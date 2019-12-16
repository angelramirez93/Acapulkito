<?php
namespace App\Controller\panel;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanelController extends Controller
{
	 /**
     * @Route("/panel", name="panel_index")
     */
    public function index()
    {
		return $this->render('panel/index.html.twig');
    }
}