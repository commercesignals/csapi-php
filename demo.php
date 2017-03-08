<?php
const CERT_FILE_NAME = '';
const API_KEY = '';
const API_BASE = '';

require_once(__DIR__ . '/Comsig/Rest/Client.php');

use Comsig\Rest\Client;

$cert = file_get_contents(__DIR__ . '/' . CERT_FILE_NAME);

$client = new Client(API_KEY, $cert, API_BASE);

print_r($client->getSignals());

