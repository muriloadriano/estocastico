<?php

class Application_Model_UsuarioMapper
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
			$this->setDbTable('Application_Model_DbTable_Usuario');
		}
		return $this->_dbTable;
	}
	
	public function salvar(Application_Model_Usuario $produto)
	{
		$dados = array(
			'nomeUsuario'   => $produto->getNomeUsuario(),
			'nome'   => $produto->getNome(),
			'senha' => $produto->getSenha(),
			'insercao' => $produto->getInsercao(),
			'ultimaAtividade' => $produto->getUltimaAtividade(),
			'dataNascimento' => $produto->getDataNascimento()
		);

		if (null === ($id = $produto->getId())) {
			unset($dados['id']);
			$dados['insercao'] = date('Y-m-d H:i:s');
			$dados['ultimaAtividade'] = date('Y-m-d H:i:s');
			
			$this->getDbTable()->insert($dados);
		} 
		else {
			$this->getDbTable()->update($dados, array('id = ?' => $id));
		}
    }
    	
    public function obterPorId($id)
   	{
   		$resultado = $this->getDbTable()->find($id);
   		
		if (count($resultado) == 0) return null;
	
		$dados = $resultado->current();
	
		$usuario = new Application_Model_Usuario();
	
		$usuario->setId($dados->id)
			->setNomeUsuario($dados->nomeUsuario)
			->setNome($dados->nome)
			->setSenha($dados->senha)
			->setInsercao($dados->insercao)
			->setUltimaAtividade($dados->ultimaAtividade)
			->setDataNascimento($dados->dataNascimento);
		
		return $usuario;
	}
	
	public function obterPorNomeUsuario($nomeUsuario)
	{
		$tabela = $this->getDbTable();
		
		$select = $tabela->select();
		$select->where('nomeUsuario = ?', $nomeUsuario);

   		$resultado = $tabela->fetchAll($select);

		if (count($resultado) == 0) return null;
	
		$dados = $resultado->current();
	
		$usuario = new Application_Model_Usuario();
	
		$usuario->setId($dados->id)
			->setNomeUsuario($dados->nomeUsuario)
			->setNome($dados->nome)
			->setSenha($dados->senha)
			->setInsercao($dados->insercao)
			->setUltimaAtividade($dados->ultimaAtividade)
			->setDataNascimento($dados->dataNascimento);
		
		return $usuario;
	}
   	
	public function obterTodos()
	{
		$conjDados  = $this->getDbTable()->fetchAll();
		$usuarios   = array();

		foreach ($conjDados as $dado) {
			$usuario = new Application_Model_Usuario();
			$usuario->setId($dado->id)
				->setNomeUsuario($dado->nomeUsuario)
				->setNome($dado->nome)
				->setSenha($dado->senha)
				->setInsercao($dado->insercao)
				->setUltimaAtividade($dado->ultimaAtividade)
				->setDataNascimento($dado->dataNascimento);
				
			$usuarios[] = $usuario;
		}
		return $usuarios;
	}
	
	public function excluir($id)
	{
		$tabela = $this->getDbTable();
		$where = $tabela->getAdapter()->quoteInto('id = ?', $id);
		$tabela->delete($where);
	}

}

