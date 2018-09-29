<?php

namespace MyApp\UserBundle\Form;

use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use MyApp\UserBundle\Entity\Annonce;

class AnnonceTypeModifier extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

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
                ))->add('nombreSalleDebain')->add('nombreVoyageur')->add('nbreLit')

              ->add('idPays')->add('ville')->add('adresse')->add('batiment')->add('codePostal')



  ->add('description')->add('dateDebut', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                    'widget' => 'single_text',
                ])->add('dateFin', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                    'widget' => 'single_text'
                ])->add('prix')

                ->add('file1', FileType::class)->add('file2', FileType::class)->add('file3', FileType::class)->add('ajouter',SubmitType::class);





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
