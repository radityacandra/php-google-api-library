<?php

require_once __DIR__.'/vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfig('client_id.json');
$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);

echo $_SESSION['access_token']; exit;

if (isset($_SESSION['access_token'])) {
	echo "aaaaaaaa"; exit;
    $client->setAccessToken($_SESSION['access_token']);
    $drive_service = new Google_Service_Drive($client);
    $files_list = $drive_service->files->listFiles(array())->getItems();
    echo json_encode($files_list);
} else {
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/coba/oauth2callback.php';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
