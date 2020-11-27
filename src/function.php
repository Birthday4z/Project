<?php
    define('DB_SERVER', "localhost");
    define('DB_USERNAME', "root");
    define('DB_PASSWORD', "");
    define('DB_NAME', "Project");

    class DB_con {
        function __construct() {
            date_default_timezone_set("Asia/Bangkok");
            $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
            $this->DBCon = $conn;

            if (mysqli_connect_errno()) {
                echo "Failed to connect to DB : " . mysqli_connect_error();
            }
        }

        public function login($username, $password) {
            $loginquery = mysqli_query($this->DBCon, "SELECT Member_ID, Username, F_Name, L_Name, Phone, isAdmin FROM member WHERE Username = '$username' AND Password = '$password'");
            return $loginquery;
        }

        public function getroom($memberid) {
            $getroomquery = mysqli_query($this->DBCon, "SELECT Room_ID FROM member_active WHERE Member_ID = $memberid");
            return $getroomquery;
        }

        public function getpetitionlist() {
            $getpetitionlist = mysqli_query($this->DBCon, "SELECT `Petition_Transaction_ID`, `Petition_ID`, `Room_ID`, `F_Name`, `Date_Create`, `Date_Admit`, `Description`, `isFinished` FROM `petition_transaction`, `member` WHERE member.Member_ID = petition_transaction.Member_ID ORDER BY Petition_Transaction_ID DESC");
            return $getpetitionlist;
        }


        public function getinvoicelist() {
            $getinvoicelist = mysqli_query($this->DBCon, "SELECT `Invoice_ID`, `Invoice_Note`, `Invoice_Date`, `Invoice_Room`, `Invoice_Receiver_Name`, `Invoice_Total`, `Invoice_Date_Create` FROM `invoice` ORDER BY Invoice_ID DESC");
            return $getinvoicelist;
        }


        public function submit_cleanform($RoomID, $MemberID, $Date_Create, $Date_Admit, $Description) {
            $cleanformquery = mysqli_query($this->DBCon, "INSERT INTO `petition_transaction`(`Petition_ID`, `Room_ID`, `Member_ID`, `Date_Create`, `Date_Admit`, `Description`, `isFinished`) VALUES (1,$RoomID,$MemberID,'$Date_Create','$Date_Admit','$Description',0)");
            return $cleanformquery;
        }

        public function submit_repairform($RoomID, $MemberID, $Date_Create, $Date_Admit, $Description) {
            $repairformquery = mysqli_query($this->DBCon, "INSERT INTO `petition_transaction`(`Petition_ID`, `Room_ID`, `Member_ID`, `Date_Create`, `Date_Admit`, `Description`, `isFinished`) VALUES (2,$RoomID,$MemberID,'$Date_Create','$Date_Admit','$Description',0)");
            return $repairformquery;
        }

    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

</head>
<body>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script type="text/javascript">
    function sweet_success($s1,$s2) {
        swal($s1, $s2, "success");
    }
    function sweet_error($e1,$e2) {
        swal($e1, $e2, "error");
    }
    function sweet_error_autoclose($ea1,$ea2,$ea3) {
        swal({
            title: $ea1,
            text: $ea2,
            timer: $ea3,
            icon: "error",
            showConfirmButton: false
            });
        }
    
</script>
</body>
</html>