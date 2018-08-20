<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Conexao;

class HoldController extends Controller {

    /**
     * @Security("has_role('ROLE_EXPOSITOR')")
     * @Route("/index/hold", name="hold")
     */
    public function indexAction() {
        $actionManager = $this->get('spy_timeline.action_manager');
        $timelineManager = $this->get('spy_timeline.timeline_manager');

        $cloned = clone($this->getUser());

        $subject = $actionManager->findOrCreateComponent(\get_class($cloned), $cloned->getId());

        try {

            //$timeline = $actionManager->getSubjectActions($subject);

            $timeline = $timelineManager->getTimeline($subject);
        } catch (Exception $e) {
            
        }

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

        $objetoUsuario = Usuario::constroi($this->getUser());
        
        $solicitacoes = Conexao::procurarSolicitacoesDeAmizade($this->getUser()->getId());
        
        return $this->render('/hold/index.html.twig', array('objetoUsuario' => $objetoUsuario, 
            'timeline' => $timeline, 'propaganda' => $propaganda, 
            'urlPropagandaImage' => $urlPropagandaImage, 'solicitacoes' => $solicitacoes));
    }
}
