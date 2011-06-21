<?php

class UsuarioController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
		$usuariosMapper = new Application_Model_UsuarioMapper();
		$this->view->usuarios = $usuariosMapper->obterTodos();
    }
}

