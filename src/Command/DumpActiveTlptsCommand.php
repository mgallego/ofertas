<?php

namespace App\Command;

use App\Manager\TlptManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpActiveTlptsCommand extends Command
{
    private $tlptManager;

    public function __construct(TlptManager $tlptManager)
    {
        $this->tlptManager = $tlptManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('km77:dump:tlpts')
            ->setDescription('Dump active TLPTs from FAPI to DDBB.')
            ->setHelp('Dump active TLPTs from FAPI to DDBB.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'TLPTs Dumper',
            '============',
            '',
        ]);

        $progress = null;

        $callback = function ($current, $total, $tlptName) use ($progress, $output) {
            if (null === $progress) {
                $progress = new ProgressBar($output, $total);
                $progress->start();
            }

            $progress->setProgress($current);
            $progress->setMessage($tlptName);
        };

        $this->tlptManager->dumpAll($callback);

        $output->writeln(['======', 'Done']);
    }
}
