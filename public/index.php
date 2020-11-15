<?php require_once('config.php') ?>

<?php require_once( ROOT_PATH . '/includes/functions.php') ?>
<?php require_once( ROOT_PATH . '/includes/create_login_functions.php') ?>

<!-- Retrieve all inventory items from database  -->
<?php $items = getInventoryItems(); ?>

<!-- Retrieve any booked items if a user is logged in -->
<?php if (isset($_SESSION['user'])) : ?>
    <?php $bookedItems = getBookedItems($_SESSION['user']['id']); ?>
<?php endif ?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="static/css/style.css">
    <meta charset="UTF-8">
	<title>Inventory Site</title>
</head>

<body>

    <!-- Container wraps page content -->
    <div class="container">

        <?php if (isset($_SESSION['user'])) : ?>

            <!-- Navbar for regular users -->
            <?php if ($_SESSION['user']['role'] == "User" ): ?>
                <ul class="navbar">
                    <li><a href="<?php echo BASE_URL;?>">Home</a></li>
                    <li><a href="<?php echo BASE_URL . '/user_dash.php';?>">Booked Items</a></li>
                    <li><a href="index.php?logout">Log Out</a></li>
                </ul>
                <hr>
            
            <!-- Navbar for admin -->
            <?php elseif ($_SESSION['user']['role'] == "Admin" ): ?> 
                <ul class="navbar">
                    <li><a href="<?php echo BASE_URL;?>">Home</a></li>
                    <li><a href="<?php echo BASE_URL . '/admin/admin_dash.php';?>">Add/edit inventory</a></li>
                    <li><a href="index.php?logout">Log Out</a></li>
                </ul>
                <hr>
            
            <?php endif ?>

         <!-- Login section if not logged in -->
         <?php else: ?>
                <form method="post" enctype="multipart/form-data" action="<?php echo BASE_URL . '/index.php'; ?>">
                    <h2>Login</h2>  
                    <input type="text" name="username" value="<?php echo $username; ?>" value="" placeholder="Username">
                    <input type="password" name="password"  placeholder="Password"> 
                    <button class="btn" type="submit" name="login_btn">Sign in</button> 
                    <br>
                    <p>Need an account? <a href="<?php echo BASE_URL . '/create_account.php';?>">Create account</a></p>
                </form>
                <hr>

        <?php endif ?>

        <!-- Items List -->
        <h2 class="items-title">Items List</h2>
            
        <div class="items-list">

            <?php foreach ($items as $item): ?>
                <?php if ($item['quantity']>0) : ?>

                    <div class="item-info">
                        <h3><?php echo $item['name'] ?></h3>
                        <div class="info">
                            <span class="description"><?php echo $item['description'] ?></span>
                            <br>
                            <span class="quantity">Quantity - <?php echo $item['quantity'] ?></span>
                        </div>

                        <!-- If user logged in show BOOK/UNBOOK buttons -->
                        <?php if (isset($_SESSION['user'])) : ?>
                            <a href="index.php?bookItem=<?php echo $item['id'] ?>">BOOK</a>
                        <?php endif ?>
                    </div>
                    
                <?php endif ?>
            <?php endforeach ?>

        </div>

    
    
    </div>
    <!-- End page content -->

</body>
