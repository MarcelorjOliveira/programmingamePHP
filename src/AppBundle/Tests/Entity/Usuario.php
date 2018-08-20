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
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    protected $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoTitulo", type="integer")
     */
    protected $codigoTitulo;

    /**
     * @var string
     *
     * @ORM\Column(name="Pais", type="string", length=255)
     */
    protected $pais;

    /**
     * @var int
     *
     * @ORM\Column(name="CEP", type="integer")
     */
    protected $cEP;

    /**
     * @var string
     *
     * @ORM\Column(name="UF", type="string", length=2)
     */
    protected $uF;

    /**
     * @var string
     *
     * @ORM\Column(name="cidade", type="string", length=255)
     */
    protected $cidade;

    /**
     * @var string
     *
     * @ORM\Column(name="bairro", type="string", length=255)
     */
    protected $bairro;

    /**
     * @var string
     *
     * @ORM\Column(name="endereco", type="string", length=255)
     */
    protected $endereco;

    /**
     * @var string
     *
     * @ORM\Column(name="complemento", type="string", length=255)
     */
    protected $complemento;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer")
     */
    protected $numero;

    /**
     * @var int
     *
     * @ORM\Column(name="DDDFixo", type="integer")
     */
    protected $dDDFixo;

    /**
     * @var int
     *
     * @ORM\Column(name="telFixo", type="integer")
     */
    protected $telFixo;

    /**
     * @var int
     *
     * @ORM\Column(name="DDDCelular", type="integer")
     */
    protected $dDDCelular;

    /**
     * @var int
     *
     * @ORM\Column(name="telCelular", type="integer")
     */
    protected $telCelular;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    protected $email;

    /*
     * @Assert\Length(max=4096)
     * @AssertzNotBlank()
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

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Usuario
     */
    public function setTitulo($titulo) {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * Set codigoTitulo
     *
     * @param int $codigoTitulo
     * @return Usuario
     */
    public function setCodigoTitulo($codigoTitulo) {
        $this->codigoTitulo = $codigoTitulo;

        return $this;
    }

    /**
     * Get codigoTitulo
     *
     * @return int
     */
    public function getCodigoTitulo() {
        return $this->codigoTitulo;
    }

    /**
     * Set pais
     *
     * @param string $pais
     * @return Usuario
     */
    public function setPais($pais) {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string
     */
    public function getPais() {
        return $this->pais;
    }

    /**
     * Set cEP
     *
     * @param integer $cEP
     * @return Usuario
     */
    public function setCEP($cEP) {
        $this->cEP = $cEP;

        return $this;
    }

    /**
     * Get cEP
     *
     * @return integer
     */
    public function getCEP() {
        return $this->cEP;
    }

    /**
     * Set uF
     *
     * @param string $uF
     * @return Usuario
     */
    public function setUF($uF) {
        $this->uF = $uF;

        return $this;
    }

    /**
     * Get uF
     *
     * @return string
     */
    public function getUF() {
        return $this->uF;
    }

    /**
     * Set cidade
     *
     * @param string $cidade
     * @return Usuario
     */
    public function setCidade($cidade) {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * Get cidade
     *
     * @return string
     */
    public function getCidade() {
        return $this->cidade;
    }

    /**
     * Set bairro
     *
     * @param string $bairro
     * @return Usuario
     */
    public function setBairro($bairro) {
        $this->bairro = $bairro;

        return $this;
    }

    /**
     * Get bairro
     *
     * @return string
     */
    public function getBairro() {
        return $this->bairro;
    }

    /**
     * Set endereco
     *
     * @param string $endereco
     * @return Usuario
     */
    public function setEndereco($endereco) {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get endereco
     *
     * @return string
     */
    public function getEndereco() {
        return $this->endereco;
    }

    /**
     * Set complemento
     *
     * @param string $complemento
     * @return Usuario
     */
    public function setComplemento($complemento) {
        $this->complemento = $complemento;

        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento() {
        return $this->complemento;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     * @return Usuario
     */
    public function setNumero($numero) {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero() {
        return $this->numero;
    }

    /**
     * Set dDDFixo
     *
     * @param integer $dDDFixo
     * @return Usuario
     */
    public function setDDDFixo($dDDFixo) {
        $this->dDDFixo = $dDDFixo;

        return $this;
    }

    /**
     * Get dDDFixo
     *
     * @return integer
     */
    public function getDDDFixo() {
        return $this->dDDFixo;
    }

    /**
     * Set telFixo
     *
     * @param integer $telFixo
     * @return Usuario
     */
    public function setTelFixo($telFixo) {
        $this->telFixo = $telFixo;

        return $this;
    }

    /**
     * Get telFixo
     *
     * @return integer
     */
    public function getTelFixo() {
        return $this->telFixo;
    }

    /**
     * Set dDDCelular
     *
     * @param integer $dDDCelular
     * @return Usuario
     */
    public function setDDDCelular($dDDCelular) {
        $this->dDDCelular = $dDDCelular;

        return $this;
    }

    /**
     * Get dDDCelular
     *
     * @return integer
     */
    public function getDDDCelular() {
        return $this->dDDCelular;
    }

    /**
     * Set telCelular
     *
     * @param integer $telCelular
     * @return Usuario
     */
    public function setTelCelular($telCelular) {
        $this->telCelular = $telCelular;

        return $this;
    }

    /**
     * Get telCelular
     *
     * @return integer
     */
    public function getTelCelular() {
        return $this->telCelular;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Usuario
     */
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
            $objetoRepository = $manager->getRepository('AppBundle:Investidor');
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

        if ($usuario->getRegra() == 'ROLE_EXPOSITOR') {
            $nome = 'Expositor';
        }

        if ($usuario->getRegra() == 'ROLE_INVESTIDOR') {
            $nome = 'Investidor';
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

    // remover unique de fotoPerfil e capaPerfil

    /**
     * @var int
     *
     * @ORM\Column(name="foto_perfil", type="integer")
     */
    protected $fotoPerfil;

    public function setFotoPerfil($fotoPerfil) {
        $this->fotoPerfil = $fotoPerfil;
        return $this;
    }

    public function getFotoPerfil() {
        return $this->fotoPerfil;
    }

    protected $fotoPerfilObject;

    /**
     *
     * @return Object
     */
    public function getFotoPerfilObject(){
        //return $this->fotoPerfilObject;
        global $kernel;

        $manager = $kernel->getContainer()->get('sonata.media.manager.media');

        $perfil = $manager->findOneBy(array('id' => $this->fotoPerfil));

        $this->fotoPerfilObject = $perfil;

        return $perfil;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="capa_perfil", type="integer")
     */
    protected $capaPerfil;

    public function setCapaPerfil($capaPerfil) {
        $this->capaPerfil = $capaPerfil;
        return $this;
    }

    public function getCapaPerfil() {
        return $this->capaPerfil;
    }

    protected $capaPerfilObject;

    public function getCapaPerfilObject(){
        global $kernel;

        $manager = $kernel->getContainer()->get('sonata.media.manager.media');

        $capa = $manager->findOneBy(array('id' => $this->capaPerfil));

        return $capa;
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
     * @ORM\Column(type="datetime")
     */
    protected $dataNascimento;

    public function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
        return $this;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function getIdade() {
        $agora = new \DateTime();

        $diference = $agora->diff($this->dataNascimento);

        return $diference->y;
    }

    public function getDataNascimentoString() {
        $string = $this->dataNascimento->format('d/m/Y');
        return $string;
    }

    public function getIdadeString() {
        if ($this->getIdade() == 1) {
            $texto = $this->getIdade() . ' ano';
            return $texto;
        }
        $texto = $this->getIdade() . ' anos';
        return $texto;
    }

    public function getRegraString() {
        $minusculo = \strtolower($this->getRegra());
        $normal = \ucfirst($minusculo);
        return $normal;
    }

    /**
     * @ORM\OneToMany(targetEntity="Project", mappedBy="usuarioorm")
     */
    protected $projects;

    /**
     * Set pins
     *
     * @param list $projects
     * @return Usuario
     */
    public function setProjects($projects) {
        $this->pins = $projects;

        return $this;
    }

    /**
     * Get pins
     *
     * @return list
     */
    public function getProjects() {
        return $this->pins;
    }

}
