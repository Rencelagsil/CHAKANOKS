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
        <h2>Logistics Coordinator Dashboard</h2>
        <p class="mb-0">Welcome, <?= $user['name'] ?? 'Logistics Coordinator' ?>!</p>
      </div>
      <div class="user-info">
        <div class="text-end">
          <div style="color:#ffd700;font-weight:600;"><?= $user['role'] ?? 'Logistics Coordinator' ?></div>
          <div style="color:#ffffff;font-size:14px;">ChakaNoks Logistics</div>
        </div>
        <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'LC', 0, 2)) ?></div>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number">3</div>
          <div class="stat-label">Active Deliveries</div>
          <div class="stat-change text-success">On schedule</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number">2</div>
          <div class="stat-label">Pending Deliveries</div>
          <div class="stat-change text-warning">Requires attention</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number">15</div>
          <div class="stat-label">Completed Today</div>
          <div class="stat-change text-success">+3 from yesterday</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-number">98%</div>
          <div class="stat-label">On-Time Delivery</div>
          <div class="stat-change text-success">Excellent performance</div>
        </div>
      </div>
    </div>

    <div class="custom-card mb-4">
      <h3 class="text-warning mb-3 fs-5">🚚 Delivery Status</h3>
      <div class="alert alert-info mb-3">
        <strong>Delivery in Progress:</strong> Branch Transfer - Main to SM Mall (ETA: 2:30 PM)
        <div class="small text-light mt-1">Driver: Juan Dela Cruz | Vehicle: Truck-001</div>
      </div>
      <div class="alert alert-warning">
        <strong>Pending Pickup:</strong> Supplier Delivery - Fresh Produce (Scheduled: 3:00 PM)
        <div class="small text-light mt-1">Supplier: Davao Fresh Foods | Items: 15 products</div>
      </div>
    </div>

    <div class="row g-3">
      <div class="col-md-3">
        <div class="action-btn h-100" onclick="alert('Schedule Delivery - Coming Soon')">
          <h5 class="mb-2">📅 Schedule Delivery</h5>
          <p class="small mb-0">Plan new delivery routes</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="action-btn h-100" onclick="alert('Track Deliveries - Coming Soon')">
          <h5 class="mb-2">📍 Track Deliveries</h5>
          <p class="small mb-0">Monitor active deliveries</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="action-btn h-100" onclick="alert('Route Optimization - Coming Soon')">
          <h5 class="mb-2">🗺️ Route Optimization</h5>
          <p class="small mb-0">Optimize delivery routes</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="action-btn h-100" onclick="alert('Logistics Reports - Coming Soon')">
          <h5 class="mb-2">📊 Logistics Reports</h5>
          <p class="small mb-0">View delivery analytics</p>
        </div>
      </div>
    </div>
  </main>
</div>

<?= $this->include('shared/footer') ?>