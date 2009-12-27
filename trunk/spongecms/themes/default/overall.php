<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<?php $this->outputHead(); ?>
	</head>
	
	<body>
		<?php $this->outputBodyPre(); ?>
		
		<div id="global_wrapper">
			<header id="header">
			<h1 id="title"><?php echo $this->sitename; ?></h1>
			<div id="menu_wrapper">
				<nav>
					<ul><?php
					foreach ($this->getMenu() as $item)
					{
						if (!$item['hide'])
						echo '
						<li'.($item['selected']?' class="sel"':'').'>
							<a href="'.$item['url'].'">'.$item['name'].'</a>
						</li>';
					}
					echo "\n";
					?>
					</ul>
				</nav>
				<?php $this->outputAdminMenu(); ?>
				<div style="clear:both;"></div>
			</div>
			</header>
			
			<section id="content">
<!-- content start -->
<?php $this->outputContent(); ?>
<!-- content end -->
			</section>
			
			<?php echo $footer['copyright']; ?>
		</div>
	</body>
</html>