<?php
/**
 * mintypublish Content Management System
 * Copyright (c) 2009-2010 a2h
 * http://github.com/a2h/mintypublish
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
 */

// http://ianburris.com/tutorials/oophp-template-engine/
class PageBuilder
{
	private $title, $content, $stylesheets=array(), $javascripts=array(), $bodypre, $disabled=false, $sitename, $location, $bodyClasses;
	
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
		$this->addJS($this->location['js'].'/jquery-1.3.2.min.js');
		$this->addJS($this->location['js'].'/html5.js');
		$this->addJS($this->location['js'].'/flowplayer-3.1.0.min.js');
		$this->addJS($this->location['js'].'/swfobject.js');
		
		// admins need extra stuff loaded
		if (isloggedin())
		{
			$this->addJS($this->location['js'].'/tiny_mce/tiny_mce.js');
			$this->addJS($this->location['js'].'/ajaxupload.min.js');
			$this->addJS($this->location['js'].'/jquery.tree.min.js');
			$this->addJS($this->location['js'].'/jquery.json-2.2.min.js');
			$this->addJS($this->location['js'].'/mintypublish.admin.js');
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
		global $pid;
		echo '<div id="pid" style="display:none;">' . $pid . '</div>'."\n";
		echo $this->bodypre;
	}
	
	function addBodyClass($class)
	{
		$this->bodyClasses[] = $class;
	}
	
	function outputBodyClasses()
	{
		if (isloggedin())
		{
			$this->bodyClasses[] = 'admin';
		}
		
		$c = count($this->bodyClasses);
		for ($i=0; $i<$c; $i++)
		{
			if ($i > 0)
			{
				echo ' ';
			}
			echo $this->bodyClasses[$i];
		}
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
		
		echo "\t\t".'<meta name="generator" content="mintypublish pre-alpha" />'."\n";
		
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