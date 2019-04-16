<?php
    require "../Components/header.php";

    session_start();

    ?>

    <div class="menu">
        <ul>
            <?php
            if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
                echo "<li><a href='../Login/SignIn.php'>Sign In</a>";
                echo "<li><a href='../Login/SignUp.php'>Sign Up</a>";
            }
            else {
                echo "<li><a href='../Login/logout.php'>Log out</a>";
            }
            ?>
        </ul>
    </div>

    <div class="header">
        Home Page
    </div>

    <div class="content">
        <form method="get" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>">
            The number of user your want to show:
            <select name="number">
                <option value="10" selected>10 elements</option>
                <option value="20">20 elements</option>
                <option value="50">50 elements</option>
                <option value="100">100 elements</option>
            </select>
            <input type="submit" name="submit" value="go">
        </form>
        <br>
    </div>

<?php
/**
 * Phần xử lí php
 */

if(isset($_GET['submit'])) {
    $num = $_GET['number'];
    // BƯỚC 1: KẾT NỐI CSDL
    $conn = mysqli_connect('localhost', 'linh', 'Rinkute_98', 'linh');

    // BƯỚC 2: TÌM TỔNG SỐ RECORDS
    $result = mysqli_query($conn, 'select count(id) as total from users');
    $row = mysqli_fetch_assoc($result);
    $total_records = $row['total'];

    // BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

//            $limit = 10;
    $limit = $num;


    // BƯỚC 4: TÍNH TOÁN TOTAL_PAGE VÀ START
    // tổng số trang
    $total_page = ceil($total_records / $limit);

    // Giới hạn current_page trong khoảng 1 đến total_page
    if ($current_page > $total_page) {
        $current_page = $total_page;
    } else if ($current_page < 1) {
        $current_page = 1;
    }

    // Tìm Start
    $start = ($current_page - 1) * $limit;
    // BƯỚC 5: TRUY VẤN LẤY DANH SÁCH TIN TỨC
    // Có limit và start rồi thì truy vấn CSDL lấy danh sách tin tức
    $result = mysqli_query($conn, "SELECT * FROM users LIMIT $start, $limit");
    /**
     * PHẦN HIỂN THỊ TIN TỨC
     */
    // BƯỚC 6: HIỂN THỊ DANH SÁCH TIN TỨC
    echo "<table border='1'>";
    echo "<th>Id</th>";
    echo "<th>Avatar</th>";
    echo "<th>Fullname</th>";
    echo "<th>Description</th>";
    echo "<th>Date</th>";
    echo "<th>PROFILE</th>";
    while ($row = mysqli_fetch_assoc($result)) {

        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        if ($row['avatar'] == "") {
            echo "<td><img src='../Asset/image/avatar'/>";
        } else {
            echo "<td>" . $row['avatar'] . "</td>";
        }
        echo "<td>" . $row['fullname'] . "</td>";
        echo "<td>" .$row['description']."</td>";
        echo "<td>" . $row['date'] . "</td>";
        echo "<td><a href='profile.php?id=".$row['id']."'>Show Profile</a></td>";
        echo "</tr>";
    }

    /**
     * Phần hiển thị phân trang
     */
    // BƯỚC 7: HIỂN THỊ PHÂN TRANG
    // nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
    if ($total_page <= 1)
        echo " ";
    else {
        if ($current_page > 1 && $total_page > 1) {
            echo '<a href="index.php?page=' . ($current_page - 1) . '&number='.$_GET['number'].'&submit=go">Prev</a> | ';
        }

        // Lặp khoảng giữa
        for ($i = 1; $i <= $total_page; $i++) {
            // Nếu là trang hiện tại thì hiển thị thẻ span
            // ngược lại hiển thị thẻ a
            if ($i == $current_page) {
                echo '<span>' . $i . '</span> | <br><br>';
            } else {
                echo '<a href="index.php?page=' . $i . '&number='.$_GET['number'].'&submit=go">' . $i . '</a> | ';
            }
        }

        // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
        if ($current_page < $total_page && $total_page > 1) {
            echo '<a href="index.php?page=' . ($current_page + 1) . '&number='.$_GET['number'].'&submit=go">Next</a> | ';
        }
    }
}

?>

    <div class="footer">

    </div>
</body>
</html>