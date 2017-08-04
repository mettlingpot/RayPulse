<?php
namespace MP\UserBundle\Controller;

use MP\PlatformBundle\Entity\Adresse;
use MP\PlatformBundle\Entity\Advert;
use MP\UserBundle\Entity\User;
use MP\UserBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;


class UserController extends Controller
{
    
        public function registerAction(Request $request)
        {

        $user = new User();

        $formUser   = $this->get('form.factory')->create(UserType::class, $user);
        $adresse = new Adresse();
        $favoris = new ArrayCollection();
        
        if ($request->isMethod('POST')) {
          $formUser->handleRequest($request);

          if ($formUser->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Bienvenue');
            return $this->redirectToRoute('login');
          }
        }

        return $this->render('MPUserBundle:Default:index.html.twig', array(
          'formUser' => $formUser->createView(),
        ));
      }
    
      public function profilAction(Request $request)
      {
        $user = $this->getUser();
        $userId = $user->getId();
        $favoris = $user->getFavoris();
          
        $repository = $this->getDoctrine()
        ->getManager()
        ->getRepository('MPPlatformBundle:Advert')
        ;

        $advert = $repository->findByUser($userId);

          if (null === $user) {
            return $this->redirectToRoute('mp_user_register');
          } 
          else {
              
            return $this->render('MPUserBundle:User:profil.html.twig', array(
            'listAdverts' => $advert, 'listFavoris' => $favoris
             ));
          }
              
      }
  
}
        


