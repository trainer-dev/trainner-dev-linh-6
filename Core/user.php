<?php
//require "../Database/config.php";

class User{
    public $db;

    public function __construct()
    {
        $this->db = mysqli_connect('localhost', 'linh', 'Rinkute_98', 'linh');

        if (mysqli_connect_errno()) {
            echo "Error: Could not connect to database.";
            exit;
        }
    }

    function Error($password,$repassword){
        /**
         * Check error
         */
        if (strlen($password) < 6 || strlen($repassword) < 6)
        {
            $passError = "* Your password must be have at least 6 character";
        }

        if ($password != $repassword) {
            $passError = "* Two passwords must be the same";
        }

    }

    public function getSignUp($email,$username,$password,$fullname,$phone, $avatar,$des,$user)
    {
        $password = md5($password);

        $type =1;

        $date = 'CURRENT_TIMESTAMP()';

        $checkemail = 'SELECT * FROM users WHERE email = "' . $email . '"';
        $checkusername = 'SELECT * FROM users WHERE username = "' . $username . '"';
        //Checking if username or email is available in database
        $check = $this->db->query($checkemail);
        $count_row = $check->num_rows;
        $checkus = $this->db->query($checkusername);
        $count = $checkus->num_rows;
        //if the username is not in database then insert the table
        if ($count_row == 0 && $count == 0) {
            $sqlInsertDB = 'INSERT INTO users SET email="' . strtolower($email) . '", password = "'
                . strtolower($password) . '",username= "' . $username. '",fullname="'.$fullname.'",phone="'.$phone.'",avatar="'
                .$avatar.'", type="'.$type.'",date='.$date.',description="'.$des.'",introUser="'.$user.'"';
            mysqli_query($this->db, $sqlInsertDB);
            return false;
        }
        else {
            return true;
        }
    }

    /**
     *
     */
    public function signUp()
    {
        //Checking for User login or not
        if (isset($_REQUEST['signup'])) {

            $email = $_POST['email'];

            $password = $_POST["password"];

            $fullname = $_POST['fullname'];

            $phone = $_POST['phone'];

            $username = $_POST['username'];

            $avatar = $_POST['avatar'];

            $des = $_POST['description'];

            $user = $_POST['introUser'];


            //Checking for User login or not
            $signUp = $this->getSignUp($email, $username, $password, $fullname, $phone, $avatar,$des,$user);

            if ($signUp) {
                $success = 'Sign in successful';
                echo "<p><span class='error'>" . $success . "</span></p><br>";
            } else {
                // Registration Failed
                $fail = 'Sign in failed. Account already exits, please try again.';
                echo "<p><span class='error'>" . $fail . "</span></p><br>";
            };
        }
    }

    public function checkLogin($email, $password)
    {

        $password = md5($password);
        $checklogin = 'SELECT * FROM users WHERE email="'.strtolower($email) .'"AND password="'.strtolower($password).'"';

        $result = mysqli_query($this->db, $checklogin);
        $userData = mysqli_fetch_array($result);
        $countRow = $result->num_rows;

        if ($countRow === 1) {
            //this login var will use for the session thing
            $_SESSION["login"] = true;
            $_SESSION["id"] = $userData["id"];
            $_SESSION["type"] = $userData["type"];
            $_SESSION["username"] = $userData["username"];
            return true;
        } else {
            return false;
        }


    }

    public function login() {
        if (isset($_REQUEST['signin'])) {
            $email = $_POST['email'];

            $password = $_POST["password"];

            $login = $this->checkLogin($email, $password);
            if ($login) {
                //Login success
                header("location:/User/index.php?number=10&submit=go");

            } else {
                $error = "Your username or password wrong!";
                echo "<p><span class='error'>" . $error . "</span></p><br>";
            }

        }
    }



    /**Starting session*/
    public function get_session() {
        return $_SESSION["login"];
    }

    /**For logout process*/
    public function  get_logout() {
        $_SESSION["login"] = false;
        session_destroy();
    }
}
?>