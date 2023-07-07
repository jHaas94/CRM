<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
session_start();

if (empty($_SESSION["username"]) || empty(($_SESSION["user_id"]))) {
    header('Location: login.php');
    exit;
} else {
    $stmt = $pdo->prepare('SELECT * FROM clients');
    $stmt->execute();
    $client = $stmt->fetchAll();
}
?>

<?= template_header('View all Clients') ?>


<div class="container">
    <?php if (!empty($_SESSION["deletedUser"])) {
        ?><p class="alert alert-success" role="alert">User has been successfully deleted!</p><?php
    }
    unset($_SESSION["deletedUser"]) ?>
    <h2 class="mb-4">Welcome <?php echo $_SESSION["username"] . "!" ?></h2>
    <div class="row">
        <div class="col">
            <h3>Clients:</h3>
        </div>
        <div class="col-1">
            <a href="createClients.php"><i class="bi bi-person-fill-add text-success" id="create-icon"></i></a>
        </div>
    </div>
    <table class="table table-light table-bordered table-striped table-responsive">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Company Name</th>
            <th scope="col">Contact Person</th>
            <th scope="col">Phone</th>
            <th scope="col">Address</th>
            <th scope="col">Created by</th>
            <th scope="col">Date of creation</th>
            <th scope="col">Date of editing</th>
            <th scope="col">View</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($client); $i++) { ?>
            <tr>
                <td><?= $client[$i][0] ?></td>
                <td><?= $client[$i][1] ?></td>
                <td><?= $client[$i][2] ?></td>
                <td><?= $client[$i][3] ?></td>
                <td><?= $client[$i][4] ?></td>
                <td><?= $client[$i][5] ?></td>
                <td><?= $client[$i][6] ?></td>
                <td><?= $client[$i][7] ?></td>
                <td><i id="eye" class="bi bi-eye-fill"
                       onclick="window.location='viewClient.php?company_id=<?= nl2br(htmlspecialchars($client[$i][0], ENT_QUOTES)) ?>'"></i>
                </td>
            </tr>

            <?php
        } ?>
        </tbody>
    </table>

</div>

<?= template_footer() ?>

