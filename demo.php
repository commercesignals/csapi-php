<?php
const CERT_FILE_NAME = '';
const API_KEY = '';
const API_BASE = '';

require_once(__DIR__ . '/CommerceSignals/API.php');

$cert = file_get_contents(__DIR__ . '/' . CERT_FILE_NAME);

$api = new CommerceSignals\API(API_KEY, $cert, API_BASE);

$signalId = 'signal-id';

// View all signal requests
$requests = $api->signals($signalId)
              ->requests()
              ->get();

$requestId = 'request-id';

// View results from a signal request
$requests = $api->signals($signalId)
              ->requests($requestId)
              ->results()
              ->get();

