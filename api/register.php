<?php
// Headers required for React to talk to PHP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';
include_once 'objects/User.php';

// Get Database Connection
$database = new Database();
$db = $database->getConnection();

// Instantiate User object
$user = new User($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->name) &&
    !empty($data->email) &&
    !empty($data->password)
){
    // Assign values
    $user->name = $data->name;
    $user->email = $data->email;
    $user->password = $data->password;
    $user->role = !empty($data->role) ? $data->role : 'student'; // Default to student

    // Create user
    if($user->create()){
        http_response_code(201);
        echo json_encode(array("message" => "User was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create user."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data. Name, email and password required."));
}
?>