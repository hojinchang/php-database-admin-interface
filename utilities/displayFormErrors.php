<?php
    if (isset($_SESSION["errorMessages"])) {
        echo "<h3>Errors with Form Processing</h3>";
        echo "<p>Unfortunately the form was not filled out correctly, please address the following issue(s):</p>";
        
        echo "<ul>";
        foreach($_SESSION["errorMessages"] as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";

        // Clear errors
        unset($_SESSION["errorMessages"]);
    }
?>