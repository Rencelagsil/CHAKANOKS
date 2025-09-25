<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ChakaNoks SCMS - Login</title>

  <!-- ✅ Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #ffd700 0%, #ffb300 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-container {
      background: rgba(0, 0, 0, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 400px;
      border: 1px solid rgba(255, 215, 0, 0.3);
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
    }

    .header h1 {
      color: #ffffff;
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .header p {
      color: #ffffff;
      font-size: 14px;
      opacity: 0.8;
    }

    .welcome-section {
      text-align: center;
      margin-bottom: 30px;
    }

    .welcome-section h2 {
      color: #ffd700;
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 8px;
    }

    .welcome-section p {
      color: #ffffff;
      font-size: 14px;
      opacity: 0.8;
    }

    .login-form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .form-group label {
      color: #ffffff;
      font-weight: 600;
      font-size: 14px;
    }

    .form-group input {
      padding: 15px;
      border: 2px solid rgba(255, 215, 0, 0.3);
      border-radius: 10px;
      background: rgba(0, 0, 0, 0.5);
      color: #ffffff;
      font-size: 16px;
      transition: all 0.3s ease;
    }

    .form-group input:focus {
      outline: none;
      border-color: #ffd700;
      box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
    }

    .form-group input::placeholder {
      color: rgba(255, 255, 255, 0.6);
    }

    .login-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 14px;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 8px;
      color: #ffffff;
    }

    .remember-me input[type="checkbox"] {
      width: 16px;
      height: 16px;
      accent-color: #ffd700;
    }

    .forgot-password {
      color: #ffd700;
      text-decoration: none;
      font-weight: 600;
    }

    .forgot-password:hover {
      text-decoration: underline;
    }

    .login-btn {
      background: #ffd700;
      color: #000000;
      border: none;
      padding: 15px;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .login-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(255, 215, 0, 0.4);
    }

    .login-btn:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    .error-message {
      background: rgba(255, 68, 68, 0.2);
      border: 1px solid #ff4444;
      color: #ff4444;
      padding: 12px;
      border-radius: 8px;
      font-size: 14px;
      display: none;
    }

    .success-message {
      background: rgba(56, 161, 105, 0.2);
      border: 1px solid #38a169;
      color: #38a169;
      padding: 12px;
      border-radius: 8px;
      font-size: 14px;
      display: none;
    }

    .help-section {
      text-align: center;
      margin-top: 25px;
      padding-top: 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .help-section p {
      color: #ffffff;
      font-size: 12px;
      margin-bottom: 8px;
    }

    .help-section a {
      color: #ffd700;
      text-decoration: none;
      font-weight: 600;
      font-size: 12px;
    }

    .help-section a:hover {
      text-decoration: underline;
    }

    @media (max-width: 480px) {
      .login-container {
        padding: 25px 20px;
      }
      
      .header h1 {
        font-size: 24px;
      }
      
      .welcome-section h2 {
        font-size: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="header">
    </div>

    <div class="welcome-section">
      <h2>Welcome Back!</h2>
      <p>Please sign in to access your dashboard.</p>
    </div>

    <form class="login-form" action="<?= base_url('login/auth') ?>" method="post" id="loginForm">
      <?php if (session()->getFlashdata('error')): ?>
        <div class="error-message" style="display: block;">
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>

      <div class="login-options">
        <label class="remember-me">
          <input type="checkbox" id="remember" name="remember">
          Remember me
        </label>
        <a href="#" class="forgot-password">Forgot Password?</a>
      </div>

      <button type="submit" class="login-btn" id="loginBtn">
        <span id="loginBtnText">Sign In</span>
        <span id="loginBtnLoading" style="display: none;">Signing In...</span>
      </button>
    </form>

    <div class="error-message" id="errorMessage"></div>
    <div class="success-message" id="successMessage"></div>

    <div class="help-section">
      <p>Need help accessing your account?</p>
      <a href="mailto:support@chakanoks.com">Contact System Administrator</a>
    </div>
  </div>

  <!-- ✅ Bootstrap JS Bundle (with Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const loginForm = document.getElementById('loginForm');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const loginBtn = document.getElementById('loginBtn');
    const loginBtnText = document.getElementById('loginBtnText');
    const loginBtnLoading = document.getElementById('loginBtnLoading');
    const errorMessage = document.getElementById('errorMessage');
    const successMessage = document.getElementById('successMessage');

    function showMessage(element, message, isError = false) {
      element.textContent = message;
      element.style.display = 'block';
      if (isError) {
        errorMessage.style.display = 'block';
        successMessage.style.display = 'none';
      } else {
        successMessage.style.display = 'block';
        errorMessage.style.display = 'none';
      }
      setTimeout(() => {
        element.style.display = 'none';
      }, 5000);
    }

    loginForm.addEventListener('submit', function(e) {
      const username = usernameInput.value.trim();
      const password = passwordInput.value.trim();

      if (!username || !password) {
        e.preventDefault();
        showMessage(errorMessage, 'Please fill in all fields.', true);
        return;
      }

      loginBtn.disabled = true;
      loginBtnText.style.display = 'none';
      loginBtnLoading.style.display = 'inline';
    });

    document.addEventListener('DOMContentLoaded', function() {
      usernameInput.focus();
    });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Enter' && document.activeElement === passwordInput) {
        loginForm.submit();
      }
    });

    document.querySelector('.forgot-password').addEventListener('click', function(e) {
      e.preventDefault();
      alert('Please contact the system administrator to reset your password.\nEmail: support@chakanoks.com');
    });
  </script>
</body>
</html>