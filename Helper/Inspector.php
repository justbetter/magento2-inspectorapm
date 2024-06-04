<?php

declare(strict_types=1);

namespace JustBetter\InspectorApm\Helper;

use Inspector\Configuration;
use Inspector\Inspector as RealInspector;
use Inspector\Models\Transaction;
use Magento\Framework\App\DeploymentConfig;

class Inspector
{
    private RealInspector $inspector;
    private ?Transaction $transaction = null;

    public function __construct(protected DeploymentConfig $deploymentConfig)
    {

    }

    public function getConfiguration()
    {
        // Create a configuration instance.
        $configuration = new Configuration();
        if (($key = $this->deploymentConfig->get('inspector_apm/ingestion_key'))) {
            $configuration->setIngestionKey($key);
        }
        if (($url = $this->deploymentConfig->get('inspector_apm/url'))) {
            $configuration->setUrl($url);
        }

        return $configuration;
    }

    public function getInspector()
    {
        return $this->inspector ??= new RealInspector($this->getConfiguration());
    }

    public function startTransaction($name)
    {
        return $this->transaction = $this->inspector->startTransaction($name);
    }

    public function __call($method, $args)
    {
        $inspector = $this->getInspector();
        if (!$this->transaction) {
            $pathInfo = explode('?', $_SERVER["REQUEST_URI"] ?? '');
            $path = array_shift($pathInfo);
            $this->startTransaction($path ?: implode(' ', $_SERVER['argv'] ?? []));
        }

        if (is_callable(array($inspector, $method))) {
            return call_user_func_array(array($inspector, $method), $args);
        } elseif (is_callable(array($this, $method))) {
            return call_user_func_array(array($this, $method), $args);
        } else {
            trigger_error("Call to undefined method '{$method}'");
        }
    }
}
