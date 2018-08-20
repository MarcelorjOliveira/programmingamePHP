<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Usuario;
use Doctrine\ORM\Mapping as ORM;

/**
 * Expositor
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExpositorRepository")
 */
class Expositor extends Usuario {

    protected $regra = 'EXPOSITOR'; 

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

    public function getNomeClasse() {
        return 'Expositor';
    }

}
