<?php

namespace MyApp\UserBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use MyApp\UserBundle\Entity\Annonce;

class AnnonceFlow extends FormFlow
{

protected function loadStepsConfig() {
return array(
array(
'label' => 'wheels',
'form_type' => 'MyApp\UserBundle\Form\AnnonceTypeForm',
),
array(
'label' => 'engine',
'form_type' =>'MyApp\UserBundle\Form\AnnonceTypeForm',
),
    array(
        'label' => 'engine',
        'form_type' =>'MyApp\UserBundle\Form\AnnonceTypeForm',
        'skip' => function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
            return $estimatedCurrentStepNumber > 1 && !$flow->getFormData();
        },
), array(
        'label' => 'engine',
        'form_type' =>'MyApp\UserBundle\Form\AnnonceTypeForm',
        'skip' => function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
            return $estimatedCurrentStepNumber > 1 && !$flow->getFormData();
        },
    ),

array(
'label' => 'confirmation',
),
);
}

}