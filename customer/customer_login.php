<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<style>
		.btn-primary {
			color: #fff;
			background-color: #65CCAE;
			border-color: #65CCAE;
		}

		.card-footer text-center, a, h3 {
			color: #65CCAE;
		}
	</style>
</head>
<body>
	<div class="container mt-5">
		<div class="card">
			<div class="card-header text-center">
				<h1>Login</h1>
			</div>
			<div class="card-body">
				<form action="checkout.php" method="post">
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" name="c_email" required>
					</div>
					<div class="form-group">
						<label>Password</label>
						<div class="input-group">
							<input type="password" class="form-control" name="c_pass" id="password" required>
							<div class="input-group-append">
								<span class="input-group-text" id="togglePassword" style="cursor: pointer;">
									<i class="fa fa-eye"></i>
								</span>
							</div>
						</div>
					</div>
					<div class="text-center">
						<button name="login" value="Login" class="btn btn-primary">
							<i class="fa fa-sign-in"></i> Log in
						</button>
					</div>
				</form>
				<div class="text-center mt-3">
					<a href="forgot_pass.php">Forgot Password?</a>
				</div>
			</div>
			<div class="card-footer text-center">
				<a href="customer_register.php">
					<h3>New? Register Here</h3>
				</a>
			</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#togglePassword').click(function() {
				const password = $('#password');
				const icon = $(this).find('i');
				const isVisible = password.attr('type') === 'text';

				password.attr('type', isVisible ? 'password' : 'text');
				icon.toggleClass('fa-eye fa-eye-slash');
			});
		});
	</script>
</body>
</html>

<?php

// Pastikan koneksi database sudah dibuat
// $con = mysqli_connect("localhost", "username", "password", "database_name");

if(isset($_POST['login'])) {
	$customer_email = $_POST['c_email'];
	$customer_pass = $_POST['c_pass'];

    // Lakukan sanitasi input sebelum digunakan dalam query (hindari SQL Injection)
	$customer_email = mysqli_real_escape_string($con, $customer_email);
	$customer_pass = mysqli_real_escape_string($con, $customer_pass);

	$select_customer = "SELECT * FROM customers WHERE customer_email='$customer_email' AND customer_pass='$customer_pass'";
	$run_customer = mysqli_query($con, $select_customer);

	$get_ip = getRealUserIp();
	$check_customer = mysqli_num_rows($run_customer);

	$select_cart = "SELECT * FROM cart WHERE ip_add='$get_ip'";
	$run_cart = mysqli_query($con, $select_cart);
	$check_cart = mysqli_num_rows($run_cart);

	if($check_customer == 0) {
		echo "<script>alert('Incorrect email or password')</script>";
		exit();
	}

	if($check_customer == 1 && $check_cart == 0) {
		$_SESSION['customer_email'] = $customer_email;
		echo "<script>alert('You are Logged In')</script>";
		echo "<script>window.open('customer/my_account.php?my_orders', '_self')</script>";
	} else {
		$_SESSION['customer_email'] = $customer_email;
		echo "<script>alert('You are Logged In')</script>";
		echo "<script>window.open('checkout.php', '_self')</script>";
	} 
}
?>