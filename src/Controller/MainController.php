<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController{


    public function __construct(){
    }

    /**
     * @Route("/", name="main_homepage")
     */
    public function homepage():Response{
        $date = getdate();
        return $this->render('core/index.html.twig', [
        ]);
    }

    
    /**
     * @Route("/list", name="list_page")
     */
    public function list():Response{
        $date = getdate();
        return $this->render('core/list.html.twig', [
        ]);
    }

        /**
     * @Route("/form", name="form_page")
     */
    public function form():Response{
        $date = getdate();
        return $this->render('core/form.html.twig', [
        ]);
    }

        /**
     * @Route("/detail", name="detail_page")
     */
    public function detail():Response{
        $date = getdate();
        return $this->render('core/detail.html.twig', [
        ]);
    }


    }