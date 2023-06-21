<link rel="stylesheet" href="assets/css/login.css">
<?php
require 'includes/autoloader.inc.php';
require 'includes/header.php';
// session_start();
Session::sessionStart();

// check
Session::userLogged();

$user_obj = new User();
?>
<body>
<form action="" method="post">
<div class="container">
    <h1>Login</h1>
    

    <label for="email"><b>Email</b></label><br>
    <input type="text" placeholder="Enter Email" name="email" id="email" required>

    <label for="password"><b>Password</b></label><br>
    <input type="password" placeholder="Enter Password" name="password" id="password" required>

    

    <button type="submit" class="btn" name="login">Login</button>
    <p class="reg">Doesn't have an account?<a href="register.php">Register</a>.</p>
  </div>

  
    



</form>
</body>




<?php
if(isset($_POST['login'])) {
    $login_cred = [
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    ];

    $user_obj->loginUser($login_cred);
}

?>