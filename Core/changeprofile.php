<?php
class Profile
{
    public $db;

    public function __construct()
    {
        $this->db = mysqli_connect('localhost', 'linh', 'Rinkute_98', 'linh');

        if (mysqli_connect_errno()) {
            echo "Error: Could not connect to database.";
            exit;
        }
    }

    public function getChange($username,$fullname,$phone, $des,$user)
    {
        $checkusername = 'SELECT * FROM users WHERE username = "' . $user . '"';

        //Checking if username or email is available in database
        $checkus = $this->db->query($checkusername);
        $count = $checkus->num_rows;
        //if the username is not in database then insert the table
        if ($count != 0) {
            $sqlInsertDB = 'UPDATE users SET fullname="'.$fullname.'",phone="'.$phone.'", description="'.$des.'",introUser="'.$user.'" WHERE id= "' . $_GET['id']. '";';
            if ($this->db->query($sqlInsertDB) === TRUE) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public function profile()
    {
        //Checking for User login or not
        if (isset($_REQUEST['submit'])) {

            $fullname = $_POST['fullname'];

            $phone = $_POST['phone'];

            $username = $_POST['username'];

            $des = $_POST['des'];

            $user = $_POST['user'];


            //Checking for User login or not
            $change = $this->getChange($username, $fullname, $phone ,$des, $user);

            if ($change) {
                $success = 'Change profile successful';
                echo "<p><span class='error'>" . $success . "</span></p><br>";
            } else {
                // Registration Failed
                $fail = 'Change profile failed. Account already not exits, please try again.';
                echo "<p><span class='error'>" . $fail . "</span></p><br>";
            };
        }
    }


}

