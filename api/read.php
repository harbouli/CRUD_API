<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function msg($success, $status, $message, $extra = [])
{
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ], $extra);
}

// INCLUDING DATABASE AND MAKING OBJECT
include_once('../config/db.php');
$db = new Database();
$connection = $db->dbConnection();

$returnData = [];
if ($_SERVER["REQUEST_METHOD"] != "GET") :
    $returnData = msg(0, 404, 'Page Not Found!');
else :
    $statemnt  = $connection->prepare("SELECT * FROM crud_tb ORDER BY created_at DESC");
    $statemnt->execute();
    $users = $statemnt->fetchAll(PDO::FETCH_ASSOC);


    $returnData = msg(1, 200, $users);

endif;

echo json_encode($returnData);
