<?php

ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

function pdo_connect_mysql()
{
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'php2';
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to database!');
    }
}

function template_header($title): string
{
    return <<<EOT
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>$title</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css” />
		<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
	</head>
	<body class="bg-body p-0 text-dark bg-opacity-10">
        <nav class="navbar navbar-expand-lg bg-body-tertiary mb-5">
          <div class="container-fluid text-bg-light p-2">
            <a class="navbar-brand">
            <img src="peopleLogo.png" id="logo" alt="Logo" width="30" height="35">
              CRM
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
              <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="index.php">Clients</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="logout.php">Logout</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
EOT;
}

function template_footer(): string
{
    return <<<EOT

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
EOT;
}

function test_input($data): string
{
    $data = trim($data);    //removes unnecessary chars (space, tab...)
    $data = stripslashes($data); //removes backslashes (\)
    return htmlspecialchars($data);
}

function get_Clients()
{
    $pdo = pdo_connect_mysql();
    if (!isset($_GET['company_id'])) {
        exit('No Company ID specified!');
    }
    $stmt = $pdo->prepare('SELECT * FROM clients WHERE company_id = ?');
    $stmt->execute([$_GET['company_id']]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$client) {
        exit('Invalid Company ID!');
    }
    return $client;
}


function print_Client($client): void
{
?>
    <h2><?= htmlspecialchars($client['company_name'], ENT_QUOTES) ?></h2>
<div class="client">
    <p class="msg"><?= nl2br("#" . htmlspecialchars($client['company_id'], ENT_QUOTES)) ?></p>
    <p class="msg"><?= nl2br("<b>Contact Person: </b>" . htmlspecialchars($client['contact_person'], ENT_QUOTES)) ?></p>
    <p class="msg"><?= nl2br("<b>Address: </b>" . htmlspecialchars($client['address'], ENT_QUOTES)) ?></p>
    <p class="msg"><?= nl2br("<b>Phone: </b>" . htmlspecialchars($client['phone'], ENT_QUOTES)) ?></p>
    <p class="msg"><?= nl2br("<b>Created by: </b>" . htmlspecialchars($client['created_by'], ENT_QUOTES)) ?></p>
    <p class="msg"><?= nl2br("<b>Created at: </b>" . htmlspecialchars($client['created_at'], ENT_QUOTES)) ?></p>
    <?php if (!empty($client['edited_at'])) { ?>
        <p class="msg"><?= nl2br("<b>Edited at: </b>" . htmlspecialchars($client['edited_at'], ENT_QUOTES)) ?></p>
    <?php } ?>
</div>
<?php }?>





