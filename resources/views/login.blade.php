<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory Management - Login</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #2c3e50, #4ca1af);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
    }

    .login-container {
      background: #fff;
      width: 350px;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #2c3e50;
    }

    label {
      font-size: 14px;
      color: #333;
      display: block;
      margin-bottom: 5px;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin-bottom: 15px;
      font-size: 14px;
      outline: none;
      transition: 0.3s;
    }

    input:focus {
      border-color: #4ca1af;
      box-shadow: 0 0 5px rgba(76,161,175,0.5);
    }

    .login-btn {
      width: 100%;
      background: #4ca1af;
      border: none;
      color: #fff;
      padding: 10px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .login-btn:hover {
      background: #357f8a;
    }

    .footer-text {
      text-align: center;
      margin-top: 15px;
      font-size: 13px;
      color: #555;
    }

    .footer-text a {
      color: #4ca1af;
      text-decoration: none;
    }

    .footer-text a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
 <form action="{{ route('web.login') }}" method="POST">
    @csrf
    <label for="email">Email Address</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" required>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Enter your password" required>

    <button type="submit" class="login-btn">Login</button>
</form>

  </div>
</body>
</html>
