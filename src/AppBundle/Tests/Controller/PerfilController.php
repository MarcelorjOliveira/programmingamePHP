<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Application\Sonata\MediaBundle\Entity\Media;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Conexao;
use AppBundle\Form\GaleriaForm;

class PerfilController extends Controller {

    /**
     * @Security("has_role('ROLE_EXPOSITOR')") 
     * @Route("/index/perfil/editar", name="editarPerfil")
     */
    public function editarAction() {
        $objetoUsuario = Usuario::constroi($this->getUser());
        
        $links = array();
        \array_push($links, array('descricao' => 'Linha do Tempo', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Sobre', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Conexões', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Apostas', 'nome' => '#'));

        return $this->render('hold/perfil/editar.html.twig', array('objetoUsuario' => $objetoUsuario,
                    'perfil' => $objetoUsuario->getFotoPerfilObject(), 'capa' => $objetoUsuario->getCapaPerfilObject(), 'links' => $links));
    }

    /**
     * @Security("has_role('ROLE_EXPOSITOR')") 
     * @Route("/index/perfil/exibir/{id}", name="perfil")
     */
    public function indexAction($id) {
        $objetoUsuario = Usuario::constroiPeloId($id);

        //$objetoUsuario->setStatusConexao(Conexao::statusUnico($this->getUser()->getId(), $objetoUsuario->getId()));
//		$form = $this->createForm(GaleriaForm::class, null);	
        
        $links = array();
        \array_push($links, array('descricao' => 'Linha do Tempo', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Sobre', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Conexões', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Apostas', 'nome' => '#'));

        return $this->render('hold/perfil/index.html.twig', array('objetoUsuario' => $objetoUsuario,
                    'perfil' => $objetoUsuario->getFotoPerfilObject(), 'capa' => $objetoUsuario->getCapaPerfilObject(), 'links' => $links));
    }

    /**
     * @Security("has_role('ROLE_EXPOSITOR')") 
     * @Route("/index/perfil/foto/update/{id}", name="atualizarFotoPerfil")
     */
    public function atualizarFotoPerfilAction($id, Request $request) {

        if ($request->files->count() > 0) {
            $manager = $this->getDoctrine()->getManager();

            $fotoTemporaria = $request->files->get('rostoPerfilContent');

            $foto = new Media();

            $foto->setProviderName('sonata.media.provider.image');
            $foto->setContext('default');
            $foto->setBinaryContent($fotoTemporaria);
            $foto->setEnabled(true);

            $manager->persist($foto);
            $manager->flush();

            $this->getUser()->setFotoPerfil($foto->getId());

            $manager->persist($this->getUser());
            $manager->flush();

            $actionManager = $this->get('spy_timeline.action_manager');
            $subject = $actionManager->findOrCreateComponent(\get_class($this->getUser()), $this->getUser()->getId());
            $action = $actionManager->create($subject, 'atualizarFotoPerfil', array('directComplement' => $foto->getId()));
            $actionManager->updateAction($action);
        }

        return $this->redirectToRoute('perfil', array('id' => $this->getUser()->getId() ) );
    }

    /**
     * @Security("has_role('ROLE_EXPOSITOR')") 
     * @Route("/index/perfil/capa/update/{id}", name="atualizarCapaPerfil")
     */
    public function atualizarCapaPerfilAction($id, Request $request) {

        if ($request->files->count() > 0) {
            $manager = $this->getDoctrine()->getManager();

            $fotoTemporaria = $request->files->get('capaPerfilContent');

            $foto = new Media();

            $foto->setProviderName('sonata.media.provider.image');
            $foto->setContext('default');
            $foto->setBinaryContent($fotoTemporaria);
            $foto->setEnabled(true);

            $manager->persist($foto);
            $manager->flush();

            $this->getUser()->setCapaPerfil($foto->getId());

            $manager->persist($this->getUser());
            $manager->flush();

            $actionManager = $this->get('spy_timeline.action_manager');
            $subject = $actionManager->findOrCreateComponent(\get_class($this->getUser()), $this->getUser()->getId());
            $action = $actionManager->create($subject, 'atualizarCapaPerfil', array('directComplement' => $foto->getId()));
            $actionManager->updateAction($action);
        }

        return $this->redirectToRoute('perfil', array('id' => $this->getUser()->getId() ) );
    }

    /**
     * @Security("has_role('ROLE_EXPOSITOR')") 
     * @Route("/index/perfil/editar/atualizar", name="editarAtualizarPerfil")
     */
    public function editarAtualizarAction() {
            $objetoUsuario = Usuario::constroi($this->getUser());
        
        $links = array();
        \array_push($links, array('descricao' => 'Linha do Tempo', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Sobre', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Conexões', 'nome' => '#'));
        \array_push($links, array('descricao' => 'Apostas', 'nome' => '#'));

        return $this->render('hold/perfil/atualizar.html.twig', array('objetoUsuario' => $objetoUsuario,
                    'perfil' => $objetoUsuario->getFotoPerfilObject(), 'capa' => $objetoUsuario->getCapaPerfilObject(), 'links' => $links));}
    
    /**
     * @Security("has_role('ROLE_EXPOSITOR')") 
     * @Route("/index/perfil/atualizar", name="atualizarPerfil")
     */
    public function atualizarAction(Request $request) {
        
        $objeto = Usuario::constroi($this->getUser());
 
        $entityManager = $this->getDoctrine()->getManager();
        
        $cidade = $request->request->get('cidade');
        
        $uf = $request->request->get('uf');
        
        $diaNascimento = $request->request->get('diaNascimento');
        
        $mesNascimento = $request->request->get('mesNascimento');
        
        $anoNascimento = $request->request->get('anoNascimento');
        
        $data = new \DateTime();
        $data->setDate($anoNascimento, $mesNascimento, $diaNascimento); 
        
        $this->getUser()->setCidade($cidade);
        $this->getUser()->setUF($uf);
        $this->getUser()->setDataNascimento($data);
        
        $entityManager->persist($this->getUser());
        $entityManager->flush();

        return $this->redirectToRoute('editarPerfil');
    }
}
