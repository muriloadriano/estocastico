<?php

class Application_Form_Produtos extends Zend_Form
{
	protected $_produto;
	
	public function __construct($produto = array())
	{			
		// Verifica se o parâmetro passado é válido
		if ($produto instanceof Application_Model_Produto) {
			$this->_produto = $produto;
		}
		else if (is_array($produto)) {
			$this->_produto = new Application_Model_Produto($produto);
		}
		else throw new Exception('Parâmetro inválido passado para o construtor de Application_Form_Produtos.');
		
		// Chama o construtor da classe pai
		parent::__construct();
	}
	
	public function init()
	{
		$this->setMethod('post');
		
		// Se estiver no modo de edição, diciona o elemento id
		$edicao = !!$this->_produto->getId();
		
		if ($edicao) {
			$this->addElement('text', 'id', array(
					'label'    => 'ID do Produto:',
					'value'    => $this->_produto->getId(),
					'readonly' => 'readonly'
			));
		}

		// Adiciona o campo de nome do produto
        $this->addElement('text', 'nome', array(
			'label'      => 'Nome do Produto:',
			'required'   => true,
			'filters'    => array('StringTrim'),
			'validators' => array(
				array('validator' => 'StringLength', 'options' => array(5, 250))
			),
			'value'    => $this->_produto->getNome()
        ));

        // Adiciona o elemento preço
		$this->addElement('text', 'preco', array(
			'label'      => 'Preço:',
			'required'   => true,
			'validators' => array(
				array('validator' => 'Float', 'options' => array('locale' => 'pt-BR'))
			),
			'value'    => $this->_produto->getPreco()
        ));

        // Adiciona o elemento estoque
		$this->addElement('text', 'estoque', array(
 			'label'      => 'Quantidade em estoque:',
			'required'   => true,
			'validators' => array(
				array('validator' => 'GreaterThan', 'options' => array('min' => 0))
			),
			'value'    => $this->_produto->getEstoque()
        ));

		// Adiciona o elemento criticidade
		$this->addElement('text', 'criticidade', array(
            'label'      => 'Nível crítico:',
			'required'   => true,
			'validators' => array(
				array('validator' => 'GreaterThan', 'options' => array('min' => 0))
			),
			'value'    => $this->_produto->getCriticidade()
		));

		// Adiciona o elemento fornecedor
		$this->addElement('text', 'fornecedor', array(
            'label'      => 'Fornecedor:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(5, 250))
            ),
			'value'    => $this->_produto->getFornecedor()
		));

        // Adiciona o botão de envio
		$this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => ($edicao ? 'Salvar alterações' : 'Cadastrar produto'),
		));

        // Proteção CSRF
		$this->addElement('hash', 'csrf', array(
			'ignore' => true,
		));
	}

}

