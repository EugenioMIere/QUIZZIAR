<?php
session_start();

if (isset($_POST['f5_pressed']) && $_POST['f5_pressed'] === 'true') {
    $_SESSION['f5_pressed'] = true;
}
?>
