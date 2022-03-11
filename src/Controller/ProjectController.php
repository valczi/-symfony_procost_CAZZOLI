<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController{

    public function __construct(private ProjectRepository $projectRepo,private EntityManagerInterface $em){

    }

              /**
     * @Route("/detailP", name="detail_project")
     */
    public function detailProjet():Response{
        return $this->render('core/detail_project.html.twig', [
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
     * @Route("/formAddP", name="form_add_project",methods={"GET","POST"})
     */
    public function form(Request $request):Response{
        $Project=new Project();
        $form=$this->createForm(ProjectType::class,$Project);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success','Project rajouté');
            $this->em->persist($Project);
            $this->em->flush();
            return $this->redirectToRoute('form_add_project');
        }
        
        return $this->render('core/add/form_project.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    }