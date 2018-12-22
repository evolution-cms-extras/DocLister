<?php
if (! defined('MODX_BASE_PATH')) {
    die('HACK???');
}

require_once(MODX_BASE_PATH . "assets/snippets/DocLister/lib/DLTemplate.class.php");

$tpl = '';
if (isset($modx->event->params['tpl'])) {
    $tpl = $modx->event->params['tpl'];
    unset($modx->event->params['tpl']);
}

return empty($tpl) ? '' : DLTemplate::getInstance($modx)->parseChunk($tpl, $modx->event->params);
