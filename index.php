<?php
session_start();
header('Access-Control-Allow-Origin:*'); //*代表可访问的地址，可以设置指定域名
header('Access-Control-Allow-Methods:POST,GET'); 
include "framework/core/Initiate.class.php";

Initiate::run();
