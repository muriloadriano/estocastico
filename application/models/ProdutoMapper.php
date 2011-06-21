<?php

class Application_Model_ProdutoMapper
{
	protected $_dbTable;
	
	public function setDbTable($dbTable)
	{
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Classe de Tabela de Dados inválida');
		}
		
		$this->_dbTable = $dbTable;
		return $this;
	}
	
	public function getDbTable()
	{
		if (null === $this->_dbTable) {
			$this->setDbTable('Application_Model_DbTable_Produto');
		}
		return $this->_dbTable;
	}
	
	public function salvar(Application_Model_Produto $produto)
	{
		$data = array(
			'nome'   => $produto->getNome(),
			'preco' => $produto->getPreco(),
			'criticidade' => $produto->getCriticidade(),
			'estoque' => $produto->getEstoque(),
			'fornecedor' => $produto->getFornecedor()
		);

		if (null === ($id = $produto->getId())) {
			unset($data['id']);
			$this->getDbTable()->insert($data);
		} 
		else {
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
    }
    	
    public function obterPorId($id)
   	{
   		$resultado = $this->getDbTable()->find($id);
   		
		if (count($resultado) == 0) return null;
	
		$dados = $resultado->current();
	
		$produto = new Application_Model_Produto();
	
		$produto->setId($dados->id)
		          ->setNome($dados->nome)
				  ->setPreco($dados->preco)
		          ->setCriticidade($dados->criticidade)
		          ->setEstoque($dados->estoque)
		          ->setFornecedor($dados->fornecedor);
		
		return $produto;
	}
   	
	public function obterTodos()
	{
	    $conjDados = $this->getDbTable()->fetchAll();
		$produtos   = array();

		foreach ($conjDados as $dado) {
		    $produto = new Application_Model_Produto(array());
		    $produto->setId($dado->id)
		          ->setNome($dado->nome)
		          ->setPreco($dado->preco)
		          ->setCriticidade($dado->criticidade)
		          ->setEstoque($dado->estoque)
		          ->setFornecedor($dado->fornecedor);
	          
		    $produtos[] = $produto;
		}
		return $produtos;
	}
}







