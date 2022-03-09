<?php

namespace App\Controller;

use App\Repository\EmployeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController{


    private EmployeRepository $employeRepo;

    public function __construct(EmployeRepository $employeRepo){
        $this->employeRepo=$employeRepo;
    }

    /**
     * @Route("/", name="main_homepage")
     */
    public function homepage():Response{
        return $this->render('core/index.html.twig', [
        ]);
    }

    
    /**
     * @Route("/list", name="list_employe")
     */
    public function list():Response{
        return $this->render('core/list_employe.html.twig', [
            'employes'=>$this->employeRepo->findAll(),
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
     * @Route("/detail", name="detail_page")
     */
    public function detail():Response{
        return $this->render('core/detail.html.twig', [
        ]);
    }


    }