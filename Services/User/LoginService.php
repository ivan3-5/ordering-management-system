<?php
include '../NoAuthDbConnection.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT Id, Password, Email, FirstName, LastName, PhoneNumber, Address, UserRole FROM users WHERE Email = ?";
$statement = $conn->prepare($sql);
$statement->bind_param("s", $email);
$statement->execute();
$result = $statement->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hash = $row['Password'];

    if (password_verify($password, $hash)) {
        session_start();
        $_SESSION['id'] = $row['Id'];
        $_SESSION['email'] = $row['Email'];
        $_SESSION['firstname'] = $row['FirstName'];
        $_SESSION['lastname'] = $row['LastName'];
        $_SESSION['PhoneNumber'] = $row['PhoneNumber'];
        $_SESSION['Address'] = $row['Address'];
        $_SESSION['UserRole'] = $row['UserRole'];

        echo json_encode(array("status" => "success", "message" => "Login successful!"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Invalid password."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Email not found."));
}
?>