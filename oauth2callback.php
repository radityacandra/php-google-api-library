<?php
require_once __DIR__.'/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('client_id.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/coba/oauth2callback.php');
$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);

if (! isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
}

if (isset($_SESSION['access_token'])) {
    $client->setAccessToken($_SESSION['access_token']);
    $drive_service = new Google_Service_Drive($client);
    $files_list = $drive_service->files->listFiles(array())->getFiles();
    echo json_encode($files_list);
}