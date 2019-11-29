<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Room;
use App\Entity\User;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/{id}", name="reservation_index", methods={"GET"} , requirements={"id": "\d+"})
     */
    public function index(ReservationRepository $reservationRepository, Room $reservation): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findByReservation($reservation),
            "reservation" => $reservation,
        ]);
//        return $this->redirectToRoute('room_index');
    }

    /**
     * @Route("/new/{id}",requirements={"id":"\d+"}, name="reservation_new", methods={"GET","POST"})
     */
    public function new(Request $request, Room $room): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        $reservation->setReservation($room);
        $user=$this->getUser();
        $client=$user->getClient();
        $reservation->setClients($client);



        if ($form->isSubmitted() && $form->isValid()) {
            $reservation = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $reservations = $entityManager->getRepository(Reservation::class);
            $conflit = $reservations->createQueryBuilder("r")
            ->where("r.reservation = :room AND NOT (:dateDebut < r.dateDebut OR :dateDebut > r.dateFin OR r.dateFin < :dateDebut OR r.dateDebut > :dateFin)")
            ->setParameter("dateDebut", $reservation->getDateDebut())
            ->setParameter("dateFin", $reservation->getDateFin())
            ->setParameter("room", $room)
                ->getQuery()->getResult();


            if(count($conflit) > 0) {
            $this->addFlash("error","Une réservation est impossible sur cette période");
            return $this->redirectToRoute('room_index');

            }

            $entityManager->persist($reservation);
            $entityManager->flush();
            $this->addFlash("success","Votre réservation est validée!");
            return $this->redirectToRoute('room_index');
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_index');
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_index');
    }
}
