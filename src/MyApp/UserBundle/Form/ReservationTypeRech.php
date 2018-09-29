<?php

namespace MyApp\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationTypeRech extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateDebut', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
            'widget' => 'single_text'
        ])->add('dateFin', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
            'widget' => 'single_text'
        ])->add('Rechercher',SubmitType::class);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyApp\UserBundle\Entity\Reservation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'myapp_userbundle_reservation';
    }



}
