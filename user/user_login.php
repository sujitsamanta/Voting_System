<?php
session_start();
include("db_conn.php");
if (isset($_POST['login_check'])) {
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$pass'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_name'] = $row['name'];
    $_SESSION['user_id'] =$row['id'];

    if($row) {

        echo "<script>alert('Login Successful'); window.location.href='user_dashbord.php';</script>";
        exit;

    } else {
        echo "<script>alert('Invalid email or password'); window.location.href='user_login.php';</script>";
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

  <style>
    .fade-in { animation: fadeIn 1s ease-in-out; }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    input:focus {
      outline: none;
      box-shadow: 0 0 8px rgba(37, 99, 235, 0.5);
      border-color: #2563eb;
    }
    label.error {
      color: #dc2626;
      font-size: 0.85rem;
      margin-top: 4px;
      display: block;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-blue-200 via-blue-100 to-blue-50 min-h-screen flex items-center justify-center">

  <div class="bg-white p-8 rounded-2xl shadow-2xl w-[90%] max-w-md fade-in">
    <h1 class="text-3xl font-extrabold text-center text-blue-700 mb-6">Welcome Back</h1>
    <p class="text-center text-gray-500 mb-8">Please sign in to continue</p>

    <form id="loginForm" class="space-y-5" action="#" method="post">
      <!-- Email -->
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
        <input type="email" name="email" class="w-full border border-gray-300 rounded-lg p-3 focus:ring focus:ring-blue-200" placeholder="you@example.com">
      </div>

      <!-- Password -->
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
        <input type="password" name="password" class="w-full border border-gray-300 rounded-lg p-3 focus:ring focus:ring-blue-200" placeholder="••••••••">
      </div>

      <!-- Submit -->
      <div class="text-center">
        <button type="submit" name="login_check" class="w-full bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-blue-700 active:scale-95 transition-transform">
          Login
        </button>
      </div>

      <!-- Link -->
      <p class="text-center text-sm mt-4 text-gray-600">
        Don't have an account?
        <a href="user_registration.php" class="text-blue-600 font-semibold hover:underline">Register here</a>
      </p>
    </form>
  </div>

  <script>
    $(document).ready(function() {
      $("#loginForm").validate({
        rules: {
          email: { required: true, email: true },
          password: { required: true, minlength: 6 }
        },
        messages: {
          email: {
            required: "Please enter your email.",
            email: "Please enter a valid email."
          },
          password: {
            required: "Please enter your password.",
            minlength: "Password must be at least 6 characters."
          }
        }
      });
    });
  </script>

</body>
</html>
