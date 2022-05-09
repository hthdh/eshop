<?php
const DB_HOST="localhost";
const DB_LOGIN="root";
const DB_PASSWORD="";
const DB_NAME="eshop";
const ORDER_LOG= "../admin/orders.log";
$basket=array();
$count=0;
$link = new mysqli(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);
basketInit();
