<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
?>
<?= template_header('Registered') ?>
<div class="container">
    <p>You have been successfully registered! You will be redirected to the login page in a view seconds!</p>
</div>
<script>setTimeout(function () {
        window.location.href = 'login.php';
    }, 3500);
</script>

<?= template_footer() ?>
