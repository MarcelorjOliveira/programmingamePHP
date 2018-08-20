<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Project
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRepository")
 */
class Project {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Nome", type="string", length=255)
     */
    private $nome;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="criado", type="datetime")
     */
    private $criado;

    /**
     * @var int
     *
     * @ORM\Column(name="usuario", type="integer")
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="Descricao", type="string", length=255)
     */
    private $descricao;

    /**
     * @var integer
     *
     * @ORM\Column(name="ramo", type="integer")
     */
    private $ramo;

    /**
     *
     * @ORM\OneToMany(targetEntity="\Application\Sonata\MediaBundle\Entity\Gallery", mappedBy="id")
     */
    private $galerias;

    private $colaboradores;
    private $seguidores;

    private $resumo;

    /**
     * Set resumo
     *
     */
    public function setResumo($resumo) {
        $this->resumo = $resumo;

        return $this;
    }

    /**
     * Get resumo
     *
     */
    public function getResumo() {
        return $this->resumo;
    }

    private $publicoAlvo;
    private $video;
    private $dataDeCriacao;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Propriedade do Project no set inválido');
        }

        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Propriedade do Project no get inválido');
        }

        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return Project
     */
    public function setNome($nome) {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return string
     */
    public function setDescricao($descricao) {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * Set criado
     *
     * @param \DateTime $criado
     * @return Investidor
     */
    public function setCriado($criado) {
        $this->criado = $criado;

        return $this;
    }

    /**
     * Get criado
     *
     * @return \DateTime
     */
    public function getCriado() {
        return $this->criado;
    }

    /**
     * Set usuario
     *
     * @param integer $usuario
     * @return Investidor
     */
    public function setUsuario($usuario) {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return integer
     */
    public function getUsuario() {
        return $this->usuario;
    }

    /**
     * Set ramo
     *
     * @param integer $ramo
     * @return Project
     */
    public function setRamo($ramo) {
        $this->ramo = $ramo;

        return $this;
    }

    /**
     * Get ramo
     *
     * @return integer
     */
    public function getRamo() {
        return $this->ramo;
    }

    public static function constroi($id) {
        global $kernel;

        $manager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $objetoRepository = $manager->getRepository('AppBundle:Project');
        $objeto = $objetoRepository->findOneById($id);

        $resumoRepository = $manager->getRepository('AppBundle:ResumoProject');
        $resumo = $resumoRepository->findOneByProject($id);

        $objeto->setResumo($resumo);

        return $objeto;
    }

    public function setGalerias($galerias) {
        $this->galerias = $galerias;
        return $this;
    }

    public function getGalerias() {
        return $this->galerias;
    }

    /** @var Symfony\Component\HttpFoundation\File\UploadedFile */
    protected $rostoProjeto;

    public function setRostoProjeto($rostoProjeto) {
        $this->rostoProjeto = $rostoProjeto;
        return $this;
    }

    public function getRostoProjeto() {
        return $this->rostoProjeto;
    }

    // remover unique do fotoPerfil

    /**
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="foto_perfil_id", referencedColumnName="id")
     */
    protected $fotoPerfil;

    public function setFotoPerfil($fotoPerfil) {
        $this->fotoPerfil = $fotoPerfil;
        return $this;
    }

    public function getFotoPerfil() {
        return $this->fotoPerfil;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="pins")
     * @ORM\JoinColumn(name="usuario_orm_id", referencedColumnName="id")
     */
    protected $usuarioorm;

    public function setUsuarioorm($usuarioorm) {
        $this->usuarioorm = $usuarioorm;
        return $this;
    }

    public function getUsuarioorm() {
        return $this->usuarioorm;
    }
}
