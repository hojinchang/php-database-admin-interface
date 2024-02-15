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
            <h2>Update a student...</h2>
            
            <!-- Self processing form -->
            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                <?php 
                    // If the student visits the updateStudent.php page by clicking the update student link, save the student record
                    if (isset($_GET["record"])) {
                        $record = $_GET["record"];
                        $record = unserialize(urldecode($record));
                        $_SESSION["record"] = $record;
                    } else {   // Send the user back to main.php if they visit this page without clicking the link
                        $_SESSION["message"] = "<p class='bad'>Please select a student to update.</p>";
                        header("Location: ./main.php");
                        exit();
                    }
                ?>

                <fieldset>
                    <legend>Update a record</legend>
                    
                    <fieldset>
                        <legend>New data</legend>

                        <div class=form-input-container>
                            <label for="studentNumber">Student #:</label>
                            <input 
                                type="text" 
                                id="studentNumber"
                                name="studentNumber"
                                value=<?php echo isset($_SESSION["record"]) ? $_SESSION["record"][0] : ""; ?>
                            />
                        </div>
                        <div class=form-input-container>
                            <label for="firstName">First Name:</label>
                            <input 
                                type="text" 
                                id="firstName" 
                                name="firstName" 
                                value=<?php echo isset($_SESSION["record"]) ? $_SESSION["record"][1] : ""; ?>
                            />
                        </div>
                        <div class=form-input-container>
                            <label for="lastName">Last Name:</label>
                            <input 
                                type="text" 
                                id="lastName" 
                                name="lastName"
                                value=<?php echo isset($_SESSION["record"]) ? $_SESSION["record"][2] : ""; ?>
                            />
                        </div>
                    </fieldset>

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