<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProductController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Route("/products")
     */
    public function listAction() {

        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();

        /*$encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $products = $serializer->serialize($products, 'json');
        return $this->json($products);*/

        return $this->render('products.html.twig', array('products' => $products));
    }

    /**
     * @Route("/products/create/{name}")
     */
    public function createAction($name) {
        $product = new Product();
        $product->setDescription("Random Priced Product");
        $product->setName($name);
        $random = random_int(0,100);
        $product->setPrice($random);

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return new Response('Saved new product with id '.$product->getId());
    }
}
