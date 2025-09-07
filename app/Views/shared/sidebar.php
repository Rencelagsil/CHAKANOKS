    <!-- Sidebar -->
    <nav class="sidebar offcanvas-md offcanvas-start" id="sidebar" tabindex="-1">
      <div class="logo">
        <h1>ChakaNoks</h1>
        <p>Supply Chain Management</p>
      </div>
      
      <div class="nav-section">
        <div class="nav-section-title">Navigation</div>

      <?php 
      $currentRole = session()->get('role');
      $currentPath = uri_string();
      ?>

      <?php if ($currentRole === 'admin'): ?>
        <!-- Admin Navigation -->
        <div class="nav-item <?= $currentPath === 'dashboard' ? 'active' : '' ?>" onclick="window.location.href='<?= base_url('dashboard') ?>'">
          <i class="bi bi-grid-3x3-gap"></i>
          Dashboard
        </div>

        <div class="nav-item" onclick="alert('Inventory Management - Coming Soon')">
          <i class="bi bi-box-seam"></i>
          Inventory Management
          <span class="badge bg-warning text-dark ms-auto">3</span>
        </div>

        <div class="nav-item" onclick="alert('Purchase Orders - Coming Soon')">
          <i class="bi bi-cart"></i>
          Purchase Orders
          <span class="badge bg-warning text-dark ms-auto">5</span>
        </div>

        <div class="nav-item" onclick="alert('Suppliers - Coming Soon')">
          <i class="bi bi-people"></i>
          Suppliers
        </div>

        <div class="nav-item" onclick="alert('Deliveries & Logistics - Coming Soon')">
          <i class="bi bi-truck"></i>
          Deliveries & Logistics
          <span class="badge bg-warning text-dark ms-auto">2</span>
        </div>

        <div class="nav-item" onclick="alert('Branch Transfers - Coming Soon')">
          <i class="bi bi-arrow-left-right"></i>
          Branch Transfers
        </div>

        <div class="nav-item" onclick="alert('Reports & Analytics - Coming Soon')">
          <i class="bi bi-bar-chart"></i>
          Reports & Analytics
        </div>

        <div class="nav-item" onclick="alert('Franchising - Coming Soon')">
          <i class="bi bi-shop"></i>
          Franchising
          <span class="badge bg-warning text-dark ms-auto">4</span>
        </div>

        <div class="nav-item" onclick="alert('User Management - Coming Soon')">
          <i class="bi bi-person-gear"></i>
          User Management
        </div>

      <?php elseif ($currentRole === 'branch_manager'): ?>
        <!-- Branch Manager Navigation -->
        <div class="nav-item <?= $currentPath === 'branchmanager' ? 'active' : '' ?>" onclick="window.location.href='<?= base_url('branchmanager') ?>'">
          <i class="bi bi-grid-3x3-gap"></i>
          Dashboard
        </div>

        <div class="nav-item <?= $currentPath === 'branchmanager/inventory' ? 'active' : '' ?>" onclick="window.location.href='<?= base_url('branchmanager/inventory') ?>'">
          <i class="bi bi-box-seam"></i>
          Inventory
        </div>

        <div class="nav-item <?= $currentPath === 'branchmanager/purchase-requests' ? 'active' : '' ?>" onclick="window.location.href='<?= base_url('branchmanager/purchase-requests') ?>'">
          <i class="bi bi-cart"></i>
          Purchase Req
        </div>

        <div class="nav-item <?= $currentPath === 'branchmanager/transfers' ? 'active' : '' ?>" onclick="window.location.href='<?= base_url('branchmanager/transfers') ?>'">
          <i class="bi bi-arrow-left-right"></i>
          Transfers
        </div>

        <div class="nav-item <?= $currentPath === 'branchmanager/reports' ? 'active' : '' ?>" onclick="window.location.href='<?= base_url('branchmanager/reports') ?>'">
          <i class="bi bi-bar-chart"></i>
          Reports
        </div>

      <?php elseif ($currentRole === 'inventory_staff'): ?>
        <!-- Inventory Staff Navigation -->
        <div class="nav-item <?= $currentPath === 'staff' ? 'active' : '' ?>" onclick="window.location.href='<?= base_url('staff') ?>'">
          <i class="bi bi-grid-3x3-gap"></i>
          Dashboard
        </div>

        <div class="nav-item <?= $currentPath === 'staff/stock-levels' ? 'active' : '' ?>" onclick="window.location.href='<?= base_url('staff/stock-levels') ?>'">
          <i class="bi bi-box-seam"></i>
          Stock Levels
        </div>

        <div class="nav-item <?= $currentPath === 'staff/deliveries' ? 'active' : '' ?>" onclick="window.location.href='<?= base_url('staff/deliveries') ?>'">
          <i class="bi bi-truck"></i>
          Deliveries
        </div>

        <div class="nav-item <?= $currentPath === 'staff/damages-expired' ? 'active' : '' ?>" onclick="window.location.href='<?= base_url('staff/damages-expired') ?>'">
          <i class="bi bi-exclamation-triangle"></i>
          Damaged/Expired
        </div>

        <div class="nav-item <?= $currentPath === 'staff/reports' ? 'active' : '' ?>" onclick="window.location.href='<?= base_url('staff/reports') ?>'">
          <i class="bi bi-bar-chart"></i>
          Reports
        </div>

      <?php elseif ($currentRole === 'logistics_coordinator'): ?>
        <!-- Logistics Coordinator Navigation -->
        <div class="nav-item <?= $currentPath === 'logistics' ? 'active' : '' ?>" onclick="window.location.href='<?= base_url('logistics') ?>'">
          <i class="bi bi-grid-3x3-gap"></i>
          Dashboard
        </div>

        <div class="nav-item" onclick="alert('Delivery Schedule - Coming Soon')">
          <i class="bi bi-calendar"></i>
          Delivery Schedule
        </div>

        <div class="nav-item" onclick="alert('Track Deliveries - Coming Soon')">
          <i class="bi bi-truck"></i>
          Track Deliveries
        </div>

        <div class="nav-item" onclick="alert('Route Optimization - Coming Soon')">
          <i class="bi bi-geo-alt"></i>
          Route Optimization
        </div>

        <div class="nav-item" onclick="alert('Reports - Coming Soon')">
          <i class="bi bi-bar-chart"></i>
          Reports
        </div>

      <?php endif; ?>
      </div>

      <div class="logout" onclick="logout()">
        <i class="bi bi-box-arrow-right"></i>
        Logout
      </div>
    </nav>

