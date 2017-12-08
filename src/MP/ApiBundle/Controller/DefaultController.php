<?php

namespace MP\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MP\MairieBundle\Entity\Article;
use MP\MairieBundle\Entity\liste;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MPApiBundle:Default:index.html.twig');
    }  
    

    public function createAction(Request $request)
    {
        $data = $request->getContent();
        $article = $this->get('jms_serializer')->deserialize($data, 'MP\MairieBundle\Entity\Article', 'json');
        
        $errors = $this->get('validator')->validate($article);

        if (count($errors)) {
            return $this->view($errors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }    

    public function showAction(Article $article)
    {
        $data = $this->get('jms_serializer')->serialize($article, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
         
        return $response;

    }    
    
    public function listAction()
    {
        $liste = new liste();
        //$articles = new Article();
        
        $articles = $this->getDoctrine()->getRepository('MPMairieBundle:Article')->findAll();
        
        foreach ($articles as $value) {
                $liste->addArticle($value);
        }
        
        $data = $this->get('jms_serializer')->serialize($liste, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
