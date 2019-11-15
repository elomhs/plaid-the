<?php

namespace App\Controller;

use App\Entity\Region;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RegionController extends AbstractController
{
    /**
     * @Route("/region", name="region")
     */
    public function index()
    {
        return $this->render('region/index.html.twig', [
            'controller_name' => 'RegionController',
        ]);
    }
    /**
     * Affiche la liste de toutes les régions
     * @Route("/listeregions", name="listeregions")
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listRegions(){
        $regions = $this->getDoctrine()->getManager()->getRepository(Region::class)->findAll();

        return $this->render("region/index.html.twig", array(
            'regions' => $regions,
            'nbregions' => count($regions),
        ));
    }
}
