<?php

define('MODX_API_MODE', true);
define('MODX_ACTION_MODE', true);

require '../index.php';

$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');
$modx->error->message = null;

$log_file =  $modx->getOption('core_path', null, MODX_CORE_PATH) . 'cache/logs/error.log';
file_put_contents($log_file, "[" . date('l jS \of F Y h:i:s A') . "] Log cleaning done!\r\n");

$corePath = $modx->getOption('sync_core_path', null,
$modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/sync/');

/** @var Sync $Sync */
if (!$Sync = $modx->getService('sync', 'Sync', $corePath . 'model/sync/',
    array('core_path' => $corePath))
) {
    return;
}

$params = array(
	'service'   => 'moysklad',
	'action'    => 'mgr/mscategory/sync',
	'sync_step' => 'sync_init',
);

// $modx->log(1, print_r('==start sync==' ,1));
// $modx->log(1, print_r($params ,1));

$response = $Sync->curlExec($params);
