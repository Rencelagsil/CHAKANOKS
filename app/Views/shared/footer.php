  </div>

  <!-- Bootstrap JS Bundle (with Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function logout() {
      if (confirm('Are you sure you want to logout?')) {
        window.location.href = '<?= base_url('logout') ?>';
      }
    }

    // Mobile sidebar toggle
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('mobileOverlay');
      
      if (sidebar) {
        sidebar.classList.toggle('show');
        if (overlay) {
          overlay.classList.toggle('active');
        }
      }
    }

    function closeSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('mobileOverlay');
      
      if (sidebar) {
        sidebar.classList.remove('show');
        if (overlay) {
          overlay.classList.remove('active');
        }
      }
    }

    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(alert => {
        setTimeout(() => {
          alert.style.opacity = '0';
          setTimeout(() => {
            alert.remove();
          }, 300);
        }, 5000);
      });
    });
  </script>
</body>
</html>

