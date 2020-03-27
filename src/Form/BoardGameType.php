<?php

namespace App\Form;

use App\Entity\BoardGame;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoardGameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null)
            ->add('description',null)
            ->add('released_at',DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'max' => date('Y-m-d'),
                ]
            ])
            ->add('age_group',IntegerType::class,[
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('classified_in', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BoardGame::class,
            'label_format' => 'board_game.%name%.label',
        ]);
    }
}
