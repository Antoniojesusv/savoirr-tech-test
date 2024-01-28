<?php

namespace App\Command;

use App\Mep\Application\Import\ImportMepCommand;
use App\Shared\Infrastructure\Bus\Command\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:import-members',
    description: 'Import members.',
    hidden: false,
    aliases: ['app:import-members']
)]
class ImportMepsCommand extends Command
{
    private CommandBus $commandBus;
    protected static $defaultDescription = 'Import members of the european parliament.';

    const MEPS_URL = "https://www.europarl.europa.eu/meps/en/full-list/xml/a";

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;

        // you must call the parent constructor
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $mepsGenerator = $this->getMepsFromXml();

        foreach ($mepsGenerator as $mep) {
            $command = new ImportMepCommand(
                $mep['id'],
                $mep['fullName'],
                $mep['country'],
                $mep['politicalGroup'],
                $mep['nationalPoliticalGroup'],
            );

            $this->commandBus->dispatch($command);
        }

        $output->writeln("Successfully meps imported. \xF0\x9F\x98\x8A");
        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to import members of the european parliament from url')
        ;
    }

    private function getMepsFromXml(): \Generator
    {
        $context = stream_context_create(
            array(
                'http' => array(
                    'method' => 'GET',
                    'header' => 'Content-type: application/xml'
                )
            )
        );

        $xml = file_get_contents(self::MEPS_URL, false, $context);

        $dom = new \DOMDocument();
        $dom->loadXML($xml);
        $mepsDocument = $dom->getElementsByTagName('meps');

        //TODO: This should be done wuth Xpath to loop dom tree efficiently
        foreach ($mepsDocument as $mep) {
            $mepChildren = $mep->childNodes;

            foreach ($mepChildren as $mepNodes) {

                $children = $mepNodes->childNodes;

                $mep = [];

                foreach ($children as $child) {
                    if ($child->nodeType == 1) {
                        $nodeName = $child->nodeName;
                        $nodeValue = $child->nodeValue;
                        $mep[$nodeName] = $nodeValue;
                    }
                }

                yield $mep;
            }
        }
    }
}