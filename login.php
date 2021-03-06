<?php

require_once 'core/init.php';


if(Input::exists()){
	//checks if input fields are set

	if(Token::check(Input::get('token'))){
		/*checks if security token generated on the page matches the one
		being submitted*/


		//Create rules for the fields being submitted on page
		$validate = new Validate();
		$validation = $validate->check($_POST, array(

			'username' => array('required' => true),
			'password' => array('required'=> true)

			));

		if($validation->passed()){

			//log user in when validation passes

			$remember = (Input::get('remember') === 'on') ? true : false;

			$user = new User();
			$login = $user->login(Input::get('username'), Input::get('password'), $remember);

			if($login){

				//redirect to home page
				Redirect::to('index.php');

			}else{

				echo 'cant login';
			}

		}else{

			foreach ($validation->errors() as $error) {
				echo $error, '</br>';
			}
		}
	}
}

?>

<form action="" method="POST">
	
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" autocomplete="off">
	</div>
<br>
	<div class="field">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" autocomplete="off">
	</div>

	<br>

	<div class="field">
		<label for="remember">
			
			<input type="checkbox" name="remember" id="remember" autocomplete="off"> Remember Me
		</label>
		
	</div>

	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

	<input type="submit" value="Log in">
</form>

<div>
	<p>Don't have an account? </p> <a href="register.php">Create New Account</a>
</div>
