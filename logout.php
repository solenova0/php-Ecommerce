<?php

require_once 'include/initialize.php';
session_start();
session_unset();
session_destroy();
redirect("index.php?logout=1");
?>