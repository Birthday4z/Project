<?php
    session_start();
    include_once('../src/function.php');
    $DBCon = new DB_con();
    if ($_SESSION['Member_ID'] == "") {
        header("location: ../index.php");
    }
    else {
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
        . "')</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body>
    <?php include_once "user_header.php" ?>
    <div class="container">
        <h1 class="mt-5">ยินดีต้อนรับ <?php echo $_SESSION['Firstname']; ?></h1> 
        <h1 class="mt-5">ห้องพัก :  <?php echo $_SESSION['Room_ID']; ?></h1> 
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