# Mage2 Module JustBetter InspectorApm

    ``justbetter/module-inspectorapm``

## Main Functionalities
Add Inspector APM support for Magento

## Installation
\* = in production please use the `--keep-generated` option

### Composer

 - Install the module composer by running `composer require justbetter/module-inspectorapm`
 - enable the module by running `php bin/magento module:enable JustBetter_InspectorApm`
 - Flush the cache by running `php bin/magento cache:flush`

## Configuration

add

```php
<?php
return [
    ...
    'inspector_apm' => [
        'ingestion_key' => '...',
        // Optional, default: https://ingest.inspector.dev
        'url' => '...',
    ],
    ...
]
```

To your env.php.

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

