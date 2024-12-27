<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(): Response
    {
        return $this->render('app/HomePage.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
        /**
         * @Route("/accueil_user", name="accueil_User")
         */
        public function indexUser(): Response
        {
            return $this->render('app/HomePage_User.html.twig', [
                'controller_name' => 'AccueilController',
            ]);
        }
    /**
     * @Route("/accueil_cand", name="accueil_Cand")
     */
    public function indexCand(): Response
    {
        return $this->render('app/HomePage_Freelance.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
    /**
     * @Route("/accueil_format", name="accueil_Form")
     */
    public function indexForm(): Response
    {
        return $this->render('app/HomePage_Client.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
    /**
     * @Route("/accueil_admin", name="accueil_Admin")
     */
    public function indexAdmin(): Response
    {
        return $this->render('app/HomePage_Admin.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
}
