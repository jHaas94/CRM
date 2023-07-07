<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

$msg = '';
// Check if POST data exists (the user submitted the form)
if (isset($_POST['name'], $_POST['email'], $_POST['userPassword'])) {
    // Validation checks... make sure the POST data is not empty
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['userPassword'])) {
        $msg = 'Please complete the form!';
    } else {
        $hashed_password = password_hash($_POST['userPassword'], PASSWORD_BCRYPT);

        $stmt = $pdo->prepare('INSERT INTO users (name, email, userPassword) VALUES (?, ?, ?)');
        $stmt->execute([$_POST['name'], $_POST['email'], $hashed_password]);
        session_start();
        $_SESSION["username"] = $_POST['name'];
        header('Location: successfulRegistering.php');
        exit;
    }
}
?>
<?= template_header('Register') ?>
<div class="container">
    <?php if ($msg): ?>
        <p class="alert alert-danger" role="alert"><?= $msg ?></p>
    <?php endif; ?>
    <h2>Add Client</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="mb-3">
            <label class="form-label" for="name">Username:</label>
            <input class="form-control" id="name" type="text" name="name" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">E-Mail:</label>
            <input class="form-control" id="email" type="email" name="email" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="userPassword">Password:</label>
            <input class="form-control" id="userPassword" type="password" name="userPassword" required>
        </div>
        <div class="mb-3">
            <input type="submit" name="submit" value="Register" class="btn btn-success mb-3">
        </div>
    </form>

</div>
<?= template_footer() ?>




