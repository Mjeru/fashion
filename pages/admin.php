<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';

ini_set('session.name', "session_id");
ini_set('session.cookie_lifetime', 1200);
session_start();

$login = $_COOKIE["login"] ?? "";
$isAuth = null;
$showForm = isset($_GET["login"]) && $_GET["login"] == "yes";
$logOut = isset($_GET["login"]) && $_GET["login"] == "esc";


function authentication($login, $password): array
{
    $connect = getConnect();
    if (mysqli_errno($connect)){
        echo '{"status":"error", "text": "'. mysqli_error($connect) .'"}';
        die();
    }
    $login = mysqli_real_escape_string($connect, $login);
    $password = mysqli_real_escape_string($connect, $password);
    $result =  mysqli_fetch_assoc(mysqli_query($connect, "select name, password,type  from users where name = '$login';"));

    if(!empty($result["name"]) && password_verify($password, $result["password"])) {
        return [
            'result'=> true,
            'type'=>$result['type']
        ];
    } else
        return [
           'result' => false,
           'type' => null,
        ];
}

function isAuth()
{
    return isset($_SESSION['auth']) && $_SESSION['auth'];
}

if ($logOut) {
    session_destroy();
    unset($_SESSION);
}

if (isAuth()) {
    $login = $_SESSION["user"];
    $isAuth = true;
    setcookie("login", $_SESSION["user"], time() + 2592000, "/");
}

if (isset($_POST["mail"])) {
    $login = htmlspecialchars($_POST["mail"]);
    $password = htmlspecialchars($_POST['password']);

    $auth = authentication($login, $password);

    $isAuth = $auth['result'];

    if($isAuth) {
        $_SESSION["user"] = $login;
        $_SESSION["auth"] = true;
        $_SESSION["userType"] = $auth['type'];
        setcookie("login", $_SESSION["user"], time() + 2592000, "/");
    }
}

if($isAuth) {
    header('Location:/orders');
} else {
    include "./pages/authorization.php";
}
