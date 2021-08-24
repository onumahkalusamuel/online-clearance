<?php
//FOR LOGIN
if(isset($_POST['login'])){
	$uName = $_POST['username'];
	$pWord = md5($_POST['password']);

	if( ! preg_match( "/^[a-zA-Z0-9]+[a-zA-Z0-9]{5}$/", $uName ) ){
		$uName = FALSE;
	}

	if( ! $uName ) {
		$login['error'] = "Username/Password Incorrect";
	} else {
		include_once("db.con.php");
		$query = "SELECT * FROM users WHERE username = '$uName' AND password = '$pWord' LIMIT 1;";
		$run = mysqli_query($con, $query);
		$result = mysqli_fetch_assoc($run);

		if ( mysqli_num_rows($run) == 1 ) {
			session_start();
			$_SESSION['user_id'] = $result['id'];
			$_SESSION['name'] = $result['name'];
			$a = $_SESSION['user_type'] = $result['user_type'];
                        if($result['user_type'] == "student") {
                            $_SESSION['regno'] = $result['reg_no'];
                        }
			
			header("Location: ".str_ireplace(" ", "", $a).".php");

		} else {
			
			$login['error'] = "Username/Password Incorrect";
		}
	}
}

//FOR PASSWORD RESET
if(isset($_POST['reset'])) {
}

include_once("main.template.php");

myheader("Welcome");
?>
<style type="text/css">
	.form {border: 1px solid black;
			padding: 40px 30px;
			box-shadow: 5px 5px rgba(100,100,100,0.8);
			border-radius: 20px 0px;
		}
		.links{
			color: rgb(50,50,200);
			cursor: pointer;
		}
		.links:hover {
			color: rgb(40,40,200);
			cursor: pointer;
			font-weight: bold;
		}
</style>
<div class="container">
	<div class="row col-sm-6 col-sm-offset-3">
		<div class="login form">
			<h2>Login</h2>
			<hr />
			<form class="login" method="post">
				<div class="form-group">
				<label class="" for="username">Username</label>
					<input type="text" class="form-control" name="username" placeholder="Username"  value="<?php if(isset($_POST['username'])){ echo $_POST['username'];}?>" required />
				</div>
				<div class="form-group">
				<label class="" for="username">Password</label>
					<input type="password" class="form-control" name="password" placeholder="Password" required />
				</div>
                            <div class="form-group">
                                    <label>
                                        <input name="remember" type="checkbox" checked value="remember">&nbsp;&nbsp;Remember Me
                                    </label>
                                </div>
				<div class="form-group">
					<input class="btn btn-success" name="login" type="submit" value="Login" />
					<span class="pull-right">
						Forgot Password? <span class="links" id="reset">Click here...</span>
					</span>
				</div>
				<?php
				if(isset($login['error']) && !empty($login['error'])):
					message($login['error']);
				endif;?>
			</form>
		</div>
		<div class="reset form" style="display:none;">
			<h2>Reset Password</h2>
			<hr />
			<form class="login" method="post">
				<div class="form-group">
				<label class="" for="resetdata">Username or Registered Email</label>
					<input type="email" class="form-control" name="resetdata" required />
				</div>
				<div class="form-group" style="display:inline;">
					<input class="pull-right btn btn-danger" name="reset" type="submit" value="Request Reset" />
				</div>
				<div class="" style="display:inline;">
					<span class="links" id="login">Login here...</span>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".links").on("click", function(){
			var main = $(this).attr('id');
			$(".form").hide(500, function(){
				$("."+main).show(500);
			});
		});
	});
</script>
<?php myfooter(); ?>
