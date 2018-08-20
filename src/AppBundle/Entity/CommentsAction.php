<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Usuario;

/**
 * CommentsAction
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentsActionRepository")
 */
class CommentsAction {

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
        $this->criado = new \DateTime();
        $this->created = $this->getCreated();
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
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Action", inversedBy="comments")
     * @ORM\JoinColumn(name="action_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $action;

    /**
     * Set action
     *
     */
    public function setAction($action) {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     * 
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="user", type="integer")
     */
    private $user;

    /**
     * Set user
     *
     * @param int $user
     * @return CommentsAction
     */
    public function setUser($user) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return int 
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * Set content
     *
     * @param string $content
     * @return CommentsAction
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="criado", type="datetime")
     */
    private $criado;

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

    public function getCriadoString() {
        $string = $this->criado->format('Y-m-d');
        return $string;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="created", type="string", length=255)
     */
    protected $created;

    public function setCreated($created) {
        $this->created = $created;
        return $this;
    }

    public function getCreated() {
        $string = $this->getCriado()->format('Y-m-d').'T'.$this->getCriado()->format('H:i:s').'.000000+00:00';
        /*global $kernel;
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $string = $em->getClassMetadata(zget_class($this->getCriado()))->getName(); 
      
         */
        return $string;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="creator", type="integer", nullable=true)
     */
    protected $creator;

    public function setCreator($creator) {
        $this->creator = $creator;
        return $this;
    }

    public function getCreator() {
        return $this->creator;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string", length=255)
     */
    protected $fullname;

    public function setFullname($fullname) {
        $this->fullname = $this->getObjetoUsuario()->getTitulo();
        return $this;
    }

    public function getFullname() {
        return $this->fullname;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="profileURL", type="string", length=255)
     */
    protected $profileURL;

    public function setProfileURL($profileURL) {
        $this->profileURL = $profileURL;
        return $this;
    }

    public function getProfileURL() {
        return $this->profileURL;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="profilePictureURL", type="string", length=255)
     */
    protected $profilePictureURL;

    public function setProfilePictureURL($profilePictureURL) {
        $this->profilePictureURL = $profilePictureURL;
        return $this;
    }

    public function getProfilePictureURL() {
        return $this->profilePictureURL;
    }

    /**
     * @var boolean
     *
     * @ORM\Column(name="createdByAdmin", type="boolean")
     */
    protected $createdByAdmin;

    public function setCreatedByAdmin($createdByAdmin) {
        $this->createdByAdmin = $createdByAdmin;
        return $this;
    }

    public function getCreatedByAdmin() {
        return $this->createdByAdmin;
    }

    /**
     * @var boolean
     *
     * @ORM\Column(name="createdByCurrentUser", type="boolean")
     */
    protected $createdByCurrentUser;

    public function setCreatedByCurrentUser($createdByCurrentUser) {
        $this->createdByCurrentUser = $createdByCurrentUser;
        return $this;
    }

    public function getCreatedByCurrentUser() {
        return $this->createdByCurrentUser;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="upvoteCount", type="integer")
     */
    protected $upvoteCount;

    public function setUpvoteCount($upvoteCount) {
        $this->upvoteCount = 0;
        return $this;
    }

    public function getUpvoteCount() {
        return $this->upvoteCount;
    }

    /**
     * @var boolean
     *
     * @ORM\Column(name="userHasUpvoted", type="boolean")
     */
    protected $userHasUpvoted;

    public function setUserHasUpvoted($userHasUpvoted) {
        $this->userHasUpvoted = $userHasUpvoted;
        return $this;
    }

    public function getUserHasUpvoted() {
        return false;
    }
    
    /**
     * @var integer
     *
     * @ORM\Column(name="parent", type="integer", nullable=true)
     */
    protected $parent;

    public function setParent($parent) {
        $this->parent = $parent;
        return $this;
    }

    public function getParent() {
        return false;
    }

    public function getObjetoUsuario() {
        global $kernel;

        $objetoUsuario = Usuario::constroiPeloId($this->user, $kernel->getContainer()->get('doctrine.orm.entity_manager'));

        return $objetoUsuario;
    }

}
