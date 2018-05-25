<div class="container">
	
	<?php $this->renderFeedbackMessages(); ?>

	<div class="login-page-box">
		<div class="table-wrapper">
			<div class="login-box">
				<h2>Login</h2>
	            <form action="<?php echo URL; ?>login/login" method="post">
	                <input type="text" name="user_name" placeholder="Username or email" tabindex="1" required />
	                <input type="password" name="user_password" placeholder="Password" tabindex="2" required />
                    <!--<input type="checkbox" name="set_remember_me_cookie" id="remember-me-checkbox" tabindex="3" />
                    <label for="remember-me-checkbox">Remember me for 2 weeks</label> -->
	                <input type="submit" class="login-submit-button" value="Log in" tabindex="4" />
	            </form>


	            <div class="link-forgot-my-password">
	                <a href="<?php echo URL; ?>login/requestPasswordReset">I forgot my password</a>
	            </div>
			</div>
			<div class="register-box"> 
				<h2>Register a new account</h2>

				<form method="post" action="<?php echo URL; ?>login/registerNewUser">
					<input type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" placeholder="Username (letters/numbers, 2-64 chars)" required />
					<input type="email" name="user_email" placeholder="Email address" required />
					<input type="password" name="user_password" pattern=".{6,}" placeholder="Password (6+ chars)" autocomplete="off" required />
					<input type="password" name="user_password_repeat" pattern=".{6,}" placeholder="Repeat password" autocomplete="off" required />

					<input type="submit" value="Register" />
				</form>
			</div>	
		</div>
	</div>

</div>