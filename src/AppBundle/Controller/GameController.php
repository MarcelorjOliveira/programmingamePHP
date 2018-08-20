<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Conexao;

class GameController extends Controller {

    /**
     * @Security("has_role('ROLE_NORMAL_USER')")
     * @Route("/index/game", name="gameIndex")
     */
    public function indexAction() {
        return $this->render('/game/index.html.twig', array());
    }
}
