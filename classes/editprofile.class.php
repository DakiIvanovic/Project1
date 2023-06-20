<?php

class EditProfile extends DbConnection {

    public $row;

    public function publicInfoForm($email) {

        $select_query = "SELECT * FROM users WHERE user_email = ?";
        $select_prep = $this->conn->prepare($select_query);
        $select_prep->bind_param('s', $email);
        $select_prep->execute();

        $select_result = $select_prep->get_result();

        $this->row = $select_result->fetch_assoc();

        $full_name = $this->row['user_full_name'];
        $username = $this->row['user_username'];
        $password = $this->row['user_password'];

        $imageUrl = '';
            if (isset($this->row['user_profile_picture'])) {
                $imageUrl = $this->row['user_profile_picture'];
            } else {
                $imageUrl = 'images/profile_picture_placeholder.jpg';
            }
        
        $form = "
        <link rel='stylesheet' href='assets/css/logged_in.css'>
        <body>
        <div class='container' id='result'>
            <h2>Public Information</h2>
            <hr>
            <form action='' method='post' enctype='multipart/form-data'>
                <label>Profile Picture</label>
                <img width='250' height='250' src='$imageUrl'><br>
                
                <input type='file' name='avatar'><br>
                
                <label>Full name</label><br>
                <input type='text' name='full_name' value='$full_name'><br>
                
                <label>Username</label><br>
                <input type='text' name='username' value='$username'><br>

                <input class='btn' type='submit' name='edit_public_info' value='Save' id='button'>
                <a href='?action=logout'>Logout</a>
                
            </form>
            </div>
            </body>
           
        ";

        echo $form;
    }

    private function uploadAvatar($avatar) {
        $allFiles = scandir('uploads');
        $avatarName = $avatar['name'];
        $avatarTmpName = $avatar['tmp_name'];
        $avatarInfo = pathinfo($avatarName);
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];

        if(!in_array($avatarInfo['extension'], $allowedExt)) {
            die('Extension not allowed');
        }

        if(in_array($avatarInfo['basename'], $allFiles)) {
            $avatarInfo['basename'] = $avatarInfo['filename'] . "_" . date('Y-m-d His') . "." . $avatarInfo['extension'];
        }

        $destination = 'uploads/' . $avatarInfo['basename'];

        move_uploaded_file($avatarTmpName, $destination);

        return $destination;
    }

    public function editPublicInfo($avatar, $fullName, $username) {
        
        $destination = '';

        if($avatar['name'] != '') {
            $destination = $this->uploadAvatar($avatar);
        }
        else {
            if(strpos($this->row['user_profile_picture'], 'images')) {
                $destination = 'images/profile_picture_placeholder.jpg';
            }
            else {
                $destination = $this->row['user_profile_picture'];
            }
        }

      
        $selectAllQuery = "SELECT * FROM users";
        $selectAllResult = $this->conn->query($selectAllQuery);

        while($row = $selectAllResult->fetch_assoc()) {
            if($row['user_email'] != $_SESSION['user_email']) {
                if($row['user_username'] == $username) {
                    die('Username already exists.');
                }
            }
        }

        $updateQuery = "UPDATE users SET user_profile_picture = ?, user_full_name = ?, user_username = ? WHERE user_email = ?";
        $updatePrep = $this->conn->prepare($updateQuery);
        $updatePrep->bind_param('ssss', $destination, $fullName, $username, $_SESSION['user_email']);
        $updateResult = $updatePrep->execute();

        if($updateResult) {
            header("Location: ".$_SERVER['PHP_SELF']);
        }
        else {
            echo 'Error while trying to update public information, please try again';
        }
    }

}