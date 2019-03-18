<?php 

namespace Mini\Libs;

class Auth {
	public static function handleLogin() {
		Session::init();

		if(!isset($_SESSION['logged_in'])) {
			Session::destroy();
			header('location: ' . URL);
			exit();
		}
	}
}