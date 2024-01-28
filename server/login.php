<?php
// Database connection parameters
$host = 'localhost';
$username = 'admin';
$password = 'Teamesteem2022@#';
$database = 'u643938962_teamesteem';

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to validate user login
function validateLogin($username, $password) {
    global $conn;

    // Sanitize input (to prevent SQL injection)
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Query the database for the user
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        // User credentials are valid
        return true;
    } else {
        // User credentials are invalid
        return false;
    }
}

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get username and password from the request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate login
    $isValidLogin = validateLogin($username, $password);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode(['success' => $isValidLogin]);
}

// Close the database connection
$conn->close();
?>