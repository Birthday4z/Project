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
    <link rel="stylesheet" href="/project/src/css/bootstrap.min.js">
    <script src="/project/src/js/jquery-3.3.1.min.js"></script>
    <script src="/project/src/js/bootstrap.min.js"></script>

    <script src="/project/src/js/jquery.dataTables.min.js"></script>
    <script src="/project/src/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="/project/src/css/dataTables.bootstrap4.min.css">
    <title>Invoice</title>
</head>
<body>
    
    <div class="container-fluid">
        <h3 align="center">Invoice List</h3> <br />
        <div align="right">
        
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
                if($row_invoicelist > 0) {
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

                            </tr>
                        
                        ';
                    }
                }
            ?>

    </div>
    
    </table>

</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        var table = $('#data-table').DataTable();
    });
</script>