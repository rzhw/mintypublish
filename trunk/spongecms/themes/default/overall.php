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
				$("#propertiesbubble").wrapInner('<div style="margin:48px 8px 8px 8px;"></div>');
				$("#propertiesbubble").css({
					'left': $("#propertiesbtn").position().left + $("#propertiesbtn").width() / 2 - $("#propertiesbubble").width() / 2,
					'top' : $("#propertiesbtn").position().top
				});
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
					<?php if (isloggedin() && $_GET['p'] != 'admin'): echo "\n"; ?>
					<div class="adminblock" id="propertiesbtn">
						<a href="javascript:void(0)">
							<img src="<?php echo $location['images']; ?>/admin_properties.png" alt="properties" />
						</a>
					</div>
					<div id="propertiesbubble" style="position:absolute;background:url('<?php echo $location['images']; ?>/admin_properties_bubble.png');font-size:11px;width:256px;height:128px;">
						hi
					</div>
					
					<div class="adminblock">
						<a href="javascript:$.pageEditor()">
							<img src="<?php echo $location['images']; ?>/admin_edit.png" alt="edit" />
						</a>
					</div>
					<?php echo "\n"; endif; ?>
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
			
			<section id="content">
<!-- content start -->
<?php $this->outputContent(); ?>
<!-- content end -->
			</section>
			
			<?php echo $footer['copyright']; ?>
		</div>
	</body>
</html>