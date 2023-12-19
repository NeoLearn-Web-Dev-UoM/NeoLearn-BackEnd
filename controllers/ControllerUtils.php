<?php

namespace controllers;

class ControllerUtils
{
    public static function sendErrorResponse($code, $message)
    {
        header('Content-Type: application/json');
        http_response_code($code);

        $response = [
            'message' => $message
        ];

        echo json_encode($response);

        // Stop the execution of the script
        exit();
    }

    public static function sendSuccessResponse($code, $data)
    {
        header('Content-Type: application/json');
        http_response_code($code);

        echo json_encode($data);
    }
}