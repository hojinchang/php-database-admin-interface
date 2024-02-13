<?php 
    require_once("./globals/globals.php");

    if (isset($_SESSION["activeTime"])
        && isset($_SESSION["username"])
    ) {
        $inactiveTime = time() - $_SESSION["activeTime"];

        if ($inactiveTime > TIMEOUT_IN_SECONDS) {
            $_SESSION["errorMessages"] = ["You have been logged out due to inactivity"];
            header("Location: logout.php");
            exit();
        } else {
            // Reset last active
            $_SESSION['activeTime'] = time();
        }
    } else {
        $_SESSION["errorMessages"] = ["Please log in to view content"];
        header("Location: index.php");
        exit();
    }
?>