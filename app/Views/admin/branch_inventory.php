<?= $this->include('shared/header') ?>

<div class="main-container">
  <button class="btn btn-primary d-md-none position-fixed top-0 start-0 m-3" style="z-index:1100" data-bs-toggle="offcanvas" data-bs-target="#sidebar"><i class="bi bi-list"></i></button>
  <div id="mobileOverlay" class="d-md-none" onclick="closeSidebar()"></div>

  <?= $this->include('shared/sidebar') ?>

  <main class="main-content">
    <div class="header">
      <div>
        <h2><?= $branch['name'] ?> - Inventory Details</h2>
        <p class="mb-0">Detailed inventory management for <?= $branch['name'] ?> branch</p>
        <p class="mb-0">Location: <?= $branch['location'] ?></p>
      </div>
      <div class="user-info">
        <div class="text-end">
          <div style="color:#ffd700;font-weight:600;">Central Office Admin</div>
          <div style="color:#ffffff;font-size:14px;"><?= $branch['name'] ?></div>
        </div>
        <div class="user-avatar">CA</div>
      </div>
    </div>

    <!-- Branch Info -->
    <div class="custom-card mb-4">
      <h3 class="text-warning mb-3 fs-5">ℹ️ Branch Information</h3>
      <div class="row">
        <div class="col-md-6">
          <p><strong>Branch Name:</strong> <?= $branch['name'] ?></p>
          <p><strong>Location:</strong> <?= $branch['location'] ?></p>
          <p><strong>Manager:</strong> <?= $branch['manager_name'] ?? 'Not assigned' ?></p>
        </div>
        <div class="col-md-6">
          <p><strong>Phone:</strong> <?= $branch['phone'] ?></p>
          <p><strong>Email:</strong> <?= $branch['email'] ?></p>
          <p><strong>Status:</strong> 
            <?php if ($branch['is_active']): ?>
              <span class="badge badge-active">Active</span>
            <?php else: ?>
              <span class="badge badge-pending">Inactive</span>
            <?php endif; ?>
          </p>
        </div>
      </div>
    </div>

    <!-- Inventory Summary -->
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number"><?= count($inventory) ?></div>
          <div class="stat-label">Total Products</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-danger"><?= count($criticalItems) ?></div>
          <div class="stat-label">Critical Items</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number">₱<?= number_format(array_sum(array_column($inventory, 'total_value')), 2) ?></div>
          <div class="stat-label">Total Value</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-info"><?= count($stockMovements) ?></div>
          <div class="stat-label">Recent Movements</div>
        </div>
      </div>
    </div>

    <!-- Inventory Table -->
    <div class="custom-card mb-4">
      <h3 class="text-warning mb-3 fs-5">📦 Inventory Items</h3>
      <div class="table-responsive">
        <table class="table table-dark table-hover">
          <thead>
            <tr>
              <th>Product</th>
              <th>Category</th>
              <th>Current Stock</th>
              <th>Min Level</th>
              <th>Reorder Point</th>
              <th>Unit Price</th>
              <th>Total Value</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($inventory as $item): ?>
            <tr>
              <td>
                <div>
                  <strong><?= $item['product_name'] ?></strong><br>
                  <small class="text-muted"><?= $item['product_code'] ?></small>
                </div>
              </td>
              <td>
                <span class="badge badge-normal"><?= $item['category'] ?></span>
              </td>
              <td>
                <strong><?= $item['current_stock'] ?> <?= $item['unit'] ?></strong>
              </td>
              <td><?= $item['min_stock_level'] ?> <?= $item['unit'] ?></td>
              <td><?= $item['reorder_point'] ?> <?= $item['unit'] ?></td>
              <td>₱<?= number_format($item['unit_price'], 2) ?></td>
              <td>₱<?= number_format($item['current_stock'] * $item['unit_price'], 2) ?></td>
              <td>
                <?php if ($item['current_stock'] <= $item['reorder_point']): ?>
                  <span class="badge badge-critical">Critical</span>
                <?php elseif ($item['current_stock'] <= $item['min_stock_level']): ?>
                  <span class="badge badge-low">Low Stock</span>
                <?php else: ?>
                  <span class="badge badge-high">In Stock</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Critical Items -->
    <?php if (!empty($criticalItems)): ?>
    <div class="custom-card mb-4" style="border-left: 4px solid #ff4444;">
      <h3 class="text-danger mb-3 fs-5">⚠️ Critical Stock Items</h3>
      <div class="table-responsive">
        <table class="table table-dark table-hover">
          <thead>
            <tr>
              <th>Product</th>
              <th>Current Stock</th>
              <th>Reorder Point</th>
              <th>Deficit</th>
              <th>Priority</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($criticalItems as $item): ?>
            <tr>
              <td>
                <strong><?= $item['product_name'] ?></strong><br>
                <small class="text-muted"><?= $item['product_code'] ?></small>
              </td>
              <td><?= $item['current_stock'] ?> <?= $item['unit'] ?></td>
              <td><?= $item['reorder_point'] ?> <?= $item['unit'] ?></td>
              <td>
                <span class="text-danger">
                  <?= max(0, $item['reorder_point'] - $item['current_stock']) ?> <?= $item['unit'] ?>
                </span>
              </td>
              <td>
                <span class="badge badge-critical">High Priority</span>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php endif; ?>

    <!-- Recent Stock Movements -->
    <div class="custom-card mb-4">
      <h3 class="text-warning mb-3 fs-5">📊 Recent Stock Movements</h3>
      <div class="table-responsive">
        <table class="table table-dark table-hover">
          <thead>
            <tr>
              <th>Date</th>
              <th>Product</th>
              <th>Movement Type</th>
              <th>Quantity</th>
              <th>User</th>
              <th>Notes</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($stockMovements as $movement): ?>
            <tr>
              <td><?= date('M d, Y H:i', strtotime($movement['created_at'])) ?></td>
              <td>
                <strong><?= $movement['product_name'] ?></strong><br>
                <small class="text-muted"><?= $movement['product_code'] ?></small>
              </td>
              <td>
                <span class="badge badge-<?= $movement['movement_type'] === 'in' ? 'high' : 'low' ?>">
                  <?= ucfirst($movement['movement_type']) ?>
                </span>
              </td>
              <td><?= $movement['quantity'] ?></td>
              <td><?= $movement['first_name'] . ' ' . $movement['last_name'] ?></td>
              <td><?= $movement['notes'] ?? '-' ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
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
