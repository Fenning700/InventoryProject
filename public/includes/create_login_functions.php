<?php 
	// variable declaration
	$username = "";
	$email    = "";
	$errors = array(); 

	// REGISTER USER
	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password_1 = $_POST['password_1'];
		$password_2 = $_POST['password_2'];

		// form validation: ensure that the form is correctly filled
		if (empty($username)) {  array_push($errors, "We need your username"); }
		if (empty($email)) { array_push($errors, "Email is missing"); }
		if (empty($password_1)) { array_push($errors, "We need your password"); }
		if ($password_1 != $password_2) { array_push($errors, "The two passwords do not match");}

		// Check that no user is registered twice. 
		// the email and usernames should be unique
		$user_check_query = "SELECT * FROM users WHERE username='$username' 
								OR email='$email' LIMIT 1";

		$result = mysqli_query($conn, $user_check_query);
		$user = mysqli_fetch_assoc($result);

		if ($user) { // if user exists
			if ($user['username'] === $username) {
			  array_push($errors, "Username already exists");
			}
			if ($user['email'] === $email) {
			  array_push($errors, "Email already exists");
			}
		}
		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = $password_1;
			$query = "INSERT INTO users (username, email, role, password, created_at, updated_at) 
					  VALUES('$username', '$email', 'User', '$password', now(), now())";
			mysqli_query($conn, $query);

			// Send user confirmation email *** NOT WORKING ***
			// send();

			// get id of created user
			$reg_user_id = mysqli_insert_id($conn); 

			// put logged in user into session array
			$_SESSION['user'] = getUserById($reg_user_id);

		
            $_SESSION['message'] = "You are now logged in";
            // redirect to public area
            header('location: index.php');				
            exit(0);
			
		}
	}

	// LOG USER IN
	if (isset($_POST['login_btn'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];

		if (empty($username)) { array_push($errors, "Username required"); }
		if (empty($password)) { array_push($errors, "Password required"); }
		if (empty($errors)) {
			$password = $password;
			$sql = "SELECT * FROM users WHERE username='$username' and password='$password' LIMIT 1";

			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {
				// get id of created user
				$reg_user_id = mysqli_fetch_assoc($result)['id']; 

				// put logged in user into session array
				$_SESSION['user'] = getUserById($reg_user_id); 

				// if user is admin, redirect to admin area
				if ( in_array($_SESSION['user']['role'], ["Admin"])) {
					$_SESSION['message'] = "You are now logged in";
					// redirect to admin area
					header('location: ' . BASE_URL . '/admin/admin_dash.php');
					exit(0);
				} else {
					$_SESSION['message'] = "You are now logged in";
					// redirect to public area
					header('location: index.php');				
					exit(0);
				}
			} else {
				array_push($errors, 'Wrong credentials');
			}
		}
	}
	// escape value from form
	function esc(String $value)
	{	
		// bring the global db connect object into function
		global $conn;

		$val = trim($value); // remove empty space sorrounding string
		$val = mysqli_real_escape_string($conn, $value);

		return $val;
	}
	// Get user info from user id
	function getUserById($id)
	{
		global $conn;
		$sql = "SELECT * FROM users WHERE id=$id LIMIT 1";

		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result);

		return $user; 
    }

    // if user clicks the logout button
    if (isset($_GET['logout'])) {
        logout();
    }

    function logout()
    {
        session_unset($_SESSION['user']);
        session_destroy();
        header('location: index.php');
    }

?>