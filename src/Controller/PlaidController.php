<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlaidController extends AbstractController
{
    /**
     * @Route("/plaid", name="plaid")
     */
    public function index()
    {
        return $this->render('plaid/index.html.twig', [
            'controller_name' => 'PlaidController',
            'salut' => "Salut tout le monde",
        ]);
    }
    /**
     * @Route("/", name="origine")
     */
    public function rene()
    {
        return $this->redirectToRoute("plaid");
    }
}
