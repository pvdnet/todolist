<?php

/**
 * Class TaskController
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */

namespace Mini\Controller;

use Mini\Core\Controller;
use Mini\Model\Task;
use Mini\Libs\Auth;
use Mini\Libs\Session;


class TaskController extends Controller {
    public $lists;
    public function __construct() {
        parent::__construct();

        Auth::handleLogin();
    }

    public function index() {
        $list = new Task();

        $this->lists = $list->getAllLists();

        $this->render('task/index');
    }

    public function create() {
        $list = new Task();
        $userInfo = Session::get('user');

        $addedList = $list->addList($userInfo['id'], $_POST['task_name']);
    }

    public function edit($taskId) {
        if(isset($taskId)):

        else:
            header('location: ' . URL . 'task/index');
        endif;
    }
}
