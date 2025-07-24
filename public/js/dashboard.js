/**
 * Função para alternar a visibilidade da sidebar em dispositivos móveis.
 */
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
}

/**
 * Define o link de navegação ativo na sidebar com base na URL atual.
 */
function setActiveNavigation() {
    const currentPage = window.location.pathname; // Pega o caminho completo (ex: /admin/products)
    const navLinks = document.querySelectorAll('.sidebar-nav .nav-link');
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        // Verifica se o href do link está contido no início da URL da página atual
        if (currentPage.startsWith(link.getAttribute('href'))) {
            link.classList.add('active');
        }
    });
}

/**
 * Inicializa o gráfico de vendas (linha) se o canvas e os dados existirem.
 * @param {object} salesData - Dados para o gráfico (labels e valores).
 */
function initSalesChart(salesData) {
    const ctx = document.getElementById('salesChart');
    if (!ctx || !salesData) return;
    
    new Chart(ctx.getContext('2d'), {
        type: 'line',
        data: {
            labels: Object.keys(salesData),
            datasets: [{
                label: 'Receita',
                data: Object.values(salesData),
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
}

/**
 * Inicializa o gráfico de categorias (doughnut) se o canvas e os dados existirem.
 * @param {array} categoryData - Dados para o gráfico (nomes e valores).
 */
function initCategoryChart(categoryData) {
    const ctx = document.getElementById('categoryChart');
    if (!ctx || !categoryData) return;

    new Chart(ctx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: categoryData.map(c => c.name),
            datasets: [{
                data: categoryData.map(c => c.category_revenue),
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#6366f1'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } } }
        }
    });
}


// Função principal que é executada quando a página carrega
document.addEventListener('DOMContentLoaded', function() {
    setActiveNavigation();
    
    // Ouve o clique no botão de menu móvel, se existir
    const mobileToggle = document.querySelector('.mobile-toggle');
    if (mobileToggle) {
        mobileToggle.addEventListener('click', toggleSidebar);
    }
});