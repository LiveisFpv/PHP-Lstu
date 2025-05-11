<?php

namespace App\Form;

use App\Entity\Animal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;

class AnimalForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('animalName', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Animal name is required']),
                ],
            ])
            ->add('animalGender', ChoiceType::class, [
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Gender is required']),
                ],
            ])
            ->add('animalAge', IntegerType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Age is required']),
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'Age must be greater than 0',
                    ]),
                ],
            ])
            ->add('animalCage', IntegerType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Cage is required']),
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'Cage must be greater than 0',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
