<?php
session_start();

if (!isset($_SESSION['logged_in']))
{
    header('Location: /login.php');
    die();
}

if (isset($_POST['btnLogout']))
{
    session_destroy();
    header('Location: /login.php');
    die();
}

include "db.inc.php";
$registrations = db_query('SELECT * FROM registrations', array());

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Elios</title>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-text">
                Elios
            </span>
            <span class="navbar-text">
                <form method="POST">
                    <button name="btnLogout" type="submit" class="btn btn-secondary">Logout</button>
                </form>
            </span>
        </div>
    </nav>  
    
    <div class="container" style="margin-top: 35px; margin-bottom: 100px; text-align: center;">
        <img style="width: 25vw;" src="https://media.discordapp.net/attachments/491543374550007828/987138889485525022/unknown.png"></img>
    </div>  
    

    <div class="container-fluid" style="max-width: 1170px;">

    <?php
        for($i = 0; $i < count($registrations); $i++)
        {
    ?>
            <div class="card" style="width: 20rem; margin: 0 40px 40px 0; display: inline-block;">
                <img src="<?= explode("\n", $registrations[$i]["pictures_contest"])[0] ?>" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($registrations[$i]["ingame_name"], ENT_QUOTES) ?></h5>
                    <p class="card-text"><?= "Image contest: " . count(explode("\n", $registrations[$i]["pictures_contest"])) ?></p>
                    <a href="/registration.php?author=<?= $registrations[$i]['author_id'] ?>" class="btn btn-primary">More information</a>
                </div>
        </div>
    <?php
        }
    ?>
    </div>
</body>
</html>

<?php

?>