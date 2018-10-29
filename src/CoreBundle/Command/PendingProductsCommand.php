<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 10/28/18
 * Time: 9:37 PM
 */

namespace CoreBundle\Command;

use CoreBundle\Entity\Product;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class PendingProductsCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('core:pending-products')
            ->setDescription('Retrieve products pending')
            ->setHelp('Retrieve products pending for over a week');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $status = Product::STATUS_PENDING;

        //TODO::set $products equal to getProductsByStatus($status) from ProductRepository
        $product = array();
        //TODO::implement mailer service

        $output->write('Pending Products Sent');
    }




}