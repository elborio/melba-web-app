<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 10/28/2016
 * Time: 3:22 PM
 */

namespace AppBundle\Security;


use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiKeyUserProvider implements UserProviderInterface
{
    public function getUsernameForApiKey($apiKey)
    {
        //TODO: lookup username from db
        $username = "";

        return $username;
    }

    public function loadUserByUsername($username)
    {
        //TODO: use my own user.
        return new User(
            $username,
            null,
            array('ROLE_API')
        );
    }

    public function refreshUser(UserInterface $user)
    {
        // $user is the User that you set in the token inside authenticateToken()
        // after it has been deserialized from the session

        // you might use $user to query the database for a fresh user
        // $id = $user->getId();
        // use $id to make a query

        // if you are *not* reading from a database and are just creating
        // a User object (like in this example), you can just return it
        return $user;
    }

    public function supportsClass($class)
    {
        // TODO: Implement supportsClass() method.
        return 'Symfony\Component\Security\Core\User\User' === $class;
    }
}