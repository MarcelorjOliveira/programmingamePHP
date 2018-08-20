<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use AppBundle\Entity\Ramo;

class ProjectForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('Nome', TextType::class, array('label' => 'Nome', 'attr' => array('data-toggle' => 'popover', 'data-placement' => 'right', 'data-content' => 'Digite o nome do projeto')))
                ->add('Descricao', TextType::class, array('label' => 'Descrição',
                    'attr' => array('data-toggle' => 'popover',
                        'data-placement' => 'right',
                        'data-content' =>
                        'Descreva um pouco mais o seu projeto')))
                ->add('Ramo', ChoiceType::class, array('choices' => Ramo::getNomes(),
                    'choices_as_values' => false,
                    'attr' => array('data-toggle' => 'popover',
                        'data-placement' => 'right',
                        'data-content' =>
                        'Escolha o ramo de atuação do projeto')))
                ->add('rostoProjeto', FileType::class, array(
                    'label' => 'Logo do projeto',
                    'attr' => array('data-toggle' => 'popover',
                        'data-placement' => 'right',
                        'data-content' => 'Coloque a logo do projeto')))
                ->add('Continuar', SubmitType::class);
    }
}
