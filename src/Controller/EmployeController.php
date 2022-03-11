<?php

namespace App\Controller;

use App\Repository\EmployeRepository;
use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\MetierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



use Symfony\Component\Routing\Annotation\Route;

class EmployeController extends AbstractController{

    public function __construct(private EmployeRepository $employeRepo,private MetierRepository $metierRepo,private EntityManagerInterface $em){

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
     * @Route("/formAddE", name="form_add_employe",methods={"GET","POST"})
     */
    public function form(Request $request):Response{
        $Employe=new Employe();
        $form=$this->createForm(EmployeType::class,$Employe);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success','Employé rajouté');
            $this->em->persist($Employe);
            $this->em->flush();
            return $this->redirectToRoute('form_add_employe');
        }
        
        return $this->render('core/add/form_employe.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

        /**
     * @Route("/detailE", name="detail_employe")
     */
    public function detailEmploye():Response{
        return $this->render('core/detail_employe.html.twig', [
        ]);
    }

    }