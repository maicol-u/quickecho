<?php
namespace Models;

use Core\BaseModel;

class UsuariosModel extends BaseModel
{
    public function __construct(){
        $table = "usuarios";
        $keys = ["id_usuario"];
        parent::__construct($table, $keys);
    }

}