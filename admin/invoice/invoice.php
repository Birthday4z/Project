<?php
    include_once('../../src/function.php');
    $DBCon = new DB_con();

    //-------Debug----------
    function debug_to_console($data) {
            $output = $data;
            if (is_array($output))
                $output = implode(',', $output);
        
            echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
        }
    


    $sqlresult_invoicelist = $DBCon->getinvoicelist();
    $row_invoicelist = mysqli_num_rows($sqlresult_invoicelist);

    if (isset($_POST["create_invoice"])) {
        /*// ยังไม่เสร็จ จะทำ Autofill หลังกรอกห้อง
        $invoice_room_id = $_POST["invoice_room_id"];
        $sqlresult_submit_invoice = $DBCon->getname_active($invoice_room_id);
        */

        $invoice_note = trim($_POST["invoice_note"]);
        $invoice_date = $_POST["invoice_date"];
        
        // ชั่วคราว
        $invoice_room_id = $_POST["invoice_room_id"];
        $invoice_member_id = $_POST["invoice_member_id"];
        $invoice_total = 0; // เดี่ยว Update ที่งฟังก์ชัน update_total_invoice
        $submit_invoice = $DBCon->submit_invoice($invoice_note, $invoice_date, $invoice_room_id, $invoice_member_id, $invoice_total);
        
        $invoice_id = $DBCon->getlastid();

        //------$invoice_id = $query_getlastid->fetch_array()[0]; //เหี้ยอะไรไม่รู้ ตอนแรกใช้ได้ พอกลับมารันมีปัญหาเฉย แต่พอคอมเม้นท์มัน เสือกรันได้เฉย อะไรวะ

        //------echo "<script type='text/javascript'>alert('$query_getlastid');</script>";
        

        for ($count = 0; $count < $_POST["total_item"]; $count++) {
            $invoice_total = $invoice_total + floatval(trim($_POST["item_amount"][$count])); // Sum ค่า invoice_total
        
            if ($_POST["item_price_unit"][$count] == NULL) {
                $_POST["item_price_unit"][$count] = 0;
            }

            if ($_POST["item_unit_lastmonth"][$count] == NULL) {
                $_POST["item_unit_lastmonth"][$count] = 0;
            }

            if ($_POST["item_unit_thismonth"][$count] == NULL) {
                $_POST["item_unit_thismonth"][$count] = 0;
            }

            if ($_POST["item_unit_used"][$count] == NULL) {
                $_POST["item_unit_used"][$count] = 0;

            }
            if ($_POST["item_amount"][$count] == NULL) {
                $_POST["item_amount"][$count] = 0;
            }

            $sqlresult_submit_invoice_item = $DBCon->submit_invoice_item($invoice_id, $_POST["item_name"][$count], $_POST["item_price_unit"][$count], $_POST["item_unit_lastmonth"][$count], $_POST["item_unit_thismonth"][$count], $_POST["item_unit_used"][$count], $_POST["item_amount"][$count]);
        }

        $update_invoice_total = $DBCon->update_total_invoice($invoice_total, $invoice_id);


        debug_to_console("ทดสอบ debug");
        
        header("location: invoice.php");

    }

    if (isset($_POST["update_invoice"])) {
        /*// ยังไม่เสร็จ จะทำ Autofill หลังกรอกห้อง
        $invoice_room_id = $_POST["invoice_room_id"];
        $sqlresult_submit_invoice = $DBCon->getname_active($invoice_room_id);
        */

        $invoice_note = trim($_POST["invoice_note"]);
        $invoice_date = $_POST["invoice_date"];
        
        // ชั่วคราว
        $invoice_room_id = $_POST["invoice_room_id"];
        $invoice_member_id = $_POST["invoice_member_id"];
        $invoice_total = 0; // เดี่ยว Update ที่หลัง

        $update_invoice_id = $_POST["invoice_id"];
        $delete_old_invoice = $DBCon->delete_old_update_invoice($update_invoice_id);

        for ($count = 0; $count < $_POST["total_item"]; $count++) {
            $invoice_total = $invoice_total + floatval(trim($_POST["item_amount"][$count])); // Sum ค่า invoice_total
        
            if ($_POST["item_price_unit"][$count] == NULL) {
                $_POST["item_price_unit"][$count] = 0;
            }

            if ($_POST["item_unit_lastmonth"][$count] == NULL) {
                $_POST["item_unit_lastmonth"][$count] = 0;
            }

            if ($_POST["item_unit_thismonth"][$count] == NULL) {
                $_POST["item_unit_thismonth"][$count] = 0;
            }

            if ($_POST["item_unit_used"][$count] == NULL) {
                $_POST["item_unit_used"][$count] = 0;

            }
            if ($_POST["item_amount"][$count] == NULL) {
                $_POST["item_amount"][$count] = 0;
            }

            $sqlresult_submit_invoice_item = $DBCon->submit_invoice_item($update_invoice_id, $_POST["item_name"][$count], $_POST["item_price_unit"][$count], $_POST["item_unit_lastmonth"][$count], $_POST["item_unit_thismonth"][$count], $_POST["item_unit_used"][$count], $_POST["item_amount"][$count]);
        }

        $update_invoice_total = $DBCon->update_invoice($invoice_note, $invoice_date, $invoice_room_id, $invoice_member_id, $invoice_total, $update_invoice_id);

    }

    if (isset($_GET["delete"]) && isset($_GET["id"])) {
        $delete_invoice = $DBCon->delete_invoice($_GET["id"]);
        header("location:invoice.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/project/src/css/bootstrap.min.css">
    <script src="/project/src/js/jquery-3.3.1.min.js"></script>
    <script src="/project/src/js/bootstrap.min.js"></script>

    <script src="/project/src/js/jquery.dataTables.min.js"></script>
    <script src="/project/src/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="/project/src/css/dataTables.bootstrap4.min.css">
    <title>Invoice</title>
</head>
<body>
<?php include_once "../admin_header.php" ?>

    <link rel="stylesheet" href="/project/src/css/datepicker.css">
    <script src="/project/src/js/bootstrap-datepicker.js" charset="UTF-8"></script>
    <script>
        $(document).ready(function() {
            $('#invoice_date').datepicker({
                format: "yyyy-mm",
                immediateUpdates: true,
                todayBtn: true,
                todayHighlight: true,
                autoclose: true
            })
        });
    </script>

    <div class="container-fluid">
        <?php
        if (isset($_GET["add"])) {
        ?>
        <form method="POST" id="invoice_form">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2" align="center"><h2 style="margin-top:11px">Create Invoice Form</h2></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-8">
                                    <b>Receiver (BILL TO)</b> <br />
                                    <input type="text" name="invoice_room_id" id="invoice_room_id" class="form-control input-sm" placeholder="Enter Room">
                                    <input type="text" name="invoice_member_id" id="invoice_member_id" class="form-control input-sm" placeholder="ช่องใส่ member ID ชั่วคราว กะว่าจะ Autofill หลังจากกรอกห้อง">
                                    <!-- ยังไม่ทำ! คิดไว้คร่าวๆ คือ เมื่อเลือก Room ID(ดึงค่าจาก member_active) จะดึง Member ID ปัจจุบันมาด้วย แล้วมาแสดงชื่อใน Field-->
                                    <input type="text" name="invoice_receiver_name" id="invoice_receiver_name" class="form-control input-sm" placeholder="Enter Receiver Name">
                                    <b>Note (BILL NOTE)</b> <br />
                                    <input type="text" name="invoice_note" id="invoice_note" class="form-control input-sm" placeholder="Enter Note">
                                    </div>

                                    <div class="col-md-4">
                                    <b>Date (BILL DATE)</b> <br />
                                    <input type="text" name="invoice_date" id="invoice_date" class="form-control input-sm" readonly placeholder="Select Invoice Date">
                                    </div>
                                
                                </div>

                                <table id="invoice-item-table" class="table table-bordered">
                                    <tr>
                                        <th>ITEM_NO.</th>
                                        <th>รายการ</th>
                                        <th>ราคาต่อหน่วย</th>
                                        <th>จำนวนหน่วยเดือนก่อน</th>
                                        <th>จำนวนหน่วยเดือนนี้</th>
                                        <th>จำนวนหน่วยที่ใช้</th>
                                        <th>Amount (Baht)</th>
                                        <th>ลบ</th>
                                    </tr>
                                    
                                    <tr id="row_id_1">
                                        <td><span id="item_no">1</span></td>
                                        <td><input type="text" name="item_name[]" id="item_name1" class="form-control input-sm" value="ไฟฟ้า (Electric)"></td>
                                        <td><input type="text" name="item_price_unit[]" id="item_price_unit1" data-itemno="1" class="form-control input-sm number_only item_price_unit"></td>
                                        <td><input type="text" name="item_unit_lastmonth[]" id="item_unit_lastmonth1" data-itemno="1" class="form-control input-sm number_only item_unit_lastmonth"></td>
                                        <td><input type="text" name="item_unit_thismonth[]" id="item_unit_thismonth1" data-itemno="1" class="form-control input-sm number_only item_unit_thismonth"></td>
                                        <td><input type="text" name="item_unit_used[]" id="item_unit_used1" data-itemno="1" class="form-control input-sm number_only item_unit_used"></td>
                                        <td><input type="text" name="item_amount[]" id="item_amount1" data-itemno="1" class="form-control input-sm number_only item_amount" readonly></td>
                                        <td><button type="button" name="remove_row" id="1" class="btn btn-danger btn-xs remove_row">X</button></td>
                                    </tr>
                                    <tr id="row_id_2">
                                        <td><span id="item_no">2</span></td>
                                        <td><input type="text" name="item_name[]" id="item_name2" class="form-control input-sm" value="ประปา (Water)"></td>
                                        <td><input type="text" name="item_price_unit[]" id="item_price_unit2" data-itemno="2" class="form-control input-sm number_only item_price_unit"></td>
                                        <td><input type="text" name="item_unit_lastmonth[]" id="item_unit_lastmonth2" data-itemno="2" class="form-control input-sm number_only item_unit_lastmonth"></td>
                                        <td><input type="text" name="item_unit_thismonth[]" id="item_unit_thismonth2" data-itemno="2" class="form-control input-sm number_only item_unit_thismonth"></td>
                                        <td><input type="text" name="item_unit_used[]" id="item_unit_used2" data-itemno="2" class="form-control input-sm number_only item_unit_used"></td>
                                        <td><input type="text" name="item_amount[]" id="item_amount2" data-itemno="2" class="form-control input-sm number_only item_amount" readonly></td>
                                        <td><button type="button" name="remove_row" id="2" class="btn btn-danger btn-xs remove_row">X</button></td>
                                    </tr>
                                </table>

                                <div align="right">
                                    <button type="button" name="add_row" id="add_row" class="btn btn-success btn-xs">เพิ่มแถว</button>
                                </div>

                            </td>
                        </tr>

                        <tr>
                            <td align="right"><b>Total</b></td>
                            <td align="right"><b><span id="final_total_amount"></span>
                            <span>฿</span></b></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input type="hidden" name="total_item" id="total_item" value="2">
                                <input type="submit" name="create_invoice" id="create_invoice" class="btn btn-info" value="Create">
                            </td>
                        </tr>


                    </table>
                </div>
        </form>

        <script>
            $(document).ready(function() {
                var final_total_amount = $('#final_total_amount').text();
                var count = 2;
                $(document).on('click', '#add_row', function(){
                    count = count + 1;
                    $('#total_item').val(count);
                    var html_code = '';

                    html_code += '<tr id="row_id_'+count+'">';
                    html_code += '<td><span id="item_no">'+count+'</span></td>';

                    html_code += '<td><input type="text" name="item_name[]" id="item_name'+count+'" class="form-control input-sm"></td>';

                    html_code += '<td><input type="text" name="item_price_unit[]" id="item_price_unit'+count+'" data-itemno="'+count+'" class="form-control input-sm number_only item_price_unit"></td>';
                    html_code += '<td><input type="text" name="item_unit_lastmonth[]" id="item_unit_lastmonth'+count+'" data-itemno="'+count+'" class="form-control input-sm number_only item_unit_lastmonth" readonly></td>';
                    html_code += '<td><input type="text" name="item_unit_thismonth[]" id="item_unit_thismonth'+count+'" data-itemno="'+count+'" class="form-control input-sm number_only item_unit_thismonth" readonly></td>';
                    html_code += '<td><input type="text" name="item_unit_used[]" id="item_unit_used'+count+'" data-itemno="'+count+'" class="form-control input-sm number_only item_unit_used"></td>';
                    html_code += '<td><input type="text" name="item_amount[]" id="item_amount'+count+'" data-itemno="'+count+'" class="form-control input-sm number_only item_amount" readonly></td>';

                    html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td></tr>';
                    
                    $('#invoice-item-table').append(html_code);

                
                });
                $(document).on('click', '.remove_row', function(){
                    var row_id = $(this).attr("id");
                    var total_item_amount = $('#item_amount'+row_id).val();
                    var final_amount = $('#final_total_amount').text();
                    var result_amount = parseFloat(final_amount) - parseFloat(total_item_amount);
                    $('#final_total_amount').text(result_amount);
                    $('#row_id_'+row_id).remove();
                    count = count - 1;
                    $('#total_item').val(count);
                });

                function cal_final_total(count) {
                    var final_total_item = 0;
                    for (j=1; j<=count; j++) {

                        var price_unit = 0;
                        var unit_lastmonth = 0;
                        var unit_thismonth = 0;
                        var unit_used = 0;
                        var item_amount = 0;
                        var zero = 0;

                        unit_thismonth = $('#item_unit_thismonth'+j).val();
                        if (unit_thismonth > 0 || unit_thismonth < 0) {
                            unit_lastmonth = $('#item_unit_lastmonth'+j).val();
                            unit_used = parseFloat(unit_thismonth) - parseFloat(unit_lastmonth);
                            if (unit_used == 0) {
                                $('#item_amount'+j).val(zero);
                            }
                            $('#item_unit_used'+j).val(unit_used);
                            final_total_item = parseFloat(final_total_item) + parseFloat(item_amount);
                        }

                        unit_used = $('#item_unit_used'+j).val();
                        if (unit_used > 0 || unit_used < 0) {
                            price_unit = $('#item_price_unit'+j).val();
                            if (price_unit > 0) {
                                item_amount = parseFloat(unit_used) * parseFloat(price_unit);
                                $('#item_amount'+j).val(item_amount);
                            }
                            final_total_item = parseFloat(final_total_item) + parseFloat(item_amount);
                        }

                    }
                    $('#final_total_amount').text(final_total_item);
                }

                
                $(document).on('blur', '.item_price_unit', function() {
                    cal_final_total(count);
                });

                $(document).on('blur', '.item_unit_used', function() {
                    cal_final_total(count);
                });

                $(document).on('blur', '.item_unit_thismonth', function() {
                    cal_final_total(count);
                });
                $(document).on('blur', '.item_unit_lastmonth', function() {
                    cal_final_total(count);
                });

                //หาชื่อเจ้าของห้องในบิล
                $('#invoice_room_id').on('blur', function() {
                    var roomid = $('#invoice_room_id').val();
                    getname_invoice(roomid)
                });

                function getname_invoice(roomid) {
                    $('#invoice_receiver_name').val(roomid);
                }

                $('#create_invoice').click(function() {

                    if ($.trim($('#invoice_room_id').val()).length == 0) {
                        alert("หมายเลขห้องของบิลนี้ ยังว่างอยู่");
                        return false;
                    }

                    if ($.trim($('#invoice_date').val()).length == 0) {
                        alert("กรุณาเลือกวันที่");
                        return false;
                    }

                    for (var i=1; i<=count; i++) {
                        if ($.trim($('#item_name'+i).val()).length == 0) {
                            alert("กรุณาใส่ชื่อรายการ");
                            $('#item_name'+i).focus();
                            return false;
                        }

                        if ($.trim($('#item_price_unit'+i).val()).length == 0) {
                            alert("กรุณาใส่ราคาต่อหน่วย");
                            $('#item_price_unit'+i).focus();
                            return false;
                        }

                        if ($.trim($('#item_unit_used'+i).val()).length == 0) {
                            alert("กรุณาใส่จำนวนหน่วยที่ใช้");
                            $('#item_unit_used'+i).focus();
                            return false;
                        }
                    }

                    $('#invoice_form').submit();

                });

            });
        </script>

        <?php 
        }
    
        else if (isset($_GET["update"]) && isset($_GET["id"])) {
            $sqlresult_getinvoice = $DBCon->getinvoice($_GET["id"]);
            $row_getinvoice = mysqli_fetch_array($sqlresult_getinvoice);
            if ($row_getinvoice > 0) {
                foreach ($sqlresult_getinvoice as $sqlrow) {
                    $getinvoice_note = $sqlrow["Invoice_Note"];
                    $getinvoice_date = $sqlrow["Invoice_Date"];
                    $getinvoice_roomid = $sqlrow["Room_ID"];
                    $getinvoice_memberid = $sqlrow["Member_ID"];
                    $getinvoice_total = $sqlrow["Invoice_Total"]; ?>            
                        <script>
                            $(document).ready(function() {
                                $('#invoice_note').val("<?php echo $getinvoice_note; ?>");
                                $('#invoice_date').val("<?php echo $getinvoice_date; ?>");
                                $('#invoice_room_id').val("<?php echo $getinvoice_roomid; ?>");
                                $('#invoice_member_id').val("<?php echo $getinvoice_memberid; ?>");
                                }                           
                                );
                        </script>

                        <form method="POST" id="invoice_form">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2" align="center"><h2 style="margin-top:11px">Update Invoice Form</h2></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="row">
                                    <div class="col-md-8">
                                    <b>Receiver (BILL TO)</b> <br />
                                    <input type="text" name="invoice_room_id" id="invoice_room_id" class="form-control input-sm" placeholder="Enter Room">
                                    <input type="text" name="invoice_member_id" id="invoice_member_id" class="form-control input-sm" placeholder="ช่องใส่ member ID ชั่วคราว กะว่าจะ Autofill หลังจากกรอกห้อง">
                                    <!-- ยังไม่ทำ! คิดไว้คร่าวๆ คือ เมื่อเลือก Room ID(ดึงค่าจาก member_active) จะดึง Member ID ปัจจุบันมาด้วย แล้วมาแสดงชื่อใน Field-->
                                    <input type="text" name="invoice_receiver_name" id="invoice_receiver_name" class="form-control input-sm" placeholder="Enter Receiver Name">
                                    <b>Note (BILL NOTE)</b> <br />
                                    <input type="text" name="invoice_note" id="invoice_note" class="form-control input-sm" placeholder="Enter Note">
                                    </div>

                                    <div class="col-md-4">
                                    <b>Date (BILL DATE)</b> <br />
                                    <input type="text" name="invoice_date" id="invoice_date" class="form-control input-sm" readonly placeholder="Select Invoice Date">
                                    </div>
                                
                                </div>

                                <table id="invoice-item-table" class="table table-bordered">
                                    <tr>
                                        <th>ITEM_NO.</th>
                                        <th>รายการ</th>
                                        <th>ราคาต่อหน่วย</th>
                                        <th>จำนวนหน่วยเดือนก่อน</th>
                                        <th>จำนวนหน่วยเดือนนี้</th>
                                        <th>จำนวนหน่วยที่ใช้</th>
                                        <th>Amount (Baht)</th>
                                        <th>ลบ</th>
                                    </tr>
                                    <?php
                                    $sqlresult_getinvoice_item = $DBCon->getinvoice_item($_GET["id"]);
                                    $row_getinvoice_item = mysqli_fetch_array($sqlresult_getinvoice_item);
                                    $m = 0;
                                    if ($row_getinvoice_item > 0) {
                                        foreach ($sqlresult_getinvoice_item as $sqlsub_row) {
                                            $m = $m + 1; ?>
                                    <tr id="row_id_<?php echo $m; ?>">
                                        <td><span id="item_no"><?php echo $m; ?></span></td>
                                        <td><input type="text" name="item_name[]" id="item_name<?php echo $m; ?>" class="form-control input-sm" value="<?php echo $sqlsub_row["Item_Name"]; ?>"></td>
                                        <td><input type="text" name="item_price_unit[]" id="item_price_unit<?php echo $m; ?>" data-itemno="<?php echo $m; ?>" class="form-control input-sm number_only item_price_unit" value = "<?php echo $sqlsub_row["Item_Unit_Price"]; ?>"></td>
                                        <td><input type="text" name="item_unit_lastmonth[]" id="item_unit_lastmonth<?php echo $m; ?>" data-itemno="<?php echo $m; ?>" class="form-control input-sm number_only item_unit_lastmonth" value = "<?php echo $sqlsub_row["Item_Unit_LastMonth"]; ?>"></td>
                                        <td><input type="text" name="item_unit_thismonth[]" id="item_unit_thismonth<?php echo $m; ?>" data-itemno="<?php echo $m; ?>" class="form-control input-sm number_only item_unit_thismonth" value = "<?php echo $sqlsub_row["Item_Unit_ThisMonth"]; ?>"></td>
                                        <td><input type="text" name="item_unit_used[]" id="item_unit_used<?php echo $m; ?>" data-itemno="<?php echo $m; ?>" class="form-control input-sm number_only item_unit_used" value = "<?php echo $sqlsub_row["Item_Unit_Used"]; ?>"></td>
                                        <td><input type="text" name="item_amount[]" id="item_amount<?php echo $m; ?>" data-itemno="<?php echo $m; ?>" class="form-control input-sm number_only item_amount"  value = "<?php echo $sqlsub_row["Item_Amount"]; ?>" readonly></td>
                                        <td><button type="button" name="remove_row" id="<?php echo $m; ?>" class="btn btn-danger btn-xs remove_row">X</button></td>
                                    </tr>
                                    <!-- ลองลบออก ถ้าเลขรันไม่ตรงให้เอาออก
                                    <tr id="row_id_2">
                                        <td><span id="item_no">2</span></td>
                                        <td><input type="text" name="item_name[]" id="item_name2" class="form-control input-sm" value="ประปา (Water)"></td>
                                        <td><input type="text" name="item_price_unit[]" id="item_price_unit2" data-itemno="2" class="form-control input-sm number_only item_price_unit"></td>
                                        <td><input type="text" name="item_unit_lastmonth[]" id="item_unit_lastmonth2" data-itemno="2" class="form-control input-sm number_only item_unit_lastmonth"></td>
                                        <td><input type="text" name="item_unit_thismonth[]" id="item_unit_thismonth2" data-itemno="2" class="form-control input-sm number_only item_unit_thismonth"></td>
                                        <td><input type="text" name="item_unit_used[]" id="item_unit_used2" data-itemno="2" class="form-control input-sm number_only item_unit_used"></td>
                                        <td><input type="text" name="item_amount[]" id="item_amount2" data-itemno="2" class="form-control input-sm number_only item_amount" readonly></td>
                                        <td><button type="button" name="remove_row" id="2" class="btn btn-danger btn-xs remove_row">X</button></td>
                                    </tr>
                                    -->
                                    <?php
                                        }
                                    ?>
                                    
                                </table>

                                <div align="right">
                                    <button type="button" name="add_row" id="add_row" class="btn btn-success btn-xs">เพิ่มแถว</button>
                                </div>

                            </td>
                        </tr>

                        <tr>
                            <td align="right"><b>Total</b></td>
                            <td align="right"><b><span id="final_total_amount"><?php echo $getinvoice_total; ?></span>
                            <span>฿</span></b></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input type="hidden" name="total_item" id="total_item" value="<?php echo $m; ?>">
                                <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $sqlsub_row["Invoice_ID"]; ?>">
                                <input type="submit" name="update_invoice" id="update_invoice" class="btn btn-info" value="Update">
                            </td>
                        </tr>


                    </table>
                </div>
        </form>

        <script>
            $(document).ready(function() {
                var final_total_amount = $('#final_total_amount').text();
                var count = <?php echo $m; ?>;
                $(document).on('click', '#add_row', function(){
                    count = count + 1;
                    $('#total_item').val(count);
                    var html_code = '';

                    html_code += '<tr id="row_id_'+count+'">';
                    html_code += '<td><span id="item_no">'+count+'</span></td>';

                    html_code += '<td><input type="text" name="item_name[]" id="item_name'+count+'" class="form-control input-sm"></td>';

                    html_code += '<td><input type="text" name="item_price_unit[]" id="item_price_unit'+count+'" data-itemno="'+count+'" class="form-control input-sm number_only item_price_unit"></td>';
                    html_code += '<td><input type="text" name="item_unit_lastmonth[]" id="item_unit_lastmonth'+count+'" data-itemno="'+count+'" class="form-control input-sm number_only item_unit_lastmonth" readonly></td>';
                    html_code += '<td><input type="text" name="item_unit_thismonth[]" id="item_unit_thismonth'+count+'" data-itemno="'+count+'" class="form-control input-sm number_only item_unit_thismonth" readonly></td>';
                    html_code += '<td><input type="text" name="item_unit_used[]" id="item_unit_used'+count+'" data-itemno="'+count+'" class="form-control input-sm number_only item_unit_used"></td>';
                    html_code += '<td><input type="text" name="item_amount[]" id="item_amount'+count+'" data-itemno="'+count+'" class="form-control input-sm number_only item_amount" readonly></td>';

                    html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td></tr>';
                    
                    $('#invoice-item-table').append(html_code);

                
                });
                $(document).on('click', '.remove_row', function(){
                    var row_id = $(this).attr("id");
                    var total_item_amount = $('#item_amount'+row_id).val();
                    var final_amount = $('#final_total_amount').text();
                    var result_amount = parseFloat(final_amount) - parseFloat(total_item_amount);
                    $('#final_total_amount').text(result_amount);
                    $('#row_id_'+row_id).remove();
                    count = count - 1;
                    $('#total_item').val(count);
                });

                function cal_final_total(count) {
                    var final_total_item = 0;
                    for (j=1; j<=count; j++) {

                        var price_unit = 0;
                        var unit_lastmonth = 0;
                        var unit_thismonth = 0;
                        var unit_used = 0;
                        var item_amount = 0;
                        var zero = 0;

                        unit_thismonth = $('#item_unit_thismonth'+j).val();
                        if (unit_thismonth > 0 || unit_thismonth < 0) {
                            unit_lastmonth = $('#item_unit_lastmonth'+j).val();
                            unit_used = parseFloat(unit_thismonth) - parseFloat(unit_lastmonth);
                            if (unit_used == 0) {
                                $('#item_amount'+j).val(zero);
                            }
                            $('#item_unit_used'+j).val(unit_used);
                            final_total_item = parseFloat(final_total_item) + parseFloat(item_amount);
                        }

                        unit_used = $('#item_unit_used'+j).val();
                        if (unit_used > 0 || unit_used < 0) {
                            price_unit = $('#item_price_unit'+j).val();
                            if (price_unit > 0) {
                                item_amount = parseFloat(unit_used) * parseFloat(price_unit);
                                $('#item_amount'+j).val(item_amount);
                            }
                            final_total_item = parseFloat(final_total_item) + parseFloat(item_amount);
                        }

                    }
                    $('#final_total_amount').text(final_total_item);
                }

                
                $(document).on('blur', '.item_price_unit', function() {
                    cal_final_total(count);
                });

                $(document).on('blur', '.item_unit_used', function() {
                    cal_final_total(count);
                });

                $(document).on('blur', '.item_unit_thismonth', function() {
                    cal_final_total(count);
                });
                $(document).on('blur', '.item_unit_lastmonth', function() {
                    cal_final_total(count);
                });

                //หาชื่อเจ้าของห้องในบิล
                $('#invoice_room_id').on('blur', function() {
                    var roomid = $('#invoice_room_id').val();
                    getname_invoice(roomid)
                });

                function getname_invoice(roomid) {
                    $('#invoice_receiver_name').val(roomid);
                }

                $('#create_invoice').click(function() {

                    if ($.trim($('#invoice_room_id').val()).length == 0) {
                        alert("หมายเลขห้องของบิลนี้ ยังว่างอยู่");
                        return false;
                    }

                    if ($.trim($('#invoice_date').val()).length == 0) {
                        alert("กรุณาเลือกวันที่");
                        return false;
                    }

                    for (var i=1; i<=count; i++) {
                        if ($.trim($('#item_name'+i).val()).length == 0) {
                            alert("กรุณาใส่ชื่อรายการ");
                            $('#item_name'+i).focus();
                            return false;
                        }

                        if ($.trim($('#item_price_unit'+i).val()).length == 0) {
                            alert("กรุณาใส่ราคาต่อหน่วย");
                            $('#item_price_unit'+i).focus();
                            return false;
                        }

                        if ($.trim($('#item_unit_used'+i).val()).length == 0) {
                            alert("กรุณาใส่จำนวนหน่วยที่ใช้");
                            $('#item_unit_used'+i).focus();
                            return false;
                        }
                    }

                    $('#invoice_form').submit();

                });

            });
        </script>

        <?php
                        }
                    }
                }
            }
        
        else {
        ?>
        <h3 align="center">Invoice List</h3> <br />
        <div align="right">
            <a href="invoice.php?add=1" class="btn btn-info btn-xs">Create Invoice</a>
        </div>

        <table id="data-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Invoice Note</th>
                    <th>Invoice Date</th>
                    <th>Room</th>
                    <th>Receiver Name</th>
                    <th>Total</th>
                    <th>PDF</th>
                    <th>EDIT</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <?php
                if ($row_invoicelist > 0) {
                    foreach ($sqlresult_invoicelist as $row) {
                        echo '
                            <tr>
                                <td>'.$row["Invoice_Note"].'</td>
                                <td>'.$row["Invoice_Date"].'</td>
                                <td>'.$row["Room_ID"].'</td>
                                <td>'.$row["F_Name"].'</td>
                                <td>'.$row["Invoice_Total"].'</td>
                                <td>
                                    <a href="print_invoice.php?pdf=1&id='.$row["Invoice_ID"].'">PDF</a>
                                </td>
                                <td>
                                    <a href="invoice.php?update=1&id='.$row["Invoice_ID"].'">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" id="'.$row["Invoice_ID"].'" class="delete">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-backspace-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M15.683 3a2 2 0 0 0-2-2h-7.08a2 2 0 0 0-1.519.698L.241 7.35a1 1 0 0 0 0 1.302l4.843 5.65A2 2 0 0 0 6.603 15h7.08a2 2 0 0 0 2-2V3zM5.829 5.854a.5.5 0 1 1 .707-.708l2.147 2.147 2.146-2.147a.5.5 0 1 1 .707.708L9.39 8l2.146 2.146a.5.5 0 0 1-.707.708L8.683 8.707l-2.147 2.147a.5.5 0 0 1-.707-.708L7.976 8 5.829 5.854z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        ';
                    }
                } ?>
    
    </table>
    <?php
            }
    ?>
    </div>
</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        var table = $('#data-table').DataTable();
    });

    $(document).on('click', '.delete', function() {
        var id = $(this).attr("id");
        if (confirm("คุณต้องการลบบิลนี้ใช้หรือไม่")) {
            window.location.href = "invoice.php?delete=1&id="+id;
        }
        else {
            return false;
        }
    });
</script>