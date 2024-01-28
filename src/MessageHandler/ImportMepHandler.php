<?php

// src/MessageHandler/SmsNotificationHandler.php
namespace App\MessageHandler;

use App\Mep\Domain\Mep;
use App\Mep\Domain\MepCountry;
use App\Mep\Domain\MepFullName;
use App\Mep\Domain\MepId;
use App\Mep\Domain\MepNationalPoliticalGroup;
use App\Mep\Domain\MepPoliticalGroup;
use App\Message\ImportMepMessage;
use App\Repository\MepRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ImportMepHandler
{
    public function __construct(
        private MepRepository $mepRepository
    ) {
        $this->mepRepository = $mepRepository;
    }
    public function __invoke(ImportMepMessage $message)
    {
        //TODO: This domain model construction should be encapsulated in factory method in application layer
        $mepId = new MepId($message->id());
        $mepFullName = new MepFullName($message->fullName());
        $mepCountry = new MepCountry($message->country());
        $mepPoliticalGroup = new MepPoliticalGroup($message->politicalGroup());
        $mepNationalPoliticalGroup = new MepNationalPoliticalGroup($message->nationalPoliticGroup());
        $mepDomainModel = new Mep($mepId, $mepFullName, $mepCountry, $mepPoliticalGroup, $mepNationalPoliticalGroup);

        //TODO: This entity model construction should be encapsulated in translator/datatransformer in infrastructured layer
        $mepEntity = new \App\Entity\Mep();
        $mepEntity->setId($mepDomainModel->id());
        $mepEntity->setFullName($mepDomainModel->fullName());
        $mepEntity->setCountry($mepDomainModel->country());
        $mepEntity->setPoliticalGroup($mepDomainModel->politicalGroup());
        $mepEntity->setNationalPoliticalGroup($mepDomainModel->nationalPoliticalGroup());

        $this->mepRepository->save($mepEntity);
    }
}