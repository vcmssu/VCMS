<?php

function smarty_modifier_number($price) {
    return number_format($price, 0, ',', ' ');
}

?>