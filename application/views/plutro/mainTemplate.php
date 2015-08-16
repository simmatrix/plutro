<?php defined('BASEPATH') or die('Unauthorized Access');?>
<header>
	<div class="text-center">
		<div class="logo text-center">
			<img src="/img/plutro-logo.png" title="Plutro" alt="Plutro"/>
		</div>
	</div>
	<div id="menu_icon"></div>
	<nav class="mobile-menu">
		<ul>
			<?php if( $layout != 'homeLayout' ){ ?>
			<div class="sidebar-search">
				<script>
					(function() {
						var cx = '013216559133318626030:ldmzncjfo8k';
						var gcse = document.createElement('script');
						gcse.type = 'text/javascript';
						gcse.async = true;
						gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
							'//cse.google.com/cse.js?cx=' + cx;
						var s = document.getElementsByTagName('script')[0];
						s.parentNode.insertBefore(gcse, s);
					})();
				</script>
				<gcse:search></gcse:search>
			</div>
			<?php } ?>
			<li><a href="<?php echo site_url(); ?>" class="selected">Home</a></li>
			<li><a href="<?php echo site_url('tools/unixreader'); ?>" class="selected">Unix reader</a></li>
			<li><a href="<?php echo site_url('tools/randomtext'); ?>" class="selected">Random text generator</a></li>
			<li><a href="<?php echo site_url('tools/flatcolors'); ?>" class="selected">Flat colors</a></li>
			<li><a href="<?php echo site_url('tools/textcounter'); ?>" class="selected">Text counter</a></li>
		</ul>
	</nav>
	<div class="footer clearfix">
		<ul class="social clearfix">
			<li><a href="http://www.facebook.com/plutrosearch" class="fb" data-title="Facebook" target="_blank"></a></li>
			<!-- <li><a href="#" class="twitter" data-title="Twitter" target="_blank"></a></li> -->
			<!-- <li><a href="#" class="google" data-title="Google +"></a></li> -->
			<!-- <li><a href="#" class="behance" data-title="Behance" target="_blank"></a></li> -->
			<!-- <li><a href="#" class="dribble" data-title="Dribble" target="_blank"></a></li> -->
			<!-- <li><a href="#" class="rss" data-title="RSS" target="_blank"></a></li> -->
		</ul>
		<div class="rights">
			<p>Copyright © 2014 <a href="http://axery.com" target="_blank">Axery.com</a></p>
		</div>
	</div>
</header>
<?php echo isset($html)? $html : ''; ?>
