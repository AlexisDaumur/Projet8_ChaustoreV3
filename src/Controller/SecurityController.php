<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\Common\Persistence\ObjectManager;




class SecurityController extends AbstractController
{
  /**
   * @var ObjectManager
   */
  private $em;
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
    public function account(ObjectManager $em)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $user->setRoles ([
          'ROLE_USER',
        ]);
        $em->persist($user);
        $em->flush();
        return $this->render('security/account.html.twig');
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
      $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous devez être administrateur pour avoir accès à cette page.');
      return $this->render('admin/home/index.html.twig');
    }
}
