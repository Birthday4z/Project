<?php
    session_start();
    include_once('src/function.php');
    $DBCon = new DB_con();

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $sqlresult = $DBCon->login($username, $password);
        $num = mysqli_fetch_array($sqlresult);

        if ($num > 0) {
            $_SESSION['Member_ID'] = $num['Member_ID'];
            $_SESSION['Username'] = $num['Username'];
            $_SESSION['Firstname'] = $num['F_Name'];
            $_SESSION['Lastname'] = $num['L_Name'];
            $_SESSION['Phone'] = $num['Phone'];
            $_SESSION['isAdmin'] = $num['isAdmin'];

            if ($_SESSION['isAdmin'] == 1) {
                //echo "<script>alert('Admin Login Successful!');</script>";
                echo "<script>window.location.href='admin/admin.php';</script>";
            } elseif ($_SESSION['isAdmin'] == 0) {
                echo "<script>window.location.href='user/user.php'</script>";
            }
        } else {
            echo "<script>sweet_error_autoclose('เกิดข้อผิดพลาด', 'Username หรือ Password ไม่ถูกต้อง', 2000)</script>";
            //echo '<meta http-equiv="refresh" content="2;url=index.php" />';
            //echo "<script>alert('Login Error!');</script>";
            //echo "<script>window.location.href='index.php';</script>";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <link rel="stylesheet" href="/project/src/css/bootstrap.min.css">
    <script src="/project/src/js/jquery-3.3.1.min.js"></script>
    <script src="/project/src/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
</head>

<body>

    <div class="container">
        <h1 class="mt-5">Login Page</h1>

        <hr>
        <form method="POST">
            <div class="mb-3">
                <div class="form-group">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-person" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M12 1H4a1 1 0 0 0-1 1v10.755S4 11 8 11s5 1.755 5 1.755V2a1 1 0 0 0-1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z" />
                        <path fill-rule="evenodd" d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                    </svg>
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-key-fill" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                    </svg>
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
            </div>
            <button type="submit" name="login" class="btn btn-primary">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right-square-fill"
                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm2.5 8.5a.5.5 0 0 1 0-1h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5z" />
                </svg> Login
            </button>

        </form>
    </div>

</body>

</html>