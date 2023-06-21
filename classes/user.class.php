<?php 

class User extends DbConnection {


    // registration form
    public $form;

    // login form
    public $loginForm;

    public function defineRegistrationForm() {
        $this->form = "<form action='' method='post'>";
        $this->form .= "<input type='text' name='full_name' placeholder='Full name'><br>";
        $this->form .= "<input type='email' name='email' placeholder='Email'><br>";
        $this->form .= "<input type='text' name='username' placeholder='Username'><br>";
        $this->form .= "<input type='password' name='password' placeholder='Password'><br>";

        $this->form .= "<input type='submit' name='register' value='Register'>";
        $this->form .= "</form>";
    }

    public function defineLoginForm() {
        $this->loginForm = "<form action='' method='post'>";
        $this->loginForm .= "<input type='email' name='email' placeholder='Email'><br>";
        $this->loginForm .= "<input type='password' name='password' placeholder='Password'><br>";

        $this->loginForm .= "<input type='submit' name='login' value='Login'>";
        $this->loginForm .= "</form>";
    }

    public function showUsers() {
        $selectQuery = "SELECT * FROM users";
        $selectResult = $this->conn->query($selectQuery);
        while($row = $selectResult->fetch_assoc()) {
            echo 'Full name: ' . $row['user_full_name'] . "<br>";
            echo 'Email: ' . $row['user_email'] . "<hr>";
        }

    }

    public function setUser($fullName, $email, $username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $insertQuery = "INSERT INTO users(user_full_name, user_email, user_username, user_password) VALUES(?, ?, ?, ?)";
        $prepQuery = $this->conn->prepare($insertQuery);
        $prepQuery->bind_param('ssss', $fullName, $email, $username, $hashedPassword);
        $insertResult = $prepQuery->execute();

        if($insertResult) {
            header("Location: login.php");
        }
        else {
            echo 'Error while trying to register<br>';
        }
    }

    public function loginUser($loginCred) {
        
        $selectQuery = "SELECT user_password FROM users WHERE user_email = ?";
        $prepQuery = $this->conn->prepare($selectQuery);
        $prepQuery->bind_param('s', $loginCred['email']);
        $prepQuery->execute();
        $selectResult = $prepQuery->get_result();

        if($selectResult->num_rows > 0) {
            $row = $selectResult->fetch_assoc();
            if(password_verify($loginCred['password'], $row['user_password'])) {
                Session::createSession($loginCred['email']);
                header("Location: logged_in.php");
            }
            else {
                echo 'Incorrect password';
            }
        }
        else {
            echo "User with that email doesn't exist";
        }
    }

   public function sendMessage($name, $email, $message) {
    $insertMessage = "INSERT INTO contacts(user_msg_name, user_msg_email, user_message) VALUES (?, ?, ?)";
    $prepMsgQuery = $this->conn->prepare($insertMessage);
    $prepMsgQuery->bind_param('sss', $name, $email, $message);
    $insertMsgResults = $prepMsgQuery->execute();

    if ($insertMsgResults) {
        echo "Message succesfully sended. Thank You.";
    }
    else {
        echo "Error sending message!";
    }
   }
    
}

?>