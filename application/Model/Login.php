<?php 

/**
 *
 * Class Login
 * 
**/

namespace Mini\Model;

use Mini\Core\Model;
use Mini\Libs\Session;

class Login extends Model {

	public function login() {
		//Check is username is filled in.
		if(!isset($_POST['user_name']) OR empty($_POST['user_name'])) {
			$_SESSION['feedback_negative'][] = FEEDBACK_EMPTY_USERNAME;
			return false;
		}

		//Check if password is filled in.
		if(!isset($_POST['user_password']) OR empty($_POST['user_password'])) {
			$_SESSION['feedback_negative'][] = FEEDBACK_EMPTY_PASSWORD;
			return false;
		}

		//The query 
		$sql = '	SELECT 	u.id, u.name, u.password_hash, u.email, ur.name as account_type, u.creation_timestamp, u.failed_logins, u.last_failed_login
					FROM 	users as u
					INNER JOIN user_roles as ur
					ON u.account_type = ur.id
					WHERE 	(u.name = :user_name OR u.email = :user_name)';

		//Prepare sql
		$query = $this->db->prepare($sql);

		//Give the parameters a value
		$parameters = array(':user_name' => $_POST['user_name']);

		//Execute sql after giving parameters a value
		$query->execute($parameters);
		
		//Count results to see if there is a match. Name and email are unique so we need just 1 match.
		$count = $query->rowCount();

		//If statement to check if $count equals 1. If it doesn't, there is no match and thus no account.
		if($count != 1) {
			$_SESSION['feedback_negative'][] = FEEDBACK_LOGIN_FAILED;
			return false;
		}

		//If we get to here we have 1 match and now we can do something with the information. Like validate it.
		$user = $query->fetch();

		//Check if user has logged in with a wrong password 3 or more times and whether last attempt was less than 30 min ago.
		if(($user->failed_logins >= 3) AND ($user->last_failed_login > (time()-30))) {
			$_SESSION['feedback_negative'][] = FEEDBACK_WRONG_PASSWORD_3;
			return false;
		}

		//Verify password
		if(password_verify($_POST['user_password'], $user->password_hash)) {
			//User's password is correct!

			//Check if the user is active. NOT YET NEEDED
			// if($user->active != 1) {
			// 	$_SESSION['feedback_negative'][] = FEEDBACK_ACCOUNT_NOT_ACTIVATED;
			// 	return false;
			// }

			//User is active, write user data into session.
			$userdata = array();
			$userdata['id'] 			= $user->id;
			$userdata['name']			= $user->name;
			$userdata['email']			= $user->email;
			$userdata['account_type']	= $user->account_type;
			$userdata['creation_time']	= $user->creation_timestamp;

			Session::init();
			Session::set('logged_in', true);
			Session::set('user', $userdata);

			//Reset failed login counter
			if($user->last_failed_login > 0) {
				$sql = '	UPDATE 	users 
							SET 	failed_logins = 0,
									last_failed_login = NULL 
							WHERE 	id = :user_id
							AND 	failed_logins != 0';

				$query = $this->db->prepare($sql);
				$parameters = array(':user_id' => $_POST['user_name']);
				$query->execute($parameters);
			}

			//Generate timestamp for last login date
			$last_login_timestamp = time();
			//Update database with last login date
			$sql = '	UPDATE 	users 
						SET 	last_login_timestamp = :last_login_timestamp 
						WHERE 	id = :user_id';

			$query = $this->db->prepare($sql);
			$parameters = array(	':user_id' => $user->id,
									':last_login_timestamp' => $last_login_timestamp);
			$query->execute($parameters);

			// //If user checks 'remember me' checkbox
			// if(isset($_POST['set_remember_me_cookie'])) {
			// 	//Generate 64 char string
			// 	$char_string = hash('sha256', mt_rand());

			// 	//Write the string into the database
			// 	$sql = '	UPDATE 	users 
			// 				SET 	rememberme_token = :rememberme_token 
			// 				WHERE 	id = :user_id';

			// 	$query = $this->db->prepare($sql);
			// 	$parameters = array(	':user_id' => $user->id,
			// 							':rememberme_token' => $char_string);
			// 	$query->execute($parameters);

			// 	//Generate cookie string that conssists of user id, char_string and combined hash of both.
			// 	$cookie_first_part = $user->id . ':' . $char_string;
			// 	$cookie_hash = hash('sha256', $cookie_first_part);
			// 	$cookie = $cookie_first_part . ':' . $cookie_hash;

			// 	//Set cookie
			// 	setcookie('rememberme', $cookie, time() + COOKIE_RUNTIME, '/', COOKIE_DOMAIN);

			// }

			//Login was succesfull so return true.
			return true;
		} else {
			//Login failed. Password does not match. Increase login counter for supplied username
			$sql = '	UPDATE	users 
						SET 	failed_logins = failed_logins+1,
								last_failed_login = :last_failed_login
						WHERE 	name = :user_name
						OR 		email = :user_name ';

			$query = $this->db->prepare($sql);
			$parameters = array(	':user_name' => $_POST['user_name'],
									':last_failed_login' => time());
			$query->execute($parameters);

			$_SESSION['feedback_negative'][] = FEEDBACK_LOGIN_FAILED;
			return false;
		}

		//Default return
		return false;
	}

	public function logout() {
		// set the remember-me-cookie to ten years ago (3600sec * 365 days * 10).
        setcookie('rememberme', false, time() - (3600 * 3650), '/', COOKIE_DOMAIN);

        // delete the session
        Session::destroy();
	}

	public function register() {
		//Go through checks to see if the form is actually filled out. HTML5 should have done this, but you never know.
		if(empty($_POST['user_name'])) {
			$_SESSION['feedback_negative'][] = FEEDBACK_REG_EMPTY_USERNAME;
		} elseif(strlen($_POST['user_name']) < 2 OR strlen($_POST['user_name']) > 64) {
			$_SESSION['feedback_negative'][] = FEEDBACK_REG_USERNAME_LONG_SHORT;
		} elseif(!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
			$_SESSION['feedback_negative'][] = FEEDBACK_REG_USERNAME_PATTERN;
		} elseif(empty($_POST['user_email'])) {
			$_SESSION['feedback_negative'][] = FEEDBACK_REG_EMPTY_EMAIL;
		} elseif(strlen($_POST['user_email']) > 64) {
			$_SESSION['feedback_negative'][] = FEEDBACK_REG_EMAIL_LONG;
		} elseif(!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['feedback_negative'][] = FEEDBACK_REG_EMAIL_PATTERN;
		} elseif(empty($_POST['user_password']) OR empty($_POST['user_password_repeat'])) {
			$_SESSION['feedback_negative'][] = FEEDBACK_REG_EMPTY_PASSWORD;
		} elseif(strlen($_POST['user_password']) < 6) {
			$_SESSION['feedback_negative'][] = FEEDBACK_REG_PASSWORD_SHORT;
		} elseif($_POST['user_password'] !== $_POST['user_password_repeat']) {
			$_SESSION['feedback_negative'][] = FEEDBACK_REG_REPEAT_WRONG;
		} elseif(	!empty($_POST['user_name'])
			AND 	strlen($_POST['user_name']) <= 64
			AND 	strlen($_POST['user_name']) >= 2 
			AND 	preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
			AND 	!empty($_POST['user_email'])
			AND 	strlen($_POST['user_email']) <= 64
			AND 	filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
			AND 	!empty($_POST['user_password'])
			AND 	!empty($_POST['user_password_repeat'])
			AND 	($_POST['user_password'] === $_POST['user_password_repeat'])) {

			$user_name = strip_tags($_POST['user_name']);
			$user_email = strip_tags($_POST['user_email']);

			$hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
			$user_password_hash = password_hash($_POST['user_password'], PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

			$sql = ' 	SELECT *
						FROM users 
						WHERE name = :user_name';
			$query = $this->db->prepare($sql);
			$parameters = array(':user_name' => $_POST['user_name']);
			$query->execute($parameters);

			$count = $query->rowCount();
			
			if($count == 1) {
				//Username already exists.
				$_SESSION['feedback_negative'][] = FEEDBACK_REG_TAKEN_USERNAME;
				return false;
			}

			$sql = 	'	SELECT *
						FROM users 
						WHERE email = :user_email';
			$query = $this->db->prepare($sql);
			$parameters = array(':user_email' => $_POST['user_email']);
			$query->execute($parameters);

			$count = $query->rowCount();

			if($count == 1) {
				//Email already exists.
				$_SESSION['feedback_negative'][] = FEEDBACK_REG_TAKEN_EMAIL;
				return false;
			}

			//User does not already exist. Time to add him to the database.
			$user_activation_hash = sha1(uniqid(mt_rand(), true));
			$user_creation_timestamp = time();

			$sql = '	INSERT INTO users (
										name,
										password_hash,
										email,
										creation_timestamp,
										activation_hash)
						VALUES 		(	:user_name,
										:password_hash,
										:email,
										:creation_timestamp,
										:activation_hash)';

			$query = $this->db->prepare($sql);
			$parameters = array(	':user_name' => $user_name,
									':password_hash' => $user_password_hash,
									':email' => $user_email,
									':creation_timestamp' => $user_creation_timestamp,
									':activation_hash' => $user_activation_hash);
			$query->execute($parameters);

			$count = $query->rowCount();
			if($count != 1) {
				//Something went wrong.Try again
				$_SESSION['feedback_negative'][] = FEEDBACK_REG_CREATION_FAILED;
				return false;
			}

			$sql = '	SELECT id 
						FROM users 
						WHERE name = :user_name';
			$query = $this->db->prepare($sql);
			$parameters = array(':user_name' => $user_name);
			$query->execute($parameters);

			$count = $query->rowCount();
			if($count != 1) {
				//Something went wrong. idk what
				$_SESSION['feedback_negative'][] = FEEDBACK_UNKNOWN_ERROR;
				return false;
			}

			$user = $query->fetch();
			$user_id = $user->id;

			//if($this->sendVerificationEmail($user_id, $user_email, $user_activation_hash)) {
				//Success! Acocunt has been made and email has been sent.
				$_SESSION['feedback_positive'][] = FEEDBACK_REG_CREATION_SUCCESS;
				return true;
			// } else {
			// 	//Delete last inserted id so user won't get a problem when registering again with the same username/email.
			// 	$sql = '	DELETE FROM users 
			// 				WHERE id = :last_inserted_id';
			// 	$query = $this->db->prepare($sql);
			// 	$parameters = array(':last_inserted_id' => $user_id);
			// 	$query->execute($parameters);

			// 	$_SESSION['feedback_negative'][] = FEEDBACK_REG_VERIFY_EMAIL_SEND_FAILED;
			// 	return false;
			// }

		}
	}
}