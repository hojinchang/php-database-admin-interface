<!-- Import global variables and head components -->
<?php
    // Import globals and config scripts
    require_once("./globals/globals.php");

    // Import Head component
    require_once("./components/head.php");  
?>

<body>
    <!-- Import header -->
    <?php
        require_once("./components/header.php");
        session_start();
    ?>

    <main>
        <section class="scriptDemo">
            <h2>Log Out</h2>
            <?php
                if (isset($_SESSION["errorMessages"])) {
                    echo "<ul>";
                    foreach($_SESSION["errorMessages"] as $error) {
                        echo "<li>$error</li>";
                    }
                    echo "</ul>";

                    unset($_SESSION["errorMessages"]);
                }

                if (isset($_SESSION["activeTime"])) {
                    $username = ucfirst($_SESSION["username"]);
                    $totalTimeLoggedIn = time() - $_SESSION["activeTime"];
    
                    echo "<p>You were logged in for $totalTimeLoggedIn seconds. Thanks for your time, <b>$username</b>!</p>";
            
                    // Stop session and delete session variables
                    $_SESSION = [];
                    session_destroy();
                }
            ?>

            <a class="link" href="./index.php">Back to login</a>

        </section>
    </main>


    <!-- Import footer -->
    <?php
        require_once("./components/footer.php");
    ?>
    
</body>
</html>