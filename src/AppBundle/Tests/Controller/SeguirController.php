<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Seguir;

class SeguirController extends Controller {

    /**
     * @Route("/index/seguir", name="seguir") 
     */
    public function indexAction(Request $request) {
        $seguidor = $this->getUser();
        $seguido = $request->request->get('seguido');
        $tipoSeguido = $request->request->get('tipoSeguido');

        $seguir = new Seguir();
        $seguir->setSeguidor($seguidor->getId());
        $seguir->setTipoSeguidor(\get_class($seguidor));
        $seguir->setSeguido($seguido);
        $seguir->setTipoSeguido($tipoSeguido);

        $em = $this->getDoctrine()->getManager();

        $em->persist($seguir);

        $em->flush();
        
        return $this->redirect($request->headers->get('referer'));
    }

}
