<?php

namespace MP\MairieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MP\MairieBundle\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;



class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MPMairieBundle:Default:index.html.twig');
    }  
    

    public function createAction(Request $request)
    {
        $data = $request->getContent();
        $article = $this->get('jms_serializer')->deserialize($data, 'MP\MairieBundle\Entity\Article', 'json');
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }    

    public function showAction(Article $article, Request $request)
    {
        $data = $this->get('jms_serializer')->serialize($article, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
         
        if ($response = false) {
            return $response;
        }
        
        return $this->render('MPMairieBundle:Default:index.html.twig', array(
          'comp' => $article
        ));

    }    
    
    public function listAction()
    {
        $articles = $this->getDoctrine()->getRepository('MPMairieBundle:Article')->findAll();
        $data = $this->get('jms_serializer')->serialize($articles, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
