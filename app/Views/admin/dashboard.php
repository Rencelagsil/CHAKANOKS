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
        <h2>Supply Chain Dashboard</h2>
        <p class="mb-0">Welcome, <?= $user['name'] ?? 'Admin' ?>!</p>
      </div>
      <div class="user-info">
        <div class="text-end">
          <div style="color:#ffd700;font-weight:600;"><?= $user['role'] ?? 'Admin' ?></div>
          <div style="color:#ffffff;font-size:14px;">ChakaNoks HQ</div>
        </div>
        <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'A', 0, 2)) ?></div>
      </div>
    </div>

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

    <div class="row g-3">
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
    </div>
  </main>
</div>

<?= $this->include('shared/footer') ?>