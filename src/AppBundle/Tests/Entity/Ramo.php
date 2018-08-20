<?php

namespace AppBundle\Entity;

class Ramo{

	protected static $_nome = array('Agronegócio', 'Alojamento e alimentação', 'Atividade administrativa', 'Atividade imobiliária', 'Atividade financeira', 'Ciência e Tecnologia', 'Comércio', 'Comunicação', 'Construção', 'Educação', 'Entretenimento', 'Esporte', 'Indústria', 'Moda', 'Transporte', 'Saúde', 'Segurança', 'Serviços'); 	

	public static function getNome($id) {
		return Ramo::$_nome[$id];
	}	

	public static function getNomes() {
		return Ramo::$_nome;
	}
}

/*	protected $_ramo = array('Esporte', 'Música', 'Invenções', 'Instituições', 'Startup', 'Obra de Arte', 'Cinema e Teatro', 'Moda', 'Gastronomia', 'Mídia', 'Games e RPG', 'Parceria', 'Projeto');

	protected $_subRamo = array(array('Esporte coletivo', 'Esporte radical', 'Atletismo', 'Esporte aquático', 'Automobilismo', 'Jogo de estratégia', 'Esporte individual', 'Combate', 'Esporte paralímpico', 'Esporte e lazer'),
array('Sertanejo', 'MPB', 'Samba/Pagode', 'Forró', 'Música eletrônica', 'Rock', 'POP', 'Axé', 'Funk/Soul/Charm/Rap', 'Gospel'), array('Medicamentos', 'Inovações tecnológicas', 'Utensílios domésticos', 'Brinquedos', 'Recicláveis', 'Combustíveis alternativos', 'Energia alternativa', 'Tratmento médico alternativo', 'Inovações agrícolas', 'Genética'), array('Clube', 'ONG', 'Agremiações', 'Igrejas', 'Instituições de ensino', 'Bancos privados', 'Bancos públicos', 'Parceria público-privada', 'Associações', 'Indústrias'), array('Microempresa', 'Franquia', 'Petróleo e gás', 'Alimentícia', 'Farmacêutica', 'Empreendedor', 'Automotiva', 'Logística', 'Importação e exportação', 'Idéia e evento'), array('Escultor', 'Pintor', 'Designer gráfico', 'Artesão', 'Estilista', 'Designer industrial', 'Arquiteto e urbanista', 'Músico', 'Dançarino', 'Fotógrafo'), 'Ator', 'Compositor', 'Cenógrafo', 'Diretor', 'Figurinista', 'Roteirista', 'Filme', 'Vídeo', 'Documentário', 'Propaganda'); */  	 	
