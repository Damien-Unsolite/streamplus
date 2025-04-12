<?php

namespace App\Form;

use App\Entity\User;
use App\Form\AddressType;
use App\Form\SubscriptionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'First name *',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Last name *',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email address *',
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Phone number *',
                'required' => true,
            ])
            ->add('creditCardNumber', TextType::class, [
                'label' => 'Credit card number',
                'required' => false,
            ])
            ->add('creditCardExpirationDate', TextType::class, [
                'label' => 'Expiration date (MM/YY)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'MM/YY',
                    'pattern' => '(0[1-9]|1[0-2])\/\d{2}', //Could be used if we not test from JavaScript
                    'maxlength' => 5,
                ],
                'mapped' => false, // Not associated to User because of format
            ])
            ->add('creditCardCVV', TextType::class, [
                'label' => 'CVV',
                'required' => false,
                'attr' => [
                    'maxlength' => 4,
                ],
            ])
            ->add('address', AddressType::class, [
                'label' => false,
            ])
            ->add('subscriptionType', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Free' => 'free',
                    'Premium' => 'premium',
                ],
                'expanded' => true,    // radios buttons
                'multiple' => false,   // 1 choice
                'mapped' => false, // Not associated to User
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
