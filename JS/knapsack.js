//funkcja celu: jak najwiecej kalorii przy jak najmniejszej ilosci powtorzen
var data = [
    {nazwa: 'martwy ciag',      wartEnergetyczna:300, efektywnosc:0, serie:4, czas:10},
    {nazwa: 'podciaganie na drazku',      wartEnergetyczna:250, efektywnosc:0, serie:4, czas:10},
    {nazwa: 'przysiad ze sztanga',      wartEnergetyczna:200, efektywnosc:0, serie:4, czas:10},
    {nazwa: 'stanie na glowie', wartEnergetyczna:500, efektywnosc:0, serie: 4, czas:10}
];

for (var i=0; i<data.length; i++){
    data[i].efektywnosc = data[i].wartEnergetyczna/data[i].czas;
}


function oblicz_cel(cel_kaloryczny, dieta){
    srednie_zapotrzebowanie = 2000;
    obliczony_cel = cel_kaloryczny+dieta-srednie_zapotrzebowanie;
    return obliczony_cel;
}



function dobierzTrening(celTreningowy){

    if (celTreningowy > 0) {


        var m= [[0]];
        var b= [[0]];
        var opts= [0];
        var P= [1];
        var choose= [0];
        for(var i= 0; i< data.length; i++) {
            opts[i+1]= opts[i]+data[i].serie;
            P[i+1]= P[i]*(1+data[i].serie);
        }
        for (var i=0; i<opts[data.length]; i++){
            m[0][i+1]= b[0][i+1]= 0;
        }
        for (var w=1; w<celTreningowy; w++) {
            m[w]= [0];
            b[w]= [0];
            for (var i=0; i<data.length; i++) {
                var N= data[i].serie; //ile serii mozemy wykonac?
                var base= opts[i]; //jaki jest indeks cwiczenia dla 0
                for (var n= 1; n<=N; n++) {
                    var W= n*data[i].wartEnergetyczna; //ile kalorii spalimy tymi cwiczeniami?
                    var s= w>W ?1 :0; //miescimy sie w limicie kalorii?
                    var v= s*n*data[i].efektywnosc; // ile powtorzen ?
                    var I= base+n; //nr cwiczenia?
                    var wN= w-s*W; //ile jeszcze mozemy zrobic cwiczen?
                    var C = n*P[i] + b[wN][base]; // kombinacja
                    m[w][I] = Math.max(m[w][I-1], v+m[wN][base]);
                    choose= b[w][I]= m[w][I]>m[w][I-1] ?C :b[w][I-1];
                }
            }
        }
        var best =[];
        for (var i= data.length-1; i>=0; i--) {
            best[i]= Math.floor(choose/P[i]);
            choose-= best[i]*P[i];
        }
        var sumaKalorie = 0;
        var sumaPowtorzen = 0;

        console.log('Twoj cel to spalic '+ celTreningowy+' kcal')
        for (var j= 0; j<best.length; j++) {
            if(0==best[j]) continue;
            console.log('Wykonaj ' + best[j] + ' razy ' + ' cwiczenie ' + data[j].nazwa + ' spalajac ' + data[j].wartEnergetyczna + ' kcal na 1 serie')
            sumaKalorie += best[j] * data[j].wartEnergetyczna;
            sumaPowtorzen += best[j] * data[j].efektywnosc;
        }
        console.log('Spalisz lacznie ' + sumaKalorie + ' kcal');
    }else{
        console.log('cel nie moze byc ujemny')
    }
}

//celTreningowy = ilosc kcal, ktore chcemy dodatkowo spalic w ciagu dnia

dobierzTrening(oblicz_cel(5000, 1800));

