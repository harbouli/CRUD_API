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


$data = json_decode(file_get_contents("php://input"));
$returnData = [];

// IF REQUEST METHOD IS NOT POST
if ($_SERVER["REQUEST_METHOD"] != "POST") :
    $returnData = msg(0, 404, 'Page Not Found!');
else :
    $firstname = trim($data->firstname);
    $lastname = trim($data->lastname);
    $email = trim($data->email);


    if (empty($firstname)) :
        $returnData[] = 'Please Enter Your Firstname';

    elseif (empty($lastname)) :
        $returnData[] = 'Please Enter Your lastname';

    elseif (empty($email)) :
        $returnData[] = 'Please Enter Your email';
    elseif (empty($returnData)) :


        $statemnt = $connection->prepare("INSERT INTO crud_tb (firstname , lastname , email) VALUES (:firstname , :lastname , :email)");


        $statemnt->bindValue(':firstname', $firstname);
        $statemnt->bindValue(':lastname', $lastname);
        $statemnt->bindValue(':email', $email);

        $statemnt->execute();

        $returnData = msg(1, 201, 'You have successfully ADD New User.');
    endif;


endif;
echo json_encode($returnData);
