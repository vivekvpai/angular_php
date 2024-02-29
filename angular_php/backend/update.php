<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if JSON data was sent
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data) {
        include 'config.php';
        try {
            // write update query
            // in this case, it seemed like we have so many fields to pass and 
            // it is better to label them and not use question marks
            $query = "UPDATE user_data 
                        SET user_password=:v_password 
                        WHERE user_name = :v_user_name";

            // prepare query for execution
            $stmt = $con->prepare($query);

            // posted values
            $v_user_name = $data['user_name'];
            $v_password = $data['password'];

            // bind the parameters
            $stmt->bindParam(':v_user_name', $v_user_name);
            $stmt->bindParam(':v_password', $v_password);


            // Execute the query
            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(array('result' => 'success'));
            } else {
                http_response_code(500);
                echo json_encode(array('result' => 'fail'));
            }
        }

        // show errors
        catch (PDOException $exception) {
            http_response_code(400);
            echo json_encode(array('result' => 'error', 'message' => $exception->getMessage()));
        }
    } else {
        // Return error response if JSON decoding failed
        http_response_code(400);
        echo json_encode(array('result' => 'error', 'message' => 'Invalid JSON data'));
    }
}else {
    // Return error response for other request methods
    http_response_code(405);
    echo json_encode(array('result' => 'error', 'message' => 'Method not allowed.'));
}
?>
