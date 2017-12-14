<?php
include("inc/config.php");
if(isset($_SESSION["user_id"])){
    session_unset();
    session_destroy();
    header("Location: log-ind");
    exit();
} else {
    header("Location: log-ind");
    exit();
}
?>