<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller {

	/**
     * @Route("/", name="homepageComum") 
     */
    public function indexPrimaryAction() {
        return $this->render('index/index.html.twig');
    }

    /**
     * @Route("/index", name="homepage") 
     */
    public function indexAction() {
        return $this->render('index/index.html.twig');
    }

	/**
	* @Route("/phpinfo", name="phpinfo")
	*/ 
	public function phpAction() {
		//ob_start();
		//phpinfo();
		//$phpinfo = ob_get_clean();
		return $this->render('phpinfo.html.twig', array('phpinfo' => phpinfo()));
	}

}
