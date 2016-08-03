<?php

namespace Test\Bundle\CompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Description of CompanyType
 *
 * @author lubomir.ferenc
 */
class FilterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $builder->getData();
        $daysChoices = array_merge(["" => NULL], array_flip($data['daysInWeek']));

        $builder
                ->setMethod('GET')
                ->add('title', TextType::class, ['required' => false])
                ->add('day', ChoiceType::class, [
                    'required' => true,
                    'choices' => $daysChoices,
                    'choices_as_values' => true,
                    'choice_translation_domain' => 'messages'
                        ]
                )
                ->add('hour', TextType::class, [
                    'required' => false,
                    'translation_domain' => 'messages'
                        ]
                )
                ->add('filter', SubmitType::class, [
                    'translation_domain' => 'messages'
                        ]
                )
        ;
    }

}
