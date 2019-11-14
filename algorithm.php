<?php
session_start();
require_once "dbconnect.php";
require_once("includes/header.php");
if (!isset($_SESSION['logged']) && $_SESSION['logged']==false)
{
    header('Location: login.php');
    exit();
}

if (!isset($_POST['diet']))
{
    header('Location: generator.php');
    exit();
}

$connect = @new mysqli($host, $db_user, $db_password, $db_name);

//jesli polaczenie sie nie uda, to ponizszy if sie nie spelni
if($connect->connect_errno!=0)
{
    echo "Error:".$connect->connect_errno."Opis:". $connect->connect_error;
}
else{
    $diet = $_POST['diet'];
    $balance = $_POST['balance'];
    $sex = $_POST['sex'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $age = $_POST['age'];
    $query = "SELECT name, energyWorth, effectivity, sets FROM exercises";
    $data=mysqli_query($connect,$query);
    while($row = mysqli_fetch_assoc($data))
        $test[] = $row;
}
?>

<div class="container">
    <div class="row">
        <div class="callout-dark text-center fade-in-b">
            <h1><b>Twoj wygenerowany plan </b> </h1>
            <div class="wrapper">
                <div id="log"></div>
                <button type="button" class="btn btn-lg btn-primary btn-block" onclick="location.href = 'generator.php';">Generuj nowy plan</button>
            </div>
        </div>

    </div>

</div>
<script type="text/javascript">
    (function () {
        if (!console) {
            console = {};
        }
        var old = console.log;
        var logger = document.getElementById('log');
        console.log = function (message) {
            if (typeof message == 'object') {
                logger.innerHTML += (JSON && JSON.stringify ? JSON.stringify(message) : String(message)) + '<br />';
            } else {
                logger.innerHTML += message + '<br />';
            }
        }
    })();

    var result = <?php echo json_encode($test, JSON_NUMERIC_CHECK)?>;
    var balance = <?php echo $balance; ?>;
    var diet = <?php echo $diet; ?>;
    var sex = <?php echo json_encode($sex); ?>;
    var weight = <?php echo $weight; ?>;
    var height = <?php echo $height; ?>;
    var age = <?php echo $age; ?>;

    function calculate_BMR(sex, weight, height, age) {
        if (sex = "male"){
            BMR_value = (9.99*weight)+(6.25*height)-(4.92*age)+5;
            BMR_value = Math.round(BMR_value);
            console.log('Twoj wspolczynnik BMR to ' + BMR_value + ' kcal');
            return BMR_value;
        }else if (sex = "female") {
            BMR_value = (9.99*weight)+(6.25*height)-(4.92*age)-161;
            BMR_value = Math.round(BMR_value);
            console.log('Twoj wspolczynnik BMR to ' + BMR_value + ' kcal');
            return BMR_value;
        }else {
            console.log('Cos poszlo nie tak');
        }
    }
    calculate_BMR(sex, weight, height, age);

    function calculate_goal(balance, diet) {
        goal = diet - BMR_value;
        goal = goal + balance;
        return goal;
    }

    calculate_goal(balance, diet);

    function generateTraining(goal){
        if (goal > 0) {
            var m= [[0]];
            var b= [[0]];
            var opts= [0];
            var P= [1];
            var choose= [0];
            for(var i= 0; i< result.length; i++) {
                opts[i+1]= opts[i]+result[i].sets;
                P[i+1]= P[i]*(1+result[i].sets);
            }
            for (var i=0; i<opts[result.length]; i++){
                m[0][i+1]= b[0][i+1]= 0;
            }
            for (var w=1; w<goal; w++) {
                m[w]= [0];
                b[w]= [0];
                for (var i=0; i<result.length; i++) {
                    var N= result[i].sets; //ile serii mozemy wykonac?
                    var base= opts[i]; //jaki jest indeks cwiczenia dla 0
                    for (var n= 1; n<=N; n++) {
                        var W= n*result[i].energyWorth; //ile kalorii spalimy tymi cwiczeniami?
                        var s= w>W ?1 :0; //miescimy sie w limicie kalorii?
                        var v= s*n*result[i].effectivity; // ile powtorzen ?
                        var I= base+n; //nr cwiczenia?
                        var wN= w-s*W; //ile jeszcze mozemy zrobic cwiczen?
                        var C = n*P[i] + b[wN][base]; // kombinacja
                        m[w][I] = Math.max(m[w][I-1], v+m[wN][base]);
                        choose= b[w][I]= m[w][I]>m[w][I-1] ?C :b[w][I-1];
                    }
                }
            }
            var best =[];
            for (var i= result.length-1; i>=0; i--) {
                best[i]= Math.floor(choose/P[i]);
                choose-= best[i]*P[i];
            }
            var sumaKalorie = 0;
            var sumaPowtorzen = 0;
            console.log('Twoja dieta to '+ diet +' kcal');
            console.log('Twoj oczekiwany bilans dnia to ' + balance + ', zatem Twoim celem jest spalic ' + goal + ' kcal');
            for (var j= 0; j<best.length; j++) {
                if(0==best[j]) continue;
                console.log('Wykonaj ' + best[j] + ' razy' + ' cwiczenie ' + result[j].name + ' spalajac ' + result[j].energyWorth + ' kcal na 1 serie')
                sumaKalorie += best[j] * result[j].energyWorth;
                sumaPowtorzen += best[j] * result[j].effectivity;

            }
            console.log('Spalisz lacznie ' + sumaKalorie + ' kcal');
        }else{
            console.log('cel nie moze byc ujemny')
        }
    }
    generateTraining(goal);

</script>



<?php
include('includes/footer.php');
?>


