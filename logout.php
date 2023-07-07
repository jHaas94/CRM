<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

session_start();
session_destroy();
?>
<?= template_header('Logout') ?>
    <div class="container">
        <p>You have been logged out. You will be redirected in a view seconds!</p>
    </div>
    <script>setTimeout(function () {
            window.location.href = 'login.php';
        }, 3000);
    </script>

<?= template_footer() ?>