<?= $this->include('shared/header') ?>

<div class="main-container">
  <button class="btn btn-primary d-md-none position-fixed top-0 start-0 m-3" style="z-index:1100" data-bs-toggle="offcanvas" data-bs-target="#sidebar"><i class="bi bi-list"></i></button>
  <div id="mobileOverlay" class="d-md-none" onclick="closeSidebar()"></div>

  <?= $this->include('shared/sidebar') ?>

  <main class="main-content">
    <div class="header">
      <div>
        <h2>Damaged / Expired Items</h2>
        <p class="mb-0">Report and track damaged or expired goods with images and notes</p>
      </div>
      <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reportDamageModal">
          <i class="bi bi-exclamation-triangle"></i> Report Damage/Expiry
        </button>
      </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-danger" id="totalDamaged">0</div>
          <div class="stat-label">Total Damaged Items</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-warning" id="totalExpired">0</div>
          <div class="stat-label">Expired Items</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-info" id="totalLoss">₱0</div>
          <div class="stat-label">Total Loss Value</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number" id="thisMonth">0</div>
          <div class="stat-label">This Month</div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="custom-card mb-4">
      <div class="row g-3">
        <div class="col-md-3">
          <input type="text" class="form-control bg-dark text-white border-warning" 
                 id="searchInput" placeholder="Search products...">
        </div>
        <div class="col-md-3">
          <select class="form-select bg-dark text-white border-warning" id="typeFilter">
            <option value="">All Types</option>
            <option value="damaged">Damaged</option>
            <option value="expired">Expired</option>
            <option value="defective">Defective</option>
            <option value="contaminated">Contaminated</option>
          </select>
        </div>
        <div class="col-md-3">
          <input type="date" class="form-control bg-dark text-white border-warning" id="dateFilter">
        </div>
        <div class="col-md-3">
          <button class="btn btn-outline-primary w-100" onclick="exportDamageReport()">
            <i class="bi bi-download"></i> Export Report
          </button>
        </div>
      </div>
    </div>

    <!-- Damage/Expiry Table -->
    <div class="custom-card">
      <div class="table-responsive">
        <table class="table table-dark table-hover">
          <thead>
            <tr>
              <th>Report ID</th>
              <th>Product</th>
              <th>Type</th>
              <th>Quantity</th>
              <th>Unit Value</th>
              <th>Total Loss</th>
              <th>Reason</th>
              <th>Reported By</th>
              <th>Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="damageTableBody">
            <!-- Dynamic content -->
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>

<!-- Report Damage Modal -->
<div class="modal fade" id="reportDamageModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-warning">
        <h5 class="modal-title text-warning">Report Damaged/Expired Item</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="damageForm">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label text-warning">Product</label>
              <select class="form-select bg-dark text-white border-warning" id="productSelect" required>
                <option value="">Select Product</option>
                <option value="1">Samsung Galaxy S23</option>
                <option value="2">Nike Air Max</option>
                <option value="3">Coca Cola 1.5L</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label text-warning">Type</label>
              <select class="form-select bg-dark text-white border-warning" id="damageType" required>
                <option value="">Select Type</option>
                <option value="damaged">Damaged</option>
                <option value="expired">Expired</option>
                <option value="defective">Defective</option>
                <option value="contaminated">Contaminated</option>
                <option value="theft">Theft/Loss</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label text-warning">Quantity Affected</label>
              <input type="number" class="form-control bg-dark text-white border-warning" 
                     id="quantity" required min="1">
            </div>
            <div class="col-md-6">
              <label class="form-label text-warning">Discovery Date</label>
              <input type="date" class="form-control bg-dark text-white border-warning" 
                     id="discoveryDate" required>
            </div>
            <div class="col-12">
              <label class="form-label text-warning">Reason/Description</label>
              <textarea class="form-control bg-dark text-white border-warning" 
                        id="reason" rows="3" required placeholder="Describe what happened..."></textarea>
            </div>
            <div class="col-12">
              <label class="form-label text-warning">Additional Notes</label>
              <textarea class="form-control bg-dark text-white border-warning" 
                        id="notes" rows="2" placeholder="Any additional information..."></textarea>
            </div>
            <div class="col-12">
              <label class="form-label text-warning">Upload Images (Optional)</label>
              <input type="file" class="form-control bg-dark text-white border-warning" 
                     id="images" multiple accept="image/*">
              <div class="form-text text-muted">You can upload multiple images as evidence</div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer border-warning">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="submitDamageReport()">Submit Report</button>
      </div>
    </div>
  </div>
</div>

<!-- View Details Modal -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-warning">
        <h5 class="modal-title text-warning">Damage Report Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detailsContent">
        <!-- Dynamic content -->
      </div>
      <div class="modal-footer border-warning">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-warning" onclick="updateStatus()">Update Status</button>
      </div>
    </div>
  </div>
</div>

<script>
// Sample damage reports data
let damageReports = [
  {
    id: 'DMG-001',
    product_name: 'Samsung Galaxy S23',
    product_id: 1,
    type: 'damaged',
    quantity: 2,
    unit_value: 45000,
    reason: 'Water damage during transport',
    notes: 'Phones were exposed to rain during delivery',
    reported_by: 'John Doe',
    discovery_date: '2025-09-07',
    status: 'pending',
    images: ['damage1.jpg', 'damage2.jpg']
  },
  {
    id: 'EXP-001',
    product_name: 'Coca Cola 1.5L',
    product_id: 3,
    type: 'expired',
    quantity: 24,
    unit_value: 85,
    reason: 'Products reached expiration date',
    notes: 'Found during routine stock check',
    reported_by: 'Jane Smith',
    discovery_date: '2025-09-06',
    status: 'approved',
    images: []
  }
];

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
  loadDamageReports();
  updateStats();
  setTodayDate();
  
  // Event listeners
  document.getElementById('searchInput').addEventListener('input', filterReports);
  document.getElementById('typeFilter').addEventListener('change', filterReports);
  document.getElementById('dateFilter').addEventListener('change', filterReports);
});

function loadDamageReports() {
  const tbody = document.getElementById('damageTableBody');
  tbody.innerHTML = '';
  
  const filteredData = getFilteredReports();
  
  filteredData.forEach(report => {
    const totalLoss = report.quantity * report.unit_value;
    const statusClass = getStatusClass(report.status);
    const typeClass = getTypeClass(report.type);
    
    const row = `
      <tr>
        <td><strong>${report.id}</strong></td>
        <td>${report.product_name}</td>
        <td><span class="badge ${typeClass}">${report.type.toUpperCase()}</span></td>
        <td>${report.quantity}</td>
        <td>₱${report.unit_value.toLocaleString()}</td>
        <td>₱${totalLoss.toLocaleString()}</td>
        <td>${report.reason.substring(0, 30)}...</td>
        <td>${report.reported_by}</td>
        <td>${formatDate(report.discovery_date)}</td>
        <td><span class="badge ${statusClass}">${report.status.toUpperCase()}</span></td>
        <td>
          <button class="btn btn-sm btn-outline-info me-1" onclick="viewDetails('${report.id}')" title="View Details">
            <i class="bi bi-eye"></i>
          </button>
          <button class="btn btn-sm btn-outline-warning" onclick="updateReportStatus('${report.id}')" title="Update Status">
            <i class="bi bi-pencil"></i>
          </button>
        </td>
      </tr>
    `;
    tbody.innerHTML += row;
  });
}

function getFilteredReports() {
  const search = document.getElementById('searchInput').value.toLowerCase();
  const type = document.getElementById('typeFilter').value;
  const date = document.getElementById('dateFilter').value;
  
  return damageReports.filter(report => {
    const matchesSearch = report.product_name.toLowerCase().includes(search) || 
                         report.id.toLowerCase().includes(search);
    const matchesType = !type || report.type === type;
    const matchesDate = !date || report.discovery_date === date;
    
    return matchesSearch && matchesType && matchesDate;
  });
}

function getStatusClass(status) {
  switch(status) {
    case 'pending': return 'bg-warning text-dark';
    case 'approved': return 'bg-success';
    case 'rejected': return 'bg-danger';
    default: return 'bg-secondary';
  }
}

function getTypeClass(type) {
  switch(type) {
    case 'damaged': return 'bg-danger';
    case 'expired': return 'bg-warning text-dark';
    case 'defective': return 'bg-info';
    case 'contaminated': return 'bg-dark';
    case 'theft': return 'bg-secondary';
    default: return 'bg-secondary';
  }
}

function updateStats() {
  const totalDamaged = damageReports.filter(r => r.type === 'damaged').length;
  const totalExpired = damageReports.filter(r => r.type === 'expired').length;
  const totalLoss = damageReports.reduce((sum, r) => sum + (r.quantity * r.unit_value), 0);
  const thisMonth = damageReports.filter(r => {
    const reportDate = new Date(r.discovery_date);
    const now = new Date();
    return reportDate.getMonth() === now.getMonth() && reportDate.getFullYear() === now.getFullYear();
  }).length;
  
  document.getElementById('totalDamaged').textContent = totalDamaged;
  document.getElementById('totalExpired').textContent = totalExpired;
  document.getElementById('totalLoss').textContent = '₱' + totalLoss.toLocaleString();
  document.getElementById('thisMonth').textContent = thisMonth;
}

function filterReports() {
  loadDamageReports();
}

function setTodayDate() {
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('discoveryDate').value = today;
}

function submitDamageReport() {
  const form = document.getElementById('damageForm');
  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }
  
  const productSelect = document.getElementById('productSelect');
  const newReport = {
    id: 'DMG-' + String(damageReports.length + 1).padStart(3, '0'),
    product_name: productSelect.options[productSelect.selectedIndex].text,
    product_id: parseInt(productSelect.value),
    type: document.getElementById('damageType').value,
    quantity: parseInt(document.getElementById('quantity').value),
    unit_value: 1000, // In real app, get from database
    reason: document.getElementById('reason').value,
    notes: document.getElementById('notes').value,
    reported_by: 'Current User', // In real app, get from session
    discovery_date: document.getElementById('discoveryDate').value,
    status: 'pending',
    images: []
  };
  
  damageReports.push(newReport);
  loadDamageReports();
  updateStats();
  
  bootstrap.Modal.getInstance(document.getElementById('reportDamageModal')).hide();
  form.reset();
  setTodayDate();
  
  showAlert('Damage report submitted successfully!', 'success');
}

function viewDetails(reportId) {
  const report = damageReports.find(r => r.id === reportId);
  if (!report) return;
  
  const totalLoss = report.quantity * report.unit_value;
  const content = `
    <div class="row g-3">
      <div class="col-md-6">
        <strong class="text-warning">Report ID:</strong><br>
        ${report.id}
      </div>
      <div class="col-md-6">
        <strong class="text-warning">Product:</strong><br>
        ${report.product_name}
      </div>
      <div class="col-md-6">
        <strong class="text-warning">Type:</strong><br>
        <span class="badge ${getTypeClass(report.type)}">${report.type.toUpperCase()}</span>
      </div>
      <div class="col-md-6">
        <strong class="text-warning">Quantity:</strong><br>
        ${report.quantity} units
      </div>
      <div class="col-md-6">
        <strong class="text-warning">Unit Value:</strong><br>
        ₱${report.unit_value.toLocaleString()}
      </div>
      <div class="col-md-6">
        <strong class="text-warning">Total Loss:</strong><br>
        ₱${totalLoss.toLocaleString()}
      </div>
      <div class="col-md-6">
        <strong class="text-warning">Discovery Date:</strong><br>
        ${formatDate(report.discovery_date)}
      </div>
      <div class="col-md-6">
        <strong class="text-warning">Status:</strong><br>
        <span class="badge ${getStatusClass(report.status)}">${report.status.toUpperCase()}</span>
      </div>
      <div class="col-12">
        <strong class="text-warning">Reason:</strong><br>
        ${report.reason}
      </div>
      <div class="col-12">
        <strong class="text-warning">Notes:</strong><br>
        ${report.notes || 'No additional notes'}
      </div>
      <div class="col-12">
        <strong class="text-warning">Reported By:</strong><br>
        ${report.reported_by}
      </div>
    </div>
  `;
  
  document.getElementById('detailsContent').innerHTML = content;
  new bootstrap.Modal(document.getElementById('viewDetailsModal')).show();
}

function updateReportStatus(reportId) {
  const report = damageReports.find(r => r.id === reportId);
  if (!report) return;
  
  const newStatus = prompt('Update status (pending/approved/rejected):', report.status);
  if (newStatus && ['pending', 'approved', 'rejected'].includes(newStatus)) {
    report.status = newStatus;
    loadDamageReports();
    showAlert('Status updated successfully!', 'success');
  }
}

function exportDamageReport() {
  const filteredData = getFilteredReports();
  const csv = convertDamageToCSV(filteredData);
  downloadCSV(csv, 'damage_report.csv');
}

function convertDamageToCSV(data) {
  const headers = ['Report ID', 'Product', 'Type', 'Quantity', 'Unit Value', 'Total Loss', 'Reason', 'Reported By', 'Date', 'Status'];
  const rows = data.map(report => [
    report.id,
    report.product_name,
    report.type,
    report.quantity,
    report.unit_value,
    report.quantity * report.unit_value,
    report.reason,
    report.reported_by,
    report.discovery_date,
    report.status
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
</script>

<?= $this->include('shared/footer') ?>


