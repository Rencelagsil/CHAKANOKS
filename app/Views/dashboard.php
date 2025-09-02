<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ChakaNoks SCMS - Complete System</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #ffd700 0%, #ffb300 100%);
      min-height: 100vh;
    }

    .container { display: flex; min-height: 100vh; }

    /* Sidebar */
    .sidebar {
      width: 280px;
      background: rgba(0, 0, 0, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 0 20px 20px 0;
      padding: 30px 0;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .logo { text-align: center; margin-bottom: 40px; }
    .logo h1 { color: #ffd700; font-size: 28px; font-weight: bold; margin-bottom: 5px; }
    .logo p { color: #ffeb3b; font-size: 14px; }

    .nav-item {
      display: flex; align-items: center;
      padding: 15px 30px; color: #ffffff; text-decoration: none;
      transition: all 0.3s ease; margin: 2px 15px; border-radius: 12px;
      position: relative; cursor: pointer;
    }
    .nav-item:hover, .nav-item.active {
      background: linear-gradient(135deg, #ffd700, #ffb300);
      color: #000000; transform: translateX(5px);
    }
    .nav-item i {
      width: 24px; height: 24px; margin-right: 15px; background: currentColor;
      mask-size: contain; mask-repeat: no-repeat;
    }
    .notification-badge {
      background: #ffd700; color: #000000; border-radius: 50%;
      width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;
      font-size: 12px; font-weight: bold; margin-left: auto;
    }

    /* Main Content */
    .main-content { flex: 1; padding: 30px; }

    .header {
      display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;
      background: rgba(0, 0, 0, 0.95); color: #ffd700; padding: 20px 30px; border-radius: 20px;
      backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .header h2 { color: #ffd700; font-size: 32px; font-weight: 600; }

    .user-info { display: flex; align-items: center; gap: 15px; }
    .user-avatar {
      width: 45px; height: 45px; border-radius: 50%;
      background: linear-gradient(135deg, #ffd700, #ffb300);
      display: flex; align-items: center; justify-content: center; color: #000000; font-weight: bold;
    }

    /* Stats Cards */
    .stats-grid {
      display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px; margin-bottom: 30px;
    }
    .stat-card {
      background: rgba(0, 0, 0, 0.95); color: #ffffff; padding: 25px; border-radius: 20px;
      backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      position: relative; overflow: hidden; cursor: pointer; transition: transform 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
      background: linear-gradient(90deg, #ffd700, #ffb300);
    }
    .stat-number { font-size: 36px; font-weight: bold; color: #ffd700; margin-bottom: 5px; }
    .stat-label { color: #ffffff; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
    .stat-change { margin-top: 10px; font-size: 14px; font-weight: 500; }
    .stat-change.positive { color: #38a169; }
    .stat-change.negative { color: #e53e3e; }

    /* Content Grid */
    .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-bottom: 30px; }

    /* Cards/Tables */
    .card {
      background: rgba(0, 0, 0, 0.95); color: #ffffff; border-radius: 20px;
      backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.3); overflow: hidden;
    }
    .card-header {
      padding: 25px 30px; background: linear-gradient(135deg, #ffd700, #ffb300);
      color: #000000; display: flex; justify-content: space-between; align-items: center;
    }
    .card-title { font-size: 20px; font-weight: 600; }
    .card-actions { display: flex; gap: 10px; }
    .btn { padding: 8px 16px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 500; transition: all 0.3s ease; }
    .btn-primary { background: rgba(0, 0, 0, 0.3); color: #000000; border: 1px solid rgba(0, 0, 0, 0.5); }
    .btn-primary:hover { background: rgba(0, 0, 0, 0.5); color: #ffd700; }

    .table-container { max-height: 400px; overflow-y: auto; }
    .table { width: 100%; border-collapse: collapse; }
    .table th {
      background: #1a1a1a; padding: 15px 20px; text-align: left; font-weight: 600;
      color: #ffd700; border-bottom: 2px solid #333333; position: sticky; top: 0;
    }
    .table td { padding: 15px 20px; border-bottom: 1px solid #333333; color: #ffffff; }
    .table tr:hover { background: #1a1a1a; }

    /* Status Badges */
    .status-badge {
      padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;
      text-transform: uppercase; letter-spacing: 0.5px;
    }
    .status-delivered { background: #ffd700; color: #000000; }
    .status-transit { background: #ffb300; color: #000000; }
    .status-pending { background: #333333; color: #ffd700; }
    .status-critical { background: #ff4444; color: #ffffff; }
    .status-low { background: #ff8800; color: #000000; }
    .status-normal { background: #ffd700; color: #000000; }
    .status-approved { background: #38a169; color: #ffffff; }
    .status-active { background: #38a169; color: #ffffff; }
    .status-inactive { background: #666; color: #ffffff; }
    .status-reviewing { background: #3182ce; color: #ffffff; }
    .status-under-construction { background: #805ad5; color: #ffffff; }
    .status-high { background: #38a169; color: #ffffff; }
    .status-medium { background: #ffd700; color: #000000; }

    /* Role Badges */
    .role-badge { padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .role-branch-manager { background: #f39c12; color: #000000; }
    .role-inventory-staff { background: #3498db; color: #ffffff; }
    .role-central-admin { background: #e74c3c; color: #ffffff; }
    .role-supplier { background: #8e44ad; color: #ffffff; }
    .role-logistics-coordinator { background: #16a085; color: #ffffff; }
    .role-franchise-manager { background: #d35400; color: #ffffff; }
    .role-system-admin { background: #2c3e50; color: #ffffff; }

    /* Quick Actions */
    .quick-actions {
      display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px; margin-bottom: 30px;
    }
    .action-btn {
      padding: 20px; background: rgba(0, 0, 0, 0.95); color: #ffffff; border: 2px solid #ffd700;
      border-radius: 15px; cursor: pointer; transition: all 0.3s ease; backdrop-filter: blur(10px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.3); text-align: center;
    }
    .action-btn:hover {
      transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0,0,0,0.4);
      background: linear-gradient(135deg, #ffd700, #ffb300); color: #000000;
    }
    .action-btn h4 { color: inherit; margin-bottom: 8px; font-size: 16px; }
    .action-btn p { color: inherit; font-size: 14px; opacity: 0.8; }
    .action-btn:hover h4, .action-btn:hover p { color: #000000; opacity: 1; }

    /* Forms */
    .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 30px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; color: #ffd700; margin-bottom: 8px; font-weight: 600; }
    .form-group input, .form-group select, .form-group textarea {
      width: 100%; padding: 12px 15px; border: 1px solid rgba(255, 215, 0, 0.3); border-radius: 10px;
      background: rgba(0, 0, 0, 0.5); color: #ffffff; font-size: 14px;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
      outline: none; border-color: #ffd700; box-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
    }
    .form-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }

    /* Franchise cards */
    .franchise-card {
      background: rgba(0, 0, 0, 0.95); color: #ffffff; border-radius: 20px; padding: 25px; margin-bottom: 20px;
      backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      border-left: 5px solid #ffd700; transition: all 0.3s ease;
    }
    .franchise-card:hover { transform: translateX(5px); border-left-color: #ffb300; }
    .franchise-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
    .franchise-name { font-size: 20px; font-weight: 600; color: #ffd700; }
    .franchise-id { font-size: 14px; color: #cccccc; }
    .franchise-details { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 15px; }
    .detail-item { display: flex; justify-content: space-between; padding: 10px; background: rgba(255, 215, 0, 0.1); border-radius: 8px; }
    .detail-label { color: #ffd700; font-weight: 500; }
    .detail-value { color: #ffffff; }

    /* Pages */
    .page { display: none; }
    .page.active { display: block; }

    /* Mobile */
    .mobile-toggle {
      display: none; position: fixed; top: 20px; left: 20px; z-index: 1000;
      background: rgba(255, 215, 0, 0.9); border: none; border-radius: 50%;
      width: 50px; height: 50px; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .mobile-overlay {
      display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.5); z-index: 998;
    }

    @media (max-width: 768px) {
      .mobile-toggle { display: flex; align-items: center; justify-content: center; }
      .sidebar {
        position: fixed; left: -300px; top: 0; height: 100vh; width: 280px;
        z-index: 999; transition: left 0.3s ease; border-radius: 0;
      }
      .sidebar.active { left: 0; }
      .mobile-overlay.active { display: block; }
      .main-content { padding: 80px 20px 20px; width: 100%; }
      .header { flex-direction: column; gap: 15px; align-items: flex-start; padding: 20px; }
      .header h2 { font-size: 24px; }
      .stats-grid { grid-template-columns: repeat(2, 1fr); }
      .content-grid { grid-template-columns: 1fr; }
      .form-grid { grid-template-columns: 1fr; }
      .franchise-details { grid-template-columns: 1fr; }
      .form-row { grid-template-columns: 1fr; }
    }

    @media (max-width: 480px) {
      .stats-grid { grid-template-columns: 1fr; }
      .quick-actions { grid-template-columns: 1fr; }
    }

    /* Modal */
    .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); }
    .modal-content {
      background: rgba(0,0,0,0.95); color: #fff; border-radius: 12px; width: 95%; max-width: 720px; margin: 60px auto; padding: 24px;
      border: 1px solid rgba(255,215,0,0.3); box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    }
    .modal-content h3 { color: #ffd700; margin-bottom: 16px; }
    .close { float: right; font-size: 28px; color: #ffd700; cursor: pointer; }
    .btn-success { background: #38a169; color: #fff; padding: 10px 16px; border-radius: 8px; border: none; cursor: pointer; }
    .btn-success:hover { filter: brightness(1.05); }
    .btn-cancel { background: #4a5568; color: #fff; padding: 10px 16px; border-radius: 8px; border: none; cursor: pointer; }

    /* Reports specific */
    .report-controls {
      background: rgba(0, 0, 0, 0.95);
      padding: 25px 30px;
      border-radius: 20px;
      margin-bottom: 30px;
      backdrop-filter: blur(10px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .control-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      align-items: end;
    }
    .control-group { display: flex; flex-direction: column; }
    .control-group label {
      color: #ffd700;
      font-weight: 600;
      margin-bottom: 8px;
      font-size: 14px;
    }
    .control-group select, .control-group input {
      padding: 12px 15px;
      border: 1px solid rgba(255, 215, 0, 0.3);
      border-radius: 10px;
      background: rgba(0, 0, 0, 0.5);
      color: #ffffff;
      font-size: 14px;
    }
    .control-group select:focus, .control-group input:focus {
      outline: none; border-color: #ffd700; box-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
    }
    .generate-btn {
      padding: 12px 25px;
      background: linear-gradient(135deg, #ffd700, #ffb300);
      color: #000000;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
      font-size: 14px;
    }
    .generate-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 215, 0, 0.4); }
    .charts-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-bottom: 30px; }
    .chart-card { background: rgba(0, 0, 0, 0.95); border-radius: 20px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.3); overflow: hidden; }
    .chart-header { padding: 25px 30px; background: linear-gradient(135deg, #ffd700, #ffb300); color: #000000; display: flex; justify-content: space-between; align-items: center; }
    .chart-title { font-size: 20px; font-weight: 600; }
    .chart-content { padding: 30px; height: 400px; display: flex; align-items: center; justify-content: center; color: #ffffff; }
    .chart-placeholder {
      background: linear-gradient(45deg, #333, #444);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      height: 100%; font-size: 18px; color: #ffd700; text-align: center;
    }
    .loading { display: none; text-align: center; color: #ffd700; font-size: 18px; }
    .loading.active { display: block; }
    .report-table-card {
      background: rgba(0, 0, 0, 0.95);
      border-radius: 20px;
      backdrop-filter: blur(10px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      overflow: hidden;
      margin-bottom: 30px;
    }
    .table-header {
      padding: 25px 30px;
      background: linear-gradient(135deg, #ffd700, #ffb300);
      color: #000000;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .table-title { font-size: 20px; font-weight: 600; }
    .export-buttons { display: flex; gap: 10px; }
    .btn-export { background: rgba(0, 0, 0, 0.3); color: #000000; border: 1px solid rgba(0, 0, 0, 0.5); }
    .btn-export:hover { background: rgba(0, 0, 0, 0.5); color: #ffd700; }
  </style>
</head>
<body>
  <div class="container">
    <!-- Mobile Toggle -->
    <button class="mobile-toggle" onclick="toggleSidebar()">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="#000"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
    </button>
    <div class="mobile-overlay" id="mobileOverlay" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
      <div class="logo">
        <h1>ChakaNoks</h1>
        <p>Supply Chain Management</p>
      </div>

      <div class="nav-item active" onclick="showPage('dashboard', this)">
        <i style="mask-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22currentColor%22><path d=%22M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z%22/></svg>')"></i>
        Dashboard
      </div>

      <div class="nav-item" onclick="showPage('inventory', this)">
        <i style="mask-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22currentColor%22><path d=%22M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8 12.5v-9l6 4.5-6 4.5z%22/></svg>')"></i>
        Inventory Management
        <span class="notification-badge">3</span>
      </div>

      <div class="nav-item" onclick="showPage('orders', this)">
        <i style="mask-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22currentColor%22><path d=%22M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03L21.7 4H5.21l-.94-2H1zm16 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z%22/></svg>')"></i>
        Purchase Orders
        <span class="notification-badge">5</span>
      </div>

      <div class="nav-item" onclick="showPage('suppliers', this)">
        <i style="mask-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22currentColor%22><path d=%22M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z%22/></svg>')"></i>
        Suppliers
      </div>

      <div class="nav-item" onclick="showPage('deliveries', this)">
        <i style="mask-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22currentColor%22><path d=%22M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.22.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z%22/></svg>')"></i>
        Deliveries & Logistics
        <span class="notification-badge">2</span>
      </div>

      <div class="nav-item" onclick="showPage('transfers', this)">
        <i style="mask-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22currentColor%22><path d=%22M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z%22/></svg>')"></i>
        Branch Transfers
      </div>

      <div class="nav-item" onclick="showPage('reports', this)">
        <i style="mask-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22currentColor%22><path d=%22M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z%22/></svg>')"></i>
        Reports & Analytics
      </div>

      <div class="nav-item" onclick="showPage('franchising', this)">
        <i style="mask-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22currentColor%22><path d=%22M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z%22/></svg>')"></i>
        Franchising
        <span class="notification-badge">4</span>
      </div>

      <div class="nav-item" onclick="showPage('users', this)">
        <i style="mask-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22currentColor%22><path d=%22M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z%22/></svg>')"></i>
        User Management
      </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Dashboard -->
      <section id="dashboard" class="page active">
        <div class="header">
          <div>
            <h2>Supply Chain Dashboard</h2>
            <select style="background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 215, 0, 0.5); padding: 10px 15px; border-radius: 10px; color: #ffd700;">
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
            <div>
              <div style="color:#ffd700;font-weight:600;">Central Admin</div>
              <div style="color:#ffffff;font-size:14px;">ChakaNoks HQ</div>
            </div>
            <div class="user-avatar">CA</div>
          </div>
        </div>

        <div class="stats-grid">
          <div class="stat-card"><div class="stat-number">6</div><div class="stat-label">Total Branches</div><div class="stat-change positive">+1 New Branch</div></div>
          <div class="stat-card"><div class="stat-number">5</div><div class="stat-label">Critical Stock Items</div><div class="stat-change negative">+2 from yesterday</div></div>
          <div class="stat-card"><div class="stat-number">₱125,450</div><div class="stat-label">Pending Orders Value</div><div class="stat-change positive">-₱15,000 from last week</div></div>
          <div class="stat-card"><div class="stat-number">3</div><div class="stat-label">Active Deliveries</div><div class="stat-change positive">On schedule</div></div>
        </div>

        <div style="background: rgba(0,0,0,0.95); color:#fff; border-radius:20px; padding:25px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.3); margin-bottom:30px;">
          <h3 style="color:#ffd700; margin-bottom:20px; font-size:20px;">⚠️ Critical Alerts</h3>
          <div style="display:flex; align-items:center; padding:15px; margin-bottom:10px; border-radius:12px; border-left:4px solid #ff4444; background: rgba(255,68,68,0.2);">
            <div>
              <strong>Stock Out Alert:</strong> Davao Main Branch - Chicken completely out of stock
              <div style="font-size:12px; color:#ccc; margin-top:5px;">Emergency reorder required immediately</div>
            </div>
          </div>
          <div style="display:flex; align-items:center; padding:15px; margin-bottom:10px; border-radius:12px; border-left:4px solid #ff8800; background: rgba(255,136,0,0.2);">
            <div>
              <strong>Low Stock Warning:</strong> SM Mall Branch - Rice stock below minimum threshold (2 units remaining)
              <div style="font-size:12px; color:#ccc; margin-top:5px;">Reorder recommended within 24 hours</div>
            </div>
          </div>
        </div>

        <div class="quick-actions">
          <button class="action-btn" onclick="alert('Creating Purchase Order...')"><h4>🛒 Create Purchase Order</h4><p>Generate new purchase orders for branches</p></button>
          <button class="action-btn" onclick="alert('Tracking Deliveries...')"><h4>📦 Track Deliveries</h4><p>Monitor all active deliveries</p></button>
          <button class="action-btn" onclick="alert('Initiating Branch Transfer...')"><h4>🔄 Branch Transfer</h4><p>Transfer stock between branches</p></button>
          <button class="action-btn" onclick="alert('Generating Report...')"><h4>📊 Generate Report</h4><p>Create comprehensive analytics</p></button>
        </div>
      </section>

      <!-- Inventory -->
      <section id="inventory" class="page">
        <div class="header">
          <h2>Inventory Management</h2>
          <div class="user-info">
            <div><div style="color:#ffd700;font-weight:600;">Central Admin</div><div style="color:#ffffff;font-size:14px;">ChakaNoks HQ</div></div>
            <div class="user-avatar">CA</div>
          </div>
        </div>

        <div class="stats-grid">
          <div class="stat-card"><div class="stat-number">247</div><div class="stat-label">Total Products</div><div class="stat-change positive">+12 this month</div></div>
          <div class="stat-card"><div class="stat-number">5</div><div class="stat-label">Critical Stock</div><div class="stat-change negative">+2 from yesterday</div></div>
          <div class="stat-card"><div class="stat-number">18</div><div class="stat-label">Low Stock Items</div><div class="stat-change negative">+5 this week</div></div>
          <div class="stat-card"><div class="stat-number">₱2.1M</div><div class="stat-label">Total Inventory Value</div><div class="stat-change positive">+8% this month</div></div>
        </div>

        <div class="quick-actions">
          <button class="action-btn"><h4>➕ Add New Product</h4><p>Register new inventory items</p></button>
          <button class="action-btn"><h4>📊 Stock Adjustment</h4><p>Adjust inventory quantities</p></button>
          <button class="action-btn"><h4>⚡ Auto-Reorder</h4><p>Set automatic reorder points</p></button>
          <button class="action-btn"><h4>📋 Export Inventory</h4><p>Download inventory reports</p></button>
        </div>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Current Inventory Status</h3>
            <div class="card-actions">
              <button class="btn btn-primary">Filter</button>
              <button class="btn btn-primary">Export</button>
            </div>
          </div>
          <div class="table-container">
            <table class="table">
              <thead>
                <tr>
                  <th>Product Code</th><th>Product Name</th><th>Branch</th><th>Current Stock</th>
                  <th>Min. Level</th><th>Max. Level</th><th>Unit Price</th><th>Status</th><th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>CHK-001</td><td>Premium Chicken Breast</td><td>Main Branch</td><td>0 kg</td>
                  <td>50 kg</td><td>200 kg</td><td>₱320/kg</td><td><span class="status-badge status-critical">Critical</span></td>
                  <td><button class="btn btn-primary" style="background:#e53e3e;">Emergency Order</button></td>
                </tr>
                <tr>
                  <td>RIC-001</td><td>Jasmine Rice</td><td>SM Mall</td><td>2 sacks</td>
                  <td>10 sacks</td><td>50 sacks</td><td>₱2,800/sack</td><td><span class="status-badge status-low">Low Stock</span></td>
                  <td><button class="btn btn-primary" style="background:#dd6b20;">Reorder</button></td>
                </tr>
                <tr>
                  <td>PRK-001</td><td>Fresh Pork Belly</td><td>Abreeza</td><td>45 kg</td>
                  <td>25 kg</td><td>150 kg</td><td>₱380/kg</td><td><span class="status-badge status-normal">Normal</span></td>
                  <td><button class="btn btn-primary">Adjust</button></td>
                </tr>
                <tr>
                  <td>OIL-001</td><td>Cooking Oil</td><td>Gaisano</td><td>3 gallons</td>
                  <td>15 gallons</td><td>60 gallons</td><td>₱180/gallon</td><td><span class="status-badge status-low">Low Stock</span></td>
                  <td><button class="btn btn-primary" style="background:#dd6b20;">Reorder</button></td>
                </tr>
                <tr>
                  <td>SAU-001</td><td>Special Sauce Mix</td><td>Victoria Plaza</td><td>25 bottles</td>
                  <td>20 bottles</td><td>100 bottles</td><td>₱85/bottle</td><td><span class="status-badge status-normal">Normal</span></td>
                  <td><button class="btn btn-primary">Adjust</button></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Orders -->
      <section id="orders" class="page">
        <div class="header">
          <h2>Purchase Orders Management</h2>
          <div class="user-info">
            <div><div style="color:#ffd700;font-weight:600;">Central Admin</div><div style="color:#ffffff;font-size:14px;">ChakaNoks HQ</div></div>
            <div class="user-avatar">CA</div>
          </div>
        </div>

        <div class="stats-grid">
          <div class="stat-card"><div class="stat-number">12</div><div class="stat-label">Pending Orders</div><div class="stat-change negative">+3 from yesterday</div></div>
          <div class="stat-card"><div class="stat-number">8</div><div class="stat-label">Approved Orders</div><div class="stat-change positive">Processing</div></div>
          <div class="stat-card"><div class="stat-number">₱185,750</div><div class="stat-label">Total Order Value</div><div class="stat-change positive">+₱25,300 today</div></div>
          <div class="stat-card"><div class="stat-number">3</div><div class="stat-label">Emergency Orders</div><div class="stat-change negative">Requires attention</div></div>
        </div>

        <div class="quick-actions">
          <button class="action-btn"><h4>🛒 New Purchase Order</h4><p>Create new purchase orders</p></button>
          <button class="action-btn"><h4>✅ Approve Orders</h4><p>Review and approve pending orders</p></button>
          <button class="action-btn"><h4>🔍 Track Orders</h4><p>Monitor order status</p></button>
          <button class="action-btn"><h4>📊 Order Reports</h4><p>Generate purchase reports</p></button>
        </div>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Purchase Orders</h3>
            <div class="card-actions">
              <button class="btn btn-primary">Filter Status</button>
              <button class="btn btn-primary">Export</button>
            </div>
          </div>
          <div class="table-container">
            <table class="table">
              <thead>
                <tr>
                  <th>PO Number</th><th>Branch</th><th>Supplier</th><th>Order Date</th>
                  <th>Expected Delivery</th><th>Total Amount</th><th>Status</th><th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><strong>PO-2025-001</strong></td><td>Main Branch</td><td>ABC Foods Supply</td>
                  <td>Aug 13, 2025</td><td>Aug 15, 2025</td><td>₱45,200</td>
                  <td><span class="status-badge status-pending">Pending</span></td>
                  <td><button class="btn btn-primary">Approve</button></td>
                </tr>
                <tr>
                  <td><strong>PO-2025-002</strong></td><td>SM Mall</td><td>Fresh Meat Co.</td>
                  <td>Aug 12, 2025</td><td>Aug 14, 2025</td><td>₱32,850</td>
                  <td><span class="status-badge status-approved">Approved</span></td>
                  <td><button class="btn btn-primary">Track</button></td>
                </tr>
                <tr>
                  <td><strong>PO-2025-003</strong></td><td>Abreeza</td><td>Golden Rice Trading</td>
                  <td>Aug 11, 2025</td><td>Aug 13, 2025</td><td>₱28,400</td>
                  <td><span class="status-badge status-transit">In Transit</span></td>
                  <td><button class="btn btn-primary">View</button></td>
                </tr>
                <tr>
                  <td><strong>PO-2025-004</strong></td><td>Gaisano</td><td>Premium Oil Suppliers</td>
                  <td>Aug 12, 2025</td><td>₱15,750</td>
                  <td><span class="status-badge status-delivered">Delivered</span></td>
                  <td><button class="btn btn-primary">Receipt</button></td>
                </tr>
                <tr>
                  <td><strong>PO-2025-005</strong></td><td>Victoria Plaza</td><td>Specialty Sauce Inc.</td>
                  <td>Aug 13, 2025</td><td>Aug 16, 2025</td><td>₱8,950</td>
                  <td><span class="status-badge status-pending">Pending</span></td>
                  <td><button class="btn btn-primary">Approve</button></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Suppliers -->
      <section id="suppliers" class="page">
        <div class="header">
          <h2>Supplier Management</h2>
          <div class="user-info">
            <div><div style="color:#ffd700;font-weight:600;">Central Admin</div><div style="color:#ffffff;font-size:14px;">ChakaNoks HQ</div></div>
            <div class="user-avatar">CA</div>
          </div>
        </div>

        <div class="stats-grid">
          <div class="stat-card"><div class="stat-number">24</div><div class="stat-label">Active Suppliers</div><div class="stat-change positive">+2 this month</div></div>
          <div class="stat-card"><div class="stat-number">3</div><div class="stat-label">Preferred Suppliers</div><div class="stat-change positive">High Performance</div></div>
          <div class="stat-card"><div class="stat-number">98.5%</div><div class="stat-label">On-Time Delivery Rate</div><div class="stat-change positive">+2.1% this month</div></div>
          <div class="stat-card"><div class="stat-number">4.8</div><div class="stat-label">Average Rating</div><div class="stat-change positive">Excellent</div></div>
        </div>

        <div class="quick-actions">
          <button class="action-btn"><h4>➕ Add Supplier</h4><p>Register new suppliers</p></button>
          <button class="action-btn"><h4>📊 Supplier Performance</h4><p>View performance metrics</p></button>
          <button class="action-btn"><h4>💰 Price Comparison</h4><p>Compare supplier prices</p></button>
          <button class="action-btn"><h4>📋 Contracts</h4><p>Manage supplier contracts</p></button>
        </div>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Supplier Directory</h3>
            <div class="card-actions">
              <button class="btn btn-primary">Filter</button>
              <button class="btn btn-primary">Export</button>
            </div>
          </div>
          <div class="table-container">
            <table class="table">
              <thead>
                <tr>
                  <th>Supplier Name</th><th>Category</th><th>Contact Person</th><th>Phone</th>
                  <th>Email</th><th>On-Time Rate</th><th>Rating</th><th>Status</th><th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><strong>ABC Foods Supply</strong></td><td>Meat Products</td><td>Juan Santos</td>
                  <td>(082) 123-4567</td><td>juan@abcfoods.com</td><td>99.2%</td><td>4.9⭐</td>
                  <td><span class="status-badge status-active">Active</span></td><td><button class="btn btn-primary">View</button></td>
                </tr>
                <tr>
                  <td><strong>Fresh Meat Co.</strong></td><td>Fresh Meat</td><td>Maria Cruz</td>
                  <td>(082) 234-5678</td><td>maria@freshmeat.com</td><td>97.8%</td><td>4.7⭐</td>
                  <td><span class="status-badge status-active">Active</span></td><td><button class="btn btn-primary">View</button></td>
                </tr>
                <tr>
                  <td><strong>Golden Rice Trading</strong></td><td>Rice & Grains</td><td>Roberto Lim</td>
                  <td>(082) 345-6789</td><td>roberto@goldenrice.com</td><td>98.5%</td><td>4.8⭐</td>
                  <td><span class="status-badge status-active">Active</span></td><td><button class="btn btn-primary">View</button></td>
                </tr>
                <tr>
                  <td><strong>Premium Oil Suppliers</strong></td><td>Cooking Oil</td><td>Anna Reyes</td>
                  <td>(082) 456-7890</td><td>anna@premiumoil.com</td><td>96.3%</td><td>4.6⭐</td>
                  <td><span class="status-badge status-active">Active</span></td><td><button class="btn btn-primary">View</button></td>
                </tr>
                <tr>
                  <td><strong>Specialty Sauce Inc.</strong></td><td>Sauces & Condiments</td><td>Carlos Mendez</td>
                  <td>(082) 567-8901</td><td>carlos@specialtysauce.com</td><td>94.7%</td><td>4.4⭐</td>
                  <td><span class="status-badge status-active">Active</span></td><td><button class="btn btn-primary">View</button></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Deliveries -->
      <section id="deliveries" class="page">
        <div class="header">
          <h2>Deliveries & Logistics</h2>
          <div class="user-info">
            <div><div style="color:#ffd700;font-weight:600;">Central Admin</div><div style="color:#ffffff;font-size:14px;">ChakaNoks HQ</div></div>
            <div class="user-avatar">CA</div>
          </div>
        </div>

        <div class="stats-grid">
          <div class="stat-card"><div class="stat-number">8</div><div class="stat-label">Active Deliveries</div><div class="stat-change positive">On schedule</div></div>
          <div class="stat-card"><div class="stat-number">15</div><div class="stat-label">Completed Today</div><div class="stat-change positive">+3 from yesterday</div></div>
          <div class="stat-card"><div class="stat-number">2</div><div class="stat-label">Delayed Shipments</div><div class="stat-change negative">Requires attention</div></div>
          <div class="stat-card"><div class="stat-number">96.8%</div><div class="stat-label">On-Time Delivery Rate</div><div class="stat-change positive">Above target</div></div>
        </div>

        <div class="quick-actions">
          <button class="action-btn"><h4>🚚 Schedule Delivery</h4><p>Plan new delivery routes</p></button>
          <button class="action-btn"><h4>📍 Live Tracking</h4><p>Track deliveries in real-time</p></button>
          <button class="action-btn"><h4>🗺️ Route Optimization</h4><p>Optimize delivery routes</p></button>
          <button class="action-btn"><h4>📦 Delivery History</h4><p>View past deliveries</p></button>
        </div>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Active Deliveries</h3>
            <div class="card-actions">
              <button class="btn btn-primary">Track All</button>
              <button class="btn btn-primary">Export</button>
            </div>
          </div>
          <div class="table-container">
            <table class="table">
              <thead>
              <tr>
                <th>Delivery ID</th><th>Destination</th><th>Driver</th><th>Items</th>
                <th>Departure Time</th><th>ETA</th><th>Status</th><th>Actions</th>
              </tr>
              </thead>
              <tbody>
              <tr><td><strong>DEL-001</strong></td><td>Main Branch</td><td>Pedro Garcia</td><td>Chicken, Rice (PO-2025-001)</td><td>8:30 AM</td><td>10:45 AM</td><td><span class="status-badge status-transit">In Transit</span></td><td><button class="btn btn-primary">Track</button></td></tr>
              <tr><td><strong>DEL-002</strong></td><td>SM Mall</td><td>Miguel Santos</td><td>Fresh Meat (PO-2025-002)</td><td>9:15 AM</td><td>11:30 AM</td><td><span class="status-badge status-transit">In Transit</span></td><td><button class="btn btn-primary">Track</button></td></tr>
              <tr><td><strong>DEL-003</strong></td><td>Abreeza</td><td>Jose Ramirez</td><td>Rice Supplies</td><td>7:45 AM</td><td>9:30 AM</td><td><span class="status-badge status-delivered">Delivered</span></td><td><button class="btn btn-primary">Receipt</button></td></tr>
              <tr><td><strong>DEL-004</strong></td><td>Gaisano</td><td>Luis Cruz</td><td>Cooking Oil</td><td>10:00 AM</td><td>12:15 PM</td><td><span class="status-badge status-pending">Preparing</span></td><td><button class="btn btn-primary">Schedule</button></td></tr>
              <tr><td><strong>DEL-005</strong></td><td>Victoria Plaza</td><td>Antonio Flores</td><td>Sauce Mix</td><td>11:30 AM</td><td>1:45 PM</td><td><span class="status-badge status-pending">Preparing</span></td><td><button class="btn btn-primary">Schedule</button></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Transfers -->
      <section id="transfers" class="page">
        <div class="header">
          <h2>Branch Transfers</h2>
          <div class="user-info">
            <div><div style="color:#ffd700;font-weight:600;">Central Admin</div><div style="color:#ffffff;font-size:14px;">ChakaNoks HQ</div></div>
            <div class="user-avatar">CA</div>
          </div>
        </div>

        <div class="stats-grid">
          <div class="stat-card"><div class="stat-number">12</div><div class="stat-label">Pending Transfers</div><div class="stat-change negative">+4 from yesterday</div></div>
          <div class="stat-card"><div class="stat-number">8</div><div class="stat-label">Active Transfers</div><div class="stat-change positive">In progress</div></div>
          <div class="stat-card"><div class="stat-number">45</div><div class="stat-label">Completed This Month</div><div class="stat-change positive">+12% from last month</div></div>
          <div class="stat-card"><div class="stat-number">₱85,300</div><div class="stat-label">Transfer Value</div><div class="stat-change positive">This month</div></div>
        </div>

        <div class="quick-actions">
          <button class="action-btn"><h4>🔄 New Transfer</h4><p>Initiate stock transfer</p></button>
          <button class="action-btn"><h4>📋 Transfer Requests</h4><p>Review branch requests</p></button>
          <button class="action-btn"><h4>🚚 Schedule Pickup</h4><p>Arrange transfer logistics</p></button>
          <button class="action-btn"><h4>📊 Transfer Reports</h4><p>View transfer analytics</p></button>
        </div>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Branch Transfer Requests</h3>
            <div class="card-actions">
              <button class="btn btn-primary">Approve All</button>
              <button class="btn btn-primary">Export</button>
            </div>
          </div>
          <div class="table-container">
            <table class="table">
              <thead>
              <tr>
                <th>Transfer ID</th><th>From Branch</th><th>To Branch</th><th>Product</th>
                <th>Quantity</th><th>Requested Date</th><th>Priority</th><th>Status</th><th>Actions</th>
              </tr>
              </thead>
              <tbody>
              <tr><td><strong>TR-001</strong></td><td>Main Branch</td><td>SM Mall</td><td>Chicken Breast</td><td>25 kg</td><td>Aug 13, 2025</td><td><span class="status-badge status-critical">High</span></td><td><span class="status-badge status-pending">Pending</span></td><td><button class="btn btn-primary">Approve</button></td></tr>
              <tr><td><strong>TR-002</strong></td><td>Abreeza</td><td>Gaisano</td><td>Jasmine Rice</td><td>5 sacks</td><td>Aug 12, 2025</td><td><span class="status-badge status-low">Medium</span></td><td><span class="status-badge status-approved">Approved</span></td><td><button class="btn btn-primary">Track</button></td></tr>
              <tr><td><strong>TR-003</strong></td><td>Victoria Plaza</td><td>Tagum Branch</td><td>Cooking Oil</td><td>10 gallons</td><td>Aug 11, 2025</td><td><span class="status-badge status-normal">Low</span></td><td><span class="status-badge status-transit">In Transit</span></td><td><button class="btn btn-primary">Track</button></td></tr>
              <tr><td><strong>TR-004</strong></td><td>SM Mall</td><td>Main Branch</td><td>Special Sauce</td><td>15 bottles</td><td>Aug 10, 2025</td><td><span class="status-badge status-normal">Low</span></td><td><span class="status-badge status-delivered">Completed</span></td><td><button class="btn btn-primary">Receipt</button></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Reports -->
      <section id="reports" class="page">
        <div class="header">
          <div>
            <h2>Reports & Analytics</h2>
            <p style="color:#ffffff;margin-top:5px;">Comprehensive business intelligence and data insights</p>
          </div>
          <div class="user-info">
            <div>
              <div style="color:#ffd700;font-weight:600;">Central Admin</div>
              <div style="color:#ffffff;font-size:14px;">ChakaNoks HQ</div>
            </div>
            <div class="user-avatar">CA</div>
          </div>
        </div>

        <div class="report-controls">
          <div class="control-grid">
            <div class="control-group">
              <label>Report Type</label>
              <select id="reportType">
                <option value="sales">Sales Performance</option>
                <option value="inventory">Inventory Analysis</option>
                <option value="supplier">Supplier Performance</option>
                <option value="financial">Financial Summary</option>
                <option value="operational">Operational Metrics</option>
                <option value="custom">Custom Report</option>
              </select>
            </div>
            <div class="control-group">
              <label>Branch</label>
              <select id="branchFilter">
                <option value="all">All Branches</option>
                <option value="main">Davao - Main Branch</option>
                <option value="sm">Davao - SM Mall</option>
                <option value="abreeza">Davao - Abreeza</option>
                <option value="gaisano">Davao - Gaisano</option>
                <option value="victoria">Davao - Victoria Plaza</option>
                <option value="tagum">Tagum - New Branch</option>
              </select>
            </div>
            <div class="control-group">
              <label>Date Range</label>
              <select id="dateRange">
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="quarter">This Quarter</option>
                <option value="year">This Year</option>
                <option value="custom">Custom Range</option>
              </select>
            </div>
            <div class="control-group">
              <label>From Date</label>
              <input type="date" id="fromDate">
            </div>
            <div class="control-group">
              <label>To Date</label>
              <input type="date" id="toDate">
            </div>
            <div class="control-group">
              <label>&nbsp;</label>
              <button class="generate-btn" onclick="generateReport()">📊 Generate Report</button>
            </div>
          </div>
        </div>

        <div class="stats-grid">
          <div class="stat-card"><div class="stat-number">₱2.45M</div><div class="stat-label">Total Revenue (Monthly)</div><div class="stat-change positive">+18.5% from last month</div></div>
          <div class="stat-card"><div class="stat-number">₱1.85M</div><div class="stat-label">Cost of Goods Sold</div><div class="stat-change positive">-5.2% efficiency gain</div></div>
          <div class="stat-card"><div class="stat-number">24.5%</div><div class="stat-label">Gross Profit Margin</div><div class="stat-change positive">+2.8% improvement</div></div>
          <div class="stat-card"><div class="stat-number">96.8%</div><div class="stat-label">Order Fulfillment Rate</div><div class="stat-change positive">Above target</div></div>
        </div>

        <div class="quick-reports">
          <div class="report-card" onclick="loadQuickReport('daily-sales')">
            <h4>📈 Daily Sales Report</h4>
            <p>Real-time sales performance across all branches with hourly breakdowns and trend analysis</p>
          </div>
          <div class="report-card" onclick="loadQuickReport('inventory-levels')">
            <h4>📦 Inventory Levels</h4>
            <p>Current stock status, low inventory alerts, and reorder recommendations by branch</p>
          </div>
          <div class="report-card" onclick="loadQuickReport('supplier-performance')">
            <h4>🤝 Supplier Performance</h4>
            <p>Delivery times, quality metrics, pricing trends, and reliability scores</p>
          </div>
          <div class="report-card" onclick="loadQuickReport('financial-summary')">
            <h4>💰 Financial Summary</h4>
            <p>Revenue, expenses, profit margins, and cash flow analysis with forecasting</p>
          </div>
          <div class="report-card" onclick="loadQuickReport('operational-efficiency')">
            <h4>⚡ Operational Efficiency</h4>
            <p>Process optimization metrics, delivery performance, and productivity indicators</p>
          </div>
          <div class="report-card" onclick="loadQuickReport('branch-comparison')">
            <h4>🏪 Branch Comparison</h4>
            <p>Comparative performance analysis across all ChakaNoks locations</p>
          </div>
        </div>

        <div class="charts-grid">
          <div class="chart-card">
            <div class="chart-header">
              <h3 class="chart-title">Revenue Trends (Last 6 Months)</h3>
              <div class="export-buttons">
                <button class="btn btn-export" onclick="exportTable('chart-revenue')">📊 Export Chart</button>
              </div>
            </div>
            <div class="chart-content">
              <div class="chart-placeholder">
                📈 Revenue Chart<br>
                <small>Interactive chart showing monthly revenue trends with branch breakdown</small>
              </div>
            </div>
          </div>

          <div class="chart-card">
            <div class="chart-header">
              <h3 class="chart-title">Top Performing Products</h3>
              <div class="export-buttons">
                <button class="btn btn-export" onclick="exportTable('chart-products')">📊 Export Chart</button>
              </div>
            </div>
            <div class="chart-content">
              <div class="chart-placeholder">
                🥇 Product Performance<br>
                <small>Best-selling items by revenue and quantity</small>
              </div>
            </div>
          </div>
        </div>

        <div class="loading" id="loadingIndicator">
          <p>⏳ Generating report... Please wait.</p>
        </div>

        <div class="report-table-card">
          <div class="table-header">
            <h3 class="table-title">Branch Performance Summary</h3>
            <div class="export-buttons">
              <button class="btn btn-export" onclick="exportTable('pdf')">📄 PDF</button>
              <button class="btn btn-export" onclick="exportTable('excel')">📊 Excel</button>
              <button class="btn btn-export" onclick="exportTable('csv')">📋 CSV</button>
            </div>
          </div>
          <div class="table-container">
            <table class="table" id="reportsTable">
              <thead>
                <tr>
                  <th>Branch</th>
                  <th>Revenue</th>
                  <th>COGS</th>
                  <th>Gross Margin</th>
                  <th>On-Time Delivery</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr><td>Main Branch</td><td>₱920,000</td><td>₱690,000</td><td>25.0%</td><td>97.5%</td><td><span class="status-badge status-high">High</span></td></tr>
                <tr><td>SM Mall</td><td>₱580,000</td><td>₱445,000</td><td>23.3%</td><td>96.1%</td><td><span class="status-badge status-medium">Medium</span></td></tr>
                <tr><td>Abreeza</td><td>₱510,000</td><td>₱395,000</td><td>22.5%</td><td>95.4%</td><td><span class="status-badge status-medium">Medium</span></td></tr>
                <tr><td>Gaisano</td><td>₱310,000</td><td>₱255,000</td><td>17.7%</td><td>93.8%</td><td><span class="status-badge status-low">Low</span></td></tr>
                <tr><td>Victoria Plaza</td><td>₱230,000</td><td>₱185,000</td><td>19.6%</td><td>92.3%</td><td><span class="status-badge status-low">Low</span></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Franchising -->
      <section id="franchising" class="page">
        <div class="header">
          <h2>Franchise Management System</h2>
          <div class="user-info">
            <div><div style="color:#ffd700;font-weight:600;">Franchise Director</div><div style="color:#ffffff;font-size:14px;">ChakaNoks Corporate</div></div>
            <div class="user-avatar">FD</div>
          </div>
        </div>

        <div class="stats-grid">
          <div class="stat-card"><div class="stat-number">6</div><div class="stat-label">Active Franchises</div><div class="stat-change positive">+1 This Quarter</div></div>
          <div class="stat-card"><div class="stat-number">4</div><div class="stat-label">Applications Pending</div><div class="stat-change negative">Requires Review</div></div>
          <div class="stat-card"><div class="stat-number">₱18.5M</div><div class="stat-label">Total Franchise Revenue</div><div class="stat-change positive">+12% This Month</div></div>
          <div class="stat-card"><div class="stat-number">92%</div><div class="stat-label">Average Performance Score</div><div class="stat-change positive">Excellent Standards</div></div>
        </div>

        <div class="quick-actions">
          <button class="action-btn" onclick="showFranchiseForm()"><h4>🏪 New Franchise Application</h4><p>Process new franchise requests</p></button>
          <button class="action-btn" onclick="alert('Opening Performance Analytics...')"><h4>📈 Performance Analytics</h4><p>Monitor franchise performance</p></button>
          <button class="action-btn" onclick="alert('Opening Training Hub...')"><h4>🎓 Training & Support</h4><p>Franchise training programs</p></button>
          <button class="action-btn" onclick="alert('Opening Territory Map...')"><h4>🗺️ Territory Management</h4><p>Manage franchise territories</p></button>
        </div>

        <div style="margin-top:30px;">
          <h3 style="color:#ffd700; margin-bottom:20px; font-size:24px;">🏪 Active Franchise Network</h3>

          <div class="franchise-card">
            <div class="franchise-header">
              <div>
                <div class="franchise-name">ChakaNoks Davao Main</div>
                <div class="franchise-id">Franchise ID: FR-001 | Owner: Original Corporate Branch</div>
              </div>
              <span class="status-badge status-active">Active</span>
            </div>
            <div class="franchise-details">
              <div class="detail-item"><span class="detail-label">Monthly Revenue:</span><span class="detail-value">₱850,000</span></div>
              <div class="detail-item"><span class="detail-label">Performance Score:</span><span class="detail-value">98%</span></div>
              <div class="detail-item"><span class="detail-label">Compliance Status:</span><span class="detail-value">Excellent</span></div>
              <div class="detail-item"><span class="detail-label">Next Inspection:</span><span class="detail-value">Sep 15, 2025</span></div>
            </div>
          </div>

          <div class="franchise-card">
            <div class="franchise-header">
              <div>
                <div class="franchise-name">ChakaNoks SM Mall Davao</div>
                <div class="franchise-id">Franchise ID: FR-002 | Owner: Jessica Tan</div>
              </div>
              <span class="status-badge status-active">Active</span>
            </div>
            <div class="franchise-details">
              <div class="detail-item"><span class="detail-label">Monthly Revenue:</span><span class="detail-value">₱720,000</span></div>
              <div class="detail-item"><span class="detail-label">Performance Score:</span><span class="detail-value">94%</span></div>
              <div class="detail-item"><span class="detail-label">Compliance Status:</span><span class="detail-value">Good</span></div>
              <div class="detail-item"><span class="detail-label">Next Inspection:</span><span class="detail-value">Sep 20, 2025</span></div>
            </div>
          </div>

          <div class="franchise-card">
            <div class="franchise-header">
              <div>
                <div class="franchise-name">ChakaNoks Abreeza Mall</div>
                <div class="franchise-id">Franchise ID: FR-003 | Owner: Michael Rodriguez</div>
              </div>
              <span class="status-badge status-active">Active</span>
            </div>
            <div class="franchise-details">
              <div class="detail-item"><span class="detail-label">Monthly Revenue:</span><span class="detail-value">₱680,000</span></div>
              <div class="detail-item"><span class="detail-label">Performance Score:</span><span class="detail-value">91%</span></div>
              <div class="detail-item"><span class="detail-label">Compliance Status:</span><span class="detail-value">Good</span></div>
              <div class="detail-item"><span class="detail-label">Next Inspection:</span><span class="detail-value">Oct 01, 2025</span></div>
            </div>
          </div>

          <div class="franchise-card">
            <div class="franchise-header">
              <div>
                <div class="franchise-name">ChakaNoks Gaisano Mall</div>
                <div class="franchise-id">Franchise ID: FR-004 | Owner: Sarah Chen</div>
              </div>
              <span class="status-badge status-active">Active</span>
            </div>
            <div class="franchise-details">
              <div class="detail-item"><span class="detail-label">Monthly Revenue:</span><span class="detail-value">₱590,000</span></div>
              <div class="detail-item"><span class="detail-label">Performance Score:</span><span class="detail-value">89%</span></div>
              <div class="detail-item"><span class="detail-label">Compliance Status:</span><span class="detail-value">Needs Improvement</span></div>
              <div class="detail-item"><span class="detail-label">Next Inspection:</span><span class="detail-value">Aug 25, 2025</span></div>
            </div>
          </div>

          <div class="franchise-card">
            <div class="franchise-header">
              <div>
                <div class="franchise-name">ChakaNoks Victoria Plaza</div>
                <div class="franchise-id">Franchise ID: FR-005 | Owner: Carlos Reyes</div>
              </div>
              <span class="status-badge status-active">Active</span>
            </div>
            <div class="franchise-details">
              <div class="detail-item"><span class="detail-label">Monthly Revenue:</span><span class="detail-value">₱630,000</span></div>
              <div class="detail-item"><span class="detail-label">Performance Score:</span><span class="detail-value">93%</span></div>
              <div class="detail-item"><span class="detail-label">Compliance Status:</span><span class="detail-value">Good</span></div>
              <div class="detail-item"><span class="detail-label">Next Inspection:</span><span class="detail-value">Sep 10, 2025</span></div>
            </div>
          </div>

          <div class="franchise-card">
            <div class="franchise-header">
              <div>
                <div class="franchise-name">ChakaNoks Tagum Branch</div>
                <div class="franchise-id">Franchise ID: FR-006 | Owner: Elena Santos</div>
              </div>
              <span class="status-badge status-active">Active - New</span>
            </div>
            <div class="franchise-details">
              <div class="detail-item"><span class="detail-label">Monthly Revenue:</span><span class="detail-value">₱420,000</span></div>
              <div class="detail-item"><span class="detail-label">Performance Score:</span><span class="detail-value">87%</span></div>
              <div class="detail-item"><span class="detail-label">Compliance Status:</span><span class="detail-value">Training Phase</span></div>
              <div class="detail-item"><span class="detail-label">Next Support Visit:</span><span class="detail-value">Aug 20, 2025</span></div>
            </div>
          </div>
        </div>
      </section>

      <!-- Users -->
      <section id="users" class="page">
        <div class="header">
          <h2>User Management</h2>
          <div class="user-info">
            <div><div style="color:#ffd700;font-weight:600;">Central Admin</div><div style="color:#ffffff;font-size:14px;">ChakaNoks HQ</div></div>
            <div class="user-avatar">CA</div>
          </div>
        </div>

        <div class="stats-grid">
          <div class="stat-card"><div class="stat-number">42</div><div class="stat-label">Total Users</div><div class="stat-change positive">+3 this month</div></div>
          <div class="stat-card"><div class="stat-number">38</div><div class="stat-label">Active Users</div><div class="stat-change positive">90% active rate</div></div>
          <div class="stat-card"><div class="stat-number">4</div><div class="stat-label">Suspended Users</div><div class="stat-change negative">Requires review</div></div>
          <div class="stat-card"><div class="stat-number">5</div><div class="stat-label">Admin Users</div><div class="stat-change positive">Security compliant</div></div>
        </div>

        <div class="quick-actions" style="margin-bottom:20px;">
          <button class="action-btn" onclick="openUserModal()">
            <h4>👤 Add New User</h4>
            <p>Create new user accounts</p>
          </button>
          <button class="action-btn" onclick="alert('Bulk import feature coming soon!')">
            <h4>📋 Bulk Import</h4>
            <p>Import users from CSV</p>
          </button>
          <button class="action-btn" onclick="alert('Reviewing permissions...')">
            <h4>🔐 Review Permissions</h4>
            <p>Audit user access levels</p>
          </button>
          <button class="action-btn" onclick="alert('Generating user report...')">
            <h4>📊 User Reports</h4>
            <p>Export user analytics</p>
          </button>
        </div>

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">All Users</h3>
            <div class="card-actions">
              <button class="btn btn-primary" onclick="filterUsers('all')">All</button>
              <button class="btn btn-primary" onclick="filterUsers('active')">Active</button>
              <button class="btn btn-primary" onclick="filterUsers('suspended')">Suspended</button>
              <button class="btn btn-primary">Export</button>
            </div>
          </div>
          <div class="table-container">
            <table class="table">
              <thead>
                <tr>
                  <th>User</th><th>Email</th><th>Role</th><th>Branch</th><th>Last Login</th><th>Status</th><th>Actions</th>
                </tr>
              </thead>
              <tbody id="usersTableBody">
                <tr data-status="active">
                  <td>
                    <div style="display:flex; align-items:center; gap:10px;">
                      <div class="user-avatar" style="width:35px; height:35px; font-size:14px;">JD</div>
                      <div><strong>Juan Dela Cruz</strong><div style="font-size:12px; color:#cccccc;">Branch manager</div></div>
                    </div>
                  </td>
                  <td>juan.delacruz@chakanoks.com</td>
                  <td><span class="role-badge role-branch-manager">Branch manager</span></td>
                  <td>Davao - Main Branch</td>
                  <td>2 hours ago</td>
                  <td><span class="status-badge status-active">Active</span></td>
                  <td>
                    <button class="btn btn-primary" onclick="editUser('juan')">Edit</button>
                    <button class="btn btn-primary" style="background:#e53e3e;" onclick="suspendUser('juan')">Suspend</button>
                  </td>
                </tr>
                <tr data-status="active">
                  <td>
                    <div style="display:flex; align-items:center; gap:10px;">
                      <div class="user-avatar" style="width:35px; height:35px; font-size:14px;">MS</div>
                      <div><strong>Maria Santos</strong><div style="font-size:12px; color:#cccccc;">Inventory staff</div></div>
                    </div>
                  </td>
                  <td>maria.santos@chakanoks.com</td>
                  <td><span class="role-badge role-inventory-staff">Inventory staff</span></td>
                  <td>Davao - SM Mall</td>
                  <td>1 day ago</td>
                  <td><span class="status-badge status-active">Active</span></td>
                  <td>
                    <button class="btn btn-primary" onclick="editUser('maria')">Edit</button>
                    <button class="btn btn-primary" style="background:#e53e3e;" onclick="suspendUser('maria')">Suspend</button>
                  </td>
                </tr>
                <tr data-status="active">
                  <td>
                    <div style="display:flex; align-items:center; gap:10px;">
                      <div class="user-avatar" style="width:35px; height:35px; font-size:14px;">CM</div>
                      <div><strong>Carlos Mendoza</strong><div style="font-size:12px; color:#cccccc;">Central Office Admin</div></div>
                    </div>
                  </td>
                  <td>carlos.mendoza@chakanoks.com</td>
                  <td><span class="role-badge role-central-admin">Central Office Admin</span></td>
                  <td>ChakaNoks HQ</td>
                  <td>30 minutes ago</td>
                  <td><span class="status-badge status-active">Active</span></td>
                  <td>
                    <button class="btn btn-primary" onclick="editUser('carlos')">Edit</button>
                    <button class="btn btn-primary" style="background:#666; cursor:not-allowed;" disabled>Protected</button>
                  </td>
                </tr>
                <tr data-status="active">
                  <td>
                    <div style="display:flex; align-items:center; gap:10px;">
                      <div class="user-avatar" style="width:35px; height:35px; font-size:14px;">LR</div>
                      <div><strong>Lisa Reyes</strong><div style="font-size:12px; color:#cccccc;">Logistics Coordinator</div></div>
                    </div>
                  </td>
                  <td>lisa.reyes@chakanoks.com</td>
                  <td><span class="role-badge role-logistics-coordinator">Logistics Coordinator</span></td>
                  <td>Victoria Plaza</td>
                  <td>6 hours ago</td>
                  <td><span class="status-badge status-active">Active</span></td>
                  <td>
                    <button class="btn btn-primary" onclick="editUser('lisa')">Edit</button>
                    <button class="btn btn-primary" style="background:#e53e3e;" onclick="suspendUser('lisa')">Suspend</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </main>
  </div>

  <!-- Add/Edit User Modal -->
  <div id="userModal" class="modal" aria-hidden="true">
    <div class="modal-content">
      <span class="close" onclick="closeUserModal()">&times;</span>
      <h3 id="modalTitle">Add New User</h3>
      <form id="userForm">
        <div class="form-row">
          <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName" required />
          </div>
          <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName" required />
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required />
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" />
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role" required>
              <option value="">Select Role</option>
              <option value="branch-manager">Branch manager</option>
              <option value="inventory-staff">Inventory staff</option>
              <option value="central-admin">Central Office Admin</option>
              <option value="supplier">Supplier</option>
              <option value="logistics-coordinator">Logistics Coordinator</option>
              <option value="franchise-manager">Franchise manager</option>
              <option value="system-admin">System Administrator(IT)</option>
            </select>
          </div>
          <div class="form-group">
            <label for="branch">Branch Assignment</label>
            <select id="branch" name="branch" required>
              <option value="">Select Branch</option>
              <option value="hq">ChakaNoks HQ</option>
              <option value="main">Davao - Main Branch</option>
              <option value="sm">Davao - SM Mall</option>
              <option value="abreeza">Davao - Abreeza</option>
              <option value="gaisano">Davao - Gaisano</option>
              <option value="victoria">Davao - Victoria Plaza</option>
              <option value="tagum">Tagum - New Branch</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="jobTitle">Job Title</label>
          <input type="text" id="jobTitle" name="jobTitle" placeholder="e.g., Branch Manager, Inventory Staff" />
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />
          </div>
          <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required />
          </div>
        </div>

        <div style="margin-top: 30px; text-align: right;">
          <button type="button" class="btn-cancel" onclick="closeUserModal()">Cancel</button>
          <button type="submit" class="btn-success">Save User</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Navigation
    function showPage(pageId, navElement) {
      document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
      const page = document.getElementById(pageId);
      if (page) page.classList.add('active');

      document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
      if (navElement) navElement.classList.add('active');

      if (window.innerWidth <= 768) closeSidebar();
    }
    function toggleSidebar() {
      document.getElementById('sidebar').classList.add('active');
      document.getElementById('mobileOverlay').classList.add('active');
    }
    function closeSidebar() {
      document.getElementById('sidebar').classList.remove('active');
      document.getElementById('mobileOverlay').classList.remove('active');
    }

    // Franchise actions
    function showFranchiseForm() {
      alert('Opening New Franchise Application Form...');
    }
    function viewApplication(applicationId) {
      alert('Opening application details for: ' + applicationId);
    }

    // User Modal
    const userModal = document.getElementById('userModal');
    function openUserModal(isEdit = false) {
      document.getElementById('modalTitle').textContent = isEdit ? 'Edit User' : 'Add New User';
      userModal.style.display = 'block';
      userModal.setAttribute('aria-hidden', 'false');
      document.getElementById('userForm').reset();
      document.getElementById('password').required = true;
      document.getElementById('confirmPassword').required = true;
    }
    function closeUserModal() {
      userModal.style.display = 'none';
      userModal.setAttribute('aria-hidden', 'true');
      document.getElementById('userForm').reset();
    }
    window.addEventListener('click', (e) => {
      if (e.target === userModal) closeUserModal();
    });

    function editUser(userId) {
      openUserModal(true);
      const firstName = document.getElementById('firstName');
      const lastName = document.getElementById('lastName');
      const email = document.getElementById('email');
      const role = document.getElementById('role');
      const branch = document.getElementById('branch');
      const jobTitle = document.getElementById('jobTitle');

      // Prefill samples
      switch (userId) {
        case 'juan':
          firstName.value = 'Juan';
          lastName.value = 'Dela Cruz';
          email.value = 'juan.delacruz@chakanoks.com';
          role.value = 'branch-manager';
          branch.value = 'main';
          jobTitle.value = 'Branch manager';
          break;
        case 'maria':
          firstName.value = 'Maria';
          lastName.value = 'Santos';
          email.value = 'maria.santos@chakanoks.com';
          role.value = 'inventory-staff';
          branch.value = 'sm';
          jobTitle.value = 'Inventory staff';
          break;
        case 'carlos':
          firstName.value = 'Carlos';
          lastName.value = 'Mendoza';
          email.value = 'carlos.mendoza@chakanoks.com';
          role.value = 'central-admin';
          branch.value = 'hq';
          jobTitle.value = 'Central Office Admin';
          break;
        case 'lisa':
          firstName.value = 'Lisa';
          lastName.value = 'Reyes';
          email.value = 'lisa.reyes@chakanoks.com';
          role.value = 'logistics-coordinator';
          branch.value = 'victoria';
          jobTitle.value = 'Logistics Coordinator';
          break;
      }

      // Optional when editing: do not require password re-entry
      document.getElementById('password').required = false;
      document.getElementById('confirmPassword').required = false;
    }

    function suspendUser(userId) {
      if (confirm('Are you sure you want to suspend this user?')) {
        alert('User suspended successfully!');
      }
    }
    function activateUser(userId) {
      if (confirm('Are you sure you want to activate this user?')) {
        alert('User activated successfully!');
      }
    }
    function filterUsers(status) {
      const rows = document.querySelectorAll('#usersTableBody tr');
      rows.forEach(row => {
        if (status === 'all') {
          row.style.display = '';
        } else {
          const rowStatus = row.getAttribute('data-status');
          row.style.display = rowStatus === status ? '' : 'none';
        }
      });
    }

    // Form submission handler
    document.getElementById('userForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const password = document.getElementById('password').value.trim();
      const confirmPassword = document.getElementById('confirmPassword').value.trim();
      if (document.getElementById('password').required && password !== confirmPassword) {
        alert('Passwords do not match!');
        return;
      }
      alert('User saved successfully!');
      closeUserModal();
    });

    // Reports handlers
    function generateReport() {
      const loading = document.getElementById('loadingIndicator');
      loading.classList.add('active');
      setTimeout(() => {
        loading.classList.remove('active');
        alert('Report generated with current filters.');
      }, 900);
    }
    function loadQuickReport(key) {
      const map = {
        'daily-sales': 'Daily Sales Report',
        'inventory-levels': 'Inventory Levels',
        'supplier-performance': 'Supplier Performance',
        'financial-summary': 'Financial Summary',
        'operational-efficiency': 'Operational Efficiency',
        'branch-comparison': 'Branch Comparison'
      };
      alert('Loading quick report: ' + (map[key] || key));
    }
    function exportTable(fmt) {
      alert('Exporting ' + fmt + '...');
    }

    // Demo: auto-navigate to franchising after load
    setTimeout(() => {
      const nav = Array.from(document.querySelectorAll('.nav-item')).find(el => el.textContent.trim().startsWith('Franchising'));
      if (nav) showPage('franchising', nav);
    }, 1000);
  </script>
</body>
</html>