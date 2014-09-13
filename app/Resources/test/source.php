<?php 

$pattern = '#^[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}$#';
var_dump(preg_match($pattern, null));