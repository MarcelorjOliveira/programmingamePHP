<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworrkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use AppBundle\Entity\Conexao;
use AppBundle\Entity\Usuario;
use Symfony\Component\HttpFoundation\JsonResponse;

/* trait Referer {
  private function getRefererParams() {
  $request = $this->getRequest();
  $referer = $request->headers->get('referer');
  $baseUrl = $request->getBaseUrl();
  $lastPath = substr($referer, strpos($referer, $baseUrl) + strlen($baseUrl));
  return $this->get('router')->getMatcher()->match($lastPath);
  }
  }
 */

class ConexaoController extends Controller {
//	use Referer;

    /**
     * @Route("/index/conexao/criar/", name="criarConexao")
     */
    public function criarAction(Request $request) {

        //$response = $request->request->get('origem');
        //$form = $this->createCustomForm(array('origem' => $request->request->get('origem'), 'destino' => $request->request->get('destino') ) );
        //$form->handleRequest($request);  
        //	if ($form->isSubmitted() && $form->isValid()) {

        $origem = $this->getUser()->getId();
        $destino = $request->request->get('destino');

        $conexaoRepository = $this->getDoctrine()->getRepository('AppBundle:Conexao');

        $conexao = $conexaoRepository->findOneBy(array('origem' => $origem, 'destino' => $destino));

        if ($conexao != null) {
            $conexao->setStatus(2);
        } else {
            $conexao = $conexaoRepository->findOneBy(array('origem' => $destino, 'destino' => $origem));
            if ($conexao != null) {
                $conexao->setStatus(2);
            } else {
                $conexao = new Conexao();
                $conexao->setOrigem($origem);
                $conexao->setDestino($destino);
                $conexao->setStatus(1);
                $conexao->setCriado(new \DateTime());
            }
        }

        $em = $this->getDoctrine()->getManager();

        $em->persist($conexao);

        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/index/conexao/aceitar/", name="aceitarConexao")
     */
    public function aceitarAction(Request $request) {

        //$response = $request->request->get('origem');
        //$form = $this->createCustomForm(array('origem' => $request->request->get('origem'), 'destino' => $request->request->get('destino') ) );
        //$form->handleRequest($request);  
        //	if ($form->isSubmitted() && $form->isValid()) {
        $solicitou = $request->request->get('solicitou');

        $conexaoRepository = $this->getDoctrine()->getRepository('AppBundle:Conexao');

        $conexao = $conexaoRepository->findOneBy(array('origem' => $solicitou, 'destino' => $this->getUser()->getId()));

        if ($conexao != null) {
            $conexao->setStatus(2);
            $em = $this->getDoctrine()->getManager();

            $em->persist($conexao);

            $em->flush();
        }
        return new JsonResponse(array('executou' => '1'), 200);
    }

    /**
     * @Route("/index/conexao/cancelar/", name="cancelarConexao")
     */
    public function cancelarAction(Request $request) {
        
        $solicitou = $request->request->get('solicitou');

        $conexaoRepository = $this->getDoctrine()->getRepository('AppBundle:Conexao');

        $conexao = $conexaoRepository->findOneBy(array('origem' => $solicitou, 'destino' => $this->getUser()->getId()));

        if ($conexao != null) {
            $conexao->setStatus(2);
            $em = $this->getDoctrine()->getManager();

            $em->persist($conexao);

            $em->flush();
        }
        
        return new JsonResponse(array('executou' => '1'),200);
    }

    private function createCustomForm(array $campos) {
        $formBuilder = $this->createFormBuilder();
        $formBuilder->setAction($this->generateUrl('criarConexao', array('origem' => $campos['origem'], $destino => $campos['destino'])))
                ->setMethod('POST');
        //				->add('origem', HiddenType::class, array('data' => $campos['origem']) )
        //				->add('destino', HiddenType::class, array('data' => $campos['destino']) );
        return $formBuilder->getForm();
    }

}
