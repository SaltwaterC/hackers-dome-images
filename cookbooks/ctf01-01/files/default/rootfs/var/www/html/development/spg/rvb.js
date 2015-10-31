/* AUTEUR: BERNARD MARTIN-RABAUD */
/* DATE DE CREATION: 25/06/00 */
/* cette fonction javascript a �t� adapt�e pour openMairie
le 20/04/2006
*/

// *****************************************************************
// AFFICHAGE DES COULEURS V2.0
// *****************************************************************
// Modifications par rapport � V1.6 :
// @ �criture en objets (objets principaux : palette et interface)
// @ param�trage (palette, descro, lignes x cellules/ligne, largeur x hauteur cellules)
// + liste permettant de modifier la saturation pour obtenir des m�langes couleur-gris (palette graphique uniquement) 
// @ int�gr� les palettes dans PaletteCouleurs en tant qu'objet ListePalettes
// + s�lectionner la saturation � la r�ouverture, en fonction de la couleur (uniquement palette graphique)
//
// NOTE POUR LA D�CLARATION DES M�THODES D'OBJET
// - on ne peut �videmment pas appeler une m�thode avant d'avoir cr�� l'objet (var xxx = new YYY())
// - lorsque la m�thode est appel�e apr�s la d�claration du contructeur de la classe, on peut la prototyper, 
//   cad Classe.prototype.methode = function() (ce sont des m�thodes de classe et non d'objet = plus l�ger)
// - lorsque la m�thode est appel�e avant la d�claration du contructeur de la classe, on ne peut pas la prototyper,
//   il faut la d�clarer dans le constructeur : this.methode = une_fonction_quelconque;

// PARAMETRES DU SCRIPT (niveau webmestre)

// on peut aussi les indiquer dans couleurs.html (en ce cas, ceux-ci ont priorit� sur les m�mes param�tres indiqu�s ici)
// palette pr�d�finie, choix entre "graphique", "216" (216 couleurs HTML), "256" (256 couleurs) et "gris (d�grad�s du noir au blanc)
var g_palette = "256";

var g_url_img_vide = "../img/couleurs_vide.gif";
// marges horizontales de la palette de couleurs
// espace entre cellules en pixels
var g_esp_cellules = 1;
// chemin et fichier image vide (relatif � couleurs.html)
var g_marge_palette = 5;
// true : affiche un message d'alerte en cas d'erreur
var g_alertes = true;

// cr�ation des 2 objets de base
var ui = new InterfaceCouleurs();
var pal = new PaletteCouleurs();

// Voici 4 palettes pr�d�finies, avec 4 arguments pour chaque palette :
// son nom, un descriptif pour afficher dans la liste, 
// les dimensions de la palette (lignes x cellules par ligne), les dimensions de chaque cellule (largeur x hauteur en pixels)
pal.ajouterPalette("graphique", "palette graphique", "24x16", "13x9");
pal.ajouterPalette("216", "216 couleurs HTML", "18x12", "17x11");
pal.ajouterPalette("256", "256 couleurs", "18x16", "13x11");
pal.ajouterPalette("gris", "d�grad�s de gris", "18x12", "17x11");

// FONCTION PRINCIPALE D'AFFICHAGE

function afficherPage(retour,palette,saturation) {
    // affichage de la palette et des bo�tes
    // s�lection de la palette
    // OPENMAIRIE
    // parametre palette   et saturation
    pal.selectionnerPalette(palette,saturation);
    // fonctions d'affichage
    pal.afficher();
    // OPENMAIRIE
    // Parametre retour
    ui.afficher(retour);
    // corrige la largeur de la palette (dans le style css)
    pal.corrigerLargeur();
    // si le champ d'appel (fen�tre appelante) avait d�j� une couleur,
    // on pr�-s�lectionne cette couleur (initPage() a affect� g_couleur)
    ui.choisirCouleur();

}


// CLASSE PALETTECOULEURS

// Cette classe a pour but de d�finir et d'afficher la palette de couleurs dans la partie gauche de la page.
// Elle communique avec le script pour :
// - savoir quelle doit �tre la palette utilis�e,
// - recevoir les param�tres de la palette,
// - afficher la palette
// Elle communique avec l'objet InterfaceCouleurs pour :
// - communiquer ou recevoir la couleur s�lectionn�e,
// - communiquer la couleur de survol,
// - recevoir le num�ro de palette en cas de changement de palette

function PaletteCouleurs() {
    this.nblignes = null;
    this.cellsparligne = null;
    this.largcellule = null;
    this.hautcellule = null;
    this.saturation = null;
    this.liste_palettes = new Array();
    this.erreur = false;
    this.ajouterPalette = PaletteCouleurs_ajouterPalette;
}


    // m�thodes publiques
    
    function PaletteCouleurs_ajouterPalette(nom, descro, dims_palette, dims_cellules) {
        // ajoute une palette pr�d�finie
        this.liste_palettes[this.liste_palettes.length] = new PalettePredefinie(nom, descro, dims_palette, dims_cellules);
    }
    

    PaletteCouleurs.prototype.selectionnerPalette = function(palette,saturation) {
        // s�lectionne la palette et d�finit ses param�tres
        
        // en cas de changement de palette, c'est ui (InterfaceCouleurs) 
        // qui sait quelle est la palette � charger
        // **************************************************************
        // modification openmairie
        // changement de palette
        // RECUPERATION PARAMETRE QUERYSTRING
        //this.palette = ui.donnerPalette();:// old
        if(palette=="")
            this.palette=null;
        else
            this.palette =palette;
        // si ui ne sait pas, c'est que la fen�tre vient d'�tre ouverte,
        if (this.palette == null) {
            // s'il n'y a qu'une seule palette pr�d�finie, on prend celle-l�  
            if (this.liste_palettes.length == 1) this.palette = 0;
            // sinon, on prend celle qui est d�finie par la variable globale g_palette
            else if (g_palette) this.palette = this.chercherIdPalette(g_palette);
            // sinon, message d'erreur
            else this.erreur = "aucune_palette";
        }
        
        // si on a une palette, on lit ses dimensions et celles des cellules et �ventuellement sa saturation
        if (this.palette != null) {
            // r�cup�re la saturation dans l'objet ui (InterfaceCouleurs), en cas de changement de palette
            // this.saturation = ui.donnerSaturation();  //OLD
            // **************************************************************
            // modification openmairie
            // changement de palette / sturation
            // RECUPERATION PARAMETRE QUERYSTRING
            if(saturation=="")
                this.saturation=null;
            else
                this.saturation =saturation;
            //this.saturation = ui.donnerSaturation();
            //alert (this.saturation);
            // si pas de changement de palette, ou pas de saturation, elle vaudra 255
            if (this.saturation == null) this.saturation = 255;
            var dims = this.liste_palettes[this.palette].extraireDimsPalette();
            if (dims) {
                this.nblignes = dims[0];
                this.cellsparligne = dims[1];
            
                dims = this.liste_palettes[this.palette].extraireDimsCellules();
                if (dims) {
                    this.largcellule = dims[0];
                    this.hautcellule = dims[1];
                }
                else this.erreur = "dims_cellules";
            }
            else this.erreur = "dims_palette";
        }
    }   


    PaletteCouleurs.prototype.afficher = function() {
        // affiche la palette de couleurs � gauche
    
        if (this.erreur) this.afficherErreur();
        else {
            // cr�ation de la palette
            var palette = this.creationPalette();
            if (this.erreur) this.afficherErreur();
            else {
                // affichage de la palette
                var html = "<div id='palette'><br>PALETTE GRAPHIQUE<br><br>";
                for (var i=0;i<this.nblignes;i++) {
                    html += "<div>";
                    for (var j=0;j<this.cellsparligne;j++) 
                        html += this.afficherCellule(palette[i][j]);
                    html += "</div>";
                }
                html += "<br>logo<br><img src='../img/logorvb.png' style='border: 1px #000000 solid;'></div>";
                document.write(html);
            }
        }
    }

    PaletteCouleurs.prototype.corrigerLargeur = function() {
        // corrige la largeur de la palette (dans le style css)
        if (this.palette != null) { 
            if (document.getElementById && document.getElementById("palette")) {
                var largeur_palette = this.cellsparligne * (this.largcellule + g_esp_cellules) + (document.all ? 0 : g_marge_palette * 2);
                var palette = document.getElementById("palette");
                palette.style.width = largeur_palette + "px";
            }
        }
    } 
    
    
    // m�thodes publiques appel�es par l'objet InterfaceCouleurs
    
    PaletteCouleurs.prototype.afficherListePalettes = function() {
        // affiche (dans la partie droite de la page) une liste des palettes pr�d�finies
        // cette m�thode est appel�e par l'objet InterfaceCouleurs)
        
        var html = "";
        if (this.liste_palettes.length > 1) {
            html += "<div><select   name=\"palettes\" size=\"1\" onchange=\"ui.rechargerPage(this.value, 100)\" id='selection'>\n";
            for (var i=0;i<this.liste_palettes.length;i++) 
                html += this.liste_palettes[i].ecrireOption(i, this.palette);
            html += "</select></div>";
        }
        return html;
    }

    PaletteCouleurs.prototype.estPaletteGraphique = function() {
        // indique si la palette courante est la palette graphique
        return (this.liste_palettes[this.palette].nom == "graphique");
    }


    // m�thodes priv�es de cr�ation de palette
    
    PaletteCouleurs.prototype.chercherIdPalette = function(nom_palette) {
        // cherche l'indice d'une palette dans les palettes pr�d�finies connaissant son nom
        for (var i=0;i<this.liste_palettes.length;i++) {
            if (nom_palette == this.liste_palettes[i].nom) return i;
        }
        return null;
    }

    
    PaletteCouleurs.prototype.creationPalette = function() {
        // cr�ation d'une palette pr�d�finie par le param�tre g_palette
        // retourne la palette sous forme de tableau � 2 dimensions

        switch (this.liste_palettes[this.palette].nom) {
            case "graphique" :  var palette = this.creationPaletteGraphique(); break;
            case "216" :        var palette = this.creation216Couleurs(); break;
            case "256" :        var palette = this.creation256Couleurs(); break;
            case "gris" :       var palette = this.creationPaletteGris(); break;
            default :   var palette = null; this.erreur = "palette_nulle";
        }
        return palette;
    }

    PaletteCouleurs.prototype.creationPaletteGraphique = function() {
        // cr�ation d'une palette graphique par teintes et luminosit�s progressives
        // la saturation est fixe et donn�e par this.saturation
    
        var palette = new Array();
        var tnt = 0;
        // calcul du pas de la teinte et de la luminosit�
        var dt = Math.round(255/(this.nblignes-1));
        var dl = Math.round(255/this.cellsparligne);
        // nblignes-1 lignes de couleurs par teintes progressives
        for (var i=0;i<this.nblignes-1;i++) {
            palette[i] = new Array();
            var lum = 0;
            // cellsparligne cellules de couleur par luminosit�s progressives
            for (var j=0;j<this.cellsparligne;j++) {
                var rvb = TSLenRVB(tnt, this.saturation, lum);
                palette[i][j] = RVBenCodeCouleur(rvb.r, rvb.v, rvb.b);
                lum += dl;
                if (lum > 255) lum = 255;
            }
            tnt += dt;
            if (tnt > 255) tnt = 255;
        }
        // plus une ligne de gris, du noir au blanc
        i = this.nblignes-1;
        var dl = Math.round(255/(this.cellsparligne-1));
        palette[i] = new Array();
        lum = 0;
        for (j=0;j<this.cellsparligne;j++) {
            rvb = TSLenRVB(0, 0, lum); 
            palette[i][j] = RVBenCodeCouleur(rvb.r, rvb.v, rvb.b);
            lum += dl;
            if (lum > 255) lum = 255;
        }
        return palette;
    }

    PaletteCouleurs.prototype.creation216Couleurs = function() {
        // cr�ation de la palette de 216 couleurs HTML (avec 18 lignes x 12 cellules)

        var palette = new Array();
        var pas = 51;
        var rouge = 0;
        var vert = 0;
        var bleu = 0;
        // nb_lignes lignes de couleurs
        for (var i=0;i<this.nblignes;i++) {
            palette[i] = new Array();
            // cellsparligne cellules de couleur par luminosit�s progressives
            for (var j=0;j<this.cellsparligne;j++) {
                palette[i][j] = RVBenCodeCouleur(rouge, vert, bleu);
                if (bleu == 255) {
                    if (vert == 255) {
                        rouge += pas; vert = 0; bleu = 0;
                    }
                    else {
                        vert += pas; bleu = 0;
                    }
                }
                else bleu += pas;
            }
        }
        return palette;
    }

    PaletteCouleurs.prototype.creation256Couleurs = function() {
        // cr�ation de la palette de 256 couleurs Windows (avec 16 lignes x 16 cellules)

        var palette = new Array();
        var pasb = 85;
        var pasrv = 255/7;
        var rouge = 0;
        var vert = 0;
        var bleu = 0;
        // nblignes lignes de couleurs
        for (var i=0;i<this.nblignes;i++) {
            palette[i] = new Array();
            // cellsparligne cellules de couleur par luminosit�s progressives
            for (var j=0;j<this.cellsparligne;j++) {
                palette[i][j] = RVBenCodeCouleur(Math.round(rouge), Math.round(vert), bleu);
                if (bleu == 255) {
                    if (Math.round(vert) == 255) {
                        rouge += pasrv; vert = 0; bleu = 0;
                    }
                    else {
                        vert += pasrv; bleu = 0;
                    }
                }
                else bleu += pasb;
            }
        }
        return palette;
    }

    PaletteCouleurs.prototype.creationPaletteGris = function() {
        // cr�ation de la palette de d�grad�s de gris 

        var palette = new Array();
        var pas = 256 / (this.nblignes * this.cellsparligne -1);
        var rouge = 0;
        var vert = 0;
        var bleu = 0;
        // nblignes lignes de couleurs
        for (var i=0;i<this.nblignes;i++) {
            palette[i] = new Array();
            // cellsparligne cellules de couleur par luminosit�s progressives
            for (var j=0;j<this.cellsparligne;j++) {
                palette[i][j] = RVBenCodeCouleur(Math.round(rouge), Math.round(vert), Math.round(bleu));
                rouge += pas;
                vert += pas;
                bleu += pas;
                if (rouge > 255) {
                    rouge = vert = bleu = 255;
                }
            }
        }
        return palette;
    }
    
    
    // m�thodes priv�es d'affichage

    PaletteCouleurs.prototype.afficherCellule = function(rvb) {
        // affiche une case couleur de la palette de couleurs

        var texte = "<span style=\"width:" + this.largcellule + "px; height:" + this.hautcellule + "px; background-color:#" + rvb + ";\">";
        texte += "<a href=\"javascript:ui.choisirCouleur('" + rvb + "')\" title=\"#" + rvb + "\"";
        texte += " onmouseover=\"ui.modifierTemoin('temoin_survol', '" + rvb + "')\"";
        texte += " onmouseout=\"ui.modifierTemoin('temoin_survol', 'ffffff')\">";
       //texte += "<img id=\"img" + rvb + "\" class=\"normal\" src=\"" + g_url_img_vide + "\" width=\"" + eval(this.largcellule - g_esp_cellules) + "\" height=" + eval(this.hautcellule - g_esp_cellules) + " border=\"0\" alt=\"#" + rvb + "\" />";
        texte += "<img id=\"img" + rvb + "\" class=\"normal\" src=\"" + g_url_img_vide + "\" width=\"8px\" height=\"12px\" border=\"1\" alt=\"#" + rvb + "\" />";
        texte += "&nbsp;</a></span>";
        return texte;
    }
    

    PaletteCouleurs.prototype.afficherErreur = function() {
        // affiche l'erreur trouv�e
        var html = "<div id='palette'><div class='palette-erreur' style='width:200px;'>";
        switch (this.erreur) {
            case "dims_palette"     : html += "Erreur dans les dimensions de la palette (lignes, cellules par ligne)."; break;
            case "dims_cellules"    : html += "Erreur dans les dimensions des cellules."; break;
            case "palette_nulle"    : html += "Erreur : la palette s�lectionn�e n'existe pas."; break;
            case "aucune_palette"   : html += "Erreur : aucune palette s�lectionn�e."; break;
        }
        html += "</div></div>";
        document.write(html);
    }


// FIN DE LA CLASSE PALETTECOULEURS


// CLASSE PALETTEPREDEFINIE

function PalettePredefinie(nom, descro, dims_palette, dims_cellules) {
    this.nom = nom;
    this.descro = descro;
    this.dims_palette = dims_palette;
    this.dims_cellules = dims_cellules;
}

    PalettePredefinie.prototype.extraireDimsPalette = function() {
        // extrait les dimensions de la palette de la propri�t� dims_palette
        var dims = this.dims_palette.match(/^(\d+)\s?x\s?(\d+)$/);
        if (dims) return Array(parseInt(dims[1]), parseInt(dims[2]));
    }

    PalettePredefinie.prototype.extraireDimsCellules = function() {
        // extrait les dimensions des cellules de la propri�t� dims_cellules
        var dims = this.dims_cellules.match(/^(\d+)\s?x\s?(\d+)$/);
        if (dims) return Array(parseInt(dims[1]), parseInt(dims[2]));
    }

    PalettePredefinie.prototype.ecrireOption = function(index, palette_cour) {
        // �crire une option de liste dans la liste des palettes
        return "<option value=\"" + index + "\"" + ((index == palette_cour) ? " selected" : "") + "> " + this.descro + "</option>\n";
    }
        
// FIN DE LA CLASSE PALETTEPREDEFINIE

        

// CLASSE INTERFACECOULEURS

// Cette classe fait l'interface entre la fen�tre, la fen�tre appelante et l'utilisateur.
// Elle affiche aussi les �l�ments du formulaire � droite de la fen�tre.
// Elle communique avec le script pour :
// - r�cup�rer les param�tres de l'url au chargement de la page,
// - afficher les bo�tes,
// - renvoyer la couleur s�lectionn�e � la fen�tre appelante,
// - recharger la page avec les param�tres dans l'url en cas de changement de palette
// Elle communique avec l'objet PaletteCouleurs pour :
// - communiquer ou recevoir la couleur s�lectionn�e,
// - recevoir la couleur de survol 

function InterfaceCouleurs() {
    this.opener_form = 'f1';   // modifi� openMairie
    this.opener_input = null;
    this.couleur = null;            // donn�e importante : c'est la couleur s�lectionn�e par le script
    this.palette = null;            // non null, si on recharge la page apr�s avoir s�lectionn� une palette
    this.saturation = null;
    this.change_palette = false;    // vrai si on a chang� de palette
    // modifi� openmairie 25/04/2006 ********************************
    // this.lireParamsFenetre = InterfaceCouleurs_lireParamsFenetre;
    // this.lireParamsFenetre();
    // methode afficher *********************************************
    this.donnerPalette = InterfaceCouleurs_donnerPalette;
    this.donnerSaturation = InterfaceCouleurs_donnerSaturation;

}


    // m�thode priv�e du constructeur

    function InterfaceCouleurs_lireParamsFenetre(retour) { // OM parametre retour
        // r�cup�ration des param�tres de l'url
        if (location.search) {
            // *************************************************************
            // openMairie recuperation du parametre retour de l URL
            //var query = location.search.substring(1);
            //var params = query.split("&");
            //this.opener_form = 'f1';
            this.opener_input = retour;
            // openMairie = Il n y a pas de 3eme argument
            // s�lection de la palette, si on a un 3e argument
            //if (params.length >= 3) {
            //    this.palette = parseInt(params[2]);
            //    this.change_palette = true;
            //}
            // s�lection de la saturation, dans un 4e argument
            //if (params.length == 4) this.saturation = parseInt(params[3]);
            // *************************************************************
            // lit le contenu du champ opener_input dans le formulaire opener_form appelant
            if (opener.document.forms[this.opener_form]) {
                if (opener.document.forms[this.opener_form].elements[this.opener_input]) {
                    var couleur = opener.document.forms[this.opener_form].elements[this.opener_input].value;
                    // si ce contenu n'est pas vide et est un code couleur, on pr�-s�lectionne cette couleur
                    couleur = couleur.replace(/^#?([0-9A-Za-z]{6})$/, "$1");
                    // *** openMairie 20/04/2006 ********************************
                    // transfert donn�es rvb
                    temp=couleur.split('-');
                    couleur = RVBenCodeCouleur(temp[0], temp[1], temp[2]);
                    //couleur = "FFFFFF";
                    if (couleur && estCodeCouleur(couleur)) this.couleur = couleur.toUpperCase();
                    // si this.saturation est toujours null, on la calcule d'apr�s la couleur
                    if ((this.couleur != null) && (this.change_palette == false) && (this.saturation == null)) 
                        this.saturation = calculSaturation(this.couleur);
                }
                else alerte("Le champ " + this.opener_input + " n'a pas �t� trouv�. V�rifiez si vous avez fourni le bon nom de champ.");
            }
            else alerte("Le formulaire " + this.opener_form + "n'a pas �t� reconnu. Vous ne pourrez pas r�cup�rer la couleur s�lectionn�e."); 
        }
    }
    

    // m�thodes publiques
    
    InterfaceCouleurs.prototype.afficher = function(retour) {
        // affiche les bo�tes et les boutons � droite
        var largBoiteRVB = 10;
        var largBoiteCode = 8;
        var html = "<div id='boites'>";
        html += "<form name='selec_couleur' method='post' action='rvb.php' onsubmit='return ui.envoyerCouleur()'>\n";
        // les bo�tes de composantes couleur rouge, vert, bleu
        html += "<div>Composantes RVB<br> R <input type='text' id='rouge' name='rouge' size=" + largBoiteRVB + " value='' class='inputr'";
        html += " onchange='ui.RVBenCodeCouleur()' /></div>";
        html += "<div>V <input type='text' id='vert' name='vert' size=" + largBoiteRVB + " value='' class='inputv'";
        html += " onchange='ui.RVBenCodeCouleur()' /></div>";
        html += "<div>B <input type='text' id='bleu' name='bleu' size=" + largBoiteRVB + " value='' class='inputb'";
        html += " onchange='ui.RVBenCodeCouleur()' /></div>";
        // la bo�te indiquant le code couleur de la couleur s�lectionn�e
        html += "<div> Hexadecimal <input type='text' style='background-color:#ffffff;color:#A7A8B1' id='code_couleur' name='code_couleur' size=" + largBoiteCode + " value=''";
        html += " onchange='ui.codeCouleurEnRVB()' /></div>";
        // la case t�moin couleur de survol
        html += "<div id='temoin_survol' style='background-color:#ffffff;color:#000000'>";
        html += "Couleur Survol�e <img src='" + g_url_img_vide + "' width='50' height='35' border='0' /></div>";
        // la case t�moin de la couleur s�lectionn�e
        html += "<div id='temoin' style='background-color:#ffffff;color:#000000'>";
        html += "Couleur S�lectionn�e <img src='" + g_url_img_vide + "' width='50' height='30' border='0' /></div>";
        // les 3 boutons "envoyer", "annuler" et "fermer"
        html += "<div class='boutons'><br><br><input type='submit' value='OK''>";
        html += "<br><br><input type='reset' value='Annuler S�lection' onclick='ui.annulerCouleur()' />";
        html += "<br><br><input type='button' value='Fermer' onclick='window.close()' /><br><br>Choix d'une palette</div>\n";
        // la liste des palettes s'il y en a plusieurs
        html += pal.afficherListePalettes();
        // dans le cas de la palette graphique : choix de la saturation
        if (pal.estPaletteGraphique()) {
            html += "<div class=\"saturation\"><span>saturation</span>";
            html += "<div style='position:relative; top:-15px; left:65px;'> <select name=\"saturation\" size=\"1\" onchange=\"ui.rechargerPage(0, this.value)\" id='selection'>\n";
            for (i=0;i<=100;i+=10)
                html += "<option value=\"" + i + "\"" + ((i == this.saturation) ? " selected" : "") + "> " + i + " %</option>\n";
            html += "</select></div></div>";
        }
        html += "</form></div>";
        document.write(html);
        // modification openMairie **********************************
        this.lireParamsFenetre = InterfaceCouleurs_lireParamsFenetre;
        this.lireParamsFenetre(retour);
        // *********************************************************

    }
    
    function InterfaceCouleurs_donnerPalette() {
        // communique la palette, dans le cas o� on a chang� de palette, sinon communique null
        if (this.change_palette) return this.palette;
        else return null;
    }
    
    function InterfaceCouleurs_donnerSaturation() {
        // communique la saturation, dans le cas o� on a chang� de palette, sinon communique null
        if (this.saturation != null) return Math.round(this.saturation * 255 / 100);
        else return null;
    }
    
    // m�thodes publiques �v�nementielles   
    
    InterfaceCouleurs.prototype.envoyerCouleur = function() {
        // transmet la couleur s�lectionn�e au formulaire appelant
        // appel�e par le bouton "Envoyer"
        // modifi� openMairie.org 20/04/2006 ***

        if (this.couleur == null) alerte("Aucune couleur n'a �t� s�lectionn�e.");
        else if ((this.opener_form == null) || (this.opener_input == null)) 
            alerte("Le nom du formulaire destinataire et/ou du champ destinataire n'a pas �t� transmis � la popup.");
        else {
            if (this.controlerCodeCouleur() && this.controlerComposantes()) {
                // retour couleur hexa ok
                //opener.document.forms[this.opener_form].elements[this.opener_input].value = "#" + this.couleur;
                // retour couleur RVB
                opener.document.forms[this.opener_form].elements[this.opener_input].value =selec_couleur.rouge.value+"-"+selec_couleur.vert.value+"-"+selec_couleur.bleu.value;
                window.close();
            }
            else alerte("Le code couleur n'est pas valide.");
        }
        return false;
    }
    

    InterfaceCouleurs.prototype.annulerCouleur = function() {
        // fait un reset et remet le temoin en gris
        // appel�e par le bouton "Annuler"
        this.marquerSelection(null);
        this.couleur = null;
        document.forms[0].reset();
        this.modifierTemoin("temoin", "ffffff");
    }
    

    InterfaceCouleurs.prototype.choisirCouleur = function() {
        // affiche le code de la couleur rvb dans la bo�te code_couleur
        // ainsi que ses composantes rouge, vert, bleu et le temoin couleur
        // appel�e lors d'un clic sur une cellule de la palette de gauche
        
        // on v�rifie s'il y a un argument
        if (arguments.length) var rvb = arguments[0];
        // sinon on prend this.couleur
        else rvb = this.couleur;
        if (rvb != null) {
            this.marquerSelection(rvb);
            this.ecrireCodeCouleur(rvb);
            this.ecrireComposantes(); 
            this.modifierTemoin("temoin");
        }
    }


    InterfaceCouleurs.prototype.marquerSelection = function(rvb) {
        // encadre l'image s�lectionn�e (supprime le cadre si une image est d�j� s�lectionn�e)
        if (this.couleur != null) changerClasse("img" + this.couleur, "normal");
        if (rvb != null) changerClasse("img" + rvb, "selection");
    }


    InterfaceCouleurs.prototype.rechargerPage = function(num_palette, saturation) {
        // recharge la page avec un num�ro de palette
        // *****************************
        // modification openMairie (php)
        // *****************************
        location.href = "rvb.php?valeur=''&form=" + this.opener_form + "&retour=" + this.opener_input + "&palette=" + num_palette + "&saturation=" + saturation;
    }
    

    InterfaceCouleurs.prototype.RVBenCodeCouleur = function() {
        // recompose les composantes rouge, vert, bleu de la couleur en code couleur
        // appel�e lorsqu'on modifie l'une des bo�tes rouge, vert, bleu,
        // le r�sultat est affect� � la bo�te code_couleur
        if (this.controlerComposantes()) {
            with (document.forms[0]) {
                this.ecrireCodeCouleur(octetEnHexa(rouge.value) + octetEnHexa(vert.value) + octetEnHexa(bleu.value));
            }
            this.modifierTemoin("temoin");
        }
        else alerte("Les composantes (rouge, vert, bleu) doivent �tre des nombres compris entre 0 et 255.");
    }
    

    InterfaceCouleurs.prototype.codeCouleurEnRVB = function() {
        // d�compose le code couleur en composantes rouge, vert, bleu
        // appel�e par une modification manuelle dans la bo�te code_couleur
        couleur = this.controlerCodeCouleur();
        // si la couleur est conforme : mise � jour des autres bo�tes
        if (couleur) {
            this.couleur = couleur;
            this.ecrireComposantes();
            this.modifierTemoin("temoin");
        }
        else alerte("Le code couleur saisi n'est pas valide. N'avez-vous pas omis le \"#\" au d�but ?");
    }


    // m�thodes priv�es de lecture / �criture / contr�le
    
    InterfaceCouleurs.prototype.lireCodeCouleur = function() {
        // lit le code couleur dans le champ code_couleur (sans le "#")
        var couleur = document.forms[0].code_couleur.value;
        return couleur.substring(1);
    }
    

    InterfaceCouleurs.prototype.ecrireCodeCouleur = function(rvb) {
        // �crit le code couleur rvb (re�u sans "#") dans le champ code_couleur
        // (avec annulerCouleur() et codeCouleurEnRVB() c'est l'une des 3 fonctions qui modifient la variable globale g_couleur)
        document.forms[0].code_couleur.value = "#" + rvb;
        this.couleur = rvb;
    }
    

    InterfaceCouleurs.prototype.controlerCodeCouleur = function() {
        // contr�le le contenu du champ code couleur
        // retourne la couleur si Ok, sinon null
        var couleur = this.lireCodeCouleur();
        if (estCodeCouleur(couleur)) return couleur.toUpperCase();
        else return null;
    }
    

    InterfaceCouleurs.prototype.ecrireComposantes = function() {
        // d�compose la couleur "g_couleur" en rouge, vert et bleu 
        // et affecte ces 3 valeurs aux bo�tes "rouge", "vert" et "bleu"
        var composantes = codeCouleurEnRVB(this.couleur);
        with (document.forms[0]) {
            rouge.value = composantes.rouge;
            vert.value = composantes.vert;
            bleu.value = composantes.bleu;
        }
    }

    
    InterfaceCouleurs.prototype.controlerComposantes = function() {
        // contr�le le contenu des champs rouge, vert et bleu : retourne true/false
        with (document.forms[0]) {
            return (estOctet(rouge.value) && estOctet(vert.value) && estOctet(bleu.value));
        }
    }
    

    InterfaceCouleurs.prototype.modifierTemoin = function(id) {
        // modifie la couleur des bo�tes temoin
        // s'il y a qu'un seul argument, on prendra la couleur g_couleur
        // sinon on prendra la couleur donn�e par ce 2e argument
        if (arguments.length == 2) var couleur = arguments[1];
        else var couleur = this.couleur;
        if (document.getElementById) {
            var noeud = document.getElementById(id);
            noeud.style.backgroundColor = "#" + couleur;
        }
    }
    
// FIN DE LA CLASSE INTERFACECOULEURS



// FONCTIONS UTILITAIRES POUR LA CLASSE PALETTECOULEURS

function TSLenRVB(tnt, sat, lum) {
    // conversion TSL -> RVB - arguments : teinte, saturation, luminosit�
    // retourne des composantes rouge, vert, bleu (en 0 - 255) sous forme d'objet
    // adaptation du script http://membres.lycos.fr/interaction/Package2/Couleur/couleurs5.html
    
    // convertit teinte en float [0-6[ et saturation, luminosit� en float [0-1[
    tnt = (tnt == 255) ? 0 : tnt * 6 / 255;
    sat = sat / 255;
    lum = lum / 255;
    var r = 0;
    var v = 0;
    var b = 0;
    
    var w = (lum <= 0.5) ? lum * (1 + sat) : lum + sat - lum * sat;
    // si w = 0, �a correspond � #000000 (w < 0 ne peut pas exister)
    if (w > 0) {
        var m = lum * 2 - w;
        var sv = (w - m) / w;
        var sext = Math.floor(tnt);
        var fract = tnt - sext;
        var vsf = w * sv * fract;
        var mid1 = m + vsf;
        var mid2 = w - vsf;
        
        switch (sext) {
            case 0 :    r = w;      v = mid1;   b = m; break;
            case 1 :    r = mid2;   v = w;      b = m; break;
            case 2 :    r = m;      v = w;      b = mid1; break;
            case 3 :    r = m;      v = mid2;   b = w; break;
            case 4 :    r = mid1;   v = m;      b = w; break;
            case 5 :    r = w;      v = m;      b = mid2;
        }
        
        // convertit r, v, b en entiers [0-255]
        r = Math.round(r * 255);
        v = Math.round(v * 255);
        b = Math.round(b * 255);
    }

    return {r:r, v:v, b:b};
}

// FONCTIONS UTILITAIRES POUR LA CLASSE INTERFACECOULEURS

function changerClasse(id, classe) {
    // change la classe d'une image identifi�e par son id
    if (document.getElementById && (img = document.getElementById(id))) img.className = classe;
}

function estCodeCouleur(couleur) {
    // contr�le un code couleur (hexa HHHHHH)
    return (couleur.search(/[0-9A-Fa-f]{6}/) != -1);
}

function octetEnHexa(nombre) {
    // convertit un nombre d�cimal [0, 255] en une chaine hexad�cimale ("00" � "FF")
    var cars_hexa = "0123456789ABCDEF";
    return cars_hexa.charAt(Math.floor(nombre / 16)) + cars_hexa.charAt(nombre % 16);
}

function RVBenCodeCouleur(rouge, vert, bleu) {
    // cr�e un code couleur � partir des trois couleurs rouge, vert, bleu
    var cars_hexa = "0123456789ABCDEF";
    var code = cars_hexa.charAt(Math.floor(rouge / 16)) + cars_hexa.charAt(rouge % 16);
    code += cars_hexa.charAt(Math.floor(vert / 16)) + cars_hexa.charAt(vert % 16);
    code += cars_hexa.charAt(Math.floor(bleu / 16)) + cars_hexa.charAt(bleu % 16);
    return code;
}

function estOctet(valeur) {
    // v�rifie si une valeur est un nombre compris entre 0 et 255
    if (isNaN(valeur) || (valeur < 0) || (valeur > 255)) return false;
    else return true;
}

function alerte(message) {
    // affiche un alert si g_alerts = true
    if (g_alertes) alert(message);
}

function codeCouleurEnRVB(couleur) {
    // convertit un code couleur en composantes RVB
    // retourne un objet {rouge, vert, bleu}
    var composantes = couleur.match(/(#?[0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})/);
    return {rouge: parseInt(composantes[1], 16), vert: parseInt(composantes[2], 16), bleu: parseInt(composantes[3], 16)};
}

function calculSaturation(code_couleur) {
    // calcul la saturation d'un code couleur
    // retourne une saturation entre 0 et 100 (0, 10, 20...100)
    
    var RVB = codeCouleurEnRVB(code_couleur);
    var r = RVB.rouge / 255;
    var v = RVB.vert / 255;
    var b = RVB.bleu / 255;
    
    var max = Math.max(r, v);
    max = Math.max(max, b);
    var min = Math.min(r, v);
    min = Math.min(min, b);

    var lum = (min + max) / 2;
    if (lum < 0) return;
    
    var diff = max - min;
    var sat = 0;
    // si diff = 0, c'est le cas du gris (tnt=0, sat=0)
    if (diff > 0) {
        if (lum < 0.5) sat = diff / (min + max);
        else sat = diff / (2 - min - max);
        sat = Math.round(sat * 10) * 10;
    }
    return sat;
}