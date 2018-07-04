<?php

use Decorator\DataProviderCacheDecorator;
use Integration\DumbDataProvider;

require __DIR__ . '/vendor/autoload.php';

$logger = new \Apix\Log\Logger\File(sys_get_temp_dir() . '/skyeng.log');

$backend   = new \Apix\Cache\Files();
$cachePool = \Apix\Cache\Factory::getPool($backend);

$dataProvider = new DumbDataProvider('host-string', 'user-string', '3');

$dataProvider = new DataProviderCacheDecorator($dataProvider, $cachePool, $logger);

for ($i = 1; $i <= 5; $i++) {
    printf("Requesting data.... Attempt %s\n", $i);
    printf("\nStarted at: %s\n", (new \DateTime())->format(\DateTime::ATOM));

    $data = $dataProvider->get(['foo' => 'bar']);

    printf("\nData received at %s\n", (new \DateTime())->format(\DateTime::ATOM));
    printf("\nData: \n%s\n", var_export($data, true));
}

$data = $dataProvider->get(['foo' => 'bar']);
