<!DOCTYPE html>
<html lang="sk">
<head>
    <title>Cvičenie 4</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v1.2.14/dist/jBox.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/StephanWagner/jBox@v1.2.14/dist/jBox.all.min.css" rel="stylesheet">
    <script src="js/javascript.js"></script>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="icon" href="images/icon.png">

</head>
<body class="container">
<header>
    <span class="welcome-header">Webová stránka</span>
</header>
<div class="container border">
    <main>

        <div class="row">
            <button id="downloadCSV" type='button' class='btn btn-success edit-button'>Stiahnuť csv</button>
            <button id="refreshDBS" type='button'  class='btn btn-warning edit-button'>Refreshnúť databázu</button>
            <button id="refreshTABLE" type='button'  class='btn btn-danger edit-button'>Refreshnúť tabuľku</button>
                <table class="table-m"  id="table" >
                    <thead>
                    <tr>
                        <th>Meno</th>
                        <th>Priezvisko</th>
                        <?php
                        include "lectures.php";
                        ?>
                        <th>Účasť</th>
                        <th>Čas</th>
                    </tr>
                    </thead>
                        <tbody>
                            <?php
                            include "refreshTable.php";
                            ?>
                        </tbody>
                </table>
        </div>
    </main>
</div>

<footer class="footer">
    ©PeterRigoDevelopment
</footer>

<div id="loading" class="center-screen"><img class="loading-img" alt="ha"  src="images/loading.gif"></div>
<div id="overlay" class="overlay"></div>
</body>
</html>
