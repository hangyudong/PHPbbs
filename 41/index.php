<?php
session_start();
include 'bootstrap/Psr4.php';
include 'bootstrap/start.php';
include 'bootstrap/alias.php';
$config = include 'Config/config.php';

Start::router();