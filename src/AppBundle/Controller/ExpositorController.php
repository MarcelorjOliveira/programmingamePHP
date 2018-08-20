<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Entity\Expositor;
use AppBundle\Entity\Seguir;
use AppBundle\Form\ExpositorForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;

class ExpositorController extends Controller {

    /**
     * @Route("/index/expositor", name="indexExpositor")
     */
    public function indexAction(Request $request) {

        $form = $this->createForm(ExpositorForm::class, null);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $expositor = new Expositor($form->getData());

            $em = $this->getDoctrine()->getManager();

            $senha = $this->get('security.password_encoder')->encodePassword($expositor, $expositor->getSenhaPlana());

            $mediaManager = $this->get('sonata.media.manager.media'); 
            
            $fotoPerfilMedia = $mediaManager->findOneBy(array('name' => 'rostoSystem.jpg') );
            
            $capaPerfilMedia = $mediaManager->findOneBy(array('name' => 'capaSystem.jpg') );
            
            $expositor->setFotoPerfil($fotoPerfilMedia->getId());
            
            $expositor->setCapaPerfil($capaPerfilMedia->getId());
            
            $expositor->setSenha($senha);

            $expositor->setRegra('ROLE_EXPOSITOR');

            $expositor->setCriado(new \DateTime);

            $em->persist($expositor);

            $em->flush();
          /*  $seguir = new Seguir();
            $seguir->setSeguidor($expositor->getId());
            $seguir->setTipoSeguidor(\get_class($expositor));
            $seguir->setSeguido($expositor->getId());
            $seguir->setTipoSeguido(\get_class($expositor));
            
            $em->persist($seguir);
            
            $em->flush(); */
            $actionManager = $this->get('spy_timeline.action_manager');
            $subject = $actionManager->findOrCreateComponent(\get_class($expositor), $expositor->getId());
            $action = $actionManager->create($subject, 'welcome');
            $actionManager->updateAction($action);
            return $this->redirectToRoute('homepage');
        }

        return $this->render('expositor/index.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
