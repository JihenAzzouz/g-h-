<?php

namespace MyApp\UserBundle\Form;

use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use MyApp\UserBundle\Entity\Annonce;

class AnnonceRechercheMap extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

                $builder
                    ->add('longitude')->add('altitude')->add('idPays')->add('rechercher',SubmitType::class);




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
