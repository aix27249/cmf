<?php
error_reporting(E_ALL);
ini_set("display_errors", "On");

if (isset($_GET['debug'])) $styles[]="debug.css";

preventCaching();
