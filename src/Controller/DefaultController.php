<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
    * @Route("/", name="app_homepage")
    */
    public function index() 
    {
        return $this->redirectToRoute('etudiant_liste_groupes');
    }

}
