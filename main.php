<!-- Import global variables and head components -->
<?php
    // Import globals
    require_once("./globals/globals.php");

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
            <h2>Administering DB From a Form</h2>
            <h3>Students:</h3>

            <a class="add-student" href="./addStudentPage.php">Add a Student</a>
        </section>
    </main>


    <!-- Import footer -->
    <?php
        require_once("./components/footer.php");
    ?>
    
</body>
</html>