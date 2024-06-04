<?php

declare(strict_types=1);

namespace JustBetter\InspectorApm\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DisableInspector extends Command
{
    public function __construct(protected \Magento\Developer\Console\Command\ProfilerDisableCommand $profilerDisableCommand)
    {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        return $this->profilerDisableCommand->execute($input, $output);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("inspector:disable");
        $this->setDescription("Disables InspectorApm Profiler");
        parent::configure();
    }
}
