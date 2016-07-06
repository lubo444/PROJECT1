<?php

namespace Test\Bundle\CompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Test\Bundle\CompanyBundle\Entity\Week;

/**
 * Description of CompanyType
 *
 * @author lubomir.ferenc
 */
class FilterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('GET');
        $builder->add('title', 'text', array('required' => false));
        $builder->add('day', 'choice', array('required' => false, 'choices' => Week::getDaysInWeek()));
        $builder->add('hour', 'text', array('required' => false));
        
        $builder->add('filter', 'submit');
    }

    public function getName()
    {
        return 'filter';
    }

}
