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
        return $this->render('core/detail/detail_project.html.twig', [
        ]);
    }

            /**
     * @Route("/addM", name="add_metier",methods={"GET","POST"})
     */
    public function addMetier(Request $request):Response{
        $Metier=new Metier();
        $form=$this->createForm(MetierType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success','Metier rajouté');
            $this->em->persist($Metier);
            $this->em->flush();
            return $this->redirectToRoute('add_metier');
        }
        
        return $this->render('core/add/form_metier.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

                /**
     * @Route("/editM/{id}", name="edit_metier",methods={"GET","POST"})
     */
    public function editMetier(Request $request,int$id):Response{
        $Metier=$this->metierRepo->find($id);
        $form=$this->createForm(MetierType::class,$Metier);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success','Metier modifié');
            $this->em->flush();
            return $this->redirectToRoute(
                'edit_metier',
                array('id' => $id),
            );
        }
        
        return $this->render('core/add/form_metier.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    }