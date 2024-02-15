<!-- Self processing form -->
<?php
    // Import mySQL database information
    require_once("../dbinfo.php");
    require_once("../globals/globals.php");

    // Start a session
    session_start();

    // Initialize errors array
    $errors = [];
    // Initialize form values
    $studentNumber = "";
    $firstName = "";
    $lastName = "";

    // If the user visits updateStudent.php without filling out the form
    if (!isset($_POST["studentNumber"]) 
        || !isset($_POST["firstName"])
        || !isset($_POST["lastName"])
    ) {
        $_SESSION["message"] = "<p class='bad'>Please use the form to update the student record</p>";
        header("Location: ../main.php");
        exit();
    }

    if (isset($_POST["studentNumber"]) 
        && isset($_POST["firstName"])
        && isset($_POST["lastName"])
    ) {
        // Normalize form data
        $studentNumber = trim($_POST["studentNumber"]);
        $firstName = trim($_POST["firstName"]);
        $lastName = trim($_POST["lastName"]);

        // Check for empty form inputs
        if (empty($firstName)) $errors[] = "Please fill in the first name";
        if (empty($lastName)) $errors[] = "Please fill in the last name";

        if (empty($studentNumber)) {
            $errors[] = "Please fill in the student number";
        } 
        // Check if the entered student number is the required format
        else if (preg_match(STUDENT_NUMBER_REGEX, $studentNumber) !== 1) {
            $errors[] = "Student number should match the format: A0#######";
        }
    }

    // If there are form errors, send them back to updateStudent.php
    if (count($errors) > 0) {
        $_SESSION["message"] = "<p class='bad'>Record NOT updated, missing form values: ".$_SESSION["record"][0]. " " .$_SESSION["record"][1]. " " .$_SESSION["record"][2]."</p>";
        header("Location: ../main.php");
        exit();
    } else {
        $database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (mysqli_connect_errno() != 0) {
            $_SESSION["message"] = "<p class='bad'>Could not connect to the database</p>";
            header("Location: ../main.php");
            exit();
        }

        // Protect against SQL injection
        $studentNumber = $database->real_escape_string($studentNumber);       
        $firstName = $database->real_escape_string($firstName);
        $lastName = $database->real_escape_string($lastName);

        // Get the student record from the session
        $record = $_SESSION["record"];
        $studentNumberRecord = $record[0];

        // Query to update student field
        $query = "UPDATE students SET id='$studentNumber', firstName='$firstName', lastName='$lastName' WHERE id='$studentNumberRecord'";
        $error = "";
        try {
            // Run query
            $result = $database->query($query);
        } catch(Exception $e) {
            $error = $e->getMessage();
            $_SESSION["message"] = "<p class='bad'>$error.<br> Record NOT updated: $studentNumber $firstName $lastName</p>";
            header("Location: ../main.php");
            exit();
        }
        
        if ($database->affected_rows == 0) {
            $_SESSION["message"] = "<p class='bad'>There was a problem updating the student to the database. $error<br>Please try again.</p>";
            header("Location: ../main.php");
            exit();
        }

        $database->close();
        
        // Successfully updated a student into the table, send user back to main.php
        $_SESSION["message"] = "<p class='good'>Record Updated: $studentNumber $firstName $lastName</p>";
        header("Location: ../main.php");
        exit();
    }

    // Delete student record from session
    unset($_SESSION["record"]);
?>