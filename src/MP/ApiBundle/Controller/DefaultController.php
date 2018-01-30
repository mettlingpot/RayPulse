<?php

namespace MP\ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MP\PlatformBundle\Entity\Advert;
use MP\UserBundle\Entity\User;
use MP\PlatformBundle\Entity\Liste;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; 



class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MPApiBundle:Default:index.html.twig');
    }  
    

    public function createAction(Request $request)
    {
        $data = $request->getContent();
        $article = $this->get('jms_serializer')->deserialize($data, 'MP\PlatformBundle\Entity\Advert', 'json');
        
        $errors = $this->get('validator')->validate($article);

        if (count($errors)) {
            return $this->view($errors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }    

    public function showAction(Advert $article)
    {
        $data = $this->get('jms_serializer')->serialize($article, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
         
        return $response;

    }    
    /**
     * @Rest\View()
     * @Rest\Get("articles")
     */
    public function listAction()
    {
        $liste = new liste();
        //$articles = new Article();
        $articles = $this->getDoctrine()->getRepository('MPPlatformBundle:Advert')->findAll();
        
        foreach ($articles as $value) {
                $liste->addArticle($value);
        }
        
        if (empty($liste)) {
            return new JsonResponse(['message' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }
        $view = View::create($liste);
        $view->setFormat('json');

        return $view;
    }
        
    /**
     * @Rest\View()
     * @Rest\Get("recherche")
     */
    public function rechercheAction(Request $request)
    {
        $liste = new liste();
        $recherche = $request->get('recherche');
        $em = $this->getDoctrine()->getManager()->getRepository('MPPlatformBundle:Advert');
        $articles = $em->findByRecherche($recherche);
        //dump($articles);
        
        foreach ($articles as $value) {
                $liste->addArticle($value);
        }
        
        if (empty($articles)) {
            return new JsonResponse(['message' => 'Aucune annonce ne correspond à cette recherche'], Response::HTTP_NOT_FOUND);
        }
        $view = View::create($liste);
        $view->setFormat('json');

        return $view;
    }
    /**
     * @Rest\View()
     * @Rest\Get("users/{user_id}")
     */
    public function getUserAction(Request $request)
    {
        $user = $this->getDoctrine()->getRepository('MPUserBundle:User')->find($request->get('user_id'));
        /* @var $user User */

        if (empty($user)) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $view = View::create($user);
        $view->setFormat('json');

        return $view;
    }
}
