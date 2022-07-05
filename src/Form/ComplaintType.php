<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Complaint;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComplaintType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('problem', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Problem description',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            /* Setting the default value of the status field to pending. */
            ->add('status', HiddenType::class, [
                'data' => 'pending',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $co) {
                    return $co->createQueryBuilder('ca')
                        ->orderBy('ca.id', 'ASC');
                },
                'attr' => [
                    'class' => 'form-select',
                ],
                'label' => 'Category',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'choice_label' => 'name',
            ])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4',
                ],
                'label' => 'submit',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Complaint::class,
        ]);
    }
}
