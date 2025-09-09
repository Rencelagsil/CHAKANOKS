<?= $this->include('shared/header') ?>

<div class="main-container">
  <button class="btn btn-primary d-md-none position-fixed top-0 start-0 m-3" style="z-index:1100" data-bs-toggle="offcanvas" data-bs-target="#sidebar"><i class="bi bi-list"></i></button>
  <div id="mobileOverlay" class="d-md-none" onclick="closeSidebar()"></div>

}
  <?= $this->include('shared/sidebar') ?>

  <main class="main-content">
    <div class="header">
      <div>
        <h2>Stock Levels</h2>
        <p class="mb-0">Real-time inventory management and stock updates</p>
      </div>
      <div>
        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addStockModal">
          <i class="bi bi-plus-circle"></i> Add Stock
        </button>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#barcodeModal">
          <i class="bi bi-upc-scan"></i> Barcode Scan
        </button>
      </div>
    </div>

    <!-- Quick Stats -->
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
          <div class="stat-label">Total Inventory Value</div>
        </div>
      </div>
    </div>

    <!-- Filters and Search -->
    <div class="custom-card mb-4">
      <div class="row g-3">
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
        <div class="col-md-2">
          <button class="btn btn-outline-primary w-100" onclick="exportStock()">
            <i class="bi bi-download"></i> Export
          </button>
        </div>
      </div>
    </div>

    <!-- Stock Table -->
    <div class="custom-card">
      <div class="table-responsive">
        <table class="table table-dark table-hover" id="stockTable">
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
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="stockTableBody">
            <!-- Dynamic content will be loaded here -->
          </tbody>
        </table>
      </div>
      
      <!-- Pagination -->
      <nav aria-label="Stock pagination" class="mt-3">
        <ul class="pagination justify-content-center" id="pagination">
          <!-- Pagination will be generated dynamically -->
        </ul>
      </nav>
    </div>
  </main>
</div>

<!-- Add/Edit Stock Modal -->
<div class="modal fade" id="addStockModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-warning">
        <h5 class="modal-title text-warning" id="stockModalTitle">Add New Product</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="stockForm">
          <input type="hidden" id="stockId" name="stock_id">
          <input type="hidden" id="productId" name="product_id">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label text-warning">Product Code</label>
              <input type="text" class="form-control bg-dark text-white border-warning" 
                     id="productCode" name="product_code" required>
            </div>
            <div class="col-md-6">
              <label class="form-label text-warning">Product Name</label>
              <input type="text" class="form-control bg-dark text-white border-warning" 
                     id="productName" name="product_name" required>
            </div>
            <div class="col-md-6">
              <label class="form-label text-warning">Category</label>
              <select class="form-select bg-dark text-white border-warning" id="category" name="category" required>
                <option value="">Select Category</option>
                <option value="electronics">Electronics</option>
                <option value="clothing">Clothing</option>
                <option value="food">Food & Beverages</option>
                <option value="home">Home & Garden</option>
                <option value="health">Health & Beauty</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label text-warning">Unit Price (₱)</label>
              <input type="number" step="0.01" class="form-control bg-dark text-white border-warning" 
                     id="unitPrice" name="unit_price" required>
            </div>
            <div class="col-md-4">
              <label class="form-label text-warning">Current Stock</label>
              <input type="number" class="form-control bg-dark text-white border-warning" 
                     id="currentStock" name="current_stock" required>
            </div>
            <div class="col-md-4">
              <label class="form-label text-warning">Minimum Level</label>
              <input type="number" class="form-control bg-dark text-white border-warning" 
                     id="minLevel" name="min_level" required>
            </div>
            <div class="col-md-4">
              <label class="form-label text-warning">Maximum Level</label>
              <input type="number" class="form-control bg-dark text-white border-warning" 
                     id="maxLevel" name="max_level" required>
            </div>
            <div class="col-12">
              <label class="form-label text-warning">Description</label>
              <textarea class="form-control bg-dark text-white border-warning" 
                        id="description" name="description" rows="3"></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer border-warning">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="saveStock()">Save Product</button>
      </div>
    </div>
  </div>
</div>

<!-- Stock Adjustment Modal -->
<div class="modal fade" id="adjustStockModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-warning">
        <h5 class="modal-title text-warning">Adjust Stock Level</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="adjustForm">
          <input type="hidden" id="adjustStockId">
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
                      id="adjustNotes" rows="3"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer border-warning">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="saveAdjustment()">Save Adjustment</button>
      </div>
    </div>
  </div>
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

<script>
// Stock data will be loaded from database
let stockData = [];

let currentPage = 1;
const itemsPerPage = 10;

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
  // Test API first
  testApiConnection();
  fetchStockData();
  
  // Event listeners
  document.getElementById('searchInput').addEventListener('input', filterStock);
  document.getElementById('categoryFilter').addEventListener('change', filterStock);
  document.getElementById('statusFilter').addEventListener('change', filterStock);
});

async function testApiConnection() {
  try {
    // Try different URL formats to find the correct one
    const testUrls = [
      '/inventory/api/test',
      '/CHAKANOKS/inventory/api/test',
      '/CHAKANOKS/public/inventory/api/test',
      'inventory/api/test'
    ];
    
    for (const url of testUrls) {
      try {
        console.log('Testing URL:', url);
        const response = await fetch(url);
        console.log('Response status:', response.status, 'for URL:', url);
        
        if (response.ok) {
          const result = await response.json();
          console.log('API Test Result:', result);
          
          if (result.success) {
            console.log(`API working at ${url}. Found ${result.product_count} products in database`);
            // Update the working URL for other API calls
            window.apiBaseUrl = url.replace('/api/test', '');
            return;
          }
        }
      } catch (urlError) {
        console.log('Failed URL:', url, urlError.message);
      }
    }
    
    showAlert('Cannot connect to API - tried multiple URLs', 'danger');
  } catch (error) {
    console.error('API test error:', error);
    showAlert('Cannot connect to API', 'danger');
  }
}

async function fetchStockData() {
  try {
    // Use the working API base URL if found, otherwise try multiple URLs
    const stockUrls = [
      window.apiBaseUrl ? `${window.apiBaseUrl}/api/stock-data` : '/inventory/api/stock-data',
      '/CHAKANOKS/inventory/api/stock-data',
      '/CHAKANOKS/public/inventory/api/stock-data',
      'inventory/api/stock-data'
    ];
    
    for (const url of stockUrls) {
      try {
        console.log('Fetching stock data from:', url);
        const response = await fetch(url);
        console.log('Stock API response status:', response.status, 'for URL:', url);
        
        if (response.ok) {
          const result = await response.json();
          console.log('API Response:', result); // Debug log
          
          // Handle new response format with debug info
          if (result.success && result.data) {
            stockData = result.data;
          } else if (Array.isArray(result)) {
            stockData = result; // Fallback for old format
          } else {
            stockData = [];
            console.error('Unexpected response format:', result);
          }
          
          console.log('Stock data loaded:', stockData); // Debug log
          loadStockData();
          updateStats();
          return; // Success, exit function
        }
      } catch (urlError) {
        console.log('Failed to fetch from:', url, urlError.message);
      }
    }
    
    showAlert('Failed to load stock data from any URL', 'danger');
  } catch (error) {
    console.error('Error fetching stock data:', error);
    showAlert('Error loading stock data', 'danger');
  }
}

function loadStockData() {
  const tbody = document.getElementById('stockTableBody');
  tbody.innerHTML = '';
  
  console.log('Loading stock data, total items:', stockData.length); // Debug log
  
    if (!stockData || stockData.length === 0) {
      tbody.innerHTML = '<tr><td colspan="10" class="text-center">No products found</td></tr>';
      return;
  }
  
  const filteredData = getFilteredData();
  const startIndex = (currentPage - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  const pageData = filteredData.slice(startIndex, endIndex);
  
  console.log('Filtered data:', filteredData.length, 'Page data:', pageData.length); // Debug log
  
    pageData.forEach(stock => {
      const statusClass = getStockStatusClass(stock.current_stock, stock.min_stock_level, stock.max_stock_level);
      const status = getStockStatus(stock.current_stock, stock.min_stock_level, stock.max_stock_level);
      const inventoryId = stock.inventory_id || stock.id;
      // Calculate total value
      const totalValue = (parseFloat(stock.current_stock || 0) * parseFloat(stock.unit_price || 0)).toLocaleString();
      const row = `
        <tr>
          <td><strong>${stock.product_code || ''}</strong></td>
          <td>${stock.product_name || ''}</td>
          <td>${stock.category || ''}</td>
          <td>${stock.current_stock != null ? stock.current_stock : 0}</td>
          <td>${stock.min_stock_level != null ? stock.min_stock_level : 0}</td>
          <td>${stock.max_stock_level != null ? stock.max_stock_level : 0}</td>
          <td>₱${parseFloat(stock.unit_price || 0).toLocaleString()}</td>
          <td>₱${totalValue}</td>
          <td><span class="badge ${statusClass}">${status}</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1" onclick="editStock(${inventoryId})">Edit</button>
            <button class="btn btn-sm btn-outline-danger" onclick="deleteStock(${inventoryId})">Delete</button>
          </td>
        </tr>
      `;
      tbody.innerHTML += row;
    });
  
  updatePagination(filteredData.length);
}

function getFilteredData() {
  const search = document.getElementById('searchInput').value.toLowerCase();
  const category = document.getElementById('categoryFilter').value;
  const status = document.getElementById('statusFilter').value;
  
  return stockData.filter(stock => {
    const matchesSearch = stock.product_name.toLowerCase().includes(search) || 
                         stock.product_code.toLowerCase().includes(search);
    const matchesCategory = !category || stock.category.toLowerCase() === category;
    const stockStatus = getStockStatus(stock.current_stock, stock.min_stock_level, stock.max_stock_level).toLowerCase();
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
  const totalProducts = stockData.length;
  const lowStockCount = stockData.filter(item => 
    item.current_stock > 0 && item.current_stock <= (item.min_stock_level || 0) * 1.5).length;
  const criticalStockCount = stockData.filter(item => 
    item.current_stock <= (item.min_stock_level || 0)).length;
  const totalValue = stockData.reduce((sum, item) => 
    sum + ((item.current_stock || 0) * (item.unit_price || 0)), 0);
  
  document.getElementById('totalProducts').textContent = totalProducts;
  document.getElementById('lowStockCount').textContent = lowStockCount;
  document.getElementById('criticalStockCount').textContent = criticalStockCount;
  document.getElementById('totalValue').textContent = '₱' + totalValue.toLocaleString();
}

function filterStock() {
  currentPage = 1;
  loadStockData();
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
  loadStockData();
}

function editStock(id) {
  const stock = stockData.find(s => s.inventory_id == id || s.id == id);
  if (!stock) return;
  document.getElementById('stockId').value = stock.inventory_id || '';
  document.getElementById('productId').value = stock.id;
  document.getElementById('productCode').value = stock.product_code;
  document.getElementById('productName').value = stock.product_name;
  document.getElementById('category').value = stock.category;
  document.getElementById('unitPrice').value = stock.unit_price;
  document.getElementById('currentStock').value = stock.current_stock || 0;
  document.getElementById('minLevel').value = stock.min_stock_level || 0;
  document.getElementById('maxLevel').value = stock.max_stock_level || 0;
  document.getElementById('description').value = stock.description || '';
  document.getElementById('stockModalTitle').textContent = 'Edit Stock Item';
  new bootstrap.Modal(document.getElementById('addStockModal')).show();
}

function adjustStock(id) {
  const item = stockData.find(s => s.id === id);
  if (!item) return;
  
  document.getElementById('adjustStockId').value = item.id;
  document.getElementById('adjustProductName').value = item.product_name;
  document.getElementById('adjustCurrentStock').value = item.current_stock;
  document.getElementById('adjustmentType').value = '';
  document.getElementById('adjustQuantity').value = '';
  document.getElementById('adjustReason').value = '';
  document.getElementById('adjustNotes').value = '';
  
  new bootstrap.Modal(document.getElementById('adjustStockModal')).show();
}

async function saveStock() {
  const form = document.getElementById('stockForm');
  const formData = new FormData(form);
  
  // Validate form
  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }
  
  const stockItem = {
    id: formData.get('product_id') || formData.get('id'),
    inventory_id: formData.get('stock_id') || null,
    product_code: formData.get('product_code'),
    product_name: formData.get('product_name'),
    category: formData.get('category'),
    unit_price: parseFloat(formData.get('unit_price')),
    current_stock: parseInt(formData.get('current_stock')),
    min_stock: parseInt(formData.get('min_level')),
    max_stock: parseInt(formData.get('max_level')),
    description: formData.get('description')
  };
  
  console.log('Saving stock item:', stockItem); // Debug log
  
  try {
    // Use the working API base URL if found
    const saveUrl = window.apiBaseUrl ? `${window.apiBaseUrl}/api/save-stock` : '/CHAKANOKS/inventory/api/save-stock';
    
    const response = await fetch(saveUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(stockItem)
    });
    
    console.log('Save response status:', response.status);
    const result = await response.json();
    console.log('Save response:', result);
    
    if (result.success) {
      await fetchStockData(); // Reload data from database
      bootstrap.Modal.getInstance(document.getElementById('addStockModal')).hide();
      form.reset();
      showAlert('Stock item saved successfully!', 'success');
    } else {
      console.error('Save failed:', result);
      showAlert('Error saving stock item: ' + (result.error || result.errors || 'Unknown error'), 'danger');
    }
  } catch (error) {
    console.error('Error saving stock:', error);
    showAlert('Error saving stock item: ' + error.message, 'danger');
  }
}

async function saveAdjustment() {
  const id = parseInt(document.getElementById('adjustStockId').value);
  const type = document.getElementById('adjustmentType').value;
  const quantity = parseInt(document.getElementById('adjustQuantity').value);
  const reason = document.getElementById('adjustReason').value;
  const notes = document.getElementById('adjustNotes').value;
  
  console.log('Adjusting stock:', { product_id: id, type, quantity, reason, notes });
  
  try {
    const adjustUrl = window.apiBaseUrl ? `${window.apiBaseUrl}/api/adjust-stock` : '/CHAKANOKS/inventory/api/adjust-stock';
    
    const response = await fetch(adjustUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        product_id: id,
        type: type,
        quantity: quantity,
        reason: reason,
        notes: notes
      })
    });
    
    console.log('Adjust response status:', response.status);
    const result = await response.json();
    console.log('Adjust response:', result);
    
    if (result.success) {
      await fetchStockData(); // Reload data
      bootstrap.Modal.getInstance(document.getElementById('adjustStockModal')).hide();
      showAlert('Stock adjusted successfully!', 'success');
    } else {
      console.error('Adjust failed:', result);
      showAlert('Error adjusting stock: ' + (result.error || result.errors || 'Unknown error'), 'danger');
    }
  } catch (error) {
    console.error('Error adjusting stock:', error);
    showAlert('Error adjusting stock: ' + error.message, 'danger');
  }
}

async function deleteStock(id) {
  if (confirm('Are you sure you want to delete this product?')) {
    console.log('Deleting stock with ID:', id);
    try {
      const deleteUrl = window.apiBaseUrl ? `${window.apiBaseUrl}/api/delete-stock/${id}` : '/CHAKANOKS/inventory/api/delete-stock/' + id;
      const response = await fetch(deleteUrl, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
        }
      });
      console.log('Delete response status:', response.status);
      const result = await response.json();
      console.log('Delete response:', result);
      if (result.success) {
        await fetchStockData(); // Reload data
        showAlert('Stock item deleted successfully!', 'success');
      } else {
        console.error('Delete failed:', result);
        showAlert('Error deleting stock item: ' + (result.error || result.errors || 'Unknown error'), 'danger');
      }
    } catch (error) {
      console.error('Error deleting stock:', error);
      showAlert('Error deleting stock item: ' + error.message, 'danger');
    }
  }
}

function searchByBarcode() {
  const barcode = document.getElementById('manualBarcode').value;
  if (!barcode) return;
  
  // In real app, search database by barcode
  const item = stockData.find(s => s.product_code === barcode);
  
  if (item) {
    bootstrap.Modal.getInstance(document.getElementById('barcodeModal')).hide();
    editStock(item.id);
  } else {
    showAlert('Product not found with barcode: ' + barcode, 'warning');
  }
}

function exportStock() {
  const filteredData = getFilteredData();
  const csv = convertToCSV(filteredData);
  downloadCSV(csv, 'stock_levels.csv');
}

function convertToCSV(data) {
  const headers = ['Product Code', 'Product Name', 'Category', 'Current Stock', 'Min Level', 'Max Level', 'Unit Price', 'Total Value', 'Status'];
  const rows = data.map(item => [
    item.product_code,
    item.product_name,
    item.category,
    item.current_stock,
    item.min_level,
    item.max_level,
    item.unit_price,
    item.current_stock * item.unit_price,
    getStockStatus(item).text
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
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
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
document.getElementById('addStockModal').addEventListener('hidden.bs.modal', function () {
  document.getElementById('stockForm').reset();
  document.getElementById('stockModalTitle').textContent = 'Add New Product';
  document.getElementById('stockId').value = '';
});
</script>

<?= $this->include('shared/footer') ?>



