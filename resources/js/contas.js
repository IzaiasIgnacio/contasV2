document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('movimentacaoForm').reset();

    // Inicializar variáveis globais e event listeners
    window.currentMovimentacaoId = null;
    window.currentMovimentacaoElement = null;
    window.currentMovimentacaoType = null;

    // Inicializar menu de contexto
    const statusContextMenu = document.getElementById('statusContextMenu');

    // Event listener for right-click on movimentacao lines
    document.addEventListener('contextmenu', function(event) {
        const target = event.target.closest('.linha_movimentacao');
        if (target) {
            event.preventDefault(); // Prevent default browser context menu
            window.currentMovimentacaoId = String(target.getAttribute('data-movimentacao-id'));
            window.currentMovimentacaoElement = target;
            window.currentMovimentacaoType = String(target.getAttribute('data-movimentacao-type'));

            // Adjust menu position to stay within viewport
            let x = event.clientX;
            let y = event.clientY;
            const menuWidth = statusContextMenu.offsetWidth;
            const menuHeight = statusContextMenu.offsetHeight;

            if (x + menuWidth > window.innerWidth) {
                x = window.innerWidth - menuWidth - 5; // 5px padding from edge
            }
            if (y + menuHeight > window.innerHeight) {
                y = window.innerHeight - menuHeight - 5; // 5px padding from edge
            }

            showContextMenu(x, y);
        } else {
            hideContextMenu(); // Hide if right-clicked elsewhere
        }
    });

    // Event listener for clicks outside the context menu to hide it
    document.addEventListener('click', function(event) {
        if (statusContextMenu && !statusContextMenu.contains(event.target)) {
            hideContextMenu();
        }
    });

    // Fechar modais ao clicar fora
    const transactionModal = document.getElementById('transactionModal');
    if (transactionModal) {
        transactionModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    }

    const bankModal = document.getElementById('bankModal');
    if (bankModal) {
        bankModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeBankModal();
            }
        });
    }

    const dateModal = document.getElementById('dateModal');
    if (dateModal) {
        dateModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDateModal();
            }
        });
    }

    const editModal = document.getElementById('editModal');
    if (editModal) {
        editModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    }

    // Oculta o menu ao rolar a tela principal
    const mainContent = document.querySelector('main');
    if (mainContent && statusContextMenu) {
        mainContent.addEventListener('scroll', () => statusContextMenu.classList.add('hidden'));
    }
});

function openModal(mes, ano) {
    const hoje = new Date();
    const dia = String(hoje.getDate()).padStart(2, '0');
    let mesFormatado = mes;
    // Mapa de meses para converter nomes em números
    const mapMeses = {'Janeiro': '01', 'Fevereiro': '02', 'Março': '03', 'Abril': '04', 'Maio': '05', 'Junho': '06', 'Julho': '07', 'Agosto': '08', 'Setembro': '09', 'Outubro': '10', 'Novembro': '11', 'Dezembro': '12'};
    
    if (isNaN(mes)) {
        mesFormatado = mapMeses[mes] || '01';
    } else {
        mesFormatado = String(mes).padStart(2, '0');
    }
    document.querySelector('input[name="data"]').value = `${dia}/${mesFormatado}/${ano}`;
    document.getElementById('transactionModal').classList.remove('hidden');
    document.querySelector('input[name="nome"]').focus();
}

function closeModal() {
    document.getElementById('transactionModal').classList.add('hidden');
}

function openBankModal() {
    document.getElementById('bankModal').classList.remove('hidden');
    document.getElementById('bankModal').classList.add('flex');
}

function closeBankModal() {
    document.getElementById('bankModal').classList.add('hidden');
    document.getElementById('bankModal').classList.remove('flex');
}

function toggleTerceiros() {
    const tipoSelect = document.getElementById('tipoSelect');
    const terceirosField = document.getElementById('terceirosField');
    
    if (tipoSelect.value === 'terceiros') {
        terceirosField.classList.remove('hidden');
    } else {
        terceirosField.classList.add('hidden');
    }
}

function openDateModal() {
    document.getElementById('dateModal').classList.remove('hidden');
}

function closeDateModal() {
    document.getElementById('dateModal').classList.add('hidden');
}

function updateDate() {
    const monthSelect = document.getElementById('monthSelect');
    const yearInput = document.getElementById('yearInput');
    
    const selectedMonth = monthSelect.value;
    const selectedYear = yearInput.value;
    
    // Send AJAX request to update the database
    fetch('/update-mes-atual', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            mes: selectedMonth,
            ano: selectedYear
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload the page to reflect the changes
            location.reload();
        } else {
            alert('Erro ao atualizar o mês atual.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erro ao atualizar o mês atual.');
    });
}

// Lógica do Menu de Contexto

// Function to show the context menu
function showContextMenu(x, y) {
    const statusContextMenu = document.getElementById('statusContextMenu');
    if (statusContextMenu) {
        statusContextMenu.style.left = `${x}px`;
        statusContextMenu.style.top = `${y}px`;
        statusContextMenu.classList.remove('hidden');
    }
}

// Function to hide the context menu
function hideContextMenu() {
    const statusContextMenu = document.getElementById('statusContextMenu');
    if (statusContextMenu) {
        statusContextMenu.classList.add('hidden');
    }
    window.currentMovimentacaoId = null;
    window.currentMovimentacaoElement = null;
    window.currentMovimentacaoType = null;
}

function setStatus(status) {
    if (!window.currentMovimentacaoId || window.currentMovimentacaoId === 'null' || window.currentMovimentacaoId === '') {
        console.error('Invalid movimentacao ID:', window.currentMovimentacaoId);
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!token) {
        console.error('CSRF token not found');
        return;
    }

    // Construir URL para localhost (sempre com index.php)
    const baseUrl = window.location.origin;
    const url = `${baseUrl}/index.php/movimentacao/${window.currentMovimentacaoId}/status`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status })
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error('Falha ao atualizar status');
        }
        return response.json();
    })
    .then((data) => {
        if (data.success) {
            // recarregar para recalcular e atualizar visual
            location.reload();
        } else {
            alert('Erro: ' + (data.error || 'Não foi possível atualizar o status.'));
        }
    })
    .catch((error) => {
        console.error(error);
        alert('Erro ao atualizar status da movimentação. Tente novamente.');
    })
    .finally(() => {
        hideContextMenu();
    });
}

function setCartao(cartaoId) {
    if (!window.currentMovimentacaoId || window.currentMovimentacaoId === 'null' || window.currentMovimentacaoId === '') {
        console.error('Invalid movimentacao ID:', window.currentMovimentacaoId);
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!token) {
        console.error('CSRF token not found');
        return;
    }

    // Construir URL para localhost (sempre com index.php)
    const baseUrl = window.location.origin;
    const url = `${baseUrl}/index.php/movimentacao/${window.currentMovimentacaoId}/cartao`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ cartao_id: cartaoId })
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error('Falha ao atualizar cartão');
        }
        return response.json();
    })
    .then((data) => {
        if (data.success) {
            // recarregar para recalcular e atualizar visual
            location.reload();
        } else {
            alert('Erro: ' + (data.error || 'Não foi possível atualizar o cartão.'));
        }
    })
    .catch((error) => {
        console.error(error);
        alert('Erro ao atualizar cartão da movimentação. Tente novamente.');
    })
    .finally(() => {
        hideContextMenu();
    });
}

function setItau() {
    if (!window.currentMovimentacaoId || window.currentMovimentacaoId === 'null' || window.currentMovimentacaoId === '') {
        console.error('Invalid movimentacao ID:', window.currentMovimentacaoId);
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!token) {
        console.error('CSRF token not found');
        return;
    }

    const baseUrl = window.location.origin;
    const url = `${baseUrl}/index.php/movimentacao/${window.currentMovimentacaoId}/itau`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error('Falha ao atualizar itau');
        }
        return response.json();
    })
    .then((data) => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro: ' + (data.error || 'Não foi possível atualizar itau.'));
        }
    })
    .catch((error) => {
        console.error(error);
        alert('Erro ao atualizar itau da movimentação. Tente novamente.');
    })
    .finally(() => {
        hideContextMenu();
    });
}

function setNb() {
    if (!window.currentMovimentacaoId || window.currentMovimentacaoId === 'null' || window.currentMovimentacaoId === '') {
        console.error('Invalid movimentacao ID:', window.currentMovimentacaoId);
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!token) {
        console.error('CSRF token not found');
        return;
    }

    const baseUrl = window.location.origin;
    const url = `${baseUrl}/index.php/movimentacao/${window.currentMovimentacaoId}/nb`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error('Falha ao atualizar nb');
        }
        return response.json();
    })
    .then((data) => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro: ' + (data.error || 'Não foi possível atualizar nb.'));
        }
    })
    .catch((error) => {
        console.error(error);
        alert('Erro ao atualizar nb da movimentação. Tente novamente.');
    })
    .finally(() => {
        hideContextMenu();
    });
}

function deleteMovimentacao() {
    if (!window.currentMovimentacaoId || window.currentMovimentacaoId === 'null' || window.currentMovimentacaoId === '') {
        console.error('Invalid movimentacao ID:', window.currentMovimentacaoId);
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!token) {
        console.error('CSRF token not found');
        return;
    }

    // Construir URL para localhost (sempre com index.php)
    const baseUrl = window.location.origin;
    const url = `${baseUrl}/index.php/movimentacao/${window.currentMovimentacaoId}`;

    fetch(url, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error('Falha ao excluir movimentação');
        }
        return response.json();
    })
    .then((data) => {
        if (data.success) {
            // recarregar para atualizar a visualização
            location.reload();
        } else {
            alert('Erro: ' + (data.error || 'Não foi possível excluir a movimentação.'));
        }
    })
    .catch((error) => {
        console.error(error);
        alert('Erro ao excluir a movimentação. Tente novamente.');
    })
    .finally(() => {
        hideContextMenu();
    });
}

function exportarDados() {
    const btn = document.getElementById('btnExportar');
    const icon = document.getElementById('iconExportar');
    const spinner = document.getElementById('spinnerExportar');
    
    if (btn) btn.disabled = true;
    if (icon) icon.classList.add('hidden');
    if (spinner) spinner.classList.remove('hidden');

    const baseUrl = window.location.origin;
    const url = `${baseUrl}/index.php/exportar`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na resposta: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                alert('Erro: ' + (data.error || 'Erro desconhecido'));
            }
        })
        .catch(error => {
            console.error('Erro ao exportar:', error);
            alert('Erro ao exportar dados.');
        })
        .finally(() => {
            if (btn) btn.disabled = false;
            if (icon) icon.classList.remove('hidden');
            if (spinner) spinner.classList.add('hidden');
        });
}

function salvarContas() {
    const btn = document.getElementById('btnSalvarContas');
    const spinner = document.getElementById('spinnerSalvarContas');
    
    if (btn) btn.disabled = true;
    if (spinner) spinner.classList.remove('hidden');

    const inputs = document.querySelectorAll('#contasInputsContainer input[data-nome]');
    const contas = {};
    inputs.forEach(input => {
        // Remove espaços em branco e troca vírgula por ponto, mantendo como string para preservar o . e os zeros
        let val = input.value.trim().replace(',', '.');
        contas[input.getAttribute('data-nome')] = val || '0.00';
    });

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const baseUrl = window.location.origin;
    const url = `${baseUrl}/index.php/contas/salvar`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ contas })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Falha ao salvar contas');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro: ' + (data.error || 'Não foi possível salvar as contas.'));
        }
    })
    .catch(error => {
        console.error(error);
        alert('Erro ao salvar as contas. Tente novamente.');
    })
    .finally(() => {
        if (btn) btn.disabled = false;
        if (spinner) spinner.classList.add('hidden');
    });
}

function openEditModal() {
    if (!window.currentMovimentacaoElement) {
        alert('Selecione uma movimentação primeiro.');
        return;
    }
    
    const id = window.currentMovimentacaoId;
    const nome = window.currentMovimentacaoElement.getAttribute('data-movimentacao-nome') || '';
    const valor = window.currentMovimentacaoElement.getAttribute('data-movimentacao-valor') || '';
    const descricao = window.currentMovimentacaoElement.getAttribute('data-movimentacao-descricao') || '';

    // Hide context menu first
    hideContextMenu();

    document.getElementById('formEditMovimentacao').dataset.movimentacaoId = id;
    document.getElementById('editNome').value = nome;
    document.getElementById('editValor').value = valor;
    document.getElementById('editDescricao').value = descricao;

    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}

function salvarEdicao() {
    const id = document.getElementById('formEditMovimentacao').dataset.movimentacaoId;
    if (!id) {
        alert('ID da movimentação não encontrado.');
        return;
    }

    const btn = document.getElementById('btnSalvarEdicao');
    const spinner = document.getElementById('spinnerSalvarEdicao');
    
    if (btn) btn.disabled = true;
    if (spinner) spinner.classList.remove('hidden');

    const nome = document.getElementById('editNome').value.trim();
    let valor = document.getElementById('editValor').value.trim();
    const descricao = document.getElementById('editDescricao').value.trim();
    
    if (valor.includes(',')) {
        valor = valor.replace(/\./g, '').replace(',', '.');
    }

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const baseUrl = window.location.origin;
    const url = `${baseUrl}/index.php/movimentacao/${id}/editar`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ nome, valor, descricao })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Falha ao salvar edição');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erro: ' + (data.error || 'Não foi possível salvar as alterações.'));
        }
    })
    .catch(error => {
        console.error(error);
        alert('Erro ao salvar as alterações. Tente novamente.');
    })
    .finally(() => {
        if (btn) btn.disabled = false;
        if (spinner) spinner.classList.add('hidden');
        closeEditModal();
    });
}
