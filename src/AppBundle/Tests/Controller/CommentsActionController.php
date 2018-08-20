<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CommentsAction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CommentsActionController extends Controller {

    /**
     * @Security("has_role('ROLE_EXPOSITOR')")
     * @Route("/index/commentAjax", name="commentAjax")
     */
    public function commentAjaxAction(Request $request) {

        $action = $request->request->get('action');

        $actionObject = $this->getDoctrine()->getRepository('AppBundle:Action')->find($action);

        $content = $request->request->get('content');
        
        $parent = $request->request->get('parent');

        $doctrine = $this->getDoctrine();

        $commentsActionRepository = $doctrine->getRepository('AppBundle:CommentsAction');

        $entityManager = $doctrine->getManager();

        $comment = new CommentsAction();
        $comment->setUser($this->getUser()->getId());
        $comment->setAction($actionObject);
        $comment->setContent($content);
        $comment->setParent($parent);
        $comment->setCreated($comment->getCreated());
        $comment->setFullname($this->getUser()->getTitulo());
        $comment->setProfileURL($this->generateUrl('perfil', array('id' => $this->getUser()->getId())));
        
        $media = $this->getUser()->getFotoPerfilObject();
        
        $provider = $this->container->get($media->getProviderName());
        $url = $provider->generatePublicUrl($media, 'reference');
        
        $comment->setProfilePictureURL($url);
        $comment->setCreatedByAdmin(false);
        $comment->setCreatedByCurrentUser(false);
        $comment->setUpvoteCount(0);
        $comment->setUserHasUpvoted(false);

        $entityManager->persist($comment);
        $entityManager->flush();


        return new JsonResponse(array('userProfileUrl' => $comment->getProfileURL(), 'userProfilePictureUrl' => $comment->getProfilePictureURL()));
    }

    /**
     * @Security("has_role('ROLE_EXPOSITOR')")
     * @Route("/index/getActionComments", name="getActionComments")
     */
    public function getActionCommentsAction(Request $request) {

        $action = $request->request->get('action');

        $actionObject = $this->getDoctrine()->getRepository('AppBundle:Action')->find($action);

        $comments = $this->get('serializer')->serialize($actionObject->getComments(), 'json');

        return new Response($comments);
    }

}
