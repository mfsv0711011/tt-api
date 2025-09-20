<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\User\UserFactory;
use App\Component\User\UserManager;
use App\Controller\Base\AbstractController;
use App\Dto\UserCreateDto;
use App\Entity\Company;
use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

/**
 * Class CreateUserController
 *
 * @package App\Controller
 */
class UserCreateAction extends AbstractController
{
    public function __invoke(
        Request $request,
        UserFactory $userFactory,
        UserManager $userManager,
        UserRepository $userRepository
    ): User {
        $data = $this->getDtoFromRequest($request, UserCreateDto::class);

        $this->validate($data);

        if ($userRepository->findOneByEmail($data->getEmail())) {
            throw new BadRequestHttpException('Email already taken');
        }

        if (!in_array('ROLE_OWNER', $this->getUser()->getRoles(), true)) {
            throw new BadRequestHttpException('Invalid role');
        }

        try {
            $company = (new Company())->setName($data->getCompanyName());
            $user = $userFactory->create($data->getEmail(), $data->getPassword(), $company);
            $user->setRoles(['ROLE_COMPANY', 'ROLE_USER']);
            $userManager->save($user, true);
        } catch (Exception $exception) {
            throw new LogicException('User yaratishda xatolik yuz berdi!');
        }

        return $user;
    }
}
