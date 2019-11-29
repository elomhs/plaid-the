<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/room")
 */
class RoomController extends AbstractController
{
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



    /**
     * @Route("/", name="room_index", methods={"GET"})
     */
    public function index(RoomRepository $roomRepository): Response
    {
        return $this->render('room/index.html.twig', [
            'rooms' => $roomRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="room_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $user=$this->getUser();
        $owner=$user->getOwner();
        $room->setOwner($owner);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Change conte-type according to image's
            $imagefile = $room->getImageFile();


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('room_index');
        }

        return $this->render('room/new.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="room_show", methods={"GET"})
     */
    public function show(Room $room): Response
    {
        return $this->render('room/show.html.twig', [
            'room' => $room,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="room_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Room $room): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);
        $user=$this->getUser();
        $ownerRoom=$user->getOwner();
        $owner=$room->getOwner();
        if($ownerRoom->getId() == $owner->getId() ) {
            $this->addFlash("success", "Vous pouvez procéder aux changements");
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('room_index');
            }
        }
        else{
            $this->addFlash("error", "Cette chambre ne vous appartient pas, vous ne pouvez pas l'éditer");
            return $this->redirectToRoute('room_index');
        }
        return $this->render('room/edit.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="room_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Room $room): Response
    {
        $user=$this->getUser();
        $ownerRoom=$user->getOwner();
        $owner=$room->getOwner();
        if($ownerRoom->getId() == $owner->getId() ) {
            if ($this->isCsrfTokenValid('delete' . $room->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($room);
                $entityManager->flush();
            }
            $this->addFlash("success", "Votre chambre a bien été supprimée");
        }
        else {
            $this->addFlash("error", "Cette chambre ne vous appartient pas, vous ne pouvez pas la supprimer");
        }
        return $this->redirectToRoute('room_index');
    }



}
