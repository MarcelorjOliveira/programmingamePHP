<?php

namespace AppBundle\Spread;

use Spy\Timeline\Spread\SpreadInterface;
use Spy\Timeline\Model\ActionInterface;
use Spy\Timeline\Spread\Entry\EntryCollection;
use Spy\Timeline\Spread\Entry\EntryUnaware;
use AppBundle\AbstractEntityManager;
use AppBundle\Entity\Usuario;

class UserSpread extends AbstractEntityManager implements SpreadInterface {

    public function supports(ActionInterface $action) {
        if(($action->getSubject()->getModel() == 'AppBundle\Entity\Expositor') || 
                ($action->getSubject()->getModel() == 'AppBundle\Entity\Investidor')) {
            return true;
        }
        return false;     
    }

    public function process(ActionInterface $action, EntryCollection $coll) {

        $subject = $action->getComponent('subject');
        
        $coll->add(new EntryUnaware($subject->getModel(), $subject->getIdentifier()));
        
        global $kernel;

        $listaQuemSegue = $kernel->getContainer()->get('doctrine.orm.entity_manager')
                        ->getRepository('AppBundle:Seguir')->findBy(array('seguido' => $subject->getId() , 'tipoSeguido' => \get_class($subject) ));
        
        foreach($listaQuemSegue as $quemSegue) {
            $coll->add(new EntryUnaware($quemSegue->getTipoSeguidor(), $quemSegue->getSeguidor()));
        }

//        $coll->add(new EntryUnaware('\Teste', 'Chuck Norris'));
    }

}
