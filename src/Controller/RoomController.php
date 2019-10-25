<?php

namespace App\Controller;

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
     * Affiche la liste de toutess les rooms dans le désordre.
     * @Route("/listerooms", name="listerooms")
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listRooms()
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Liste des chambres</title>
    </head>
    <body>
        <h1>rooms list</h1>
        <p>Voici la liste des chambres:</p>
        <ul>';

        $rooms = $this->getDoctrine()->getRepository('App:Room')->findAll();

        foreach($rooms as $room) {
            $htmlpage .= '<li>
            <a href="">'.$room->getSummary() . ' [' . $room->getDescription() . ']' . $room->getId() . '</a></li>';
        }
        $htmlpage .= '</ul>';

        $htmlpage .= '</body></html>';

        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
        return $this->render(':room:index.html.twig',[
            'rooms'=>$rooms,
        ]);
    }
}
