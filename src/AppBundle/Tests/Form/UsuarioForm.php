<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; 

class UsuarioForm extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder,  array $options) {
		 $builder->add('CEP', TextType::class, array('label' => 'CEP'))
					->add('pais', TextType::class, array('label' => 'País'))
					//->add('UF', ChoiceType::class, array('label' => 'UF', 'choices' => array('selecione um estado' => null), 'choices_as_values' => true))
					->add('UF', TextType::class, array('label' => 'UF'))
                                        ->add('Cidade', TextType::class, array('label' => 'Cidade'))
					->add('Bairro', TextType::class, array('label' => 'Bairro'))
					->add('Endereco', TextType::class, array('label' => 'Endereço'))
					->add('Numero', TextType::class, array('label' => 'Número'))
					->add('Complemento', TextType::class, array('label' => 'Complemento'))
					->add('DDDFixo', TextType::class, array('label' => 'DDD Fixo'))
					->add('TelFixo', TextType::class, array('label' => 'Tel. Fixo'))
					->add('DDDCelular', TextType::class, array('label' => 'DDD Celular'))
					->add('TelCelular', TextType::class, array('label' => 'Tel. Celular'))
					->add('email', EmailType::class, array('label' => 'Email'))
					->add('senhaPlana', RepeatedType::class, array('type' => PasswordType::class,
						'first_options' => array('label' => 'Senha'),
						'second_options' => array('label' => 'Repetir Senha')
						)
					)
                                        ->add('dataNascimento', BirthdayType::class, array('label' => 'Data de Nascimento', 
                                            'format' => 'ddMMyyyy'))
					;
	}
/*
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Usuario'));
	}
*/
}    
