<?php
    session_start();
    include_once('../../src/function.php');
    if ($_SESSION['Member_ID'] == "" or $_SESSION['isAdmin'] == 0 ) {
        header("location: ../../index.php");
    }
    else {
    $DBCon = new DB_con();
    $sqlresult_petitionlist = $DBCon->getpetitionlist();
    $row_petitionlist = mysqli_num_rows($sqlresult_petitionlist);
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
    <title>Petition Management</title>
</head>

<body>
<?php include_once "../admin_header.php" ?>
    <div class="container-fluid">
    <h3 align="center">Petition List</h3> <br />

        <table id="data-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Petition_Transaction_ID</th>
                    <th>Petition_ID</th>
                    <th>Room_ID</th>
                    <th>ชื่อเจ้าของห้อง</th>
                    <th>Date_Create</th>
                    <th>Date_Admit</th>
                    <th>Description</th>
                    <th>isFinished</th>
                </tr>
            </thead>
            <?php
                if ($row_petitionlist > 0) {
                    foreach ($sqlresult_petitionlist as $row) {
                        echo '
                            <tr>
                                <td>'.$row["Petition_Transaction_ID"].'</td>
                                <td>'.$row["Petition_ID"].'</td>
                                <td>'.$row["Room_ID"].'</td>
                                <td>'.$row["F_Name"].'</td>
                                <td>'.$row["Date_Create"].'</td>
                                <td>'.$row["Date_Admit"].'</td>
                                <td>'.$row["Description"].'</td>
                                <td>'.$row["isFinished"].'</td>
                            </tr>
                        ';
                    }
                } ?>
                    </table>
    </div>
    </body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        var table = $('#data-table').DataTable();
    });
</script>

<?php
}
?>