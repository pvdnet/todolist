<?php

/**
 * Class ChecklistController
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */

namespace Mini\Controller;

use Mini\Core\Controller;
use Mini\Model\Checklist;
use Mini\Libs\Auth;
use Mini\Libs\Session;


class ChecklistController extends Controller {
    private $list;
    private $userInfo;
    public $lists;
    public $singleList;
    public $singleListTasks;
    public $singleListCreator;
    public function __construct() {
        parent::__construct();

        Auth::handleLogin();

        $this->list = new Checklist();
        $this->userInfo = Session::get('user');
    }

    public function index() {
        $this->lists = $this->list->getAllLists();

        $this->render('checklist/index');
    }

    public function create() {
        $addedList = $this->list->addList($this->userInfo['id'], $_POST['list_name']);

        header('location: ' . URL . 'checklist');
    }

    public function view($listId) {
        if(isset($listId)):

            $this->singleList = $this->list->getList($listId);

            if($this->singleList == '' || $this->singleList == null):
                $_SESSION['feedback_negative'][] = 'This list no longer exists.';
                header('location: ' . URL . 'checklist');
            else:
                $this->singleListTasks = $this->list->getTasksByList($listId);
                $this->singleListCreator = $this->list->getUserByList($this->singleList->user_id);
                $this->render('checklist/view');
            endif;
        else:
            header('location: ' . URL . 'checklist');
        endif;
    }

    public function edit($listId) {
        if(isset($listId)):
            $this->list->updateList($listId, $_POST['list_name']);
            $this->list->lastEditList($listId);
            $_SESSION['feedback_positive'][] = 'Name edited.';
            header('location: ' . URL . 'checklist/view/' . $listId);
        else:
            header('location: ' . URL . 'checklist');
        endif;
    }

    public function delete($listId) {
        if(isset($listId)):
            $this->list->deleteList($listId);
            $_SESSION['feedback_positive'][] = 'List removed succesfully';
            header('location: ' . URL . 'checklist');
        else:
            header('location: ' . URL . 'checklist');
        endif;
    }

    public function addTask($listId) {
        if($listId):
            $this->list->addTask($listId, $this->userInfo['id'], $_POST['task_name'], $_POST['task_description'], $_POST['task_duration']);
            $this->list->lastEditList($listId);
            $_SESSION['feedback_positive'][] = 'New task added';
        else:
            $_SESSION['feedback_negative'][] = 'Failed to add task';
        endif;
        header('location: ' . URL . 'checklist/view/' . $listId);
    }

    public function task($taskId) {

    }
}