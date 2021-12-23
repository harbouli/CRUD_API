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


$statemnt = $connection->prepare('SELECT * FROM crud_tb WHERE id =:id');

$statemnt->bindValue(':id', $id);

$statemnt->execute();
$user = $statemnt->fetch(PDO::FETCH_ASSOC);

$returnData = msg(1, 200, $user,);

$data = json_decode(file_get_contents("php://input"));
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($data->firstname);
    $lastname = trim($data->lastname);
    $email = trim($data->email);
    if (empty($firstname)) :
        $erorrs[] = 'Please Enter Your Firstname';

    elseif (empty($lastname)) :
        $erorrs[] = 'Please Enter Your lastname';

    elseif (empty($email)) :
        $erorrs[] = 'Please Enter Your email';
    elseif (empty($erorrs)) :


        $statemnt = $connection->prepare("UPDATE  crud_tb  SET firstname = :firstname , lastname = :lastname , email= :email WHERE id =:id");


        $statemnt->bindValue(':firstname', $firstname);
        $statemnt->bindValue(':lastname', $lastname);
        $statemnt->bindValue(':email', $email);
        $statemnt->bindValue(':id', $id);

        $statemnt->execute();

        $returnData = msg(1, 201, 'You have successfully ADD New User.');
    endif;
}
echo json_encode($returnData);
