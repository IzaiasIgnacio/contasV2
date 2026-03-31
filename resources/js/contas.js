document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('movimentacaoForm').reset();
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
    const currentDateSpan = document.getElementById('currentDate');
    
    const months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 
                  'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    
    const selectedMonth = months[monthSelect.value - 1];
    const selectedYear = yearInput.value;
    
    currentDateSpan.textContent = `${selectedMonth} ${selectedYear}`;
    closeDateModal();
}

// Lógica do Menu de Contexto
const statusContextMenu = document.getElementById('statusContextMenu');

// Function to show the context menu
function showContextMenu(x, y) {
    statusContextMenu.style.left = `${x}px`;
    statusContextMenu.style.top = `${y}px`;
    statusContextMenu.classList.remove('hidden');
}

// Function to hide the context menu
function hideContextMenu() {
    statusContextMenu.classList.add('hidden');
    currentMovimentacaoId = null;
    currentMovimentacaoElement = null;
    currentMovimentacaoType = null;
}

// Event listener for right-click on movimentacao lines
document.addEventListener('contextmenu', function(event) {
    const target = event.target.closest('.linha_movimentacao');
    if (target) {
        event.preventDefault(); // Prevent default browser context menu
        currentMovimentacaoId = target.dataset.movimentacaoId;
        currentMovimentacaoElement = target;
        currentMovimentacaoType = target.dataset.movimentacaoType;

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
    if (!statusContextMenu.contains(event.target)) {
        hideContextMenu();
    }
});

// Fechar modais ao clicar fora
document.getElementById('transactionModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

document.getElementById('bankModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeBankModal();
    }
});

document.getElementById('dateModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDateModal();
    }
});

// Oculta o menu ao rolar a tela principal, para evitar que o menu fique "flutuando"
const mainContent = document.querySelector('main');
if (mainContent) {
    mainContent.addEventListener('scroll', () => statusContextMenu.classList.add('hidden'));
}
