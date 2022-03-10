<?php

namespace App\Controller;

use App\Repository\EmployeRepository;
use App\Repository\MetierRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController{


    private EmployeRepository $employeRepo;
    private ProjectRepository $projectRepo;
    private MetierRepository $metierRepo;

    public function __construct(EmployeRepository $employeRepo,ProjectRepository $projectRepo,MetierRepository $metierRepo){
        $this->employeRepo=$employeRepo;
        $this->projectRepo=$projectRepo;
        $this->metierRepo=$metierRepo;
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

    
    /**
     * @Route("/listEmploye", name="list_employe")
     */
    public function listEmploye():Response{
        return $this->render('core/list/list_employe.html.twig', [
            'employes'=>$this->employeRepo->findAll(),
        ]);
    }

        /**
     * @Route("/listProject", name="list_project")
     */
    public function listProjet():Response{
        return $this->render('core/list/list_project.html.twig', [
            'projects'=>$this->projectRepo->findAll(),
        ]);
    }

           /**
     * @Route("/listMetier", name="list_metier")
     */
    public function listMetier():Response{
        return $this->render('core/list/list_metier.html.twig', [
            'metiers'=>$this->metierRepo->findAll(),
        ]);
    }

        /**
     * @Route("/form", name="form_page")
     */
    public function form():Response{
        return $this->render('core/form.html.twig', [
        ]);
    }

        /**
     * @Route("/detail", name="detail_employe")
     */
    public function detailEmploye():Response{
        return $this->render('core/detail_employe.html.twig', [
        ]);
    }

            /**
     * @Route("/detail", name="detail_project")
     */
    public function detailProjet():Response{
        return $this->render('core/detail_project.html.twig', [
        ]);
    }


    }