<?php
    require "../Components/header.php";
    require "../Core/changeprofile.php";

    $profile = new Profile();
    if (isset($_REQUEST['submit'])) {

        $fullname = $_POST['fullname'];

        $phone = $_POST['phone'];

        $username = $_POST['username'];

        $des = $_POST['des'];

        $user = $_POST['user'];

        $profile->getChange($username,$fullname,$phone, $des,$user);
    }


$conn = mysqli_connect('localhost', 'linh', 'Rinkute_98', 'linh');

    $sql = "select *
                from users
                where id=".$_GET['id'];
    $user = mysqli_query($conn, $sql);

    while ($select = mysqli_fetch_assoc($user)) {
        ?>

        <div class="menu">
            <ul>

                <?php
                session_start();
                if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
                    echo "<li><a href='index.php?number=10&submit=go'>Home Page</a></li>";
                }
                else {
                    echo "<li><a href='../Login/logout.php'>Log out</a>";
                    echo "<li><a href='index.php?number=10&submit=go'>Home Page</a></li>";
                }
                ?>

            </ul>
        </div>

        <div class="header">
            Profile Page
        </div>


        <div class="content">
            <h2><? if(isset($_SESSION["username"]) && $_SESSION["username"] != '') echo "Hello ".$_SESSION["username"]."!"?></h2>
            <br><br>
            <?php
            $profile->profile();

            ?>
            <img src="<?php ?>">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" id="profile">
                <?php
                    if(isset($msg))
                        echo "<p>".$msg."</p>";
                ?>
                Username: <input type="text" name="username" value="<?php echo $select['username'] ?>"><br>
                <?php
                    if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
                        ?>
                            <input type='button' name='login' value='Sign In to show all user profile' onclick="redirect()">
                <?php
                        if(isset($_POST['login'])){
                            header("Location:/Login/SignIn.php");
                        }
                    }

                    else {

                        ?>
                        Fullname: <input type="text" name="fullname" value="<?php echo $select['fullname'] ?>">
                        <br>
                        Phone: <input type="text" name="phone" value="<?php echo $select['phone'] ?>"><br>
                        Description: <input type="text" name="des" value="<?php echo $select['description'] ?>"><br>
                        User Introduce: <input type="text" name="user" value="<?php echo $select['introUser'] ?>">
                        <?php
                            if($select["introUser"]==""){}

                        ?>
                        <br>
                        <?php if( isset($_SESSION['type']) && $select['type'] <= $_SESSION["type"]) { ?>
                            <input type="submit" value="Change Profile" name="submit" id="submit">
                            <?php
                        }
                        else {
                            echo "<p>You can't change this profile</p>";
                        }
                    }
                ?>
            </form>
        </div>

        <?php
    }
?>

<script type="text/javascript">
    function redirect() {
        window.location="/Login/SignIn.php"
    }
</script>
