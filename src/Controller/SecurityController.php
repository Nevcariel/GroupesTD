<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Entity\Etudiant;
use App\Entity\Enseignant;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends Controller
{
    /**
     * @Route("/login/professionnel", name="login_professionnel")
     */
    public function loginproAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $loginForm = $this->createForm(LoginType::class, [
            'username' => $lastUsername,
        ]);

        return $this->render('security/professionnel/login.html.twig', array(
                'loginForm' => $loginForm->createView(),
                'error' => $error,
            )
        );
    }
    
    /**
     * @Route("/login", name="login")
     */
    public function loginAction() {
        $target = urlencode($this->container->getParameter('cas_login_target'));
        $url = 'https://'.$this->container->getParameter('cas_host') . '/login?service=';

        return $this->redirect($url . $target . '/force');
    }


    /**
    * @Route("/force", name="force")
    */
    public function forceAction() {

        if (!isset($_SESSION)) {
                session_start();
        }

        session_destroy();

        return $this->redirect($this->generateUrl('etudiant_liste_groupes'));
    }
    
}