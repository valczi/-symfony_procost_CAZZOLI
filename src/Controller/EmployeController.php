<?php

namespace App\Controller;

use App\Repository\EmployeRepository;
use App\Entity\Employe;
use App\Entity\Worktime;
use App\Form\EmployeType;
use App\Form\WorktimeTypeESide;
use App\Repository\WorktimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class EmployeController extends AbstractController{

    public function __construct(private WorktimeRepository $worktimeRepo, private EmployeRepository $employeRepo,private EntityManagerInterface $em){

    }
    
    /**
     * @Route("/employe/list", name="employe_list")
     */
    public function listEmploye(PaginatorInterface $paginator, Request $request):Response{
        $donnes=$this->employeRepo->findAllQuery();
        $employes= $paginator->paginate(
            $donnes, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        

        return $this->render('core/list/list_employe.html.twig', [
            'employes'=>$employes,
        ]);
    }

        /**
     * @Route("/employe/new", name="employe_add",methods={"GET","POST"})
     */
    public function addEmploye(Request $request):Response{
        $Employe=new Employe();
        $form=$this->createForm(EmployeType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success','Employé rajouté');
            $this->em->persist($Employe);
            $this->em->flush();
            return $this->redirectToRoute('employe_add');
        }
        
        return $this->render('core/add/form_employe.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

        /**
     * @Route("/employe/detail/{id}", name="employe_detail")
     */
    public function detailEmploye(PaginatorInterface $paginator,Request $request,int $id):Response{

        $employe = $this->employeRepo->find($id);
        $worktime=new Worktime();

        if($employe==null){
            throw new NotFoundHttpException();
        }

        $donnes=$this->worktimeRepo->getWorktimesQuery($employe);

        $worktimes= $paginator->paginate(
            $donnes, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        $worktime->setEmploye($employe);
        $form=$this->createForm(WorktimeTypeESide::class,$worktime);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success','Temps de travail ajouté');
            $this->em->persist($worktime);
            $this->em->flush();
            return $this->redirectToRoute(
                'employe_detail',
                array('id' => $id),
            );
        }

        return $this->render('core/detail/detail_employe.html.twig', [
            'employe'=>$employe,
            'worktimes'=>$worktimes,
            'form'=>$form->createView(),
        ]);
    }

     /**
     * @Route("/employe/edit/{id}", name="edit_employe")
     */
    public function editEmploye(Request $request,int $id):Response{

        $employe=$this->employeRepo->find($id);
        
        if($employe==null){
            throw new NotFoundHttpException();
        }

        $form=$this->createForm(EmployeType::class,$employe);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success','Metier modifié');
            $this->em->flush();
            return $this->redirectToRoute(
                'edit_employe',
                array('id' => $id),
            );
        }
        return $this->render('core/edit/edit_employe.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    }