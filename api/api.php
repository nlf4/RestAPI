<?php
require_once '../lib/autoload.php';
require_once  'access_control.php';
$TaskService = $Container->getTaskService();
$uri_count = 5;

// Get URI parts
$uri_parts = explode( "/", $_SERVER["REQUEST_URI"]);

// Count URI parts
$count = count( $uri_parts );

// Divide URI parts
$last_part = end( $uri_parts );
$penultimate_part = $uri_parts[ $count - 2 ];

// Execute function based on URI
if ( $count == $uri_count AND $last_part == 'taken' ) {
    switch( $_SERVER['REQUEST_METHOD'] ) {
        case 'GET':
            $TaskService->read();
            return true;
        case 'POST':
            $TaskService->create();
            return true;
        default:
            echo 'Unvalid request method';
            return false;
    }
}

if ( $count == $uri_count + 1 AND $penultimate_part == "taak" ){
    switch( $_SERVER['REQUEST_METHOD'] ) {
        case 'GET':
            $TaskService->read_single( $last_part );
            return true;
        case 'PUT':
            $TaskService->update( $last_part );
            return true;
        case 'DELETE':
            $TaskService->delete( $last_part );
            return true;
        default:
            echo 'Unvalid request method';
            return false;
    }
}