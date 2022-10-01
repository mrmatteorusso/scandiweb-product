<?php



if (!function_exists('readJSON')) {
    function readJSON()
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}
