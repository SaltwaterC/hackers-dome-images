<?php
// FR fonction calendrier 10/07/04
echo  "<frameset rows='50,*' framespacing='0' border='0' frameborder='0'>";
echo  "<frame name='haut' scrolling='no' noresize  src='calendrierhaut.php?origine=".$_GET['origine']."'>";
//echo  "<frame name='bas'  scrolling='no' src='calendrierbas.php?origine=".$_GET['origine']."'>";
echo  "<frame name='bas'  scrolling='no' src='calendrierbas.php?origine=debut'>";
?>
  <noframes>
    <body>
        <p>Cette page utilise des cadres, mais votre navigateur
        ne les prend pas en charge.</p>
    </body>
  </noframes>
  
</frameset>