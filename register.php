
<?php
include 'includes/autoloader.inc.php';
include 'includes/header.php';
Session::sessionStart();

// check if user is not logged
Session::userLogged();

$user_obj = new User();
?>
<link rel="stylesheet" href="assets/css/register.css">
<body>
<form action="" method="post">
<div class="rcontainer">
    <h1>Register</h1>
    

    <label for="full_name"><b>Full Name<b></label>
    <input type="text" placeholder="Enter Full Name" name="full_name" id="full_name" required>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" id="email" required>

    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" id="username" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" id="password" required>

    

    <button type="submit" class="btn" name="register">Register</button>
    <p class="signin">Already have an account? <a href="login.php">Sign in</a>.</p>
  </div>

  
    



</form>
</body>
<?php
    
    if(isset($_POST['register'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user_obj->setUser($full_name, $email, $username, $password);
}

?>