<?php
session_start();

unset($_SESSION['logged']);
unset($_SESSION['id']);
header('Location: index.php');