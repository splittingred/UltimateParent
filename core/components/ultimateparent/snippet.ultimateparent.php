<?php
/**
 * @name UltimateParent
 * @version 1.3
 * @author Susan Ottwell <sottwell@sottwell.com> March 2006
 * @editor Jason Coward <jason@collabpad.com> Sept 17, 2006
 * @editor Al B <> May 18, 2007
 * @editor S. Hamblett <shamblett@cwazy.co.uk>
 * @editor Shaun McCormick <shaun@collabpad.com>
 *
 * UltimateParent - snippet for MODx 0.9x Travels up the resource tree from the
 * current resource to return the "ultimate" parent
 *
 * March 2006 - sottwell@sottwell.com
 * Bug fix Sept 17, 2006 - Jason Coward
 * Bug fix to prevent infinite loops if parent never = $top. 18 May, 2007 - Al B
 * Released to the Public Domain, use as you like November 2008 converted for
 * use with Revolution by S. Hamblett
 *
 * Arguments:
 * $id - the id of the resource whose parent you want to find.
 * $top - the top of
 * the search
 *
 * examples:
 * [[UltimateParent? &id=`45` &top=`6`]]
 * will find the first parent of resource #45 under resource #6
 *
 * if id == 0 or top == id, will return id.
 *
 * You can use this as the startDoc for DropMenu to create specific submenus.
 */
if (!isset($modx)) return '';

$top = isset($top) ? $top : 0;
$id = isset($id)? $id : $modx->resource->get('id');
if ($id == $top || $id == 0) { return $id; }

$pid = $modx->getParent($id,1,'id');
if ($pid['id'] == $top) { return $id; }

while ($pid['id'] != $top && $pid['id'] != 0) {
    $id = $pid['id'];
    $pid = $modx->getParent($id,1,'id');
    if ($pid['id'] == $top) { return $id; }
}
return 0; /* if all else fails */