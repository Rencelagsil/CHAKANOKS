<?= $this->include('shared/header') ?>

<div class="main-container">
  <button class="btn btn-primary d-md-none position-fixed top-0 start-0 m-3" style="z-index:1100" data-bs-toggle="offcanvas" data-bs-target="#sidebar"><i class="bi bi-list"></i></button>
  <div id="mobileOverlay" class="d-md-none" onclick="closeSidebar()"></div>

  <?= $this->include('shared/sidebar') ?>

  <main class="main-content">
    <div class="header">
      <div>
        <h2>Central Office - Products Management</h2>
        <p class="mb-0">Manage product catalog, track inventory across branches, and monitor supplier relationships</p>
        <p class="mb-0">Role: Central Office Admin</p>
      </div>
      <div class="user-info">
        <div class="text-end">
          <div style="color:#ffd700;font-weight:600;">Central Office Admin</div>
          <div style="color:#ffffff;font-size:14px;">Product Management</div>
        </div>
        <div class="user-avatar">CA</div>
      </div>
    </div>

    <!-- Product Analytics -->
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number"><?= $productAnalytics['total_products'] ?></div>
          <div class="stat-label">Total Products</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-success"><?= $productAnalytics['active_products'] ?></div>
          <div class="stat-label">Active Products</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-warning"><?= $productAnalytics['perishable_products'] ?></div>
          <div class="stat-label">Perishable Products</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number text-info"><?= count($categories) ?></div>
          <div class="stat-label">Categories</div>
        </div>
      </div>
    </div>

    <!-- Products Table -->
    <div class="custom-card mb-4">
      <h3 class="text-warning mb-3 fs-5">📦 All Products with Stock Information</h3>
      <?php if (!empty($products)): ?>
      <div class="table-responsive">
        <table class="table table-dark table-hover" id="productsTable">
          <thead>
            <tr>
              <th>Product</th>
              <th>Category</th>
              <th>Unit Price</th>
              <th>Total Stock</th>
              <th>Branch Stocks</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
              <td>
                <div>
                  <strong><?= $product['product_name'] ?></strong><br>
                  <small class="text-muted"><?= $product['product_code'] ?></small><br>
                  <small class="text-muted">Barcode: <?= $product['barcode'] ?></small>
                </div>
              </td>
              <td>
                <span class="badge badge-normal"><?= $product['category'] ?></span>
              </td>
              <td>₱<?= number_format($product['unit_price'], 2) ?></td>
              <td>
                <strong><?= $product['total_stock'] ?? 0 ?> <?= $product['unit'] ?></strong>
              </td>
              <td>
                <div class="small">
                  <?php if (!empty($product['branch_stocks'])): ?>
                    <?php foreach ($product['branch_stocks'] as $stock): ?>
                    <div>
                      <strong><?= $stock['branch_name'] ?>:</strong> 
                      <?= $stock['current_stock'] ?> <?= $product['unit'] ?>
                    </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <span class="text-muted">No branch data</span>
                  <?php endif; ?>
                </div>
              </td>
              <td>
                <?php if ($product['is_active']): ?>
                  <span class="badge badge-active">Active</span>
                <?php else: ?>
                  <span class="badge badge-pending">Inactive</span>
                <?php endif; ?>
                
                <?php if ($product['is_perishable']): ?>
                  <br><span class="badge badge-low">Perishable</span>
                <?php endif; ?>
              </td>
              <td>
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-sm btn-outline-primary" 
                          onclick="viewProductDetails(<?= $product['id'] ?>)">
                    <i class="bi bi-eye"></i>
                  </button>
                  <button type="button" class="btn btn-sm btn-outline-primary" 
                          onclick="editProduct(<?= $product['id'] ?>)">
                    <i class="bi bi-pencil"></i>
                  </button>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <div class="text-center py-4">
        <p class="text-muted">No products found. Please add products to the system.</p>
        <button class="btn btn-primary" onclick="alert('Add Product functionality coming soon!')">
          <i class="bi bi-plus"></i> Add Product
        </button>
      </div>
      <?php endif; ?>
    </div>

    <!-- Categories Summary -->
    <div class="custom-card mb-4">
      <h3 class="text-warning mb-3 fs-5">🏷️ Product Categories</h3>
      <div class="row">
        <?php foreach ($categories as $category): ?>
        <div class="col-md-3 mb-2">
          <span class="badge badge-normal fs-6"><?= $category['category'] ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Suppliers Summary -->
    <div class="custom-card mb-4">
      <h3 class="text-warning mb-3 fs-5">🚚 Suppliers</h3>
      <?php if (!empty($suppliers)): ?>
      <div class="table-responsive">
        <table class="table table-dark table-hover">
          <thead>
            <tr>
              <th>Supplier Name</th>
              <th>Contact Person</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($suppliers as $supplier): ?>
            <tr>
              <td><strong><?= $supplier['company_name'] ?></strong></td>
              <td><?= $supplier['contact_person'] ?></td>
              <td><?= $supplier['phone'] ?></td>
              <td><?= $supplier['email'] ?></td>
              <td>
                <?php if ($supplier['is_active']): ?>
                  <span class="badge badge-active">Active</span>
                <?php else: ?>
                  <span class="badge badge-pending">Inactive</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <div class="text-center py-4">
        <p class="text-muted">No suppliers found. Please add suppliers to the system.</p>
        <button class="btn btn-primary" onclick="alert('Add Supplier functionality coming soon!')">
          <i class="bi bi-plus"></i> Add Supplier
        </button>
      </div>
      <?php endif; ?>
    </div>
  </main>
</div>

<script>
function refreshData() {
  location.reload();
}

function viewProductDetails(productId) {
  // Implementation for viewing product details
  alert('View product details for ID: ' + productId);
}

function editProduct(productId) {
  // Implementation for editing product
  alert('Edit product ID: ' + productId);
}

// Auto-refresh every 5 minutes
setInterval(function() {
  location.reload();
}, 300000);
</script>

<?= $this->include('shared/footer') ?>
