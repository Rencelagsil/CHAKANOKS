<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chakanoks SCMS - Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #fff8f2; /* soft background */
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-card {
      background: #f3f3f3;
      padding: 30px 40px;
      border-radius: 10px;
      width: 320px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      text-align: center;
    }

    .login-card h2 {
      margin: 0 0 20px;
      font-size: 20px;
      font-weight: bold;
      color: #333;
    }

    label {
      display: block;
      text-align: left;
      margin: 10px 0 5px;
      font-size: 14px;
      color: #333;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 15px;
      font-size: 14px;
    }

    .remember {
      display: flex;
      align-items: center;
      font-size: 13px;
      margin-bottom: 15px;
      color: #444;
    }

    .remember input {
      margin-right: 6px;
    }

    button {
      width: 100%;
      padding: 10px;
      background: #f97316; /* orange */
      border: none;
      border-radius: 4px;
      color: white;
      font-size: 15px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.2s;
    }

    button:hover {
      background: #d26010;
    }

    .forgot {
      margin-top: 15px;
      font-size: 13px;
    }

    .forgot a {
      text-decoration: none;
      color: #f97316;
    }

    .tagline {
      margin-top: 20px;
      font-size: 12px;
      font-style: italic;
      color: #555;
    }

    .error {
      color: red;
      font-size: 13px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <h2>Chakanoks SCMS</h2>

    <?php if(session()->getFlashdata('error')): ?>
      <p class="error"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form method="post" action="<?= site_url('login/auth') ?>">
      <label for="username">Username or Email</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>

      <div class="remember">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Remember me</label>
      </div>

      <button type="submit">Login</button>
    </form>

    <div class="forgot">
      <a href="#">Forgot password?</a>
    </div>

    <div class="tagline">“Chakanoks the Juiciest Manok”</div>
  </div>
</body>
</html>
