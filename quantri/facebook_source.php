<?php
include 'Facebook/autoload.php';
include('fbconfig.php');
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$loginUrl= $helper->getLoginUrl('http://localhost:8888/DoAnWeb/quantri/fb-callback.php', $permissions);
?>
