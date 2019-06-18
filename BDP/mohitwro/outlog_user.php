<?php
session_start();

unset($_SESSION['log']);
unset($_SESSION['id']);
unset($_SESSION['imie']);
header('Location: index.php');