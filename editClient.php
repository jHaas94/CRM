<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
session_start();

$client = get_Clients();

//for updating the data:
$msg = '';
if (isset($_POST['company_name'], $_POST['contact_person'], $_POST['phone'], $_POST['address'])) {
    // Validation checks... make sure the POST data is not empty
    if (empty($_POST['company_name']) || empty($_POST['contact_person']) || empty($_POST['phone']) || empty($_POST['address'])) {
        $msg = 'Please complete the form!';
    } else {
        // Insert new record into the clients table
        $stmt = $pdo->prepare('UPDATE clients SET company_name = ?, contact_person = ?, phone = ?, address = ?, created_by = ? where company_id = ?');
        $stmt->execute([$_POST['company_name'], $_POST['contact_person'], $_POST['phone'], $_POST['address'], $_SESSION["user_id"], $_GET['company_id']]);
        // Redirect to the view clients page. The user will see their created client on this page.
        header('Location: viewClient.php?company_id=' . $_GET['company_id']);
        exit;
    }
}
?>

<?= template_header('Edit Client') ?>

<div class="container">

    <?php print_Client($client)?>

    <?php if ($msg): ?>
        <p class="alert alert-danger" role="alert"><?= $msg ?></p>
    <?php endif; ?>
    <h2 class="insideOfText">Edit Client</h2>
    <p>Please enter all the data that you would like to change!</p>
    <form action="editClient.php?company_id=<?php echo $client['company_id'] ?>" method="post">
        <div class="mb-3">
            <label for="company_name" class="form-label">Name of the company:</label>
            <input class="form-control" type="text" name="company_name" required value="<?php echo $client["company_name"];?>">
        </div>
        <div class="mb-3">
            <label for="contact_person" class="form-label">Contact person:</label>
            <input class="form-control" type="text" name="contact_person" required value="<?php echo $client["contact_person"];?>">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone:</label>
            <input class="form-control" name="phone" required value="<?php echo $client["phone"];?>">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address:</label>
            <input class="form-control" name="address" required value="<?php echo $client["address"];?>">
        </div>
        <input type="submit" value="Save changes" class="btn btn-success mb-3">
    </form>
</div>

<?= template_footer() ?>

