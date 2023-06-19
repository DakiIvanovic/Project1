<?php
include 'includes/autoloader.inc.php';
include 'includes/header.php';
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
<form action="">
  <input type="text" placeholder="name" class="box">
  <input type="email" placeholder="email" class="box">
  <textarea name="" id="" cols="30" rows="10" class="box message" placeholder="message"></textarea>
  <button type="submit" class="btn">Send<i class="fas fa-paper-plane"></i></button>
</form>

</div>
</section>
<?php

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];


$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'social_network';

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if($conn->connect_error) {
die('Error connecting with database: ' . $conn->connect_error);
}
    
    

    $contact_query = "INSERT INTO contacts(name, email, message) VALUES(?, ?, ?)";

    $prep_query = $conn->prepare($contact_query);
    $prep_query->bind_param('sss', $name, $email, $message);
    $prep_result = $prep_query->execute();

    if($prep_result) {
        echo 'Successfully sent a message';
    }
    else {
        echo 'Error while trying to send a message';
    }
}
?>