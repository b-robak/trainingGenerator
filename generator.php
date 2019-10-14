<?php
    session_start();
    require_once("includes/header.php");
    if (!isset($_SESSION['logged']) && $_SESSION['logged']==false)
    {
        header('Location: login.php');
        exit();
    }
?>

<div class="container">
    <div class="row">
            <div class="callout-dark text-center fade-in-b">
                <h1><b>Wygeneruj swoj plan</b> </h1>
                <p>Tutaj mozesz wygenerowac swoja plan</p>
                <div class="wrapper">
                    <form action="" method="post" name="generatePlan" class="form-generatePlan">
                        <b>Twoj cel kaloryczny (w kcal):</b>
                        <input type="text" class="form-control" name="kcalTarget" placeholder="Cel kaloryczny" required="" autofocus="" />
                        <b>Twoja dieta (w kcal):</b>
                        <input type="text" class="form-control" name="yourDiet" placeholder="Twoja dieta" required="" autofocus="" />
                            <label for="sex">Plec:</label>
                            <select class="form-control" id="sex">
                                <option>Mezczyzna</option>
                                <option>Kobieta</option>
                            </select>
                            <label for="advanceLevel">Poziom:</label>
                            <select class="form-control" id="advanceLevel">
                                <option>Poczatkujacy</option>
                                <option>Sredni</option>
                            </select>
                    </br>
                        <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Generate" type="Submit">Generuj!</button>
                    </form>
                </div>
            </div>

    </div>

</div>
<?php
include('includes/footer.php');
?>
