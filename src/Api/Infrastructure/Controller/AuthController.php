<?php


namespace App\Api\Infrastructure\Controller;

use App\Api\Model\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
        $user->setRole($role);
        $em->persist($user);
        $em->flush();
        return $this->respondWithSuccess(sprintf('User %s successfully created', $user->getUsername()));
    }

//    /**
//     * @param UserInterface $user
//     * @param JWTTokenManagerInterface $JWTManager
//     * @return JsonResponse
//     */
//    public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager)
//    {
//        return new JsonResponse(['token' => $JWTManager->create($user)]);
//    }
}