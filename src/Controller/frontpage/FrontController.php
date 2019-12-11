<?php
namespace App\Controller\frontpage;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends Controller
{
	 /**
     * @Route("/", name="index")
     */
    public function index()
    {
		return $this->render('frontpage/index.html.twig');
    }
}