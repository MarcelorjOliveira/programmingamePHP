<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Conexao
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConexaoRepository")
 */
class Conexao {

    const enviada = 1;
    const aceita = 2;

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
     * @ORM\Column(name="origem", type="integer")
     */
    private $origem;

    /**
     * @var int
     *
     * @ORM\Column(name="destino", type="integer")
     */
    private $destino;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="criado", type="datetime")
     */
    private $criado;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Propriedade da Conexão no set inválido');
        }

        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Propriedade da Conexão no get inválido');
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
     * Set origem
     *
     * @param int $origem
     * @return Project
     */
    public function setOrigem($origem) {
        $this->origem = $origem;

        return $this;
    }

    /**
     * Get origem
     *
     * @return int
     */
    public function getOrigem() {
        return $this->origem;
    }

    /**
     * Set destino
     *
     * @param int $destino
     * @return Conexoes
     */
    public function setDestino($destino) {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Get destino
     *
     * @return int
     */
    public function getDestino() {
        return $this->destino;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Conexoes
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus() {
        return $this->status;
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

    private static function statusPesquisa($id) {

        global $kernel;

        $manager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $objetoRepository = $manager->getRepository('AppBundle:Conexao');

        $conexoes = $objetoRepository->findByOrigem($id);

        return $conexoes;
    }

    public static function statusUsuarios($id, $usuarios) {

        global $kernel;

        $manager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $conexaoRepository = $manager->getRepository('AppBundle:Conexao');

        $conexoesOrigem = $conexaoRepository->findByOrigem($id);
        $conexoesDestino = $conexaoRepository->findByDestino($id);


        foreach ($usuarios as $usuario) {
            foreach ($conexoesOrigem as $conexao) {
                if ($usuario->getId() == $conexao->getDestino()) {
                    $usuario->setDescricaoStatusConexao($conexao->getDescricaoStatusOrigem());
                }
            }

            foreach ($conexoesDestino as $conexao) {
                if ($usuario->getId() == $conexao->getOrigem()) {
                    $usuario->setDescricaoStatusConexao($conexao->getDescricaoStatusDestino());
                }
            }

            if(\is_null($usuario->getDescricaoStatusConexao())){
                $usuario->setDescricaoStatusConexao('Adicionar aos Amigos');
            }
        }

        return $usuarios;
    }

    public static function statusUnico($idOrigem, $idDestino) {
        global $kernel;

        $manager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $objetoRepository = $manager->getRepository('AppBundle:Conexao');

        $conexao = $objetoRepository->findOneBy(array('origem' => $idOrigem, 'destino' => $idDestino));

        $status = 0;

        if ($conexao != null) {
            $status = $conexao->getStatus();
        }

        return $status;
    }

    public static function procurarSolicitacoesDeAmizade($id) {
        global $kernel;

        $manager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $objetoRepository = $manager->getRepository('AppBundle:Conexao');


        $solicitacoes = $objetoRepository->findBy(array('destino' => $id, 'status' => 1));

        return $solicitacoes;
    }

    public function getDescricaoStatusOrigem(){
        if ($this->status == 2) {
            return 'Amigos';
        }
        if ($this->status == 1) {
            return 'Solicitação enviada';
        }

        return 'Adicionar aos amigos';
    }

    public function getDescricaoStatusDestino() {
        if ($this->status == 2) {
            return 'Amigos';
        }
        if ($this->status == 1) {
            return 'Responder à solicitação';
        }

        return 'Adicionar aos amigos';

    }

    public function usuarioOrigem() {

        return Usuario::constroiPeloId($this->origem);
    }

    public function usuarioDestino() {
        return Usuario::constroiPeloId($this->destino);
    }

}
