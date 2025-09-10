<?= $this->include('shared/header') ?>

<div class="main-container">
  <button class="btn btn-primary d-md-none position-fixed top-0 start-0 m-3" style="z-index:1100" data-bs-toggle="offcanvas" data-bs-target="#sidebar"><i class="bi bi-list"></i></button>
  <div id="mobileOverlay" class="d-md-none" onclick="closeSidebar()"></div>

  <?= $this->include('shared/sidebar') ?>

  <main class="main-content">
    <div class="header">
      <div>
        <h2>Inventory Reports & Analytics</h2>
        <p class="mb-0">Comprehensive reporting and analytics for branch inventory management</p>
        <p class="mb-0">Branch: <?= $branch['name'] ?? 'Unknown Branch' ?></p>
      </div>
      <div>
        <button class="btn btn-primary me-2" onclick="generateCustomReport()">
          <i class="bi bi-file-earmark-text"></i> Custom Report
        </button>
        <button class="btn btn-outline-primary" onclick="exportAllReports()">
          <i class="bi bi-download"></i> Export All
        </button>
      </div>
    </div>

    

    <!-- Date Range Filter -->
    <div class="custom-card mb-4">
      <h5 class="text-warning mb-3">Report Filters</h5>
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label text-warning">Date From</label>
          <input type="date" class="form-control bg-dark text-white border-warning" 
                 id="dateFrom" value="<?= date('Y-m-01') ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label text-warning">Date To</label>
          <input type="date" class="form-control bg-dark text-white border-warning" 
                 id="dateTo" value="<?= date('Y-m-d') ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label text-warning">Category</label>
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
          <label class="form-label text-warning">&nbsp;</label>
          <button class="btn btn-outline-warning w-100" onclick="applyFilters()">
            <i class="bi bi-funnel"></i> Apply Filters
          </button>
        </div>
      </div>
    </div>

    <!-- Report Content Area -->
    <div class="custom-card" id="reportContent">
      <div class="text-center py-5">
        <i class="bi bi-graph-up fs-1 text-muted mb-3"></i>
        <h5 class="text-muted">Select a report category above to view detailed analytics</h5>
        <p class="text-muted">Choose from inventory, stock movement, perishable goods, purchase analysis, transfer analysis, or performance metrics</p>
      </div>
    </div>
  </main>
</div>

<!-- Custom Report Modal -->
<div class="modal fade" id="customReportModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-warning">
        <h5 class="modal-title text-warning">Generate Custom Report</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="customReportForm">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label text-warning">Report Type</label>
              <select class="form-select bg-dark text-white border-warning" id="reportType" required>
                <option value="">Select Report Type</option>
                <option value="inventory">Inventory Report</option>
                <option value="stock_movement">Stock Movement</option>
                <option value="perishable">Perishable Goods</option>
                <option value="purchase">Purchase Analysis</option>
                <option value="transfer">Transfer Analysis</option>
                <option value="performance">Performance Metrics</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label text-warning">Format</label>
              <select class="form-select bg-dark text-white border-warning" id="reportFormat" required>
                <option value="html">HTML (Web View)</option>
                <option value="pdf">PDF Document</option>
                <option value="excel">Excel Spreadsheet</option>
                <option value="csv">CSV File</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label text-warning">Date From</label>
              <input type="date" class="form-control bg-dark text-white border-warning" 
                     id="customDateFrom" required>
            </div>
            <div class="col-md-6">
              <label class="form-label text-warning">Date To</label>
              <input type="date" class="form-control bg-dark text-white border-warning" 
                     id="customDateTo" required>
            </div>
            <div class="col-12">
              <label class="form-label text-warning">Additional Filters</label>
              <div class="row g-2">
                <div class="col-md-6">
                  <select class="form-select bg-dark text-white border-warning" id="customCategory">
                    <option value="">All Categories</option>
                    <option value="electronics">Electronics</option>
                    <option value="clothing">Clothing</option>
                    <option value="food">Food & Beverages</option>
                    <option value="home">Home & Garden</option>
                    <option value="health">Health & Beauty</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <select class="form-select bg-dark text-white border-warning" id="customStatus">
                    <option value="">All Status</option>
                    <option value="normal">Normal Stock</option>
                    <option value="low">Low Stock</option>
                    <option value="critical">Critical Stock</option>
                    <option value="out">Out of Stock</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label text-warning">Report Title</label>
              <input type="text" class="form-control bg-dark text-white border-warning" 
                     id="reportTitle" placeholder="Enter custom report title...">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer border-warning">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="generateCustomReportData()">
          <i class="bi bi-file-earmark-text"></i> Generate Report
        </button>
      </div>
    </div>
  </div>
</div>

<script>
// Global variables
let reportData = {};
let currentReportType = null;

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
  loadDashboardStats();
  setDefaultDates();
  
  // Event listeners
  document.getElementById('dateFrom').addEventListener('change', loadDashboardStats);
  document.getElementById('dateTo').addEventListener('change', loadDashboardStats);
  document.getElementById('categoryFilter').addEventListener('change', loadDashboardStats);
});

function setDefaultDates() {
  const today = new Date();
  const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
  
  document.getElementById('dateFrom').value = firstDay.toISOString().split('T')[0];
  document.getElementById('dateTo').value = today.toISOString().split('T')[0];
  document.getElementById('customDateFrom').value = firstDay.toISOString().split('T')[0];
  document.getElementById('customDateTo').value = today.toISOString().split('T')[0];
}

async function loadDashboardStats() {
  try {
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    const category = document.getElementById('categoryFilter').value;
    
    const response = await fetch('/branchmanager/api/dashboard-stats', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        date_from: dateFrom,
        date_to: dateTo,
        category: category
      })
    });
    
    const result = await response.json();
    
    if (result.success) {
      updateDashboardStats(result.data);
    }
  } catch (error) {
    console.error('Error loading dashboard stats:', error);
  }
}

function updateDashboardStats(data) {
  document.getElementById('totalInventoryValue').textContent = '₱' + (data.total_inventory_value || 0).toLocaleString();
  document.getElementById('lowStockItems').textContent = data.low_stock_items || 0;
  document.getElementById('expiringItems').textContent = data.expiring_items || 0;
  document.getElementById('monthlyMovements').textContent = data.monthly_movements || 0;
}

function showInventoryReport() {
  currentReportType = 'inventory';
  loadReport('inventory');
}

function showStockMovementReport() {
  currentReportType = 'stock_movement';
  loadReport('stock_movement');
}

function showPerishableReport() {
  currentReportType = 'perishable';
  loadReport('perishable');
}

function showPurchaseReport() {
  currentReportType = 'purchase';
  loadReport('purchase');
}

function showTransferReport() {
  currentReportType = 'transfer';
  loadReport('transfer');
}

function showPerformanceReport() {
  currentReportType = 'performance';
  loadReport('performance');
}

async function loadReport(reportType) {
  try {
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    const category = document.getElementById('categoryFilter').value;
    
    const response = await fetch('/branchmanager/api/report-data', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        report_type: reportType,
        date_from: dateFrom,
        date_to: dateTo,
        category: category
      })
    });
    
    const result = await response.json();
    
    if (result.success) {
      displayReport(reportType, result.data);
    } else {
      showAlert('Error loading report: ' + (result.error || 'Unknown error'), 'danger');
    }
  } catch (error) {
    console.error('Error loading report:', error);
    showAlert('Error loading report: ' + error.message, 'danger');
  }
}

function displayReport(reportType, data) {
  const content = document.getElementById('reportContent');
  
  switch(reportType) {
    case 'inventory':
      content.innerHTML = generateInventoryReportHTML(data);
      break;
    case 'stock_movement':
      content.innerHTML = generateStockMovementReportHTML(data);
      break;
    case 'perishable':
      content.innerHTML = generatePerishableReportHTML(data);
      break;
    case 'purchase':
      content.innerHTML = generatePurchaseReportHTML(data);
      break;
    case 'transfer':
      content.innerHTML = generateTransferReportHTML(data);
      break;
    case 'performance':
      content.innerHTML = generatePerformanceReportHTML(data);
      break;
    default:
      content.innerHTML = '<div class="alert alert-warning">Report type not supported</div>';
  }
}

function generateInventoryReportHTML(data) {
  return `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="text-warning mb-0">Inventory Report</h5>
      <div>
        <button class="btn btn-outline-primary btn-sm me-2" onclick="exportReport('inventory')">
          <i class="bi bi-download"></i> Export
        </button>
        <button class="btn btn-outline-success btn-sm" onclick="printReport()">
          <i class="bi bi-printer"></i> Print
        </button>
      </div>
    </div>
    
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number">${data.total_products || 0}</div>
          <div class="stat-label">Total Products</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-warning">${data.low_stock_count || 0}</div>
          <div class="stat-label">Low Stock</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-danger">${data.critical_stock_count || 0}</div>
          <div class="stat-label">Critical Stock</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-success">₱${(data.total_value || 0).toLocaleString()}</div>
          <div class="stat-label">Total Value</div>
        </div>
      </div>
    </div>
    
    <div class="table-responsive">
      <table class="table table-dark table-hover">
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
          </tr>
        </thead>
        <tbody>
          ${data.products ? data.products.map(product => `
            <tr>
              <td><strong>${product.product_code || ''}</strong></td>
              <td>${product.product_name || ''}</td>
              <td>${product.category || ''}</td>
              <td>${product.current_stock || 0}</td>
              <td>${product.min_stock_level || 0}</td>
              <td>${product.max_stock_level || 0}</td>
              <td>₱${parseFloat(product.unit_price || 0).toLocaleString()}</td>
              <td>₱${((product.current_stock || 0) * (product.unit_price || 0)).toLocaleString()}</td>
              <td><span class="badge ${getStockStatusClass(product.current_stock, product.min_stock_level, product.max_stock_level)}">${getStockStatus(product.current_stock, product.min_stock_level, product.max_stock_level)}</span></td>
            </tr>
          `).join('') : '<tr><td colspan="9" class="text-center">No data available</td></tr>'}
        </tbody>
      </table>
    </div>
  `;
}

function generateStockMovementReportHTML(data) {
  return `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="text-info mb-0">Stock Movement Report</h5>
      <div>
        <button class="btn btn-outline-primary btn-sm me-2" onclick="exportReport('stock_movement')">
          <i class="bi bi-download"></i> Export
        </button>
        <button class="btn btn-outline-success btn-sm" onclick="printReport()">
          <i class="bi bi-printer"></i> Print
        </button>
      </div>
    </div>
    
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-success">${data.total_incoming || 0}</div>
          <div class="stat-label">Total Incoming</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-warning">${data.total_outgoing || 0}</div>
          <div class="stat-label">Total Outgoing</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-info">${data.total_adjustments || 0}</div>
          <div class="stat-label">Adjustments</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number">${data.total_movements || 0}</div>
          <div class="stat-label">Total Movements</div>
        </div>
      </div>
    </div>
    
    <div class="table-responsive">
      <table class="table table-dark table-hover">
        <thead>
          <tr>
            <th>Date</th>
            <th>Product</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Reason</th>
            <th>Reference</th>
            <th>User</th>
          </tr>
        </thead>
        <tbody>
          ${data.movements ? data.movements.map(movement => `
            <tr>
              <td>${formatDate(movement.date)}</td>
              <td>${movement.product_name || ''}</td>
              <td><span class="badge ${getMovementTypeClass(movement.type)}">${movement.type.toUpperCase()}</span></td>
              <td>${movement.quantity || 0}</td>
              <td>${movement.reason || ''}</td>
              <td>${movement.reference || ''}</td>
              <td>${movement.user_name || ''}</td>
            </tr>
          `).join('') : '<tr><td colspan="7" class="text-center">No data available</td></tr>'}
        </tbody>
      </table>
    </div>
  `;
}

function generatePerishableReportHTML(data) {
  return `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="text-danger mb-0">Perishable Goods Report</h5>
      <div>
        <button class="btn btn-outline-primary btn-sm me-2" onclick="exportReport('perishable')">
          <i class="bi bi-download"></i> Export
        </button>
        <button class="btn btn-outline-success btn-sm" onclick="printReport()">
          <i class="bi bi-printer"></i> Print
        </button>
      </div>
    </div>
    
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-danger">${data.expiring_soon || 0}</div>
          <div class="stat-label">Expiring Soon</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-warning">${data.expired || 0}</div>
          <div class="stat-label">Expired</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-info">₱${(data.waste_value || 0).toLocaleString()}</div>
          <div class="stat-label">Waste Value</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number">${data.total_perishable || 0}</div>
          <div class="stat-label">Total Perishable</div>
        </div>
      </div>
    </div>
    
    <div class="table-responsive">
      <table class="table table-dark table-hover">
        <thead>
          <tr>
            <th>Product</th>
            <th>Current Stock</th>
            <th>Expiry Date</th>
            <th>Days Until Expiry</th>
            <th>Unit Value</th>
            <th>Total Value</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          ${data.perishable_items ? data.perishable_items.map(item => `
            <tr>
              <td>${item.product_name || ''}</td>
              <td>${item.current_stock || 0}</td>
              <td>${item.expiry_date ? formatDate(item.expiry_date) : 'N/A'}</td>
              <td>${item.days_until_expiry || 'N/A'}</td>
              <td>₱${parseFloat(item.unit_price || 0).toLocaleString()}</td>
              <td>₱${((item.current_stock || 0) * (item.unit_price || 0)).toLocaleString()}</td>
              <td><span class="badge ${getExpiryStatusClass(item.days_until_expiry)}">${getExpiryStatus(item.days_until_expiry)}</span></td>
            </tr>
          `).join('') : '<tr><td colspan="7" class="text-center">No data available</td></tr>'}
        </tbody>
      </table>
    </div>
  `;
}

function generatePurchaseReportHTML(data) {
  return `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="text-success mb-0">Purchase Analysis Report</h5>
      <div>
        <button class="btn btn-outline-primary btn-sm me-2" onclick="exportReport('purchase')">
          <i class="bi bi-download"></i> Export
        </button>
        <button class="btn btn-outline-success btn-sm" onclick="printReport()">
          <i class="bi bi-printer"></i> Print
        </button>
      </div>
    </div>
    
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number">${data.total_requests || 0}</div>
          <div class="stat-label">Total Requests</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-warning">${data.pending_requests || 0}</div>
          <div class="stat-label">Pending</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-success">${data.approved_requests || 0}</div>
          <div class="stat-label">Approved</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-info">₱${(data.total_spending || 0).toLocaleString()}</div>
          <div class="stat-label">Total Spending</div>
        </div>
      </div>
    </div>
    
    <div class="table-responsive">
      <table class="table table-dark table-hover">
        <thead>
          <tr>
            <th>PO Number</th>
            <th>Supplier</th>
            <th>Total Amount</th>
            <th>Requested Date</th>
            <th>Status</th>
            <th>Items Count</th>
          </tr>
        </thead>
        <tbody>
          ${data.requests ? data.requests.map(request => `
            <tr>
              <td><strong>${request.po_number || ''}</strong></td>
              <td>${request.supplier_name || ''}</td>
              <td>₱${parseFloat(request.total_amount || 0).toLocaleString()}</td>
              <td>${formatDate(request.requested_date)}</td>
              <td><span class="badge ${getStatusClass(request.status)}">${request.status.toUpperCase()}</span></td>
              <td>${request.items_count || 0}</td>
            </tr>
          `).join('') : '<tr><td colspan="6" class="text-center">No data available</td></tr>'}
        </tbody>
      </table>
    </div>
  `;
}

function generateTransferReportHTML(data) {
  return `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="text-primary mb-0">Transfer Analysis Report</h5>
      <div>
        <button class="btn btn-outline-primary btn-sm me-2" onclick="exportReport('transfer')">
          <i class="bi bi-download"></i> Export
        </button>
        <button class="btn btn-outline-success btn-sm" onclick="printReport()">
          <i class="bi bi-printer"></i> Print
        </button>
      </div>
    </div>
    
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number">${data.total_transfers || 0}</div>
          <div class="stat-label">Total Transfers</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-warning">${data.pending_transfers || 0}</div>
          <div class="stat-label">Pending</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-success">${data.completed_transfers || 0}</div>
          <div class="stat-label">Completed</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-info">₱${(data.total_value || 0).toLocaleString()}</div>
          <div class="stat-label">Total Value</div>
        </div>
      </div>
    </div>
    
    <div class="table-responsive">
      <table class="table table-dark table-hover">
        <thead>
          <tr>
            <th>Transfer ID</th>
            <th>From Branch</th>
            <th>To Branch</th>
            <th>Total Value</th>
            <th>Requested Date</th>
            <th>Status</th>
            <th>Priority</th>
          </tr>
        </thead>
        <tbody>
          ${data.transfers ? data.transfers.map(transfer => `
            <tr>
              <td><strong>${transfer.transfer_id || ''}</strong></td>
              <td>${transfer.from_branch_name || ''}</td>
              <td>${transfer.to_branch_name || ''}</td>
              <td>₱${parseFloat(transfer.total_value || 0).toLocaleString()}</td>
              <td>${formatDate(transfer.requested_date)}</td>
              <td><span class="badge ${getStatusClass(transfer.status)}">${transfer.status.toUpperCase()}</span></td>
              <td>${transfer.priority || 'Normal'}</td>
            </tr>
          `).join('') : '<tr><td colspan="7" class="text-center">No data available</td></tr>'}
        </tbody>
      </table>
    </div>
  `;
}

function generatePerformanceReportHTML(data) {
  return `
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="text-warning mb-0">Performance Metrics Report</h5>
      <div>
        <button class="btn btn-outline-primary btn-sm me-2" onclick="exportReport('performance')">
          <i class="bi bi-download"></i> Export
        </button>
        <button class="btn btn-outline-success btn-sm" onclick="printReport()">
          <i class="bi bi-printer"></i> Print
        </button>
      </div>
    </div>
    
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number">${data.inventory_turnover || 0}</div>
          <div class="stat-label">Inventory Turnover</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-success">${data.stock_accuracy || 0}%</div>
          <div class="stat-label">Stock Accuracy</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-warning">${data.waste_percentage || 0}%</div>
          <div class="stat-label">Waste Percentage</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-info">${data.efficiency_score || 0}</div>
          <div class="stat-label">Efficiency Score</div>
        </div>
      </div>
    </div>
    
    <div class="row g-3">
      <div class="col-md-6">
        <div class="custom-card">
          <h6 class="text-warning">Top Performing Categories</h6>
          <div class="table-responsive">
            <table class="table table-dark table-sm">
              <thead>
                <tr>
                  <th>Category</th>
                  <th>Turnover Rate</th>
                  <th>Value</th>
                </tr>
              </thead>
              <tbody>
                ${data.top_categories ? data.top_categories.map(category => `
                  <tr>
                    <td>${category.name}</td>
                    <td>${category.turnover_rate}</td>
                    <td>₱${category.value.toLocaleString()}</td>
                  </tr>
                `).join('') : '<tr><td colspan="3" class="text-center">No data available</td></tr>'}
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="custom-card">
          <h6 class="text-warning">Monthly Trends</h6>
          <div class="table-responsive">
            <table class="table table-dark table-sm">
              <thead>
                <tr>
                  <th>Month</th>
                  <th>Incoming</th>
                  <th>Outgoing</th>
                  <th>Net Change</th>
                </tr>
              </thead>
              <tbody>
                ${data.monthly_trends ? data.monthly_trends.map(trend => `
                  <tr>
                    <td>${trend.month}</td>
                    <td>${trend.incoming}</td>
                    <td>${trend.outgoing}</td>
                    <td class="${trend.net_change >= 0 ? 'text-success' : 'text-danger'}">${trend.net_change >= 0 ? '+' : ''}${trend.net_change}</td>
                  </tr>
                `).join('') : '<tr><td colspan="4" class="text-center">No data available</td></tr>'}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  `;
}

function generateCustomReport() {
  new bootstrap.Modal(document.getElementById('customReportModal')).show();
}

async function generateCustomReportData() {
  const form = document.getElementById('customReportForm');
  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }
  
  const reportData = {
    report_type: document.getElementById('reportType').value,
    format: document.getElementById('reportFormat').value,
    date_from: document.getElementById('customDateFrom').value,
    date_to: document.getElementById('customDateTo').value,
    category: document.getElementById('customCategory').value,
    status: document.getElementById('customStatus').value,
    title: document.getElementById('reportTitle').value
  };
  
  try {
    const response = await fetch('/branchmanager/api/generate-custom-report', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(reportData)
    });
    
    const result = await response.json();
    
    if (result.success) {
      if (reportData.format === 'html') {
        displayReport(reportData.report_type, result.data);
        bootstrap.Modal.getInstance(document.getElementById('customReportModal')).hide();
      } else {
        // Download file for other formats
        downloadFile(result.file_url, result.filename);
        bootstrap.Modal.getInstance(document.getElementById('customReportModal')).hide();
      }
      showAlert('Custom report generated successfully!', 'success');
    } else {
      showAlert('Error generating report: ' + (result.error || 'Unknown error'), 'danger');
    }
  } catch (error) {
    console.error('Error generating custom report:', error);
    showAlert('Error generating custom report: ' + error.message, 'danger');
  }
}

function applyFilters() {
  if (currentReportType) {
    loadReport(currentReportType);
  } else {
    loadDashboardStats();
  }
}

function exportReport(reportType) {
  const dateFrom = document.getElementById('dateFrom').value;
  const dateTo = document.getElementById('dateTo').value;
  const category = document.getElementById('categoryFilter').value;
  
  // In a real implementation, this would generate and download the report
  showAlert(`Exporting ${reportType} report...`, 'info');
}

function exportAllReports() {
  showAlert('Exporting all reports...', 'info');
}

function printReport() {
  window.print();
}

function downloadFile(url, filename) {
  const a = document.createElement('a');
  a.href = url;
  a.download = filename;
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
}

// Helper functions
function getStockStatus(current, min, max) {
  current = parseInt(current) || 0;
  min = parseInt(min) || 0;
  max = parseInt(max) || 0;
  
  if (current === 0) return 'Out of Stock';
  if (current <= min) return 'Critical';
  if (current <= (min * 1.2)) return 'Low Stock';
  if (max > 0 && current >= max) return 'Overstock';
  return 'Normal';
}

function getStockStatusClass(current, min, max) {
  current = parseInt(current) || 0;
  min = parseInt(min) || 0;
  max = parseInt(max) || 0;
  
  if (current === 0) return 'bg-danger';
  if (current <= min) return 'bg-danger';
  if (current <= (min * 1.2)) return 'bg-warning text-dark';
  if (max > 0 && current >= max) return 'bg-info';
  return 'bg-success';
}

function getMovementTypeClass(type) {
  switch(type) {
    case 'in': return 'bg-success';
    case 'out': return 'bg-warning text-dark';
    case 'adjustment': return 'bg-info';
    default: return 'bg-secondary';
  }
}

function getExpiryStatus(days) {
  if (days === null || days === undefined) return 'Unknown';
  if (days < 0) return 'Expired';
  if (days <= 3) return 'Critical';
  if (days <= 7) return 'Warning';
  return 'Good';
}

function getExpiryStatusClass(days) {
  if (days === null || days === undefined) return 'bg-secondary';
  if (days < 0) return 'bg-danger';
  if (days <= 3) return 'bg-danger';
  if (days <= 7) return 'bg-warning text-dark';
  return 'bg-success';
}

function getStatusClass(status) {
  switch(status) {
    case 'pending': return 'bg-warning text-dark';
    case 'approved': return 'bg-success';
    case 'rejected': return 'bg-danger';
    case 'completed': return 'bg-primary';
    case 'cancelled': return 'bg-dark';
    default: return 'bg-secondary';
  }
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
</script>

<?= $this->include('shared/footer') ?>


