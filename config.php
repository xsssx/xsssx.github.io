<?php
$host = "localhost";
$dbuser = "root";
$password = "Login.?1";
$dbname = "zadanie3";

session_start();
require_once "GoogleAPI/vendor/autoload.php";
$gClient = new Google_Client();
$gClient->setClientId("806452915011-avmq7n2212m2sg81b6lkidhh6e55kqgb.apps.googleusercontent.com");
$gClient->setClientSecret("TF_EYscwr5ufMS7zaZQf1nvQ");
$gClient->setApplicationName("Login");
$gClient->setRedirectUri("http://webtechholubnik.sk/Zadanie%203/login.php");
$gClient->addScope("https://www.googleapis.com/auth/plus.login https://accounts.google.com/o/oauth2/v2/auth?scope= https://www.googleapis.com/auth/userinfo.email");
//$login_url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';
?>