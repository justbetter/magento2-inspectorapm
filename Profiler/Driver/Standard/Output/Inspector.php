<?php

namespace JustBetter\InspectorApm\Profiler\Driver\Standard\Output;

use Magento\Framework\Profiler\Driver\Standard\AbstractOutput;
use Magento\Framework\Profiler\Driver\Standard\Stat;

class Inspector extends AbstractOutput
{
    public function display(Stat $stat)
    {
        // We do not display the stats here, instead we have already passed it to https://inspector.dev/
    }
}
