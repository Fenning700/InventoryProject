<?php require_once('../config.php') ?>

<?php require_once( ROOT_PATH . '/includes/functions.php') ?>

<!-- Retrieve all inventory items from database  -->
<?php $items = getInventoryItems(); ?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../static/css/style.css">
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>

<body>

    <!-- Container wraps page content -->
    <div class="container">

        <ul class="navbar">
            <li><a href="<?php echo BASE_URL;?>">Home</a></li>
            <li><a href="<?php echo BASE_URL . '/admin/admin_dash.php';?>">Add/edit inventory</a></li>
            <li><a href="index.php?logout">Log Out</a></li>
        </ul>
        <hr>

        <h2 class="items-title">Current Items</h2>

        <div class="items-list">
            <?php foreach ($items as $item): ?>
            <div class="item-info">
                <span class="quantity"><?php echo $item['name'] ?></span><br>
                <span>Quantity - <?php echo $item['quantity'] ?></span><br>
                <span>Item added - <?php echo $item['created_at'] ?></span><br>
                <a href="admin_dash.php?edit-item=<?php echo $item['id'] ?>">EDIT</a>
                <a href="admin_dash.php?delete-item=<?php echo $item['id'] ?>">DELETE</a>
                <br>
            </div>
            <?php endforeach ?>
        </div>

        <!-- Create items form -->
        <div class="create-items">
            <h2>Create Items</h2>
            <form method="post" enctype="multipart/form-data" action="<?php echo BASE_URL . '/admin/admin_dash.php'; ?>" >

                <!-- if editing item, the id is required to identify that item -->
                <?php if ($isEditingItem === true): ?>
                    <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                <?php endif ?>

                <input type="text" name="name" value="<?php echo $name; ?>" placeholder="Name">
                <br><br>
                <textarea name="description" id="description" cols="25" rows="3" placeholder="Item Description"><?php echo $description; ?></textarea>
                <br>
                <input type="number" name="quantity" min="0" value="<?php echo $quantity; ?>" placeholder="Quantity">
                <br><br>
                <!-- if editing item, display the update button instead of create button -->
                <?php if ($isEditingItem === true): ?> 
                    <button type="submit" class="btn" name="update_item">UPDATE</button>
                <?php else: ?>
                    <button type="submit" class="btn" name="create_item">Save Item</button>
                <?php endif ?>
            
            </form>

        </div>
    </div>
    <!-- End page content -->

</body>