<?php
    session_start();
    require_once("includes/header.php");
    if (isset($_SESSION['logged']) && $_SESSION['logged']==true)
    {
        header('Location: profile.php');
        exit();
    }
?>

<div class = "container">
    <div class="wrapper">
        <form action="checklogin.php" method="post" name="Login_Form" class="form-signin">
            <h3 class="form-signin-heading"></br><img src="IMG/logo.png"></h3>
            <input type="text" class="form-control" name="username" placeholder="Login" required="" autofocus="" />
            <input type="password" class="form-control" name="password" placeholder="Haslo" required=""/>

            <?php
                if(isset($_SESSION['login_error'])) echo '<div class ="error">'.$_SESSION['login_error'].'</div>';
            ?>

            <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit">Zaloguj</button>
            <a href="register.php" class="form-signin-register">Nie masz konta? Kliknij</a>
        </form>
    </div>
</div>

<?php
    require_once("includes/footer.php")
?>
