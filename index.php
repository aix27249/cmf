<?php
require_once 'core.php';
?>
<!DOCTYPE html>

<html itemscope itemtype="http://schema.org/Article">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="<?php echo $favicon;?>" type="image/vnd.microsoft.icon" />
		<meta content="<?php echo $title;?>" about="/" property="dc:title" />
		<link rel="shortlink" href="<?php echo $canonical_url;?>" />
		<link rel="canonical" href="<?php echo $canonical_url;?>" />
		<title><?php echo $title_full;?></title>
		<?php if (isset($scripts) && is_array($scripts)) { foreach ($scripts as $s) { echo '<script type="text/javascript" src="' . $s . '"></script>'; }}?>
		<style type="text/css" media="all">
		<?php if (isset($styles) && is_array($styles)) { 
			if (!isset($merge_styles) || $merge_styles!==true) foreach ($styles as $s) { echo "\t\t" . '@import url("' . $s . '");' . "\n"; }
			else echo getMergedStyles($styles);
		}?>
		</style>
		<?php if (isset($header_items) && is_array($header_items)) { foreach($header_items as $h) {echo "\t\t" . $h . "\n";}}?>
		<!--[if IE]>
		<?php echo getIEHeaders();?>
		<![endif]-->
	</head>
	<body>
		<?php require_once 'includes/analytics.php'; ?>
		<?php echo $page_content;?>
	</body>
</html>
