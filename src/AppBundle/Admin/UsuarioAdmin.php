<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UsuarioAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
		$formMapper->add('pais', TextType::class, array('label' => 'País'))
					->add('UF', TextType::class, array('label' => 'UF'))
					->add('Cidade', TextType::class, array('label' => 'Cidade'))
					->add('Bairro', TextType::class, array('label' => 'Bairro'))
					->add('Endereco', TextType::class, array('label' => 'Endereço'))
					->add('Numero', TextType::class, array('label' => 'Número'))
					->add('Complemento', TextType::class, array('label' => 'Complemento'))
					->add('CEP', TextType::class, array('label' => 'CEP'))
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
					;
        $formMapper->add('titulo', 'text');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('titulo');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('titulo');
    }
}
