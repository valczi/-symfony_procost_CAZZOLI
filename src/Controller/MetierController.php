<?php

namespace App\Controller;

use App\Entity\Metier;
use App\Form\MetierType;
use App\Repository\MetierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



use Symfony\Component\Routing\Annotation\Route;

class MetierController extends AbstractController{

    public function __construct(private MetierRepository $metierRepo,private EntityManagerInterface $em){

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
     * @Route("/detailM", name="detail_metier")
     */
    public function detailProjet():Response{
        return $this->render('core/detail_project.html.twig', [
        ]);
    }

            /**
     * @Route("/formAddM", name="form_add_metier",methods={"GET","POST"})
     */
    public function form(Request $request):Response{
        $Metier=new Metier();
        $form=$this->createForm(MetierType::class,$Metier);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success','Metier rajouté');
            $this->em->persist($Metier);
            $this->em->flush();
            return $this->redirectToRoute('form_add_metier');
        }
        
        return $this->render('core/add/form_metier.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    }