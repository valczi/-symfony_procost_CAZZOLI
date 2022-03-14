<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController{

    public function __construct(private ProjectRepository $projectRepo,private EntityManagerInterface $em){

    }
        /**
     * @Route("/project/detail/{id}", name="project_detail")
     */
    public function detailProject(int $id):Response{

        $project = $this->projectRepo->find($id);

        if($project==null){
            throw new NotFoundHttpException();
        }
        $worktimes = $project->getWorktimes();
        $nbWorkers= $this->projectRepo->getNbWorker($project->getId());
        return $this->render('core/detail/detail_project.html.twig', [
            'project'=>$project,
            'nbWorkers'=>$nbWorkers,
            'worktimes'=>$worktimes,
        ]);
    }

            /**
     * @Route("/project/end/{id}", name="project_end")
     */
    public function endProject(int $id):Response{

        $project = $this->projectRepo->find($id);

        if($project==null){
            throw new NotFoundHttpException();
        }
        $project->setDeliveredAt(new DateTimeImmutable());
        $this->em->flush();

        return $this->redirectToRoute(
            'project_detail',
            array('id' => $id),
        );
    }


            /**
     * @Route("/project/list", name="project_list")
     */
    public function listProjet():Response{
        return $this->render('core/list/list_project.html.twig', [
            'projects'=>$this->projectRepo->findAll(),
        ]);
    }

            /**
     * @Route("/project/new", name="project_add",methods={"GET","POST"})
     */
    public function addProject(Request $request):Response{
        $Project=new Project();
        $form=$this->createForm(ProjectType::class,$Project);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success','Project rajouté');
            $this->em->persist($Project);
            $this->em->flush();
            return $this->redirectToRoute('project_add');
        }
        
        return $this->render('core/add/form_project.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    
            /**
     * @Route("/project/edit/{id}", name="project_edit",methods={"GET","POST"})
     */
    public function editProject(Request $request,int $id):Response{
        $Project=$this->projectRepo->find($id);

        if($Project->getDeliveredAt()!=null){
            return $this->redirectToRoute(
                'project_list',
            );
        }

        $form=$this->createForm(ProjectType::class,$Project);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success','Project modifié');
            $this->em->flush();
            return $this->redirectToRoute(
                'project_edit',
                array('id' => $id),
            );
        }
        
        return $this->render('core/add/form_project.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    }