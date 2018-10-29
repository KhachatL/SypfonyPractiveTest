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
use CoreBundle\Form\CustomerType;
use CoreBundle\Entity\Customer;


class CustomerController extends FOSRestController
{
    /**
     * @Rest\GET("/customers")
     */
    public function getCustomersAction()
    {
        $customer = $this->getDoctrine()->getRepository('CoreBundle:Customer')->findBy(array('deletedAt' => null));

        return $customer;
    }

    /**
     * @Rest\Get("/customer/{uuid}")
     */
    public function getCustomerAction($uuid)
    {
        $customer = $this->getDoctrine()->getRepository('CoreBundle:Customer')->findOneBy(array('uuid' => $uuid, 'deletedAt' => null));
        if (!$customer) {
            return new View("Customer not found", Response::HTTP_NOT_FOUND);
        }

        return $customer;
    }

    /**
     * @Rest\Post("/customer")
     */
    public function postCustomerAction(Request $request)
    {
        $customer = new Customer;

        $body = $request->getContent();
        $data = json_decode($body, true);

        $form = $this->createForm(CustomerType::class, $customer);
        $form->submit($data, 'POST');

        if ($form->isValid()) {
            $customer = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();
        } else {
            return new View($form->getErrors(), Response::HTTP_NOT_ACCEPTABLE);
        }

        return new View(null, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/customer/{uuid}")
     */
    public function putCustomerAction($uuid, Request $request)
    {
        $customer = $this->getDoctrine()->getRepository('CoreBundle:Customer')->findOneBy(array('uuid' => $uuid, 'deletedAt' => null));

        if (!$customer) {
            return new View("Costomer not found", Response::HTTP_NOT_FOUND);
        }

        $body = $request->getContent();
        $data = json_decode($body, true);

        $form = $this->createForm(CustomerType::class, $customer);
        $form->submit($data, 'PUT');

        if ($form->isValid()) {
            $customer = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();
        } else {
            return new View($form->getErrors(), Response::HTTP_NOT_ACCEPTABLE);
        }

        return new View("Customer Updated Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/customer/{uuid}")
     */
    public function deleteCustomerAction($uuid)
    {
        $customer = $this->getDoctrine()->getRepository('CoreBundle:Customer')->findOneBy(array('uuid' => $uuid, 'deletedAt' => null));

        if (!$customer) {
            return new View("Costomer not found", Response::HTTP_NOT_FOUND);
        } else {

            $customer->setDeletedAt(new \Datetime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

        }

        return new View(null, Response::HTTP_OK);
    }



}