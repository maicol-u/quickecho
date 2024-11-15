<?php
use Models\UsuariosModel;
use Http\Request;
use Http\Response;

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UsuariosModel();
    }

    public function getUsers() {
        $users = $this->userModel->readAll();
        Response::success($users);
    }

}