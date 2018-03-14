<?php
  session_start();

  $configs = include('config.php');
  $conn = mysqli_connect($host, $dbuser, $password, $dbname);
  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="google-site-verification" content="Jovhct3Wf5_TonHFAo-99qJT1Nh2BV6IVm2iE5JeMtE" />
</head>
<body>

<div class="header">
  <h2>Home Page</h2>
</div>
<div class="form-div">
    <!-- notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
        <h3>
          <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
          ?>
        </h3>
      </div>
    <?php endif ?>

    <?php  if (isset($_SESSION['username'])) :
      $username = $_SESSION['username'];
      $query = "SELECT * FROM user WHERE username='$username';";
      $result = mysqli_query($conn, $query);
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['name'] = $row['name'];
        $_SESSION['surname'] = $row['surname'];
      }
      ?>
      <p>Vitaj <strong><?php echo $_SESSION['name']." ".$_SESSION['surname']; ?></strong></p>
        <a class="btn" href="stats.php?id=<?php echo $row['id'];?>">Zoznam prihlaseni</a><br><br>
      <a class="buttonLike" href="index.php?logout='1'">Odhlasenie</a>
    <?php endif; ?>
    <?php

    ?>
</div>

</body>
</html>
