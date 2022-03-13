<?php

namespace App\Controller;

use App\Repository\EmployeRepository;
use App\Entity\Employe;
use App\Entity\Worktime;
use App\Form\EmployeType;
use App\Form\WorktimeTypeESide;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class EmployeController extends AbstractController{

    public function __construct(private EmployeRepository $employeRepo,private EntityManagerInterface $em){

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
     * @Route("/formAddE", name="add_employe",methods={"GET","POST"})
     */
    public function addEmploye(Request $request):Response{
        $Employe=new Employe();
        $form=$this->createForm(EmployeType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success','Employé rajouté');
            $this->em->persist($Employe);
            $this->em->flush();
            return $this->redirectToRoute('add_employe');
        }
        
        return $this->render('core/add/form_employe.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

        /**
     * @Route("/detailE/{id}", name="detail_employe")
     */
    public function detailEmploye(Request $request,int $id):Response{



        $employe = $this->employeRepo->find($id);
        $worktime=new Worktime();

        if($employe==null){
            throw new NotFoundHttpException();
        }
        $listWorktimes=$employe->getWorktimes();

        $worktime->setEmploye($employe);
        $form=$this->createForm(WorktimeTypeESide::class,$worktime);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success','Temps de travail ajouté');
            $this->em->persist($worktime);
            $this->em->flush();
            return $this->redirectToRoute(
                'detail_employe',
                array('id' => $id),
            );
        }

        return $this->render('core/detail/detail_employe.html.twig', [
            'employe'=>$employe,
            'worktimes'=>$listWorktimes,
            'form'=>$form->createView(),
        ]);
    }

     /**
     * @Route("/EditE/{id}", name="edit_employe")
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