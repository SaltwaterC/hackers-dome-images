var pfenetre;
var fenetreouverte = false;

//-------------------------------------------------//
//     francais                                    //
//-------------------------------------------------//
var lang_calendrier = "calendrier";
var lang_numerique = "Entree non numerique !!";
var lang_aide = "Aide";
var lang_traces = "Traces";
var lang_date_non_valide = "Date non valide !! ";
var lang_heure_non_valide = "Heure non valide  !!";
var lang_upload = "Upload";

function aide (obj)
{
    if (fenetreouverte == true)
        pfenetre.close ();
    pfenetre = window.open ("../doc/"+obj+".html", lang_aide, "toolbar=no, scrollbars=yes, status=no, width=600, height=400, top=120, left=120");
    fenetreouverte = true;
}

function traces (fichier)
{
    if (fenetreouverte == true)
        pfenetre.close ();
    pfenetre = window.open ("../tmp/"+fichier, lang_traces, "toolbar=no, scrollbars=yes, status=no, width=600, height=400, top=120, left=120");
    fenetreouverte = true;
}

function vdate (origine)
{
    if (fenetreouverte == true)
        pfenetre.close ();
    pfenetre = window.open ("../spg/calendrier.php?origine="+origine, lang_calendrier, "width=310, height=230, top=120, left=120");
    fenetreouverte = true;
}

function fdate (champ)
{
    var flag = 0;
    var jour = "";
    var mois = "";
    var annee = "";

    if (champ.value.lastIndexOf("/") == -1 && (champ.value.length == 6 || champ.value.length == 8))
    {
        jour = champ.value.substring(0,2);
        mois = champ.value.substring(2,4);
        if (champ.value.length == 6)
            annee = "20"+champ.value.substring(4,6);
        if (champ.value.length == 8)
            annee = champ.value.substring(4,8);
    }
    
    if (champ.value.lastIndexOf("/") != -1 && (champ.value.length == 8 || champ.value.length == 10))
    {
        jour = champ.value.substring(0,2);
        mois = champ.value.substring(3,5);
        if (champ.value.length == 8)
            annee = "20"+champ.value.substring(6,8);
        if (champ.value.length == 10)
            annee = champ.value.substring(6,10);
    }

    if (isNaN (jour) || isNaN (mois) || isNaN (annee))
    {   
        flag = 1;
    }

    if (jour < '01' || jour > '31' || mois < '01' || mois > '12' || annee < '0000' || annee > '9999')
    {
        flag = 1;
    }

    if (flag == 0)
    {
        champ.value = jour+"/"+mois+"/"+annee;
    }
    else
    {
        champ.value = "";
        alert(lang_date_non_valide)
        return;
    }
}

function ftime (champ)
{
    var flag = 0;
    var heure = "";
    var minute = "";
    var seconde = "";

    if (champ.value.lastIndexOf(":") == -1 && (champ.value.length == 2 || champ.value.length == 4 || champ.value.length == 6))
    {
        heure = champ.value.substring(0,2);
        if (champ.value.length == 2)
        {
            minute = "00";
            seconde = "00";
        }
        if (champ.value.length == 4)
        {
            minute = champ.value.substring(2,4);
            seconde = "00";
        }
        if (champ.value.length == 6)
        {
            minute = champ.value.substring(2,4);
            seconde = champ.value.substring(4,6);
        }
    }
    
    if (champ.value.lastIndexOf(":") != -1 && (champ.value.length == 5 || champ.value.length == 8))
    {
        heure = champ.value.substring(0,2);
        if (champ.value.length == 5)
        {
            minute = champ.value.substring(3,5);
            seconde = "00";
        }
        if (champ.value.length == 8)
        {
            minute = champ.value.substring(3,5);
            seconde = champ.value.substring(6,8);
        }
    }

    if (isNaN (heure) || isNaN (minute) || isNaN (seconde))
    {   
        flag = 1;
    }

    if (heure < '00' || heure > '23' || minute < '00' || minute > '59' || seconde < '00' || seconde > '59')
    {
        flag = 1;
    }

    if (flag == 0)
    {
        champ.value = heure+":"+minute+":"+seconde;
    }
    else
    {
        champ.value = "";
        alert(lang_heure_non_valide)
        return;
    }
}


function vupload (origine)
{
    if (fenetreouverte == true)
        pfenetre.close ();
    pfenetre=window.open("../spg/upload.php?origine="+origine,lang_upload ,"width=300,height=100,top=120,left=120");
    fenetreouverte=true;
}

function VerifNum (champ)
{
    if  (isNaN (champ.value))
    {
        alert (lang_numerique);
        champ.value = "";
        return;
    }
    champ.value = champ.value.replace (".", "");
}

