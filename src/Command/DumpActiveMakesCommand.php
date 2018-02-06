<?php

namespace App\Command;

use App\Manager\MakeManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpActiveMakesCommand extends Command
{
    private $makeManager;

    public function __construct(MakeManager $tlptManager)
    {
        $this->makeManager = $tlptManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('km77:dump:makes')
            ->setDescription('Dump active Makes from FAPI to DDBB.')
            ->setHelp('Dump active Makes from FAPI to DDBB.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Make Dumper',
            '============',
            '',
        ]);

        $callback = function ($makeName) use ($output) {
            $output->writeln($makeName);
        };

        $this->makeManager->dumpAll($callback);

        $output->writeln(['======', 'Done']);
    }
}
