<?php
require_once '../include/initialize.php';
session_start();
session_unset();
session_destroy();
redirect(web_root . "admin/login.php?logout=1");
?>