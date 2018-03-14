<?php
session_start();

// Holds the Google application Client Id, Client Secret and Redirect Url
require_once('settings.php');

// Holds the various APIs involved as a PHP class. Download this class at the end of the tutorial
require_once('google-login-api.php');

// Google passes a parameter 'code' in the Redirect Url
if(isset($_GET['code'])) {
    try {
        $gapi = new GoogleLoginApi();
        
        // Get the access token 
        $data = $gapi->GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);

        // Access Tokem
        $access_token = $data['access_token'];
        
        // Get user information
        $user_info = $gapi->GetUserProfileInfo($access_token);

        echo '<pre>';print_r($user_info); echo '</pre>';

        // Now that the user is logged in you may want to start some session variables
        $_SESSION['logged_in'] = 1;

        // You may now want to redirect the user to the home page of your website
        // header('Location: home.php');
    }
    catch(Exception $e) {
        echo $e->getMessage();
        exit();
    }
}

class GoogleLoginApi
{
    public function GetAccessToken($client_id, $redirect_uri, $client_secret, $code) {  
        $url = 'https://www.googleapis.com/oauth2/v4/token';            
    
        $curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type=authorization_code';
        $ch = curl_init();      
        curl_setopt($ch, CURLOPT_URL, $url);        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        
        curl_setopt($ch, CURLOPT_POST, 1);      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);    
        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);      
        if($http_code != 200) 
            throw new Exception('Error : Failed to receieve access token');
        
        return $data;
    }
}

class GoogleLoginApi
{
    public function GetUserProfileInfo($access_token) { 
        $url = 'https://www.googleapis.com/plus/v1/people/me';          
    
        $ch = curl_init();      
        curl_setopt($ch, CURLOPT_URL, $url);        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));
        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);     
        if($http_code != 200) 
            throw new Exception('Error : Failed to get user information');
        
        return $data;
    }
}
?>