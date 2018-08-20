<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Usuario;
use Doctrine\ORM\Mapping as ORM;

/**
 * Investidor
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InvestidorRepository")
 */
class Investidor extends Usuario {

    protected $regra = 'INVESTIDOR';

    /**
     * @var int
     *
     * @ORM\Column(name="TipoInvestidorId", type="integer")
     */
    private $tipoInvestidorId;

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Propriedade do expositor no set inválido');
        }

        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Propriedade do expositor no get inválido');
        }

        return $this->$method();
    }

    /**
     * Set tipoInvestidorId
     *
     * @param integer $tipoInvestidorId
     * @return Investidor
     */
    public function setTipoInvestidorId($tipoInvestidorId) {
        $this->tipoInvestidorId = $tipoInvestidorId;

        return $this;
    }

    /**
     * Get tipoInvestidorId
     *
     * @return integer 
     */
    public function getTipoInvestidorId() {
        return $this->tipoInvestidorId;
    }

    public function getNomeClasse() {
        return 'Investidor';
    }

}
