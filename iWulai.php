<?php
header('Content-Type:application/json; charset=utf-8');
var_dump($_FILES);
exit(json_encode($_FILES));