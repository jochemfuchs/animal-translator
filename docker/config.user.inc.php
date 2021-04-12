<?php

if(!isset($i) || $i <= 0) {
    $i = 1;
}

$cfg['Servers'][$i]['host'] = 'mysql8';
$cfg['Servers'][$i]['port'] = 3306;
$cfg['Servers'][$i]['auth_type'] = 'config';
$cfg['Servers'][$i]['user'] = 'root';
$cfg['Servers'][$i]['password'] = 'secret';
