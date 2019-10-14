<!DOCTYPE html>
<html lang ="pl">
<head>
    <title>Generator planu treningowego</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href ="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <style>

    </style>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<nav class ="navbar navbar-inverse">
    <div class="container-fluid">
        <div class ="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavBar">
                <span class=icon-bar"></span>
                <span class=icon-bar"></span>
                <span class=icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><img src="IMG/logo.png"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class ="nav navbar-nav navbar-right">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="login.php">Logowanie</a></li>
                <li><a href="profile.php">Profil</a></li>
                <li><a href="generator.php">Generator</a></li>
            </ul>

        </div>
    </div>
</nav>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class ="active"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class ="item active">
            <img src="IMG/slide2.jpg">
            <div class="carousel-caption">
                <h1>Wygeneruj swoj plan</h1>
                <br>
                <button type="button" class="btn btn-default" onclick="location.href = 'generator.php';">Generuj</button>
            </div>
        </div><!--koniec aktywnego -->
    </div>
</div> <!---- koniec slidera -->