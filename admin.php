<?php
// on login attempt
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // if user/pw = admin/admin
    if($_POST['name'] == "admin" && $_POST['password'] == "admin") {
        header("Location: guestbook.php");
        exit();
    }

    // error checking
    $errors = [];

    // variable to simplify conditionals
    $nameOK = false;
    $pwOK = false;

    // if no name entered
    if(!isset($_POST['name']) || $_POST['name'] == "") {
        $errors[] = "Please enter a user name";
    } else {
        $nameOK = true;
    }

    // if no password entered
    if(!isset($_POST['password']) || $_POST['password'] == "") {
        $errors[] = "Please enter a password";
    } else {
        $pwOK = true;
    }

    // if they aren't right
    if($nameOK && $pwOK) {
        $errors[] = "Username and Password dont't match.";
    }
    // --> errors will be loaded inside login box
}

$title = "Login Page";
include("./includes/header.html");
?>

<!-- begin html -->
<div class="container mx-auto p-3 py-5 border shadow" id="login" style="">
    <h3 class="text-center">View Guestbook</h3>
    <br>
    <!-- display any errors from a previous login attempt -->
    <?php
        if(!empty($errors)) {
            foreach($errors as $error) {
                echo '<p class="text-center">' . $error . '</p>';
            }
        }
    ?>
    <!-- login form -->
    <form method="post" action="admin.php">

        <div class="row my-2 mx-4">
            <div class="col">
                <input type="text" class="form-control" placeholder="Username" name="name" value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>">
            </div>
        </div>
        <div class="row my-3 mx-4">
            <div class="col">
                <input type="password" class="form-control" placeholder="Password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>">
            </div>
        </div>
        <div class="row mt-4 text-center">
            <div class="col">
                <input id="loginSubmit" class="btn btn-purple" type="submit" value="Login">
            </div>
        </div>

    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>