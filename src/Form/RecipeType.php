<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSetDataEvent;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom de la recette',
                'empty_data' => '',
                'constraints' => new Sequentially([
                    new NotNull(),
                    new NotBlank(message: "Veuillez remplir ce champs"),
                    new Length(min:6, minMessage: "Doit contenir au moins {{ limit }} caractères")
                ]),
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Comment faire cette recette',
                'empty_data' => '',
                'constraints' => new Sequentially([
                    new NotNull(),
                    new NotBlank(message: "Veuillez remplir ce champs"),
                    new Length(min:6, minMessage: "Doit contenir au moins {{ limit }} caractères")
                ]),
            ])
            ->add('duration', NumberType::class, [
                'label' => 'Durée (en minutes)',
            ])
            // ->addEventListener(FormEvents::PRE_SUBMIT, function (PreSubmitEvent $event) {
            //     $data = $event->getData();

            //     dd($data);
            // })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
