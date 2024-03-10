<?php
// Script written by DProvat. 
// Please contact us if there are any errors or problems with usage. https://arprovat.com/
// Connect to database
$servername = "localhost";
$username = "arprovat_Developer";
$password = "Your_Password";
$dbname = "Your_DataBase_Name";

// Establish secure connection with error handling
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500); 
    error_log("Connection failed: " . $conn->connect_error);
    echo "Database connection failed. Please try again later.";
    exit;
}
// ***You can also write the above codes on separate pages. 
// Then include that page at the top of each PHP script.
// Why not the above code is only used for database connection.


// Check request method and action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Handle data submission

  if (!isset($_POST['date']) || !isset($_POST['time']) || !isset($_POST['systolic']) || !isset($_POST['diastolic'])) {
    http_response_code(400); // Bad request
    echo "Required data missing. Please provide all fields.";
    exit;
  }

  $date = $conn->real_escape_string($_POST['date']);
  $time = $conn->real_escape_string($_POST['time']);
  $systolic = (int)$_POST['systolic']; // Enforce integer type for safety
  $diastolic = (int)$_POST['diastolic']; // Enforce integer type for safety

  // Prepare and execute SQL statement with error handling
  $sql = "INSERT INTO blood_pressure (date, time, systolic, diastolic) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);

  if (!$stmt) {
    http_response_code(500);
    echo "Failed to prepare SQL statement.";
    exit;
  }

  $stmt->bind_param("ssss", $date, $time, $systolic, $diastolic);

  if (!$stmt->execute()) {
    http_response_code(500);
    echo "Failed to execute SQL statement.";
    exit;
  }

  // Success response
  http_response_code(201); 
  echo "Blood pressure data saved successfully.";

  $stmt->close();
} else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_data') {
  // Handle data retrieval for history page

  $sql = "SELECT * FROM blood_pressure ORDER BY date DESC"; 
  $result = $conn->query($sql);

  if (!$result) {
    http_response_code(500);
    echo "Failed to retrieve data.";
    exit;
  }

  $data = array(); // Array to store retrieved data

  while ($row = $result->fetch_assoc()) {
    $data[] = $row; 
  }

  $result->close();
  header('Content-Type: application/json'); 
  echo json_encode($data); // Encode data array as JSON and send response
} else {
  // Handle invalid request methods
  http_response_code(405); 
  echo "Invalid request method. Only POST and GET with action 'get_data' are allowed.";
  exit;
}

$conn->close(); // Close database connection
?>
