<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<!doctype html>
<html lang="de">

<head>
    <title>Alle Trainings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/training_edit.js"></script>
    <?php include 'includes/navbar.php'; ?>
</head>

<body class="b_body">
    <div class="container text-center">
        <h2 class="header">Alle Trainings</h2>
        <div class="row">
            <?php
            include 'includes/functions.php';
            $result = get_active_exercises_by_tid($_POST['tid']);
            if ($result->num_rows > 0) {
                echo'
                <div class="table-responsive text-center mt-2">
                    <table class="table table-bordered b_table"> 
                    <tr> 
                    <th>Name</th>
                    <th>Entfernen</th>
                    </tr>';
                    
                foreach($result as $item){
                    echo'
                    <tr id="' . $item['id'] . '">
                    <td>' . $item['name'] . '</td>
                    <td><button onClick="exercise_delete_submit(this.id)" 
                    class="btn btn-secondary" id="' . $item['id'] . '_' . $_POST['tid'] . '">Löschen</button></td>
                    </tr>';

                }
                echo'</table>';
            }
            ?>
        </div>
    </div>
</body>

</html>