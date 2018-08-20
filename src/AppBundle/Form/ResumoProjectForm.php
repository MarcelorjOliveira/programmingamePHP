<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ResumoProjectForm extends AbstractType{

	public function buildForm(FormBuilderInterface $builder,  array $options) {
		$builder->add('ParceirosChave', TextareaType::class, array('required' => false, 'label' => 'Parceiros Chave', 'attr' => array('data-toggle' => 'popover', 'data-placement' => 'right', 'title' => 'Popover title', 'data-content' => 'Default popover') ) )
				->add('AtividadesChave', TextareaType::class, array('required' => false, 'label' => 'Atividades Chave'))
				->add('RecursosChave', TextareaType::class, array('required' => false, 'label' => 'Recursos Chave'))
				->add('PropostaDeValor', TextareaType::class, array('required' => false, 'label' => 'Proposta de Valor'))
				->add('RelacaoComCliente', TextareaType::class, array('required' => false, 'label' => 'Relação com o Cliente'))
				->add('Canais', TextareaType::class, array('required' => false, 'label' => 'Canais'))
				->add('SegmentosDeMercado', TextareaType::class, array('required' => false, 'label' => 'Segmentos de Mercado'))
				->add('EstruturaDeCustos', TextareaType::class, array('required' => false, 'label' => 'Estrutura de Custos'))
				->add('FontesDeRenda', TextareaType::class, array('required' => false, 'label' => 'Fontes de Renda'))
				->add('Finalizar', SubmitType::class)
					;
	}
}
