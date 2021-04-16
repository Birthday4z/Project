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

        public function getlastid() {
            $getlastid = mysqli_insert_id($this->DBCon);
            return $getlastid;
        }

        public function getroom($memberid) {
            $getroomquery = mysqli_query($this->DBCon, "SELECT Room_ID FROM member_active WHERE Member_ID = $memberid");
            return $getroomquery;
        }

        public function getname_active($roomid) {
            $getroomquery = mysqli_query($this->DBCon, "SELECT member.F_Name, member.L_Name FROM `member`, `member_active` WHERE member_active.Room_ID = $roomid AND member_active.Member_ID = member.Member_ID");
            return $getroomquery;
        }

        public function getpetitionlist() {
            $getpetitionlist = mysqli_query($this->DBCon, "SELECT `Petition_Transaction_ID`, `Petition_ID`, `Room_ID`, `F_Name`, `Date_Create`, `Date_Admit`, `Description`, `isFinished` FROM `petition_transaction`, `member` WHERE member.Member_ID = petition_transaction.Member_ID ORDER BY Petition_Transaction_ID DESC");
            return $getpetitionlist;
        }

        public function getinvoicelist() /*ใช้ดึงข้อมูลตารางในหน้า invoice management*/ { 
            $getinvoicelist = mysqli_query($this->DBCon, "SELECT `Invoice_ID`, `Invoice_Note`, `Invoice_Date`, `Room_ID`, `F_Name`, `Invoice_Total`, `Invoice_Date_Create` FROM `invoice`, `member` WHERE invoice.Member_ID = member.Member_ID ORDER BY Invoice_ID DESC");
            return $getinvoicelist;
        }

        public function getinvoice($InvoiceID) {
            $getinvoice = mysqli_query($this->DBCon, "SELECT `Invoice_ID`, `Invoice_Note`, `Invoice_Date`, `Room_ID`, `Member_ID`, `Invoice_Total` FROM `invoice` WHERE `Invoice_ID` = $InvoiceID LIMIT 1");
            return $getinvoice;
        }

        public function getinvoice_item($InvoiceID) {
            $getinvoice_item = mysqli_query($this->DBCon, "SELECT `Invoice_ID`, `Item_Name`, `Item_Unit_Price`, `Item_Unit_LastMonth`, `Item_Unit_ThisMonth`, `Item_Unit_Used`, `Item_Amount` FROM `invoice_item` WHERE `Invoice_ID` = $InvoiceID");
            return $getinvoice_item;
        }

        public function submit_cleanform($RoomID, $MemberID, $Date_Create, $Date_Admit, $Description) {
            $cleanformquery = mysqli_query($this->DBCon, "INSERT INTO `petition_transaction`(`Petition_ID`, `Room_ID`, `Member_ID`, `Date_Create`, `Date_Admit`, `Description`, `isFinished`) VALUES (1,$RoomID,$MemberID,'$Date_Create','$Date_Admit','$Description',0)");
            return $cleanformquery;
        }

        public function submit_repairform($RoomID, $MemberID, $Date_Create, $Date_Admit, $Description) {
            $repairformquery = mysqli_query($this->DBCon, "INSERT INTO `petition_transaction`(`Petition_ID`, `Room_ID`, `Member_ID`, `Date_Create`, `Date_Admit`, `Description`, `isFinished`) VALUES (2,$RoomID,$MemberID,'$Date_Create','$Date_Admit','$Description',0)");
            return $repairformquery;
        }

        public function submit_invoice($Note, $Date, $RoomID, $MemberID, $Invoice_Total) {
            $invoicequery = mysqli_query($this->DBCon, "INSERT INTO `invoice`(`Invoice_Note`, `Invoice_Date`, `Room_ID`, `Member_ID`, `Invoice_Total`) VALUES ('$Note','$Date',$RoomID,$MemberID,$Invoice_Total)");
            return $invoicequery;
        }

        public function submit_invoice_item($InvoiceID, $Item_name, $Item_Unit_Price, $Item_Unit_LastMonth, $Item_Unit_ThisMonth, $Item_Unit_Used, $Item_Amount) {
            $invoice_itemquery = mysqli_query($this->DBCon, "INSERT INTO `invoice_item`(`Invoice_ID`, `Item_Name`, `Item_Unit_Price`, `Item_Unit_LastMonth`, `Item_Unit_ThisMonth`, `Item_Unit_Used`, `Item_Amount`) VALUES ($InvoiceID, '$Item_name', $Item_Unit_Price, $Item_Unit_LastMonth, $Item_Unit_ThisMonth, $Item_Unit_Used, $Item_Amount)");
            return $invoice_itemquery;
        }

        public function update_total_invoice($Invoice_Total, $InvoiceID) {
            $update_invoicequery = mysqli_query($this->DBCon, "UPDATE `invoice` SET `Invoice_Total`= $Invoice_Total WHERE `Invoice_ID` = $InvoiceID");
            return $update_invoicequery;
        }

        public function update_invoice($Note, $Date, $RoomID, $MemberID, $Invoice_Total, $InvoiceID) {
            $updateinvoicequery = mysqli_query($this->DBCon, "UPDATE `invoice` SET `Invoice_Note` = '$Note', `Invoice_Date` = '$Date', `Room_ID` = $RoomID, `Member_ID` = $MemberID, `Invoice_Total` = $Invoice_Total WHERE `Invoice_ID` = $InvoiceID");
            return $updateinvoicequery;
        }

        public function delete_old_update_invoice($InvoiceID) {
            $deleteupdateinvoicequery = mysqli_query($this->DBCon, "DELETE FROM `invoice_item` WHERE `Invoice_ID` = $InvoiceID");
            return $deleteupdateinvoicequery;
        }

        public function delete_invoice($InvoiceID) {
            $deleteinvoicequery = mysqli_query($this->DBCon, "DELETE FROM `invoice_item` WHERE `Invoice_ID` = $InvoiceID");
            $deleteinvoice_itemquery = mysqli_query($this->DBCon, "DELETE FROM `invoice` WHERE `Invoice_ID` = $InvoiceID");
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