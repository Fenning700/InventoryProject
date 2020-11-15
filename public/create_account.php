<?php require_once('config.php') ?>

<?php require_once( ROOT_PATH . '/includes/create_login_functions.php') ?>

<!DOCTYPE html>
<html>
<head>
    <!-- <link rel="stylesheet" href="static/css/style.css"> -->
    <meta charset="UTF-8">
	<title>Inventory | Create Account</title>
</head>

<body>
    <form method="post" action="create_account.php" >
        <h2>Register with us!</h2>
        <input  type="text" name="username" value="<?php echo $username; ?>"  placeholder="Username">
        <input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
        <input type="password" name="password_1" placeholder="Password">
        <input type="password" name="password_2" placeholder="Password confirmation">
        <button type="submit" class="btn" name="reg_user">Register</button>
        <p>
            Already a member? <a href="index.php">Sign in </a>on the home page
        </p>
    </form>




</body>
