<?php
// $Id: fpdf_etiquette.php,v 1.1 2008-07-24 13:18:52 jbastide Exp $
// openMairie : http://www.openmairie.org
// contact@openmairie.org
require_once('fpdf.php');
//
class PDF extends FPDF
{
    //
     var $msg=0;
    //
    // Give the height for a char size given.
    function Get_Height_Chars($pt) {
        // Tableau de concordance entre la hauteur des caract�res et de l'espacement entre les lignes
        $_Table_Hauteur_Chars = array(6=>2, 7=>2.5, 8=>3, 9=>4, 10=>5, 11=>6, 12=>7, 13=>8, 14=>9, 15=>10);
        if (in_array($pt, array_keys($_Table_Hauteur_Chars))) {
            return $_Table_Hauteur_Chars[$pt];
        } else {
            return 100; // There is a prob..
        }
    }
    // M�thode qui permet de modifier la taille des caract�res
    // Cela modifiera aussi l'espace entre chaque ligne
    function Set_Font_Size($pt,$Char_Size,$Line_Height) {
        if ($pt > 3) {
            $this->$Char_Size = $pt;
            $this->$Line_Height = $this->Get_Height_Chars($pt);
            $this->SetFontSize($this->$Char_Size);
        }
    }
  function Table_position($sql,$db,$param,$champs,$texte,$champs_compteur,$img)
  {
      //
      global $police;
      //
      $_Margin_Left=$param[0];
      $_Margin_Top=$param[1];
      $_X_Space=$param[2];
      $_Y_Space=$param[3];
      $_X_Number=$param[4];
      $_Y_Number=$param[5];
      $_Width=$param[6];
      $_Height=$param[7];
      $_Char_Size=$param[8];
      $_Line_Height=$param[9];
      $_cptx=$param[10];
      $_cpty=$param[11];
      $_cadre=$param[13];
      $_cadrezone=$param[14];
      $this->Set_Font_Size($param[12],$param[8],$param[9]);
      //
      $res =& $db->query($sql);
      //
       if (DB::isError($res)) {
          $this->erreur_db($res->getDebugInfo(),$res->getMessage(),'');
      }
      else
      {
        $nbChamp=0;
        $nbtexte=0;
        $nbimg=0;
        $_PosX =0;
        $_PosY =0;
        $info=$res->tableInfo();
        $nbChamp=count($info);
        $nbtexte=count($texte);
        $nbimg=count($img);
        $compteur=0;
        $tmpchamps="";
        $nb_txt=0;
        if (!isset($champs_compteur[0])) $champs_compteur[0]=0; //php4
        //
        $nbrow=0;
        $nbrow=$res->numrows();
        //
        while ($row=& $res->fetchRow(DB_FETCHMODE_ASSOC)) {
              $compteur++;
              $k=0;
              $j=0;
              if ($_cptx==0){//-------------------------------------------------
                  $_PosX =$_Margin_Left;
                  $_PosY =$_Margin_Top+($_cpty*($_Height+$_Y_Space))+$_cpty;
                  $this->SetXY($_PosX, $_PosY);
                  //cadre zone definie
                  $this->MultiCell($_Width,$_Height,"",$_cadrezone);
                  if ($champs_compteur[0]==1){
                    $archx= $_PosX;
                    $archy= $_PosY;
                    $champ_bold='';
                    $champ_size=$param[12];
                    $this->SetXY($archx+$champs_compteur[1],$archy+$champs_compteur[2]);
                    //bold et size
                    if ($champs_compteur[4]==1){$champ_bold='B';}
                    if ($champs_compteur[5]>0){$champ_size=$champs_compteur[5];}
                    $this->SetFont($police,$champ_bold,$champ_size);
                    $this->Set_Font_Size($champ_size,$param[8],$param[9]);
                    //
                    $this->MultiCell($champs_compteur[3],$_Line_Height,$compteur,$_cadre);
                    $this->SetXY($archx,$archy);
                  }
                  for($j=0;$j<$nbChamp;$j++){
                    $archx= $_PosX;
                    $archy= $_PosY;
                    $champ_bold='';
                    $champ_size=$param[12];
                   // ---------------------------------------$this->MultiCell($_Width,$_Height,"",$_cadrezone);
                    $this->SetXY($archx+$champs[$info[$j]['name']][2][0],$archy+$champs[$info[$j]['name']][2][1]);
                    //bold et size
                    if ($champs[$info[$j]['name']][2][3]==1) {$champ_bold='B';}
                    if ($champs[$info[$j]['name']][2][4]>0) {$champ_size=$champs[$info[$j]['name']][2][4];}
                    $this->SetFont($police,$champ_bold,$champ_size);
                    $this->Set_Font_Size($champ_size,$param[8],$param[9]);
                    //
                    if($champs[$info[$j]['name']][3]==1){
                       $champs_num="";
                       $champs_num=number_format($row[$info[$j]['name']],0);
                       $this->MultiCell($champs[$info[$j]['name']][2][2],$_Line_Height,$champs[$info[$j]['name']][0].$champs_num.$champs[$info[$j]['name']][1],$_cadre);
                    }
                    else
                    {
                     $this->MultiCell($champs[$info[$j]['name']][2][2],$_Line_Height,$champs[$info[$j]['name']][0].$row[$info[$j]['name']].$champs[$info[$j]['name']][1],$_cadre);
                    }
                    $this->SetXY($archx,$archy);
                  }
                  for($i=0;$i<$nbimg;$i++){
                   //
                   $archx= $_PosX;
                   $archy= $_PosY;
                   $this->SetXY($archx+$img[$i][1],$archy+$img[$i][2]);
                   //
                   $this->Image($img[$i][0],$archx+$img[$i][1],$archy+$img[$i][2],$img[$i][3],$img[$i][4],$img[$i][5]);
                   $this->SetXY($archx,$archy);
                  }
                  for($k=0;$k<$nbtexte;$k++){
                    $archx= $_PosX;
                    $archy= $_PosY;
                    $champ_bold='';
                    $champ_size=$param[12];
                    $this->SetXY($archx+$texte[$k][1],$archy+$texte[$k][2]);
                    //bold et size
                    if ($texte[$k][4]==1){$champ_bold='B';}
                    if ($texte[$k][5]>0){$champ_size=$texte[$k][5];}
                    $this->SetFont($police,$champ_bold,$champ_size);
                    $this->Set_Font_Size($champ_size,$param[8],$param[9]);
                    //
                    $this->MultiCell($texte[$k][3],$_Line_Height,$texte[$k][0],$_cadre);
                    $this->SetXY($archx,$archy);
                  }
                 $_cptx++;
                 if ($_cptx==$_X_Number){
                      $_cptx=0;
                      $_cpty++;
                      if ($_cpty==$_Y_Number){
                        $_cptx=0;
                        $_cpty=0;
                        //
                        if ($compteur<$nbrow){
                            $this->AddPage();
                        }//
                      }
                 }
              }//---------------------------------------------------------------
              else
              {//---------------------------------------------------------------
                  $_PosX =$_Margin_Left+($_cptx*($_Width+$_X_Space));
                  $_PosY =$_Margin_Top+($_cpty*( $_Height+$_Y_Space))+$_cpty;
                  $this->SetXY($_PosX, $_PosY);
                  //cadre zone definie
                  $this->MultiCell($_Width,$_Height,"",$_cadrezone);
                  if ($champs_compteur[0]==1){
                    $archx= $_PosX;
                    $archy= $_PosY;
                    $champ_bold='';
                    $champ_size=$param[12];
                    $this->SetXY($archx+$champs_compteur[1],$archy+$champs_compteur[2]);
                    //bold et size
                    if ($champs_compteur[4]==1){$champ_bold='B';}
                    if ($champs_compteur[5]>0){$champ_size=$champs_compteur[5];}
                    $this->SetFont($police,$champ_bold,$champ_size);
                    $this->Set_Font_Size($champ_size,$param[8],$param[9]);
                    //
                    $this->MultiCell($champs_compteur[3],$_Line_Height,$compteur,$_cadre);
                    $this->SetXY($archx,$archy);
                  }
                  for($j=0;$j<$nbChamp;$j++){
                    $archx= $_PosX;
                    $archy= $_PosY;
                    $champ_bold='';
                    $champ_size=$param[12];
                    //-------------------------$this->MultiCell($_Width,$_Height,"",$_cadrezone);
                    $this->SetXY($archx+$champs[$info[$j]['name']][2][0],$archy+$champs[$info[$j]['name']][2][1]);
                    //bold et size
                    if ($champs[$info[$j]['name']][2][3]==1){$champ_bold='B';}
                    if ($champs[$info[$j]['name']][2][4]>0){$champ_size=$champs[$info[$j]['name']][2][4];}
                    $this->SetFont($police,$champ_bold,$champ_size);
                   $this->Set_Font_Size($champ_size,$param[8],$param[9]);
                    //
                    if($champs[$info[$j]['name']][3]==1){
                       $champs_num="";
                       $champs_num=number_format($row[$info[$j]['name']],0);
                       $this->MultiCell($champs[$info[$j]['name']][2][2],$_Line_Height,$champs[$info[$j]['name']][0].$champs_num.$champs[$info[$j]['name']][1],$_cadre);
                    }
                    else
                    {
                     $this->MultiCell($champs[$info[$j]['name']][2][2],$_Line_Height,$champs[$info[$j]['name']][0].$row[$info[$j]['name']].$champs[$info[$j]['name']][1],$_cadre);
                    }
                    $this->SetXY($archx,$archy);
                  }
                 for($i=0;$i<$nbimg;$i++){
                   //
                   $archx= $_PosX;
                   $archy= $_PosY;
                   $this->SetXY($archx+$img[$i][1],$archy+$img[$i][2]);
                   //
                   $this->Image($img[$i][0],$archx+$img[$i][1],$archy+$img[$i][2],$img[$i][3],$img[$i][4],$img[$i][5]);
                   $this->SetXY($archx,$archy);
                  }
                  for($k=0;$k<$nbtexte;$k++){
                    $archx= $_PosX;
                    $archy= $_PosY;
                    $champ_bold='';
                    $champ_size=$param[12];
                    $this->SetXY($archx+$texte[$k][1],$archy+$texte[$k][2]);
                    //bold et size
                    if ($texte[$k][4]==1){$champ_bold='B';}
                    if ($texte[$k][5]>0){$champ_size=$texte[$k][5];}
                    $this->SetFont($police,$champ_bold,$champ_size);
                    $this->Set_Font_Size($champ_size,$param[8],$param[9]);
                    //
                    $this->MultiCell($texte[$k][3],$_Line_Height,$texte[$k][0],$_cadre);
                    $this->SetXY($archx,$archy);
                  }
                  $_cptx++;
                  if ($_cptx==$_X_Number){
                        $_cptx=0;
                        $_cpty++;
                        if ($_cpty==$_Y_Number){
                            $_cptx=0;
                            $_cpty=0;
                            // mo
                            if ($compteur<$nbrow){
                                $this->AddPage();
                            }//
                        }
                  }
             }// fin else $_cptx//----------------------------------------------
        }// while
        // aucun enregistrement
        if($nbrow==0){
            $this->SetTextColor(245,34,108);
            $this->SetDrawColor(245,34,108);
            $_PosX =$_Margin_Left;
            $_PosY =$_Margin_Top+($_cpty*($_Height+$_Y_Space))+$_cpty;
            $this->SetXY($_PosX+10, $_PosY+10);
            $this->MultiCell(100,10,'   Aucun enregistrement s�lectionn�',1);
        }
        $res->free();
      }// DB
   }// fonction table etiquette

// =====================================================================
// Traitement d erreur
// transfert � l ecran des erreurs de bases de donnees
// $debuginfo : info table de donn�es
// $messageDB : message d erreur DB pear
// $table = table concern�e
// =====================================================================
function erreur_db($debuginfo,$messageDB,$table)
{
  include ("error_db.inc");
        $this->SetFont('arial','','9');
        $this->ln();
        $this->Cell(0,10,'Attention, Erreur de base de donn�es',0,1,'L');
        $this->Cell(0,10,$requete,0,1,'L');
        $this->Cell(0,10,$erreur_origine,0,1,'L');
        $this->Cell(0,10,$messageDB,0,1,'L');
        $this->Cell(0,10,$msgfr,0,1,'L');
        $this->Cell(0,10,'Contactez votre administrateur',0,1,'L');
}
}// fin class
//******************************************************************************
?>