// Products data
const products = [
    {
        id: "1",
        name: "Wireless Bluetooth Headphones",
        sku: "WBH-001",
        category: "eletronicos",
        price: 99.99,
        stock: 45,
        status: "ativo",
        sales: 234,
        rating: 4.5,
    },
    {
        id: "2",
        name: "Smart Fitness Watch",
        sku: "SFW-002",
        category: "eletronicos",
        price: 199.99,
        stock: 12,
        status: "ativo",
        sales: 156,
        rating: 4.8,
    },
    {
        id: "3",
        name: "Organic Cotton T-Shirt",
        sku: "OCT-003",
        category: "roupas",
        price: 29.99,
        stock: 0,
        status: "sem_estoque",
        sales: 89,
        rating: 4.2,
    },
    {
        id: "4",
        name: "Ergonomic Laptop Stand",
        sku: "ELS-004",
        category: "acessorios",
        price: 49.99,
        stock: 78,
        status: "ativo",
        sales: 67,
        rating: 4.3,
    },
    {
        id: "5",
        name: "Premium Coffee Beans",
        sku: "PCB-005",
        category: "comida",
        price: 24.99,
        stock: 156,
        status: "ativo",
        sales: 445,
        rating: 4.7,
    },
    {
        id: "6",
        name: "Wireless Phone Charger",
        sku: "WPC-006",
        category: "eletronicos",
        price: 39.99,
        stock: 3,
        status: "estoque_baixo",
        sales: 178,
        rating: 4.1,
    },
];

let filteredProducts = [...products];
let selectedProducts = [];

// Category mappings
const categoryMap = {
    eletronicos: "Eletrônicos",
    roupas: "Roupas", 
    acessorios: "Acessórios",
    comida: "Comida & Bebida"
};

// Status mappings
const statusMap = {
    ativo: { class: "badge bg-success", text: "Ativo", icon: "check-circle" },
    sem_estoque: { class: "badge bg-danger", text: "Sem Estoque", icon: "exclamation-triangle" },
    estoque_baixo: { class: "badge bg-warning text-dark", text: "Estoque Baixo", icon: "clock" }
};

// Render products table
function renderProductsTable() {
    const tbody = document.getElementById('productsTable');
    if (!tbody) return;

    tbody.innerHTML = filteredProducts.map(product => {
        const status = getProductStatus(product);
        const statusInfo = statusMap[status];
        
        return `
            <tr>
                <td>
                    <input type="checkbox" class="form-check-input product-checkbox" value="${product.id}" 
                           ${selectedProducts.includes(product.id) ? 'checked' : ''}>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="product-icon me-3">
                            <i class="bi bi-box"></i>
                        </div>
                        <div>
                            <div class="fw-medium">${product.name}</div>
                            <div class="small text-muted">
                                ${'★'.repeat(Math.floor(product.rating))} ${product.rating}
                            </div>
                        </div>
                    </div>
                </td>
                <td><code class="small">${product.sku}</code></td>
                <td>${categoryMap[product.category]}</td>
                <td class="fw-medium">R$${product.price.toFixed(2)}</td>
                <td>
                    <span class="${product.stock < 10 ? 'text-warning fw-medium' : ''}">${product.stock}</span>
                </td>
                <td>
                    <span class="${statusInfo.class}">
                        <i class="bi bi-${statusInfo.icon} me-1"></i>
                        ${statusInfo.text}
                    </span>
                </td>
                <td>${product.sales}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>Visualizar</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Excluir</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        `;
    }).join('');

    updateBulkActions();
}

// Get product status based on stock
function getProductStatus(product) {
    if (product.stock === 0) return "sem_estoque";
    if (product.stock < 10) return "estoque_baixo";
    return "ativo";
}

// Filter products
function filterProducts() {
    const searchTerm = document.getElementById('productSearch')?.value.toLowerCase() || '';
    const categoryFilter = document.getElementById('categoryFilter')?.value || '';
    const statusFilter = document.getElementById('statusFilter')?.value || '';

    filteredProducts = products.filter(product => {
        const matchesSearch = product.name.toLowerCase().includes(searchTerm) ||
                             product.sku.toLowerCase().includes(searchTerm);
        const matchesCategory = !categoryFilter || product.category === categoryFilter;
        const matchesStatus = !statusFilter || getProductStatus(product) === statusFilter;
        
        return matchesSearch && matchesCategory && matchesStatus;
    });

    renderProductsTable();
    updateProductCount();
}

// Update product count
function updateProductCount() {
    const countElement = document.querySelector('.table-header p');
    if (countElement) {
        countElement.textContent = `${filteredProducts.length} de ${products.length} produtos`;
    }
}

// Handle checkbox selection
function setupCheckboxes() {
    const selectAllCheckbox = document.getElementById('selectAll');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                if (this.checked) {
                    if (!selectedProducts.includes(checkbox.value)) {
                        selectedProducts.push(checkbox.value);
                    }
                } else {
                    selectedProducts = [];
                }
            });
            updateBulkActions();
        });
    }

    // Handle individual checkbox changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-checkbox')) {
            const productId = e.target.value;
            if (e.target.checked) {
                if (!selectedProducts.includes(productId)) {
                    selectedProducts.push(productId);
                }
            } else {
                selectedProducts = selectedProducts.filter(id => id !== productId);
            }
            
            // Update select all checkbox
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.product-checkbox');
            if (selectAll) {
                selectAll.checked = selectedProducts.length === checkboxes.length;
                selectAll.indeterminate = selectedProducts.length > 0 && selectedProducts.length < checkboxes.length;
            }
            
            updateBulkActions();
        }
    });
}

// Update bulk actions visibility
function updateBulkActions() {
    const bulkActions = document.getElementById('bulkActions');
    if (bulkActions) {
        if (selectedProducts.length > 0) {
            bulkActions.style.display = 'flex';
            bulkActions.querySelector('span').textContent = `${selectedProducts.length} selecionados`;
        } else {
            bulkActions.style.display = 'none';
        }
    }
}

// Setup search functionality
function setupSearch() {
    const searchInput = document.getElementById('productSearch');
    if (searchInput) {
        searchInput.addEventListener('input', filterProducts);
    }
}

// Setup filters
function setupFilters() {
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');
    
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterProducts);
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', filterProducts);
    }
}

// Initialize products page
function initProductsPage() {
    renderProductsTable();
    setupCheckboxes();
    setupSearch();
    setupFilters();
    updateProductCount();
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Only initialize if we're on the products page
    if (document.getElementById('productsTable')) {
        initProductsPage();
    }
});
