<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Entity\NormalUser;
use AppBundle\Entity\Seguir;
use AppBundle\Form\NormalUserForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;

class NormalUserController extends Controller {

    /**
     * @Route("/index/normal_user", name="indexNormalUser")
     */
    public function indexAction(Request $request) {

      if (!empty($request->request->get('_username')) && !empty($request->request->get('_password'))) {

          $normalUser = new NormalUser();

          $em = $this->getDoctrine()->getManager();

          $normalUser->setEmail($request->request->get('_username'));

          $normalUser->setSenhaPlana($request->request->get('_password'));
          
          $senha = $this->get('security.password_encoder')->encodePassword($normalUser, $normalUser->getSenhaPlana());

          $normalUser->setSenha($senha);

          $normalUser->setRegra('ROLE_NORMAL_USER');

          $normalUser->setCriado(new \DateTime);

          $em->persist($normalUser);

          $em->flush();

          return $this->redirectToRoute('homepage');
      }
      return $this->render('normal_user/index.html.twig', array(
        'teste' => 'teste'  ,
));
    }

}
