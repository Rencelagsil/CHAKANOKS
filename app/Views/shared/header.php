<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ChakaNoks SCMS - <?= $title ?? 'Dashboard' ?></title>
  
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
      background: linear-gradient(180deg, #1a1a1a 0%, #000000 100%);
      backdrop-filter: blur(10px);
      border-radius: 0 20px 20px 0;
      padding: 30px 0;
      box-shadow: 0 10px 30px rgba(0,0,0,0.5);
      position: fixed;
      height: 100vh;
      overflow-y: auto;
      z-index: 1000;
      transition: all 0.3s ease;
      border-right: 3px solid var(--primary-gold);
      border-left: 1px solid rgba(255,215,0,0.1);
    }
    
    .sidebar::-webkit-scrollbar {
      width: 6px;
    }
    
    .sidebar::-webkit-scrollbar-track {
      background: rgba(0,0,0,0.3);
    }
    
    .sidebar::-webkit-scrollbar-thumb {
      background: var(--primary-gold);
      border-radius: 3px;
    }
    
    .sidebar::-webkit-scrollbar-thumb:hover {
      background: var(--secondary-gold);
    }

    .logo { 
      text-align: center; 
      margin-bottom: 40px; 
      padding: 20px;
      background: rgba(0,0,0,0.3);
      border-radius: 15px;
      margin: 0 15px 40px 15px;
    }
    .logo h1 { 
      color: var(--primary-gold); 
      font-size: 28px; 
      font-weight: bold; 
      margin-bottom: 5px; 
      text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    .logo p { 
      color: #ffeb3b; 
      font-size: 14px; 
      opacity: 0.9;
    }

    .nav-item {
      display: flex; 
      align-items: center;
      padding: 18px 30px; 
      color: #ffffff; 
      text-decoration: none;
      transition: all 0.3s ease; 
      margin: 3px 15px; 
      border-radius: 15px;
      position: relative; 
      cursor: pointer; 
      border: none; 
      background: rgba(255,255,255,0.05);
      width: calc(100% - 30px);
      border-left: 4px solid transparent;
      font-weight: 500;
      backdrop-filter: blur(5px);
    }
    
    .nav-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(255,215,0,0.1), rgba(255,179,0,0.05));
      border-radius: 15px;
      opacity: 0;
      transition: opacity 0.3s ease;
      z-index: -1;
    }
    
    .nav-item:hover::before {
      opacity: 1;
    }
    
    .nav-item:hover {
      background: rgba(255,215,0,0.15);
      color: var(--primary-gold);
      transform: translateX(8px);
      border-left: 4px solid var(--primary-gold);
      box-shadow: 0 5px 15px rgba(255,215,0,0.2);
    }
    
    .nav-item.active {
      background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold));
      color: #000000;
      transform: translateX(8px);
      border-left: 4px solid #000000;
      box-shadow: 0 5px 15px rgba(255,215,0,0.4);
      font-weight: 600;
    }
    
    .nav-item i {
      width: 24px; 
      height: 24px; 
      margin-right: 15px;
      font-size: 18px; 
      display: flex; 
      align-items: center; 
      justify-content: center;
    }

    .logout {
      padding: 18px 30px; 
      text-align: center; 
      font-weight: bold;
      color: var(--primary-gold); 
      cursor: pointer; 
      border-top: 2px solid rgba(255,215,0,0.3);
      transition: 0.3s; 
      margin-top: auto;
      background: rgba(0,0,0,0.3);
      margin: 20px 15px 0 15px;
      border-radius: 15px;
    }
    .logout:hover { 
      background: rgba(255,215,0,0.2);
      color: #ffffff;
      transform: translateY(-2px);
    }

    /* Navigation Section */
    .nav-section {
      margin-bottom: 20px;
    }
    
    .nav-section-title {
      color: var(--primary-gold);
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin: 20px 30px 10px 30px;
      opacity: 0.8;
      border-bottom: 1px solid rgba(255,215,0,0.2);
      padding-bottom: 8px;
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
  </style>
</head>
<body>
  <div class="main-container">
    <!-- Mobile Toggle -->
    <button class="btn btn-primary d-md-none position-fixed top-0 start-0 m-3" style="z-index: 1100;" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
      <i class="bi bi-list"></i>
    </button>

