<?php
include 'functions.php';

$client = get_Clients();
session_start();
$_SESSION['created_by'] = $client['created_by'];
?>

<?= template_header('Client') ?>

<div class="container">
    <a href="index.php"><i class="bi bi-arrow-return-left" id="return-icon"></i>Return to Clients</a>
    <div class="card border-success mt-3" style="width: 18rem;">
        <div class="card-body">
            <?php print_Client($client)?>
            <?php if ($client['created_by'] === $_SESSION["user_id"]) { ?>
                <div class="btns">
                    <a id="confirmation" href="deleteClient.php?company_id=<?php echo $client['company_id'] ?>">
                        <button type="button" class="btn btn-danger">DELETE</button>
                    </a>
                    <a id="edit-link" href="editClient.php?company_id=<?php echo $client['company_id'] ?>">
                        <button type="button" class="btn btn-success">EDIT</button>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script src="script.js"></script>
<?= template_footer() ?>


