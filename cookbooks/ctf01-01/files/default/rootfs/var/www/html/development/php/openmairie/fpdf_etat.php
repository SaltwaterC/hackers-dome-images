<?php
//$Id: fpdf_etat.php,v 1.2 2008-10-15 16:20:43 fraynaud1 Exp $
// openMairie : http://www.openmairie.org
// contact@openmairie.org

//require ("../php/fpdf/fpdf.php");
require_once ($path_fpdf."fpdf.php");
class PDF extends fpdf
{
var $footerfont;
var $footerattribut;
var $footertaille;


// surcharge fpdf
//Pied de page
function Footer()
{
    //Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    //Police Arial italique 8
    $this->SetFont('Arial','I',8);
    //Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
//nouvelle fonction : ROTATION texte 90 45 .....
function TextWithRotation($xr,$yr,$txtr,$txtr_angle,$font_angle=0)
{
    $txtr=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txtr)));

    $font_angle+=90+$txtr_angle;
    $txtr_angle*=M_PI/180;
    $font_angle*=M_PI/180;

    $txtr_dx=cos($txtr_angle);
    $txtr_dy=sin($txtr_angle);
    $font_dx=cos($font_angle);
    $font_dy=sin($font_angle);

    $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',
             $txtr_dx,$txtr_dy,$font_dx,$font_dy,
             $xr*$this->k,($this->h-$yr)*$this->k,$txtr);
    if ($this->ColorFlag)
        $s='q '.$this->TextColor.' '.$s.' Q';
    $this->_out($s);
}

// nouvelle fonction
function sousetat(&$db,$etat,$sousetat){
          $GLOBALS['entete_flag']=$sousetat['entete_flag'];
         //
         $res =& $db->query($sousetat['sql']);
         if (DB::isError($res)) {
            $this->erreur_db($res->getDebugInfo(),$res->getMessage(),'');
          }else{
          $info=$res->tableInfo();
          }
          $this->SetDrawColor($sousetat['bordure_couleur'][0],$sousetat['bordure_couleur'][1],$sousetat['bordure_couleur'][2]);////couleur du tracé
          //intervalle
          $this->ln($sousetat['intervalle_debut']);
          //titre
          $this->SetFillColor($sousetat['titrefondcouleur'][0],$sousetat['titrefondcouleur'][1],$sousetat['titrefondcouleur'][2]);
          $this->SetTextColor($sousetat['titretextecouleur'][0],$sousetat['titretextecouleur'][1],$sousetat['titretextecouleur'][2]);
          $this->SetFont($sousetat["titrefont"],$sousetat["titreattribut"],$sousetat["titretaille"]);
          $this->MultiCell($sousetat['tableau_largeur'],$sousetat["titrehauteur"],$sousetat["titre"],$sousetat["titrebordure"],$sousetat["titrealign"],$sousetat["titrefond"]);
          //
          $nbchamp=count($info);
          //
          $this->SetFont($etat['se_font'],'',$sousetat['tableau_fontaille']);
          // ENTETE
         if ($sousetat['entete_flag']==1){
             $this->SetFillColor($sousetat['entete_fondcouleur'][0],$sousetat['entete_fondcouleur'][1],$sousetat['entete_fondcouleur'][2]);
             $this->SetTextColor($sousetat['entete_textecouleur'][0],$sousetat['entete_textecouleur'][1],$sousetat['entete_textecouleur'][2]);
             //texte horizontal
             if (!isset($sousetat['entete_orientation']))
             {
                 //-------------------------------------------
                 for($k=0;$k<$nbchamp;$k++)
                 {
                   $this->Cell($sousetat['cellule_largeur'][$k],$sousetat['entete_hauteur'],strtoupper($info[$k]['name']),$sousetat['entetecolone_bordure'][$k],0,$sousetat['entetecolone_align'][$k],$sousetat['entete_fond']);
                }
                //-------------------------------------------
             }
             else
             {
                 //texte avec angle
                    for($k=0;$k<$nbchamp;$k++)
                    {
                    //mo 27 mars 2008-------------------------------------------
                    //texte horizontal si entete_orientation =0
                    if ($sousetat['entete_orientation'][$k]==0){
                       $this->Cell($sousetat['cellule_largeur'][$k],$sousetat['entete_hauteur'],strtoupper($info[$k]['name']),$sousetat['entetecolone_bordure'][$k],0,$sousetat['entetecolone_align'][$k],$sousetat['entete_fond']);
                    }else{
                     //mo 27 mars 2008---------------------------------------
                     if ($sousetat['entete_orientation'][$k]>0)
                       {
                                         $this->Cell($sousetat['cellule_largeur'][$k],$sousetat['entete_hauteur'],'',$sousetat['entetecolone_bordure'][$k],0,$sousetat['entetecolone_align'][$k],$sousetat['entete_fond']);
                                         $xd=$this->Getx();
                                         $yd=$this->Gety();
                                         $xd=$xd-(floor($sousetat['cellule_largeur'][$k]/2));
                                         if ($sousetat['entete_orientation'][$k]<91)
                                         {
                                           $yd=($yd+$sousetat['entete_hauteur'])-1;
                                         }
                                         else
                                         {
                                            $yd=($yd+$sousetat['entete_hauteur'])-5;
                                         }
                                         $this->TextWithRotation($xd,$yd,strtoupper($info[$k]['name']),$sousetat['entete_orientation'][$k],0);
                              }
                       else
                       {
                            //$this->Cell($sousetat['cellule_largeur'][$k],$sousetat['entete_hauteur'],strtoupper($info[$k]['name']),$sousetat['entetecolone_bordure'][$k],0,$sousetat['entetecolone_align'][$k],$sousetat['entete_fond']);
                             $this->Cell($sousetat['cellule_largeur'][$k],$sousetat['entete_hauteur'],'',$sousetat['entetecolone_bordure'][$k],0,$sousetat['entetecolone_align'][$k],$sousetat['entete_fond']);
                                         $xd=$this->Getx();
                                          $yd=$this->Gety();
                                         $xd = $xd -  floor((($sousetat['cellule_largeur'][$k]/2))) - floor(strlen ($info[$k]['name']));
                                         $yd=($yd+$sousetat['entete_hauteur'])-3;
                                         $this->TextWithRotation($xd,$yd,strtoupper($info[$k]['name']),$sousetat['entete_orientation'][$k],0);
                       }
                     }//mo 27 mars 2008 fin else entete_orientation'][$k]different de zero
                   }//fin for
            }

             //
             $this->ln();
        }

        //
         $couleur=1;
         $this->SetTextColor($etat['se_couleurtexte'][0],$etat['se_couleurtexte'][1],$etat['se_couleurtexte'][2]);
         //  initialisation
          for($j=0;$j<$nbchamp;$j++)
              $total[$j]=0;
         $cptenr=0;
         $flagtotal=0;
         $flagmoyenne=0;
         $flagcompteur=0;
         //
          while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)){
                //
                if ($couleur==1){
                   $this->SetFillColor($sousetat['se_fond1'][0],$sousetat['se_fond1'][1],$sousetat['se_fond1'][2]);
                   $couleur=0;
                }else{
                   $this->SetFillColor($sousetat['se_fond2'][0],$sousetat['se_fond2'][1],$sousetat['se_fond2'][2]);
                   $couleur=1;
                }
               //
               //preparer multiligne
               $max_ln=1;  
               $multi_height=$sousetat['cellule_hauteur'];
               //Etablir nb lignes necessaires et preparer chaines avec \n
               for($j=0;$j<$nbchamp;$j++){
// A ajouter eventuellement dans .sousetat.inc
// //à 1 texte organisé en multiligne, avec autre valeur texte compressé
// $sousetat['cellule_multiligne']=array("0","0","1","1","1","0","0","1","1","0");
// //pourcentage de hauteur utilisée pour 1 ligne d'une cellule multiligne
// $sousetat['cellule_hautmulti']=1/2; 
                  if (isset($sousetat['cellule_multiligne'])) {  //si variable définie, valeur à 1 => multiligne 
                    if ($sousetat['cellule_multiligne'][$j]==1) {
                      $t_ln=$this->PrepareMultiCell($sousetat['cellule_largeur'][$j],$row[$info[$j]['name']]);
                      if ($t_ln>$max_ln) $max_ln=$t_ln;
                    } // sinon compression
                  } else {  //si variable non definie, multiligne par defaut
                    $t_ln=$this->PrepareMultiCell($sousetat['cellule_largeur'][$j],$row[$info[$j]['name']]);
                    if ($t_ln>$max_ln) $max_ln=$t_ln;
                  }
               }
               //fixation de la nouvelle hauteur si plus d'1 ligne selon quota hauteur/nblignesmulti ou pas
               if ($max_ln>1)
                 if (isset($sousetat['cellule_hautmulti'])) //si valeur cellule_hautmulti existe
                   $multi_height=$max_ln*$sousetat['cellule_hauteur']*$sousetat['cellule_hautmulti'];
                  else  //sinon valeur par defaut 1/2
                   $multi_height=$max_ln*$sousetat['cellule_hauteur']*1/2;
               for($j=0;$j<$nbchamp;$j++){
                  if (isset($sousetat['cellule_numerique'][$j]) AND TRIM($sousetat['cellule_numerique'][$j])!=""){
                     //champs non numerique = 999 , numerique
                     if ($sousetat['cellule_numerique'][$j]==999){ // non numerique
                         if ($cptenr==0){
                          $this->Cell($sousetat['cellule_largeur'][$j],$multi_height,$row[$info[$j]['name']],$sousetat['cellule_bordure_un'][$j],0,$sousetat['cellule_align'][$j],$sousetat['cellule_fond']);
                         }else{
                          $this->Cell($sousetat['cellule_largeur'][$j],$multi_height,$row[$info[$j]['name']],$sousetat['cellule_bordure'][$j],0,$sousetat['cellule_align'][$j],$sousetat['cellule_fond']);
                         }
                  }else{ // numerique
                      if ($cptenr==0){
                         $this->Cell($sousetat['cellule_largeur'][$j],$multi_height,number_format($row[$info[$j]['name']], $sousetat['cellule_numerique'][$j], ',', ' '),$sousetat['cellule_bordure_un'][$j],0,$sousetat['cellule_align'][$j],$sousetat['cellule_fond']);
                       }else{
                          $this->Cell($sousetat['cellule_largeur'][$j],$multi_height,number_format($row[$info[$j]['name']], $sousetat['cellule_numerique'][$j], ',', ' '),$sousetat['cellule_bordure'][$j],0,$sousetat['cellule_align'][$j],$sousetat['cellule_fond']);
                       }
                         // si total = calcul variable total
                          if ($sousetat['cellule_total'][$j]==1){
                             $total[$j] = $total[$j]+$row[$info[$j]['name']];
                             $flagtotal=1;
                          }
                          if ($sousetat['cellule_moyenne'][$j]==1){
                             if ($flagtotal==0)
                                $total[$j] = $total[$j]+$row[$info[$j]['name']];
                             $flagmoyenne=1;
                          }

                  }}
                  if ($sousetat['cellule_compteur'][$j]==1){
                             $flagcompteur=1;
                  }
               }// fin for
               $cptenr=$cptenr+1;
               $this->ln();
          }//fin while
          //
          // apres derniere ligne
          if ($sousetat['tableau_bordure']=="1"){
             $this->Cell($sousetat['tableau_largeur'],0,'',"T",1,'L',0);
          }
          //affichage total----------------------------------------------------
          if ($flagtotal==1){
              for($k=0;$k<$nbchamp;$k++){
                   if ($sousetat['cellule_total'][$k]==1){
                        $this->SetFont($etat['se_font'],'',$sousetat['cellule_fontaille_total']);
                       $this->SetFillColor($sousetat['cellule_fondcouleur_total'][0],$sousetat['cellule_fondcouleur_total'][1],$sousetat['cellule_fondcouleur_total'][2]);
                       $this->Cell($sousetat['cellule_largeur'][$k],$sousetat['cellule_hauteur_total'],number_format($total[$k], $sousetat['cellule_numerique'][$k], ',', ' '),$sousetat['cellule_bordure_total'][$k],0,$sousetat['cellule_align_total'][$k],$sousetat['cellule_fond_total']);
                   }else{// affichage sur la colone correspondante
                      if ($k==0){
                         // 1ere colone
                         $this->SetFont($etat['se_font'],'',$sousetat['cellule_fontaille_total']);
                         $this->SetFillColor($sousetat['cellule_fondcouleur_total'][0],$sousetat['cellule_fondcouleur_total'][1],$sousetat['cellule_fondcouleur_total'][2]);
                         $this->Cell($sousetat['cellule_largeur'][$k],$sousetat['cellule_hauteur_total'],'TOTAL',$sousetat['cellule_bordure_total'][$k],0,$sousetat['cellule_align_total'][$k],$sousetat['cellule_fond_total']);
                      }else{
                         // colones suivante
                         $this->SetFont($etat['se_font'],'',$sousetat['cellule_fontaille_total']);
                         $this->SetFillColor($sousetat['cellule_fondcouleur_total'][0],$sousetat['cellule_fondcouleur_total'][1],$sousetat['cellule_fondcouleur_total'][2]);
                         $this->Cell($sousetat['cellule_largeur'][$k],$sousetat['cellule_hauteur_total'],'',$sousetat['cellule_bordure_total'][$k],0,$sousetat['cellule_align_total'][$k],$sousetat['cellule_fond_total']);
                      }
                   }
              }//fin for k
              $this->ln();

         }
         //$k=0;
         //affichage moyenne----------------------------------------------------
         if ($flagmoyenne==1){
              for($k=0;$k<$nbchamp;$k++){
                   if ($sousetat['cellule_moyenne'][$k]==1){
                       $this->SetFont($etat['se_font'],'',$sousetat['cellule_fontaille_moyenne']);
                       $this->SetFillColor($sousetat['cellule_fondcouleur_moyenne'][0],$sousetat['cellule_fondcouleur_moyenne'][1],$sousetat['cellule_fondcouleur_moyenne'][2]);
                       $this->Cell($sousetat['cellule_largeur'][$k],$sousetat['cellule_hauteur_moyenne'],number_format($total[$k]/$cptenr, $sousetat['cellule_numerique'][$k], ',', ' '),$sousetat['cellule_bordure_moyenne'][$k],0,$sousetat['cellule_align_moyenne'][$k],$sousetat['cellule_fond_moyenne']);
                   }else{// affichage sur la colone correspondante
                      if ($k==0){
                         // 1ere colone
                         $this->SetFont($etat['se_font'],'',$sousetat['cellule_fontaille_moyenne']);
                         $this->SetFillColor($sousetat['cellule_fondcouleur_moyenne'][0],$sousetat['cellule_fondcouleur_moyenne'][1],$sousetat['cellule_fondcouleur_moyenne'][2]);
                         $this->Cell($sousetat['cellule_largeur'][$k],$sousetat['cellule_hauteur_moyenne'],'MOYENNE',$sousetat['cellule_bordure_moyenne'][$k],0,$sousetat['cellule_align_moyenne'][$k],$sousetat['cellule_fond_moyenne']);
                      }else{
                         // colones suivante
                         $this->SetFont($etat['se_font'],'',$sousetat['cellule_fontaille_moyenne']);
                         $this->SetFillColor($sousetat['cellule_fondcouleur_moyenne'][0],$sousetat['cellule_fondcouleur_moyenne'][1],$sousetat['cellule_fondcouleur_moyenne'][2]);
                         $this->Cell($sousetat['cellule_largeur'][$k],$sousetat['cellule_hauteur_moyenne'],'',$sousetat['cellule_bordure_moyenne'][$k],0,$sousetat['cellule_align_moyenne'][$k],$sousetat['cellule_fond_moyenne']);
                      }
                   }
              }//fin for k
              $this->ln();
           }
         //affichage compteur----------------------------------------------------
         if ($flagcompteur==1){
              for($k=0;$k<$nbchamp;$k++){
                   if ($sousetat['cellule_compteur'][$k]==1){
                       $this->SetFont($etat['se_font'],'',$sousetat['cellule_fontaille_nbr']);
                       $this->SetFillColor($sousetat['cellule_fondcouleur_nbr'][0],$sousetat['cellule_fondcouleur_nbr'][1],$sousetat['cellule_fondcouleur_nbr'][2]);
                       $this->Cell($sousetat['cellule_largeur'][$k],$sousetat['cellule_hauteur_nbr'],number_format($cptenr, 0, ',', ' '),$sousetat['cellule_bordure_nbr'][$k],0,$sousetat['cellule_align_nbr'][$k],$sousetat['cellule_fond_nbr']);
                   }else{// affichage sur la colone correspondante
                      if ($k==0){
                         // 1ere colone
                         $this->SetFont($etat['se_font'],'',$sousetat['cellule_fontaille_nbr']);
                         $this->SetFillColor($sousetat['cellule_fondcouleur_nbr'][0],$sousetat['cellule_fondcouleur_nbr'][1],$sousetat['cellule_fondcouleur_nbr'][2]);
                         $this->Cell($sousetat['cellule_largeur'][$k],$sousetat['cellule_hauteur_nbr'],'NOMBRE',$sousetat['cellule_bordure_nbr'][$k],0,$sousetat['cellule_align_nbr'][$k],$sousetat['cellule_fond_nbr']);
                      }else{
                         // colones suivante
                         $this->SetFont($etat['se_font'],'',$sousetat['cellule_fontaille_nbr']);
                         $this->SetFillColor($sousetat['cellule_fondcouleur_nbr'][0],$sousetat['cellule_fondcouleur_nbr'][1],$sousetat['cellule_fondcouleur_nbr'][2]);
                         $this->Cell($sousetat['cellule_largeur'][$k],$sousetat['cellule_hauteur_nbr'],'',$sousetat['cellule_bordure_nbr'][$k],0,$sousetat['cellule_align_nbr'][$k],$sousetat['cellule_fond_nbr']);
                      }
                   }
              }//fin for k
              $this->ln();
         }
   if ( $cptenr>0){
      $this->ln($sousetat['intervalle_fin']);
  }

}// fin fonction sous etat





function PrepareMultiCell($w,&$txt)
{   //prepare un texte passé par référence (en le modifiant) avec ajout \n pour traitement par Cell modifié  
    //et retourne nb ligne necessaire
    //basé sur code MultiCell mais pas d'affichage
    $cw=&$this->CurrentFont['cw']; //largeur caractere
    if($w==0) //si largeur=0, largeur=largeurcourante-margegauche-positionx
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s); //longueur texte sans retour chariot
    if($nb>0 && $s[$nb-1]=="\n")
        $nb--;      //supp. dernier retour ligne si existe
    $sep=-1;    //espace
    $i=0;       //index boucle
    $j=0;
    $l=0;
    $ns=0;
    $nl=1;
  $nbrc=0; //nb retourcharriot
    while($i<$nb) {  //boucle sur texte
        //Get next character
        $c=$s{$i};  //caractere courant
        if($c=="\n") {  //retour ligne
            //Explicit line break
            $i++;     //
            $sep=-1;   //raz espace
            $j=$i;     //debut de ligne
            $l=0;
            $ns=0;
            $nl++;   //nb ligne +1
            continue; // prochain caractere
        }
        if($c==' ') {  //si espace
            $sep=$i; //position espace
            $ls=$l;
            $ns++;
        }
        $l+=$cw[$c];
        if($l>$wmax) { //si ligne depasse largeur
            //Automatic line break
            if($sep==-1) { //si aucun espace detecte
                if($i==$j)
                    $i++;
            } else { //espace detecte
                $i=$sep+1;   //prochain car = car suivant dernier espace
            }  //insertion retour charriot dans texte
      $txt=substr($txt,0,$i+$nbrc)."\n".substr($txt,$i+$nbrc);
      $nbrc++;
            $sep=-1;
            $j=$i;
            $l=0;
            $ns=0;
            $nl++;   //nb ligne +1 
        } else //ligne < largeur colonne
            $i++;
    }  //fin de texte
  return $nl;
}

function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='')  
//surcharge pour retour ligne sur detection \n sinon compression
//changement
//border: indicates if borders must be drawn around the cell. The value can be either a number:
//0: no border 
//>0: frame of the corresponding width 
//or a string containing some or all of the following characters (in any order): 
//L: left 
//T: top 
//R: right 
//B: bottom 
//or for bold border: 
//l: left 
//t: top 
//r: right 
//b: bottom 
//Default value: 0.
{
    //Output a cell
    $k=$this->k;
    if($this->y+$h>$this->PageBreakTrigger and !$this->InFooter and $this->AcceptPageBreak())
    {
        $x=$this->x;
        $ws=$this->ws;
        if($ws>0)
        {
            $this->ws=0;
            $this->_out('0 Tw');
        }
        $this->AddPage($this->CurOrientation);
        $this->x=$x;
        if($ws>0)
        {
            $this->ws=$ws;
            $this->_out(sprintf('%.3f Tw', $ws*$k));
        }
    }
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $s='';
// begin change Cell function 12.08.2003 
    if($fill==1 or $border>0)
    {
        if($fill==1)
            $op=($border>0) ? 'B' : 'f';
        else
            $op='S';
        if ($border>1) {
            $s=sprintf(' q %.2f w %.2f %.2f %.2f %.2f re %s Q ', $border, 
                $this->x*$k, ($this->h-$this->y)*$k, $w*$k, -$h*$k, $op);
        }
        else
            $s=sprintf('%.2f %.2f %.2f %.2f re %s ', $this->x*$k, ($this->h-$this->y)*$k, $w*$k, -$h*$k, $op);
    }
    if(is_string($border))
    {
        $x=$this->x;
        $y=$this->y;
        if(is_int(strpos($border, 'L')))
            $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', $x*$k, ($this->h-$y)*$k, $x*$k, ($this->h-($y+$h))*$k);
        else if(is_int(strpos($border, 'l')))
            $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', $x*$k, ($this->h-$y)*$k, $x*$k, ($this->h-($y+$h))*$k);
            
        if(is_int(strpos($border, 'T')))
            $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', $x*$k, ($this->h-$y)*$k, ($x+$w)*$k, ($this->h-$y)*$k);
        else if(is_int(strpos($border, 't')))
            $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', $x*$k, ($this->h-$y)*$k, ($x+$w)*$k, ($this->h-$y)*$k);
        
        if(is_int(strpos($border, 'R')))
            $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', ($x+$w)*$k, ($this->h-$y)*$k, ($x+$w)*$k, ($this->h-($y+$h))*$k);
        else if(is_int(strpos($border, 'r')))
            $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', ($x+$w)*$k, ($this->h-$y)*$k, ($x+$w)*$k, ($this->h-($y+$h))*$k);
        
        if(is_int(strpos($border, 'B')))
            $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', $x*$k, ($this->h-($y+$h))*$k, ($x+$w)*$k, ($this->h-($y+$h))*$k);
        else if(is_int(strpos($border, 'b')))
            $s.=sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', $x*$k, ($this->h-($y+$h))*$k, ($x+$w)*$k, ($this->h-($y+$h))*$k);
    }
    if (trim($txt)!='') {
        $cr=substr_count($txt, "\n");
        if ($cr>0) { // Multi line
            $txts = explode("\n", $txt);
            $lines = count($txts);
            //$dy=($h-2*$this->cMargin)/$lines;
            for($l=0;$l<$lines;$l++) {
                $txt=$txts[$l];
                $w_txt=$this->GetStringWidth($txt);
                if($align=='R')
                    $dx=$w-$w_txt-$this->cMargin;
                elseif($align=='C')
                    $dx=($w-$w_txt)/2;
                else
                    $dx=$this->cMargin;

                $txt=str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
                if($this->ColorFlag)
                    $s.='q '.$this->TextColor.' ';
                $s.=sprintf('BT %.2f %.2f Td (%s) Tj ET ', 
                    ($this->x+$dx)*$k, 
                    ($this->h-($this->y+.5*$h+(.7+$l-$lines/2)*$this->FontSize))*$k, 
                    $txt);
                if($this->underline)
                    $s.=' '.$this->_dounderline($this->x+$dx, $this->y+.5*$h+.3*$this->FontSize, $txt);
                if($this->ColorFlag)
                    $s.='Q ';
                if($link)
                    $this->Link($this->x+$dx, $this->y+.5*$h-.5*$this->FontSize, $w_txt, $this->FontSize, $link);
            }
        }
        else { // Single line
            $w_txt=$this->GetStringWidth($txt);
            $Tz=100;
            if ($w_txt>$w-2*$this->cMargin) { // Need compression
                $Tz=($w-2*$this->cMargin)/$w_txt*100;
                $w_txt=$w-2*$this->cMargin;
            }
            if($align=='R')
                $dx=$w-$w_txt-$this->cMargin;
            elseif($align=='C')
                $dx=($w-$w_txt)/2;
            else
                $dx=$this->cMargin;
            $txt=str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
            if($this->ColorFlag)
                $s.='q '.$this->TextColor.' ';
            $s.=sprintf('q BT %.2f %.2f Td %.2f Tz (%s) Tj ET Q ', 
                        ($this->x+$dx)*$k, 
                        ($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k, 
                        $Tz, $txt);
            if($this->underline)
                $s.=' '.$this->_dounderline($this->x+$dx, $this->y+.5*$h+.3*$this->FontSize, $txt);
            if($this->ColorFlag)
                $s.='Q ';
            if($link)
                $this->Link($this->x+$dx, $this->y+.5*$h-.5*$this->FontSize, $w_txt, $this->FontSize, $link);
        }
    }
// end change Cell function 12.08.2003
    if($s)
        $this->_out($s);
    $this->lasth=$h;
    if($ln>0)
    {
        //Go to next line
        $this->y+=$h;
        if($ln==1)
            $this->x=$this->lMargin;
    }
    else
        $this->x+=$w;
}

// =====================================================================
// Traitement d erreur
// transfert à l ecran des erreurs de bases de donnees
// $debuginfo : info table de données
// $messageDB : message d erreur DB pear
// $table = table concernée
// =====================================================================
function erreur_db($debuginfo,$messageDB,$table)
{
  include ("error_db.inc");
        $this->SetFont('arial','','9');
        $this->ln();
        $this->Cell(0,10,'Attention, Erreur de base de données',0,1,'L');
        $this->Cell(0,10,$requete,0,1,'L');
        $this->Cell(0,10,$erreur_origine,0,1,'L');
        $this->Cell(0,10,$messageDB,0,1,'L');
        $this->Cell(0,10,$msgfr,0,1,'L');
        $this->Cell(0,10,'Contactez votre administrateur',0,1,'L');
}

} //fin class pdf
?>