<?php

namespace MyApp\AdminBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffresguideRecherche extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idPays',EntityType::class,array('class'=>'MyApp\UserBundle\Entity\Pays','choice_label'=>'libelle'))
            ->add('continent',ChoiceType::class,array(
                'choices'=>array(
                    'Europe'=>'Europe',
                    'Amérique du sud'=>'Amérique du sud',
                    'Amérique du nord'=>'Amérique du nord','Asie'=>'Asie','Afrique'=>'Afrique'
                ,'Océanie'=>'Océanie')));

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyApp\AdminBundle\Entity\Offresguide'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'myapp_adminbundle_offresguide';
    }


}
