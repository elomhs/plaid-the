<?php

namespace App\Controller;

use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    /**
     * @Route("/room", name="room")
     */
    public function index()
    {
        return $this->render('room/index.html.twig', [
            'controller_name' => 'RoomController',
        ]);
    }
    /**
     * Affiche la liste de toutes les rooms dans le désordre.
     * @Route("/listerooms", name="listerooms")
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listRooms()
    {
        $rooms = $this->getDoctrine()->getManager()->getRepository(Room::class)->findAll();

        return $this->render("room/index.html.twig", array(
            'rooms' => $rooms,
            'nbrooms' => count($rooms),
        ));
    }
}
