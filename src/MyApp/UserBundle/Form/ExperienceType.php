<?php

namespace MyApp\UserBundle\Form;

use Doctrine\ORM\Query\Expr\Select;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExperienceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
            ->add('description')
            ->add('idPays')
            ->add('idVille')
            ->add('file', FileType::class, array('attr' => array('id'=>'file')))
            ->add('file1', FileType::class)
            ->add('file2', FileType::class)
            ->add('file3', FileType::class)
            ->add('file4', FileType::class)
            //  ->add('i1',FileType::class)
            // ->add('idUser')
            // ->add('file')
            //          ->add('cp',null, array('attr' => array('class' => 'cp',
            //           'maxlength' => 5)))
            //  ->add('ville',null, array('attr' => array('class' => 'ville')))
        ;

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyApp\UserBundle\Entity\Experience'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'guestandhost_guestandhostbundle_experience';
    }


}
