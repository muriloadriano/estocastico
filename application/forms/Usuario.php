<?php

class Application_Form_Usuario extends Zend_Form
{

	protected $_usuario;

	public function __construct($usuario = array())
	{
		// Verifica se o parâmetro passado é válido
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
		$edicao = !!$this->_usuario->getId();
		
		if ($edicao) {
			$this->addElement('text', 'id', array(
					'label'    => 'ID do Usuário:',
					'value'    => $this->_usuario->getId(),
					'readonly' => 'readonly'
			));
			
			$insercao = $this->_usuario->getInsercao();
		}
		else $insercao = date('Y-m-d H:i:s');
		
		// Adiciona o campo oculto inserção
		$this->addElement('hidden', 'insercao', array('value' => $insercao));

		// Adiciona o campo de nome
        $this->addElement('text', 'nome', array(
			'label'      => 'Nome:',
			'required'   => true,
			'filters'    => array('StringTrim'),
			'validators' => array(
				array('validator' => 'StringLength', 'options' => array(5, 250))
			),
			'value'    => $this->_usuario->getNome()
        ));

        // Adiciona o elemento de nome de usuário (login)
		$this->addElement('text', 'nomeUsuario', array(
			'label'      => 'Login:',
			'required'   => true,
			'filters'    => array('StringTrim'),
			'validators' => array(
				array('validator' => 'StringLength', 'options' => array(5, 100))
			),
			'value'     => $this->_usuario->getNomeUsuario()
        ));

		// Adiciona o elemento de senha
		$this->addElement('password', 'senha', array(
			'label'      => 'Senha:',
			'required'   => true,
			'validators' => array(
				array('validator' => 'StringLength', 'options' => array(5, 50))
			),
			'value'    => $this->_usuario->getSenha()
	    ));
		
		// Adiciona o elemento de senha
		$this->addElement('text', 'dataNascimento', array(
			'label'      => 'Data de Nascimento (dia/mês/ano):',
			'required'   => false,
			'validators' => array(
				array('validator' => 'Date', 'options' => array('format' => 'd/m/Y'))
			),
			'value'    => ($edicao ? date('d/m/Y', strtotime($this->_usuario->getDataNascimento())) : '')
	    ));

        // Adiciona o botão de envio
		$this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => ($edicao ? 'Salvar alterações' : 'Cadastrar usuário'),
		));

        // Proteção CSRF
		$this->addElement('hash', 'csrf', array(
			'ignore' => true,
		));
    }
}

