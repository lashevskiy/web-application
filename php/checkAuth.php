<?php
if (!isset($_SESSION['user_id']) or empty($_SESSION['user_id'])) {
    header('Location: ' . "index.php");
}
?>