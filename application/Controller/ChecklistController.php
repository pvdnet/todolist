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

        header('location: ' . URL . 'checklist/index');
    }

    public function view($listId) {
        if(isset($listId)):

            $this->singleList = $this->list->getList($listId);

            if($this->singleList == '' || $this->singleList == null):
                $_SESSION['feedback_negative'][] = 'This list no longer exists.';
                header('location: ' . URL . 'checklist/index');
            else:
                $this->singleListCreator = $this->list->getUserByList($this->singleList->user_id);
                $this->render('checklist/view');
            endif;
        else:
            header('location: ' . URL . 'checklist/index');
        endif;
    }

    public function edit($listId) {
        if(isset($listId)):
            $this->list->updateList($listId, $_POST['list_name']);
            header('location: ' . URL . 'checklist/view/' . $listId);
        else:
            header('location: ' . URL . 'checklist/index');
        endif;
    }

    public function delete($listId) {
        if(isset($listId)):
            $this->list->deleteList($listId);
            $_SESSION['feedback_positive'][] = 'List removed succesfully';
            header('location: ' . URL . 'checklist/index');
        else:
            header('location: ' . URL . 'checklist/index');
        endif;
    }
}