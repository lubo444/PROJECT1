<?php

namespace Test\Bundle\CompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Test\Bundle\CompanyBundle\Entity\Week;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Description of RestOpeningHoursType
 *
 * @author lubomir.ferenc
 */
class RestOpeningHoursType extends AbstractType
{

    private $method;

    public function __construct($method = null)
    {
        $this->method = $method;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $required = true;
        $daysInWeek = Week::getDaysInWeek();
        $daysChoices = array_flip($daysInWeek);

        if ($this->method == 'PUT') {
            $required = false;
            $builder->addEventListener(
                    FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $this->onPreSubmit($event);
            }
            );
        }

        $builder
                ->add('dayInWeek', ChoiceType::class, [
                    'required' => true,
                    'choices' => $daysChoices,
                    'choices_as_values' => true]
                )
                ->add('startAt', TextType::class, array('required' => true))
                ->add('lunchStartAt', TextType::class, array('required' => false))
                ->add('lunchEndAt', TextType::class, array('required' => false))
                ->add('endAt', TextType::class, array('required' => true));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Test\Bundle\CompanyBundle\Entity\OpeningHours',
            'csrf_protection' => false,
        ));
    }

    /**
     * remove not filled items from form, required for PUT method
     * @param FormEvent $event
     */
    public function onPreSubmit(FormEvent $event)
    {
        $params = $event->getData();

        if (!isset($params['lunchStartAt'])) {
            $event->getForm()->remove('lunchStartAt');
        }

        if (!isset($params['lunchEndAt'])) {
            $event->getForm()->remove('lunchEndAt');
        }

        if (!isset($params['startAt'])) {
            $event->getForm()->remove('startAt');
        }

        if (!isset($params['endAt'])) {
            $event->getForm()->remove('endAt');
        }

        if (!isset($params['dayInWeek'])) {
            $event->getForm()->remove('dayInWeek');
        }
    }

}
