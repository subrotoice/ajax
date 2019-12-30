<?php
date_default_timezone_set('Asia/Dhaka');
$pdo = new PDO('mysql:host=localhost;dbname=vocabulary;charset=utf-8', "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); // Here PDO is super object something like obj.obj.method()