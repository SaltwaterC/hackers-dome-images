<?php
//$Id: agent.class.php,v 1.6 2008-07-29 14:00:45 jbastide Exp $
include ("../dyn/var.inc");
require_once ($path_om."formulairedyn.class.php");
require_once ($path_om."dbformdyn.class.php");
//051207
//les formulaires générés en ajax ne reconnaissent pas les fonctions java
//internes à ces formulaires d'où la necessité de les déclarer ici 
require_once ("candidature.class.php");
class agent extends dbForm
{
    var $table = "agent";
    var $clePrimaire = "agent";
    var $typeCle = "A";
    function agent ($id, $db, $debug)
    {
        $this -> constructeur ($id, $db, $debug);
    } // param_agent ($id, $db, $debug)
    function verifier ()
    {
        $this -> correct = True;
        $imgv="";
        $f="&nbsp!&nbsp;&nbsp;&nbsp;&nbsp;";
        $imgv="<img src='../img/punaise.png' align='middle'  border='0'>";
        if ($this -> valF ['agent'] == "")
        {
            $this -> correct = false;
            $this -> msg = $this -> msg .$imgv.$this->lang("code")."&nbsp;".$this->lang("agent")."&nbsp".$this->lang("obligatoire").$f;
        }
        if ($this -> valF ['nom'] == "")
        {
            $this -> correct = false;
            $this -> msg = $this -> msg .$imgv.$this->lang("nom")."&nbsp;".$this->lang("obligatoire").$f;
        }
        if ($this -> valF ['prenom'] == "")
        {
            $this -> correct = false;
            $this -> msg = $this -> msg .$imgv.$this->lang("prenom")."&nbsp;".$this->lang("obligatoire").$f;
        }
    } // verifier ()
    function setType (&$form, $maj) 
    {
        if ($maj < 2)
        {
            // Ajout
            $form -> setType ('service', 'select');
            $form -> setType ('grade', 'select');
            if ($maj == 1)
            {
                // Modification
                 $form -> setType ('agent', 'hiddenstatic');
            }
        }
        else
        {
             $form -> setType ('agent', 'hiddenstatic');
            // Suppression
        }
    } // setType (&$form, $maj) 
    function setSelect(&$form,$maj,$db,$DEBUG)
    {
        include ("../dyn/connexion.php");
        include ("../sql/".$dsn['phptype']."/".$this -> table.".form.inc");
        
        // Liste de choix : service
        $res = $db->query($sql_service);
        if (DB :: isError($res))
            die($res->getMessage().$sql_service);
        else
        {
            if ($DEBUG == 1)
                echo " la requete ".$sql_service." est exécutée<br>";
            $contenu [0][0] = "";
            $contenu [1][0] = $this->lang("choisir")."&nbsp;".$this->lang("un")."&nbsp;".$this->lang("service");
            $k=1;
            while ($row=& $res->fetchRow())
            {
                    $contenu[0][$k]=$row[0];
                    $contenu[1][$k]=$row[1];
                    $k++;
            }
            $form->setSelect('service',$contenu);
        }
        // Liste de choix : grade
        $contenu=array();
        $res = $db->query($sql_grade);
        if (DB :: isError($res))
            die($res->getMessage().$sql_grade);
        else
        {
            if ($DEBUG == 1)
                echo " la requete ".$sql_grade." est exécutée<br>";
            $contenu [0][0] = "";
            $contenu [1][0] = $this->lang("choisir")."&nbsp;".$this->lang("un")."&nbsp;".$this->lang("grade");
            $k=1;
            while ($row=& $res->fetchRow())
            {
                    $contenu[0][$k]=$row[0];
                    $contenu[1][$k]=$row[1];
                    $k++;
            }
            $form->setSelect('grade',$contenu);
        }
    } // setSelect(&$form,$maj,$db,$DEBUG)


function setOnchange(&$form,$maj){
$form->setOnchange("nom","this.value=this.value.toUpperCase()");
$form->setOnchange("ville","this.value=this.value.toUpperCase()");
}

function setVal(&$form,$maj,$validation){
if ($validation==0) {
  if ($maj == 0){
    include ("../dyn/var.inc");
    $form->setVal('cp', $client_cp);
    $form->setVal('ville', $client_ville);
}}
}

function cleSecondaire($id,$db,$val,$debug) {
$this->rechercheCandidature($id,$db,$debug) ;
}


function rechercheCandidature($id,$db,$debug){
    $this->correct=True;
    $imgv="";
    $f="&nbsp!&nbsp;&nbsp;&nbsp;&nbsp;";
    $imgv="<img src='../img/punaise.png' align='middle'  border='0'>";
    $sql = "select * from candidature where agent ='".$id."'";
    $res = $db->query($sql);
    if($debug==1) echo $sql;
    if (DB :: isError($res))
       die($res->getMessage(). " => Echec  ".$sql);
    else{
        $nbligne=$res->numrows();
        $this->msg = $this->msg.$imgv."&nbsp;".$this->lang("il_y_a")."&nbsp;<font class='parametre'>&nbsp;".$nbligne."&nbsp;</font>&nbsp;".
        $this->lang("enregistrement")."&nbsp;".$this->lang("en_lien")."&nbsp;".$this->lang("avec")."&nbsp;".$this->lang("table")." \"candidature\" ".$this->lang("pour")."&nbsp;".$this->lang("l")."&nbsp;".$this->lang("agent")."&nbsp; [".
        $id."]".$f."<br>";
        if ($nbligne>0)
           $this->correct=false;
    }
}  

}
?>