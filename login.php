<?php
//$configs = include('config.php');

include('server.php');
require_once('config.php');
$login_url = $gClient->createAuthUrl();
//$login_url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';

//<a class='login' href="<?= $login_url "><img class='login' src="img/google.png" width="250px" size="54px"></a><br>
?>
<!DOCTYPE html>
<html>
<head>
    <title>Zadanie 3</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="google-site-verification" content="Jovhct3Wf5_TonHFAo-99qJT1Nh2BV6IVm2iE5JeMtE" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
</head>
<body>
  <div class="header">
    	<h2>Login</h2>
    </div>
    <div class="form-div">
    <form method="post" action="login.php">

    	<div class="input-group">
    		<label>Username</label>
    		<input type="text" name="username" >
    	</div>
    	<div class="input-group">
    		<label>Password</label>
    		<input type="password" name="password">
    	</div><br>
    	<div class="input-group">
    		<button type="submit" class="btn" id="btnLogin" name="login_user"></button><button class="ais" name="ais"></button><br>
    	</div><br>
        <div class="input-group">
        <button type="submit" onclick="window.location = '<?php echo $login_url ;?>'" class="googleBtn" name="google"></button>
        </div><br>
    	<p>
    		Nie ste zaregistrovaný?<br><a class="buttonLike" href="register.php">Registrovať sa</a>
    	</p>
      <?php include('errors.php'); ?>
    </form>
    </div>
</body>
</html>
