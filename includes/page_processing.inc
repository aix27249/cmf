<?php
/* 
 * Page processor
 *
 * This code do page preparation:
 * 	- get page name from GET array
 * 	- load page data
 * 	- form html header metadata
 *
 * Normally, this code should not be changed.
 *
 * FIXME: THIS CODE *NEED* TO BE REWORKED!!!
 */


$page_meta = processPage($page_name);

if (isset($page_meta['url'])) $this_url = $page_meta['url'];
else $this_url='/?p=' . $page_name;
if (isset($page_meta['title'])) $title = $page_meta['title'];
else $title = '';

// Allow title override
if (isset($page_title)) $title = $page_title;

/* This block is a bullshit, plz new code here
if (isset($page_meta['styles'])) $styles[] = $page_meta['styles'];
if (isset($page_meta['scripts'])) $scripts[] = $page_meta['scripts'];
if (isset($page_meta['header_items'])) $header_items[] = $page_meta['header_items'];
if (isset($page_meta['body'])) $body = $page_meta['body'];
else $body = '<div class="error">NO BODY</div>';*/

$title_full = $title . ' | ' . $site_name;
$canonical_url = $this_url;
if ($this_url=='/movies') $canonical_url='/movies/' . $_GET['m'];
else if ($this_url=='/news' && isset($_GET['id'])) $canonical_url = '/news/' . $_GET['id'];
else if ($this_url=='/home') $canonical_url = '/';
