<?php 

/**
 *
 * Class LoginController
 *
**/

namespace Mini\Controller;

use Mini\Core\Controller;
use Mini\Model\Login;

Class LoginController extends Controller {

	public function index() {

		//load view
		$this->render('login/index');
	}

	public function login() {
		//This is where we end up after filling in the login form on index.

		$login = new Login();

		$login_success = $login->login();

		if($login_success) {
			header('location: ' . URL);
		} else {
			header('location: ' . URL . 'login');
		}
	}

	public function registerNewUser() {

		$register = new Login();

		$register_success = $register->register();

		header('location: ' . URL . 'login');
	}

	public function logout() {

		$logout = new Login();

		$logout->logout();

		header('location: ' . URL);
	}
}