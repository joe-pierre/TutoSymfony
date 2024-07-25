<?php

namespace App\Form;

use App\Utils\ContactFormDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Sequentially;

class ContactFormDTOType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'empty_data' => '',
                'constraints' => new Sequentially([
                    new NotNull,
                    new NotBlank(message: 'Veuillez remplir ce champs'),
                    new Length(min: 3, minMessage: 'Doit contenir au moins {{ limit }} caractères')
                ]),
            ])
            ->add('email', EmailType::class, [
                'empty_data' => '',
                'constraints' => new Sequentially([
                    new NotNull,
                    new NotBlank(message: 'Veuillez remplir ce champs'),
                    new Email(),
                ]),
            ])
            ->add('subject', TextType::class, [
                'empty_data' => '',
                'constraints' => new Sequentially([
                    new NotNull,
                    new NotBlank(message: 'Veuillez remplir ce champs'),
                    new Length(min: 3, minMessage: 'Doit contenir au moins {{ limit }} caractères')
                ])
            ])
            ->add('message', TextareaType::class, [
                'empty_data' => '',
                'constraints' => new Sequentially([
                    new NotNull,
                    new NotBlank(message: 'Veuillez remplir ce champs'),
                    new Length(min: 3, minMessage: 'Doit contenir au moins {{ limit }} caractères')
                ])
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactFormDTO::class,
        ]);
    }
}
