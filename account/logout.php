<?php
    session_start();
    session_destroy();
    echo '<script>';
    echo 'window.location.href = "http://localhost/new/login.php ";';
    echo '</script>';
?>