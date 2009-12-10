<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<?php $this->outputHead(); ?>
	</head>
	
	<body>
		<?php $this->outputBodyPre(); ?>
		
		<script type="text/javascript">
			// temporary
			$(document).ready(function() {
				$(".adminblock").wrapInner('<div class="middle"></div>').prepend('<div class="left"></div>').append('<div class="right"></div>');
			});
		</script>
		
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
				<div style="float:right;">
					<?php if (isloggedin()): echo "\n"; ?>
					<div class="adminblock">
						<a href="index.php?p=admin">
							<img src="<?php echo $location['images']; ?>/admin_icon.png" alt="admin" />
							<div class="imgafter"><?php echo $_SESSION['uname']; ?></div>
						</a>
					</div>
					<?php echo "\n"; endif; ?>
				</div>
				<div style="clear:both;"></div>
			</div>
			</header>
			
			<div id="content_wrapper">
<!-- content start -->
<?php $this->outputContent(); ?>
<!-- content end -->
			</div>
			
			<?php echo $footer['copyright']; ?>
		</div>
	</body>
</html>