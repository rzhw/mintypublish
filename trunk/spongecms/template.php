<?php
/*
 * Sponge Content Management System
 * Copyright (c) 2009 a2h - http://a2h.uni.cc/
 * http://zvfpcms.sourceforge.net/
 *
 * Templating system originally developed for bugspray
 * issue tracking software
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Under section 7b of the GNU General Public License you are
 * required to preserve this notice.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

// http://ianburris.com/tutorials/oophp-template-engine/
class PageBuilder
{
	private $title, $content, $stylesheets=array(), $javascripts=array(), $bodypre, $disabled=false, $sitename, $location;
	
	function PageBuilder()
	{
		global $sitename, $location;
		
		// outside stuff
		$this->sitename = $sitename;
		$this->location = $location;
		
		// default stuff to output header
		$this->title = 'Unnamed Page';
		$this->addCSS($this->location['root'].'/global.css');
		$this->addCSS($this->location['styles'].'/screen.css');
		$this->addJS($location['js'].'/jquery-1.3.2.min.js');
		$this->addJS($location['js'].'/html5.js');
		$this->addJS($location['js'].'/cookies.js');
		$this->addJS($location['js'].'/flowplayer-3.1.0.min.js');
		
		// admins need extra stuff loaded
		if (isloggedin())
		{			
			$this->addJS($this->location['js'].'/tiny_mce/tiny_mce.js');
			$this->addJS($this->location['js'].'/jquery.pageeditor.js');
		}
		
		// start capturing the content
		ob_start();
	}
	
	function disableTemplate()
	{
		$this->disabled = true;
	}
	
	function setTitle($title)
	{
		global $sitename;
		$this->title = $title;
	}
	
	function setType($type)
	{
		$this->type = $type;
	}
	
	function addCSS($path)
	{
		$this->stylesheets[] = $path;
	}
	
	function addJS($path)
	{
		$this->javascripts[] = $path;
	}
	
	function addBodyPre($content)
	{
		$this->bodypre .= $content;
	}
	
	function addBodyPreInc($content)
	{
		global $location;
		ob_start();
		include($content);
		$this->bodypre .= ob_get_clean();
	}
	
	function outputBodyPre()
	{
		echo $this->bodypre;
	}
	
	function getMenu()
	{
		global $menu;
		return $menu;
	}
	
	function outputHead()
	{
		echo '<title>'.$this->sitename.' | '.$this->title.'</title>'."\n";
		
		echo "\t\t".'<script type="text/javascript">var loc=[];';
		global $location;
		foreach ($location as $key => $value)
		{
			echo 'loc[\''.$key.'\']=\''.$value.'\';';
		}
		echo '</script>'."\n";
		
		foreach ($this->stylesheets as $stylesheet)
		{
			echo "\t\t".'<link rel="stylesheet" type="text/css" href="'.$stylesheet.'" />'."\n";
		}
		foreach ($this->javascripts as $javascript)
		{
			echo "\t\t".'<script type="text/javascript" src="'.$javascript.'"></script>'."\n";
		}
	}
	
	function outputContent()
	{
		echo $this->content;
	}
	
	function outputAdminMenu()
	{
		if (isloggedin())
		{
			global $menu, $pid;
			foreach ($menu as $menuitem)
			{
				if ($menuitem['id'] == $pid)
				{
					$curpg = $menuitem;
				}
			}
			$location = $this->location;
			include($this->location['theme_nr'].'/admin_menu.php');
		}
	}
	
	function build()
	{
		if ($this->disabled)
		{
			return $this->content;
		}
		else
		{
			global $footer;
			ob_start();
			$location = $this->location;
			include($this->location['theme_nr'].'/overall.php');
			return ob_get_clean();
		}
	}
	
	function outputAll()
	{
		// stop capturing everything
		$this->content = ob_get_clean();
		
		// build the page
		echo $this->build();
	}
}
?>