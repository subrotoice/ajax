<?php
date_default_timezone_set('Asia/Dhaka');

$date = new DateTime();
$returnText = $date->getTimestamp();
echo $returnText*1000;
