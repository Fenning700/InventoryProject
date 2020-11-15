<?php require_once('config.php') ?>

<?php require_once( ROOT_PATH . '/includes/functions.php') ?>

<!-- Retrieve all booked items & inventory items from database  -->
<?php $items = getInventoryItems(); ?>
<?php $bookedItems = getBookedItems($_SESSION['user']['id']); ?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="static/css/style.css">
    <meta charset="UTF-8">
    <title>User Dashboard</title>
</head>

<body>
    
    <!-- Container wraps page content -->
    <div class="container">

        <ul class="navbar">
            <li><a href="<?php echo BASE_URL;?>">Home</a></li>
            <li><a href="<?php echo BASE_URL . '/user_dash.php';?>">Booked Items</a></li>
            <li><a href="index.php?logout">Log Out</a></li>
        </ul>
        <hr>

        <h2 class="items-title">Booked Items</h2>

        <?php foreach ($bookedItems as $item): ?>

            <div class="item-info">
                <h3><?php echo $item['name'] ?></h3>
                <div class="info">
                    <span class="description"><?php echo $item['description'] ?></span>
                </div>
                <br>
                <a href="user_dash.php?unbook=<?php echo $item['id'] ?>">UNBOOK</a>
            </div>

        <?php endforeach ?>


    </div> 
    <!-- End page content -->

</body>