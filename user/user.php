<?php
    session_start();
    include_once('../src/function.php');
    $DBCon = new DB_con();
    if ($_SESSION['Member_ID'] == "") {
        header("location: ../index.php");
    } else {
        // Get Room_ID
        $sqlresult = $DBCon->getroom($_SESSION['Member_ID']);
        $num = mysqli_fetch_array($sqlresult); // Create Session
        if ($num > 0) {
            $_SESSION['Room_ID'] = $num['Room_ID'];
        }

        $User_Member_ID = $_SESSION['Member_ID'];
        $User_Room_ID = $_SESSION['Room_ID'];
        $User_Username = $_SESSION['Username'];
        $User_Firstname = $_SESSION['Firstname'];
        $User_Lastname = $_SESSION['Lastname'];
        $User_Phone = $_SESSION['Phone'];
        $User_isAdmin = $_SESSION['isAdmin'];


        echo "<script>sweet_success('เข้าสู่ระบบสำเร็จ !', 'ยินดีต้อนรับ คุณ "
        . $_SESSION['Firstname']
        . "')</script>"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>

    <link rel="stylesheet" href="/project/src/css/bootstrap.min.css">
    <script src="/project/src/js/jquery-3.3.1.min.js"></script>
    <script src="/project/src/js/bootstrap.min.js"></script>

</head>

<body>
    <?php include_once "user_header.php" ?>
    <div class="container">
        <h1 class="mt-5">ยินดีต้อนรับ <?php echo $_SESSION['Firstname']; ?></h1>
        <h1 class="mt-5">ห้องพัก : <?php echo $_SESSION['Room_ID']; ?></h1>
        <hr>
    </div>




</body>

</html>






<?php
    }
?>