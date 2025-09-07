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
        <h2>Branch Manager Dashboard</h2>
        <p class="mb-0">Welcome, <?= $user['name'] ?? 'Branch Manager' ?>!</p>
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

    <div class="row g-4 mb-4">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number"><?= count($inventory ?? []) ?></div>
          <div class="stat-label">Total Products</div>
          <div class="stat-change text-success">+5 this week</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number"><?= count($lowStockItems ?? []) ?></div>
          <div class="stat-label">Low Stock Items</div>
          <div class="stat-change text-danger">+2 from yesterday</div>
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
          <div class="stat-number">₱<?= number_format($totalInventoryValue ?? 0) ?></div>
          <div class="stat-label">Inventory Value</div>
          <div class="stat-change text-success">+3% this month</div>
        </div>
      </div>
    </div>

    <div class="custom-card mb-4">
      <h3 class="text-warning mb-3 fs-5">⚠️ Stock Alerts</h3>
      <?php if (!empty($lowStockItems)): ?>
        <?php foreach ($lowStockItems as $item): ?>
          <div class="alert alert-warning mb-3">
            <strong>Low Stock:</strong> <?= $item['product_name'] ?? 'Unknown Product' ?> - Only <?= $item['current_stock'] ?? 0 ?> units remaining
            <div class="small text-light mt-1">Reorder recommended within 24 hours</div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="alert alert-info">
          <strong>All Good:</strong> No low stock alerts at this time
        </div>
      <?php endif; ?>
    </div>

    <div class="row g-3">
      <div class="col-md-3">
        <div class="action-btn h-100" onclick="alert('Create Purchase Request - Coming Soon')">
          <h5 class="mb-2">🛒 Create Purchase Request</h5>
          <p class="small mb-0">Request new inventory items</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="action-btn h-100" onclick="alert('View Inventory - Coming Soon')">
          <h5 class="mb-2">📦 View Inventory</h5>
          <p class="small mb-0">Check current stock levels</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="action-btn h-100" onclick="alert('Transfer Request - Coming Soon')">
          <h5 class="mb-2">🔄 Transfer Request</h5>
          <p class="small mb-0">Request transfers from other branches</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="action-btn h-100" onclick="alert('Branch Reports - Coming Soon')">
          <h5 class="mb-2">📊 Branch Reports</h5>
          <p class="small mb-0">View branch performance</p>
        </div>
      </div>
    </div>
  </main>
</div>

<?= $this->include('shared/footer') ?>