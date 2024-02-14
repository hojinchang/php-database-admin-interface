<!-- Import global variables and head components -->
<?php
    // Import globals
    require_once("./globals/globals.php");

    // Import Head component
    require_once("./components/head.php");

    session_start();
?>

<body>
    <!-- Import header -->
    <?php
        require_once("./components/header.php");
    ?>

    <main>
        <section class="objectives">
            <h2>Objectives</h2>
            <p>Write a secure database administration interface.</p>
        </section>

        <section class="scriptDemo">
            <h2>Script Demo</h2>

            <?php
                require_once("./utilities/displayFormErrors.php");
            ?>

            <form action="./utilities/loginProcessor.php" method="POST">
                <div class="form-input-container">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username">
                </div>
                <div class="form-input-container">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">
                </div>

                <div class="button-container">
                    <button type="submit">Login</button>
                </div>
            </form>
        </section>
    </main>


    <!-- Import footer -->
    <?php
        require_once("./components/footer.php");
    ?>
    
</body>
</html>