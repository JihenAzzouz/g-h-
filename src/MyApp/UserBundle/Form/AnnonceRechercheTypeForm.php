<?php

namespace MyApp\UserBundle\Form;

use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use MyApp\UserBundle\Entity\Annonce;

class AnnonceRechercheTypeForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

                $builder->add('typeMaison' ,ChoiceType::class, array(

                    'choices' => array(
                        ''=>'',
                        'Appartement' => 'Appartement',
                        'Maison' => 'Maison',

                    ),
                        'required'    => false,
                    )
                )->add('typeLogement', ChoiceType::class, array(

                    'choices' => array(
                        ''=>'',
                        'Chambre double' => 'Chambre double',
                        'Chambre partagee' => 'Chambre partagee',

                    ),
                        'required'    => false,

                    )
                )->add('nbreLit')->add('nombreVoyageur')->add('idPays')->add('ville')->add('prix')->add('dateDebut',\Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                    'widget' => 'single_text',
                    'required'  => false
                ])->add('dateFin',\Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                    'widget' => 'single_text',
                    'required'  => false
                ])
->add('rechercher',SubmitType::class);



    }

    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyApp\UserBundle\Entity\Annonce'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'AnnonceType';
    }


}
