<?php
/**
 * jcr_write_nextprev
 *
 * A Textpattern CMS plugin for next/prev article buttons on the Write panel.
 */

if (txpinterface === 'admin') {
    if ($event == 'article') {
        register_callback(function($event, $step, $pre, $rs) {
            return article_partial_article_nextprev($rs);
        }, 'article_ui', 'extend_col_1', 0);
    }
}

/**
 * Renders next/prev links.
 *
 * @param      array $rs Article data
 * @return     string HTML
 *
 * wholesale duplicate of built-in article_partial_article_nav($rs)
 * should it someday be removed from the core (status: deprecated in 4.9.0)
 */

function article_partial_article_nextprev($rs)
{
    $out = array();

    if ($rs['prev_id']) {
        $out[] = prevnext_link(gTxt('prev'), 'article', 'edit', $rs['prev_id'], '', 'prev');
    } else {
        $out[] = span(gTxt('prev'), array(
            'class'         => 'navlink-disabled',
            'aria-disabled' => 'true',
        ));
    }

    if ($rs['next_id']) {
        $out[] = prevnext_link(gTxt('next'), 'article', 'edit', $rs['next_id'], '', 'next');
    } else {
        $out[] = span(gTxt('next'), array(
            'class'         => 'navlink-disabled',
            'aria-disabled' => 'true',
        ));
    }

    return n.tag(join('', $out), 'nav', array('class' => 'nav-tertiary'));
}
