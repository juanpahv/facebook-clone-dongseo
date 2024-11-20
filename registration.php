<?php
echo "Hello World!";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "facebook";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $month = $_POST['month'];
  $day = $_POST['day'];
  $year = $_POST['year'];
  $gender = $_POST['gender'];
  $email = $_POST['emailPhone'];
  $phone = $_POST['emailPhone'];
  $password = $_POST['password'];
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

$birthday = $year . "-" . $month . "-" . $day;

$sql = "INSERT INTO facebook_profile (first_name, last_name, birthday, gender, email, phone, password) VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param("sssssss", $firstName, $lastName, $birthday, $gender, $email, $phone, $hashed_password);

if ($stmt->execute() === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
