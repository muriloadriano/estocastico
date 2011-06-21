<?php

class LoginController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
		$formulario = $this->getFormulario();
		$formulario->setAction('/login/processar');
		
		if ($this->getRequest()->getParam('erro') == 'invalido') {
			$formulario->setDescription('Usuário e/ou senha inválido(s).');
		}
		
		$this->view->formulario = $formulario;
    }

    public function preDispatch()
    {
		if (Zend_Auth::getInstance()->hasIdentity()) {
			if ($this->getRequest()->getActionName() != 'logout') {
				$this->_helper->redirector('index');
			}
		}
		else {
			if ($this->getRequest()->getActionName() == 'logout') {
				$this->getHelper()->redirector('index');
			}
		}
		
    }

    public function getFormulario()
    {
		return new Application_Form_Login(array(
			'action' => 'login/processar',
			'method' => 'post'
		));
    }

    public function getAutenticador(array $parametros)
    {
		$autenticador = new AutenticadorAdapter($parametros['nomeUsuario'], 
			$parametros['senha']);
		
		return $autenticador;
    }

    public function processarAction()
    {
        $request = $this->getRequest();

		if (!$request->isPost()) {
			return $this->_helper->redirector('index');
		}
		
		$formulario = $this->getFormulario();
		
		if (!$formulario->isValid($request->getPost())) {
			$this->view->formulario = $formulario;
			return $this->render('index');
		}
	
		$adaptador = $this->getAutenticador($formulario->getValues());
		$autenticador = Zend_Auth::getInstance();
		
		$resultado = $autenticador->authenticate($adaptador);
		
		// Verifica se a autenticação falhou
		if (!$resultado->isValid()) {
			return $this->_helper->getHelper('Redirector')->
				gotoUrl('/login/index/erro/invalido/');
		}
		
		// A autenticação foi feita, redireciona pra página inicial
		return $this->_helper->redirector('index', 'index');
    }

	public function logoutAction()
	{
		Zend_Auth::getInstance()->clearIdentity();
		
		// Volta pra página inicial
		$this->_helper->redirector('index', 'index');
	}
}

class AutenticadorAdapter implements Zend_Auth_Adapter_Interface
{
	protected $_usuario;
	protected $_senha;
	
	public function __construct($usuario, $senha)
	{
		$this->_usuario = $usuario;
		$this->_senha   = $senha;
	}
	
	public function authenticate()
	{
		$mapperUsuario = new Application_Model_UsuarioMapper();
		if ($mapperUsuario->checarUsuarioSenha($this->_usuario, 
			$this->_senha)) {
				
				return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS,
					$this->_usuario, array());
		}
		
		return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
			null, array());
	}
}



