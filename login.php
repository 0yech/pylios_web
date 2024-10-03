<?php
ob_start();

session_start();

$error = "";

$login = "aaa";
$password = "aaa";

$loginRO = "ElsEU";
$passwordRO = "xxx";

if ($_POST)
{
    if (!isset($_POST['user']) || !isset($_POST['pwd'])) die();
   
    $user = htmlspecialchars($_POST['user'], ENT_QUOTES);
    $pwd = htmlspecialchars($_POST['pwd'], ENT_QUOTES);

    if ($user === $login && sha1($pwd) === $password)
    {        
        $_SESSION['logged_in'] = 1;
        $_SESSION['is_admin'] = 1;
        
        header('Location: index.php');
    }
    else if ($user === $loginRO && sha1($pwd) === $passwordRO)
    {
        $_SESSION['logged_in'] = 1;
        $_SESSION['is_admin'] = 0;

        header('Location: index.php');
    }
    else
    {
        $error = '<span style="color: red">Wrong Username/Password</span>';
    }
}

ob_end_flush();

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
    <div class="container" style="width: 500px; margin-top: 100px;">
        <form method="POST">
            <div class="mb-3">
                <label for="usernameInput" class="form-label">Username</label>
                <input name="user" type="text" class="form-control" id="usernameInput">
            </div>
            <div class="mb-3">
                <label for="passwordInput" class="form-label">Password</label>
                <input name="pwd" type="password" class="form-control" id="passwordInput">
                <?= $error ?>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>