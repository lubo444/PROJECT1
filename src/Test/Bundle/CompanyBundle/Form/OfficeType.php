<?php

namespace Test\Bundle\CompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Description of OfficeType
 *
 * @author lubomir.ferenc
 */
class OfficeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address', TextType::class, [
            'required' => true,
            'translation_domain' => 'messages'
                ]
        );
        $builder
                ->add('add_edit', SubmitType::class, [
                    'translation_domain' => 'messages',
                    'label' => 'add_edit'
                        ]
                )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Test\Bundle\CompanyBundle\Entity\Office',
        ));
    }

}
