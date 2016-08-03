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
class OpeningHoursType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $daysInWeek = array_flip(Week::getDaysInWeek());

        $builder
                ->add('dayInWeek', ChoiceType::class, [
                    'required' => true,
                    'choices' => $daysInWeek,
                    'choices_as_values' => true,
                    'translation_domain' => 'messages',
                    'label' => 'day_in_week'
                        ]
                )
                ->add('startAt', TextType::class, [
                    'required' => true,
                    'translation_domain' => 'messages',
                    'label' => 'start_at'
                        ]
                )
                ->add('lunchStartAt', TextType::class, [
                    'required' => false,
                    'translation_domain' => 'messages',
                    'label' => 'lunch_starts_at'
                        ]
                )
                ->add('lunchEndAt', TextType::class, [
                    'required' => false,
                    'translation_domain' => 'messages',
                    'label' => 'lunch_ends_at'
                        ]
                )
                ->add('endAt', TextType::class, [
                    'required' => true,
                    'translation_domain' => 'messages',
                    'label' => 'end_at'
                        ]
                )
                ->add('add_edit', SubmitType::class, [
                    'translation_domain' => 'messages',
                    'label' => 'day_in_week',
                    'label' => 'add_edit'
                        ]
                )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Test\Bundle\CompanyBundle\Entity\OpeningHours',
            'csrf_protection' => false,
        ));
    }

}
