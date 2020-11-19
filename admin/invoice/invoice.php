<?php
    include_once('../../src/function.php');
    $DBCon = new DB_con();

    $sqlresult_invoicelist = $DBCon->getinvoicelist();
    $row_invoicelist = mysqli_num_rows($sqlresult_invoicelist);
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

    <link rel="stylesheet" href="/project/src/css/datepicker.css">
    <script src="/project/src/js/bootstrap-datepicker.js"></script>
    <script>
        $(document).ready(function() {
            $('#invoice_date').datepicker({
                format: "yyyy-mm-dd",
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
                                    To,<br />
                                    <b>Receiver (BILL TO)</b> <br />
                                    <input type="text" name="invoice_receiver_name" id="invoice_receiver_name" class="form-control input-sm" placeholder="Enter Receiver Name">
                                    </div>

                                    <div class="col-md-4">
                                    Reverse Charge <br />>

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
                                <input type="hidden" name="total_item" id="total_item" value="1">
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

                $('#create_invoice').click(function() {

                    if ($.trim($('#invoice_receiver_name').val()).length == 0) {
                        alert("กรุณาเลือกผู้รับบิล");
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
            } else {
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
                                <td>'.$row["Invoice_Room"].'</td>
                                <td>'.$row["Invoice_Receiver_Name"].'</td>
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
</script>