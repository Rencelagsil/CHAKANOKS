<?= $this->include('shared/header') ?>

<div class="main-container">
  <button class="btn btn-primary d-md-none position-fixed top-0 start-0 m-3" style="z-index:1100" data-bs-toggle="offcanvas" data-bs-target="#sidebar"><i class="bi bi-list"></i></button>
  <div id="mobileOverlay" class="d-md-none" onclick="closeSidebar()"></div>

  <?= $this->include('shared/sidebar') ?>

  <main class="main-content">
    <div class="header">
      <div>
        <h2>Branch Inventory Management</h2>
        <p class="mb-0">Monitor branch inventory, create purchase requests, and approve intra-branch transfers</p>
        <p class="mb-0">Branch: <?= $branch['name'] ?? 'Unknown Branch' ?></p>
      </div>
      <div class="user-info">
        <div class="text-end">
          <div style="color:#ffd700;font-weight:600;"><?= $user['role'] ?? 'Branch Manager' ?></div>
          <div style="color:#ffffff;font-size:14px;"><?= $branch['name'] ?? 'Branch' ?></div>
        </div>
        <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'BM', 0, 2)) ?></div>
      </div>
    </div>

    <!-- Critical Alerts -->
    <div class="custom-card mb-4" id="alertsSection">
      <h3 class="text-warning mb-3 fs-5">⚠️ Critical Stock Alerts</h3>
      <div id="criticalAlerts">
        <!-- Dynamic alerts will be loaded here -->
      </div>
    </div>

    <!-- Quick Stats Dashboard -->
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number" id="totalProducts">0</div>
          <div class="stat-label">Total Products</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-warning" id="lowStockCount">0</div>
          <div class="stat-label">Low Stock Items</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-danger" id="criticalStockCount">0</div>
          <div class="stat-label">Critical Stock</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-success" id="totalValue">₱0</div>
          <div class="stat-label">Inventory Value</div>
        </div>
      </div>
    </div>

    

    <!-- Quick Actions -->
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="action-btn h-100" onclick="openBarcodeScanner()">
          <h5 class="mb-2">📱 Barcode Scan</h5>
          <p class="small mb-0">Quick stock updates via barcode</p>
        </div>
      </div>
      
    </div>

    <!-- Inventory Table -->
    <div class="custom-card">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-warning mb-0">Current Inventory</h3>
        <div class="d-flex gap-2">
          <button class="btn btn-outline-primary btn-sm" onclick="refreshInventory()">
            <i class="bi bi-arrow-clockwise"></i> Refresh
          </button>
          <button class="btn btn-outline-success btn-sm" onclick="exportInventory()">
            <i class="bi bi-download"></i> Export
          </button>
        </div>
      </div>

      <!-- Filters -->
      <div class="row g-3 mb-3">
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-text bg-dark text-warning border-warning">
              <i class="bi bi-search"></i>
            </span>
            <input type="text" class="form-control bg-dark text-white border-warning" 
                   id="searchInput" placeholder="Search products...">
          </div>
        </div>
        <div class="col-md-3">
          <select class="form-select bg-dark text-white border-warning" id="categoryFilter">
            <option value="">All Categories</option>
            <option value="electronics">Electronics</option>
            <option value="clothing">Clothing</option>
            <option value="food">Food & Beverages</option>
            <option value="home">Home & Garden</option>
            <option value="health">Health & Beauty</option>
          </select>
        </div>
        <div class="col-md-3">
          <select class="form-select bg-dark text-white border-warning" id="statusFilter">
            <option value="">All Status</option>
            <option value="normal">Normal Stock</option>
            <option value="low">Low Stock</option>
            <option value="critical">Critical Stock</option>
            <option value="out">Out of Stock</option>
          </select>
        </div>
        
      </div>

      <div class="table-responsive">
        <table class="table table-dark table-hover" id="inventoryTable">
          <thead>
            <tr>
              <th>Product Code</th>
              <th>Product Name</th>
              <th>Category</th>
              <th>Current Stock</th>
              <th>Min Level</th>
              <th>Max Level</th>
              <th>Unit Price</th>
              <th>Total Value</th>
              <th>Expiry Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="inventoryTableBody">
            <!-- Dynamic content will be loaded here -->
          </tbody>
        </table>
      </div>
      
      <!-- Pagination -->
      <nav aria-label="Inventory pagination" class="mt-3">
        <ul class="pagination justify-content-center" id="pagination">
          <!-- Pagination will be generated dynamically -->
        </ul>
      </nav>
    </div>
  </main>
</div>

<!-- Barcode Scanner Modal -->
<div class="modal fade" id="barcodeModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-warning">
        <h5 class="modal-title text-warning">Barcode Scanner</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <div id="barcodeReader" style="width: 100%; height: 300px; background: #333; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
          <div class="text-warning">
            <i class="bi bi-camera-video fs-1"></i>
            <p class="mt-2">Camera will appear here</p>
            <p class="small">Point camera at barcode to scan</p>
          </div>
        </div>
        <div class="mt-3">
          <input type="text" class="form-control bg-dark text-white border-warning" 
                 id="manualBarcode" placeholder="Or enter barcode manually">
          <button class="btn btn-primary mt-2" onclick="searchByBarcode()">Search Product</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Quick Stock Adjustment Modal -->
<div class="modal fade" id="quickAdjustModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-warning">
        <h5 class="modal-title text-warning">Quick Stock Adjustment</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="quickAdjustForm">
          <input type="hidden" id="adjustProductId">
          <div class="mb-3">
            <label class="form-label text-warning">Product</label>
            <input type="text" class="form-control bg-dark text-white border-warning" 
                   id="adjustProductName" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label text-warning">Current Stock</label>
            <input type="number" class="form-control bg-dark text-white border-warning" 
                   id="adjustCurrentStock" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label text-warning">Adjustment Type</label>
            <select class="form-select bg-dark text-white border-warning" id="adjustmentType" required>
              <option value="">Select Type</option>
              <option value="add">Add Stock</option>
              <option value="remove">Remove Stock</option>
              <option value="set">Set Exact Amount</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label text-warning">Quantity</label>
            <input type="number" class="form-control bg-dark text-white border-warning" 
                   id="adjustQuantity" required>
          </div>
          <div class="mb-3">
            <label class="form-label text-warning">Reason</label>
            <select class="form-select bg-dark text-white border-warning" id="adjustReason" required>
              <option value="">Select Reason</option>
              <option value="delivery">New Delivery</option>
              <option value="sale">Sale/Transfer</option>
              <option value="damage">Damaged Goods</option>
              <option value="expired">Expired Items</option>
              <option value="theft">Theft/Loss</option>
              <option value="correction">Stock Correction</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label text-warning">Notes</label>
            <textarea class="form-control bg-dark text-white border-warning" 
                      id="adjustNotes" rows="2"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer border-warning">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="saveQuickAdjustment()">Save Adjustment</button>
      </div>
    </div>
  </div>
</div>

<!-- Product Information Modal (View Only) -->
<div class="modal fade" id="productInfoModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-warning">
        <h5 class="modal-title text-warning">
          <i class="bi bi-info-circle"></i> Product Information
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <h6 class="text-warning">Product Details</h6>
            <table class="table table-dark table-sm">
              <tr>
                <td><strong>Name:</strong></td>
                <td id="viewProductName">-</td>
              </tr>
              <tr>
                <td><strong>Code:</strong></td>
                <td id="viewProductCode">-</td>
              </tr>
              <tr>
                <td><strong>Category:</strong></td>
                <td id="viewProductCategory">-</td>
              </tr>
              <tr>
                <td><strong>Unit:</strong></td>
                <td id="viewProductUnit">-</td>
              </tr>
              <tr>
                <td><strong>Price:</strong></td>
                <td id="viewProductPrice">-</td>
              </tr>
              <tr>
                <td><strong>Barcode:</strong></td>
                <td id="viewProductBarcode">-</td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <h6 class="text-warning">Stock Information</h6>
            <table class="table table-dark table-sm">
              <tr>
                <td><strong>Current Stock:</strong></td>
                <td id="viewCurrentStock">-</td>
              </tr>
              <tr>
                <td><strong>Min Stock Level:</strong></td>
                <td id="viewMinStock">-</td>
              </tr>
              <tr>
                <td><strong>Reorder Point:</strong></td>
                <td id="viewReorderPoint">-</td>
              </tr>
              <tr>
                <td><strong>Status:</strong></td>
                <td id="viewStockStatus">-</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="alert alert-info mt-3">
          <i class="bi bi-info-circle"></i>
          <strong>Note:</strong> As a Branch Manager, you can view product information but cannot edit stock levels. 
          Only Inventory Staff can make stock adjustments.
        </div>
      </div>
      <div class="modal-footer border-warning">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
// Global variables
let inventoryData = [];
let currentPage = 1;
const itemsPerPage = 15;

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
  detectBmApiBase().then(() => {
    loadInventoryData();
    loadCriticalAlerts();
  });

  // Event listeners
  document.getElementById('searchInput').addEventListener('input', filterInventory);
  document.getElementById('categoryFilter').addEventListener('change', filterInventory);
  document.getElementById('statusFilter').addEventListener('change', filterInventory);
  
  // Auto-refresh every 30 seconds
  setInterval(() => {
    loadInventoryData();
    loadCriticalAlerts();
  }, 30000);
});

async function detectBmApiBase() {
  if (window.bmApiBase) return window.bmApiBase;
  const candidates = [
    '/branchmanager',
    '/CHAKANOKS/branchmanager',
    '/CHAKANOKS/public/branchmanager'
  ];
  for (const base of candidates) {
    try {
      const res = await fetch(base + '/api/inventory-data');
      if (res.ok) {
        const json = await res.json();
        if (json && typeof json === 'object') {
          window.bmApiBase = base;
          return base;
        }
      }
    } catch (e) {}
  }
  window.bmApiBase = '/branchmanager';
  return window.bmApiBase;
}

async function loadInventoryData() {
  try {
    const response = await fetch((window.bmApiBase || '/branchmanager') + '/api/inventory-data');
    const result = await response.json();
    
    if (result.success) {
      inventoryData = result.data;
      loadInventoryTable();
      updateStats();
    } else {
      console.error('Failed to load inventory data:', result.error);
      showAlert('Failed to load inventory data', 'danger');
    }
  } catch (error) {
    console.error('Error loading inventory data:', error);
    showAlert('Error loading inventory data', 'danger');
  }
}

function loadInventoryTable() {
  const tbody = document.getElementById('inventoryTableBody');
  tbody.innerHTML = '';
  
  if (!inventoryData || inventoryData.length === 0) {
    tbody.innerHTML = '<tr><td colspan="10" class="text-center">No inventory items found</td></tr>';
    return;
  }
  
  const filteredData = getFilteredInventoryData();
  const startIndex = (currentPage - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  const pageData = filteredData.slice(startIndex, endIndex);
  
  pageData.forEach(item => {
    const statusClass = getStockStatusClass(item.current_stock, item.min_stock_level, item.max_stock_level);
    const status = getStockStatus(item.current_stock, item.min_stock_level, item.max_stock_level);
    const totalValue = (parseFloat(item.current_stock || 0) * parseFloat(item.unit_price || 0)).toLocaleString();
    const expiryDate = item.expiry_date ? formatDate(item.expiry_date) : 'N/A';
    
    const row = `
      <tr>
        <td><strong>${item.product_code || ''}</strong></td>
        <td>${item.product_name || ''}</td>
        <td>${item.category || ''}</td>
        <td>${item.current_stock != null ? item.current_stock : 0}</td>
        <td>${item.min_stock_level != null ? item.min_stock_level : 0}</td>
        <td>${item.max_stock_level != null ? item.max_stock_level : 0}</td>
        <td>₱${parseFloat(item.unit_price || 0).toLocaleString()}</td>
        <td>₱${totalValue}</td>
        <td>${expiryDate}</td>
        <td><span class="badge ${statusClass}">${status}</span></td>
      </tr>
    `;
    tbody.innerHTML += row;
  });
  
  updatePagination(filteredData.length);
}

function getFilteredInventoryData() {
  const search = document.getElementById('searchInput').value.toLowerCase();
  const category = document.getElementById('categoryFilter').value;
  const status = document.getElementById('statusFilter').value;
  
  return inventoryData.filter(item => {
    const matchesSearch = item.product_name.toLowerCase().includes(search) || 
                         item.product_code.toLowerCase().includes(search);
    const matchesCategory = !category || item.category.toLowerCase() === category;
    const stockStatus = getStockStatus(item.current_stock, item.min_stock_level, item.max_stock_level).toLowerCase();
    const matchesStatus = !status || stockStatus.includes(status);
    
    return matchesSearch && matchesCategory && matchesStatus;
  });
}

function getStockStatus(current, min, max) {
  current = parseInt(current) || 0;
  min = parseInt(min) || 0;
  max = parseInt(max) || 0;
  
  if (current === 0) {
    return 'Out of Stock';
  } else if (current <= min) {
    return 'Critical';
  } else if (current <= (min * 1.2)) {
    return 'Low Stock';
  } else if (max > 0 && current >= max) {
    return 'Overstock';
  } else {
    return 'Normal';
  }
}

function getStockStatusClass(current, min, max) {
  current = parseInt(current) || 0;
  min = parseInt(min) || 0;
  max = parseInt(max) || 0;
  
  if (current === 0) {
    return 'bg-danger';
  } else if (current <= min) {
    return 'bg-danger';
  } else if (current <= (min * 1.2)) {
    return 'bg-warning text-dark';
  } else if (max > 0 && current >= max) {
    return 'bg-info';
  } else {
    return 'bg-success';
  }
}

function updateStats() {
  const totalProducts = inventoryData.length;
  const lowStockCount = inventoryData.filter(item => 
    item.current_stock > 0 && item.current_stock <= (item.min_stock_level || 0) * 1.5).length;
  const criticalStockCount = inventoryData.filter(item => 
    item.current_stock <= (item.min_stock_level || 0)).length;
  const totalValue = inventoryData.reduce((sum, item) => 
    sum + ((item.current_stock || 0) * (item.unit_price || 0)), 0);
  
  document.getElementById('totalProducts').textContent = totalProducts;
  document.getElementById('lowStockCount').textContent = lowStockCount;
  document.getElementById('criticalStockCount').textContent = criticalStockCount;
  document.getElementById('totalValue').textContent = '₱' + totalValue.toLocaleString();
}

async function loadCriticalAlerts() {
  try {
    const response = await fetch((window.bmApiBase || '/branchmanager') + '/api/critical-alerts');
    const result = await response.json();
    
    if (result.success) {
      const alertsContainer = document.getElementById('criticalAlerts');
      if (result.data.length === 0) {
        alertsContainer.innerHTML = '<div class="alert alert-info"><strong>All Good:</strong> No critical stock alerts at this time</div>';
      } else {
        alertsContainer.innerHTML = result.data.map(alert => `
          <div class="alert alert-warning mb-2">
            <strong>Critical Stock:</strong> ${alert.product_name} - Only ${alert.current_stock} units remaining
            <div class="small text-light mt-1">Immediate action required</div>
          </div>
        `).join('');
      }
    }
  } catch (error) {
    console.error('Error loading critical alerts:', error);
  }
}

function filterInventory() {
  currentPage = 1;
  loadInventoryTable();
}

function updatePagination(totalItems) {
  const totalPages = Math.ceil(totalItems / itemsPerPage);
  const pagination = document.getElementById('pagination');
  pagination.innerHTML = '';
  
  if (totalPages <= 1) return;
  
  for (let i = 1; i <= totalPages; i++) {
    const li = document.createElement('li');
    li.className = `page-item ${i === currentPage ? 'active' : ''}`;
    li.innerHTML = `<a class="page-link bg-dark text-warning border-warning" href="#" onclick="changePage(${i})">${i}</a>`;
    pagination.appendChild(li);
  }
}

function changePage(page) {
  currentPage = page;
  loadInventoryTable();
}

function openBarcodeScanner() {
  new bootstrap.Modal(document.getElementById('barcodeModal')).show();
}

async function searchByBarcode() {
  const barcode = document.getElementById('manualBarcode').value;
  if (!barcode) return;
  
  try {
    const response = await fetch(`/CHAKANOKS/inventory/api/search-barcode/${barcode}`);
    const result = await response.json();
    
    if (result.success && result.data) {
      bootstrap.Modal.getInstance(document.getElementById('barcodeModal')).hide();
      showProductInfo(result.data);
    } else {
      showAlert('Product not found with barcode: ' + barcode, 'warning');
    }
  } catch (error) {
    console.error('Error searching barcode:', error);
    showAlert('Error searching barcode: ' + error.message, 'danger');
  }
}

function showProductInfo(product) {
  // Update the product info modal with the scanned product data
  document.getElementById('viewProductName').textContent = product.product_name;
  document.getElementById('viewProductCode').textContent = product.product_code;
  document.getElementById('viewProductCategory').textContent = product.category;
  document.getElementById('viewProductUnit').textContent = product.unit;
  document.getElementById('viewProductPrice').textContent = '₱' + product.unit_price;
  document.getElementById('viewProductBarcode').textContent = product.barcode;
  document.getElementById('viewCurrentStock').textContent = product.current_stock;
  document.getElementById('viewMinStock').textContent = product.min_stock_level;
  document.getElementById('viewReorderPoint').textContent = product.reorder_point;
  
  // Show stock status
  const stockStatus = document.getElementById('viewStockStatus');
  if (product.current_stock <= product.min_stock_level) {
    stockStatus.innerHTML = '<span class="badge bg-danger">Low Stock</span>';
  } else if (product.current_stock <= product.reorder_point) {
    stockStatus.innerHTML = '<span class="badge bg-warning">Reorder Soon</span>';
  } else {
    stockStatus.innerHTML = '<span class="badge bg-success">In Stock</span>';
  }
  
  // Show the product info modal
  new bootstrap.Modal(document.getElementById('productInfoModal')).show();
}

function quickAdjustStock(productId) {
  const item = inventoryData.find(s => s.id === productId);
  if (!item) return;
  
  document.getElementById('adjustProductId').value = item.id;
  document.getElementById('adjustProductName').value = item.product_name;
  document.getElementById('adjustCurrentStock').value = item.current_stock;
  document.getElementById('adjustmentType').value = '';
  document.getElementById('adjustQuantity').value = '';
  document.getElementById('adjustReason').value = '';
  document.getElementById('adjustNotes').value = '';
  
  new bootstrap.Modal(document.getElementById('quickAdjustModal')).show();
}

async function saveQuickAdjustment() {
  const form = document.getElementById('quickAdjustForm');
  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }
  
  const adjustmentData = {
    product_id: document.getElementById('adjustProductId').value,
    type: document.getElementById('adjustmentType').value,
    quantity: parseInt(document.getElementById('adjustQuantity').value),
    reason: document.getElementById('adjustReason').value,
    notes: document.getElementById('adjustNotes').value
  };
  
  try {
    const response = await fetch((window.bmApiBase || '/branchmanager') + '/api/adjust-stock', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(adjustmentData)
    });
    
    const result = await response.json();
    
    if (result.success) {
      await loadInventoryData();
      bootstrap.Modal.getInstance(document.getElementById('quickAdjustModal')).hide();
      form.reset();
      showAlert('Stock adjusted successfully!', 'success');
    } else {
      showAlert('Error adjusting stock: ' + (result.error || 'Unknown error'), 'danger');
    }
  } catch (error) {
    console.error('Error adjusting stock:', error);
    showAlert('Error adjusting stock: ' + error.message, 'danger');
  }
}

function createPurchaseRequest() {
  window.location.href = '/branchmanager/purchase_requests';
}

function viewTransferRequests() {
  window.location.href = '/branchmanager/transfers';
}

function generateInventoryReport() {
  const filteredData = getFilteredInventoryData();
  const csv = convertToCSV(filteredData);
  downloadCSV(csv, 'inventory_report.csv');
}

function exportInventory() {
  generateInventoryReport();
}

function refreshInventory() {
  loadInventoryData();
  loadCriticalAlerts();
  
  showAlert('Inventory data refreshed', 'success');
}

 

function viewProductDetails(productId) {
  const item = inventoryData.find(s => s.id === productId);
  if (!item) return;
  
  // In a real implementation, this would open a detailed product view modal
  showAlert(`Product: ${item.product_name}\nStock: ${item.current_stock}\nPrice: ₱${item.unit_price}`, 'info');
}

function convertToCSV(data) {
  const headers = ['Product Code', 'Product Name', 'Category', 'Current Stock', 'Min Level', 'Max Level', 'Unit Price', 'Total Value', 'Expiry Date', 'Status'];
  const rows = data.map(item => [
    item.product_code,
    item.product_name,
    item.category,
    item.current_stock,
    item.min_stock_level,
    item.max_stock_level,
    item.unit_price,
    item.current_stock * item.unit_price,
    item.expiry_date || 'N/A',
    getStockStatus(item.current_stock, item.min_stock_level, item.max_stock_level)
  ]);
  
  return [headers, ...rows].map(row => row.join(',')).join('\n');
}

function downloadCSV(csv, filename) {
  const blob = new Blob([csv], { type: 'text/csv' });
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.setAttribute('hidden', '');
  a.setAttribute('href', url);
  a.setAttribute('download', filename);
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
}

function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
}

function showAlert(message, type) {
  const alertDiv = document.createElement('div');
  alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
  alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
  alertDiv.innerHTML = `
    ${message}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  `;
  document.body.appendChild(alertDiv);
  
  setTimeout(() => {
    if (alertDiv.parentNode) {
      alertDiv.parentNode.removeChild(alertDiv);
    }
  }, 5000);
}

// Reset form when modal is closed
document.getElementById('quickAdjustModal').addEventListener('hidden.bs.modal', function () {
  document.getElementById('quickAdjustForm').reset();
});
</script>

<?= $this->include('shared/footer') ?>


