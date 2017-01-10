<?php
function smarty_modifier_ending_subscribers($num)
{ 
$num100 = $num % 100;
$num10 = $num % 10;
if (($num100 >= 5 && $num100 <= 20) || ($num10 == 0) || ($num10 >= 5 && $num10 <= 9)) 
{ 
return $num.' подписчиков'; 
} 
else if ($num10 >= 2 && $num10 <= 4) 
{ 
return $num.' подписчика'; 
} 
else 
{ 
return $num.' подписчик'; 
}
}
?>