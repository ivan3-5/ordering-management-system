<?php
  include '../NoAuthDbConnection.php';
  
  $firstName = $_POST["fname"];
  $lastName = $_POST["lname"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $phoneNumber = $_POST["pnumber"];
  $address = $_POST["address"];

  $message = '';

  if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($phoneNumber) || empty($address)) {
    $message = "All fields are required.";
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $message = "Invalid email format.";
  } else if (strlen($password) < 8) {
    $message = "Password must be at least 8 characters long.";
  }

  if (!empty($message)) {
    echo json_encode(array("status" => "error", "message" => $message));
    return;
  }

  // $sql = "INSERT INTO users (FirstName, LastName, Email, Password, PhoneNumber, Address, DateCreated, DateUpdated)" 
  //     . "VALUES ('" . $frstName . "', '" . $lastName . "', '" . $email . "', '" . $password . "', '" . $phoneNumber . "', " 
  //     . "'" . $address . "', '" . date("Y/m/d") . "', '" . date("Y/m/d")  . "')";

  $hash = password_hash($password, PASSWORD_DEFAULT);
  $dateCreated = date("Y/m/d");
  $dateUpdated = date("Y/m/d");
  $userRole = "user";

  $sql = "INSERT INTO users (FirstName, LastName, Email, Password, PhoneNumber, Address, UserRole, DateCreated, DateUpdated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_stmt_init($conn);
  
  if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "sssssssss", $firstName, $lastName, $email, $hash, $phoneNumber, $address, $userRole, $dateCreated, $dateUpdated);
      if (mysqli_stmt_execute($stmt)) {
        echo json_encode(array("status" => "success", "message" => "Account created successfully!"));
      } else {
        echo json_encode(array("status" => "error", "message" => "Error creating account. Please try again later."));
      }
  } else {
      echo "<div class='alert alert-danger'>Database error. Please contact support.</div>";
  }
      
  // if ($conn->query($sql) === TRUE) {
  //   echo json_encode(array("status" => "success", "message" => "Account created successfully!"));
  // } else {
  //   echo json_encode(array("status" => "error", "message" => "Error creating account. Please try again later."));
  // }
?>