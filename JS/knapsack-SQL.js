var mysql      = require('mysql');
var connection = mysql.createConnection({
    host: '',
    user: '',
    password: '',
    database: ''
});


connection.connect(function(err) {
    if (err) throw err;
    connection.query("SELECT name, energyWorth, effectivity, sets FROM exercises", function (err, result) {
        if (err) throw err;
        function dobierzTrening(celTreningowy){

            if (celTreningowy > 0) {
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
                for (var w=1; w<celTreningowy; w++) {
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

                console.log('Twoj cel to spalic '+ celTreningowy+' kcal')
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
        dobierzTrening(1200)
    });
});

//console.log(fields[0].name);
//connection.end();