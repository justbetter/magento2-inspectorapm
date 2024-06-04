<?php

declare(strict_types=1);

namespace JustBetter\InspectorApm\Console\Command;

use JustBetter\InspectorApm\Profiler\Driver\InspectorProfiler;
use JustBetter\InspectorApm\Profiler\Driver\Standard\Output\Inspector;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EnableInspector extends Command
{
    public function __construct(protected \Magento\Developer\Console\Command\ProfilerEnableCommand $profilerEnableCommand)
    {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->addArgument('type', InputArgument::OPTIONAL, 'Profiler type');

        $input->setArgument('type', json_encode([
            'drivers' => [
                [
                    'output' => Inspector::class,
                    'type' => InspectorProfiler::class
                ]
            ]
        ]));
        return $this->profilerEnableCommand->execute($input, $output);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("inspector:enable");
        $this->setDescription("Enables InspectorApm Profiler");
        parent::configure();
    }
}
