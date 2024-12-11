<?php 
    include '../DbConnector.php';

    // Retrieve user data from the database using the session email
    $email = $session_email;
    $sql = "SELECT FirstName, LastName FROM users WHERE Email = ?";
    $statement = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($statement, $sql)) {
        mysqli_stmt_bind_param($statement, "s", $email);
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $firstname, $lastname);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close($statement);

        echo json_encode(array("status" => "success", "Email" => $email, "FirstName" => $firstname, "LastName" => $lastname));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error fetching user data"));
    }

?>