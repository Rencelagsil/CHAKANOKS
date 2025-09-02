<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Logistics Coordinator Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- Bootstrap CSS (copied from staff.php if present) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
      display: block;
      padding: 15px 30px;
      color: #ffffff;
      text-decoration: none;
      transition: all 0.3s ease;
      margin: 5px 15px;
      border-radius: 12px;
      font-weight: 500;
      font-size: 16px;
      letter-spacing: 0.5px;
    }
    .nav a:hover, .nav a.active {
      background: linear-gradient(135deg, #ffd700, #ffb300);
      color: #000000;
      transform: translateX(5px);
    }

    .logout {
      padding: 15px 30px;
      text-align: center;
      font-weight: bold;
      color: #ffd700;
      cursor: pointer;
      border-top: 1px solid rgba(255,215,0,0.3);
      transition: 0.3s;
      font-size: 16px;
      letter-spacing: 0.5px;
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
      <p>Logistics</p>
    </div>
    <nav class="nav">
      <a href="#" class="active">Dashboard</a>
      <a href="#">Delivery Schedule</a>
      <a href="#">Track Deliveries</a>
      <a href="#">Route Optimization</a>
      <a href="#">Reports</a>
    </nav>
    <div class="logout">Logout</div>
  </aside>

  <!-- Main -->
  <div class="main-content">
    <div class="header">
      <h2>Logistics Coordinator</h2>
      <div class="branch-info">Logistics Department</div>
    </div>
    <div class="cards"></div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const navLinks = document.querySelectorAll(".nav a");
  const cardsContainer = document.querySelector(".cards");
  const headerTitle = document.querySelector(".header h2");

  // Cards for Logistics Coordinator
  const cardSchedule = `
    <div class="card">
      <h3>Delivery Schedule</h3>
      <div class="kpi">15</div>
      <div class="muted">Deliveries scheduled today</div>
      <table>
        <tr><th>Time</th><th>Destination</th></tr>
        <tr><td>08:00</td><td>Davao City</td></tr>
        <tr><td>10:30</td><td>Cebu City</td></tr>
        <tr><td>14:00</td><td>General Santos</td></tr>
      </table>
    </div>
  `;

  const cardTracking = `
    <div class="card">
      <h3>Live Tracking</h3>
      <div class="kpi">8</div>
      <div class="muted">Deliveries in progress</div>
      <table>
        <tr><th>Truck</th><th>Status</th></tr>
        <tr><td>TR-102</td><td>En Route</td></tr>
        <tr><td>TR-108</td><td>Delayed</td></tr>
        <tr><td>TR-115</td><td>Delivered</td></tr>
      </table>
    </div>
  `;

  const cardRoutes = `
    <div class="card">
      <h3>Route Optimization</h3>
      <div class="kpi">3</div>
      <div class="muted">Routes optimized today</div>
      <table>
        <tr><th>Route</th><th>Time Saved</th></tr>
        <tr><td>Davao - Tagum</td><td>15 min</td></tr>
        <tr><td>Cebu - Mandaue</td><td>10 min</td></tr>
      </table>
    </div>
  `;

  const cardReports = `
    <div class="card">
      <h3>Logistics Reports</h3>
      <div class="kpi">5</div>
      <div class="muted">Available</div>
      <table>
        <tr><th>Report</th><th>Period</th></tr>
        <tr><td>On-Time Delivery Rate</td><td>Weekly</td></tr>
        <tr><td>Fuel Efficiency</td><td>Monthly</td></tr>
      </table>
    </div>
  `;

  const sections = {
    Dashboard: cardSchedule + cardTracking + cardRoutes + cardReports,
    "Delivery Schedule": cardSchedule,
    "Track Deliveries": cardTracking,
    "Route Optimization": cardRoutes,
    Reports: cardReports
  };

  // Load default
  cardsContainer.innerHTML = sections.Dashboard;

  // Handle nav clicks
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
