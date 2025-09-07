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
        <h2>Inventory Staff Dashboard</h2>
        <p class="mb-0">Welcome, <?= $user['name'] ?? 'Inventory Staff' ?>!</p>
        <p class="mb-0">Branch: <?= $branch['name'] ?? 'Unknown Branch' ?></p>
      </div>
      <div class="user-info">
        <div class="text-end">
          <div style="color:#ffd700;font-weight:600;"><?= $user['role'] ?? 'Inventory Staff' ?></div>
          <div style="color:#ffffff;font-size:14px;"><?= $branch['name'] ?? 'Branch' ?></div>
        </div>
        <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'IS', 0, 2)) ?></div>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number"><?= count($inventory ?? []) ?></div>
          <div class="stat-label">Total Products</div>
          <div class="stat-change text-success">+3 this week</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number"><?= count($lowStockItems ?? []) ?></div>
          <div class="stat-label">Low Stock Items</div>
          <div class="stat-change text-warning">+1 from yesterday</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number"><?= count($criticalStockItems ?? []) ?></div>
          <div class="stat-label">Critical Stock</div>
          <div class="stat-change text-danger">Requires attention</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number"><?= count($recentMovements ?? []) ?></div>
          <div class="stat-label">Recent Movements</div>
          <div class="stat-change text-info">Today's activity</div>
        </div>
      </div>
    </div>

    <div class="custom-card mb-4">
      <h3 class="text-warning mb-3 fs-5">⚠️ Stock Alerts</h3>
      <?php if (!empty($criticalStockItems)): ?>
        <?php foreach ($criticalStockItems as $item): ?>
          <div class="alert alert-warning mb-3">
            <strong>Critical Stock:</strong> <?= $item['product_name'] ?? 'Unknown Product' ?> - Only <?= $item['current_stock'] ?? 0 ?> units remaining
            <div class="small text-light mt-1">Immediate action required</div>
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
        <div class="action-btn h-100" onclick="alert('Adjust Stock - Coming Soon')">
          <h5 class="mb-2">📝 Adjust Stock</h5>
          <p class="small mb-0">Update inventory quantities</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="action-btn h-100" onclick="alert('Receive Delivery - Coming Soon')">
          <h5 class="mb-2">📦 Receive Delivery</h5>
          <p class="small mb-0">Process incoming deliveries</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="action-btn h-100" onclick="alert('Report Damaged - Coming Soon')">
          <h5 class="mb-2">⚠️ Report Damaged</h5>
          <p class="small mb-0">Report damaged/expired goods</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="action-btn h-100" onclick="alert('Stock Reports - Coming Soon')">
          <h5 class="mb-2">📊 Stock Reports</h5>
          <p class="small mb-0">View inventory reports</p>
        </div>
      </div>
    </div>
  </main>
</div>

<?= $this->include('shared/footer') ?>