<section class="page-top">
	<div class="container">
		<div class="col-md-4 col-sm-4">
			<h1><?php if(isset($bc1)){ echo $bc1; }?></h1>
		</div>
		<div class="col-md-8 col-sm-8">
			<ul class="pull-right breadcrumb">
				<li>
					<a href="<?=PUBLIC_WEBAPP_URL?>">
						Beranda
					</a>
				</li>				
				<li>
					<a href="<?=PUBLIC_WEBAPP_URL.'category/'?>">
						<?=$bc2?>
					</a>
				</li>        
				<li class='active'>
					<a href="">
						<?=$bc3?>
					</a>
				</li>        
			</ul>
		</div>
	</div>
</section>