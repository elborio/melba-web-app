<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 11/3/2016
 * Time: 5:59 PM
 */

namespace AppBundle\Entity;


class Link
{
    private $name;
    private $path;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }


}