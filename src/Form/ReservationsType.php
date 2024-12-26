<?php

namespace App\Form;

use App\Entity\Enseignants;
use App\Entity\Matieres;
use App\Entity\Promotions;
use App\Entity\Reservations;
use App\Entity\Salles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
                'label' => 'Date : ',
            ])
            ->add('heure_debut', null, [
                'widget' => 'single_text',
                'label' => 'Heure de début : ',
            ])
            ->add('heure_fin', null, [
                'widget' => 'single_text',
                'label' => 'Heure de fin : ',
            ])
            ->add('enseignant', EntityType::class, [
                'class' => Enseignants::class,
                'choice_label' => function (Enseignants $enseignant) {
                    return $enseignant->getPrenomEnseignant() . ' ' . $enseignant->getNomEnseigant();
                },
                'label' => 'Enseignant : ',])
            ->add('promotion', EntityType::class, [
                'class' => Promotions::class,
                'choice_label' => function (Promotions $promotion) {
                    return $promotion->getNiveauPromotion() . ' ' . $promotion->getIntituleFormation().' : '.$promotion->getNbEtudiants().' élèves';
                },
                'label' => 'Promotion : ',
            ])
            ->add('matiere', EntityType::class, [
                'class' => Matieres::class,
                'choice_label' =>function (Matieres $matiere) {
                    return $matiere->getNomMatiere() . ' : ' . $matiere->getDureeMinute().' minutes';
                },
                'label' => 'Matiere : ',
            ])
            ->add('salle', EntityType::class, [
                'class' => Salles::class,
                'choice_label' => function (Salles $salle) {
                    return $salle->getNomSalle() . ' : ' . $salle->getCapacite().' places';
                },
                'label' => 'Salle : ',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
