<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 11/14/2016
 * Time: 7:13 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class GroupInvite
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="GroupInviteRepository")
 */
class GroupInvite
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Group")
     */
    private $group;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expiration;

    /**
     * @ORM\Column(type="text")
     */
    private $inviteKey;

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
     * Set email
     *
     * @param string $email
     *
     * @return GroupInvite
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set expiration
     *
     * @param \DateTime $expiration
     *
     * @return GroupInvite
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * Get expiration
     *
     * @return \DateTime
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * Set key
     *
     * @param string $key
     *
     * @return GroupInvite
     */
    public function setInviteKey($inviteKey)
    {
        $this->inviteKey = $inviteKey;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getInviteKey()
    {
        return $this->inviteKey;
    }

    /**
     * Set group
     *
     * @param \AppBundle\Entity\Group $group
     *
     * @return GroupInvite
     */
    public function setGroup(\AppBundle\Entity\Group $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \AppBundle\Entity\Group
     */
    public function getGroup()
    {
        return $this->group;
    }
}
