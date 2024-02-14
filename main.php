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

<!-- Set sort order -->
<?php
    $sortOrder = "id";
    $validChoices = ["id", "firstname", "lastname"];

    if (isset($_GET["sort"])) {
        // If a valid sort query string was sent, set the sort order
        if (in_array($_GET["sort"], $validChoices)) {
            $sortOrder = $_GET["sort"];
        } else {
            $_SESSION["errorMessages"] = [$_GET['choice']." is not a valid sort choice!"];
            header("Location: ../main.php");
            exit();
        }
    }
?>

<body>
    <!-- Import header -->
    <?php
        require_once("./components/header.php");
    ?>

    <main>
        <section class="scriptDemo">
            <h2>Administering DB From a Form</h2>
            <?php
                echo "<p>Hello <b>". ucfirst($_SESSION["username"]) ."</b>. You are authorized to view the content.</p>";

                // Display message
                if (isset($_SESSION["message"])) {
                    echo $_SESSION["message"];
                    unset($_SESSION["message"]);
                }
            ?>

            <h3>Students:</h3>
            <a class="add-student" href="./addStudent.php">Add a Student</a>

            <?php 
                // Connect to database
                $database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                if (mysqli_connect_errno() != 0) {
                    $_SESSION["errorMessages"] = ["Could not connect to the database"];
                    header("Location: ../index.php");
                    exit();
                }

                // Query select every student
                $sortOrder = $database->real_escape_string($sortOrder);
                $query = "SELECT id, firstname, lastname FROM students ORDER BY $sortOrder;";
                $results = $database->query($query);

                if ($results->num_rows > 0) {
                    // Get table fields
                    $tableFields = $results->fetch_fields();

                    // Display the students in a table
                    echo "<table>";
                    echo "<tr>";
                    foreach($tableFields as $field) {
                        if ($field->name == "id" || $field->name == "firstname" || $field->name == "lastname") {
                            echo "<th><a class='table-link' href='". $_SERVER["PHP_SELF"]. "?sort=$field->name'>". ucfirst($field->name) ."</a></th>";
                        } else {
                            echo "<th>$field->name</th>";
                        }
                    }

                    echo "<th>Delete</th>";
                    echo "<th>Update</th>";
                    echo "</tr>";

                    while($record = $results->fetch_row()) {
                        echo "<tr>";
                        foreach($record as $data) {
                            echo "<td>$data</td>";
                        }

                        echo "<td><a class='table-link' href='./deleteStudent.php'>delete</a></td>";
                        echo "<td><a class='table-link' href='./updateStudent.php'>update</a></td>";

                        echo "</tr>";
                    }

                    echo "</table>";
                }
            ?>
        </section>

        <section class="scriptDemo">
            <a class="logout" href="./logout.php">Logout</a>
        </section>
    </main>


    <!-- Import footer -->
    <?php
        require_once("./components/footer.php");
    ?>
    
</body>
</html>