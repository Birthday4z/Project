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
    <!-- Import Script CSS_Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body>
    <?php include_once "admin_header.php" ?>
    <div class="container">
        <h1 class="mt-5">Welcome Admin <?php echo $_SESSION['Firstname']; ?></h1>
        <hr>
    </div>




    <!-- Import Script JS_Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>

<?php
    }
?>