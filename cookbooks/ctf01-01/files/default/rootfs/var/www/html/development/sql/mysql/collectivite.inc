<?php
//
   $DEBUG=0;
   $serie=1;
   $ent = "parametrage -> collectivite";
  if(isset($idx)){
      if($idx != "]")
       if (trim($idx!=""))
         $ent = $ent."-><font id='idz1'>&nbsp;".$idx."&nbsp;</font>";
    }
    if(isset($idz) ){
      if (trim($idz!=""))
       $ent = $ent."&nbsp;<font id='idz1'>&nbsp;".strtoupper($idz)."&nbsp;</font>";
    }
   $ico = "../img/ico_parametrage.png";
   $edition="";
//
       $href[0]['lien']= "";
       $href[0]['id']= "";
       $href[0]['lib']= "";
       $href[1]['lien'] = "form.php?obj=collectivite&idx=";
       $href[1]['id']= "";
       $href[1]['lib']= "";
       $href[2]['lien'] = "";
       $href[2]['id']= "";
       $href[2]['lib']= "";
//
   $table="collectivite";
   $champAffiche=array("id",
                       "ville",
                       "maire");
   $champRecherche=array("ville");
   $selection="";
   $tri= "";
?>