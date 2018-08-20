<?php

namespace AppBundle\ClassServices;

use Doctrine\ORM\EntityManager;

/*
 * @InjectParams({
 *  "em" = @Inject("doctrine.orm.entity_manager")
 * })
 */
class EntityDb 
{
    private $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getEm() {
        return $this->em;
    }
}

