<?php

declare(strict_types=1);

namespace App\Mep\Application\Import;

use App\Mep\Domain\Mep;
use App\Mep\Domain\MepCountry;
use App\Mep\Domain\MepFullName;
use App\Mep\Domain\MepId;
use App\Mep\Domain\MepNationalPoliticalGroup;
use App\Mep\Domain\MepPoliticalGroup;
use App\Repository\MepRepository;
use App\Shared\Domain\Bus\Command\Contract\Command;
use App\Shared\Domain\Bus\Command\Contract\CommandHandler;


final class ImportMepCommandHandler implements CommandHandler
{
    public function __construct(
        private MepRepository $mepRepository
    ) {
        $this->mepRepository = $mepRepository;
    }

    /**
     * Summary of __invoke
     * @param App\Mep\Application\Import\ImportMepCommand $command
     * @return mixed
     */
    public function __invoke(Command $command): void
    {
        $mepId = new MepId($command->id());
        $mepFullName = new MepFullName($command->fullName());
        $mepCountry = new MepCountry($command->country());
        $mepPoliticalGroup = new MepPoliticalGroup($command->politicalGroup());
        $mepNationalPoliticalGroup = new MepNationalPoliticalGroup($command->nationalPoliticGroup());
        $mepDomainModel = new Mep($mepId, $mepFullName, $mepCountry, $mepPoliticalGroup, $mepNationalPoliticalGroup);

        $mepEntity = new \App\Entity\Mep();
        $mepEntity->setId($mepDomainModel->id());
        $mepEntity->setFullName($mepDomainModel->fullName());
        $mepEntity->setCountry($mepDomainModel->country());
        $mepEntity->setPoliticalGroup($mepDomainModel->politicalGroup());
        $mepEntity->setNationalPoliticalGroup($mepDomainModel->nationalPoliticalGroup());

        $this->mepRepository->save($mepEntity);
    }
}