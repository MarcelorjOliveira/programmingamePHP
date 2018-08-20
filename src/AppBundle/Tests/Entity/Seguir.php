<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seguir
 *
 * @ORM\Table(name="seguir")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SeguirRepository")
 */
class Seguir
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="seguidor", type="integer")
     */
    private $seguidor;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoSeguidor", type="string", length=255)
     */
    private $tipoSeguidor;

    /**
     * @var int
     *
     * @ORM\Column(name="seguido", type="integer")
     */
    private $seguido;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoSeguido", type="string", length=255)
     */
    private $tipoSeguido;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set seguidor
     *
     * @param integer $seguidor
     *
     * @return Seguir
     */
    public function setSeguidor($seguidor)
    {
        $this->seguidor = $seguidor;

        return $this;
    }

    /**
     * Get seguidor
     *
     * @return int
     */
    public function getSeguidor()
    {
        return $this->seguidor;
    }

    /**
     * Set tipoSeguidor
     *
     * @param string $tipoSeguidor
     *
     * @return Seguir
     */
    public function setTipoSeguidor($tipoSeguidor)
    {
        $this->tipoSeguidor = $tipoSeguidor;

        return $this;
    }

    /**
     * Get tipoSeguidor
     *
     * @return string
     */
    public function getTipoSeguidor()
    {
        return $this->tipoSeguidor;
    }

    /**
     * Set seguido
     *
     * @param integer $seguido
     *
     * @return Seguir
     */
    public function setSeguido($seguido)
    {
        $this->seguido = $seguido;

        return $this;
    }

    /**
     * Get seguido
     *
     * @return int
     */
    public function getSeguido()
    {
        return $this->seguido;
    }

    /**
     * Set tipoSeguido
     *
     * @param string $tipoSeguido
     *
     * @return Seguir
     */
    public function setTipoSeguido($tipoSeguido)
    {
        $this->tipoSeguido = $tipoSeguido;

        return $this;
    }

    /**
     * Get tipoSeguido
     *
     * @return string
     */
    public function getTipoSeguido()
    {
        return $this->tipoSeguido;
    }
}

