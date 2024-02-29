<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //include database connection
    include 'config.php';

    try {
        // Check if ID is provided
        if(isset($_GET['user_name'])) {
            // Specific ID is provided
            $id = $_GET['user_name'];
            // prepare select query for specific ID
            $query = "SELECT * FROM user_data WHERE user_name = ?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $id);
        } else {
            // No specific ID provided, return all records
            $query = "SELECT * FROM user_data";
            $stmt = $con->prepare($query);
        }

        // execute query
        $stmt->execute();

        // fetch records
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($rows) {
            // Return records data as JSON
            http_response_code(200);
            echo json_encode(array('result' => 'success', 'data' => $rows));
        } else {
            // Return failure response if no records found
            http_response_code(500);
            echo json_encode(array('result' => 'fail', 'message' => 'No records found.'));
        }
    }

    // show error
    catch (PDOException $exception) {
        // Return error response as JSON
        http_response_code(400);
        echo json_encode(array('result' => 'error', 'message' => $exception->getMessage()));
    }
}else {
    // Return error response for other request methods
    http_response_code(405);
    echo json_encode(array('result' => 'error', 'message' => 'Method not allowed.'));
}
?>
