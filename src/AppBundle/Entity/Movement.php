<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movement
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MovementRepository")
 */
class Movement {

    public function __construct($userId, $exerciseId){
        $this->user = $userId;
        $this->exercise = $exerciseId;
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid movement property in set');
        }

        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid movement property in get');
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

    public function getNomeClasse() {
        return 'Movement';
    }


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getId() {
        return $this->id;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="exerciseId", type="integer")
     */
    protected $exercise;

    /**
     * Set exercise
     * @param string $exercise
     * @return Movement
     */
    public function setExercise($exercise) {
        $this->exercise = $exercise;

        return $this;
    }

    public function getExercise() {
        return $this->exercise;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="userId", type="integer")
     */
    protected $user;

    /**
     * Set user
     * @param string $user
     * @return Movement
     */
    public function setUser($user) {
        $this->user = $user;

        return $this;
    }

    public function getUser() {
        return $this->user;
    }


  /**
    * @var string
    *
    * @ORM\Column(name="codeUsed", type="text")
    */
    protected $codeUsed;

    /**
     * Set Code Used
     * @param string $codeUsed
     * @return Movement
     */
    public function setCodeUsed($codeUsed) {
        $this->codeUsed = $codeUsed;

        return $this;
    }

    /**
     * Get CodeUsed
     *
     * @return string
     */
    public function getCodeUsed() {
        return $this->codeUsed;
    }

    /**
      * @var string
      *
      * @ORM\Column(name="mark", type="float")
      */
      protected $mark;

      /**
       * Set mark
       * @param string $mark
       * @return Movement
       */
      public function setMark($mark) {
          $this->mark = $mark;

          return $this;
      }

      /**
       * Get Mark
       *
       * @return string
       */
      public function getMark() {
          return $this->mark;
      }
}
