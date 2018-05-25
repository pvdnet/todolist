<?php 

namespace Mini\Libs;

class Auth {
	public static function handleLogin($adminCheck = false) {
		Session::init();

		if(!isset($_SESSION['logged_in'])) {
			Session::destroy();
			header('location: ' . URL);
			exit();
		} elseif (!isset($_SESSION['user']['account_type']) OR $_SESSION['user']['account_type'] != 1 AND $adminCheck == true) {
			header('location: ' . URL);
			exit();
		}
	}
}