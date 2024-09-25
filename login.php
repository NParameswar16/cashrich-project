<?php
ob_start ();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Login and Registration</title>
 </head>
 <body>
 
 <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color:#D3D3D3;
    }
     .navbar {
         display: flex;
         justify-content: center;
         align-items: center;
         background-color: #333;
         Height: 60px;
     }
    .logo{
      display: inline-block;
      justify-content: center;
      aline-items: center;
      position:absolute;
      top: 10px;
      left: 43%;
      height: 50px;
      width: 200px;
    }
    .container {
      display: flex;
      max-width: 350px;
      margin: 50px auto;
      background-color: #fff;
      margin-top: 100px;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }
    input[type="submit"] {
      background-color:#000000;
      color: white;
      cursor: pointer;
    }
    input[type="submit"]:hover {
      background-color:	#202020;
    }
    .form-group {
      margin-bottom: 15px;
    }
    .form-group label {
      font-weight: bold;
    }
    .login-link {
      text-align: center;
      margin-top: 10px;
    }
    .login-link a {
      color: #007bff;
      text-decoration: none;
    }
    .login-link a:hover {
      text-decoration: underline;
    }
    .message {
      text-align: center;
      margin-top: 10px;
      color: red;
    }
    .tab {
      text-align: center;
      margin-bottom: 20px;
    }
   
    .form-container {
      display: none;
    }
    .form-container.active {
      display: block;
    }

    @media (max-width: 576px) {
      .navbar-brand img {
        width: 200px;
        height: 50px;
        margin-left: -65px;
      }
    }
  </style>
</head>
<body>

  <!-- <navbar> -->
    <section>
    <nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="logo2.png" alt="" width="30" height="24" class="d-inline-block align-text-top logo">
    </a>
  </div>
</nav>
    </section>

<div class="container">
  <!-- Login Form -->
  <div id="login-form" class="form-container active">
    <h2>Login</h2>
    <form method="post">
      <div class="form-group">
        <label for="email">Email Id:</label>
        <input type="email" id="login-email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="login-password" name="password" required>
      </div>
      <div class="form-group">
        <input type="submit" name="login" value="Login">
      </div>
    </form>
    <div class="login-link">
      Don't have an account? <a href="#" onclick="showForm('register')">Sign up here</a>
    </div>
  </div>

  <!-- Registration Form -->
  <div id="register-form" class="form-container">
    <h2>Sign Up</h2>
    <form method="post"  onsubmit="return validateRegistrationForm()">
      <div class="form-group">
        <label for="name">Username:</label>
        <input type="text" id="reg-username" name="username" required>
      </div>
      <div class="form-group">
        <label for="email">Email Id:</label>
        <input type="email" id="reg-email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="reg-password" name="password" required>
      </div>
      <div class="form-group">
        <input type="submit" name="register" value="Register">
      </div>
    </form>
    <div class="login-link">
      Already have an account? <a href="#" onclick="showForm('login')">Login here</a>
    </div>
  </div>

  <div id="message" class="message"></div>
</div>


<!--javascript code -->
<script>
  function showForm(form) {
    document.getElementById('login-form').classList.remove('active');
    document.getElementById('register-form').classList.remove('active');

    if (form === 'login') {
      document.getElementById('login-form').classList.add('active');
    } else {
      document.getElementById('register-form').classList.add('active');
    }
  }

  function validateRegistrationForm() {
    const username = document.getElementById('reg-username').value;
    const password = document.getElementById('reg-password').value;
    const message = document.getElementById('message');

    
    const usernamePattern = /^[a-zA-Z0-9]{4,15}$/;
    if (!usernamePattern.test(username)) {
      message.textContent = "Username must be 4-15 characters long and contain only letters and digits.";
      return false;
    }

    
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/;
    if (!passwordPattern.test(password)) {
      message.textContent = "Password must be 8-15 characters long, with at least 1 uppercase letter, 1 lowercase letter, 1 digit, and 1 special character.";
      return false;
    }
    
    
    message.textContent = "";
    return true;
  }


</script>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "practice1";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Login 
  if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $passcode = $_POST['password'];

    $sql = "SELECT email, password FROM cashrich WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      if ($row['password'] === $passcode) {
        $_SESSION['email'] = $row['email'];
      
        header("Location:main.php");
        ob_end_flush();
        exit();
      } else {
        echo "<div class='message'>Invalid password</div>";
      }
    } else {
      echo "<div class='message'>Invalid email</div>";
    }

    $stmt->close();
  }

  // Registration 
  if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $passcode = $_POST['password'];

    $sql = "INSERT INTO cashrich (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $passcode);

    if ($stmt->execute()) {

      header("Location: login.php");
      exit();
    } else {
      echo "Error: " . $stmt->error;
    }

    $stmt->close();
  }

  $conn->close();
}
?>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>


