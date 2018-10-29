<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 10/28/18
 * Time: 10:27 AM
 */

namespace CoreBundle\DataFixtures;

use CoreBundle\Entity\Customer;
use CoreBundle\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CustomerProductsData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $customer = new Customer();
        $customer->setFirstName('Test');
        $customer->setLastName('Tester');
        $customer->setStatus('approved');
        $manager->persist($customer);

        $product = new Product();
        $product->setIssn('0817-8471');
        $product->setName('test_product');
        $product->setStatus('pending');
        $product->setCustomer($customer);
        $manager->persist($product);

        $manager->flush();
    }
}

