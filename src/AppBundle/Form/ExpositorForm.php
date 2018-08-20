<?php

namespace AppBundle\Form;

use AppBundle\Form\UsuarioForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ExpositorForm extends UsuarioForm {
	
	public function buildForm(FormBuilderInterface $builder,  array $options) {
		parent::buildForm($builder, $options);
		$builder->add('codigoTitulo', TextType::class, array('label' => 'CPF'))
					->add('titulo', TextType::class, array('label' => 'Nome'))
					->add('Cadastrar', SubmitType::class)
					;
	}
}

