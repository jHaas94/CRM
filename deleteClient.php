<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
session_start();

if(isset($_SESSION['created_by'])) {
    if ($_SESSION['created_by'] === $_SESSION["user_id"]) {
        $stmt = $pdo->prepare('DELETE FROM clients where company_id = ?');
        $stmt->execute([$_GET['company_id']]);

        $_SESSION['deletedUser'] = true;
        unset($_SESSION['created_by']);

    }
}
header('Location: index.php');
