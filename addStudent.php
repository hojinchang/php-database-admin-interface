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
            <h2>Add a student...</h2>

            <?php
                // Display form processing errors if they exist
                require_once("./utilities/displayFormErrors.php");
            ?>
            
            <!-- Self processing form -->
            <form action="./utilities/addStudentProcessor.php" method="POST">
                <fieldset>
                    <legend>Add a record</legend>
                    
                    <div class=form-input-container>
                        <label for="studentNumber">Student #:</label>
                        <input type="text" id="studentNumber" name="studentNumber" />
                    </div>
                    <div class=form-input-container>
                        <label for="firstName">First Name:</label>
                        <input type="text" id="firstName" name="firstName" />
                    </div>
                    <div class=form-input-container>
                        <label for="lastName">Last Name:</label>
                        <input type="text" id="lastName" name="lastName" />
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