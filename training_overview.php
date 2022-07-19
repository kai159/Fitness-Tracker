<!doctype html>
<html lang="de">

<head>
    <title>Alle Trainings</title>
    <link rel="stylesheet" href="css/alternate.css">
    <link rel="stylesheet" href="css/training_overview.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/navbar.php'; ?>
</head>

<body>
    <h2 class="header">Alle Trainings</h2>
    <div class="main">
        <?php
        include 'includes/functions.php';
        $result = get_all_training();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="element">
                <div class="searchable"><h3><a class="col_blue" href="training.php?training=' . $row['id'] . '">' . $row['name'] . '</a></h3>
                <p>' . $row['description'] . '</p> </div>
                <img class="picture" src="data:image/jpeg;base64,' . base64_encode($row['picture']) . '"/> 
                <br>';
                if ($_SESSION['tid'] != $row['id']) {
                    echo '<form action="includes/training_overview.inc.php" method="post">
                    <input type="hidden" name="training_id" value="' . $row['id'] . '" > <br>
                    <button type="submit" name="training_overview_submit">Aktivieren</button> <br>
                    </form></div>
                    ';
                } else {
                    echo '</div>';
                }
            }
        } else {
            echo '<p>Bitte legen Sie zunächst ein Training an.
        Dies finden Sie unter Training => <a class="col_blue" href="training_create.php">Training</a> erstellen.</p>';
        }
        ?>
    </div>
</body>

</html>