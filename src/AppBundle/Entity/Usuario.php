<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Usuario
 *
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="regra", type="string")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario implements UserInterface, \Serializable {

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    protected $regra = 'USUARIO';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {

      return $this->id;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    protected $email;

    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }



    /*
     * @Assert\Length(max=4096)
     * @AssertNotBlank()
     */
    protected $senhaPlana;

    /**
     * @var string
     *
     * @ORM\Column(name="senha", type="string", length=255)
     */
    protected $senha;
    protected $statusConexao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="criado", type="datetime")
     */
    private $criado;

    public function __construct(array $options = null) {
        $this->isActive = true;
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Propriedade do usuário no set inválido');
        }

        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Propriedade do usuário no get inválido');
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


    public function setSenhaPlana($senha) {
        $this->senhaPlana = $senha;
        return $this;
    }

    public function getSenhaPlana() {
        return $this->senhaPlana;
    }

    /**
     * Set senha
     *
     * @param string $senha
     * @return Usuario
     */
    public function setSenha($senha) {
        $this->senha = $senha;

        return $this;
    }

    /**
     * Get senha
     *
     * @return string
     */
    public function getSenha() {
        return $this->senha;
    }

    public function setRegra($regra) {
        $this->regra = $regra;
        return $this;
    }

    public function getRegra() {
        return $this->regra;
    }

    /**
     * Set criado
     *
     * @param \DateTime $criado
     * @return NormalUser
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

    public static function constroi($usuario) {
        global $kernel;

        $manager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $objeto = null;
        $objetoRepository = null;

        if ($usuario->getRegra() == 'EXPOSITOR') {
            $objetoRepository = $manager->getRepository('AppBundle:Expositor');
            $objeto = $objetoRepository->find($usuario->getId());
        }

        if ($usuario->getRegra() == 'INVESTIDOR') {
            $objetoRepository = $manager->getRepository('AppBundle:NormalUser');
            $objeto = $objetoRepository->find($usuario->getId());
        }

        $objetoRepository = $manager->getRepository('AppBundle:Project');
        $objeto->setProjects($objetoRepository->findByUsuario($usuario->getId()));

        return $objeto;
    }

    public static function constroiPeloId($idUsuario) {
        global $kernel;

        $manager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $objetoRepository = $manager->getRepository('AppBundle:Usuario');
        $usuario = $objetoRepository->find($idUsuario);
        return $usuario;
    }

    public static function insereFotoPerfilObject($usuarios){
        global $kernel;

        $manager = $kernel->getContainer()->get('sonata.media.manager.media');

        foreach($usuarios as $usuario){
            $perfil = $manager->findOneBy(array('id' => $usuario->fotoPerfil));

            $usuario->fotoPerfilObject = $perfil;
        }
    }

    public static function pesquisaPeloNome($pesquisa, $id) {
        global $kernel;

        $manager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $usuarios = array();

        $objetoRepository = $manager->getRepository('AppBundle:Usuario');

        $usuarios = $objetoRepository->createQueryBuilder('o')->where('o.titulo like :titulo')->setParameter('titulo', '%' . $pesquisa . '%')->getQuery()->getResult();

        //Usuario::insereFotoPerfilObject($usuarios);

        $usuariosComStatus = Conexao::statusUsuarios($id, $usuarios);

        return $usuariosComStatus;
    }

    public function getNomeClasse() {

        $nome = '';

        if ($usuario->getRegra() == 'ROLE_NORMALUSER') {
            $nome = 'NormalUser';
        }

        return $nome;
    }

    public function getStatusConexao() {
        return $this->statusConexao;
    }

    protected $descricaoStatusConexao;

    public function setDescricaoStatusConexao($descricaoStatusConexao){
        $this->descricaoStatusConexao = $descricaoStatusConexao;
        return $this;
    }

    public function getDescricaoStatusConexao() {
        return $this->descricaoStatusConexao;
    }

    public function getUsername() {
        return $this->email;
    }

    public function getSalt() {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword() {
        return $this->senha;
    }

    public function getRoles() {
        return array('ROLE_' . $this->getRegra());
    }

    public function eraseCredentials() {

    }

    /** @see \Serializable::serialize() */
    public function serialize() {
        return serialize(array(
            $this->id,
            $this->email,
            $this->senha,
                // see section on salt below
                // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized) {
        list (
                $this->id,
                $this->email,
                $this->senha,
                // see section on salt below
                // $this->salt
                ) = unserialize($serialized);
    }

    public function setGaleria($galeria) {
        $this->galeria = $galeria;
        return $this;
    }

    public function getGaleria() {
        return $this->galeria;
    }

    protected $temporaryImages;

    public function addTemporaryImage($image) {
        if (\count($temporaryImages) == 0 || $temporaryImages == null) {
            $temporaryImages = array();
        }
        \array_push($temporaryImages, $image);
    }

    public function getTemporaryImages() {
        return $this->temporaryImages;
    }

    public function getClass() {
        return \get_class($this);
    }

    /**
     * @ORM\OneToMany(targetEntity="Project", mappedBy="usuarioorm")
     */
    protected $projects;

    /**
     * Set projects
     *
     * @param list $projects
     * @return Usuario
     */
    public function setProjects($projects) {
        $this->projects = $projects;

        return $this;
    }

    /**
     * Get projects
     *
     * @return list
     */
    public function getProjects() {
        return $this->projects;
    }

}
