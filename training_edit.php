<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<!doctype html>
<html lang="de">

<head>
    <title>Training editieren</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/training_edit.js"></script>
    <?php include 'includes/navbar.php'; ?>
</head>

<body class="b_body">
    <div class="container text-center">
        <h2 class="header">Training editieren</h2>
        <div class="row">
            <?php
                include 'includes/functions.php';
                $result_training = get_single_training_active($_GET['tid']);
                if (!$result_training->num_rows > 0) {
                    header('Location: /training_overview.php');
                    exit();
                }
                $result = get_active_exercises_by_tid($_GET['tid']);
                $row = $result_training->fetch_assoc();

                // First block with image
                echo '
                <div class="row">
                <div class="col-xxl-4 col-lg-4 order-first"></div>
                <div class="col-xxl-4 col-lg-4 shadow-sm px-4 mt-3" style="min-width: 350px;">
                <h3 onclick="extra_hidden()">' . $row['name'] . '</h3>
                <p>' . $row['description'] . '</p> 
                <img class="mb-4" style="width:270px; height:120px;" src="data:image/jpeg;base64,' . base64_encode($row['picture']) . '"/>
                </div>';


                // Table with delete options
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
                        class="btn btn-secondary" id="' . $item['id'] . '_' . $_GET['tid'] . '">Löschen</button></td>
                        </tr>';
                    }
                    echo'</table>';
                }
                // Options for editing
                echo'
                <div class="row">
                    <div class="col-xxl-6 col-lg-6 mt-3">        
                        <form enctype="multipart/form-data" action="includes/training.inc.php" method="post">
                            <label for="changed_descr">Wählen Sie eine Beschreibung aus:</label><br>
                            <input type="text" name="changed_descr" placeholder="Beschreibung ändern"> <br>
                            <input type="hidden" name="name_tr" value="' . $row['name'] . '">
                            <input type="hidden" name="id_tr" value="' . $row['id'] . '">
                            <button class="btn btn-secondary btn-sm" type="submit" name="update_descr">Ändern</button> <br>
                        </form>
                    </div>
                    <div class="col-xxl-6 col-lg-6 mt-3">
                        <form class="form_img"  enctype="multipart/form-data" action="includes/training.inc.php" method="post">
                            <label for="file">Wählen Sie ein Bild aus:</label><br>
                            <input name="file" id="file" type="file" accept=".jpg, .jpeg, .png" style="margin-top:5px;border:none;" /> <br>
                            <input type="hidden" name="name_tr" value="' . $row['name'] . '">
                            <input type="hidden" name="id_tr" value="' . $row['id'] . '">
                            <button class="btn btn-secondary btn-sm" type="submit" name="update_img">Ändern</button> <br>
                        </form>
                    </div>
                    <div class="col-xxl-4 col-lg-3 mt-3"></div>
                    <div class="col-xxl-4 mt-3">
                        <form action="includes/training_edit.inc.php" method="post">
                            <label for="file">Komplettes Training löschen:</label><br>
                            <input type="hidden" name="id_tr" value="' . $row['id'] . '">
                            <button class="btn btn-secondary btn-sm" type="submit" name="delete_submit">Löschen</button> <br>
                        </form>
                    </div>
                </div>';
            ?>
        </div>
    </div>
</body>

</html>