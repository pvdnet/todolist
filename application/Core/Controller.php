<?php 

namespace Mini\Core;

use Mini\Libs\Session;

class Controller {

	public function __construct() {
		Session::init();
	}

	public function render($filename) {
		require VIEW . '_templates/header.php';
		require VIEW . $filename . '.php';
		require VIEW . '_templates/footer.php';
	}

	public function renderFeedbackMessages() {
		$feedback_positive = Session::get('feedback_positive');
		$feedback_negative = Session::get('feedback_negative');

		if (isset($feedback_positive)) {
			foreach ($feedback_positive as $feedback) {
				echo '<div class="feedback success">'.$feedback.'</div>';
			}
		}

		if (isset($feedback_negative)) {
			foreach ($feedback_negative as $feedback) {
				echo '<div class="feedback error">'.$feedback.'</div>';
			}
		}

		Session::set('feedback_positive', null);
		Session::set('feedback_negative', null);
	}

	public function loggedIn() {
		if(Session::get('logged_in') == true) {
			return true;
		} else {
			return false;
		}
	}

	public function showSession() {
		echo '<pre>';
		print_r($_SESSION);
		echo '</pre>';
	}
}