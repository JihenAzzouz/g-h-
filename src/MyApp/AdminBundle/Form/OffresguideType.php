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

class OffresguideType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')->add('descriptif',TextareaType::class)
            ->add('tensionElectricite')->add('langue')->add('capitale')
            ->add('population')
            ->add('monnaie',ChoiceType::class,array(
                'choices'=>array(
                    'AED - United Arab Emirates Dirham'=>'AED',
                    'AUD - Australian Dollar'=>'AUD',
                    'BGN - Bulgarian Lev'=>'BGN',
                    'BRL - Brazilian Real'=>'BRL',
                    'CAD - Canadian Dollar'=>'CAD',
                    'CHF - Switzerland Franc'=>'CHF',
                    'DKK - Danish Krone'=>'DKK',
                    'EUR - EU Euro'=>'EUR',
                    'GBP - British Pound'=>'GBP',
                    'HUF - Hungarian Forint'=>'HUF',
                    'INR - Indian Rupee'=>'INR',
                    'JPY - Japanese Yen'=>'JPY',
                    'MAD - Moroccan Dirham'=>'MAD',
                    'MXN - Mexican Peso'=>'MXN',
                    'MYR - Malaysian Ringgit'=>'MYR',
                    'NGN - Nigerian Naira'=>'NGN',
                    'NOK - Norwegian Krone'=>'NOK',
                    'PLN - Polish Zloty'=>'PLN',
                    'RON - Romanian Leu'=>'RON',
                    'RUB - Russian Ruble'=>'RUB',
                    'SEK - Swedish Krona'=>'SEK',
                    'SGD - Singapore Dollar'=>'SGD',
                    'TND - Tunisia Dinar'=>'TND',
                    'TWD - Taiwanese Dollar'=>'TWD',
                    'USD - US Dollar'=>'USD',
                    'ZAR - South African Rand'=>'ZAR')))

            ->add('frequenceElectricite')
            ->add('idVille',EntityType::class,array('class'=>'MyApp\UserBundle\Entity\Ville','choice_label'=>'libelleVille'))
            ->add('idPays',EntityType::class,array('class'=>'MyApp\UserBundle\Entity\Pays','choice_label'=>'libelle'))
                ->add('file',FileType::class) ->add('continent',ChoiceType::class,array(
                'choices'=>array(
                    'Europe'=>'Europe',
                    'Amérique du sud'=>'Amérique du sud',
                    'Amérique du nord'=>'Amérique du nord','Asie'=>'Asie','Afrique'=>'Afrique'
                ,'Océanie'=>'Océanie')))->add('Valider',SubmitType::class);
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
