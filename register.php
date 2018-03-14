<?php include('server.php');?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrácia</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="header">
    <h2>Registrácia</h2>
</div>
<div class="form-div">
<form action="register.php" method="post" accept-charset="utf8">
    Prihlasovacie meno: <input type="text" name="username" value="<?php echo $user; ?>"><br>
    Email:              <input type="text" name="email" value=""><br>
    Meno:               <input type="text" name="name" value="<?php echo $name; ?>"><br>
    Priezvisko:         <input type="text" name="surname" value="<?php echo $surname; ?>"><br>
    Heslo:              <input type="password" name="password"><br>
    Potrvdte heslo:     <input type="password" name="passwordcheck"><br><br>
    <button type="submit" style="width: 250px;" class="btn" name="register_user">Registrovať</button><br>
    <br>
    <?php include('errors.php'); ?>
    <p>
        Už ste zaregistrovaný? <a href="login.php">Prihlásiť sa</a>
    </p>
</form>

</div>
</body>
</html>
