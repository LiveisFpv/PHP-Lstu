<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\CallbackTransformer;

class TicketForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ticketDate', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Date is required.']),
                    new Callback([$this, 'validateFutureDate']),
                ]
            ])
            ->add('ticketTime', ChoiceType::class, [
                'choices' => $this->generateTimeChoices(),
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Time is required.']),
                ],
            ])
            ->add('ticketCost', NumberType::class, [
                'data' => 100,
                'attr' => ['readonly' => true],
            ])
            ->add('userEmail', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Email is required.']),
                    new Assert\Email(['message' => 'Please provide a valid email.'])
                ]
            ])
            ->add('cardNumber', TextType::class, [
                'mapped' => false,
                'label' => 'Card Number',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Card number is required.']),
                    new Assert\Regex([
                        'pattern' => '/^\d{4}\s\d{4}\s\d{4}\s\d{4}$/',
                        'message' => 'Card number must be 16 digits.'
                    ])
                ]
            ])
            ->add('cardExpiry', TextType::class, [
                'mapped' => false,
                'label' => 'Expiry Date (MM/YY)',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Expiry date is required.']),
                    new Assert\Regex([
                        'pattern' => '/^(0[1-9]|1[0-2])\/\d{2}$/',
                        'message' => 'Expiry date must be in MM/YY format.'
                    ]),
                    new Callback([$this, 'validateExpiryDate']),
                ]
            ])
            ->add('cardCVV', TextType::class, [
                'mapped' => false,
                'label' => 'CVV',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'CVV is required.']),
                    new Assert\Regex([
                        'pattern' => '/^\d{3}$/',
                        'message' => 'CVV must be 3 digits.'
                    ])
                ]
            ]);
            $builder->get('ticketTime')->addModelTransformer(new CallbackTransformer(
                function ($time) {
                    // Transform DateTime to string
                    return $time instanceof \DateTime ? $time->format('H:i') : $time;
                },
                function ($time) {
                    // Transform string to DateTime
                    return \DateTime::createFromFormat('H:i', $time) ?: null;
                }
            ));
    }

    public function validateFutureDate($date, ExecutionContextInterface $context): void
    {
        if ($date < new \DateTime('today')) {
            $context->buildViolation('Date must be today or in the future.')
                ->addViolation();
        }
    }

    public function validateTimeRange($time, ExecutionContextInterface $context): void
    {
        if (!$time instanceof \DateTime) {
            $context->buildViolation('Invalid time format.')
                ->addViolation();
            return;
        }

        $hour = (int)$time->format('H');
        $minute = (int)$time->format('i');

        if ($hour < 9 || $hour > 16 || ($hour === 16 && $minute > 45)) {
            $context->buildViolation('Time must be between 09:00 and 17:00 with 15-minute steps.')
                ->addViolation();
        }

        if ($minute % 15 !== 0) {
            $context->buildViolation('Time must be in 15-minute intervals.')
                ->addViolation();
        }
    }

    public function validateExpiryDate($value, ExecutionContextInterface $context): void
    {
        if (!preg_match('/^(0[1-9]|1[0-2])\/(\d{2})$/', $value, $matches)) {
            return;
        }

        [$all, $month, $year] = $matches;
        $expiry = \DateTime::createFromFormat('m/y', $month . '/' . $year);
        $expiry->modify('last day of this month')->setTime(23, 59, 59);

        if ($expiry < new \DateTime()) {
            $context->buildViolation('Card expiry date must be in the future.')
                ->addViolation();
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
    private function generateTimeChoices(): array
    {
        $choices = [];
        for ($hour = 9; $hour <= 16; $hour++) {
            foreach ([0, 15, 30, 45] as $minute) {
                $time = sprintf('%02d:%02d', $hour, $minute);
                $choices[$time] = $time;
            }
        }
        $choices['17:00'] = '17:00';
        return $choices;
    }
    
}