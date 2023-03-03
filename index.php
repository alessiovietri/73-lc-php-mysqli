<?php

    var_dump($_GET);

    define("DB_SERVERNAME", "localhost");
    define("DB_USERNAME","root");
    define("DB_PASSWORD", "root");
    define("DB_NAME", "db_university");

    // var_dump(DB_SERVERNAME);
    // var_dump(DB_USERNAME);
    // var_dump(DB_PASSWORD);
    // var_dump(DB_NAME);
    
    // Connect
    $conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // echo '<h1>CONN</h1>';
    // var_dump($conn);
    
    // Check connection
    if ($conn && $conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
    }
    else{
        if (isset($_GET['id'])) {
            $departmentId = $_GET['id'];
            $sql = "SELECT id, name, head_of_department FROM departments WHERE id = $departmentId";
            //      SELECT id, name, head_of_department FROM departments WHERE id = 3
        }
        else{
            $sql = "SELECT id, name, head_of_department FROM departments";
        }
        $result = $conn->query($sql);

        // var_dump($result->fetch_fields());
        
        $conn->close();
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHP + MYSQLi</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col">

                    <h1>
                        Departments
                    </h1>
                    
                    <?php 

                        if (isset($_GET['id'])) {
                            echo '<a href="index.php">Torna alla lista</a>';
                        }  


                        if ($result && $result->num_rows > 0) {
                    ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <?php

                                        foreach ($result->fetch_fields() as $singleField) {
                                    ?>
                                        <th scope="col"><?php echo $singleField->name; ?></th>
                                    <?php
                                        }

                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    for ($i = 0; $i < $result->num_rows; $i++) {
                                        $singleDepartment = $result->fetch_assoc();
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $singleDepartment['id']; ?></th>
                                        <td>
                                            <a href="index.php?id=<?php echo $singleDepartment['id']; ?>">
                                                <?php echo $singleDepartment['name']; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $singleDepartment['head_of_department']; ?></td>
                                    </tr>
                                <?php
                                    }

                                ?>
                            </tbody>
                        </table>
                    <?php
                        }
                        else if ($result) {
                            echo "<h2>0 results</h2>";
                        }
                        else {
                            echo "<h2>query error</h2>";
                        }
                        
                    ?>

                </div>
            </div>
        </div>

    </body>
</html>