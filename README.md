# jcr_writenav_buttons

**For Textpattern v4.9 and greater** (not needed for older versions)

Restores the "recent articles" dropdown and next / prev article buttons on Write panel for navigating quickly between adjacent articles.

The plugin uses a duplicate of the original functions in the Textpattern core (deprecated from v.4.9 onwards) and thus works exactly as earlier Textpattern versions, adding a "recent articles" dropdown and previous and next article buttons at the bottom of the sidebar.

You can change the number of recent articles to display by adding the following line to `config.php`, changing `5` to however many articles you wish to see:

```
define('WRITE_RECENT_ARTICLES_COUNT', 5);
```

## Installation

Install and activate to show the buttons on the Write panel.

## Changelog and credits

### Changelog

-   Version 0.2.1 -- 2025/06/29 -- Minor fix: properly reinstate on article save
-   Version 0.2 -- 2024/01/29 -- Also include "recent articles" dropdown
-   Version 0.1 -- 2024/01/23 -- First release

### Credits

Oleg's and Stef's advice in this [forum thread](https://forum.textpattern.com/viewtopic.php?id=52256) and the existing Textpattern core.
