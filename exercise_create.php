<!doctype html>
<html lang="de">

<head>
    <title>Übung erstellen</title>
    <link rel="stylesheet" href="css/logregdivs.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/navbar.php'; ?>
</head>

<body>
    <div class="center borderpadding">
        <h2>Übung erstellen</h2>
        <form enctype="multipart/form-data" action="includes/exercise_create.inc.php" method="post">
            <input type="text" name="name_ex" placeholder="Name" autofocus><br>
            <input type="text" name="description" placeholder="Beschreibung"> <br>
            <label for="file">Wählen Sie ein Bild aus:</label><br>
            <input name="file" id="file" type="file" accept=".jpg, .jpeg, .png" style="margin-top:5px;border:none;" />
            <br>
            <button type="submit" name="exercise_submit">Erstellen</button> <br>
        </form>

        <?php
        // Fehlermeldungen
        isset($_GET['ms']) ? $message = $_GET['ms'] : $message = '';
        if ($message !== '') {
            switch ($message) {
                case 'success';
                    echo '<p>Übung erfolgreich erstellt</p>';
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