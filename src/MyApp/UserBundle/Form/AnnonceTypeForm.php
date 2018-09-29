<?php

namespace MyApp\UserBundle\Form;

use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use MyApp\UserBundle\Entity\Annonce;

class AnnonceTypeForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch ($options['flow_step']) {
            case 1 :
                $builder->add('typeMaison', ChoiceType::class, array(

                    'choices' => array(

                        'Appartement' => 'Appartement',
                        'Maison' => 'Maison',

                    )
                ))->add('typeLogement', ChoiceType::class, array(

                    'choices' => array(

                        'Chambre double' => 'Chambre double',
                        'Chambre partagee' => 'Chambre partagee',


                    )
                ))->add('nombreChambre' ,ChoiceType::class, array(

                'choices' => array(

                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                    )))->add('nombreSalleDebain',ChoiceType::class, array(

                    'choices' => array(

                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10',
                    )))->add('nombreVoyageur',ChoiceType::class, array(

                    'choices' => array(

                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10',
                    )))->add('nbreLit',ChoiceType::class, array(

                    'choices' => array(

                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10',
                    )));
                break;
            case 2 :

                $builder->add('idPays')->add('ville')->add('adresse')->add('batiment')->add('codePostal')->add('longitude',HiddenType::class)->add('altitude',HiddenType::class);

                break;
            case 3:
                $builder->add('file1', FileType::class)->add('file2', FileType::class)->add('file3', FileType::class);
                break;

            case 4:

                $builder->add('description')->add('dateDebut', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                    'widget' => 'single_text',
                ])->add('dateFin', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                    'widget' => 'single_text'
                ])->add('prix');
                break;

        }




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
