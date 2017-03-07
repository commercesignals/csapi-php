<?php
const CERT_FILE_NAME = '';
const API_KEY = '';
const API_BASE = '';

define('__ROOT__', dirname(__FILE__));
require_once(__ROOT__ . '/Comsig/Rest/Client.php');

use Comsig\Rest\Client;

$cert = file_get_contents(__ROOT__ . '/' . CERT_FILE_NAME);

$client = new Client(API_KEY, $cert, API_BASE);
