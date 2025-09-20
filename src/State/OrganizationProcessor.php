<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Component\User\CurrentUser;
use App\Dto\OrganizationInput;
use App\Entity\Organization;
use Doctrine\ORM\EntityManagerInterface;

/**
* @implements ProcessorInterface<Organization, Organization|void>
 */
readonly class OrganizationProcessor implements ProcessorInterface
{
    public function __construct(private ProcessorInterface $processor, private EntityManagerInterface $em, private CurrentUser $user)
    {
    }

    /**
     * @param Organization $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Organization
    {
        if (!$data instanceof OrganizationInput) {
            throw new \InvalidArgumentException('Invalid data.');
        }

        $organization = new Organization();
        $organization->setName($data->getName()->toArray());
        $organization->setCompany($this->user->getUser()->getCompany());

        if ($data->getLogo()) {
            $organization->setLogo($data->getLogo());
        }

        $this->em->persist($organization);
        $this->em->flush();


        return $organization;
    }
}
