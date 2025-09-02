<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ChakaNoks SCMS - Complete System</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  
  <style>
    :root {
      --primary-gold: #ffd700;
      --secondary-gold: #ffb300;
      --dark-bg: rgba(0, 0, 0, 0.95);
      --card-bg: rgba(0, 0, 0, 0.95);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, var(--primary-gold) 0%, var(--secondary-gold) 100%);
      min-height: 100vh;
    }

    .main-container { display: flex; min-height: 100vh; }

    /* Sidebar Styling */
    .sidebar {
      width: 280px;
      background: var(--dark-bg);
      backdrop-filter: blur(10px);
      border-radius: 0 20px 20px 0;
      padding: 30px 0;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      position: fixed;
      height: 100vh;
      overflow-y: auto;
      z-index: 1000;
      transition: all 0.3s ease;
    }

    .logo { text-align: center; margin-bottom: 40px; }
    .logo h1 { color: var(--primary-gold); font-size: 28px; font-weight: bold; margin-bottom: 5px; }
    .logo p { color: #ffeb3b; font-size: 14px; }

    .nav-item {
      display: flex; align-items: center;
      padding: 15px 30px; color: #ffffff; text-decoration: none;
      transition: all 0.3s ease; margin: 2px 15px; border-radius: 12px;
      position: relative; cursor: pointer; border: none; background: none;
      width: calc(100% - 30px);
    }
    .nav-item:hover, .nav-item.active {
      background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold));
      color: #000000; transform: translateX(5px);
    }
    .nav-item i {
      width: 24px; height: 24px; margin-right: 15px;
      font-size: 18px; display: flex; align-items: center; justify-content: center;
    }

    /* Main Content */
    .main-content { 
      flex: 1; 
      padding: 30px; 
      margin-left: 280px;
      transition: all 0.3s ease;
    }

    .header {
      display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;
      background: var(--dark-bg); color: var(--primary-gold); padding: 20px 30px; border-radius: 20px;
      backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .header h2 { color: var(--primary-gold); font-size: 32px; font-weight: 600; }

    .user-info { display: flex; align-items: center; gap: 15px; }
    .user-avatar {
      width: 45px; height: 45px; border-radius: 50%;
      background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold));
      display: flex; align-items: center; justify-content: center; color: #000000; font-weight: bold;
    }

    /* Cards */
    .stat-card, .custom-card {
      background: var(--card-bg); color: #ffffff; padding: 25px; border-radius: 20px;
      backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      position: relative; overflow: hidden; cursor: pointer; transition: transform 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
      background: linear-gradient(90deg, var(--primary-gold), var(--secondary-gold));
    }
    .stat-number { font-size: 36px; font-weight: bold; color: var(--primary-gold); margin-bottom: 5px; }
    .stat-label { color: #ffffff; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
    .stat-change { margin-top: 10px; font-size: 14px; font-weight: 500; }
    .stat-change.text-success { color: #38a169; }
    .stat-change.text-danger { color: #e53e3e; }

    /* Bootstrap overrides for theme */
    .btn-primary {
      background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold));
      border: none;
      color: #000000;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(255, 215, 0, 0.4);
      background: linear-gradient(135deg, var(--secondary-gold), var(--primary-gold));
      color: #000000;
    }

    .btn-outline-primary {
      border-color: var(--primary-gold);
      color: var(--primary-gold);
    }
    .btn-outline-primary:hover {
      background: var(--primary-gold);
      border-color: var(--primary-gold);
      color: #000000;
    }

    .table-dark {
      background: var(--card-bg);
      color: #ffffff;
      border-radius: 15px;
      overflow: hidden;
    }
    .table-dark th {
      background: #1a1a1a;
      color: var(--primary-gold);
      border-color: #333333;
      font-weight: 600;
    }
    .table-dark td {
      border-color: #333333;
      color: #ffffff;
    }

    /* Status badges */
    .badge-critical { background: #ff4444; color: #ffffff; }
    .badge-low { background: #ff8800; color: #000000; }
    .badge-normal { background: var(--primary-gold); color: #000000; }
    .badge-high { background: #38a169; color: #ffffff; }
    .badge-active { background: #38a169; color: #ffffff; }
    .badge-pending { background: #666; color: var(--primary-gold); }
    .badge-delivered { background: var(--primary-gold); color: #000000; }
    .badge-transit { background: var(--secondary-gold); color: #000000; }

    /* Action buttons */
    .action-btn {
      background: var(--card-bg); color: #ffffff; border: 2px solid var(--primary-gold);
      border-radius: 15px; cursor: pointer; transition: all 0.3s ease; backdrop-filter: blur(10px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.3); text-align: center; padding: 20px;
    }
    .action-btn:hover {
      transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0,0,0,0.4);
      background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold)); color: #000000;
    }

    /* Page visibility */
    .page { display: none; }
    .page.active { display: block; }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        margin-left: -280px;
      }
      .sidebar.show {
        margin-left: 0;
      }
      .main-content {
        margin-left: 0;
        padding: 20px;
      }
    }

    /* Form styling */
    .form-control {
      background: rgba(0, 0, 0, 0.5);
      border: 1px solid rgba(255, 215, 0, 0.3);
      color: #ffffff;
      border-radius: 10px;
    }
    .form-control:focus {
      background: rgba(0, 0, 0, 0.5);
      border-color: var(--primary-gold);
      box-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
      color: #ffffff;
    }
    .form-label {
      color: var(--primary-gold);
      font-weight: 600;
    }

    /* Alert styling */
    .alert-warning {
      background: rgba(255, 68, 68, 0.2);
      border: 1px solid #ff4444;
      border-left: 4px solid #ff4444;
      color: #ffffff;
    }
    .alert-info {
      background: rgba(255, 136, 0, 0.2);
      border: 1px solid #ff8800;
      border-left: 4px solid #ff8800;
      color: #ffffff;
    }

    /* Franchise cards */
    .franchise-card {
      background: var(--card-bg);
      color: #ffffff;
      border-radius: 20px;
      padding: 25px;
      backdrop-filter: blur(10px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      border-left: 5px solid var(--primary-gold);
      transition: all 0.3s ease;
    }
    .franchise-card:hover {
      transform: translateX(5px);
      border-left-color: var(--secondary-gold);
    }

    /* Modal styling */
    .modal-content {
      background: var(--card-bg);
      color: #ffffff;
      border: 1px solid rgba(255, 215, 0, 0.3);
      border-radius: 20px;
    }
    .modal-header {
      border-bottom: 1px solid rgba(255, 215, 0, 0.3);
    }
    .modal-title {
      color: var(--primary-gold);
    }
    .btn-close {
      filter: invert(1);
    }
  </style>
</head>
<body>
  <div class="main-container">
    <!-- Mobile Toggle -->
    <button class="btn btn-primary d-md-none position-fixed top-0 start-0 m-3" style="z-index: 1100;" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
      <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar -->
    <nav class="sidebar offcanvas-md offcanvas-start" id="sidebar" tabindex="-1">
      <div class="logo">
        <h1>ChakaNoks</h1>
        <p>Supply Chain Management</p>
      </div>

      <div class="nav-item active" onclick="showPage('dashboard', this)">
        <i class="bi bi-grid-3x3-gap"></i>
        Dashboard
      </div>

      <div class="nav-item" onclick="showPage('inventory', this)">
        <i class="bi bi-box-seam"></i>
        Inventory Management
        <span class="badge bg-warning text-dark ms-auto">3</span>
      </div>

      <div class="nav-item" onclick="showPage('orders', this)">
        <i class="bi bi-cart"></i>
        Purchase Orders
        <span class="badge bg-warning text-dark ms-auto">5</span>
      </div>

      <div class="nav-item" onclick="showPage('suppliers', this)">
        <i class="bi bi-people"></i>
        Suppliers
      </div>

      <div class="nav-item" onclick="showPage('deliveries', this)">
        <i class="bi bi-truck"></i>
        Deliveries & Logistics
        <span class="badge bg-warning text-dark ms-auto">2</span>
      </div>

      <div class="nav-item" onclick="showPage('transfers', this)">
        <i class="bi bi-arrow-left-right"></i>
        Branch Transfers
      </div>

      <div class="nav-item" onclick="showPage('reports', this)">
        <i class="bi bi-bar-chart"></i>
        Reports & Analytics
      </div>

      <div class="nav-item" onclick="showPage('franchising', this)">
        <i class="bi bi-shop"></i>
        Franchising
        <span class="badge bg-warning text-dark ms-auto">4</span>
      </div>

      <div class="nav-item" onclick="showPage('users', this)">
        <i class="bi bi-person-gear"></i>
        User Management
      </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Dashboard Page -->
      <section id="dashboard" class="page active">
        <div class="header">
          <div>
            <h2>Supply Chain Dashboard</h2>
            <select class="form-select mt-2" style="width: 200px; background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 215, 0, 0.5); color: #ffd700;">
              <option>All Branches</option>
              <option>Davao - Main Branch</option>
              <option>Davao - SM Mall</option>
              <option>Davao - Abreeza</option>
              <option>Davao - Gaisano</option>
              <option>Davao - Victoria Plaza</option>
              <option>Tagum - New Branch</option>
            </select>
          </div>
          <div class="user-info">
            <div class="text-end">
              <div style="color:#ffd700;font-weight:600;">Central Admin</div>
              <div style="color:#ffffff;font-size:14px;">ChakaNoks HQ</div>
            </div>
            <div class="user-avatar">CA</div>
          </div>
        </div>

        <div class="row g-4 mb-4">
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-number">6</div>
              <div class="stat-label">Total Branches</div>
              <div class="stat-change text-success">+1 New Branch</div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-number">5</div>
              <div class="stat-label">Critical Stock Items</div>
              <div class="stat-change text-danger">+2 from yesterday</div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-number">₱125,450</div>
              <div class="stat-label">Pending Orders Value</div>
              <div class="stat-change text-success">-₱15,000 from last week</div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-number">3</div>
              <div class="stat-label">Active Deliveries</div>
              <div class="stat-change text-success">On schedule</div>
            </div>
          </div>
        </div>

        <div class="custom-card mb-4">
          <h3 class="text-warning mb-3 fs-5">⚠️ Critical Alerts</h3>
          <div class="alert alert-warning mb-3">
            <strong>Stock Out Alert:</strong> Davao Main Branch - Chicken completely out of stock
            <div class="small text-light mt-1">Emergency reorder required immediately</div>
          </div>
          <div class="alert alert-info">
            <strong>Low Stock Warning:</strong> SM Mall Branch - Rice stock below minimum threshold (2 units remaining)
            <div class="small text-light mt-1">Reorder recommended within 24 hours</div>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-md-3">
            <div class="action-btn h-100">
              <h5 class="mb-2">🛒 Create Purchase Order</h5>
              <p class="small mb-0">Generate new purchase orders for branches</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="action-btn h-100">
              <h5 class="mb-2">📦 Track Deliveries</h5>
              <p class="small mb-0">Monitor all active deliveries</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="action-btn h-100">
              <h5 class="mb-2">🔄 Branch Transfer</h5>
              <p class="small mb-0">Transfer stock between branches</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="action-btn h-100">
              <h5 class="mb-2">📊 Generate Report</h5>
              <p class="small mb-0">Create comprehensive analytics</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Inventory Page -->
      <section id="inventory" class="page">
        <div class="header">
          <h2>Inventory Management</h2>
          <div class="user-info">
            <div class="text-end">
              <div style="color:#ffd700;font-weight:600;">Central Admin</div>
              <div style="color:#ffffff;font-size:14px;">ChakaNoks HQ</div>
            </div>
            <div class="user-avatar">CA</div>
          </div>
        </div>

        <div class="row g-4 mb-4">
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-number">247</div>
              <div class="stat-label">Total Products</div>
              <div class="stat-change text-success">+12 this month</div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-number">5</div>
              <div class="stat-label">Critical Stock</div>
              <div class="stat-change text-danger">+2 from yesterday</div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-number">18</div>
              <div class="stat-label">Low Stock Items</div>
              <div class="stat-change text-danger">+5 this week</div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-number">₱2.1M</div>
              <div class="stat-label">Total Inventory Value</div>
              <div class="stat-change text-success">+8% this month</div>
            </div>
          </div>
        </div>

        <div class="row g-3 mb-4">
          <div class="col-md-3">
            <div class="action-btn h-100">
              <h5 class="mb-2">➕ Add New Product</h5>
              <p class="small mb-0">Register new inventory items</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="action-btn h-100">
              <h5 class="mb-2">📊 Stock Adjustment</h5>
              <p class="small mb-0">Adjust inventory quantities</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="action-btn h-100">
              <h5 class="mb-2">⚡ Reorder</h5>
              <p class="small mb-0">Set reorder points</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="action-btn h-100">
              <h5 class="mb-2">📋 Export Inventory</h5>
              <p class="small mb-0">Download inventory reports</p>
            </div>
          </div>
        </div>

        <div class="custom-card">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="text-warning">Current Inventory Status</h3>
            <div>
              <button class="btn btn-outline-primary me-2">Filter</button>
              <button class="btn btn-outline-primary">Export</button>
            </div>
          </div>
          
          <div class="table-responsive">
            <table class="table table-dark table-hover">
              <thead>
                <tr>
                  <th>Product Code</th>
                  <th>Product Name</th>
                  <th>Branch</th>
                  <th>Current Stock</th>
                  <th>Min. Level</th>
                  <th>Max. Level</th>
                  <th>Unit Price</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>CHK-001</td>
                  <td>Premium Chicken Breast</td>
                  <td>Main Branch</td>
                  <td>0 kg</td>
                  <td>50 kg</td>
                  <td>200 kg</td>
                  <td>₱320/kg</td>
                  <td><span class="badge badge-critical rounded-pill">Critical</span></td>
                  <td><button class="btn btn-danger btn-sm">Emergency Order</button></td>
                </tr>
                <tr>
                  <td>RIC-001</td>
                  <td>Jasmine Rice</td>
                  <td>SM Mall</td>
                  <td>2 sacks</td>
                  <td>10 sacks</td>
                  <td>50 sacks</td>
                  <td>₱2,800/sack</td>
                  <td><span class="badge badge-low rounded-pill">Low Stock</span></td>
                  <td><button class="btn btn-warning btn-sm">Reorder</button></td>
                </tr>
                <tr>
                  <td>PRK-001</td>
                  <td>Fresh Pork Belly</td>
                  <td>Abreeza</td>
                  <td>45 kg</td>
                  <td>25 kg</td>
                  <td>150 kg</td>
                  <td>₱380/kg</td>
                  <td><span class="badge badge-normal rounded-pill">Normal</span></td>
                  <td><button class="btn btn-primary btn-sm">Adjust</button></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Other pages would continue in similar Bootstrap format... -->
      <!-- For brevity, I'll show just the franchising page as an example -->

      <!-- Franchising Page -->
      <section id="franchising" class="page">
        <div class="header">
          <h2>Franchise Management System</h2>
          <div class="user-info">
            <div class="text-end">
              <div style="color:#ffd700;font-weight:600;">Franchise Director</div>
              <div style="color:#ffffff;font-size:14px;">ChakaNoks Corporate</div>
            </div>
            <div class="user-avatar">FD</div>
          </div>
        </div>

        <div class="row g-4 mb-4">
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-number">6</div>
              <div class="stat-label">Active Franchises</div>
              <div class="stat-change text-success">+1 This Quarter</div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-number">4</div>
              <div class="stat-label">Applications Pending</div>
              <div class="stat-change text-danger">Requires Review</div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-number">₱18.5M</div>
              <div class="stat-label">Total Franchise Revenue</div>
              <div class="stat-change text-success">+12% This Month</div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-card">
              <div class="stat-number">92%</div>
              <div class="stat-label">Average Performance Score</div>
              <div class="stat-change text-success">Excellent Standards</div>
            </div>
          </div>
        </div>

        <div class="row g-3 mb-4">
          <div class="col-md-3">
            <div class="action-btn h-100">
              <h5 class="mb-2">🏪 New Franchise Application</h5>
              <p class="small mb-0">Process new franchise requests</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="action-btn h-100">
              <h5 class="mb-2">📈 Performance Analytics</h5>
              <p class="small mb-0">Monitor franchise performance</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="action-btn h-100">
              <h5 class="mb-2">🎓 Training & Support</h5>
              <p class="small mb-0">Franchise training programs</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="action-btn h-100">
              <h5 class="mb-2">🗺️ Territory Management</h5>
              <p class="small mb-0">Manage franchise territories</p>
            </div>
          </div>
        </div>

        <h3 class="text-warning mb-4">🏪 Active Franchise Network</h3>

        <div class="row g-4">
          <div class="col-lg-6">
            <div class="franchise-card">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                  <h5 class="text-warning mb-1">ChakaNoks Davao Main</h5>
                  <small class="text-light">Franchise ID: FR-001 | Owner: Original Corporate Branch</small>
                </div>
                <span class="badge badge-active rounded-pill">Active</span>
              </div>
              <div class="row g-3">
                <div class="col-6">
                  <div class="d-flex justify-content-between p-2 rounded" style="background: rgba(255, 215, 0, 0.1);">
                    <span class="text-warning fw-medium">Monthly Revenue:</span>
                    <span class="text-white">₱850,000</span>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex justify-content-between p-2 rounded" style="background: rgba(255, 215, 0, 0.1);">
                    <span class="text-warning fw-medium">Performance:</span>
                    <span class="text-white">98%</span>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex justify-content-between p-2 rounded" style="background: rgba(255, 215, 0, 0.1);">
                    <span class="text-warning fw-medium">Compliance:</span>
                    <span class="text-white">Excellent</span>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex justify-content-between p-2 rounded" style="background: rgba(255, 215, 0, 0.1);">
                    <span class="text-warning fw-medium">Next Inspection:</span>
                    <span class="text-white">Sep 15, 2025</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-lg-6">
            <div class="franchise-card">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                  <h5 class="text-warning mb-1">ChakaNoks SM Mall Davao</h5>
                  <small class="text-light">Franchise ID: FR-002 | Owner: Jessica Tan</small>
                </div>
                <span class="badge badge-active rounded-pill">Active</span>
              </div>
              <div class="row g-3">
                <div class="col-6">
                  <div class="d-flex justify-content-between p-2 rounded" style="background: rgba(255, 215, 0, 0.1);">
                    <span class="text-warning fw-medium">Monthly Revenue:</span>
                    <span class="text-white">₱720,000</span>
                  </div>
                </div>
                <div class="col-6">