<?php
function smarty_modifier_posts($num)
{ 
$num100 = $num % 100;
$num10 = $num % 10;
if (($num100 >= 5 && $num100 <= 20) || ($num10 == 0) || ($num10 >= 5 && $num10 <= 9)) 
{ 
return $num.' просмотров'; 
} 
else if ($num10 >= 2 && $num10 <= 4) 
{ 
return $num.' просмотра'; 
} 
else 
{ 
return $num.' просмотр'; 
}
}
?>