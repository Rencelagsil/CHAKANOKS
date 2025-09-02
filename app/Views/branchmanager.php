<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Branch Manager Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
  :root{
    --primary:#f97316;
    --primary-dark:#d26010;
    --ink:#222;
    --muted:#666;
    --line:#f2f2f2;
    --bg:#fff;
  }
  *{box-sizing:border-box;}
  html,body{height:100%;margin:0;}
  body{
    font-family: Arial, sans-serif;
    background:var(--bg);
    color:var(--ink);
    overflow:hidden;
  }
  .app{
    display:grid;
    grid-template-columns: 220px 1fr;
    height:100vh;
  }

  /* Sidebar */
  .sidebar{
    background:linear-gradient(180deg, var(--primary), var(--primary-dark));
    color:#fff;
    display:flex;
    flex-direction:column;
    padding:20px 0;
  }
  .logo{
    text-align:center;
    font-weight:bold;
    font-size:20px;
    margin-bottom:30px;
    color:#fff;
    letter-spacing:1px;
  }
  .nav{flex:1;}
  .nav a{
    display:block;
    padding:12px 20px;
    text-decoration:none;
    color:#fff;
    border-left:4px solid transparent;
    transition:0.3s;
    font-weight:500;
  }
  .nav a:hover{
    background:rgba(255,255,255,0.1);
    border-left-color:#fff;
  }
  .nav a.active{
    background:rgba(255,255,255,0.2);
    border-left-color:#fff;
  }
  .logout{
    padding:12px 20px;
    border-top:1px solid rgba(255,255,255,0.3);
    cursor:pointer;
    text-align:center;
    font-weight:bold;
    background:rgba(255,255,255,0.1);
    transition:0.2s;
  }
  .logout:hover{background:rgba(255,255,255,0.2);}

  /* Main */
  .main{
    display:grid;
    grid-template-rows: 60px 1fr;
    background:#fafafa;
  }
  .topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 20px;
    border-bottom:1px solid var(--line);
    background:#fff;
    box-shadow:0 2px 4px rgba(0,0,0,0.05);
  }
  .branch-info{font-size:14px;color:var(--muted);}

  /* Cards */
  .cards{
    padding:20px;
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap:20px;
    overflow-y:auto;
  }
  .card{
    border:1px solid var(--line);
    border-radius:12px;
    padding:16px;
    background:white;
    box-shadow:0 2px 8px rgba(0,0,0,0.05);
    transition:transform 0.2s, box-shadow 0.2s;
  }
  .card:hover{
    transform:translateY(-4px);
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
  }
  .card h3{margin:0 0 10px;font-size:16px;color:var(--primary-dark);}
  .kpi{font-size:28px;font-weight:bold;margin-bottom:8px;color:var(--primary);}
  .muted{font-size:13px;color:var(--muted);margin-bottom:10px;}
  table{width:100%;border-collapse:collapse;font-size:13px;}
  th,td{text-align:left;padding:6px 0;border-bottom:1px solid var(--line);}
  th{color:var(--primary-dark);font-weight:bold;}

  /* Action Buttons */
  .btn{
    display:inline-block;
    margin-top:8px;
    padding:6px 12px;
    border:none;
    border-radius:6px;
    background:var(--primary);
    color:#fff;
    font-size:13px;
    cursor:pointer;
    transition:0.2s;
  }
  .btn:hover{background:var(--primary-dark);}
  .btn-outline{
    background:#fff;
    color:var(--primary);
    border:1px solid var(--primary);
  }
  .btn-outline:hover{background:var(--primary);color:#fff;}
</style>
</head>
<body>
<div class="app">
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">CHAKANOKS</div>
    <nav class="nav">
      <a href="#" class="active">Dashboard</a>
      <a href="#">Inventory</a>
      <a href="#">Purchase Req</a>
      <a href="#">Transfers</a>
      <a href="#">Reports</a>
    </nav>
    <div class="logout">Logout</div>
  </aside>

  <!-- Main -->
  <div class="main">
    <div class="topbar">
      <div><strong>Branch Manager</strong></div>
      <div class="branch-info">Branch: Davao City</div>
    </div>
    <div class="cards"></div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const navLinks = document.querySelectorAll(".nav a");
  const cardsContainer = document.querySelector(".cards");

  // Cards with ACTIONS
  const cardInventory = `
    <div class="card">
      <h3>Current Inventory</h3>
      <div class="kpi">12,480</div>
      <div class="muted">Units on hand</div>
      <table>
        <tr><th>Category</th><th>Units</th></tr>
        <tr><td>Beverages</td><td>4,210</td></tr>
        <tr><td>Snacks</td><td>3,890</td></tr>
        <tr><td>Personal Care</td><td>1,620</td></tr>
      </table>
      <button class="btn">+ Add Item</button>
      <button class="btn-outline">View All</button>
    </div>
  `;

  const cardLowStock = `
    <div class="card">
      <h3>Low-Stock Alerts</h3>
      <div class="kpi">14</div>
      <div class="muted">Items below threshold</div>
      <table>
        <tr><th>Item</th><th>Stock</th></tr>
        <tr><td>Sardines 155g</td><td>22</td></tr>
        <tr><td>Rice 5kg</td><td>9</td></tr>
        <tr><td>Soap Bar</td><td>15</td></tr>
      </table>
      <button class="btn">Reorder</button>
    </div>
  `;

  const cardPurchase = `
    <div class="card">
      <h3>Purchase Requests</h3>
      <div class="kpi">6</div>
      <div class="muted">Pending approval</div>
      <table>
        <tr><th>PR No.</th><th>Status</th></tr>
        <tr><td>PR-00138</td><td>Review</td></tr>
        <tr><td>PR-00139</td><td>Approval</td></tr>
        <tr><td>PR-00140</td><td>Draft</td></tr>
      </table>
      <button class="btn">+ New Request</button>
    </div>
  `;

  const cardTransfers = `
    <div class="card">
      <h3>Transfers</h3>
      <div class="kpi">3</div>
      <div class="muted">Awaiting action</div>
      <table>
        <tr><th>Ref</th><th>Status</th></tr>
        <tr><td>TX-0192</td><td>Incoming</td></tr>
        <tr><td>TX-0193</td><td>Await Pickup</td></tr>
      </table>
      <button class="btn">+ New Transfer</button>
    </div>
  `;

  const cardApprovals = `
    <div class="card">
      <h3>Approvals</h3>
      <div class="kpi">4</div>
      <div class="muted">Need your approval</div>
      <table>
        <tr><th>Type</th><th>Ref</th></tr>
        <tr><td>PR</td><td>PR-00139</td></tr>
        <tr><td>Transfer</td><td>TX-0193</td></tr>
      </table>
      <button class="btn-outline">Review All</button>
    </div>
  `;

  const cardReports = `
    <div class="card">
      <h3>Reports Snapshot</h3>
      <div class="kpi">7</div>
      <div class="muted">Available today</div>
      <table>
        <tr><th>Report</th><th>Period</th></tr>
        <tr><td>Daily Sales</td><td>Today</td></tr>
        <tr><td>Inventory Aging</td><td>This Week</td></tr>
        <tr><td>Stock Movement</td><td>This Month</td></tr>
      </table>
      <button class="btn">Generate Report</button>
    </div>
  `;

  // Sections
  const sections = {
    Dashboard: cardInventory + cardLowStock + cardPurchase + cardTransfers + cardApprovals + cardReports,
    Inventory: cardInventory + cardLowStock,
    "Purchase Req": cardPurchase + cardApprovals,
    Transfers: cardTransfers,
    Reports: cardReports
  };

  // Default
  cardsContainer.innerHTML = sections.Dashboard;

  // Nav Clicks
  navLinks.forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault();
      navLinks.forEach(l => l.classList.remove("active"));
      link.classList.add("active");

      const sectionName = link.textContent.trim();
      cardsContainer.innerHTML = sections[sectionName] || "<div class='card'><h3>Not Found</h3></div>";
    });
  });
});
</script>
</body>
</html>
