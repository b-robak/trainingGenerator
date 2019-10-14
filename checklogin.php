<?php

    session_start();

    if(!isset($_POST['username']) || (!isset($_POST['password'])))
{
    header('Location: login.php');
    exit();
}
    require_once "dbconnect.php";

    $connect = @new mysqli($host, $db_user, $db_password, $db_name);

    //jestli polaczenie sie nie uda, to ponizszy if sie nie spelni
    if($connect->connect_errno!=0)
    {
        echo "Error:".$connect->connect_errno."Opis:". $connect->connect_error;
    }
    else
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $username = htmlentities($username,ENT_QUOTES, "UTF-8");


        if($query_result = @$connect->query(sprintf("SELECT * FROM users WHERE user='%s'",
            mysqli_real_escape_string($connect, $username))))
        {
            $check_users = $query_result->num_rows;
            if($check_users>0)
            {
                $sql_row = $query_result->fetch_assoc();

                //sprawdzenie hasha
                if(password_verify($password, $sql_row['password']))
                {
                    $_SESSION['logged'] = true;
                    $_SESSION['id'] = $sql_row['id'];
                    $_SESSION['user'] = $sql_row['user'];
                    $_SESSION['email'] = $sql_row['email'];

                    unset($_SESSION['login_error']);
                    $query_result->free_result();
                    header('Location: profile.php');
                }else {
                    $_SESSION['login_error']='Bledne dane logowania';
                    header('Location: login.php');
                }

            } else {
                $_SESSION['login_error']='Bledne dane logowania';
                header('Location: login.php');
            }
        }

        $connect->close();
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
