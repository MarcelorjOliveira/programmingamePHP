<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProjectForm;
use AppBundle\Form\ResumoProjectForm;
use AppBundle\Form\GaleriaProjectForm;
use Sonata\MediaBundle\Form\Type\MediaType;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Application\Sonata\MediaBundle\Entity\Media;
use Application\Sonata\MediaBundle\Entity\GalleryHasMedia;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProjectController extends Controller {

    /**
     * @Security("has_role('ROLE_EXPOSITOR')")
     * @Route("/index/project/criar", name="criarProject")
     */
    public function criarAction(Request $request) {
        $objetoUsuario = Usuario::constroi($this->getUser());

        $form = $this->createForm(ProjectForm::class, null);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $project = new Project($form->getData());

            $project->setUsuario($this->getUser()->getId());

            $project->setCriado(new \DateTime);

            $fotoTemporaria = $project->getRostoProjeto();

            $fotoPerfilMedia = new Media();

            $fotoPerfilMedia->setProviderName('sonata.media.provider.image');
            $fotoPerfilMedia->setContext('default');
            $fotoPerfilMedia->setBinaryContent($fotoTemporaria);
            $fotoPerfilMedia->setEnabled(true);

            $em->persist($fotoPerfilMedia);

            $em->flush();

            $project->setFotoPerfil($fotoPerfilMedia);

            $project->setUsuarioorm($this->getUser());

            $em->persist($project);

            $em->flush();

            return $this->redirectToRoute('projectresumocriar', array('project' => $project->getId()));
        }


        return $this->render('hold/project/criar.html.twig', array(
                    'form' => $form->createView(), 'objetoUsuario' => $objetoUsuario
        ));
    }

    /**
     * @Security("has_role('ROLE_EXPOSITOR')")
     * @Route("/index/project/exibir/{id}", name="projectindex")
     */
    public function indexAction(Request $request, $id) {
        $objetoUsuario = Usuario::constroi($this->getUser());
        $objetoProject = Project::constroi($id);

        $links = array();
        \array_push($links, array('descricao' => 'Linha do Tempo', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Sobre', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Conexões', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Apostas', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Fotos', 'nome' => $this->generateUrl('fotosProject', array('id' => $objetoProject->getId()))));

        $resumo = $this->getDoctrine()->getRepository('AppBundle:ResumoProject')
                ->findOneBy(array('project' => $id));

        $em = $this->getDoctrine()->getManager();

//Get the number of rows from your table
        $rows = $em->createQuery('SELECT COUNT(a.id) FROM PasinterAdManagerBundle:Ad a')->getSingleScalarResult();

        $offset = max(0, rand(0, $rows - 1));

//Get the first $amount users starting from a random point
        $query = $em->createQuery('
                SELECT DISTINCT a
                FROM PasinterAdManagerBundle:Ad a')
                ->setFirstResult($offset);

        $result = $query->getResult();

        $propaganda = \array_shift($result);

        $media = $propaganda->getImage();

        $provider = $this->container->get($media->getProviderName());
        $urlPropagandaImage = $provider->generatePublicUrl($media, 'reference');

        return $this->render('hold/project/index.html.twig', array('objetoUsuario' => $objetoUsuario, 'objetoProject' => $objetoProject,
                    'perfil' => $objetoProject->getFotoPerfil(), 'capa' => $resumo->getCapa(), 'links' => $links, 'propaganda' => $propaganda, 'urlPropagandaImage' => $urlPropagandaImage ));
    }

    /**
     * @Security("has_role('ROLE_EXPOSITOR')")
     * @Route("/index/project/{id}/fotos", name="fotosProject")
     */
    public function fotosAction($id) {

        $objetoUsuario = Usuario::constroi($this->getUser());
        $objetoProject = Project::constroi($id);
//          $form = $this->createForm(GaleriaForm::class, null);
        $links = array();
        \array_push($links, array('descricao' => 'Linha do Tempo', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Sobre', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Conexões', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Apostas', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Fotos', 'nome' => $this->generateUrl('fotosProject', array('id' => $objetoProject->getId()))));

        $resumo = $this->getDoctrine()->getRepository('AppBundle:ResumoProject')
                ->findOneBy(array('project' => $id));

        $em = $this->getDoctrine()->getManager();

//Get the number of rows from your table
        $rows = $em->createQuery('SELECT COUNT(a.id) FROM PasinterAdManagerBundle:Ad a')->getSingleScalarResult();

        $offset = max(0, rand(0, $rows - 1));

//Get the first $amount users starting from a random point
        $query = $em->createQuery('
                SELECT DISTINCT a
                FROM PasinterAdManagerBundle:Ad a')
                ->setFirstResult($offset);

        $result = $query->getResult();

        $propaganda = \array_shift($result);

        $media = $propaganda->getImage();

        $provider = $this->container->get($media->getProviderName());
        $urlPropagandaImage = $provider->generatePublicUrl($media, 'reference');

        $galleries = $this->get('sonata.media.manager.gallery')->findBy(array('enabled' => true, 'project' => $objetoProject->getId()));

        return $this->render('hold/project/fotos/index.html.twig', array('objetoUsuario' => $objetoUsuario, 'objetoProject' => $objetoProject, 'galleries' => $galleries,
            'perfil' => $objetoProject->getFotoPerfil(), 'capa' => $resumo->getCapa(), 'links' => $links, 'propaganda' => $propaganda, 'urlPropagandaImage' => $urlPropagandaImage));
    }

    /**
     * @Security("has_role('ROLE_EXPOSITOR')")
     * @Route("/index/project/{id}/fotos/criar", name="criarFotosProject")
     */
    public function criarFotosAction($id, Request $request) {
        $objetoProject = Project::constroi($id);

        $mediaManager = $this->getDoctrine()->getManager();

        $medias = $this->get('sonata.media.manager.media')->findBy(array('enabled' => true, 'usuario' => $this->getUser()->getId()));

        if (\count($medias) > 0) {
            $galeria = new Gallery();
            $galeria->setName($request->get('tituloGaleria'));
            $galeria->setContext('default');
            $galeria->setDefaultFormat('default_small');
            $galeria->setEnabled(true);
            $galeria->setProject($objetoProject);

            $mediaManager->persist($galeria);
            $mediaManager->flush();

            $actionManager = $this->get('spy_timeline.action_manager');
            $subject = $actionManager->findOrCreateComponent(\get_class($objetoProject), $objetoProject->getId());
            $action = $actionManager->create($subject, 'postarGaleria', array('directComplement' => $galeria->getId()));
            $actionManager->updateAction($action);

            foreach ($medias as $media) {

                $media->setUsuario(0);

                $galleryHasMedia = new GalleryHasMedia();

                $galleryHasMedia->setMedia($media);
                $galleryHasMedia->setGallery($galeria);
                $galleryHasMedia->setEnabled(true);

                $mediaManager->persist($galleryHasMedia);
                $mediaManager->persist($media);

                $mediaManager->flush();
            }
        }
        return $this->redirectToRoute('fotosProject', array('id' => $id));
    }

    /**
     * @Route("/index/project/fotos/criar/ajax", name="adicionarFotoAjax")
     */
    public function adicionarFotoAjaxAction(Request $request) {

        $manager = $this->getDoctrine()->getManager();

        $fotoTemporaria = $request->files->get('foto');

        $foto = new Media();

        $foto->setProviderName('sonata.media.provider.image');
        $foto->setContext('default');
        $foto->setBinaryContent($fotoTemporaria);
        $foto->setEnabled(true);

        $manager->persist($foto);

        $manager->flush();

        $provider = $this->get($foto->getProviderName());

        $caminhoFoto = $provider->generatePublicUrl($foto, 'reference');

        $this->getUser()->addTemporaryImage($foto);

        return new JsonResponse(array('caminhoFoto' => '2'), 200);
    }

    /**
     * @Security("has_role('ROLE_EXPOSITOR')")
     * @Route("/index/projeto/foto/update/{id}", name="atualizarPerfilProjeto")
     */
    public function atualizarPerfilProjetoAction($id, Request $request) {

        if ($request->files->count() > 0) {
            $manager = $this->getDoctrine()->getManager();

            $objetoProject = Project::constroi($id);

            $fotoTemporaria = $request->files->get('perfilProjetoContent');

            $foto = new Media();

            $foto->setProviderName('sonata.media.provider.image');
            $foto->setContext('default');
            $foto->setBinaryContent($fotoTemporaria);
            $foto->setEnabled(true);

            $manager->persist($foto);
            $manager->flush();

            $objetoProject->setFotoPerfil($foto);

            $manager->persist($objetoProject);
            $manager->flush();

            /*$actionManager = $this->get('spy_timeline.action_manager');
            $subject = $actionManager->findOrCreateComponent(\get_class($this->getUser()), $this->getUser()->getId());
            $action = $actionManager->create($subject, 'atualizarFotoPerfil', array('directComplement' => $foto->getId()));
            $actionManager->updateAction($action);
             *
             */
        }

        return $this->redirect($request->headers->get('referer'));
    }

}
