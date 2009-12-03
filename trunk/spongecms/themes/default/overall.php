<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<?php $this->outputHead(); ?>
	</head>
	
	<body>
		<?php $this->outputBodyPre(); ?>
		
		<div id="contentbg"></div>
		
		<div id="global_wrapper">
			<img src="<?php echo $location['images']; ?>/logo.png" alt="" />
			
			<div id="menu_wrapper">
				<nav>
					<ul>
					<?php
					foreach ($this->getMenu() as $item)
					{
						if (!$item['hide'])
						echo '
						<li'.($item['selected']?' class="sel"':'').'>
							<a href="'.$item['url'].'">'.$item['name'].'</a>
						</li>';
					}
					?>
					</ul>
				</nav>
				<div style="float:right;overflow:hidden;">
					<?php					
					if (isloggedin())
					{
						echo '<b>Logged in as: '.$_SESSION['uname'].'</b>
						(<a href="index.php?p=admin">admin</a> |
						<a href="'.$location['admin'].'&amp;s=logout">logout</a>)';
					}
					else
					{
						echo '<b>Not logged in</b>
						(<a href="index.php?p=admin">login</a> |
						<a href="'.$location['admin'].'&amp;s=register">register</a>)';
					}
					?>
				</div>
				<div style="clear:both;"></div>
			</div>
			
			<div id="content_wrapper">
<!-- content start -->
<?php $this->outputContent(); ?>
<!-- content end -->
			</div>
			
			<div id="footer_wrapper">
				<?php echo $footer['copyright']; ?>
				| Generated in <?php echo $footer['generated']; ?> secs
			</div>
		</div>
	</body>
</html>