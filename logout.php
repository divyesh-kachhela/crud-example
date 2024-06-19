<?php
if(session_start() && session_unset() && session_destroy()) {
    header("Location: index.php");
    exit();
} else {
    echo "logout error";
}
?>