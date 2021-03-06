<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 11/3/2016
 * Time: 6:01 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM as ORM;

/**
 * Class Module
 * @package AppBundle\Entity
 * @ORM\Mapping\Entity()
 * @ORM\Mapping\Table(name="module")
 */
class Module
{
    /**
     * @var
     * @ORM\Mapping\Column(type="integer")
     * @ORM\Mapping\Id()
     * @ORM\Mapping\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var
     * @ORM\Mapping\Column(type="string")
     */
    private $name;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Module
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
