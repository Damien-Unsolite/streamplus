<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('addressLine1', TextType::class, [
                'label' => 'Address line 1',
            ])
            ->add('addressLine2', TextType::class, [
                'label' => 'Address line 2',
                'required' => false,
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Postal code / ZIP',
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
            ])
            ->add('state', TextType::class, [
                'label' => 'State / Province / Region',
                'required' => false,
            ])
            ->add('country', CountryType::class, [
                'label' => 'Country',
                'placeholder' => 'Select a country',
                'preferred_choices' => ['US', 'FR', 'GB'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
