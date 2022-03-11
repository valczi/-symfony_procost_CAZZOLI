<?php

namespace App\Form;

use App\Entity\Metier;
use App\Entity\Employe;
use App\Repository\MetierRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EmployeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class)
            ->add('surname',TextType::class)
            ->add('mail',EmailType::class)
            ->add('cost',IntegerType::class)
            ->add('hired',DateType::class)
            ->add('job',EntityType::class,[
                "class"=>Metier::class,
                "choice_label"=>'name',
                "query_builder" => function (MetierRepository $repository) {
                    return $repository->createQueryBuilder("j")
                        ->orderBy("j.name", "ASC");
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
