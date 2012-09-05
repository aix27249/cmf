<?php
// Sitemap generator
$site_url = 'http://example.net/';

$xml_init = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>';
$sitemap = new SimpleXMLElement($xml_init);

$pages_raw = scandir('pages');

// List of pages to exclude from sitemap
$exclude = array('profile', '404', 'mailconfirm', 'logout', 'login');

// Change frequency. Update to match your reality.
$changefreq = array('schedule' => 'daily',
	'about' => 'monthly', 
	'contacts' => 'monthly',
	'forum' => 'hourly',
	'home' => 'hourly',
	'news' => 'daily'
);

$exx = array();
foreach($exclude as $e) {
	$exx[$e]=true;
}



foreach($pages_raw as $p) {
	if ($p==='.' || $p==='..') continue;
	$pname = preg_replace('/\.php$/', '', $p);
	if (isset($exx[$pname])) continue;
	$child = $sitemap->addChild('url');
	if ($pname!=='home') $child->addChild('loc', $site_url . $pname);
	else $child->addChild('loc', $site_url);

	if (isset($changefreq[$pname])) $child->addChild('changefreq', $changefreq[$pname]);
}

require_once 'includes/dbconfig.php';

$res = $mysqli->query('SELECT id FROM moviedb_programs');
while ($row = $res->fetch_row()) {
	$child = $sitemap->addChild('url');
	$child->addChild('loc', $site_url . 'movies/' . $row[0]);
	$child->addChild('changefreq', 'weekly');
}

$res = $mysqli->query('SELECT node.nid, node.created, node.changed FROM node WHERE node.status=1 AND node.type="article"');
while ($row = $res->fetch_row()) {
	$child = $sitemap->addChild('url');
	$child->addChild('loc', $site_url . 'news/' . $row[0]);
	$child->addChild('changefreq', 'never');
	$child->addChild('lastmod', date('Y-m-d', $row[2]));
}
header('Content-type: application/xml');
$dom = new DOMDocument;
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($sitemap->asXML());
echo $dom->saveXML();
