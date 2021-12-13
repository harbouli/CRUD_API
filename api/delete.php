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
$id = $_GET['id'] ??  null;
// IF REQUEST METHOD IS NOT GET
if ($_SERVER["REQUEST_METHOD"] != "GET") :
    $returnData = msg(0, 404, 'Page Not Found!');
else :
    $statment = $connection->prepare('DELETE FROM crud_tb WHERE id =:id');
    $statment->bindValue(':id', $id);
    $statment->execute();
    $returnData = msg(1, 200, 'User Has Been Deleted');

endif;
echo json_encode($returnData);
