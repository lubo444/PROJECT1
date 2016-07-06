<?php

namespace Test\Bundle\CompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Test\Bundle\CompanyBundle\Entity\Week;

/**
 * Description of OpeningHoursType
 *
 * @author lubomir.ferenc
 */
class OpeningHoursType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('dayInWeek', 'choice', array('choices' => Week::getDaysInWeek()));
        $builder->add('startAt', 'text', array('required' => true));
        $builder->add('lunchStartAt', 'text', array('required' => false));
        $builder->add('lunchEndAt', 'text', array('required' => false));
        $builder->add('endAt', 'text', array('required' => true));
        $builder->add('add', 'submit');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Test\Bundle\CompanyBundle\Entity\OpeningHours',
        ));
    }

    public function getName()
    {
        return 'openingHours';
    }

}
