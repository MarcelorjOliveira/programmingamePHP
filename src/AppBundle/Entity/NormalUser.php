<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Usuario;
use Doctrine\ORM\Mapping as ORM;

/**
 * Expositor
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NormalUserRepository")
 */
class NormalUser extends Usuario {

    protected $regra = 'NORMAL_USER';

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Propriedade do normalUser no set inválido');
        }

        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Propriedade do normalUser no get inválido');
        }

        return $this->$method();
    }

    public function getNomeClasse() {
        return 'NormalUser';
    }

}
