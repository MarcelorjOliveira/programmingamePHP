<?php

namespace AppBundle\Entity;

class TipoInvestidor
{

	protected $_nome = array('Consultoria', 'Doador', 'Fornecedor', 'Patrocinador', 'Especificado', 'Aceleradora', 'Instituição Governamental', 'Mídia Impressa', 'Agente', 'Parceiro', 'Empreendedor', 'Fundo de Investimento');   
										


	public function getTipo($id) {
		return $this->_nome[$id];
	}	

	public function getTipos() {
		return $this->_nome;
	}
}

