<?php

class ProdutoController extends Zend_Controller_Action
{

    public function init()
    {
		if (!Zend_Auth::getInstance()->hasIdentity()) {
			return $this->_helper->redirector('index', 'index');
		}
		
    }

    public function indexAction()
    {
        $produtos = new Application_Model_ProdutoMapper();
        $this->view->produtos = $produtos->obterTodos();

		$this->view->criticos = $produtos->obterCriticos();
    }

    public function adicionarAction()
    {
        $requisicao = $this->getRequest();
		$formulario = new Application_Form_Produtos();
		
		if ($requisicao->isPost()) {
			if ($formulario->isValid($requisicao->getPost())) {
				$produto = new Application_Model_Produto($formulario->getValues());
				$mapper  = new Application_Model_ProdutoMapper();
				$mapper->salvar($produto);
				
				return $this->_helper->redirector('index');
			}
		}
		
		$this->view->formulario = $formulario;
    }

    public function editarAction()
    {
		$idProduto = $this->getRequest()->getParam('id');
		if (!is_numeric($idProduto)) return $this->getHelper()->redirector('adicionar');

		$mapper = new Application_Model_ProdutoMapper();
		$produto = $mapper->obterPorId($idProduto);

		$requisicao = $this->getRequest();

		if (!$requisicao->isPost()) {
			if ($produto == null) return $this->getHelper()->redirector('adicionar');

			$this->view->formulario = new Application_Form_Produtos($produto);
		}
		else {
			if ($produto == null) $produto = array();

			$formulario = new Application_Form_Produtos($produto);

			if ($formulario->isValid($requisicao->getPost())) {
				$produto = new Application_Model_Produto($formulario->getValues());
				$mapper  = new Application_Model_ProdutoMapper();
				$mapper->salvar($produto);

				return $this->_helper->redirector('index');
			}

			$this->view->formulario = $formulario;
		}
    }

    public function excluirAction()
    {
        $idProduto = $this->getRequest()->getParam('id');
		if (!is_numeric($idProduto)) return $this->_helper->redirector('index');
    
		$mapper = new Application_Model_ProdutoMapper();
		$produto = $mapper->obterPorId($idProduto);
		
		if ($produto == null) return $this->_helper->redirector('index');
		
		$opcao = $this->getRequest()->getParam('opcao');
		
		if (!empty($opcao)) {
			if ($opcao == 'sim') {
				$mapper->excluir($idProduto);
			}
			return $this->_helper->redirector('index');
		}
		
		$this->view->produto = $produto;
	}


}







