# Atualizar toggles do Notion via clique (AJAX) - movimentacao

## Fluxo
Você cria os toggles **manualmente** no Notion (um para cada mês/slot que quiser
manter). Ao clicar em um botão na página, um request AJAX (POST) chama o
`NotionMovimentacoesController@atualizar`, que:

1. Lê os IDs dos toggles do `.env` (`NOTION_TOGGLE_IDS`), **na ordem em que
   devem representar os meses** — posição 0 = mês atual, posição 1 = próximo
   mês, posição 2 = mês seguinte, etc. **Suporta qualquer quantidade de
   toggles**, basta adicionar mais IDs na lista.
2. Para cada toggle, na ordem:
   - Atualiza o **título** para o nome do mês correspondente (ex: `Agosto`).
   - Remove a tabela antiga (se existir) dentro do toggle.
   - Cria uma nova tabela (sem cabeçalho) com uma linha por registro
     (`nome | valor`) e uma linha final `total`, destacada em vermelho.
3. Retorna um **JSON** com o resultado por toggle, para o front-end exibir
   feedback ao usuário.

## Limitações da API do Notion e como foram tratadas

### 1. Máximo de 100 blocos por requisição
Uma tabela com mais de ~99 linhas não cabe em uma única chamada. O controller:
- Cria a tabela já com o **primeiro lote de até 99 linhas** (99 + o próprio
  bloco da tabela = 100, dentro do limite).
- Pega o `id` da tabela recém-criada na resposta da API.
- Anexa o **restante das linhas em lotes de até 100**, via chamadas
  subsequentes em `PATCH /v1/blocks/{tabela_id}/children`.

### 2. Rate limit (~3 requisições/segundo, em média)
Todas as chamadas à API passam por um único método (`notionRequest`) que:
- Aplica um **intervalo mínimo de ~0,35s** entre requisições consecutivas.
- Se receber **HTTP 429**, espera o tempo do header `Retry-After` (ou
  backoff exponencial) e **tenta novamente automaticamente** (até 5x).
- Também refaz em caso de erro `5xx` transitório do Notion.

### 3. Chamada via AJAX / requisição HTTP síncrona
Como o processamento roda **dentro do ciclo de vida do request** (não em
fila/Job), e cada mês pode levar alguns segundos (por causa do rate limit +
paginação), fique atento a:
- **Timeout do PHP/servidor web** (`max_execution_time`, timeout do
  Nginx/Apache/PHP-FPM): com muitos meses e muitos registros, o processo
  pode demorar o suficiente para estourar o timeout padrão. Se isso
  acontecer, aumente o timeout da rota específica ou migre para
  processamento em fila (Job) com polling do status no front-end — posso
  implementar essa versão se precisar.
- O botão no exemplo já fica desabilitado durante a requisição para evitar
  cliques duplicados.

## Passos de instalação

### 1. Criar os toggles manualmente no Notion
Crie um toggle vazio para cada mês/slot que quiser manter atualizado. A
ordem deles na página não importa; o que importa é a ordem dos IDs no `.env`.

### 2. Pegar o ID de cada toggle
- Clique nos `...` do bloco toggle no Notion → **Copy link to block**.
- O ID é a parte depois do `#` no link copiado. Formate como UUID com
  hífens se necessário: `8f3b1c2d-4e5f-4a6b-9c7d-1234567890ab`

### 3. Copiar arquivos para o projeto Laravel
```bash
cp NotionMovimentacoesController.php app/Http/Controllers/
cp Movimentacao.php app/Models/
```

### 4. Configurar `.env`
```env
NOTION_TOKEN=secret_xxx...
NOTION_TOGGLE_IDS="id-mes-atual,id-proximo-mes,id-mes-seguinte"
```
> Lembre de compartilhar a página com a integração do Notion (Connections),
> senão a API retorna 404.

### 5. Adicionar config em `config/services.php`
Copie o conteúdo de `services_notion_snippet.php` para dentro do array de
`config/services.php`.

### 6. Ajustar o Model / colunas
Confirme se sua tabela `movimentacao` tem a coluna de data usada para filtrar
por mês (`data`, no exemplo). Ajuste em `Movimentacao.php` e no controller
(`whereYear`/`whereMonth`) caso o nome real seja outro.

### 7. Adicionar a rota e o botão
Veja `rota-e-ajax-exemplo.blade.php` — contém:
- A rota (`routes/web.php`)
- O botão + script fetch/AJAX
- Nota sobre a tag `<meta name="csrf-token">` necessária no layout

### 8. Testar
Clique no botão na página; o `<span id="notion-status">` mostrará a
mensagem de sucesso/erro retornada pelo controller.

## Formato da resposta JSON
```json
{
  "success": true,
  "message": "Todos os toggles foram atualizados com sucesso.",
  "toggles": [
    { "toggle_id": "abc123", "mes": "Agosto", "ano": 2026, "total_registros": 12, "status": "ok" },
    { "toggle_id": "def456", "mes": "Setembro", "ano": 2026, "total_registros": 3, "status": "ok" }
  ]
}
```
Em caso de falha parcial, `success` vem `false`, o HTTP status é `207`, e o
`status` de cada toggle indica `ok` ou `erro`.

## Observações
- O controller **não cria nem apaga toggles** — apenas atualiza título e
  tabela dos toggles cujos IDs você configurou.
- A tabela antiga é **arquivada e recriada do zero** a cada clique (não
  editada linha a linha), então edições manuais feitas direto na tabela do
  Notion serão sobrescritas na próxima atualização.
- Se quiser proteger a rota (ex: só usuários logados podem clicar), ajuste
  o middleware na definição da rota (`->middleware(['auth'])`, já incluído
  no exemplo).