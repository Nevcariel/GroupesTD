<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
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

        return $this->redirect($this->generateUrl('app_homepage'));
    }
}
