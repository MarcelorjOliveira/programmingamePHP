<?php

namespace AppBundle\Controller;

use AppBundle\Form\ResumoProjectForm;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Project;
use AppBundle\Entity\ResumoProject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Application\Sonata\MediaBundle\Entity\Media;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ResumoProjectController extends Controller {
    //Se usuário pode modificar esse resumo

    /**
     * @Security("has_role('ROLE_EXPOSITOR')")
     * @Route("/index/pin/resumo/update/index/{pin}", name="pinresumoupdateindex")
     */
    public function updateIndexAction($project, Request $request) {
        $objetoUsuario = Usuario::constroi($this->getUser());
        $objetoProject = Project::constroi($project);
        if ($objetoProject->getResumo() != null) {
            $form = $this->createForm(ResumoProjectForm::class, $objetoProject->getResumo(), array('action' => $this->generateUrl('pinresumoupdate', array('pin' => $project))));
            return $this->render('hold/pin/resumo/atualizar.html.twig', array(
                        'form' => $form->createView(), 'objetoUsuario' => $objetoUsuario, 'pin' => $project));
        }
    }

    /**
     * @Route("/index/pin/resumo/update/{pin}", name="pinresumoupdate")
     */
    public function updateAction($project, Request $request) {
        $objetoProject = Project::constroi($project);

        $form = $this->createForm(ResumoProjectForm::class, $objetoProject->getResumo());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {

            $em = $this->getDoctrine()->getManager();

            $resumoProject = $objetoProject->getResumo();

            $resumoProject->setCriado(new \DateTime);

            $resumoProject->geraResumo();

            $resumoTemporario = new File('images/perfil/pin/resumo/' . $resumoProject->getProject() . '.jpg');

            $capaPerfilMedia = new Media();

            $capaPerfilMedia->setProviderName('sonata.media.provider.image');
            $capaPerfilMedia->setContext('default');
            $capaPerfilMedia->setBinaryContent($resumoTemporario);
            $capaPerfilMedia->setEnabled(true);

            $em->persist($capaPerfilMedia);

            $em->flush();

            $resumoProject->setCapa($capaPerfilMedia);

            $em->persist($resumoProject);

            $em->flush();

            return $this->redirectToRoute('hold');
        }
    }

    /**
     * @Security("has_role('ROLE_EXPOSITOR')")
     * @Route("/index/pin/resumo/criar/{pin}", name="pinresumocriar")
     */
    public function criarAction(Request $request, $project) {
        $objetoUsuario = Usuario::constroi($this->getUser());

        $form = $this->createForm(ResumoProjectForm::class, null, array('action' => $this->generateUrl('pinresumocriar', array('pin' => $project))));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $resumoProject = new ResumoProject($form->getData());

            $resumoProject->setProject($project);

            $resumoProject->setCriado(new \DateTime);

            $resumoProject->geraResumo();

            $resumoTemporario = new File('images/perfil/pin/resumo/' . $resumoProject->getProject() . '.jpg');

            $capaPerfilMedia = new Media();

            $capaPerfilMedia->setProviderName('sonata.media.provider.image');
            $capaPerfilMedia->setContext('default');
            $capaPerfilMedia->setBinaryContent($resumoTemporario);
            $capaPerfilMedia->setEnabled(true);

            $em->persist($capaPerfilMedia);

            $em->flush();

            $resumoProject->setCapa($capaPerfilMedia);

            $em->persist($resumoProject);

            $em->flush();

            return $this->redirectToRoute('hold');
        }

        return $this->render('hold/pin/resumo/criar.html.twig', array(
                    'form' => $form->createView(), 'objetoUsuario' => $objetoUsuario, 'pin' => $project
        ));
    }

}
