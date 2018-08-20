<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ActionTimelineController extends Controller {
    /* public function postarGaleriaAction() {
      return $this->render('/timeline/verbs/postarGaleria.html.twig', array('subject' => $subject, 'parametros' => array('gallery' => $gallery) ) );
      } */

    public function postarGaleria($action) {
        $subjectId = $action->getComponent('subject')->getIdentifier();

        global $kernel;

        $subject = Project::constroi($subjectId);

        $galleryId = $action->getComponent('directComplement');

        $gallery = $this->get('sonata.media.manager.gallery')->
                find($galleryId);
        return array('subject' => $subject, 'gallery' => $gallery);
    }

    public function atualizarFotoPerfil($action) {
        $subjectId = $action->getComponent('subject')->getIdentifier();

        global $kernel;

        $subject = Usuario::constroiPeloId($subjectId);

        $fotoPerfilId = $action->getComponent('directComplement');

        $fotoPerfil = $this->get('sonata.media.manager.media')->
                find($fotoPerfilId);
        return array('subject' => $subject, 'perfil' => $fotoPerfil);
    }
    public function welcome($action){
        return array();
    }

    public function atualizarCapaPerfil($action) {
        $subjectId = $action->getComponent('subject')->getIdentifier();

        global $kernel;

        $subject = Usuario::constroiPeloId($subjectId);

        $capaPerfilId = $action->getComponent('directComplement');

        $capaPerfil = $this->get('sonata.media.manager.media')->
                find($capaPerfilId);
        return array('subject' => $subject, 'capa' => $capaPerfil);
    }

    public function timelineAction($action) {

        if ($action->getVerb()) {
            $verbo = $action->getVerb();

            $parametros = $this->$verbo($action);

            $parametros['action'] = $action;

            return $this->render('/timeline/verbs/' . $verbo . '.html.twig', $parametros);
        }

        return new Response('');
    }

}
