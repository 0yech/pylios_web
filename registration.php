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

if (isset($_POST['delete']))
{
    if ($_SESSION['is_admin'] == 1)
    {
        db_execute("DELETE FROM registrations WHERE author_id = ?", array($_POST['delete']));
        die();
    }
}

if (!isset($_GET['author']))
{
    header('Location: /');
    die();
}

if (!is_numeric($_GET['author']) || strlen($_GET['author']) != 18)
{
    header('Location: /');
    die();
}

$registration = db_query('SELECT * FROM registrations WHERE author_id = ?', array($_GET['author']));

if (count($registration) == 0)
{
    die('No registration found with that author id');
}

$registration = $registration[0];

$pictures_contest = explode("\n", $registration['pictures_contest']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js" integrity="sha512-RdSPYh1WA6BF0RhpisYJVYkOyTzK4HwofJ3Q7ivt/jkpW6Vc8AurL1R+4AUcvn9IwEKAPm/fk7qFZW3OuiUDeg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

    <div class="container" style="margin-top: 35px; margin-bottom: 40px; text-align: center;">
        <h1><?= $registration['ingame_name'] ?></h1>      
    </div>
    <div class="container" style="text-align: center; margin-bottom: 40px;">
        <h3>Forum name: <span style="margin-left: 20px"><?= $registration['forum_name'] ?></h3>      
    </div>   
    <?php 
        if ($_SESSION['is_admin'] === 1)
        {
    ?>
    <div class="container" style="text-align: center; margin-bottom: 40px;">
        <button type="button" class="btn btn-danger" style="width: 200px">Disqualify</button>      
    </div>   
    <?php
        }
    ?>
    <div class="container-fluid" style="max-width: 2000px;">
        <h3>Picture IGN</h3>    
        <img style='margin: 0 50px 50px 0; width: 20rem;' src='<?= $registration['pictures_ign'] ?>'>
    </div>  
    <div class="container-fluid" style="max-width: 2000px;">
        <h3>Pictures Contest</h3>    
        <?php
            foreach($pictures_contest as $image)
            {
                echo "<img style='margin: 0 50px 50px 0; width: 20rem;' src='".$image."'>";
            }
        ?>
    </div>   
</body>

<?php 
    if ($_SESSION['is_admin'] === 1)
    {
?>
    <script>
        $(document).ready(function() {
            $('button').click(function() {
                bootbox.confirm("Are you sure to disqualify this user ? /!\\ This can't be undone /!\\", function(result) {
                    if (result)
                    {
                        $.post("registration.php", { delete: "<?= $_GET['author'] ?>" }, function(data) {
                                alert("User Disqualified");
                                location.href = "/";
                        });
                    }
                });    
                
                $(".bootbox-close-button").remove();
                $(".bootbox-accept").text("Yes");
                $(".bootbox-accept").attr("class", "btn btn-danger bootbox-accept");
            })
        });
    </script>
<?php
    }
?>