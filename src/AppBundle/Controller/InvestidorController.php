<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Investidor;
use AppBundle\Entity\Seguir;
use AppBundle\Entity\Usuario;
use AppBundle\Form\InvestidorForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class InvestidorController extends Controller {

    /**
     * @Route("/index/investidor")
     */
    public function indexAction(Request $request) {
        $form = $this->createForm(InvestidorForm::class, null);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $investidor = new Investidor($form->getData());

            $em = $this->getDoctrine()->getManager();

            $senha = $this->get('security.password_encoder')->encodePassword($investidor, $investidor->getSenhaPlana());

            $investidor->setSenha($senha);
            
            $mediaManager = $this->get('sonata.media.manager.media'); 
            
            $fotoPerfilMedia = $mediaManager->findOneBy(array('name' => 'rostoSystem.jpg') );
            
            $capaPerfilMedia = $mediaManager->findOneBy(array('name' => 'capaSystem.jpg') );
            
            $investidor->setFotoPerfil($fotoPerfilMedia->getId());
            
            $investidor->setCapaPerfil($capaPerfilMedia->getId());
          
            $investidor->setRegra('ROLE_EXPOSITOR');

            $investidor->setCriado(new \DateTime);

            $investidor->setTipoInvestidorId(1);

            $em->persist($investidor);

            $em->flush();
           /* 
            $seguir = new Seguir();
            $seguir->setSeguidor($investidor->getId());
            $seguir->setTipoSeguidor(\get_class($investidor));
            $seguir->setSeguido($investidor);
            $seguir->setTipoSeguido($investidor);
            
            $em->persist($seguir);
            
            $em->flush();
            * 
            */
            
            $actionManager = $this->get('spy_timeline.action_manager');
            $subject = $actionManager->findOrCreateComponent(\get_class($investidor), $investidor->getId());
            $action = $actionManager->create($subject, 'welcome');
            $actionManager->updateAction($action);
            return $this->redirectToRoute('homepage');
        }

        return $this->render('investidor/index.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
