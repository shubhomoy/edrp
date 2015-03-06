<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="style.css" />
		<title>EdRP</title>
		<?php
			session_start();
			session_destroy();
			//the above lines unset the SESSION if EdRP admin did not logout
		?>
	</head>
	<body>
		<div id="header">EdRP</div>
		<div id="container">
			<?php
			if(isset($_GET['login']) || (!isset($_GET['about']) && !isset($_GET['contact']))){
				// user clicks on login button
				?>
				<div class="container_body_main">
					<h3>Login</h3>
					<hr />
					<table align="left" width="70%" border="0">
						<tr><td align="left" width="20%">Username</td><td><input type="password" id="username" autocomplete="off" autofocus="autofocus" /></td></tr>
						<tr><td align="left">Password</td><td><input id="password" type="password" /></td></tr>
						<tr><td></td><td><input type="checkbox"/> Remember Me</td></tr>
						<tr><td></td><td><a href="#" class="login_btn" onclick="cls()">Login</a></td></tr>
						<tr><td></td><td><a href="#" >Forgot Password? Click Here</a></td></tr>
					</table>
				</div>
				<?php
			}else
			if(isset($_GET['about'])){
				// about page
				?>
				<div class="container_body_main">
					<h3>About</h3>
					<hr />
					Myself Shubhomoy..!! :) :)
				</div>
				<?php
			}else
			if(isset($_GET['contact'])){
				//contact us page
				?>
				<div class="container_body_main">
					<h3>Contact Us</h3>
					<hr />
					Contact me :)<br />
					Email - biswas_shubhomoy777@yahoo.com
				</div>
				<?php
			}else{
				?>
				<div class="container_body_main">
					<h3>Login</h3>
					<hr />
					<table align="left" width="70%" border="0">
						<tr><td align="left" width="20%">Username</td><td><input type="text" autocomplete="off" autofocus="autofocus" /></td></tr>
						<tr><td align="left">Password</td><td><input type="password" /></td></tr>
						<tr><td></td><td><input type="checkbox"/> Remember Me</td></tr>
						<tr><td></td><td><a href="#" class="login_btn" onclick="cls()">Login</a></td></tr>
						<tr><td></td><td><a href="#" >Forgot Password? Click Here</a></td></tr>
					</table>
				</div>
				<?php
			}
			?>
			
			<div id="container_body_link">
				<a href="index.php?login">Login</a>
				<a href="?about">About</a>
				<a href="?contact">Contact Us</a>
			</div>
		</div>
		<script type="text/javascript" src="ajax/ajax.js"></script>
		<script type="text/javascript" src="js/jquery.js"></script>
	</body>
</html>