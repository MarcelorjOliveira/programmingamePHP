<?php

namespace AppBundle;

/**
 * Abstract EntityManager 
 */
abstract class AbstractEntityManager {

    /**
     * Return the entity manager
     * 
     * @return entity repository or null
     */
    public function getEntityManager() {
        global $kernel;

        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
            $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
            return $entityManager;
        }
   
        return null;
    }
}
