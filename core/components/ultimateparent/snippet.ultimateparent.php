<?php
/**
 * @name UltimateParent
 * @version 1.3
 * @author Susan Ottwell <sottwell@sottwell.com> March 2006
 * @author Al B <> May 18, 2007
 * @author S. Hamblett <shamblett@cwazy.co.uk>
 * @author Shaun McCormick <shaun@modx.com>
 * @author Jason Coward <modx@modx.com>
 *
 * @param &id The id of the document whose parent you want to find.
 * @param &top The top node for the search.
 * @param &topLevel The top level node for the search (root = level 1)
 *
 * @license Public Domain, use as you like.
 *
 * @example [[UltimateParent? &id=`45` &top=`6`]]
 * Will find the ultimate parent of document 45 if it is a child of document 6;
 * otherwise it will return 45.
 *
 * @example [[UltimateParent? &topLevel=`2`]]
 * Will find the ultimate parent of the current document at a depth of 2 levels
 * in the document hierarchy, with the root level being level 1.
 *
 * This snippet travels up the document tree from a specified document and
 * returns the "ultimate" parent.  Version 2.0 was rewritten to use the new
 * getParentIds function features available only in MODx 0.9.5 or later.
 *
 * Based on the original UltimateParent 1.x snippet by Susan Ottwell
 * <sottwell@sottwell.com>.  The topLevel parameter was introduced by staed and
 * adopted here.
 */
if (!isset($modx)) return '';

$top = intval($modx->getOption('top', $scriptProperties, 0));
$id = intval($modx->getOption('id', $scriptProperties, $modx->resource->get('id')));
$topLevel = intval($modx->getOption('topLevel', $scriptProperties, 0));
$context = $modx->getOption('context', $scriptProperties, $modx->context->key);

if ($id && $id != $top) {
    $pid = $id;
    $pids = $modx->getParentIds($id);
    if (!$topLevel || count($pids) >= $topLevel) {
        while ($parentIds = $modx->getParentIds($id, 1, array('context' => $context))) {
            $pid = array_pop($parentIds);
            if ($pid == $top) {
                break;
            }
            $id = $pid;
            $parentIds = $modx->getParentIds($id, 10, array('context' => $context));
            if ($topLevel && count($parentIds) < $topLevel) {
                break;
            }
        }
    }
}
return $id;