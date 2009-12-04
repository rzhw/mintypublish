<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<?php $this->outputHead(); ?>
	</head>
	
	<body>
		<?php $this->outputBodyPre(); ?>
		<div id="shadow_top">
		<div id="global_wrapper">
			<header id="header">
			<h1 id="title"><?php echo $this->sitename; ?></h1>
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
			</header>
			
			<section id="content">
<!-- content start -->
<?php $this->outputContent(); ?>
<!-- content end -->
			</section>
			
			<div id="footer_wrapper">
				<?php echo $footer['copyright']; ?>
				| Generated in <?php echo $footer['generated']; ?> secs
			</div>
		</div>
		</div>
	</body>
</html>