<div class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
	<div class="container">
		<a href="../" class="navbar-brand">
			<img src="<?= FRONTEND3_STATIC_FILES ?>images/logo-2.png" style='width: 200px; height: 50px;' alt="">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto">

				<?php
				if (isset($menu)) {
					foreach ($menu as $data) {
						$active = ''; 
						$label = $data['label'];
						$style = "";
						if ($active_page == $data ['page_name']) {
							$active = 'active';             
							$style = "style='color:#4582ec9e'";   
							$label = $data['label'];
						}
						if(!isset($data['icon'])){
							$data['icon'] = "";
						}
						?>

						<li class="nav-item "><a href="<?= $data['link'] ?>" <?=$style?> class="nav-link <?=$active?>"> 
							<span><?= $label ?> <i class="<?= $data['icon'] ?>"></i></span>
						</a></li>

						<?php

					}
				}
				?>
				<li class="nav-item "><a href="javascrip:void(0)"  class="nav-link  " onclick='ShowLogoutModal()'> 
					<span>Keluar <i class="fa fa-sign-out"></i></span>
				</a></li>
			</ul>

		</div>
	</div>
</div>
<div style='margin-top:100px;'>

