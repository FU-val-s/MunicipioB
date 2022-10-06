<?php

//Call Google API Client

//Load library
require './vendor/autoload.php';

//Set client

$client = new \Google_Client();
$client->setApplicationName('Google Sheets and PHP');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig('./credentials.json');
$service = new Google_Service_Sheets($client);

//Request and read data from Sheet

$spreadsheetId = "1XCdVYdUFrtJRZQGp5DJhqp86mpQpEY3aYw-LEoTrVBk";
$range = "Capa_final_integrada_con_modif";

$result = $service->spreadsheets_values->get($spreadsheetId, $range);
$sheet = $result->getValues();

$headers = array_shift($sheet);


// Combine the headers with each following row

$data = array();
foreach ($sheet as $row) {
    $copy = array_pad($row,16,"0");
    $aux = array_combine($headers, $copy);
    array_push($data , $aux);
}

//print_r($data);

//Generate .json file.

file_put_contents('markersData.json', json_encode($data));



?>