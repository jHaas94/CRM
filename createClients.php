<?php
include 'functions.php';

$pdo = pdo_connect_mysql();
session_start();
$msg = '';
// Check if POST data exists (the user submitted the form)
if (isset($_POST['company_name'], $_POST['contact_person'], $_POST['phone'], $_POST['address'])) {
    // Validation checks... make sure the POST data is not empty
    if (empty($_POST['company_name']) || empty($_POST['contact_person']) || empty($_POST['phone']) || empty($_POST['address'])) {
        $msg = 'Please complete the form!';
    } else {
        // Insert new record into the clients table
        $stmt = $pdo->prepare('INSERT INTO clients (company_name, contact_person, phone, address, created_by) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$_POST['company_name'], $_POST['contact_person'], $_POST['phone'], $_POST['address'], $_SESSION["user_id"]]);

        header('Location: viewClient.php?company_id=' . $pdo->lastInsertId());
        exit;
    }
}
?>

<?= template_header('Create Client') ?>

<div class="container">
    <?php if ($msg): ?>
        <p class="alert alert-danger" role="alert"><?= $msg ?></p>
    <?php endif; ?>
    <h2>Add Client</h2>
    <form action="createClients.php" method="post">
        <div class="mb-3">
            <label class="form-label" for="company_name">Name of the company:</label>
            <input class="form-control" type="text" name="company_name" id="company_name"
                   required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="contact_person">Contact person:</label>
            <input class="form-control" type="text" name="contact_person"
                   id="contact_person" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="phone">Phone:</label>
            <input class="form-control" name="phone" id="phone" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="address">Address:</label>
            <input class="form-control" name="address" id="address" required>
        </div>

        <input type="submit" value="Add Client" class="btn btn-success mb-3">
    </form>
</div>

<?= template_footer() ?>

