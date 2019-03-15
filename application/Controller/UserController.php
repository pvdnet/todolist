<?php 

namespace Mini\Controller;

use Mini\Core\Controller;
use Mini\Libs\Auth;
use Mini\Libs\Session;

class UserController extends Controller {
	public $user;
	public function __construct() {
		parent::__construct();
		//Anything user-related is login only.
		Auth::handleLogin();

		//Auto make user variables from session. To use in the view.

		$userSession = Session::get('user');

		$this->user = new \stdClass;
		$this->user->id = $userSession['id'];
		$this->user->name = $userSession['name'];
		$this->user->email = $userSession['email'];
		$this->user->accountType = $userSession['account_type'];
		$this->user->creationDate = date('d-M-Y', $userSession['creation_time']);
	}

	public function index() {

		$this->render('user/index');
	}

	public function league() {
		$this->render('user/league');
	}

	public function getInfo() {
		$user = Session::get('user');

		return $user;
	}
}