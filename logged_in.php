<link rel='stylesheet' href='assets/css/logged_in.css'>
<?php
include 'includes/autoloader.inc.php';
include 'includes/header.php';
Session::sessionStart();
Session::userNotLogged();



$obj = new EditProfile();
$obj->publicInfoForm($_SESSION['user_email']);



if(isset($_POST['edit_public_info'])) {
    $obj->editPublicInfo($_FILES['avatar'], $_POST['full_name'], $_POST['username']);
}

Session::logout();



?>


