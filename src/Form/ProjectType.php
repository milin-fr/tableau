<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('projectStatus', EntityType::class, [
                'class' => 'App\Entity\ProjectStatus',
                'placeholder' => "Selectionez le status"
            ])
            ->add('tasks', EntityType::class, [
                'class' => 'App\Entity\Task',
                'placeholder' => "Selectionez les taches"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
