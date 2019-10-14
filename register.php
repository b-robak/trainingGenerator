<?php
    session_start();
    require_once("includes/header.php");
    require_once("dbconnect.php");

    if(isset($_POST['email']))
    {
        //zalozmy udana walidacje
        $validate_OK = true;

        $login = $_POST['login'];

        if((strlen($login) < 3) || (strlen($login) > 20))
        {
            $validate_OK = false;
            $_SESSION['e_login']="Login musi posiadac od 3 do 20 znakow";
        }

        if(ctype_alnum($login)==false)
        {
            $validate_OK=false;
            $_SESSION['e_login']="Login moze zawierac tylko litery i cyfry (bez polskich znakow)";
        }

        $email = $_POST['email'];
        $email_OK = filter_var($email, FILTER_SANITIZE_EMAIL);

        if((filter_var($email_OK,FILTER_VALIDATE_EMAIL)==false) || ($email_OK!=$email))
        {
            $validate_OK = false;
            $_SESSION['e_email']="Email niepoprawny";
        }

        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if((strlen($password1) < 8) || (strlen($password1) > 20))
        {
            $validate_OK = false;
            $_SESSION['e_password']="Haslo musi posiadac od 8 do 20 znakow";
        }

        if($password1!=$password2) {
            $validate_OK = false;
            $_SESSION['e_password'] = "Hasla musza byc identyczne";
        }

        $hashed_pw = password_hash($password1, PASSWORD_DEFAULT);

        $secret_key = "6LfdbjcUAAAAAM0_UL_O9n8jmotOOcC9UpWajN7e";

        $check_captcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);

        $captcha_response = json_decode($check_captcha);

        if ($captcha_response->success==false)
        {
            $wszystko_OK = false;
            $_SESSION['e_captcha']="Potwierdź, że nie jesteś botem!";
        }

        //zapamietanie wprowadzonych danych
        $_SESSION['remember_login']=$login;
        $_SESSION['remember_email']=$email;

            mysqli_report(MYSQLI_REPORT_STRICT);
        try
        {
            $connect = new mysqli($host, $db_user, $db_password, $db_name);
            if($connect->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
                {
                $sql_result = $connect->query("SELECT id FROM users WHERE email='$email'");

                if(!$sql_result) throw new Exception($connect->error);
                $count_mails = $sql_result->num_rows;
                if($count_mails>0)
                {
                    $validate_OK = false;
                    $_SESSION['e_email']="Istnieje juz konto z tym emailem";
                }
                $sql_result = $connect->query("SELECT id FROM users WHERE user='$login'");

                if(!$sql_result) throw new Exception($connect->error);
                $count_usernames = $sql_result->num_rows;
                if($count_usernames>0)
                {
                    $validate_OK = false;
                    $_SESSION['e_login']="Istnieje juz konto z tym loginem";
                }

                if($validate_OK==true)
                {
                    if($connect->query("INSERT INTO users VALUES (NULL, '$login', '$hashed_pw', '$email')"))
                    {
                        $_SESSION['s_register']="Konto zostalo zalozone pomyslnie";
                    }
                    else
                    {
                        throw new Exception($connect->error);

                    }
                }

                $connect->close();
            }
        }
        catch(Exception $error_catch)
        {
            echo '<div class ="error">Blad! Przepraszamy...</div>';
        }


    }
?>


<div class = "container">
    <div class="wrapper">
        <form action="" method="post" name="Login_Form" class="form-signin">
            <h3 class="form-signin-heading"></br><img src="IMG/logo.png"></h3>
            <?php
            if(isset($_SESSION['s_register']))
            {
                echo '<div class ="success">'.$_SESSION['s_register'].'</div>';
                unset($_SESSION['s_register']);
            }
            ?>
            <input type="text" class="form-control" value="<?php if(isset($_SESSION['remember_login'])){
                echo $_SESSION['remember_login'];
                unset($_SESSION['remember_login']);
            }?>" name="login" placeholder="Login" required="" autofocus="" />
            <?php
                if(isset($_SESSION['e_login']))
                {
                    echo '<div class ="error">'.$_SESSION['e_login'].'</div>';
                    unset($_SESSION['e_login']);
                }
            ?>
            <input type="email" class="form-control" value="<?php if(isset($_SESSION['remember_email'])){
                echo $_SESSION['remember_email'];
                unset($_SESSION['remember_email']);
            }?>" name="email" placeholder="Email" required=""/>
            <?php
            if(isset($_SESSION['e_email']))
            {
                echo '<div class ="error">'.$_SESSION['e_email'].'</div>';
                unset($_SESSION['e_email']);
            }
            ?>
            <input type="password" class="form-control" name="password1" placeholder="Twoje haslo" required=""/>
            <?php
            if(isset($_SESSION['e_password']))
            {
                echo '<div class ="error">'.$_SESSION['e_password'].'</div>';
                unset($_SESSION['e_password']);
            }
            ?>
            <input type="password" class="form-control" name="password2" placeholder="Powtorz haslo" required=""/>
            <?php
            if(isset($_SESSION['e_password']))
            {
                echo '<div class ="error">'.$_SESSION['e_password'].'</div>';
                unset($_SESSION['e_password']);
            }
            ?>
            <div class="g-recaptcha" data-sitekey="6LfdbjcUAAAAAP9S_34IJdzDKfgdknmz_71H2d4A"></div>
            <?php
            if(isset($_SESSION['e_captcha']))
            {
                echo '<div class ="error">'.$_SESSION['e_captcha'].'</div>';
                unset($_SESSION['e_captcha']);
            }
            ?>

            <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Register" type="Submit">Zarejestruj sie</button>
        </form>
    </div>
</div>

<?php
    require_once("includes/footer.php")
?>