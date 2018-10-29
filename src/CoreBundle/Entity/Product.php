<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 10/27/18
 * Time: 11:14 PM
 */

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use CoreBundle\Entity\Customer;

/**
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ProductRepository")
 * @ORM\Table(name="product")
 */
class Product
{
    const STATUS_PENDING = 'pending';

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @Assert\Issn
     */
    private $issn;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('new', 'pending', 'in review', 'approved', 'inactive', 'deleted')")
     */
    private $status = 'new';

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\Customer", inversedBy="products")
     * @ORM\JoinColumn(name="customer_uuid", referencedColumnName="uuid")
     */
    private $customer;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @return integer
     */
    public function getIssn()
    {
        return $this->issn;
    }

    /**
     * @param integer $issn
     */
    public function setIssn($issn)
    {
        $this->issn = $issn;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return datetime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param datetime $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }
}