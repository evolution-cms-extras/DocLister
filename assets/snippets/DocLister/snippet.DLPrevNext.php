<?php
if (! defined('MODX_BASE_PATH')) {
    die('HACK???');
}

$ID = $modx->documentObject['id'];
$params = is_array($modx->event->params) ? $modx->event->params : [];
$params = array_merge($params, [
        'api'   => 1,
        'debug' => '0'
    ]);

$json = $modx->runSnippet("DocLister", $params);
$children = jsonHelper::jsonDecode($json, ['assoc' => true]);
$children = is_array($children) ? $children : [];
$self = $prev = $next = null;
foreach ($children as $key => $data) {
    if (! empty($self)) {
        $next = $key;
        break;
    }
    if ($key == $ID) {
        $self = $key;
        if (empty($prev)) {
            $prev = end($children);
            $prev = $prev['id'];
        }
    } else {
        $prev = $key;
    }
}
if (empty($next)) {
    reset($children);
    $next = current($children);
    $next = $next['id'];
}
if ($next == $prev) {
    $next = '';
}

$TPL = DLTemplate::getInstance($modx);
return ($prev == $ID) ? '' : $TPL->parseChunk($prevnextTPL, [
    'prev' => empty($prev) ? '' : $TPL->parseChunk($prevTPL, $children[$prev]),
    'next' => empty($next) ? '' : $TPL->parseChunk($nextTPL, $children[$next]),
]);
