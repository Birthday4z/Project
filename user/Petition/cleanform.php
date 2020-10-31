<?php
    session_start();
    include_once('../../src/function.php');
    $current_date = date("Y-m-d");
    $DBCon = new DB_con();
    if ($_SESSION['Member_ID'] == "") {
        header("location: ../../index.php");
    }
    else {
        if (isset($_POST['submit_cleanupform'])) {
            $want_date = $_POST['want_date'];

            //Submit Query Cleanup Form
            $sqlresult = $DBCon->submit_cleanform($_SESSION['Room_ID'], $_SESSION['Member_ID'], $current_date, $_POST['want_date'], $_POST['Description']);
            if ($sqlresult) {
                echo "<script>sweet_success('บันทึกข้อมูลสำเร็จ !', 'คำร้องของคุณถูกบันทึกแล้ว');</script>";
            }
        }
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petition - Cleanform</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    
</head>
<body>
    <?php include_once "../user_header.php" ?>
    <div class="container">
        <form method="POST">
        <h1 class="mt-5">คำร้องทำความสะอาดห้องพัก</h1> 
        <hr>
        <br>
        <h5>ห้อง : <?php echo $_SESSION['Room_ID']; ?> </h5>
        <br>
        <h5>ชื่อ - นามสกุล : <?php echo $_SESSION['Firstname']?> <?php echo $_SESSION['Lastname']; ?></h5>
        <br>
        <h5>เบอร์ติดต่อ : <?php echo $_SESSION['Phone'];?></h5>
        <br>
        <h5>วันที่ยื่นคำร้อง : <?php
                            echo date("Y/m/d");
                            ?>
        </h5>
        <br>
        <h5>วันที่ต้องการ : <input type="date" name="want_date" required></h5>
        <br>


        <h5>รายละเอียดเพิ่มเติม</h5>  <textarea name="Description" style="margin: 0px; width: 720px; height: 300px;"></textarea>
        <br><br>
        <center>
            <button type="button" class="btn btn-outline-primary">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-printer-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5z"/>
            <path fill-rule="evenodd" d="M11 9H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
            <path fill-rule="evenodd" d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
            </svg> Print
            </button>


            <button type="submit" name="submit_cleanupform" class="btn btn-success">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-server" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M1.333 2.667C1.333 1.194 4.318 0 8 0s6.667 1.194 6.667 2.667V4C14.665 5.474 11.68 6.667 8 6.667 4.318 6.667 1.333 5.473 1.333 4V2.667zm0 3.667v3C1.333 10.805 4.318 12 8 12c3.68 0 6.665-1.193 6.667-2.665V6.334c-.43.32-.931.58-1.458.79C11.81 7.684 9.967 8 8 8c-1.967 0-3.81-.317-5.21-.876a6.508 6.508 0 0 1-1.457-.79zm13.334 5.334c-.43.319-.931.578-1.458.789-1.4.56-3.242.876-5.209.876-1.967 0-3.81-.316-5.21-.876a6.51 6.51 0 0 1-1.457-.79v1.666C1.333 14.806 4.318 16 8 16s6.667-1.194 6.667-2.667v-1.665z"/>
            </svg> Submit</button>

            
        </center>
        </form>
    </div>





    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>


<?php
    }
?>