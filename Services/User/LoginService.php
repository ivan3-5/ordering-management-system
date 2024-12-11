<?php
    include '../NoAuthDbConnection.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT Id, Password, Email, FirstName, LastName, PhoneNumber, Address, UserRole FROM users WHERE Email = ?";
    $statement = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($statement, $sql)) {
        mysqli_stmt_bind_param($statement, "s", $email);
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $id, $hash, $email, $firstname, $lastname, $phone_number, $address, $user_role);
        mysqli_stmt_fetch($statement);

        if ($hash && password_verify($password, $hash, )) {
            session_start();
            $_SESSION['id'] = $id;
            $_SESSION['email'] = $email;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['PhoneNumber'] = $phone_number;
            $_SESSION['Address'] = $address;
            $_SESSION['UserRole'] = $user_role;
            
            echo json_encode(array("status" => "success", "message" => "Login successful!"));
            // header("Location: UserProfile.php");
            // exit();
        } else {
            echo json_encode(array("status" => "error", "message" => "Invalid email or password."));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Database error."));
    }
?>