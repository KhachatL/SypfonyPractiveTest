<?php

namespace CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use CoreBundle\Entity\Product;


class ProductRepository extends EntityRepository
{
    //TODO::add CRUD queries and move from Contrller

    /**
     * Render Products by given status
     *
     * @param $status
     * @return array
     */
    public function getProductsByStatus($status)
    {
        $query = $this->_em->createQuery(
            'SELECT issn, name
             FROM CoreBundle:Product p
             WHERE status = :status AND deleted_at <= (NOW() - INTERVAL 7 DAY)
             ORDER BY updated_at DESC'
        )->setParameter('status', $status);

        $result = $query->getResult();
        return $result;
    }
}
