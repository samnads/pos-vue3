<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function RESPONSE($success = false, $type = 4, $timeout = 5000, $message = null, $errors = null)
{
    $types = array(
        0 => 'success',
        1 => 'danger',
        2 => 'warning',
        3 => 'info',
        4 => 'primary',
        5 => 'secondary',
        6 => 'light',
        7 => 'dark',
    );
    if (is_array($message)) {
        $type = 1;
        $message = '<strong>Database error , </strong>' . ($message['message'] ? $message['message'] : "Unexpected error occured !");
    }
    $array = array(
        'success' => $success ? true : false,
        'type' => $types[$type],
        'timeout' => $timeout,
        'message' => $message,
        'errors' => $errors
    );
    echo json_encode($array);
    die();
}
