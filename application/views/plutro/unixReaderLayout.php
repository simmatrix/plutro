<?php defined('BASEPATH') or die('Unauthorized Access');?>
<section class="main clearfix">
	<div class="row main-search-container">

		<div class="col-lg-11 text-center">
			<h3 class="text-plutro">Unix Reader</h3>
			<div class="input-group container-fluid marg-bott-25 col-lg-12">
				<input type="text" id="unixTime" class="form-control input-lg" placeholder="Please input your unix time string here..">
				<div class="input-group-btn">
					<button type="submit" id="unixTimeBtn" class="btn btn-lg btn-default text-plutro">
						Go
					</button>
				</div>
			</div>
			<div class="input-group container-fluid marg-bott-25 col-lg-3">
				<small class="text-plutro">Timezone</small>
				<input type="text" id="unixTimezone" class="form-control input-lg" placeholder="America/New_York">
			</div>
			<div class="unix-reader-result text-plutro">
				<small id="unixTimeFormat" style="display:none;">Day / Month / Year | Hour:Minute:Seconds</small>
				<div id="unixTimeResult"></div>
			</div>
		</div>
	</div>
</section>
