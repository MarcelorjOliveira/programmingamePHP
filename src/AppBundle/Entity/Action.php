<?php

namespace AppBundle\Entity;

use Spy\TimelineBundle\Entity\Action as BaseAction;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActionRepository")
 * @ORM\Table(name="spy_timeline_action")
 */
class Action extends BaseAction
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="ActionComponent", mappedBy="action", cascade={"persist"})
     */
    protected $actionComponents;

    /**
     * @ORM\OneToMany(targetEntity="Timeline", mappedBy="action")
     */
    protected $timelines;
    
      /**
     * @ORM\OneToMany(targetEntity="CommentsAction", mappedBy="action")
     */
    protected $comments;
    
    public function setComments($comments) {
        $this->comments = $comments;
        return $this;
    }
    
    public function getComments(){
        return $this->comments;
    }
    
    public function addComment($comment){
     if(\count($this->comments) == 0 || $this->comments == null) {
            $this->comments = array();
        }
        \array_push($this->comments, $comment);
        return $this->comments;
    }
}
