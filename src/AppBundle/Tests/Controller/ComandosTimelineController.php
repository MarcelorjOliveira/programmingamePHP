<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CurtirComandoTimeline;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ComandosTimelineController extends Controller {

    /**
     * @Security("has_role('ROLE_EXPOSITOR')")
     * @Route("/index/curtir", name="curtirAjax")
     */
    public function curtirAjaxAction(Request $request) {

        $action = $request->request->get('action');

        $doctrine = $this->getDoctrine();

        $curtirRepository = $doctrine->getRepository('AppBundle:CurtirComandoTimeline');

        if (!$curtirRepository->findBy(array('usuario' => $this->getUser()->getId(), 'action' => $action ))) {

            $entityManager = $doctrine->getManager();

            $curtir = new CurtirComandoTimeline();
            $curtir->setUsuario($this->getUser()->getId());
            $curtir->setAction($action);

            $entityManager->persist($curtir);
            $entityManager->flush();
        }

        return new JsonResponse(array('done' => 1));
    }

}
