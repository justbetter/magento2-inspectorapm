<?php

namespace JustBetter\InspectorApm\Profiler\Driver;

use JustBetter\InspectorApm\Helper\Inspector;
use Magento\Framework\DB\Profiler;

class DbProfiler extends Profiler
{
    private $timers = [];

    public function getInspector()
    {
        return $GLOBALS['inspector_apm'] ??= \Magento\Framework\App\ObjectManager::getInstance()->get(Inspector::class);
    }

    /**
     * Starts a query.  Creates a new query profile object (Zend_Db_Profiler_Query)
     * and returns the "query profiler handle".  Run the query, then call
     * queryEnd() and pass it this handle to make the query as ended and
     * record the time.  If the profiler is not enabled, this takes no
     * action and immediately returns null.
     *
     * @param  string  $queryText   SQL statement
     * @param  integer $queryType   OPTIONAL Type of query, one of the Zend_Db_Profiler::* constants
     * @return integer|null
     */
    public function queryStart($queryText, $queryType = null)
    {
        $queryId = parent::queryStart(...func_get_args());

        if ($queryId) {
            $this->timers[$queryId] = $this->getInspector()?->startSegment('process', $queryText);
        }

        return $queryId;
    }

    /**
     * Ends a query. Pass it the handle that was returned by queryStart().
     * This will mark the query as ended and save the time.
     *
     * @param  integer $queryId
     * @throws Zend_Db_Profiler_Exception
     * @return string   Inform that a query is stored or ignored.
     */
    public function queryEnd($queryId)
    {
        if ($this->timers[$queryId] ?? false) {
            $this->timers[$queryId]->end();
            unset($this->timers[$queryId]);
        }

        return parent::queryEnd(...func_get_args());
    }
}
