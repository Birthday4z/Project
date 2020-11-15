<?php
    session_start();
    include_once('../src/function.php');
    if ($_SESSION['Member_ID'] == "") {
        header("location: ../index.php");
    }
    else {
        $Admin_Member_ID = $_SESSION['Member_ID'];
        $Admin_Username = $_SESSION['Username'];
        $Admin_Firstname = $_SESSION['Firstname'];
        $Admin_Lastname = $_SESSION['Lastname'];
        $Admin_Phone = $_SESSION['Phone'];
        $Admin_isAdmin = $_SESSION['isAdmin'];

        echo "<script>sweet_success('เข้าสู่ระบบสำเร็จ !', 'ยินดีต้อนรับ คุณ "
        . $_SESSION['Firstname']
        . "')</script>";
        //echo "<script>sweet_success('เข้าสู่ระบบสำเร็จ !', 'ยินดีต้อนรับ คุณ $Admin_Firstname')</script>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Management System</title>
    
    <link rel="stylesheet" href="/project/src/css/bootstrap.min.css">
    <script src="/project/src/js/jquery-3.3.1.min.js"></script>
    <script src="/project/src/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
</head>
<body>
    <?php include_once "admin_header.php" ?>

    <link rel="stylesheet" href="/project/src/css/datepicker.css">
    <script src="/project/src/js/bootstrap-datepicker.js"></script>

    <div class="container">
        <h1 class="mt-5">Welcome Admin <?php echo $_SESSION['Firstname']; ?></h1>
        <hr>
    </div>





</body>
</html>

<?php
    }
?>