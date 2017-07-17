// konversi rupiah
function tandaPemisahTitik(angka){
    var _minus = false;
    if (angka < 0) _minus = true;
    angka = angka.toString();
    angka=angka.replace(".","");
    angka=angka.replace("-","");
    c = "";
    panjang = angka.length;
    j = 0;
    for (i = panjang; i > 0; i--){
         j = j + 1;
         if (((j % 3) == 1) && (j != 1)){
           c = angka.substr(i-1,1) + "." + c;
         } else {
           c = angka.substr(i-1,1) + c;
         }
    }
    if (_minus) c = "-" + c ;
    return c;
}

function numbersonly(ini, angkaasli){
    if (angkaasli.keyCode>=49){
        if(angkaasli.keyCode<=57){
        a = ini.value.toString().replace(".","");
        angka = a.replace(/[^\d]/g,"");
        angka = (angka=="0")?String.fromCharCode(angkaasli.keyCode):angka + String.fromCharCode(angkaasli.keyCode);
        ini.value = tandaPemisahTitik(angka);
        return false;
        }
        else if(angkaasli.keyCode<=105){
            if(angkaasli.keyCode>=96){
                //e.keycode = e.keycode - 47;
                a = ini.value.toString().replace(".","");
                angka = a.replace(/[^\d]/g,"");
                angka = (angka=="0")?String.fromCharCode(angkaasli.keyCode-48):angka + String.fromCharCode(angkaasli.keyCode-48);
                ini.value = tandaPemisahTitik(angka);
                //alert(e.keycode);
                return false;
                }
            else {return false;}
        }
        else {
            return false; }
    }else if (angkaasli.keyCode==48){
        a = ini.value.replace(".","") + String.fromCharCode(angkaasli.keyCode);
        angka = a.replace(/[^\d]/g,"");
        if (parseFloat(angka)!=0){
            ini.value = tandaPemisahTitik(angka);
            return false;
        } else {
            return false;
        }
    }else if (angkaasli.keyCode==95){
        a = ini.value.replace(".","") + String.fromCharCode(angkaasli.keyCode-48);
        angka = a.replace(/[^\d]/g,"");
        if (parseFloat(angka)!=0){
            ini.value = tandaPemisahTitik(angka);
            return false;
        } else {
            return false;
        }
    }else if (angkaasli.keyCode==8 || angkaasli.keycode==46){
        a = ini.value.replace(".","");
        angka = a.replace(/[^\d]/g,"");
        angka = angka.substr(0,angka.length -1);
        if (tandaPemisahTitik(b)!=""){
            ini.value = tandaPemisahTitik(angka);
        } else {
            ini.value = "";
        }
        
        return false;
    } else if (angkaasli.keyCode==9){
        return true;
    } else if (angkaasli.keyCode==17){
        return true;
    } else {
        //alert (e.keyCode);
        return false;
    }

}