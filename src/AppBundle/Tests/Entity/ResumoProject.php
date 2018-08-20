<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResumoProjectRepository")
 */
class ResumoProject {

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
     * @ORM\Column(name="ParceirosChave", type="string", length=255, nullable=true)
     */
    private $parceirosChave;

    /**
     * @var string
     *
     * @ORM\Column(name="AtividadesChave", type="string", length=255, nullable=true)
     */
    private $atividadesChave;

    /**
     * @var string
     *
     * @ORM\Column(name="RecursosChave", type="string", length=255, nullable=true)
     */
    private $recursosChave;

    /**
     * @var string
     *
     * @ORM\Column(name="PropostaDeValor", type="string", length=255, nullable=true)
     */
    private $propostaDeValor;

    /**
     * @var string
     *
     * @ORM\Column(name="RelacaoComCliente", type="string", length=255, nullable=true)
     */
    private $relacaoComCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="Canais", type="string", length=255, nullable=true)
     */
    private $canais;

    /**
     * @var string
     *
     * @ORM\Column(name="SegmentosDeMercado", type="string", length=255, nullable=true)
     */
    private $segmentosDeMercado;

    /**
     * @var string
     *
     * @ORM\Column(name="EstruturaDeCustos", type="string", length=255, nullable=true)
     */
    private $estruturaDeCustos;

    /**
     * @var string
     *
     * @ORM\Column(name="FontesDeRenda", type="string", length=255, nullable=true)
     */
    private $fontesDeRenda;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="criado", type="datetime")
     */
    private $criado;

    /**
     * @var int
     *
     * @ORM\Column(name="pin", type="integer")
     */
    private $project;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Propriedade ' . $name . ' do Resumo do Project no set inválido');
        }

        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Propriedade ' . $name . ' do Resumo do Project no get inválido');
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

    public function setId($id){
        $this->id = $id;
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
     * Set ParceirosChave
     *
     * @param text $parceirosChave
     * @return ResumoProject
     */
    public function setParceirosChave($parceirosChave) {
        $this->parceirosChave = $parceirosChave;

        return $this;
    }

    /**
     * Get ParceirosChave
     *
     * @return text
     */
    public function getParceirosChave() {
        return $this->parceirosChave;
    }

    /**
     * Set AtividadesChave
     *
     * @param text $atividadesChave
     * @return ResumoProject
     */
    public function setAtividadesChave($atividadesChave) {
        $this->atividadesChave = $atividadesChave;

        return $this;
    }

    /**
     * Get AtividadesChave
     *
     * @return text
     */
    public function getAtividadesChave() {
        return $this->atividadesChave;
    }

    /**
     * Set RecursosChave
     *
     * @param text $recursosChave
     * @return ResumoProject
     */
    public function setRecursosChave($recursosChave) {
        $this->recursosChave = $recursosChave;

        return $this;
    }

    /**
     * Get RecursosChave
     *
     * @return text
     */
    public function getRecursosChave() {
        return $this->recursosChave;
    }

    /**
     * Set PropostaDeValor
     *
     * @param text $propostaDeValor
     * @return ResumoProject
     */
    public function setPropostaDeValor($propostaDeValor) {
        $this->propostaDeValor = $propostaDeValor;

        return $this;
    }

    /**
     * Get PropostaDeValor
     *
     * @return text
     */
    public function getPropostaDeValor() {
        return $this->propostaDeValor;
    }

    /**
     * Set RelacaoComCliente
     *
     * @param text $relacaoComCliente
     * @return ResumoProject
     */
    public function setRelacaoComCliente($relacaoComCliente) {
        $this->relacaoComCliente = $relacaoComCliente;

        return $this;
    }

    /**
     * Get RelacaoComCliente
     *
     * @return text
     */
    public function getRelacaoComCliente() {
        return $this->relacaoComCliente;
    }

    /**
     * Set Canais
     *
     * @param text $canais
     * @return ResumoProject
     */
    public function setCanais($canais) {
        $this->canais = $canais;

        return $this;
    }

    /**
     * Get Canais
     *
     * @return text
     */
    public function getCanais() {
        return $this->canais;
    }

    /**
     * Set SegmentosDeMercado
     *
     * @param text $segmentosDeMercado
     * @return ResumoProject
     */
    public function setSegmentosDeMercado($segmentosDeMercado) {
        $this->segmentosDeMercado = $segmentosDeMercado;

        return $this;
    }

    /**
     * Get SegmentosDeMercado
     *
     * @return text
     */
    public function getSegmentosDeMercado() {
        return $this->segmentosDeMercado;
    }

    /**
     * Set EstruturaDeCustos
     *
     * @param text $estruturaDeCustos
     * @return ResumoProject
     */
    public function setEstruturaDeCustos($estruturaDeCustos) {
        $this->estruturaDeCustos = $estruturaDeCustos;

        return $this;
    }

    /**
     * Get EstruturaDeCustos
     *
     * @return text
     */
    public function getEstruturaDeCustos() {
        return $this->estruturaDeCustos;
    }

    /**
     * Set FontesDeRenda
     *
     * @param text $fontesDeRenda
     * @return ResumoProject
     */
    public function setFontesDeRenda($fontesDeRenda) {
        $this->fontesDeRenda = $fontesDeRenda;

        return $this;
    }

    /**
     * Get FontesDeRenda
     *
     * @return text
     */
    public function getFontesDeRenda() {
        return $this->fontesDeRenda;
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
     * Set pin
     *
     * @param integer $usuario
     * @return ResumoProject
     */
    public function setProject($project) {
        $this->pin = $project;

        return $this;
    }

    /**
     * Get pin
     *
     * @return integer
     */
    public function getProject() {
        return $this->pin;
    }

    private function criaMultiplasLinhas($xInicial, $yInicial, $tamanho, $frase, $imagem) {

        $auxiliarArray = \str_split($frase, $tamanho);

        for ($contador = 0; $contador < \count($auxiliarArray); $contador++) {
            \imagettftext($imagem, 8, 0, $xInicial, $yInicial + 15 * $contador, 0, 'fonts/arial.ttf', $auxiliarArray[$contador]);
        }
        return '';
    }

    public function geraResumo() {
        $modelo = \imagecreatefromjpeg('images/perfil/pin/resumo/modelo.jpg');
        \imagejpeg($modelo, 'images/perfil/pin/resumo/modeloCopia.jpg');

        $resumo = \imagecreatefromjpeg('images/perfil/pin/resumo/modeloCopia.jpg');

        $textcolor = imagecolorallocate($resumo, 0, 0, 0);

        $this->criaMultiplasLinhas(13, 45, 20, $this->parceirosChave, $resumo);
        $this->criaMultiplasLinhas(150, 45, 20, $this->atividadesChave, $resumo);
        $this->criaMultiplasLinhas(150, 190, 20, $this->recursosChave, $resumo);
        $this->criaMultiplasLinhas(280, 45, 20, $this->propostaDeValor, $resumo);
        $this->criaMultiplasLinhas(420, 45, 20, $this->relacaoComCliente, $resumo);
        $this->criaMultiplasLinhas(420, 190, 20, $this->canais, $resumo);
        $this->criaMultiplasLinhas(560, 45, 20, $this->segmentosDeMercado, $resumo);
        $this->criaMultiplasLinhas(13, 320, 53, $this->estruturaDeCustos, $resumo);
        $this->criaMultiplasLinhas(360, 340, 53, $this->fontesDeRenda, $resumo);

        \imagejpeg($resumo, 'images/perfil/pin/resumo/' . $this->getProject() . '.jpg');
    }

    /**
     * @ORM\OneToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="capa_perfil_id", referencedColumnName="id")
     */
    protected $capa;

    public function setCapa($capa) {
        $this->capa = $capa;
        return $this;
    }

    public function getCapa() {
        return $this->capa;
    }

}
