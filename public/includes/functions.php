<?php

// General variables
$errors = [];

/* * * * * * * * * * * * * * * *
* Returns all inventory items *
* * * * * * * * * * * * * * */
function getInventoryItems() {
	// use global $conn object to access MySQL (config.php)
	global $conn;
	$sql = "SELECT * FROM items";
	$result = mysqli_query($conn, $sql);

	// fetch all items as an array called $items
	$items = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $items;
}


/* * * * * * * * * * * * * * * * *
* Handle booking & booked  items *
* * * * * * * * * * * * * * * * */
// if user clicks the book item button
if (isset($_GET['bookItem'])) {
	$item_id = $_GET['bookItem'];
	bookItem($item_id);
}

// if user clicks the unbook item button
if (isset($_GET['unbook'])) {
	$item_id = $_GET['unbook'];
	unbook($item_id);
}

function bookItem($item_id){
	global $conn;
	$user_id = ($_SESSION['user']['id']);
	$reduceQty = "UPDATE items SET quantity=quantity-1 WHERE id=$item_id";	
	$query = "INSERT INTO bookedItems (user_id, item_id) VALUES ($user_id, $item_id)";

	if (mysqli_query($conn, $query)){
		// Reduce item quantity if booked
		mysqli_query($conn, $reduceQty);
		// redirect to public area
		header('location: index.php');				
		exit(0);
	}
}

function getBookedItems($user_id) {	
	global $conn;
	$sql = "SELECT items.name, items.description, items.id FROM bookedItems AS bi INNER JOIN items ON items.id = bi.item_id WHERE bi.user_id = $user_id" ; 
	$result = mysqli_query($conn, $sql);
	// fetch all booked items as an array
	$bookedItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $bookedItems;
}

function unbook($item_id){
	global $conn;
	$addQty = "UPDATE items SET quantity=quantity+1 WHERE id=$item_id";
	$sql = "DELETE FROM bookedItems WHERE item_id=$item_id";

	if (mysqli_query($conn, $sql)) {
		// Add to item quantity if unbooked
		mysqli_query($conn, $addQty);
		// Redirect user to dash
		header('location: user_dash.php');
		exit(0);
	}
}


/* * * * * * * * * * * * * * 
* Add, edit & delete items *
* * * * * * * * * * * * * */

// Item variables
$item_id = 0;
$isEditingItem = false;
$name = "";
$description = "";
$quantity = 0;

// if user clicks the create item button
if (isset($_POST['create_item'])) { 
	createItem($_POST); 
}
// if user clicks the edit item button
if (isset($_GET['edit-item'])) {
	$isEditingItem = true;
	$item_id = $_GET['edit-item'];
	editItem($item_id);
}
// if user clicks the update item button
if (isset($_POST['update_item'])) {
	updateItem($_POST);
}
// if user clicks the delete item button
if (isset($_GET['delete-item'])) {
	$item_id = $_GET['delete-item'];
	deleteItem($item_id);
}

// takes values posted from form as parameter

function createItem($request_values)
{
	global $conn, $errors, $name, $item_id, $description, $quantity;
	$name = $request_values['name'];
	$description = $request_values['description'];
	$quantity = $request_values['quantity'];
	
	// validate form
	if (empty($name)) { array_push($errors, "Item name is required"); }
	if (empty($description)) { array_push($errors, "Item description is required"); }
	if (empty($quantity)) { array_push($errors, "Item quantity is required"); }
	
	// create item if there are no errors in the form
	if (count($errors) == 0) {
		$query = "INSERT INTO items (user_id, name, description, quantity, created_at, updated_at) 
					VALUES(1, '$name', '$description', $quantity, now(), now())";
		if(mysqli_query($conn, $query)){ // if item created successfully
			header('location: admin_dash.php');
			exit(0);
		}
	}
}


// takes item id as parameter
// fetches item from DB
// adds item info to form fields for editing
function editItem($id)
{
	global $conn, $name, $description, $quantity, $isEditingItem, $item_id;
	$sql = "SELECT * FROM items WHERE id=$id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$item = mysqli_fetch_assoc($result);
	// set form values on the form to be updated
	$name = $item['name'];
	$description = $item['description'];
	$quantity = $item['quantity'];
}
// takes values posted from form as parameter
function updateItem($request_values)
{
	global $conn, $errors, $item_id, $name, $description, $quantity;

	$name = $request_values['name'];
	$description = $request_values['description'];
	$quantity = $request_values['quantity'];
	$item_id = $request_values['item_id'];

	if (empty($name)) { array_push($errors, "Item name is required"); }
	if (empty($description)) { array_push($errors, "Item description is required"); }

	// register item if there are no errors in the form
	if (count($errors) == 0) {
		$query = "UPDATE items SET name='$name', description ='$description', quantity=$quantity, updated_at=now() WHERE id=$item_id";
		
		if(mysqli_query($conn, $query)){ // if item created successfully
			$_SESSION['message'] = "Item updated successfully";
			header('location: admin_dash.php');
			exit(0);
		}
	}
}


// delete item
function deleteItem($item_id)
{
	global $conn;
	$sql = "DELETE FROM items WHERE id=$item_id";
	if (mysqli_query($conn, $sql)) {
		header('location: admin_dash.php');
		exit(0);
	}
}


?>