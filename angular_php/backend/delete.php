<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

// include database connection
include 'config.php';
 
try {
    // get record ID
    $id = isset($_GET['user_name']) ? $_GET['user_name'] : die(json_encode(array('result' => 'fail', 'message' => 'Record ID not found.')));
 
    // delete query
    $query = "DELETE FROM user_data WHERE user_name = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
     
    if ($stmt->execute()) {
        // Return success response as JSON
        http_response_code(200);
        echo json_encode(array('result' => 'success'));
    } else {
        // Return failure response as JSON
        http_response_code(500);
        echo json_encode(array('result' => 'fail', 'message' => 'Failed to delete record.'));
    }
} catch (PDOException $exception) {
    // Return error response as JSON
    http_response_code(400);
    echo json_encode(array('result' => 'error', 'message' => $exception->getMessage()));
}
} else {
    // Return error response for other request methods
    http_response_code(405);
    echo json_encode(array('result' => 'error', 'message' => 'Method not allowed.'));
}
?>
