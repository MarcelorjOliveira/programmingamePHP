<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Usuario;

class PesquisaController extends Controller {

    /**
     * @Security("has_role('ROLE_EXPOSITOR')")
     * @Route("/index/hold/pesquisa", name="pesquisa") 
     */
    public function indexAction(Request $request) {
        $conteudo = $request->request->get('pesquisa');
        $pesquisa = Usuario::pesquisaPeloNome($conteudo, $this->getUser()->getId());

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
        return $this->render('/hold/pesquisa/index.html.twig', array('objetoUsuario' => $objetoUsuario, 'pesquisa' => $pesquisa, 'propaganda' => $propaganda, 'urlPropagandaImage' => $urlPropagandaImage));
    }

}
