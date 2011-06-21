<?php

class Application_Model_Usuario
{
	protected $_id;
	protected $_nomeUsuario;
	protected $_nome;
	protected $_senha;
	protected $_insercao;
	protected $_ultimaAtividade;
	protected $_dataNascimento;
	
	public function __construct(array $dados = array())
	{
		$metodos = get_class_methods($this);
		
		foreach ($dados as $key => $value) {
		    $metodo = 'set' . ucfirst($key);
		    if (in_array($metodo, $metodos)) {
		        $this->$metodo($value);
		    }
		}
		return $this;
	}
	
	public function getId()
	{
		return $this->_id;
	}
	
	public function setId($id)
	{
		$this->_id = $id;
		return $this;
	}
	public function getNomeUsuario()
	{
		return $this->_nomeUsuario;
	}
	
	public function setNomeUsuario($nomeUsuario)
	{
		$this->_nomeUsuario = $nomeUsuario;
		return $this;
	}
	public function getNome()
	{
		return $this->_nome;
	}
	
	public function setNome($nome)
	{
		$this->_nome = $nome;
		return $this;
	}
	public function getSenha()
	{
		return $this->_senha;
	}
	
	public function setSenha($senha)
	{
		$this->_senha = $senha;
		return $this;
	}
	public function getInsercao()
	{
		return $this->_insercao;
	}
	
	public function setInsercao($insercao)
	{
		$this->_insercao = $insercao;
		return $this;
	}
	public function getUltimaAtividade()
	{
		return $this->_ultimaAtividade;
	}
	
	public function setUltimaAtividade()
	{
		$this->_ultimaAtividade = $ultimaAtividade;
		return $this;
	}
	public function getDataNascimento()
	{
		return $this->_dataNascimento;
	}
	
	public function setDataNascimento($dataNascimento)
	{
		$this->_dataNascimento = $dataNascimento;
		return $this;
	}
}

