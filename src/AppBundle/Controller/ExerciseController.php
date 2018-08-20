<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Exercise;
use AppBundle\Entity\Movement;
use Symfony\Component\HttpFoundation\Session\Session;

class ExerciseController extends Controller {

/*
use halyen;

insert into Exercise ( name, statement, modelResponse, tests) values ("Soma","Escreva uma função com o nome soma que tenha dois
argumentos inteiros e retorne um número inteiro também. Exemplos : soma(5,7) = 12 . soma(2,9) = 11","int soma(int x, int y)\n {\n int z; \n z = x + y; \n return z; \n
                 }\n", "CU_ASSERT(5 == soma(2,3)); \n CU_ASSERT(7 == soma(4,3)); \n CU_ASSERT(87 == soma(43,44));\n")

*/

	/**
     * @Security("has_role('ROLE_NORMAL_USER')")
     * @Route("/index/game/basicexercises/show", name="showExercise")
     */
    public function showExerciseAction() {
        $exercise = $this->getDoctrine()->getRepository('AppBundle:Exercise')
          ->chooseExercise($this->getUser()->getId());

        $session = new Session();

        $session->set('exercise', $exercise);

        return $this->render('game/basicexercises/show.html.twig');
    }

    /**
       * @Security("has_role('ROLE_NORMAL_USER')")
       * @Route("/index/game/basicexercises/mark", name="markExercise")
       */

      public function markExerciseAction(Request $request) {

        $session = new Session();

        $exercise = $session->get('exercise');

        $exercise->setCode($request->request->get('resolution'));

        $mark = $exercise->buildSourceCode();

        $this->addFlash('notice','Nota : '.$mark);

        $entityManager = $this->getDoctrine()->getManager();

        $movement = new Movement($this->getUser()->getId(), $exercise->getId());

        $movement->setMark($mark);

        $movement->setCodeUsed($request->request->get('resolution'));

        $entityManager->persist($movement);

        $entityManager->flush();

        return $this->redirectToRoute('showExercise') ;
      }

}
