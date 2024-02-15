<!-- Import global variables and head components -->
<?php
    // Import globals
    require_once("./globals/globals.php");
    require_once("./dbinfo.php");

    // Import Head component
    require_once("./components/head.php");

    session_start();
    require_once("./utilities/sessionGuard.php");
?>

<body>
    <!-- Import header -->
    <?php
        require_once("./components/header.php");
    ?>

    <main>
        <section class="scriptDemo">
            <h2>Delete a student...</h2>

            <!-- Self processing form processing -->
            <?php 
                // Initialize for values
                $deleteStudent = "";

                if (isset($_POST["deleteStudent"])) {
                    $deleteStudent = trim($_POST["deleteStudent"]);
                    // If the user submitted yes
                    if ($deleteStudent == "yes") {
                        $database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        if (mysqli_connect_errno() != 0) {
                            $_SESSION["message"] = "<p class='bad'>Could not connect to the database</p>";
                            header("Location: ./main.php");
                            exit();
                        }

                        // Get the student record from the session
                        $record = $_SESSION["record"];
                        $studentNumber = $record[0];

                        // Deletion query
                        $query = "DELETE FROM students WHERE id='$studentNumber';";
                        $result = $database->query($query);

                        ($database->affected_rows > 0) 
                            ? $_SESSION["message"] = "<p class='good'>Record Deleted: ".$record[0]." ".$record[1]." ".$record[2]."</p>"
                            : $_SESSION["message"] = "<p class='bad'>Record NOT Deleted.</p>";

                        $database->close();
                    // If the user submitted no
                    } else {
                        $_SESSION["message"] = "<p class='bad'>Record NOT Deleted.</p>";
                    }

                    // Delete student record from session
                    unset($_SESSION["record"]);

                    header("Location: ./main.php");
                    exit();
                }
            ?>
            
            <!-- Self processing form -->
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                <fieldset>
                    <legend>Delete a record - Are you sure?</legend>
                    
                    <?php
                        // If the student visits the deleteStudent.php page by clicking the delete student link, save the student record
                        if (isset($_GET["record"])) {
                            $record = $_GET["record"];
                            $record = unserialize(urldecode($record));
                            // Store the student record in the session
                            $_SESSION["record"] = $record;

                            // Output the student that will be deleted 
                            echo "<p>".$record[0]." ".$record[1]." ".$record[2]."</p>";
                        } else {   // Send the user back to main.php if they visit this page without clicking the link
                            $_SESSION["message"] = "<p class='bad'>Please select a student to delete.</p>";
                            header("Location: ./main.php");
                            exit();
                        }
                    ?>

                    <div class="form-input-container">
                        <input type="radio" id="yes" name="deleteStudent" value="yes">
                        <label for="yes">Yes</label>
                    </div>

                    <div class="form-input-container">
                        <input type="radio" id="no" name="deleteStudent" value="no">
                        <label for="no">No</label>
                    </div>

                    <div class="button-container">
                        <button type="submit">Submit</button>
                    </div>
                </fieldset>
            </form>
        </section>
        <section class="scriptDemo">
            <a class="link" href="./main.php">Back to Admin Page</a>
        </section>
    </main>


    <!-- Import footer -->
    <?php
        require_once("./components/footer.php");
    ?>
    
</body>
</html>