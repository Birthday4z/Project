<?php
    session_start();
    include_once('../../src/function.php');
    $current_date = date("Y-m-d");
    $DBCon = new DB_con();
    if ($_SESSION['Member_ID'] == "") {
        header("location: ../../index.php");
    } else {
        if (isset($_POST['submit_repairform'])) {

            $want_date = $_POST['want_date'];
            if ($want_date < $current_date) {
                echo "<script>sweet_error('ไม่สามารถเลือกวันที่ต้องการได้ !','กรุณาเลือกวันที่ต้องการ หลังจากวันที่ปัจจุบัน');</script>";
            } else {

                $want_date = $_POST['want_date'];

                $sqlresult = $DBCon->submit_repairform($_SESSION['Room_ID'], $_SESSION['Member_ID'], $current_date, $_POST['want_date'], $_POST['Description']);
                if ($sqlresult) {
                    echo '<script type="text/javascript">swal("บันทึกข้อมูลสำเร็จ !", "ระบบกำลังพาคุณไปหน้าพิมพ์แบบฟอร์ม", "success");</script>';
                    $_SESSION['TypePetition'] = "ฟอร์มคำร้องซ่อมแซมอุปกรณ์ในห้องพัก";
                    $_SESSION['Currentdate'] = $current_date;
                    $_SESSION['Wantdate'] = $_POST['want_date'];
                    $_SESSION['Description'] = $_POST['Description'];
                
                    echo "<script>window.open('printpdf.php','_blank');</script>";
                }
            }
        }

        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petition - Repairform</title>

    <link rel="stylesheet" href="/project/src/css/bootstrap.min.css">
    <script src="/project/src/js/jquery-3.3.1.min.js"></script>
    <script src="/project/src/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body>
    <?php include_once "../user_header.php" ?>

    <link rel="stylesheet" href="/project/src/css/datepicker.css">
    <script src="/project/src/js/bootstrap-datepicker.js"></script>
    <script>
    $(document).ready(function() {
        $('#want_date').datepicker({
            format: "yyyy-mm-dd",
            immediateUpdates: true,
            todayBtn: true,
            todayHighlight: true,
            autoclose: true,
            startDate: new Date()
        })
    });
    </script>

    <div class="container">
        <form method="POST">

            <h1 class="mt-5">คำร้องซ่อมแซมอุปกรณ์ห้องพัก</h1>
            <hr>
            <br>
            <h5>ห้อง <?php echo $_SESSION['Room_ID']; ?> </h5>
            <br>
            <h5>ชื่อ - นามสกุล <?php echo $_SESSION['Firstname']?> <?php echo $_SESSION['Lastname']; ?></h5>
            <br>
            <h5>เบอร์ติดต่อ <?php echo $_SESSION['Phone']; ?></h5>
            <br>
            <h5>วันที่ยื่นคำร้อง <?php echo date("Y-m-d"); ?>
            </h5>
            <br>

            <div class="container">
                <div class="form-group row">
                    <h5>วันที่ต้องการ </h5>&nbsp;
                    <div style="width: 200px">
                        <input type="text" name="want_date" id="want_date" class="form-control form-inline" required 
                            placeholder="Select Date **ต้องเลือก**">
                    </div>
                </div>
            </div>

            <h5>รายละเอียดเพิ่มเติม</h5> <textarea name="Description" class="form-control" rows="10" maxlength="255" placeholder="ช่องกรอกรายละเอียดการทำความสะอาด **ไม่จำเป็นต้องกรอก** (สูงสุด 255 ตัวอักษร)"></textarea>
            <br><br>
            <center>

                <button type="submit" name="submit_repairform" class="btn btn-success">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-server" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M1.333 2.667C1.333 1.194 4.318 0 8 0s6.667 1.194 6.667 2.667V4C14.665 5.474 11.68 6.667 8 6.667 4.318 6.667 1.333 5.473 1.333 4V2.667zm0 3.667v3C1.333 10.805 4.318 12 8 12c3.68 0 6.665-1.193 6.667-2.665V6.334c-.43.32-.931.58-1.458.79C11.81 7.684 9.967 8 8 8c-1.967 0-3.81-.317-5.21-.876a6.508 6.508 0 0 1-1.457-.79zm13.334 5.334c-.43.319-.931.578-1.458.789-1.4.56-3.242.876-5.209.876-1.967 0-3.81-.316-5.21-.876a6.51 6.51 0 0 1-1.457-.79v1.666C1.333 14.806 4.318 16 8 16s6.667-1.194 6.667-2.667v-1.665z" />
                    </svg> Submit</button>
                    
            </center>
        </form>
    </div>
</body>

</html>
<?php
    }
?>