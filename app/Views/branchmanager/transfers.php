<?= $this->include('shared/header') ?>

<div class="main-container">
  <button class="btn btn-primary d-md-none position-fixed top-0 start-0 m-3" style="z-index:1100" data-bs-toggle="offcanvas" data-bs-target="#sidebar"><i class="bi bi-list"></i></button>
  <div id="mobileOverlay" class="d-md-none" onclick="closeSidebar()"></div>

  <?= $this->include('shared/sidebar') ?>

  <main class="main-content">
    <div class="header">
      <div>
        <h2>Intra-Branch Transfer Management</h2>
        <p class="mb-0">Approve and manage inventory transfers between branches</p>
        <p class="mb-0">Branch: <?= $branch['name'] ?? 'Unknown Branch' ?></p>
      </div>
      <div>
        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#createTransferModal">
          <i class="bi bi-arrow-left-right"></i> New Transfer
        </button>
        <button class="btn btn-outline-primary" onclick="exportTransfers()">
          <i class="bi bi-download"></i> Export
        </button>
      </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number" id="totalTransfers">0</div>
          <div class="stat-label">Total Transfers</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-warning" id="pendingApprovals">0</div>
          <div class="stat-label">Pending Approval</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-success" id="approvedTransfers">0</div>
          <div class="stat-label">Approved</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-info" id="totalValue">₱0</div>
          <div class="stat-label">Total Value</div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="custom-card mb-4">
      <div class="row g-3">
        <div class="col-md-3">
          <input type="text" class="form-control bg-dark text-white border-warning" 
                 id="searchInput" placeholder="Search transfers...">
        </div>
        <div class="col-md-3">
          <select class="form-select bg-dark text-white border-warning" id="statusFilter">
            <option value="">All Status</option>
            <option value="pending">Pending Approval</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
            <option value="in_transit">In Transit</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
          </select>
        </div>
        <div class="col-md-3">
          <select class="form-select bg-dark text-white border-warning" id="directionFilter">
            <option value="">All Directions</option>
            <option value="incoming">Incoming</option>
            <option value="outgoing">Outgoing</option>
          </select>
        </div>
        <div class="col-md-3">
          <button class="btn btn-outline-warning w-100" onclick="clearFilters()">
            <i class="bi bi-x-circle"></i> Clear Filters
          </button>
        </div>
      </div>
    </div>

    <!-- Transfers Table -->
    <div class="custom-card">
      <div class="table-responsive">
        <table class="table table-dark table-hover" id="transfersTable">
          <thead>
            <tr>
              <th>Transfer ID</th>
              <th>Direction</th>
              <th>From Branch</th>
              <th>To Branch</th>
              <th>Items Count</th>
              <th>Total Value</th>
              <th>Requested Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="transfersTableBody">
            <!-- Dynamic content will be loaded here -->
          </tbody>
        </table>
      </div>
      
      <!-- Pagination -->
      <nav aria-label="Transfers pagination" class="mt-3">
        <ul class="pagination justify-content-center" id="pagination">
          <!-- Pagination will be generated dynamically -->
        </ul>
      </nav>
    </div>
  </main>
</div>

<!-- Create Transfer Modal -->
<div class="modal fade" id="createTransferModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-warning">
        <h5 class="modal-title text-warning">Create Transfer Request</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="transferForm">
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label text-warning">Transfer To Branch</label>
              <select class="form-select bg-dark text-white border-warning" id="toBranchSelect" required>
                <option value="">Select Destination Branch</option>
                <!-- Dynamic branches will be loaded here -->
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label text-warning">Priority</label>
              <select class="form-select bg-dark text-white border-warning" id="prioritySelect" required>
                <option value="normal">Normal</option>
                <option value="high">High</option>
                <option value="urgent">Urgent</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label text-warning">Transfer Notes</label>
              <textarea class="form-control bg-dark text-white border-warning" 
                        id="transferNotes" rows="3" placeholder="Reason for transfer and any special instructions..."></textarea>
            </div>
          </div>

          <!-- Items Section -->
          <div class="row g-3 mb-3">
            <div class="col-12">
              <h6 class="text-warning">Add Items to Transfer</h6>
            </div>
            <div class="col-md-4">
              <label class="form-label text-warning">Product</label>
              <select class="form-select bg-dark text-white border-warning" id="productSelect">
                <option value="">Select Product</option>
                <!-- Dynamic products will be loaded here -->
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label text-warning">Available Stock</label>
              <input type="number" class="form-control bg-dark text-white border-warning" 
                     id="availableStock" readonly>
            </div>
            <div class="col-md-2">
              <label class="form-label text-warning">Transfer Qty</label>
              <input type="number" class="form-control bg-dark text-white border-warning" 
                     id="transferQuantity" min="1" value="1">
            </div>
            <div class="col-md-2">
              <label class="form-label text-warning">Unit Value</label>
              <input type="number" step="0.01" class="form-control bg-dark text-white border-warning" 
                     id="itemUnitValue" readonly>
            </div>
            <div class="col-md-2">
              <label class="form-label text-warning">&nbsp;</label>
              <button type="button" class="btn btn-primary w-100" onclick="addItemToTransfer()">
                <i class="bi bi-plus"></i> Add
              </button>
            </div>
          </div>

          <!-- Items List -->
          <div class="table-responsive">
            <table class="table table-dark table-sm" id="transferItemsTable">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Available</th>
                  <th>Transfer Qty</th>
                  <th>Unit Value</th>
                  <th>Total Value</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="transferItemsTableBody">
                <!-- Dynamic items will be added here -->
              </tbody>
            </table>
          </div>

          <!-- Total Summary -->
          <div class="row g-3 mt-3">
            <div class="col-md-6">
              <div class="alert alert-info">
                <strong>Total Items:</strong> <span id="totalItemsCount">0</span><br>
                <strong>Total Value:</strong> ₱<span id="totalValue">0.00</span>
              </div>
            </div>
            <div class="col-md-6 text-end">
              <button type="button" class="btn btn-outline-secondary me-2" onclick="saveAsDraft()">
                <i class="bi bi-save"></i> Save as Draft
              </button>
              <button type="button" class="btn btn-primary" onclick="submitTransfer()">
                <i class="bi bi-send"></i> Submit Transfer
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- View Transfer Details Modal -->
<div class="modal fade" id="viewTransferModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-warning">
        <h5 class="modal-title text-warning">Transfer Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="transferDetailsContent">
        <!-- Dynamic content will be loaded here -->
      </div>
      <div class="modal-footer border-warning">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="approveTransfer()" id="approveBtn" style="display: none;">
          <i class="bi bi-check-circle"></i> Approve
        </button>
        <button type="button" class="btn btn-danger" onclick="rejectTransfer()" id="rejectBtn" style="display: none;">
          <i class="bi bi-x-circle"></i> Reject
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Approval Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-warning">
        <h5 class="modal-title text-warning" id="approvalModalTitle">Approve Transfer</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="approvalForm">
          <div class="mb-3">
            <label class="form-label text-warning">Approval Notes</label>
            <textarea class="form-control bg-dark text-white border-warning" 
                      id="approvalNotes" rows="3" placeholder="Add any notes about this approval..."></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer border-warning">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="confirmApproval()" id="confirmApprovalBtn">
          <i class="bi bi-check-circle"></i> Confirm Approval
        </button>
        <button type="button" class="btn btn-danger" onclick="confirmRejection()" id="confirmRejectionBtn" style="display: none;">
          <i class="bi bi-x-circle"></i> Confirm Rejection
        </button>
      </div>
    </div>
  </div>
</div>

<script>
// Global variables
let transfersData = [];
let branchesData = [];
let productsData = [];
let transferItems = [];
let currentTransferId = null;
let currentPage = 1;
const itemsPerPage = 10;

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
  loadTransfersData();
  loadBranches();
  loadProducts();
  
  // Event listeners
  document.getElementById('searchInput').addEventListener('input', filterTransfers);
  document.getElementById('statusFilter').addEventListener('change', filterTransfers);
  document.getElementById('directionFilter').addEventListener('change', filterTransfers);
  
  // Product selection change
  document.getElementById('productSelect').addEventListener('change', updateProductInfo);
  document.getElementById('transferQuantity').addEventListener('input', calculateItemTotal);
});

async function loadTransfersData() {
  try {
    const response = await fetch('/branchmanager/api/transfers');
    const result = await response.json();
    
    if (result.success) {
      transfersData = result.data;
      loadTransfersTable();
      updateStats();
    } else {
      console.error('Failed to load transfers data:', result.error);
      showAlert('Failed to load transfers', 'danger');
    }
  } catch (error) {
    console.error('Error loading transfers data:', error);
    showAlert('Error loading transfers', 'danger');
  }
}

async function loadBranches() {
  try {
    const response = await fetch('/branchmanager/api/branches');
    const result = await response.json();
    
    if (result.success) {
      branchesData = result.data;
      const select = document.getElementById('toBranchSelect');
      select.innerHTML = '<option value="">Select Destination Branch</option>' + 
        result.data.map(branch => `<option value="${branch.id}">${branch.branch_name}</option>`).join('');
    }
  } catch (error) {
    console.error('Error loading branches:', error);
  }
}

async function loadProducts() {
  try {
    const response = await fetch('/branchmanager/api/products');
    const result = await response.json();
    
    if (result.success) {
      productsData = result.data;
      const select = document.getElementById('productSelect');
      select.innerHTML = '<option value="">Select Product</option>' + 
        result.data.map(product => `<option value="${product.id}" data-stock="${product.current_stock}" data-price="${product.unit_price}">${product.product_name} (${product.product_code}) - Stock: ${product.current_stock}</option>`).join('');
    }
  } catch (error) {
    console.error('Error loading products:', error);
  }
}

function loadTransfersTable() {
  const tbody = document.getElementById('transfersTableBody');
  tbody.innerHTML = '';
  
  if (!transfersData || transfersData.length === 0) {
    tbody.innerHTML = '<tr><td colspan="9" class="text-center">No transfers found</td></tr>';
    return;
  }
  
  const filteredData = getFilteredTransfersData();
  const startIndex = (currentPage - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  const pageData = filteredData.slice(startIndex, endIndex);
  
  pageData.forEach(transfer => {
    const statusClass = getStatusClass(transfer.status);
    const direction = transfer.from_branch_id == <?= $branch['id'] ?? 0 ?> ? 'Outgoing' : 'Incoming';
    const directionClass = direction === 'Outgoing' ? 'text-warning' : 'text-info';
    const requestedDate = formatDate(transfer.requested_date);
    
    const row = `
      <tr>
        <td><strong>${transfer.transfer_id || ''}</strong></td>
        <td><span class="${directionClass}">${direction}</span></td>
        <td>${transfer.from_branch_name || 'Unknown'}</td>
        <td>${transfer.to_branch_name || 'Unknown'}</td>
        <td>${transfer.items_count || 0}</td>
        <td>₱${parseFloat(transfer.total_value || 0).toLocaleString()}</td>
        <td>${requestedDate}</td>
        <td><span class="badge ${statusClass}">${transfer.status.toUpperCase()}</span></td>
        <td>
          <button class="btn btn-sm btn-outline-info me-1" onclick="viewTransferDetails(${transfer.id})" title="View Details">
            <i class="bi bi-eye"></i>
          </button>
          ${transfer.status === 'pending' && direction === 'Incoming' ? `
            <button class="btn btn-sm btn-outline-success me-1" onclick="showApprovalModal(${transfer.id}, 'approve')" title="Approve">
              <i class="bi bi-check-circle"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger" onclick="showApprovalModal(${transfer.id}, 'reject')" title="Reject">
              <i class="bi bi-x-circle"></i>
            </button>
          ` : ''}
        </td>
      </tr>
    `;
    tbody.innerHTML += row;
  });
  
  updatePagination(filteredData.length);
}

function getFilteredTransfersData() {
  const search = document.getElementById('searchInput').value.toLowerCase();
  const status = document.getElementById('statusFilter').value;
  const direction = document.getElementById('directionFilter').value;
  
  return transfersData.filter(transfer => {
    const matchesSearch = transfer.transfer_id.toLowerCase().includes(search) || 
                         transfer.from_branch_name.toLowerCase().includes(search) ||
                         transfer.to_branch_name.toLowerCase().includes(search);
    const matchesStatus = !status || transfer.status === status;
    
    let matchesDirection = true;
    if (direction === 'incoming') {
      matchesDirection = transfer.to_branch_id == <?= $branch['id'] ?? 0 ?>;
    } else if (direction === 'outgoing') {
      matchesDirection = transfer.from_branch_id == <?= $branch['id'] ?? 0 ?>;
    }
    
    return matchesSearch && matchesStatus && matchesDirection;
  });
}

function getStatusClass(status) {
  switch(status) {
    case 'pending': return 'bg-warning text-dark';
    case 'approved': return 'bg-success';
    case 'rejected': return 'bg-danger';
    case 'in_transit': return 'bg-info';
    case 'completed': return 'bg-primary';
    case 'cancelled': return 'bg-dark';
    default: return 'bg-secondary';
  }
}

function updateStats() {
  const totalTransfers = transfersData.length;
  const pendingApprovals = transfersData.filter(t => t.status === 'pending' && t.to_branch_id == <?= $branch['id'] ?? 0 ?>).length;
  const approvedTransfers = transfersData.filter(t => t.status === 'approved').length;
  const totalValue = transfersData.reduce((sum, t) => sum + parseFloat(t.total_value || 0), 0);
  
  document.getElementById('totalTransfers').textContent = totalTransfers;
  document.getElementById('pendingApprovals').textContent = pendingApprovals;
  document.getElementById('approvedTransfers').textContent = approvedTransfers;
  document.getElementById('totalValue').textContent = '₱' + totalValue.toLocaleString();
}

function filterTransfers() {
  currentPage = 1;
  loadTransfersTable();
}

function clearFilters() {
  document.getElementById('searchInput').value = '';
  document.getElementById('statusFilter').value = '';
  document.getElementById('directionFilter').value = '';
  filterTransfers();
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
  loadTransfersTable();
}

function updateProductInfo() {
  const productSelect = document.getElementById('productSelect');
  const selectedOption = productSelect.options[productSelect.selectedIndex];
  const availableStock = selectedOption.getAttribute('data-stock') || 0;
  const unitValue = selectedOption.getAttribute('data-price') || 0;
  
  document.getElementById('availableStock').value = availableStock;
  document.getElementById('itemUnitValue').value = unitValue;
  document.getElementById('transferQuantity').max = availableStock;
  calculateItemTotal();
}

function calculateItemTotal() {
  const quantity = parseFloat(document.getElementById('transferQuantity').value) || 0;
  const unitValue = parseFloat(document.getElementById('itemUnitValue').value) || 0;
  const total = quantity * unitValue;
  
  // In a real implementation, this would update a total field
}

function addItemToTransfer() {
  const productSelect = document.getElementById('productSelect');
  const selectedOption = productSelect.options[productSelect.selectedIndex];
  
  if (!selectedOption.value) {
    showAlert('Please select a product', 'warning');
    return;
  }
  
  const quantity = parseInt(document.getElementById('transferQuantity').value);
  const availableStock = parseInt(document.getElementById('availableStock').value);
  const unitValue = parseFloat(document.getElementById('itemUnitValue').value);
  const total = quantity * unitValue;
  
  if (quantity > availableStock) {
    showAlert('Transfer quantity cannot exceed available stock', 'warning');
    return;
  }
  
  const item = {
    product_id: selectedOption.value,
    product_name: selectedOption.text.split(' - ')[0],
    available_stock: availableStock,
    transfer_quantity: quantity,
    unit_value: unitValue,
    total_value: total
  };
  
  transferItems.push(item);
  updateTransferItemsTable();
  updateTransferSummary();
  
  // Reset form
  productSelect.value = '';
  document.getElementById('availableStock').value = '';
  document.getElementById('transferQuantity').value = 1;
  document.getElementById('itemUnitValue').value = '';
}

function updateTransferItemsTable() {
  const tbody = document.getElementById('transferItemsTableBody');
  tbody.innerHTML = '';
  
  transferItems.forEach((item, index) => {
    const row = `
      <tr>
        <td>${item.product_name}</td>
        <td>${item.available_stock}</td>
        <td>${item.transfer_quantity}</td>
        <td>₱${item.unit_value.toFixed(2)}</td>
        <td>₱${item.total_value.toFixed(2)}</td>
        <td>
          <button class="btn btn-sm btn-outline-danger" onclick="removeTransferItem(${index})">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      </tr>
    `;
    tbody.innerHTML += row;
  });
}

function removeTransferItem(index) {
  transferItems.splice(index, 1);
  updateTransferItemsTable();
  updateTransferSummary();
}

function updateTransferSummary() {
  const totalItems = transferItems.length;
  const totalValue = transferItems.reduce((sum, item) => sum + item.total_value, 0);
  
  document.getElementById('totalItemsCount').textContent = totalItems;
  document.getElementById('totalValue').textContent = totalValue.toFixed(2);
}

async function saveAsDraft() {
  if (transferItems.length === 0) {
    showAlert('Please add at least one item to the transfer', 'warning');
    return;
  }
  
  const transferData = {
    to_branch_id: document.getElementById('toBranchSelect').value,
    priority: document.getElementById('prioritySelect').value,
    notes: document.getElementById('transferNotes').value,
    items: transferItems,
    status: 'draft'
  };
  
  try {
    const response = await fetch('/branchmanager/api/create-transfer', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(transferData)
    });
    
    const result = await response.json();
    
    if (result.success) {
      await loadTransfersData();
      bootstrap.Modal.getInstance(document.getElementById('createTransferModal')).hide();
      resetForm();
      showAlert('Transfer saved as draft successfully!', 'success');
    } else {
      showAlert('Error saving transfer: ' + (result.error || 'Unknown error'), 'danger');
    }
  } catch (error) {
    console.error('Error saving transfer:', error);
    showAlert('Error saving transfer: ' + error.message, 'danger');
  }
}

async function submitTransfer() {
  if (transferItems.length === 0) {
    showAlert('Please add at least one item to the transfer', 'warning');
    return;
  }
  
  const transferData = {
    to_branch_id: document.getElementById('toBranchSelect').value,
    priority: document.getElementById('prioritySelect').value,
    notes: document.getElementById('transferNotes').value,
    items: transferItems,
    status: 'pending'
  };
  
  try {
    const response = await fetch('/branchmanager/api/create-transfer', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(transferData)
    });
    
    const result = await response.json();
    
    if (result.success) {
      await loadTransfersData();
      bootstrap.Modal.getInstance(document.getElementById('createTransferModal')).hide();
      resetForm();
      showAlert('Transfer submitted successfully!', 'success');
    } else {
      showAlert('Error submitting transfer: ' + (result.error || 'Unknown error'), 'danger');
    }
  } catch (error) {
    console.error('Error submitting transfer:', error);
    showAlert('Error submitting transfer: ' + error.message, 'danger');
  }
}

function resetForm() {
  document.getElementById('transferForm').reset();
  transferItems = [];
  updateTransferItemsTable();
  updateTransferSummary();
}

function viewTransferDetails(transferId) {
  const transfer = transfersData.find(t => t.id === transferId);
  if (!transfer) return;
  
  const direction = transfer.from_branch_id == <?= $branch['id'] ?? 0 ?> ? 'Outgoing' : 'Incoming';
  const canApprove = transfer.status === 'pending' && direction === 'Incoming';
  
  const content = `
    <div class="row g-3">
      <div class="col-md-6">
        <strong class="text-warning">Transfer ID:</strong><br>
        ${transfer.transfer_id}
      </div>
      <div class="col-md-6">
        <strong class="text-warning">Direction:</strong><br>
        <span class="${direction === 'Outgoing' ? 'text-warning' : 'text-info'}">${direction}</span>
      </div>
      <div class="col-md-6">
        <strong class="text-warning">From Branch:</strong><br>
        ${transfer.from_branch_name}
      </div>
      <div class="col-md-6">
        <strong class="text-warning">To Branch:</strong><br>
        ${transfer.to_branch_name}
      </div>
      <div class="col-md-6">
        <strong class="text-warning">Status:</strong><br>
        <span class="badge ${getStatusClass(transfer.status)}">${transfer.status.toUpperCase()}</span>
      </div>
      <div class="col-md-6">
        <strong class="text-warning">Total Value:</strong><br>
        ₱${parseFloat(transfer.total_value).toLocaleString()}
      </div>
      <div class="col-md-6">
        <strong class="text-warning">Requested Date:</strong><br>
        ${formatDate(transfer.requested_date)}
      </div>
      <div class="col-md-6">
        <strong class="text-warning">Priority:</strong><br>
        ${transfer.priority || 'Normal'}
      </div>
      <div class="col-12">
        <strong class="text-warning">Notes:</strong><br>
        ${transfer.notes || 'No notes provided'}
      </div>
    </div>
  `;
  
  document.getElementById('transferDetailsContent').innerHTML = content;
  
  // Show/hide action buttons
  document.getElementById('approveBtn').style.display = canApprove ? 'inline-block' : 'none';
  document.getElementById('rejectBtn').style.display = canApprove ? 'inline-block' : 'none';
  
  currentTransferId = transferId;
  new bootstrap.Modal(document.getElementById('viewTransferModal')).show();
}

function showApprovalModal(transferId, action) {
  currentTransferId = transferId;
  const isApproval = action === 'approve';
  
  document.getElementById('approvalModalTitle').textContent = isApproval ? 'Approve Transfer' : 'Reject Transfer';
  document.getElementById('confirmApprovalBtn').style.display = isApproval ? 'inline-block' : 'none';
  document.getElementById('confirmRejectionBtn').style.display = isApproval ? 'none' : 'inline-block';
  
  new bootstrap.Modal(document.getElementById('approvalModal')).show();
}

async function confirmApproval() {
  const notes = document.getElementById('approvalNotes').value;
  
  try {
    const response = await fetch(`/branchmanager/api/approve-transfer/${currentTransferId}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ notes: notes })
    });
    
    const result = await response.json();
    
    if (result.success) {
      await loadTransfersData();
      bootstrap.Modal.getInstance(document.getElementById('approvalModal')).hide();
      bootstrap.Modal.getInstance(document.getElementById('viewTransferModal')).hide();
      showAlert('Transfer approved successfully!', 'success');
    } else {
      showAlert('Error approving transfer: ' + (result.error || 'Unknown error'), 'danger');
    }
  } catch (error) {
    console.error('Error approving transfer:', error);
    showAlert('Error approving transfer: ' + error.message, 'danger');
  }
}

async function confirmRejection() {
  const notes = document.getElementById('approvalNotes').value;
  
  try {
    const response = await fetch(`/branchmanager/api/reject-transfer/${currentTransferId}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ notes: notes })
    });
    
    const result = await response.json();
    
    if (result.success) {
      await loadTransfersData();
      bootstrap.Modal.getInstance(document.getElementById('approvalModal')).hide();
      bootstrap.Modal.getInstance(document.getElementById('viewTransferModal')).hide();
      showAlert('Transfer rejected successfully!', 'success');
    } else {
      showAlert('Error rejecting transfer: ' + (result.error || 'Unknown error'), 'danger');
    }
  } catch (error) {
    console.error('Error rejecting transfer:', error);
    showAlert('Error rejecting transfer: ' + error.message, 'danger');
  }
}

function approveTransfer() {
  showApprovalModal(currentTransferId, 'approve');
}

function rejectTransfer() {
  showApprovalModal(currentTransferId, 'reject');
}

function exportTransfers() {
  const filteredData = getFilteredTransfersData();
  const csv = convertTransfersToCSV(filteredData);
  downloadCSV(csv, 'transfers.csv');
}

function convertTransfersToCSV(data) {
  const headers = ['Transfer ID', 'From Branch', 'To Branch', 'Items Count', 'Total Value', 'Requested Date', 'Status', 'Priority'];
  const rows = data.map(transfer => [
    transfer.transfer_id,
    transfer.from_branch_name,
    transfer.to_branch_name,
    transfer.items_count,
    transfer.total_value,
    transfer.requested_date,
    transfer.status,
    transfer.priority || 'Normal'
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
document.getElementById('createTransferModal').addEventListener('hidden.bs.modal', function () {
  resetForm();
});
</script>

<?= $this->include('shared/footer') ?>


