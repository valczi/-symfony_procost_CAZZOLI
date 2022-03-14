<?php

namespace App\Controller;

use App\Repository\EmployeRepository;
use App\Repository\MetierRepository;
use App\Repository\ProjectRepository;
use App\Repository\WorktimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;



use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController{

    public function __construct(private WorktimeRepository $worktimeRepository, private EmployeRepository $employeRepo,private ProjectRepository $projectRepo,private MetierRepository $metierRepo,private EntityManagerInterface $em){

    }

    /**
     * @Route("/", name="main_homepage")
     */
    public function homepage():Response{
        $allProjects=$this->worktimeRepository->getAllProjectsWithPrice();
        $bestEmploye=$this->employeRepo->bestEmploye();

        //dd($allProjects);

        $last5Worktimes=$this->worktimeRepository->getFiveLast();

        $timeProd=$this->worktimeRepository->getTimeAll();      

        $projectDelivered=0;
        $projetRentable=0;

        foreach ($allProjects as $project) {
            if($project['DeliveredAt']!=null)
                $projectDelivered++;
            if($project['total']<$project['cost'])
                $projetRentable++;
        }
        $nbProject=sizeof($allProjects);
        $pourcentageDone=$projectDelivered*100/$nbProject;
        $pourcentageRentable=$projetRentable*100/$nbProject;
        return $this->render('core/index.html.twig', [
            'rentable'=>$pourcentageRentable,
            'pourcentage'=>$pourcentageDone,
            'delivered'=>$projectDelivered,
            'nbEmploye'=>$this->employeRepo->getNbWorker(),
            'inProgress'=>$nbProject-$projectDelivered,
            'bestEmploye'=>$bestEmploye,
            'projects'=>array_slice($allProjects,0,5), 
            'worktimes'=>$last5Worktimes,
            'time'=>$timeProd,
        ]);
    }

    }