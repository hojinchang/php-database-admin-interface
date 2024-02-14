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

    // If the user visits addStudent.php without filling out the form
    if (!isset($_POST["studentNumber"]) 
        || !isset($_POST["firstName"])
        || !isset($_POST["lastName"])
    ) {
        $_SESSION["message"] = "<p class='bad'>Please use the form to add students</p>";
        header("Location: ./main.php");
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

        if (empty($firstName)) $errors[] = "Please fill in the first name";
        if (empty($lastName)) $errors[] = "Please fill in the last name";

        if (empty($studentNumber)) {
            $errors[] = "Please fill in the student number";
        } else if (preg_match(STUDENT_NUMBER_REGEX, $studentNumber) !== 1) {
            $errors[] = "Studen number should match the format: A0#######";
        }
    }

    if (count($errors) > 0) {
        $_SESSION["errorMessages"] = $errors;
        header("Location: ../addStudent.php");
        exit;
    }
?>