<?php

namespace App\Form;


use App\Entity\Project;
use App\Entity\Worktime;
use App\Entity\Employe;
use App\Repository\EmployeRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class WorktimeTypeESide extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('time',IntegerType::class)
            ->add('projet',EntityType::class,[
                "class"=>Project::class,
                "choice_label"=>'nom',
                "query_builder" => function (ProjectRepository $repository) {
                    return $repository->createQueryBuilder("j")
                        ->orderBy("j.nom", "ASC")
                        ->where('j.DeliveredAt IS NULL');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Worktime::class,
        ]);
    }
}
