
<?php include('config.php'); ?>
<?php include('includes/public/head_section.php'); ?>
<?php include(ROOT_PATH . '/includes/public/registration_login.php'); ?>
<title>MyWebSite | Home </title>
 
</head>

<body>

	<div class="container">

		<!-- Navbar -->
		<?php include(ROOT_PATH . '/includes/public/navbar.php'); ?>
		<!-- // Navbar -->
       
	 
		<!-- formulaire d'inscription -->
        <form action="" method="POST">
        <h2>Register on MyWebSite</h2>
    
        <?php include(ROOT_PATH . '/includes/public/errors.php') ?>
        <input type="text" name="username"   placeholder="Username">
        <input type="email" name="email"   placeholder="Email">
        <input type="password" name="password_reg" placeholder="Password">
        <input type="password" name="passwordConf" placeholder="Password confirmation">
        <button type="btn" class="btn" name="reg_btn">Register</button>
        <p> Already a member? <a color="blue" href="login.php">Sign in</a>
        </form>
		
		<!-- // Messages -->

		<!-- content -->
		 
			 

			



		 

	</div>
	<!-- // container -->


	<!-- Footer -->
	<?php include(ROOT_PATH . '/includes/public/footer.php'); ?>
	<!-- // Footer -->

 
  
