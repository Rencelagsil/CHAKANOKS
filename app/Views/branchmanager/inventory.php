<?= $this->include('shared/header') ?>

<div class="main-container">
  <button class="btn btn-primary d-md-none position-fixed top-0 start-0 m-3" style="z-index:1100" data-bs-toggle="offcanvas" data-bs-target="#sidebar"><i class="bi bi-list"></i></button>
  <div id="mobileOverlay" class="d-md-none" onclick="closeSidebar()"></div>

  <?= $this->include('shared/sidebar') ?>

  <main class="main-content">
    <div class="header">
      <div>
        <h2>Branch Inventory</h2>
        <p class="mb-0">Manage branch stock</p>
      </div>
    </div>

    <div class="custom-card">
      <p class="mb-0">Coming soon: branch inventory list and actions.</p>
    </div>
  </main>
</div>

<?= $this->include('shared/footer') ?>


