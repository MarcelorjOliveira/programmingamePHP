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
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ConexaoAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
		$formMapper->add('origem', TextType::class, array('label' => 'Origem'))
					->add('destino', TextType::class, array('label' => 'Destino'))
					->add('status', TextType::class, array('label' => 'Status'))
					->add('criado', DateTimeType::class, array('label' => 'Criado'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('criado');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('criado');
    }
}
