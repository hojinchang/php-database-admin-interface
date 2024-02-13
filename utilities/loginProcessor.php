<?php
    // Import mySQL database information
    require_once("../dbinfo.php");

    // Start a session
    session_start();

    // Initialize errors array
    $errorMessages = [];
    // Initialize form values
    $username = "";
    $password = "";

    // If the user visits loginProcessor.php without filling out the form
    if (!isset($_POST["username"]) || !isset($_POST["password"])) {
        $_SESSION["errorMessages"] = ["Please fill in the login form"];
        header("Location: ../index.php");
        exit();
    }

    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        // Check for empty inputs
        if (empty($username)) $errorMessages[] = "Please fill in your username";
        if (empty($password)) $errorMessages[] = "Please fill in your password";

        // Redirect users back to login form if they didnt fill out the username or password
        if (count($errorMessages) > 0) {
            $_SESSION["errorMessages"] = $errorMessages;
            header("Location: ../index.php");
            exit();
        }

        // Connect to MySQL database
        $database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        // Determine if database connection was successful
        if (mysqli_connect_errno() != 0) {
            $_SESSION["errorMessages"] = ["Could not connect to the database"];
            header("Location: ../index.php");
            exit();
        }

        // Protext against SQL injection
        $username = $database->real_escape_string($username);
        $password = $database->real_escape_string($password);

        // Query to see if username exists in the secure_users table
        $query = "SELECT username, password FROM secure_users WHERE BINARY username='$username'";
        $result = $database->query($query);

        if ($result->num_rows != 1) {
            $_SESSION["errorMessages"] = ["The username: <b>$username</b> is not in our database"];
            header("Location: ../index.php");
            exit();
        }

        // Get the user
        $record = $result->fetch_assoc();
        $hashedPassword = $record["password"];

        // Check if the entered password matches the password in the databse
        if (!password_verify($password, $hashedPassword)) {
            $_SESSION["errorMessages"] = ["The password is incorrect"];
            header("Location: ../index.php");
            exit();
        } 

        $database->close();
    }

    if (count($errorMessages) > 0) {
        $_SESSION["errorMessages"] = $errorMessages;
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION["username"] = $username;
        $_SESSION["activeTime"] = time();

        header("Location: ../main.php");
        exit();
    }

?>