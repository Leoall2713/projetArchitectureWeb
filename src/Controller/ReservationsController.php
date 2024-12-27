<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Entity\Promotions;
use App\Entity\Salles;
use App\Form\ReservationsType;
use App\Repository\ReservationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


#[Route('/reservations')]
final class ReservationsController extends AbstractController
{
    #[Route(name: 'app_reservations_index', methods: ['GET', 'POST'])]
    public function index(Request $request, ReservationsRepository $reservationsRepository): Response
    {
        $form = $this->createFormBuilder()
            ->add('promotion', EntityType::class, [
                'class' => Promotions::class,
                'choice_label' => 'intituleFormation',
                'placeholder' => 'Toutes les promotions',
                'required' => false,
            ])
            ->add('salle', EntityType::class, [
                'class' => Salles::class,
                'choice_label' => 'nomSalle',
                'placeholder' => 'Toutes les salles',
                'required' => false,
            ])
            ->getForm();

        $form->handleRequest($request);

        $promotion = null;
        $salle = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $promotion = $form->get('promotion')->getData();
            $salle = $form->get('salle')->getData();
        }

        $reservations = $reservationsRepository->findByFilters($promotion, $salle);

        return $this->render('reservations/index.html.twig', [
            'reservations' => $reservations,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_reservations_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, ReservationsRepository $reservationsRepository): Response
{
    $reservation = new Reservations();
    $form = $this->createForm(ReservationsType::class, $reservation);
    $form->handleRequest($request);

    // On verifie si le formulaire est envoyé
    if ($form->isSubmitted() && $form->isValid()) {
        // On récupère toutes les variables dont nous avons besoin avec les méthodes get que l'on a dans entity
        $enseignant = $reservation->getEnseignant();
        $promotion = $reservation->getPromotion();
        $salle = $reservation->getSalle();
        $date = new \DateTime($reservation->getDate()->format('Y-m-d'));
        $heureDebut = $reservation->getHeureDebut();
        $heureFin = $reservation->getHeureFin();
        $nbEtudiants = $promotion->getNbEtudiants();
        $capacite = $salle->getCapacite();
        $matiere = $reservation->getMatiere();
        $dureeMinutes = $matiere->getDureeMinute();

        // On récupère les minutes entre les deux heures que nous avons mis
        $minutes = $heureDebut->diff($heureFin);
        $minutes = ($minutes->h * 60) + $minutes->i;

        // On vérifie que l'heure du début est inférieur à celle de fin sinon erreur
        if ($heureDebut >= $heureFin) {
            $this->addFlash('error', 'L\'heure du début est supérieure ou égale à l\'heure de fin.');
            return $this->redirectToRoute('app_reservations_new');
        }

        // On vérifie que la réservation est supérieur à 1h
        if ($minutes < 60) {
            $this->addFlash('error', 'La réservation doit être pour une durée d\'au moins 1 heure.');
            return $this->redirectToRoute('app_reservations_new');
        }

        // Partie pour vérifier que le même enseignant ne soit pas deux fois sur le même créneau
        $enseignantReservation = $reservationsRepository->findOneBy([
            'enseignant' => $enseignant,
            'date' => $date,
        ]);

        if ($enseignantReservation) {
            $enseignantHeureDebut = $enseignantReservation->getHeureDebut();
            $enseignantHeureFin = $enseignantReservation->getHeureFin();

            if (($heureDebut < $enseignantHeureFin) && ($heureFin > $enseignantHeureDebut)) {
                $this->addFlash('error', 'L\'enseignant n\'est pas disponible pour ce créneau horaire.');
                return $this->redirectToRoute('app_reservations_new');
            }
        }

        // Partie pour vérifier que la même promotion ne soit pas deux fois sur le même créneau
        $promoReservation = $reservationsRepository->findOneBy([
            'promotion' => $promotion,
            'date' => $date,
        ]);

        if ($promoReservation) {
            $promoHeureDebut = $promoReservation->getHeureDebut();
            $promoHeureFin = $promoReservation->getHeureFin();

            if (($heureDebut < $promoHeureFin) && ($heureFin > $promoHeureDebut)) {
                $this->addFlash('error', 'La promotion n\'est pas disponible pour ce créneau horaire.');
                return $this->redirectToRoute('app_reservations_new');
            }
        }

        // Partie pour vérifier que la même salle ne soit pas deux fois sur le même créneau
        $salleReservation = $reservationsRepository->findOneBy([
            'salle' => $salle,
            'date' => $date,
        ]);

        if ($salleReservation) {
            $salleHeureDebut = $salleReservation->getHeureDebut();
            $salleHeureFin = $salleReservation->getHeureFin();

            if (($heureDebut < $salleHeureFin) && ($heureFin > $salleHeureDebut)) {
                $this->addFlash('error', 'La salle n\'est pas disponible pour ce créneau horaire.');
                return $this->redirectToRoute('app_reservations_new');
            }
        }

        // On vérifie que le nombre d'étudiants ne dépasse pas la capacité de la salle que l'on a choisi sinon erreur
        if ($nbEtudiants > $capacite) {
            $this->addFlash('error', 'La salle ne dispose pas d\'assez de places pour cette promotion.');
            return $this->redirectToRoute('app_reservations_new');
        }

        // On vérifie que la matière et la réservation ont la même durée sinon erreur
        if ($dureeMinutes != $minutes) {
            $this->addFlash('error', 'Le temps de la matière ne correspond pas au créneau horaire.');
            return $this->redirectToRoute('app_reservations_new');
        }

        // On part du principe que la faculté ouvre ses portes à 8h et les fermes à 20h
        // On fait donc en sorte que si l'heure du début>8h et l'heure de fin<20h sinon erreur
        $heureDebutSeul = $heureDebut->format('H:i');
        $heureFinSeul = $heureFin->format('H:i');
        if ($heureDebutSeul < '08:00') {
            $this->addFlash('error', 'Les salles ouvrent à 8h');
            return $this->redirectToRoute('app_reservations_new');
        }
        if ($heureFinSeul > '20:00') {
            $this->addFlash('error', 'Les salles ferment à 20h');
            return $this->redirectToRoute('app_reservations_new');
        }


        // Si toutes les conditions qu'on a fait précédemment sont bonnes alors ça créer la ligne et l'ajoute à la table réservation
        $entityManager->persist($reservation);
        $entityManager->flush();

        return $this->redirectToRoute('app_reservations_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('reservations/new.html.twig', [
        'reservation' => $reservation,
        'form' => $form,
    ]);
}

    // Partie pour voir chaque réservation en détail
    #[Route('/{id}', name: 'app_reservations_show', methods: ['GET'])]
    public function show(Reservations $reservation): Response
    {
        return $this->render('reservations/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    // Partie pour sup les réservations
    #[Route('/{id}', name: 'app_reservations_delete', methods: ['POST'])]
    public function delete(Request $request, Reservations $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservations_index', [], Response::HTTP_SEE_OTHER);
    }

    
    
}
