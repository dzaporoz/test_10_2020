<?php


namespace App\Api\Infrastructure\Controller;

use App\Api\Model\Entity\User;
use App\Resources\Api\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends ApiController
{
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->transformJsonBody($request);
        $username = $request->get('username');
        $password = $request->get('password');
        $role = $request->get('role');

        if (empty($username) || empty($password) || empty($role) || ! in_array($role, ['client', 'manager'])){
            return $this->respondValidationError("Invalid Username or Password or Role (should be 'user' or 'manager')");
        }

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setRoles(array($role == 'client' ? 'ROLE_CLIENT' : 'ROLE_MANAGER'));
        $em->persist($user);
        $em->flush();
        $this->setStatusCode(201);
        return $this->response(null, sprintf('User %s successfully created', $user->getUsername()));
    }
}