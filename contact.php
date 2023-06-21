<?php
require 'includes/autoloader.inc.php';
require 'includes/header.php';

// Session::session_start();

// Session::userLogged();

$user_obj = new User();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
<link rel='stylesheet' href='assets/css/contact.css'>
<section class="contact" id="contact">
<div class="row"> 
<div class="content">
  <h3 class="tittle">contact info</h3>
  <div class="info">
    <h3><i class="fas fa-envelope"> david.ivanovic.066@gmail.com</i></h3>
    <h3><i class="fas fa-map-marker-alt"> Nis, Serbia</i></h3>
    <h3><i class="fas fa-phone"> 062/8643871</i></h3>
  </div>
</div>
<form method="POST" action="contact.php">
  <input type="text" name="name" placeholder="Name" class="box" required>
  <input type="email" name="email" placeholder="Email" class="box" required>
  <textarea name="message" cols="30" rows="10" class="box message" placeholder="Message" required></textarea>
  <button type="submit" class="btn" name="send_message">Send <i class="fas fa-paper-plane"></i></button>
</form>

</div>
</section>
<?php

if(isset($_POST['send_message'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  $user_obj->sendMessage($name, $email, $message);
}


?>