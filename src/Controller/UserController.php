<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 */
final class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("users", name="users")
     * @return Response
     */
    public function index(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("user/add", name="user_add")
     * @param Request $request
     * @return Response
     * @throws \Symfony\Component\Form\Exception\LogicException
     */
    public function add(Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            // Encode the new password
            $encoder = $this->get('security.password_encoder'); // Todo: change to DI
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // Set role
            $user->setRole('ROLE_USER');

            // Save
            $this->userRepository->save($user);

            return $this->redirectToRoute('users');
        }

        return $this->render('user/user.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("user/{userId}", name="user_edit"), requirements={"userId": "\d+"}
     * @param int $userId
     * @param Request $request
     * @return Response
     * @throws \Symfony\Component\Form\Exception\LogicException
     */
    public function edit(int $userId, Request $request): Response
    {
        $user = $this->userRepository->findById($userId);
        if (!$user) {
            throw $this->createNotFoundException('The user with id ' . $userId . ' does not exist!');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            // Encode the new password
            $encoder = $this->get('security.password_encoder'); // Todo: change to DI
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // Set role
            $user->setRole('ROLE_USER');

            // Save
            $this->userRepository->save($user);

            return $this->redirectToRoute('users');
        }

        return $this->render('user/user.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}