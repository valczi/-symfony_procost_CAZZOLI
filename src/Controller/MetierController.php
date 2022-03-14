<?php

namespace App\Controller;

use App\Entity\Metier;
use App\Form\MetierType;
use App\Repository\MetierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MetierController extends AbstractController{

    public function __construct(private MetierRepository $metierRepo,private EntityManagerInterface $em){

    }
           /**
     * @Route("/metier/list", name="metier_list")
     */
    public function listMetier(PaginatorInterface $paginator, Request $request):Response{
        $donnes=$this->metierRepo->findAllQuery();
        $metiers= $paginator->paginate(
            $donnes, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('core/list/list_metier.html.twig', [
            'metiers'=>$metiers,
        ]);
    }

               /**
     * @Route("/metier/delete/{id}", name="metier_delete")
     */
    public function deleteMetier($id):Response{
        $metier = $this->metierRepo->find($id);

        if($metier==null){
            throw new NotFoundHttpException();
        }

        if($metier->nbEmploye()!=0){
            return $this->redirectToRoute(
                'main_homepage',
            );
        }

        $this->em->remove($metier);
        $this->em->flush();

        return $this->redirectToRoute(
            'metier_list',
        );
    }


            /**
     * @Route("/metier/new", name="add_metier",methods={"GET","POST"})
     */
    public function addMetier(Request $request):Response{
        $Metier=new Metier();
        $form=$this->createForm(MetierType::class,$Metier);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //dd($Metier);
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
     * @Route("/metier/edit/{id}", name="metier_edit",methods={"GET","POST"})
     */
    public function editMetier(Request $request,int $id):Response{
        $Metier=$this->metierRepo->find($id);

        if($Metier==null){
            throw new NotFoundHttpException();
        }

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