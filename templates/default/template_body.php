<div id="wrapper">
	<div id="page-wrapper" class="clearfix">
		<div id="header" class="area">
			<?php printBlocks('header');?>
		</div>
		<div id="highlight" class="area">
			<?php printBlocks('highlight');?>
		</div>
		<div id="main" class="area">
			<div id="content" class="subarea">
				<?php printBlocks('content');?>
			</div>
			<div id="sidebar" class="subarea">
				<?php printBlocks('sidebar');?>
			</div>
		</div>
		<div id="footer" class="area">
			<?php printBlocks('footer');?>
		</div>
	</div>
</div>
<div id="pageside">
	<?php printBlocks('pageside');?>
</div>

