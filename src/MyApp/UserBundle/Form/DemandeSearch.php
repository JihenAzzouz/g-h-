<?php

namespace MyApp\UserBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DemandeSearch extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       /* $builder->add('typeMaison',ChoiceType::class,array(
            'choices'=>array(
                '...'=>'',
                'Maison'=>'Maison',
                'Appartement'=>'Appartment'

               )))*/
        $builder->add('pays',EntityType::class,array(
        'class'=>'MyApp\UserBundle\Entity\Pays', 'choice_label' =>'libelle','placeholder'=>'choisissez un pays'))
        ->add('ville',EntityType::class,array(
        'class'=>'MyApp\UserBundle\Entity\Ville', 'choice_label' =>'libelleVille','placeholder'=>'choisissez une ville'))
          ;

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyApp\UserBundle\Entity\Demande'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'myapp_userbundle_demande';
    }


}
