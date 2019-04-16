
<html>
<header>
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="../Asset/Au.css">
</header>
<body>
<?php
session_start();

include "../Core/validate.php";
include "../Core/user.php";
include "../Database/config.php";

$user = new User();


if(isset($_POST["signup"])) {

    $email = $_POST['email'];

    $password = $_POST["password"];

    $fullname = $_POST['fullname'];

    $phone = $_POST['phone'];

    $username = $_POST['username'];

    $avatar = $_POST['avatar'];


    $des = $_POST['description'];

    $userIntro = $_POST['introUser'];

    if($avatar==''){
        $avanull = "../Asset/image/avatar";
        $user->getSignUp($email,$username,$password,$fullname,$phone, $avanull,$des,$userIntro);
    }
    else
        $user->getSignUp($email,$username,$password,$fullname,$phone, $avatar,$des,$userIntro);
}

?>

    <div class="signup">
        <h2>
            Sign Up Page
        </h2>
        <h5>Welcome to Sign Up page</h5>

        <?php
        if(isset($passError))
            echo "<p><span class='error'>".$passError ."</span></p><br>";
        $user-> signUp();
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]);?>">

            Email:<br>
            <input type="email" name="email"  <?php if(isset($_SESSION['email'])) echo "value=".$_SESSION['email']; else echo "placeholder = 'Please enter your email'" ?> required>

            Password: <br>
            <input type="password" name="password" placeholder="Enter your password" required><br>


            Password (re-enter):<br>
            <input type="password" name="password-re" placeholder="Enter your password again"required><br>

            Your fullname:<br>
            <input type="text" name="fullname" placeholder="Enter your fullname" pattern="[a-zA-Z]{1,}" required><br>

            Username:<br>
            <input type="text" name="username" <?php if(isset($_SESSION['uname'])) echo "value=".$_SESSION['uname']; else echo "placeholder = 'Please enter your username'" ?> required><br>

            Phone number: <br>
            <input type="text" name="phone" id="phone" placeholder="Enter your phone numbers" pattern="[0-9]{1,}" required>

            Description:<br>
            <input type="text" name="description" placeholder="Enter your description"required><br>

            User Introduce:<br>
            <input type="text" name="introUser" placeholder="User who introduce this web to you"required><br>


            Avatar:<br>
            <input type="file" name="avatar" id="avatar"><br>

            <input type="submit" name="signup" value="Sign Up">

            <p><a href="SignIn.php" style="background: white">Have you been had account yet?</a><br></p>
        </form>
    </div>

</body>
</html>

