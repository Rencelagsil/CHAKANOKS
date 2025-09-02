<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Inventory Staff Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #ffd700 0%, #ffb300 100%);
      min-height: 100vh;
      overflow: hidden;
    }

    .layout-container { 
      display: flex; 
      min-height: 100vh; 
    }

    /* Sidebar */
    .sidebar {
      width: 260px;
      background: rgba(0, 0, 0, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 0 20px 20px 0;
      padding: 30px 0;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      display: flex;
      flex-direction: column;
    }
    .logo { text-align: center; margin-bottom: 40px; }
    .logo h1 { color: #ffd700; font-size: 26px; font-weight: bold; margin-bottom: 5px; }
    .logo p { color: #ffeb3b; font-size: 13px; }

    .nav { flex: 1; overflow-y: auto; }
    .nav a {
      display: block; padding: 15px 30px; color: #ffffff;
      text-decoration: none; transition: all 0.3s ease;
      margin: 5px 15px; border-radius: 12px; font-weight: 500;
    }
    .nav a:hover, .nav a.active {
      background: linear-gradient(135deg, #ffd700, #ffb300);
      color: #000000; transform: translateX(5px);
    }

    .logout {
      padding: 15px 30px; text-align: center; font-weight: bold;
      color: #ffd700; cursor: pointer; border-top: 1px solid rgba(255,215,0,0.3);
      transition: 0.3s;
    }
    .logout:hover { background: rgba(255,215,0,0.1); }

    /* Main Content */
    .main-content { 
      flex: 1; padding: 30px; 
      display: flex; flex-direction: column; 
      overflow: hidden;
    }

    .header {
      display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;
      background: rgba(0, 0, 0, 0.95); color: #ffd700;
      padding: 20px 30px; border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      flex-shrink: 0;
    }
    .header h2 { font-size: 28px; font-weight: 600; }
    .branch-info { font-size: 14px; color: #ccc; }

    /* Cards Grid */
    .cards {
      flex: 1;
      overflow-y: auto;
      padding-right: 5px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
    }
    .card {
      background: rgba(0, 0, 0, 0.95); color: #ffffff;
      padding: 25px; border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      position: relative; overflow: hidden;
      transition: transform 0.3s ease;
    }
    .card:hover { transform: translateY(-5px); }
    .card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
      background: linear-gradient(90deg, #ffd700, #ffb300);
    }
    .card h3 { margin: 0 0 10px; font-size: 18px; color: #ffd700; }
    .kpi { font-size: 32px; font-weight: bold; margin-bottom: 8px; color: #ffd700; }
    .muted { font-size: 13px; color: #bbbbbb; margin-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    th,td { text-align: left; padding: 6px 0; border-bottom: 1px solid #333; }
    th { color: #ffd700; font-weight: bold; }
</style>
</head>
<body>
<div class="layout-container">
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      <h1>CHAKANOKS</h1>
      <p>Inventory Staff</p>
    </div>
    <nav class="nav">
      <a href="#" class="active">Dashboard</a>
      <a href="#">Stock Levels</a>
      <a href="#">Deliveries</a>
      <a href="#">Damaged/Expired</a>
      <a href="#">Reports</a>
    </nav>
    <div class="logout">Logout</div>
  </aside>

  <!-- Main -->
  <div class="main-content">
    <div class="header">
      <h2>Inventory Staff</h2>
      <div class="branch-info">Branch: Davao City</div>
    </div>
    <div class="cards"></div>
  </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", () => {
  const navLinks = document.querySelectorAll(".nav a");
  const cardsContainer = document.querySelector(".cards");
  const headerTitle = document.querySelector(".header h2");

  const cardStockLevels = `
    <div class="card">
      <h3>Stock Levels</h3>
      <div class="kpi">12,480</div>
      <div class="muted">Total units in inventory</div>
      <table>
        <tr><th>Category</th><th>Units</th></tr>
        <tr><td>Beverages</td><td>4,210</td></tr>
        <tr><td>Snacks</td><td>3,890</td></tr>
        <tr><td>Personal Care</td><td>1,620</td></tr>
      </table>
    </div>
  `;

  const cardDeliveries = `
    <div class="card">
      <h3>Recent Deliveries</h3>
      <div class="kpi">5</div>
      <div class="muted">Received this week</div>
      <table>
        <tr><th>Date</th><th>Items</th></tr>
        <tr><td>Aug 12</td><td>Rice 50kg</td></tr>
        <tr><td>Aug 13</td><td>Soda Cases</td></tr>
        <tr><td>Aug 14</td><td>Shampoo Packs</td></tr>
      </table>
    </div>
  `;

  const cardDamaged = `
    <div class="card">
      <h3>Damaged / Expired Goods</h3>
      <div class="kpi">8</div>
      <div class="muted">Reported this month</div>
      <table>
        <tr><th>Item</th><th>Qty</th></tr>
        <tr><td>Milk 1L</td><td>3</td></tr>
        <tr><td>Bread Loaf</td><td>5</td></tr>
      </table>
    </div>
  `;

  const cardReports = `
    <div class="card">
      <h3>Reports</h3>
      <div class="kpi">4</div>
      <div class="muted">Available</div>
      <table>
        <tr><th>Type</th><th>Period</th></tr>
        <tr><td>Stock Movement</td><td>Today</td></tr>
        <tr><td>Delivery Summary</td><td>This Week</td></tr>
      </table>
    </div>
  `;

  const sections = {
    Dashboard: cardStockLevels + cardDeliveries + cardDamaged + cardReports,
    "Stock Levels": cardStockLevels,
    Deliveries: cardDeliveries,
    "Damaged/Expired": cardDamaged,
    Reports: cardReports
  };

  cardsContainer.innerHTML = sections.Dashboard;

  navLinks.forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault();
      navLinks.forEach(l => l.classList.remove("active"));
      link.classList.add("active");
      const sectionName = link.textContent.trim();
      headerTitle.textContent = sectionName;
      cardsContainer.innerHTML = sections[sectionName] || "<div class='card'><h3>Not Found</h3></div>";
    });
  });
});
</script>
</body>
</html>
