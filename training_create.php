<!doctype html>
<html lang="de">

<head>
    <title>Training erstellen</title>
    <link rel="stylesheet" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/navbar.php'; ?>
</head>

<body class="b_body">
    <div class="container mt-5 text-center">
        <h2>Training erstellen</h2>
        <form enctype="multipart/form-data" action="includes/training_create.inc.php" method="post">
        <div class="row">            
            <div class="col-lg-3 col-md-3"></div>   
            <div class="col-lg-6 col-md-6">
                <div class="row">
                    <div class="col-6 offset-3">
                        <input class="form-control mt-3 text-center" type="text" name="name_ex" placeholder="Name" autofocus>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6 offset-3">
                        <input class="form-control text-center" type="text" name="description" placeholder="Beschreibung">
                    </div>           
                <div class="row mt-3">
                    <div class="col-6 offset-3">
                        <label for="file">Wählen Sie ein Bild aus:</label><br>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6 offset-3">
                        <input class="form-control"  name="file" id="file" type="file" accept=".jpg, .jpeg, .png"  stlye="margin-left: 10px">
                    </div>
                </div>
            </div>  
            <div class="col justify-content-md-center">
                <button class="btn btn-secondary mt-2" type="submit" name="training_submit">Erstellen</button>
            </div>
            </form>
        </div>
        <br>
        <?php
        // Fehlermeldungen
        isset($_GET['ms']) ? $message = $_GET['ms'] : $message = '';
        if ($message !== '') {
            switch ($message) {
                case 'success';
                    echo '<p><a class="col_blue" href="training.php?training=' . $_GET['train_id'] . '">Training</a> erfolgreich erstellt</p>';
                    break;
                case 'empty':
                    echo '<p>Eingabefelder sind unvollständig</p>';
                    break;
                case 'error':
                    echo '<p>Fehler bei dem Hochladen der Datei</p>';
                    break;
                case 'size':
                    echo '<p>Die Datei ist zu groß</p>';
                    break;
                case 'format':
                    echo '<p>Die Datei hat ein Falsches Format</p>';
                    break;
                case 'db';
                    echo '<p>Fehler an der Datenbank. Bitte versuchen Sie es später erneut</p>';
                    break;
                case 'taken';
                    echo '<p>Der Name ist schon vergeben </p>';
                    break;
                case 'fail';
                    echo '<p>Bitte versuchen Sie es später erneut</p>';
                    break;
            }
        }
        ?>     
    </div>           
</body>

</html>