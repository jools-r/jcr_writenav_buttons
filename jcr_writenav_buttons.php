<?php
/**
 * jcr_write_nextprev
 *
 * A Textpattern CMS plugin for next/prev article buttons on the Write panel.
 */

 global $event;

if (txpinterface === 'admin') {
    if ($event === 'article') {
        new jcr_writenav_buttons();
    }
}

class jcr_writenav_buttons
{
    /**
     * Initialise.
     */
    public function __construct()
    {
        // Hook into the Write panel callback at end of sidebar
        register_callback(function($event, $step, $pre, $rs) {
            return $this->article_partial_article_recent_articles($rs);
        }, 'article_ui', 'extend_col_1', 0);

        register_callback(function($event, $step, $pre, $rs) {
            return $this->article_partial_article_nextprev($rs);
        }, 'article_ui', 'extend_col_1', 0);
    }

    /**
     * Renders <ol> list of recent articles.
     *
     * The rendered widget can be customised via the 'article_ui > recent_articles'
     * pluggable UI callback event.
     *
     * @param      array $rs Article data
     * @return     string HTML
     *
     * duplicate of built-in article_partial_article_recent_articles($rs) should the
     * original function be removed from the core (deprecated since v4.9.0)
     */

    protected function article_partial_article_recent_articles($rs)
    {
        /* Number of recent articles displayed on the Write panel.
         * This constant can be overridden from the config.php.
         */
        if (!defined('WRITE_RECENT_ARTICLES_COUNT')) {
            define('WRITE_RECENT_ARTICLES_COUNT', 10);
        }

        $recents = safe_rows_start("Title, ID", 'textpattern', "1 = 1 ORDER BY LastMod DESC LIMIT ".(int) WRITE_RECENT_ARTICLES_COUNT);
        $ra = '';


        if ($recents && numRows($recents)) {
            $ra = '<ol class="recent">';

            while ($recent = nextRow($recents)) {
                if ($recent['Title'] === '') {
                    $recent['Title'] = gTxt('untitled').sp.$recent['ID'];
                }

                $ra .= n.'<li class="recent-article">'.
                    href(escape_title($recent['Title']), '?event=article'.a.'step=edit'.a.'ID='.$recent['ID']).
                    '</li>';
            }

            $ra .= '</ol>';
        }

        return wrapRegion(
            'txp-recent-group',
            pluggable_ui('article_ui', 'recent_articles', $ra, $rs),
            'txp-recent-group-content', 'recent_articles', 'article_recent');
    }

    /**
     * Renders next/prev links.
     *
     * @param      array $rs Article data
     * @return     string HTML
     *
     * duplicate of built-in article_partial_article_nav($rs) should the original
     * function be removed from the core (deprecated since v4.9.0)
     */

    protected function article_partial_article_nextprev($rs)
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
}
