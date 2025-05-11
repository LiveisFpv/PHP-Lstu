<?php

namespace App\Form;

use App\Entity\Care;
use Dom\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CareForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('careType',TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Care type is required']),
                ],
            ])
            ->add('animalName',TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Animal name is required']),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Care::class,
        ]);
    }
}
