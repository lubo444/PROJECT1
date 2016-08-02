<?php

namespace Test\Bundle\CompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Test\Bundle\CompanyBundle\Entity\Week;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Description of OpeningHoursType
 *
 * @author lubomir.ferenc
 */
class OpeningHoursType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $daysInWeek = array_flip(Week::getDaysInWeek());
        
        $builder
                ->add('dayInWeek', ChoiceType::class, [
                    'required' => true,
                    'choices' => $daysInWeek,
                    'choices_as_values' => true]
                )
                ->add('startAt', TextType::class, array('required' => true))
                ->add('lunchStartAt', TextType::class, array('required' => false))
                ->add('lunchEndAt', TextType::class, array('required' => false))
                ->add('endAt', TextType::class, array('required' => true))
                ->add('add', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Test\Bundle\CompanyBundle\Entity\OpeningHours',
            'csrf_protection' => false,
        ));
    }

}
