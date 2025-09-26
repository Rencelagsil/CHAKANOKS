<?= $this->include('shared/header') ?>

<div class="main-container">
  <button class="btn btn-primary d-md-none position-fixed top-0 start-0 m-3" style="z-index:1100" data-bs-toggle="offcanvas" data-bs-target="#sidebar"><i class="bi bi-list"></i></button>
  <div id="mobileOverlay" class="d-md-none" onclick="closeSidebar()"></div>

  <?= $this->include('shared/sidebar') ?>

  <main class="main-content">
    <div class="header">
      <div>
        <h2>Central Office - Inventory Overview</h2>
        <p class="mb-0">Monitor inventory across all branches, track critical stock levels, and manage supply chain operations</p>
        <p class="mb-0">Role: Central Office Admin</p>
      </div>
      <div class="user-info">
        <div class="text-end">
          <div style="color:#ffd700;font-weight:600;">Central Office Admin</div>
          <div style="color:#ffffff;font-size:14px;">System Overview</div>
        </div>
        <div class="user-avatar">CA</div>
      </div>
    </div>

    <!-- Quick Stats Dashboard -->
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number"><?= count($branches) ?></div>
          <div class="stat-label">Total Branches</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number">₱<?= number_format($totalInventoryValue, 2) ?></div>
          <div class="stat-label">Total Inventory Value</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-danger"><?= count($criticalStockItems) ?></div>
          <div class="stat-label">Critical Items</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-warning"><?= count($lowStockAlerts) ?></div>
          <div class="stat-label">Low Stock Alerts</div>
        </div>
      </div>
    </div>

    <!-- Branch Inventory Summary -->
    <div class="custom-card mb-4">
      <h3 class="text-warning mb-3 fs-5">🏢 Branch Inventory Summary</h3>
      <div class="table-responsive">
        <table class="table table-dark table-hover">
          <thead>
            <tr>
              <th>Branch</th>
              <th>Total Products</th>
              <th>Inventory Value</th>
              <th>Low Stock</th>
              <th>Critical Items</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($inventorySummary)): ?>
              <?php foreach ($inventorySummary as $summary): ?>
              <tr>
                <td>
                  <strong><?= $summary['branch_name'] ?></strong>
                </td>
                <td><?= $summary['total_products'] ?></td>
                <td>₱<?= number_format($summary['total_value'], 2) ?></td>
                <td>
                  <span class="badge badge-low"><?= $summary['low_stock_count'] ?></span>
                </td>
                <td>
                  <span class="badge badge-critical"><?= $summary['critical_count'] ?></span>
                </td>
                <td>
                  <a href="<?= base_url('admin/branch-inventory/' . $summary['branch_id']) ?>" 
                     class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-eye"></i> View Details
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted">
                  <i class="bi bi-info-circle"></i> No inventory data available. Please ensure branches and inventory data are properly seeded.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Critical Stock Items -->
    <div class="custom-card mb-4" style="border-left: 4px solid #ff4444;">
      <h3 class="text-danger mb-3 fs-5">⚠️ Critical Stock Items</h3>
      <?php if (!empty($criticalStockItems)): ?>
      <div class="table-responsive">
        <table class="table table-dark table-hover">
          <thead>
            <tr>
              <th>Product</th>
              <th>Branch</th>
              <th>Current Stock</th>
              <th>Reorder Point</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($criticalStockItems as $item): ?>
            <tr>
              <td>
                <strong><?= $item['product_name'] ?></strong><br>
                <small class="text-muted"><?= $item['product_code'] ?></small>
              </td>
              <td><?= $item['branch_name'] ?></td>
              <td><?= $item['current_stock'] ?> <?= $item['unit'] ?></td>
              <td><?= $item['reorder_point'] ?> <?= $item['unit'] ?></td>
              <td>
                <span class="badge badge-critical">Critical</span>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <div class="text-center text-muted py-4">
        <i class="bi bi-check-circle text-success"></i>
        <p class="mb-0">No critical stock items found. All products are within safe stock levels.</p>
      </div>
      <?php endif; ?>
    </div>

    <!-- Low Stock Alerts -->
    <?php if (!empty($lowStockAlerts)): ?>
    <div class="custom-card mb-4" style="border-left: 4px solid #ff8800;">
      <h3 class="text-warning mb-3 fs-5">⚠️ Low Stock Alerts by Branch</h3>
      <?php foreach ($lowStockAlerts as $alert): ?>
      <div class="mb-3">
        <h6 class="text-warning"><?= $alert['branch_name'] ?></h6>
        <div class="table-responsive">
          <table class="table table-dark table-sm">
            <thead>
              <tr>
                <th>Product</th>
                <th>Current Stock</th>
                <th>Min Level</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($alert['items'] as $item): ?>
              <tr>
                <td><?= $item['product_name'] ?></td>
                <td><?= $item['current_stock'] ?> <?= $item['unit'] ?></td>
                <td><?= $item['min_stock_level'] ?> <?= $item['unit'] ?></td>
                <td>
                  <span class="badge badge-low">Low Stock</span>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </main>
</div>

<script>
function refreshData() {
  location.reload();
}

// Auto-refresh every 5 minutes
setInterval(function() {
  location.reload();
}, 300000);
</script>

<?= $this->include('shared/footer') ?>
