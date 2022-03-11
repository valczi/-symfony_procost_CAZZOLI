<?php

namespace App\Controller;

use App\Repository\EmployeRepository;
use App\Repository\MetierRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;



use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController{

    public function __construct(private EmployeRepository $employeRepo,private ProjectRepository $projectRepo,private MetierRepository $metierRepo,private EntityManagerInterface $em){

    }

    /**
     * @Route("/", name="main_homepage")
     */
    public function homepage():Response{
        $allProjects=$this->projectRepo->findAll();
        $allEmployes=$this->employeRepo->findAll();
        $projectDelivered=0;
        foreach ($allProjects as $project) {
            if($project->getDeliveredAt()!=null)
                $projectDelivered++;
        }
        $nbProject=sizeof($allProjects);
        $pourcentageDone=$projectDelivered*100/$nbProject;
        
        return $this->render('core/index.html.twig', [
            'pourcentage'=>$pourcentageDone,
            'delivered'=>$projectDelivered,
            'nbEmploye'=>sizeof($allEmployes),
            'inProgress'=>$nbProject-$projectDelivered,
        ]);
    }

    }