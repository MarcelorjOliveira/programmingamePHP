<?php

namespace AppBundle\Spread;

use Spy\Timeline\Spread\SpreadInterface;
use Spy\Timeline\Model\ActionInterface;
use Spy\Timeline\Spread\Entry\EntryCollection;
use Spy\Timeline\Spread\Entry\EntryUnaware;
use AppBundle\AbstractEntityManager;
use AppBundle\Entity\Usuario;

class ProjectSpread extends AbstractEntityManager implements SpreadInterface {

    public function supports(ActionInterface $action) {
        // here you define what actions you want to support, you have to return a boolean.
        return true;
    }

    public function process(ActionInterface $action, EntryCollection $coll) {

        global $kernel;

        //return \get_class($kernel);

        $usuario = $kernel->getContainer()->get('doctrine.orm.entity_manager')
                        ->getRepository('AppBundle:Usuario')->find(1);
        $coll->add(new EntryUnaware(\get_class($usuario), $usuario->getTitulo()));

//        $coll->add(new EntryUnaware('\Teste', 'Chuck Norris'));
    }

}
