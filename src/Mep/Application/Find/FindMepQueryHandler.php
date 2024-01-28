<?php

declare(strict_types=1);
namespace App\Mep\Application\Find;

use App\Entity\Mep;
use App\Mep\Domain\MepCountry;
use App\Mep\Domain\MepFullName;
use App\Mep\Domain\MepList;
use App\Mep\Domain\MepNationalPoliticalGroup;
use App\Mep\Domain\MepPoliticalGroup;
use App\Repository\MepRepository;
use App\Shared\Domain\Bus\Query\Contract\Query;
use App\Shared\Domain\Bus\Query\Contract\QueryHandler;

final class FindMepQueryHandler implements QueryHandler
{

    public function __construct(
        private MepRepository $mepRepository
    ) {
        $this->mepRepository = $mepRepository;
    }

    public function __invoke(Query $findMepQuery): mixed
    {
        $entityCollection = $this->mepRepository->findAll();

        //TODO: A middelware needs to be added to the query bus to transform the domain model collection to a normal array to comply with the endpoint contract.
        //TODO: A mapper need to be add to the service locator to map query message with this handler.
        return array_map(function (Mep $mep) {
            return new MepList(
                new MepFullName($mep->getFullName()),
                new MepCountry($mep->getCountry()),
                new MepPoliticalGroup($mep->getPoliticalGroup()),
                new MepNationalPoliticalGroup($mep->getNationalPoliticalGroup())
            );
        }, $entityCollection);
    }
}