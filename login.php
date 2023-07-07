<?php
include 'functions.php';

$pdo = pdo_connect_mysql(); // Connects to MySQL
$msg = '';
$usernameErr = $passwordErr = "";
$username = $password = "";
$pwSet = false;
$userSet = false;
$fillUserName = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $usernameErr = "Name is required";
    } else {
        $username = test_input($_POST["name"]);
        $userSet = true;
    }
    if (empty($_POST["userPassword"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["userPassword"];
        $pwSet = true;
    }
}

if ($userSet && $pwSet) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE name = :username");
    $stmt->bindParam(':username', $username);

    if ($stmt->execute()) {
        $arr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $arr[] = $row["name"];
            $pwFromDB = $row["userPassword"];
            $userID = $row["user_id"];
        }
        if (empty($arr)) {
            $msg = "This username doesn't exist. Please try again!";
        } else {
            if (password_verify($password, $pwFromDB)) {
                // Passwords match, login successful
                session_start();
                $_SESSION["username"] = $username;
                $_SESSION["user_id"] = $userID;
                header('Location: index.php');
                exit;
            } else {
                $msg = "Invalid password. Please try again!";
            }
        }
    }
}


?>
<?= template_header('Login') ?>
<div class="container">
    <?php if ($msg): ?>
        <p class="alert alert-danger" role="alert"><?= $msg ?></p>
    <?php endif; ?>
    <h2>Login to your Account</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group mt-3">
            <div class="col-sm-3">
                <label for="name" class="form-label">Username:</label>
                <input id="name" type="text" name="name" class="form-control"
                       required <?php if (($fillUserName) && isset($_POST['name'])) {
                    echo 'value=' . $_POST['name'];
                } ?> >
            </div>
        </div>
        <div class="form-group mt-3">
            <div class="col-sm-3">
                <label for="userPassword" class="form-label">Password:</label>
                <input id="userPassword" type="password" name="userPassword" class="form-control" required>
            </div>
        </div>
        <div class="form-group mt-3">
                <input type="submit" class="btn btn-success" name="submit" value="Login"">
        </div>
    </form>
    <p class="mt-3">Don't have an account yet?</p>
    <button id="register-btn" class="btn btn-outline-success" onclick="window.location.href = 'registerUser.php';">REGISTER
        HERE
    </button>

</div>
<?= template_footer() ?>

