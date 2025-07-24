// Orders data
const orders = [
    {
        id: "#3210",
        customer: "John Doe",
        email: "john@example.com",
        products: ["Conta LoL", "Boost Diamante"],
        items: 2,
        date: "2024-01-15",
        total: 199.99,
        status: "completo",
        payment: "pago"
    },
    {
        id: "#3209",
        customer: "Jane Smith",
        email: "jane@example.com", 
        products: ["Smurf Valorant", "Unlock All Agents"],
        items: 2,
        date: "2024-01-15",
        total: 299.99,
        status: "processando",
        payment: "pago"
    },
    {
        id: "#3208",
        customer: "Bob Johnson",
        email: "bob@example.com",
        products: ["Key Steam"],
        items: 1,
        date: "2024-01-14",
        total: 19.99,
        status: "completo",
        payment: "pago"
    },
    {
        id: "#3207",
        customer: "Alice Brown",
        email: "alice@example.com",
        products: ["Key EPIC", "Game Pass"],
        items: 2,
        date: "2024-01-14",
        total: 59.99,
        status: "pendente",
        payment: "pendente"
    },
    {
        id: "#3206",
        customer: "Charlie Wilson",
        email: "charlie@example.com",
        products: ["Tinder Plus"],
        items: 1,
        date: "2024-01-13",
        total: 49.99,
        status: "completo",
        payment: "pago"
    },
    {
        id: "#3205",
        customer: "Diana Prince",
        email: "diana@example.com",
        products: ["Netflix Premium", "Spotify Premium"],
        items: 2,
        date: "2024-01-13",
        total: 89.99,
        status: "processando",
        payment: "pago"
    },
    {
        id: "#3204",
        customer: "Bruce Wayne",
        email: "bruce@example.com",
        products: ["Discord Nitro"],
        items: 1,
        date: "2024-01-12",
        total: 29.99,
        status: "completo",
        payment: "pago"
    },
    {
        id: "#3203",
        customer: "Clark Kent",
        email: "clark@example.com",
        products: ["Steam Wallet", "Key Cyberpunk"],
        items: 2,
        date: "2024-01-12",
        total: 149.99,
        status: "pendente",
        payment: "pendente"
    },
    {
        id: "#3202",
        customer: "Tony Stark",
        email: "tony@example.com",
        products: ["Xbox Game Pass"],
        items: 1,
        date: "2024-01-11",
        total: 39.99,
        status: "completo",
        payment: "pago"
    },
    {
        id: "#3201",
        customer: "Steve Rogers",
        email: "steve@example.com",
        products: ["YouTube Premium", "Apple Music"],
        items: 2,
        date: "2024-01-11",
        total: 79.99,
        status: "cancelado",
        payment: "reembolsado"
    }
];

let filteredOrders = [...orders];
let selectedOrders = [];

// Status mappings
const statusMap = {
    pendente: { class: "badge bg-warning text-dark", text: "Pendente", icon: "clock" },
    processando: { class: "badge bg-primary", text: "Processando", icon: "arrow-repeat" },
    completo: { class: "badge bg-success", text: "Completo", icon: "check-circle" },
    cancelado: { class: "badge bg-danger", text: "Cancelado", icon: "x-circle" }
};

// Payment mappings
const paymentMap = {
    pago: { class: "badge bg-success", text: "Pago", icon: "check-circle" },
    pendente: { class: "badge bg-warning text-dark", text: "Pendente", icon: "clock" },
    reembolsado: { class: "badge bg-info", text: "Reembolsado", icon: "arrow-counterclockwise" },
    falhado: { class: "badge bg-danger", text: "Falhado", icon: "x-circle" }
};

// Render orders table
function renderOrdersTable() {
    const tbody = document.getElementById('ordersTable');
    if (!tbody) return;

    tbody.innerHTML = filteredOrders.map(order => {
        const statusInfo = statusMap[order.status];
        const paymentInfo = paymentMap[order.payment];
        const date = new Date(order.date).toLocaleDateString('pt-BR');
        
        return `
            <tr>
                <td>
                    <input type="checkbox" class="form-check-input order-checkbox" value="${order.id}" 
                           ${selectedOrders.includes(order.id) ? 'checked' : ''}>
                </td>
                <td>
                    <div>
                        <div class="fw-medium">${order.id}</div>
                        <div class="small text-muted">${order.items} item${order.items > 1 ? 's' : ''}</div>
                    </div>
                </td>
                <td>
                    <div>
                        <div class="fw-medium">${order.customer}</div>
                        <div class="small text-muted">${order.email}</div>
                    </div>
                </td>
                <td>
                    <div class="small">
                        ${order.products.slice(0, 2).map(product => `<div>${product}</div>`).join('')}
                        ${order.products.length > 2 ? `<div class="text-muted">+${order.products.length - 2} mais</div>` : ''}
                    </div>
                </td>
                <td>
                    <div class="small">${date}</div>
                </td>
                <td class="fw-medium">R$${order.total.toFixed(2)}</td>
                <td>
                    <span class="${statusInfo.class}">
                        <i class="bi bi-${statusInfo.icon} me-1"></i>
                        ${statusInfo.text}
                    </span>
                </td>
                <td>
                    <span class="${paymentInfo.class}">
                        <i class="bi bi-${paymentInfo.icon} me-1"></i>
                        ${paymentInfo.text}
                    </span>
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>Visualizar</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-truck me-2"></i>Rastrear</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-x-circle me-2"></i>Cancelar</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        `;
    }).join('');

    updateBulkActions();
}

// Filter orders
function filterOrders() {
    const searchTerm = document.getElementById('orderSearch')?.value.toLowerCase() || '';
    const statusFilter = document.getElementById('statusFilter')?.value || '';
    const periodFilter = document.getElementById('periodFilter')?.value || '';

    filteredOrders = orders.filter(order => {
        const matchesSearch = order.id.toLowerCase().includes(searchTerm) ||
                             order.customer.toLowerCase().includes(searchTerm) ||
                             order.email.toLowerCase().includes(searchTerm);
        const matchesStatus = !statusFilter || order.status === statusFilter;
        const matchesPeriod = !periodFilter || matchesPeriodFilter(order.date, periodFilter);
        
        return matchesSearch && matchesStatus && matchesPeriod;
    });

    renderOrdersTable();
    updateOrderCount();
}

// Check if order matches period filter
function matchesPeriodFilter(orderDate, period) {
    const today = new Date();
    const orderDateObj = new Date(orderDate);
    
    switch(period) {
        case 'hoje':
            return orderDateObj.toDateString() === today.toDateString();
        case 'semana':
            const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
            return orderDateObj >= weekAgo;
        case 'mes':
            return orderDateObj.getMonth() === today.getMonth() && 
                   orderDateObj.getFullYear() === today.getFullYear();
        case 'trimestre':
            const quarterMonths = [
                [0, 1, 2], [3, 4, 5], [6, 7, 8], [9, 10, 11]
            ];
            const currentQuarter = quarterMonths.find(quarter => 
                quarter.includes(today.getMonth())
            );
            return currentQuarter && currentQuarter.includes(orderDateObj.getMonth()) &&
                   orderDateObj.getFullYear() === today.getFullYear();
        default:
            return true;
    }
}

// Update order count
function updateOrderCount() {
    const countElement = document.querySelector('.table-header p');
    if (countElement) {
        countElement.textContent = `${filteredOrders.length} de ${orders.length} pedidos`;
    }
}

// Handle checkbox selection
function setupCheckboxes() {
    const selectAllCheckbox = document.getElementById('selectAll');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.order-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                if (this.checked) {
                    if (!selectedOrders.includes(checkbox.value)) {
                        selectedOrders.push(checkbox.value);
                    }
                } else {
                    selectedOrders = [];
                }
            });
            updateBulkActions();
        });
    }

    // Handle individual checkbox changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('order-checkbox')) {
            const orderId = e.target.value;
            if (e.target.checked) {
                if (!selectedOrders.includes(orderId)) {
                    selectedOrders.push(orderId);
                }
            } else {
                selectedOrders = selectedOrders.filter(id => id !== orderId);
            }
            
            // Update select all checkbox
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.order-checkbox');
            if (selectAll) {
                selectAll.checked = selectedOrders.length === checkboxes.length;
                selectAll.indeterminate = selectedOrders.length > 0 && selectedOrders.length < checkboxes.length;
            }
            
            updateBulkActions();
        }
    });
}

// Update bulk actions visibility
function updateBulkActions() {
    const bulkActions = document.getElementById('bulkActions');
    if (bulkActions) {
        if (selectedOrders.length > 0) {
            bulkActions.style.display = 'flex';
            bulkActions.querySelector('span').textContent = `${selectedOrders.length} selecionados`;
        } else {
            bulkActions.style.display = 'none';
        }
    }
}

// Setup search functionality
function setupSearch() {
    const searchInput = document.getElementById('orderSearch');
    if (searchInput) {
        searchInput.addEventListener('input', filterOrders);
    }
}

// Setup filters
function setupFilters() {
    const statusFilter = document.getElementById('statusFilter');
    const periodFilter = document.getElementById('periodFilter');
    
    if (statusFilter) {
        statusFilter.addEventListener('change', filterOrders);
    }
    
    if (periodFilter) {
        periodFilter.addEventListener('change', filterOrders);
    }
}

// Initialize orders page
function initOrdersPage() {
    renderOrdersTable();
    setupCheckboxes();
    setupSearch();
    setupFilters();
    updateOrderCount();
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Only initialize if we're on the orders page
    if (document.getElementById('ordersTable')) {
        initOrdersPage();
    }
});
