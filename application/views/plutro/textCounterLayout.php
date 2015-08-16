<?php defined('BASEPATH') or die('Unauthorized Access');?>
<section class="main clearfix">
	<div class="row marg-top-75">
		<div class="col-lg-11 text-center">
			<h3 class="text-plutro">Please select your counter</h3>
			<div class="row">
				<button id="countCharacterBtn" class="btn btn-default btn-primary">Characters</button>
				<button id="countWordBtn" class="btn btn-default">Words</button>
			</div>
			<textarea id="countTextbox" class="form-control marg-y-25" rows="15"></textarea>
			<div class="countResult text-plutro marg-y-25"></div>
			<div class="row marg-bott-75">
				<button type="submit" id="countTextBtn" class="btn btn-lg btn-default text-plutro">
					Count
				</button>
			</div>
		</div>
	</div>
</section>
