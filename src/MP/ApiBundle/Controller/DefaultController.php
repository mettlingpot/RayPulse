<?php

namespace MP\ApiBundle\Controller;

use MP\PlatformBundle\Entity\Advert;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MPApiBundle:Default:index.html.twig');
    }

    public function showAction($id, Request $request)
    {     
        $tabArticle = $this->getDoctrine()->getRepository('MPPlatformBundle:Advert')->findById($id);
        $article = $tabArticle[0];

        $retest= $article->getUser()->getUsername();

        $data = $this->get('jms_serializer')->serialize($retest, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
         
        return $response;

    }    
    
    public function listAction()
    {
        //$liste = new liste();
        //$articles = new Article();
        
        $articles = $this->getDoctrine()->getRepository('MPPlatformBundle:Advert')->findAll();
        
        // foreach ($articles as $value) {
        //         $liste->addArticle($value);
        // }
        
        $data = $this->get('jms_serializer')->serialize($articles, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
