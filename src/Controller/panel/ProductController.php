<?php
namespace App\Controller\panel;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Producto;

class ProductController extends AbstractController
{

	 /**
     * @Route("panel/product/", name="product_view")
     */
    public function ListProductView()
    {
    	$productos = $this->getDoctrine()->getRepository(Producto::class);
    	$productos = $productos->findAll();
		return $this->render('panel/product/list.html.twig', array('productos' => $productos));
    }
	 /**
     * @Route("panel/get/product/", name="get_products")
     */
    public function GetProducts()
    {
    	$productos = $this->getDoctrine()->getRepository(Producto::class);
    	$productos = $productos->findall();
    	$response = new JsonResponse();
	    $response->setData(array('data' => $productos));
	    $response->setStatusCode(Response::HTTP_OK);
	    return $response;
    }
	 /**
     * @Route("panel/product/create", name="create_product_view", methods={"GET"})
     */
    public function CreateProductView()
    {
		return $this->render('panel/product/create.html.twig');
    }
	 /**
     * @Route("panel/product/create", name="create_product_action", methods={"POST"})
     */
    public function CreateProductAction(Request $request)
    {
		$entityManager = $this->getDoctrine()->getManager();
		try {

	    	$producto = $this->getDoctrine()->getRepository(Producto::class);
	    	$producto = new Producto();
	    	$producto->setNombre($request->request->get('nombre'));
	    	$producto->setDescripcion($request->request->get('descripcion'));
	    	$producto->setPrecio($request->request->get('precio'));
	    	$entityManager->persist($producto);
	    	$entityManager->flush();
	        $response = new JsonResponse();
	        $response->setData(array('title' => 'Producto insertado', 'status' => 'success', 'message' => 'el producto ha sido ingresado al sistema correctamente!'));
	        $response->setStatusCode(Response::HTTP_OK);

        		return $response;
        } catch (Exception $e) {
	       	$response = new JsonResponse();
	        $response->setData(array('title' => 'Ha ocurrido un error', 'status' => 'success', 'message' => 'el producto no pudo ser ingresado al sistema!'));
	        $response->setStatusCode(Response::HTTP_BAD_REQUEST);

	        	return $response;
		}

    }
	 /**
     * @Route("panel/product/delete", name="delete_product_action", methods={"POST"})
     */
    public function DeleteProductAction(Request $request)
    {
    	try {
    		$entityManager = $this->getDoctrine()->getManager();
	    	$repository = $this->getDoctrine()->getRepository(Producto::class);
	    	$producto = $repository->find($request->request->get('product_id'));
	    	$entityManager->remove($producto);
			$entityManager->flush();
	        $response = new JsonResponse();
	        $response->setData(array('title' => 'Producto borrado', 'status' => 'success', 'message' => 'el producto ha sido borrado correctamente!'));
	        $response->setStatusCode(Response::HTTP_OK);

        		return $response;
    	} catch (Exception $e) {
	       	$response = new JsonResponse();
	        $response->setData(array('title' => 'Ha ocurrido un error', 'status' => 'success', 'message' => 'el producto no pudo ser borrado, probablemente ya no existe, actualiza la pagina!'));
	        $response->setStatusCode(Response::HTTP_BAD_REQUEST);

	        	return $response;
    	}
	}
}