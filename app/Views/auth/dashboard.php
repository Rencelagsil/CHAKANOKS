<?= $this->include('shared/header') ?>

<div class="main-container">
  <!-- Mobile Toggle -->
  <button class="btn btn-primary d-md-none position-fixed top-0 start-0 m-3" style="z-index: 1100;" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
    <i class="bi bi-list"></i>
  </button>

  <!-- Mobile Overlay -->
  <div id="mobileOverlay" class="d-md-none" onclick="closeSidebar()"></div>

  <?= $this->include('shared/sidebar') ?>

  <!-- Main Content -->
  <main class="main-content">
    <div class="header">
      <div>
        <h2>ChakaNoks SCMS Dashboard</h2>
        <p class="mb-0">Welcome, <?= $user['name'] ?? 'User' ?>!</p>
      </div>
      <div class="user-info">
        <div class="text-end">
          <div style="color:#ffd700;font-weight:600;"><?= ucwords(str_replace('_', ' ', $user['role'] ?? 'User')) ?></div>
          <div style="color:#ffffff;font-size:14px;"><?= $user['branch_id'] ? 'Branch ' . $user['branch_id'] : 'Central Office' ?></div>
        </div>
        <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'U', 0, 2)) ?></div>
      </div>
    </div>

    <?php if ($dashboardType === 'admin'): ?>
      <!-- Admin Dashboard -->
      <div class="row g-4 mb-4">
        <div class="col-md-3">
          <div class="stat-card">
            <div class="stat-number"><?= $totalBranches ?? 6 ?></div>
            <div class="stat-label">Total Branches</div>
            <div class="stat-change text-success">+1 New Branch</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-card">
            <div class="stat-number"><?= count($criticalStockItems ?? []) ?></div>
            <div class="stat-label">Critical Stock Items</div>
            <div class="stat-change text-danger">+2 from yesterday</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-card">
            <div class="stat-number">₱<?= number_format($totalInventoryValue ?? 125450) ?></div>
            <div class="stat-label">Total Inventory Value</div>
            <div class="stat-change text-success">+8% this month</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-card">
            <div class="stat-number"><?= count($pendingApprovals ?? []) ?></div>
            <div class="stat-label">Pending Approvals</div>
            <div class="stat-change text-warning">Requires attention</div>
          </div>
        </div>
      </div>

      <div class="custom-card mb-4">
        <h3 class="text-warning mb-3 fs-5">⚠️ Critical Alerts</h3>
        <?php if (!empty($criticalStockItems)): ?>
          <?php foreach ($criticalStockItems as $item): ?>
            <div class="alert alert-warning mb-3">
              <strong>Stock Out Alert:</strong> <?= $item['product_name'] ?? 'Unknown Product' ?> - Critical stock level
              <div class="small text-light mt-1">Emergency reorder required immediately</div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="alert alert-info">
            <strong>All Good:</strong> No critical stock alerts at this time
          </div>
        <?php endif; ?>
      </div>

    <?php elseif ($dashboardType === 'branch_manager'): ?>
      <!-- Branch Manager Dashboard -->
      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <div class="stat-card">
            <div class="stat-number"><?= count($branchInventory ?? []) ?></div>
            <div class="stat-label">Total Products</div>
            <div class="stat-change text-info">In your branch</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="stat-card">
            <div class="stat-number"><?= count($criticalItems ?? []) ?></div>
            <div class="stat-label">Critical Items</div>
            <div class="stat-change text-danger">Needs attention</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="stat-card">
            <div class="stat-number"><?= count($pendingRequests ?? []) ?></div>
            <div class="stat-label">Pending Requests</div>
            <div class="stat-change text-warning">Awaiting approval</div>
          </div>
        </div>
      </div>

      <div class="custom-card mb-4">
        <h3 class="text-warning mb-3 fs-5">🚨 Branch Critical Items</h3>
        <?php if (!empty($criticalItems)): ?>
          <?php foreach ($criticalItems as $item): ?>
            <div class="alert alert-warning mb-3">
              <strong>Low Stock:</strong> <?= $item['product_name'] ?? 'Unknown Product' ?> - Only <?= $item['quantity'] ?? 0 ?> left
              <div class="small text-light mt-1">Consider reordering soon</div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="alert alert-success">
            <strong>All Good:</strong> No critical stock items in your branch
          </div>
        <?php endif; ?>
      </div>

    <?php elseif ($dashboardType === 'inventory_staff'): ?>
      <!-- Inventory Staff Dashboard -->
      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <div class="stat-card">
            <div class="stat-number"><?= count($stockLevels ?? []) ?></div>
            <div class="stat-label">Stock Items</div>
            <div class="stat-change text-info">To manage</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="stat-card">
            <div class="stat-number"><?= count($recentDeliveries ?? []) ?></div>
            <div class="stat-label">Recent Deliveries</div>
            <div class="stat-change text-success">This week</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="stat-card">
            <div class="stat-number"><?= count($expiringItems ?? []) ?></div>
            <div class="stat-label">Expiring Items</div>
            <div class="stat-change text-warning">Need attention</div>
          </div>
        </div>
      </div>

      <div class="custom-card mb-4">
        <h3 class="text-warning mb-3 fs-5">⏰ Expiring Items</h3>
        <?php if (!empty($expiringItems)): ?>
          <?php foreach ($expiringItems as $item): ?>
            <div class="alert alert-warning mb-3">
              <strong>Expiring Soon:</strong> <?= $item['product_name'] ?? 'Unknown Product' ?> - Expires on <?= $item['expiry_date'] ?? 'Unknown Date' ?>
              <div class="small text-light mt-1">Consider using or transferring to other branches</div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="alert alert-success">
            <strong>All Good:</strong> No items expiring soon
          </div>
        <?php endif; ?>
      </div>

    <?php elseif ($dashboardType === 'logistics_coordinator'): ?>
      <!-- Logistics Coordinator Dashboard -->
      <div class="row g-4 mb-4">
        <div class="col-md-6">
          <div class="stat-card">
            <div class="stat-number"><?= count($activeDeliveries ?? []) ?></div>
            <div class="stat-label">Active Deliveries</div>
            <div class="stat-change text-info">In progress</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="stat-card">
            <div class="stat-number"><?= count($scheduledDeliveries ?? []) ?></div>
            <div class="stat-label">Scheduled Deliveries</div>
            <div class="stat-change text-success">Planned</div>
          </div>
        </div>
      </div>

      <div class="custom-card mb-4">
        <h3 class="text-info mb-3 fs-5">🚚 Active Deliveries</h3>
        <?php if (!empty($activeDeliveries)): ?>
          <?php foreach ($activeDeliveries as $delivery): ?>
            <div class="alert alert-info mb-3">
              <strong>Delivery in Progress:</strong> <?= $delivery['delivery_id'] ?? 'Unknown ID' ?> to <?= $delivery['branch_name'] ?? 'Unknown Branch' ?>
              <div class="small text-light mt-1">Status: <?= $delivery['status'] ?? 'Unknown' ?></div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="alert alert-success">
            <strong>All Good:</strong> No active deliveries at this time
          </div>
        <?php endif; ?>
      </div>

    <?php elseif ($dashboardType === 'supplier'): ?>
      <!-- Supplier Dashboard -->
      <div class="row g-4 mb-4">
        <div class="col-md-6">
          <div class="stat-card">
            <div class="stat-number"><?= count($pendingOrders ?? []) ?></div>
            <div class="stat-label">Pending Orders</div>
            <div class="stat-change text-warning">Awaiting fulfillment</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="stat-card">
            <div class="stat-number"><?= count($recentOrders ?? []) ?></div>
            <div class="stat-label">Recent Orders</div>
            <div class="stat-change text-success">This week</div>
          </div>
        </div>
      </div>

      <div class="custom-card mb-4">
        <h3 class="text-warning mb-3 fs-5">📦 Pending Orders</h3>
        <?php if (!empty($pendingOrders)): ?>
          <?php foreach ($pendingOrders as $order): ?>
            <div class="alert alert-warning mb-3">
              <strong>Order Pending:</strong> <?= $order['order_id'] ?? 'Unknown ID' ?> from <?= $order['branch_name'] ?? 'Unknown Branch' ?>
              <div class="small text-light mt-1">Due: <?= $order['due_date'] ?? 'Unknown Date' ?></div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="alert alert-success">
            <strong>All Good:</strong> No pending orders at this time
          </div>
        <?php endif; ?>
      </div>

    <?php elseif ($dashboardType === 'franchise_manager'): ?>
      <!-- Franchise Manager Dashboard -->
      <div class="row g-4 mb-4">
        <div class="col-md-6">
          <div class="stat-card">
            <div class="stat-number"><?= count($franchiseApplications ?? []) ?></div>
            <div class="stat-label">Franchise Applications</div>
            <div class="stat-change text-info">Under review</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="stat-card">
            <div class="stat-number"><?= count($franchiseAllocations ?? []) ?></div>
            <div class="stat-label">Active Allocations</div>
            <div class="stat-change text-success">Active franchises</div>
          </div>
        </div>
      </div>

      <div class="custom-card mb-4">
        <h3 class="text-info mb-3 fs-5">🏢 Franchise Applications</h3>
        <?php if (!empty($franchiseApplications)): ?>
          <?php foreach ($franchiseApplications as $application): ?>
            <div class="alert alert-info mb-3">
              <strong>New Application:</strong> <?= $application['applicant_name'] ?? 'Unknown Applicant' ?> - <?= $application['location'] ?? 'Unknown Location' ?>
              <div class="small text-light mt-1">Status: <?= $application['status'] ?? 'Pending' ?></div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="alert alert-success">
            <strong>All Good:</strong> No pending franchise applications
          </div>
        <?php endif; ?>
      </div>

    <?php elseif ($dashboardType === 'system_admin'): ?>
      <!-- System Administrator Dashboard -->
      <div class="row g-4 mb-4">
        <div class="col-md-3">
          <div class="stat-card">
            <div class="stat-number"><?= count($branches ?? []) ?></div>
            <div class="stat-label">Total Branches</div>
            <div class="stat-change text-info">System wide</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-card">
            <div class="stat-number"><?= $totalUsers ?? 0 ?></div>
            <div class="stat-label">Total Users</div>
            <div class="stat-change text-info">All accounts</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-card">
            <div class="stat-number"><?= $activeUsers ?? 0 ?></div>
            <div class="stat-label">Active Users</div>
            <div class="stat-change text-success">Currently active</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-card">
            <div class="stat-number"><?= count($systemAlerts ?? []) ?></div>
            <div class="stat-label">System Alerts</div>
            <div class="stat-change text-warning">Requires attention</div>
          </div>
        </div>
      </div>

      <div class="custom-card mb-4">
        <h3 class="text-warning mb-3 fs-5">⚙️ System Alerts</h3>
        <?php if (!empty($systemAlerts)): ?>
          <?php foreach ($systemAlerts as $alert): ?>
            <div class="alert alert-<?= $alert['type'] === 'warning' ? 'warning' : 'info' ?> mb-3">
              <strong>System Alert:</strong> <?= $alert['message'] ?? 'Unknown Alert' ?>
              <div class="small text-light mt-1">Time: <?= $alert['timestamp'] ?? 'Unknown' ?></div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="alert alert-success">
            <strong>All Good:</strong> No system alerts at this time
          </div>
        <?php endif; ?>
      </div>

    <?php else: ?>
      <!-- Default Dashboard -->
      <div class="custom-card mb-4">
        <h3 class="text-info mb-3 fs-5">👋 Welcome to ChakaNoks SCMS</h3>
        <div class="alert alert-info">
          <strong>Welcome!</strong> <?= $message ?? 'You are now logged into the ChakaNoks Supply Chain Management System.' ?>
          <div class="small text-light mt-1">Please contact your administrator if you need access to specific features.</div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Role-specific action buttons -->
    <div class="row g-3">
      <?php if ($dashboardType === 'admin'): ?>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="alert('Create Purchase Order - Coming Soon')">
            <h5 class="mb-2">🛒 Create Purchase Order</h5>
            <p class="small mb-0">Generate new purchase orders for branches</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="alert('Track Deliveries - Coming Soon')">
            <h5 class="mb-2">📦 Track Deliveries</h5>
            <p class="small mb-0">Monitor all active deliveries</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="alert('Branch Transfer - Coming Soon')">
            <h5 class="mb-2">🔄 Branch Transfer</h5>
            <p class="small mb-0">Transfer stock between branches</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="alert('Generate Report - Coming Soon')">
            <h5 class="mb-2">📊 Generate Report</h5>
            <p class="small mb-0">Create comprehensive analytics</p>
          </div>
        </div>
      <?php elseif ($dashboardType === 'branch_manager'): ?>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="window.location.href='<?= base_url('branchmanager/inventory') ?>'">
            <h5 class="mb-2">📦 Branch Inventory</h5>
            <p class="small mb-0">Manage your branch inventory</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="window.location.href='<?= base_url('branchmanager/purchase-requests') ?>'">
            <h5 class="mb-2">🛒 Purchase Requests</h5>
            <p class="small mb-0">Create and manage purchase requests</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="window.location.href='<?= base_url('branchmanager/transfers') ?>'">
            <h5 class="mb-2">🔄 Branch Transfers</h5>
            <p class="small mb-0">Transfer items between branches</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="window.location.href='<?= base_url('branchmanager/reports') ?>'">
            <h5 class="mb-2">📊 Branch Reports</h5>
            <p class="small mb-0">View branch performance reports</p>
          </div>
        </div>
      <?php elseif ($dashboardType === 'inventory_staff'): ?>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="window.location.href='<?= base_url('staff/stock-levels') ?>'">
            <h5 class="mb-2">📦 Stock Levels</h5>
            <p class="small mb-0">Update and monitor stock levels</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="window.location.href='<?= base_url('staff/deliveries') ?>'">
            <h5 class="mb-2">🚚 Receive Deliveries</h5>
            <p class="small mb-0">Process incoming deliveries</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="window.location.href='<?= base_url('staff/damages-expired') ?>'">
            <h5 class="mb-2">⚠️ Report Damages</h5>
            <p class="small mb-0">Report damaged or expired items</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="window.location.href='<?= base_url('staff/reports') ?>'">
            <h5 class="mb-2">📊 Inventory Reports</h5>
            <p class="small mb-0">Generate inventory reports</p>
          </div>
        </div>
      <?php elseif ($dashboardType === 'logistics_coordinator'): ?>
        <div class="col-md-4">
          <div class="action-btn h-100" onclick="alert('Schedule Delivery - Coming Soon')">
            <h5 class="mb-2">📅 Schedule Delivery</h5>
            <p class="small mb-0">Schedule new deliveries</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="action-btn h-100" onclick="alert('Track Deliveries - Coming Soon')">
            <h5 class="mb-2">🚚 Track Deliveries</h5>
            <p class="small mb-0">Monitor delivery status</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="action-btn h-100" onclick="alert('Route Optimization - Coming Soon')">
            <h5 class="mb-2">🗺️ Optimize Routes</h5>
            <p class="small mb-0">Optimize delivery routes</p>
          </div>
        </div>
      <?php elseif ($dashboardType === 'supplier'): ?>
        <div class="col-md-4">
          <div class="action-btn h-100" onclick="alert('View Orders - Coming Soon')">
            <h5 class="mb-2">📋 View Orders</h5>
            <p class="small mb-0">View and manage orders</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="action-btn h-100" onclick="alert('Update Status - Coming Soon')">
            <h5 class="mb-2">📝 Update Status</h5>
            <p class="small mb-0">Update order status</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="action-btn h-100" onclick="alert('Submit Invoice - Coming Soon')">
            <h5 class="mb-2">💰 Submit Invoice</h5>
            <p class="small mb-0">Submit invoices for orders</p>
          </div>
        </div>
      <?php elseif ($dashboardType === 'franchise_manager'): ?>
        <div class="col-md-4">
          <div class="action-btn h-100" onclick="alert('Review Applications - Coming Soon')">
            <h5 class="mb-2">📋 Review Applications</h5>
            <p class="small mb-0">Review franchise applications</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="action-btn h-100" onclick="alert('Allocate Supplies - Coming Soon')">
            <h5 class="mb-2">📦 Allocate Supplies</h5>
            <p class="small mb-0">Allocate supplies to franchises</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="action-btn h-100" onclick="alert('Track Payments - Coming Soon')">
            <h5 class="mb-2">💰 Track Payments</h5>
            <p class="small mb-0">Track franchise payments</p>
          </div>
        </div>
      <?php elseif ($dashboardType === 'system_admin'): ?>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="alert('User Management - Coming Soon')">
            <h5 class="mb-2">👥 User Management</h5>
            <p class="small mb-0">Manage user accounts and roles</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="alert('System Settings - Coming Soon')">
            <h5 class="mb-2">⚙️ System Settings</h5>
            <p class="small mb-0">Configure system parameters</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="alert('Backup & Recovery - Coming Soon')">
            <h5 class="mb-2">💾 Backup & Recovery</h5>
            <p class="small mb-0">Manage system backups</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="action-btn h-100" onclick="alert('System Logs - Coming Soon')">
            <h5 class="mb-2">📊 System Logs</h5>
            <p class="small mb-0">View system activity logs</p>
          </div>
        </div>
      <?php else: ?>
        <div class="col-md-6">
          <div class="action-btn h-100" onclick="alert('Contact Administrator - Coming Soon')">
            <h5 class="mb-2">📞 Contact Administrator</h5>
            <p class="small mb-0">Get help with your account</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="action-btn h-100" onclick="alert('System Information - Coming Soon')">
            <h5 class="mb-2">ℹ️ System Information</h5>
            <p class="small mb-0">Learn about the system</p>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </main>
</div>

<?= $this->include('shared/footer') ?>
