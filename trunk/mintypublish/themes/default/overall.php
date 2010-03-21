<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="shortcut icon" href="<?php echo $location['images']; ?>/favicon.ico" />
		<?php $this->outputHead(); ?>
	</head>
	
	<body class="<?php $this->outputBodyClasses(); ?>">
		<?php $this->outputBodyPre(); ?>
		
		<?php $this->outputAdminMenu(); ?>
		
		<div id="container">
			<header id="header">
				<div id="title">
					<h1><?php echo $this->sitename; ?></h1>
				</div>
				
				<div id="menu">
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
					<div style="clear:both;"></div>
				</div>
			</header>
			
			<section id="content">
<?php $this->outputContent(); ?>
			</section>
			
			<?php echo $footer['copyright']; ?>
		</div>
	</body>
</html>