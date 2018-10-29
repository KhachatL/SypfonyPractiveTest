<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 10/27/18
 * Time: 11:03 PM
 */

namespace ApiBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CoreBundle\Entity\Product;
use CoreBundle\Form\ProductType;

class ProductController extends FOSRestController
{
    /**
     * @Rest\GET("/products")
     */
    public function getProductsAction()
    {
        $product = $this->getDoctrine()->getRepository('CoreBundle:Product')->findBy(array('deletedAt' => null));

        return $product;
    }

    /**
     * @Rest\Get("/product/{issn}")
     */
    public function getProductAction($issn)
    {
        $product = $this->getDoctrine()->getRepository('CoreBundle:Product')->findOneBy(array('issn' => $issn, 'deletedAt' => null));
        if (!$product) {
            return new View("Product not found", Response::HTTP_NOT_FOUND);
        }

        return $product;
    }

    /**
     * @Rest\Post("/product")
     */
    public function postProductAction(Request $request)
    {
        $product = new Product;

        $body = $request->getContent();
        $data = json_decode($body, true);

        $form = $this->createForm(ProductType::class, $product);
        $form->submit($data, 'POST');

        if ($form->isValid()) {
            $product = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
        } else {
            return new View($form->getErrors(), Response::HTTP_NOT_ACCEPTABLE);
        }

        return new View(null, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/product/{issn}")
     */
    public function putProductAction($issn, Request $request)
    {
        $product = $this->getDoctrine()->getRepository('CoreBundle:Product')->findOneBy(array('issn' => $issn, 'deletedAt' => null));

        if (!$product) {
            return new View("Product not found", Response::HTTP_NOT_FOUND);
        }

        $body = $request->getContent();
        $data = json_decode($body, true);

        $form = $this->createForm(ProductType::class, $product);
        $form->submit($data, 'PUT');

        if ($form->isValid()) {
            $product = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
        } else {
            return new View($form->getErrors(), Response::HTTP_NOT_ACCEPTABLE);
        }

        return new View("Product Updated Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/product/{issn}")
     */
    public function deleteProductAction($issn)
    {
        $product = $this->getDoctrine()->getRepository('CoreBundle:Product')->findOneBy(array('issn' => $issn, 'deletedAt' => null));

        if (!$product) {
            return new View("Product not found", Response::HTTP_NOT_FOUND);
        } else {
            $product->setDeletedAt(new \Datetime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
        }

        return new View(null, Response::HTTP_OK);
    }



}