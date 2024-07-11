<?php
// Assuming you have already established a database connection ($conn)
include("../config/db.php");
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the search query from the request
    $searchQuery = isset($_GET['query']) ? $_GET['query'] : '';
    // Perform a basic validation on the search query
    if (empty($searchQuery)) {
        echo json_encode(['error' => 'Search query is required.']);
        exit;
    }

    // Sanitize the search query to prevent SQL injection (using mysqli_real_escape_string)
    $searchQuery = $conn->real_escape_string($searchQuery);

    // Perform the database query
    $query = "SELECT tblProduct_P_PK AS id, tblProduct_P_Name AS name, tblProduct_P_SKU AS sku FROM tblproduct_p WHERE tblProduct_P_Name LIKE '%$searchQuery%' OR tblProduct_P_SKU LIKE '%$searchQuery%'";

    $result = $conn->query($query);

    // Check if the query was successful
    if ($result) {
        // Fetch the results as an associative array
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        // Output the results as JSON
        echo json_encode($rows);
    } else {
        // Query failed, output an error
        echo json_encode(['error' => 'Error executing the database query: ' . $conn->error]);
    }

    // Close the database connection
    $conn->close();
}
?>
