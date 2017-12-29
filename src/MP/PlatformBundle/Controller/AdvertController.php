<?php

namespace MP\PlatformBundle\Controller;


use MP\UserBundle\Entity\User;
use MP\PlatformBundle\Entity\Adresse;
use MP\PlatformBundle\Form\RechercheType;
use MP\PlatformBundle\Form\AdresseType;
use MP\PlatformBundle\Entity\Advert;
use MP\PlatformBundle\Entity\Image;
use MP\PlatformBundle\Form\AdvertType;
use MP\PlatformBundle\Form\AdvertEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AdvertController extends Controller
{
    public function indexAction($page)
    {    
      if ($page < 1) {
        throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
      }
        $nbArticlesParPage = 9;

        $em = $this->getDoctrine()->getManager()->getRepository('MPPlatformBundle:Advert');
        
        $advert = $em->findAllPagination($page, $nbArticlesParPage);
        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($advert) / $nbArticlesParPage),
            'nomRoute' => 'mp_platform_home',
            'paramsRoute' => array()
        );

        return $this->render('MPPlatformBundle:Advert:index.html.twig', array(         
            
            'pagination' => $pagination,'listAdverts' => $advert
            ));
    }
    

  public function addAction(Request $request)
  {
    $session = $request->getSession();
    $advert = new Advert();
    $user = $this->getUser();
    $adresse = new Adresse();
      
    $form = $this->get('form.factory')->create(AdvertType::class, $advert);
      
    if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          
        $advert->setUser($user);
        $adresse = $advert->getAdresse();
            
        $em = $this->getDoctrine()->getManager();
        $em->persist($advert);
        $em->flush();

        $session = $request->getSession();
        $session->getFlashBag()->add('info', 'Evénement bien enregistré');

        return $this->redirectToRoute('mp_platform_view', array('id' => $advert->getId()));
      }
    }

    return $this->render('MPPlatformBundle:Advert:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }


  public function editAction($id, Request $request)
  {
    $user = $this->getUser();
    $em = $this->getDoctrine()->getManager();
    $advert = $em->getRepository('MPPlatformBundle:Advert')->find($id);
    //dump($advert);
    if (null === $advert) {
      // throw new NotFoundHttpException("L'événement d'id ".$id." n'existe pas.");
      $request->getSession()->getFlashBag()->add('info', "L'événement d'id ".$id." n'existe pas.");
      return $this->redirect($_SERVER['HTTP_REFERER']);
    }
    if ($user->getId() !== $advert->getUser()->getId()) {
      // throw new NotFoundHttpException("L'événement d'id ".$id." n'existe pas.");
      $request->getSession()->getFlashBag()->add('info', "L'événement d'id ".$id." n'est pas a vous.");
      return $this->redirectToRoute('mp_platform_home');
    }

    $form = $this->get('form.factory')->create(AdvertType::class, $advert);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $adresse = $advert->getAdresse();
      $em->flush();
        
      $request->getSession()->getFlashBag()->add('info', 'événement bien modifié.');

      return $this->redirectToRoute('mp_platform_view', array('id' => $advert->getId()));
    }

    return $this->render('MPPlatformBundle:Advert:edit.html.twig', array(
      'advert' => $advert,
      'form'   => $form->createView(),
    ));
  }

  public function deleteAction(Request $request, $id)
  {
    $user = $this->getUser();
    $em = $this->getDoctrine()->getManager();
    $advert = $em->getRepository('MPPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'événement d'id ".$id." n'existe pas.");
    }
    if ($user->getId() !== $advert->getUser()->getId()) {
      // throw new NotFoundHttpException("L'événement d'id ".$id." n'existe pas.");
      $request->getSession()->getFlashBag()->add('info', "L'événement d'id ".$id." n'est pas a vous.");
      return $this->redirectToRoute('mp_platform_home');
    }

    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->remove($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "L'événement a bien été supprimée.");

      return $this->redirectToRoute('mp_platform_home');
    }
    
    return $this->render('MPPlatformBundle:Advert:delete.html.twig', array(
      'advert' => $advert,
      'form'   => $form->createView(),
    ));
  }

  public function menuAction($limit)
  {
    $em = $this->getDoctrine()->getManager();
    $advert = $em->getRepository('MPPlatformBundle:Advert')->findAll();

    return $this->render('MPPlatformBundle:Advert:menu.html.twig', array(
      'listAdverts' => $advert
    ));
  }
    
  public function viewAction($id,Request $request)
  {
    $repository = $this->getDoctrine()
      ->getManager()
      ->getRepository('MPPlatformBundle:Advert')
    ;

    $advert = $repository->find($id);

    if (null === $advert) {
      // throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
      $request->getSession()->getFlashBag()->add('info', "Désolé, l'événement n'existe pas encore.");
      return $this->redirectToRoute('mp_platform_home');
    }

    return $this->render('MPPlatformBundle:Advert:view.html.twig', array(
      'advert' => $advert
    ));
  }
    
    public function rechercheAction(Request $request)
      {
        $recherche = $request->query->get('_recherche');
        $em = $this->getDoctrine()->getManager()->getRepository('MPPlatformBundle:Advert');
        $advert = $em->findByRecherche($recherche);
        
        return $this->render('MPPlatformBundle:Advert:resultRech.html.twig', array(
                'listAdverts' => $advert
             ));
    }
    
    public function favorisAction(Request $request,$id)
      {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $advert = $em->getRepository('MPPlatformBundle:Advert')->find($id);
        $favoris = $user->getfavoris();
      
            if($favoris->contains($advert)){
                $request->getSession()->getFlashBag()->add('info', 'Supprimé des favoris.');
                $user->removefavori($advert);
            }else{
                $request->getSession()->getFlashBag()->add('info', 'Ajouté aux favoris.');
                $user->addfavori($advert);
            }
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
          
        return $this->redirect($_SERVER['HTTP_REFERER']);
      }
    
    public function mapAction($id,Request $request)
      {
        $repository = $this->getDoctrine()
          ->getManager()
          ->getRepository('MPPlatformBundle:Advert')
        ;
        $cible = $repository->find($id);
        $adverts = $repository->findAll();
        // dump($adverts);

        // foreach ($adverts as $advert){
        //       $adresse = array('adresse'=>array('id'      =>$advert->getId(),
        //                               'title'   =>$advert->getTitle(),
        //                               'content' =>$advert->getContent(),
        //                               'site'    =>$advert->getSite(),
        //                               'lng'     =>$advert->getAdresse()->getLng(),
        //                               'lat'     =>$advert->getAdresse()->getLat(),
        //                               'image'   =>$advert->getImage()
        //                               ));
        // }
        
         $data = $this->get('jms_serializer')->serialize($adverts, 'json');
         $dataCible = $this->get('jms_serializer')->serialize($cible,'json');
        // dump($data);
        return $this->render('MPPlatformBundle:Advert:map.html.twig', array(
          'advert' => $data,
          'cible' => $dataCible

        ));
      }

}

