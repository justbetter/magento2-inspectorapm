<?php
declare(strict_types=1);

namespace JustBetter\InspectorApm\Plugin\Magento\Framework;

use JustBetter\InspectorApm\Helper\Inspector;
use Magento\Framework\App\Bootstrap;

class AppInterface
{
    public function __construct(protected Inspector $inspector)
    {

    }

    public function beforeCatchException($subject, Bootstrap $bootstrap, \Exception $exception)
    {
        $this->inspector->reportException($exception);

        return [$bootstrap, $exception];
    }
}

