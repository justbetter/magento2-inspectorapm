<?php
namespace JustBetter\InspectorApm\Profiler\Driver;

use JustBetter\InspectorApm\Helper\Inspector;
use Magento\Framework\Profiler\DriverInterface;

class InspectorProfiler implements DriverInterface
{
    private $timers = [];

    public function getInspector()
    {
        return $GLOBALS['inspector_apm'] ??= \Magento\Framework\App\ObjectManager::getInstance()->get(Inspector::class);
    }

    /**
     * Clear collected statistics for specified timer or for whole profiler if timer id is omitted
     *
     * @param string|null $timerId
     * @return void
     */
    public function clear($timerId = null)
    {
        $this->timers[$timerId]->end();
    }

    /**
     * Start collecting statistics for specified timer
     *
     * @param string $timerId
     * @param array|null $tags
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function start($timerId, array $tags = null)
    {
        $this->timers[$timerId] = $this->getInspector()->startSegment('Magento\Framework\Profiler', $timerId)?->setContext($tags ?? []);
    }

    /**
     * Stop recording statistics for specified timer.
     *
     * @param string $timerId
     * @return void
     */
    public function stop($timerId)
    {
        $this->timers[$timerId]?->end();
    }
}
