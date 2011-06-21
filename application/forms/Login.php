<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'nomeUsuario', array(
			'filters'    => array('StringTrim'),
			'validators' => array(
				'Alpha', array('StringLength', false, array(5, 100))
			),
			'required' => true,
			'label'    => 'Nome de Usuário:'
		));
		
		$this->addElement('password', 'senha', array(
			'required' => true,
			'label'    => 'Senha:'
		));
		
		$this->addElement('submit', 'login', array(
			'required' => false,
			'ignore'   => true,
			'label'    => 'Entrar'
		));
		
		$this->setDecorators(array(
			'FormElements',
			array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
			array('Description', array('placement' => 'prepend')),
			'Form'
		));
    }


}

