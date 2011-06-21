<?php

class UsuarioController extends Zend_Controller_Action
{

    private $_erros;

    public function init()
    {
		$this->_erros['usuarioExistente'] = 'Já existe um usuário com o login ';
    }

    public function indexAction()
    {
		$usuariosMapper = new Application_Model_UsuarioMapper();
		$this->view->usuarios = $usuariosMapper->obterTodos();
    }

    public function adicionarAction()
    {
        $requisicao = $this->getRequest();
		$formulario = new Application_Form_Usuario();
		
		if ($requisicao->isPost()) {
			if ($formulario->isValid($requisicao->getPost())) {
				$usuario = new Application_Model_Usuario($formulario->getValues());
				$mapper  = new Application_Model_UsuarioMapper();
				
				if ($mapper->obterPorNomeUsuario($usuario->getNomeUsuario()) != null) {
					$this->view->erro = $this->_erros['usuarioExistente'] . $usuario->getNomeUsuario() . '.';
				}
				else {
					$mapper->salvar($usuario);
					return $this->_helper->redirector('index');
				}
			}
		}
		
		$this->view->formulario = $formulario;
    }

    public function editarAction()
    {
        $idUsuario = $this->getRequest()->getParam('id');
		if (!is_numeric($idUsuario)) return $this->getHelper()->redirector('adicionar');

		$mapper = new Application_Model_UsuarioMapper();
		$usuario = $mapper->obterPorId($idUsuario);

		$requisicao = $this->getRequest();

		if (!$requisicao->isPost()) {
			if ($usuario == null) return $this->getHelper()->redirector('adicionar');

			$this->view->formulario = new Application_Form_Usuario($usuario);
		}
		else {
			if ($usuario == null) $usuario = array();

			$formulario = new Application_Form_Usuario($usuario);

			if ($formulario->isValid($requisicao->getPost())) {
				$usuario = new Application_Model_Usuario($formulario->getValues());
				$mapper  = new Application_Model_UsuarioMapper();
				
				if ($mapper->obterPorNomeUsuario($usuario->getNomeUsuario()) != null) {
					$this->view->erro = $this->_erros['usuarioExistente'] . $usuario->getNomeUsuario() . '.';
				}
				else {
					$mapper->salvar($usuario);
					return $this->_helper->redirector('index');
				}
			}
		}
		
		$this->view->formulario = $formulario;
    }
	
	public function excluirAction()
    {
        $idUsuario = $this->getRequest()->getParam('id');
		if (!is_numeric($idUsuario)) return $this->_helper->redirector('index');
    
		$mapper = new Application_Model_UsuarioMapper();
		$usuario = $mapper->obterPorId($idUsuario);
		
		if ($usuario == null) return $this->_helper->redirector('index');
		
		$opcao = $this->getRequest()->getParam('opcao');
		
		if (!empty($opcao)) {
			if ($opcao == 'sim') {
				$mapper->excluir($idUsuario);
			}
			return $this->_helper->redirector('index');
		}
		
		$this->view->usuario = $usuario;
	}

}







