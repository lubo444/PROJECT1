<?php

namespace Test\Bundle\CompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Description of RestOfficeType
 *
 * @author lubomir.ferenc
 */
class RestOfficeType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address', TextType::class, array('required' => true));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Test\Bundle\CompanyBundle\Entity\Office',
            'csrf_protection' => false,
        ));
    }

}
