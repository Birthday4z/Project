<?php
    session_start();
    include_once('src/function.php');
    $DBCon = new DB_con();

    if (isset($_POST['submit'])) {
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
                echo "<script>window.location.href='admin/admin.php';</script>";
            } elseif ($_SESSION['isAdmin'] == 0) {
                echo "<script>window.location.href='user/user.php'</script>";
            }
        } else {
            echo "<script>sweet_error_autoclose('เกิดข้อผิดพลาด', 'Username หรือ Password ไม่ถูกต้อง', 3000)</script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Management System</title>
    <link rel="stylesheet" href="/project/src/css/bootstrap.min.css">
    <link rel="stylesheet" href="/project/src/css/styles.css">
    <script src="/project/src/js/jquery-3.3.1.min.js"></script>
    <script src="/project/src/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.2.0/anime.min.js"></script>

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
</head>
<body>
<div class="page">
  <div class="container">
    <div class="left">
      <div class="login">LOGIN</div>
      <div class="eula">ยินดีต้อนรับเข้าสู่ระบบจัดการห้องพัก Apartment Management System</div>
    </div>
    <div class="right">
      <svg viewBox="0 0 320 300">
        <defs>
          <linearGradient
                          inkscape:collect="always"
                          id="linearGradient"
                          x1="13"
                          y1="193.49992"
                          x2="307"
                          y2="193.49992"
                          gradientUnits="userSpaceOnUse">
            <stop
                  style="stop-color:#ff00ff;"
                  offset="0"
                  id="stop876" />
            <stop
                  style="stop-color:#ff0000;"
                  offset="1"
                  id="stop878" />
          </linearGradient>
        </defs>
        <path d="m 40,120.00016 239.99984,-3.2e-4 c 0,0 24.99263,0.79932 25.00016,35.00016 0.008,34.20084 -25.00016,35 -25.00016,35 h -239.99984 c 0,-0.0205 -25,4.01348 -25,38.5 0,34.48652 25,38.5 25,38.5 h 215 c 0,0 20,-0.99604 20,-25 0,-24.00396 -20,-25 -20,-25 h -190 c 0,0 -20,1.71033 -20,25 0,24.00396 20,25 20,25 h 168.57143" />
      </svg>
      <div class="form">
        <form method="POST">
        <label for="email">บัญชีผู้ใช้ (Username)</label>
        <input type="text" id="username" name="username" autocomplete="off" required>
        <label for="password">รหัสผ่าน (Password)</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" id="submit" name="submit" value="Submit">
        <form>
      </div>
    </div>
  </div>
</div>

</body>
</html>

<script type="text/javascript">
var current = null;
document.querySelector('#username').addEventListener('focus', function(e) {
  if (current) current.pause();
  current = anime({
    targets: 'path',
    strokeDashoffset: {
      value: 0,
      duration: 700,
      easing: 'easeOutQuart'
    },
    strokeDasharray: {
      value: '240 1386',
      duration: 700,
      easing: 'easeOutQuart'
    }
  });
});
document.querySelector('#password').addEventListener('focus', function(e) {
  if (current) current.pause();
  current = anime({
    targets: 'path',
    strokeDashoffset: {
      value: -336,
      duration: 700,
      easing: 'easeOutQuart'
    },
    strokeDasharray: {
      value: '240 1386',
      duration: 700,
      easing: 'easeOutQuart'
    }
  });
});
document.querySelector('#submit').addEventListener('focus', function(e) {
  if (current) current.pause();
  current = anime({
    targets: 'path',
    strokeDashoffset: {
      value: -730,
      duration: 700,
      easing: 'easeOutQuart'
    },
    strokeDasharray: {
      value: '530 1386',
      duration: 700,
      easing: 'easeOutQuart'
    }
  });
});
</script>"