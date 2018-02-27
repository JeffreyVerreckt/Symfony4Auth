<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller
 */
final class IndexController extends Controller
{

    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('default/homepage.html.twig');
    }
}
