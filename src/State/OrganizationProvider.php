<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Doctrine\Orm\Paginator;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\Dto\OrganizationOutput;
use App\Entity\Organization;
use ArrayIterator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class OrganizationProvider implements ProviderInterface
{
    public function __construct(
        private RequestStack $requestStack,
        #[Autowire(service: CollectionProvider::class)]
        private ProviderInterface $collectionProvider,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): TraversablePaginator|array
    {
        $locale = $this->requestStack->getCurrentRequest()?->headers->get('Accept-Languages', 'ru');

        if ($operation instanceof CollectionOperationInterface) {
            /** @var Paginator $paginator */
            $paginator = $this->collectionProvider->provide($operation, $uriVariables, $context);

            $dtoItems = [];

            /** @var Organization $organization */
            foreach ($paginator as $organization) {
                $dtoItems[] = new OrganizationOutput(
                    $organization->getId(),
                    $organization->getTranslatedName($locale),
                    $organization->getNegativeCount(),
                    $organization->getPositiveCount()
                );
            }

            if ($paginator instanceof Paginator) {
                return new TraversablePaginator(
                    new ArrayIterator($dtoItems),
                    $paginator->getCurrentPage() ?? 0,
                    $paginator->getItemsPerPage(),
                    $paginator->getTotalItems(),
                );
            } else {
                return $dtoItems;
            }
        }

        throw new \RuntimeException('Unsupported operation');
    }
}
