<?php
$d1="gmail.com";
$d2="gmail.com..";
$r1=checkdnsrr($d1, "MX"); 
$r2=checkdnsrr($d2, "MX"); 
var_dump($r1);
var_dump($r2);

$str = 'salem@gmail.com';
$ex = explode('@', $str);
$tt = end($ex);
var_dump($tt);