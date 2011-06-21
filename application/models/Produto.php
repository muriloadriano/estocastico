<?php
/**
 * Classe que representa um Produto de acordo com o diagrama da Fig A.1 do documento de projeto
 */
class Application_Model_Produto
{
	protected $_nome;
	protected $_id;
	protected $_preco;
	protected $_criticidade;
	protected $_estoque;
	protected $_fornecedor;
	
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
	
	public function getNome()
	{
		return $this->_nome;
	}
	
	public function setNome($nome)
	{
		$this->_nome = $nome;
		return $this;
	}
	
	public function getPreco()
	{
		return $this->_preco;
	}
	
	public function setPreco($preco)
	{
		$this->_preco = $preco;
		return $this;
	}
	
	public function getCriticidade()
	{
		return $this->_criticidade;
	}
	
	public function setCriticidade($criticidade)
	{
		$this->_criticidade = $criticidade;
		return $this;
	}
	
	public function getEstoque()
	{
		return $this->_estoque;
	}
	
	public function setEstoque($estoque)
	{
		$this->_estoque = $estoque;
		return $this;
	}
	
	public function getFornecedor()
	{
		return $this->_fornecedor;
	}
	
	public function setFornecedor($fornecedor)
	{
		$this->_fornecedor = $fornecedor;
		return $this;
	}
}



