<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

	 /**
     * @Route("/index/auth")
     */
	
    public function indexAction()
    {
		return $this->render('auth/index.html.twig', array());
    }

	/**
     * @Route("/index/auth/login")
     */

    public function loginAction(Request $request)
    {
 

/*
		if ($auth->hasIdentity()){
			return $this->render->('hold/index.html.twig', null);
		}

*/		
		

/*
		$usuarioManager = $this->getDoctrine()->getRepository('AppBundle:Usuario'); 

		if ($usuarioManager->findOneBy( array('email' => $request->get('email'), 'senha' => $request->get('senha')) ) ) {
						

$auth = Zend_Auth::getInstance();
			$identity = $authAdapter->getResultRowObject();

//			session_start();
	
//			$_SESSION['usuario'] = $identity 
			
			$authStorage = $auth->getStorage();

			$authStorage->write($identity);

'/hold'

path('homepage').'/auth/login'

	
			return $this->redirect($this->generateUrl('homepage', array(), UrlGeneratorInterface::ABSOLUTE_URL).'/hold');		
			
		} 
		return $this->redirect($this->generateUrl('homepage', array(), UrlGeneratorInterface::ABSOLUTE_URL).'/auth');
*/
    }

	 /**
     * @Route("/index/auth/logout")
     */
	
    public function logoutAction()
    {    
        return $this->redirectToRoute('homepage');
	}

	private function getAuthAdapter() {
	}
}





