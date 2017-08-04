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
    $em = $this->getDoctrine()->getManager()->getRepository('MPPlatformBundle:Advert');
        
    $advert = $em->findByDate();

        return $this->render('MPPlatformBundle:Advert:index.html.twig', array(
                'listAdverts' => $advert
             ));
    }
    

  public function addAction(Request $request)
  {
 
    $advert = new Advert();
    $user = $this->getUser();
    $adresse = new Adresse();
      
    $form = $this->get('form.factory')->create(AdvertType::class, $advert);
      
    if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          
        $advert->setUser($user);
        $advert->getImage()->upload();
        $adresse = $advert->getAdresse();
            
        $em = $this->getDoctrine()->getManager();
        $em->persist($advert);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

        return $this->redirectToRoute('mp_platform_view', array('id' => $advert->getId()));
      }
    }

    return $this->render('MPPlatformBundle:Advert:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }


  public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository('MPPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'événement d'id ".$id." n'existe pas.");
    }

    $form = $this->get('form.factory')->create(AdvertEditType::class, $advert);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      // Inutile de persister ici, Doctrine connait déjà notre annonce
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'événement bien modifiée.');

      return $this->redirectToRoute('mp_platform_view', array('id' => $advert->getId()));
    }

    return $this->render('MPPlatformBundle:Advert:edit.html.twig', array(
      'advert' => $advert,
      'form'   => $form->createView(),
    ));
  }

  public function deleteAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();

    $advert = $em->getRepository('MPPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'événement d'id ".$id." n'existe pas.");
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
    
  public function viewAction($id)
  {
    $repository = $this->getDoctrine()
      ->getManager()
      ->getRepository('MPPlatformBundle:Advert')
    ;

    $advert = $repository->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
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

        return $this->render('MPPlatformBundle:Advert:index.html.twig', array(
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
                $user->removefavori($advert);
            }else{
                $user->addfavori($advert);
            }
        

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Ajouté au favoris.');

          
        return $this->redirect($_SERVER['HTTP_REFERER']);
      }


}

