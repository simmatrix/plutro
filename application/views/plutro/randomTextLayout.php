<?php defined('BASEPATH') or die('Unauthorized Access');?>
<section class="main clearfix">
	<div class="row marg-top-75">
		<div class="col-lg-11 text-center">
			<h3 class="text-plutro">Please select your generator</h3>
			<div class="row">
				<button id="randomCharacterBtn" class="btn btn-default btn-primary">Characters</button>
				<button id="randomWordBtn" class="btn btn-default">Words</button>
			</div>
			<textarea id="randomTextbox" class="form-control marg-y-25" rows="15"></textarea>
			<div class="input-group container-fluid marg-bott-25 col-lg-2">
				<input type="text" class="form-control input-lg" id="randomTextAmount" value="100" placeholder="100">
				<div class="input-group-btn">
					<button type="submit" id="randomTextBtn" class="btn btn-lg btn-default text-plutro">
						Go
					</button>
				</div>
			</div>
		</div>
	</div>
</section>
