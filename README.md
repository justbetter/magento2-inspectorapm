# Mage2 Module JustBetter InspectorApm

## Main Functionalities
Add Inspector APM support for Magento

## Installation

### Composer

 - Install the module composer by running `composer require justbetter/magento2-inspectorapm (--dev)`
 - enable the module by running `php bin/magento module:enable JustBetter_InspectorApm`
 - Flush the cache by running `php bin/magento cache:flush`

## Configuration

add

```php
<?php
return [
    ...
    'inspector_apm' => [
        'ingestion_key' => $_ENV['INSPECTOR_INGESTION_KEY'] ?? '...',
        // Optional, default: https://ingest.inspector.dev
        'url' => $_ENV['INSPECTOR_URL'] ?? 'https://ingest.inspector.dev',
    ],
    ...
]
```

To your env.php.

### Buggregator

If you wish to use buggregator instead of inspector you can set the configuration to

```php
<?php
return [
    ...
    'inspector_apm' => [
        'ingestion_key' => $_ENV['INSPECTOR_INGESTION_KEY'] ?? 'anything-as-its-not-used',
        'url' => $_ENV['INSPECTOR_URL'] ?? 'http://inspector@127.0.0.1:8000',
    ],
    ...
]
```

In your env.php.

## Usage

### Database Profiler
Set

```php
<?php
return [
    ...
    'db' => [
        'connection' => [
            'default' => [
                ...
                'profiler' => [
                    'class' => 'JustBetter\\InspectorApm\\Profiler\\Driver\\DbProfiler',
                    'enabled' => true
                ]
            ]
        ]
    ],
    ...
```

in your env.php to enable the db profiler. This will automatically profile all database transactions.

### Magento Profiler

run `bin/magento inspector:enable` to enable the regular profiler.

This will profile all calls to [\Magento\Framework\Profiler::start](https://github.com/search?q=repo%3Amagento%2Fmagento2%20%5CMagento%5CFramework%5CProfiler&type=code)
which you can add in your own code to measure it's performance.

### Direct access

If you want to disable all Magento and Zend provided profiling but still want to profile some functions, you can use dependency injection to get "\JustBetter\InspectorApm\Helper\Inspector" and call any of it's underlying functions.

