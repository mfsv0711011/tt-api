<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\OrganizationInput;
use App\Entity\Organization;
use Doctrine\ORM\EntityManagerInterface;

readonly class OrganizationProcessor implements ProcessorInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Organization
    {
        if (!$data instanceof OrganizationInput) {
            throw new \InvalidArgumentException('Invalid data.');
        }

        $organization = new Organization();
        $organization->setName($data->getName()->toArray());

        if ($data->getLogo()) {
            $organization->setLogo($data->getLogo());
        }

        $this->em->persist($organization);
        $this->em->flush();


        return $organization;
    }
}
