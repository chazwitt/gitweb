<?php 
$Shortcut = "[InternetShortcut] 
URL=http://www.pinminwang.com
IDList= 
[{000214A0-0000-0000-C000-000000000046}] 
Prop3=19,2 
"; 
Header("Content-type: application/octet-stream"); 
header("Content-Disposition: attachment; filename=商云时代平台.url;"); 
echo $Shortcut; 
?>