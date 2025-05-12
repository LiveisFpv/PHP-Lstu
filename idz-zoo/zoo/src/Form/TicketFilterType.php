<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ticketDate', DateType::class, [
                'required' => false,
                'label' => 'Ticket Date',
                'widget' => 'single_text',
            ])
            ->add('ticketTime', TextType::class, [
                'required' => false,
                'label' => 'Ticket Time',
            ])
            ->add('ticketCost', TextType::class, [
                'required' => false,
                'label' => 'Ticket Cost',
            ])
            ->add('userEmail', TextType::class, [
                'required' => false,
                'label' => 'User Email',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
