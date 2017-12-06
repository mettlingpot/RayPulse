<?php

namespace MP\ApiBundle\Controller;

use MP\PlatformBundle\Entity\Advert;
use MP\PlatformBundle\Entity\Liste;
use MP\PlatformBundle\Entity\Category;
use MP\UserBundle\Entity\User;

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
        $liste = new liste();
        //$articles = new Article();
        
        $articles = $this->getDoctrine()->getRepository('MPPlatformBundle:Advert')->findById($id);
        
        foreach ($articles as $value) {
                $liste->addArticle($value);
        }
        // $advert[0] = $article->getUser()->getUsername();
        // $advert[1] = $article->getTitle();

        $data = $this->get('jms_serializer')->serialize($liste, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
         
        return $response;

    }    
    
    public function listAction()
    {
        $liste = new liste();
        //$articles = new Article();
        
        $articles = $this->getDoctrine()->getRepository('MPPlatformBundle:Advert')->findAll();
        
        foreach ($articles as $value) {
                $liste->addArticle($value);
        }
        
        $data = $this->get('jms_serializer')->serialize($liste, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
