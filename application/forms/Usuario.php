<?php

class Application_Form_Usuario extends Zend_Form
{

	protected $_usuario;

	public function __construct($usuario = array())
	{
		// Verifica o parâmetro passado e monta o array $_arrCampos
		if ($usuario instanceof Application_Model_Usuario) {
			$this->_usuario = $usuario;
		}
		else if (is_array($usuario)) {
			$this->_usuario = new Application_Model_Usuario($usuario);
		}
		else throw new Exception('Parâmetro inválido passado para o construtor de Application_Form_Usuario.');
		
		// Chama o construtor da classe pai
		parent::__construct();
	}

    public function init()
    {
        $this->setMethod('post');
		
		// Se estiver no modo de edição, diciona o elemento id
		$edicao = !!$this->usuário->getId();
		
		if ($edicao) {
			$this->addElement('text', 'id', array(
					'label'    => 'ID do Usuário:',
					'value'    => $this->_usuario->getId(),
					'readonly' => 'readonly'
			));
		}

		// Adiciona o campo de nome do usuario
        $this->addElement('text', 'nome', array(
			'label'      => 'Nome do usuario:',
			'required'   => true,
			'filters'    => array('StringTrim'),
			'validators' => array(
				array('validator' => 'StringLength', 'options' => array(5, 250))
			),
			'value'    => $this->_usuario->getNome()
        ));

        // Adiciona o elemento preço
		$this->addElement('text', 'preco', array(
			'label'      => 'Preço:',
			'required'   => true,
			'validators' => array(
				array('validator' => 'Float', 'options' => array('locale' => 'br'))
			),
			'value'    => $this->_usuario->getPreco()
        ));

        // Adiciona o elemento estoque
		$this->addElement('text', 'estoque', array(
 			'label'      => 'Quantidade em estoque:',
			'required'   => true,
			'validators' => array(
				array('validator' => 'GreaterThan', 'options' => array('min' => 0))
			),
			'value'    => $this->_usuario->getEstoque()
        ));

		// Adiciona o elemento criticidade
		$this->addElement('text', 'criticidade', array(
            'label'      => 'Nível crítico:',
			'required'   => true,
			'validators' => array(
				array('validator' => 'GreaterThan', 'options' => array('min' => 0))
			),
			'value'    => $this->_usuario->getCriticidade()
		));

		// Adiciona o elemento fornecedor
		$this->addElement('text', 'fornecedor', array(
            'label'      => 'Fornecedor:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(5, 250))
            ),
			'value'    => $this->_usuario->getFornecedor()
		));

        // Adiciona o botão de envio
		$this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => ($edicao ? 'Salvar alterações' : 'Cadastrar usuario'),
		));

        // Proteção CSRF
		$this->addElement('hash', 'csrf', array(
			'ignore' => true,
		));
    }
}

