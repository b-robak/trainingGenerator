<?php
    session_start();
    require_once("includes/header.php");

    if(!isset($_SESSION['logged']))
{
    header('Location: login.php');
    exit();
}
?>
<?php
    echo "Witaj".$_SESSION['user'].'</br>';
    echo "Aktualna data to:".date('Y-m-d H:i:s').'</br>';
?>
    <a href="logout.php">Wyloguj sie</a>


<?php
require_once("includes/footer.php")
?>
