<script type="text/javascript">
var ribbonoffsets = {
	font: { left: 144 , top: 38 },
	paragraph: { left: 380, top: 38 }
};
</script>

<div class="mainContainer" style="display:none;">
	<ul class="ribbon">
		<li>
			<ul class="orb">
				<li>
					<a href="javascript:void(0);" accesskey="1" class="orbButton">&nbsp;</a><span>Menu</span>
					<ul>
						<li>
							<a href="#">
								<img src="<?php echo $location['ribbon']; ?>/icons/icon_save.png" /><span>Save</span>
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</li>
		<li>
			<ul class="menu">
				<li>
					<a href="#home" accesskey="2">Home</a>
					<ul>
						<li>
							<h2><span>Clipboard</span></h2>
							<div class="ribbon-list ribbon-list-tall">
								<div>
									<img src="<?php echo $location['ribbon']; ?>/icons/icon_paste.png" />
									Paste
									<ul style="display:none;width:160px !important;">
										<li id="thecontent_pastetext">Without formatting</li>
										<li id="thecontent_pasteword">With formatting</li>
									</ul>
								</div>
							</div>
							<div class="ribbon-list">
								<div>
									<img src="<?php echo $location['ribbon']; ?>/icons/icon_small_cut.png" />
									Cut
								</div>
								<div>
									<img src="<?php echo $location['ribbon']; ?>/icons/icon_small_copy.png" />
									Copy
								</div>
							</div>
						</li>
						<li>
							<h2><span>Font</span></h2>
							<div class="ribbon-list" style="width:208px !important;"></div>
						</li>
						<li>
							<h2><span>Paragraph</span></h2>
							<div class="ribbon-list" style="width:88px !important;"></div>
						</li>
						<li>
							<h2>
								<span>Insert</span>
							</h2>
							<div id="thecontent_mediasponge">
								<img src="<?php echo $location['ribbon']; ?>/icons/icon_picture.png" />
								Media
							</div>
						</li>
						<li>
							<h2>
								<span>Advanced</span>
							</h2>
							<div id="thecontent_code">
								<img src="<?php echo $location['ribbon']; ?>/icons/icon_picture.png" />
								HTML
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</li>
	</ul>
</div>