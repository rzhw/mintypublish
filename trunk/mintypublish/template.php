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

// if someone stumbles across here, send them back up to the root
if (!$zvfpcms)
{
	header("HTTP/1.1 307 Temporary Redirect");
	header("Location: ..");
	exit();
}

class PageBuilder // thanks to http://ianburris.com/tutorials/oophp-template-engine/
{
	private $title, $content, $stylesheets=array(), $javascripts=array(), $bodypre, $disabled=false, $sitename, $location, $bodyClasses;
	
	function __construct()
	{
		global $auth, $sitename, $location;
		
		// outside stuff
		$this->sitename = $sitename;
		$this->location = $location;
		
		// default stuff to output header
		$this->title = 'Unnamed Page';
		$this->addCSS($this->location['styles'].'/all.css', 'all');
		$this->addCSS($this->location['styles'].'/print.css', 'print');
		$this->addJS($this->location['js'].'/jquery-1.4.2.min.js');
		$this->addJS($this->location['js'].'/html5.js');
		$this->addJS($this->location['js'].'/swfobject.js');
		
		// admins need extra stuff loaded
		if ($auth->isLoggedIn())
		{
			$this->addJS($this->location['js'].'/tiny_mce/tiny_mce.js');
			$this->addJS($this->location['js'].'/ajaxupload.min.js');
			$this->addJS($this->location['js'].'/jquery.tree.min.js');
			$this->addJS($this->location['js'].'/jquery.jqDnR.min.js');
			$this->addJS($this->location['js'].'/mintypublish.admin.js');
		}
		
		// start capturing the content
		ob_start();
	}
	
	// look into __deconstruct
	
	public function disableTemplate()
	{
		$this->disabled = true;
	}
	
	public function setTitle($title)
	{
		global $sitename;
		$this->title = $title;
	}
	
	public function setType($type)
	{
		$this->type = $type;
	}
	
	public function addCSS($path, $media='')
	{
		$this->stylesheets[] = array('href' => $path, 'media' => $media);
	}
	
	public function addJS($path)
	{
		$this->javascripts[] = $path;
	}
	
	public function addBodyPre($content)
	{
		$this->bodypre .= $content;
	}
	
	public function addBodyPreInc($content)
	{
		global $location;
		ob_start();
		include($content);
		$this->bodypre .= ob_get_clean();
	}
	
	public function outputBodyPre()
	{
		global $pid;
		echo '<div id="pid" style="display:none;">' . $pid . '</div>'."\n";
		echo $this->bodypre;
	}
	
	public function addBodyClass($class)
	{
		$this->bodyClasses[] = $class;
	}
	
	public function outputBodyClasses()
	{
		global $auth;
		
		if ($auth->isLoggedIn())
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
	
	public function getMenu()
	{
		global $menu;
		return $menu;
	}
	
	public function outputHead()
	{
		echo '<title>'.$this->sitename.' | '.$this->title.'</title>'."\n";
		
		echo "\t\t".'<script type="text/javascript">var loc = {';
		global $location;
		$i = 0;
		foreach ($location as $key => $value)
		{
			if ($i > 0)
			{
				echo ',';
			}
			echo "'$key':'$value'";
			$i++;
		}
		echo '};</script>'."\n";
		
		echo "\t\t".'<meta name="generator" content="mintypublish ' . MP_VERSION . '" />'."\n";
		
		foreach ($this->stylesheets as $stylesheet)
		{
			echo "\t\t".'<link rel="stylesheet" type="text/css"' . ($stylesheet['media'] ? ' media="'.$stylesheet['media'].'"' : '') . ' href="' . $stylesheet['href'] . '" />'."\n";
		}
		foreach ($this->javascripts as $javascript)
		{
			echo "\t\t".'<script type="text/javascript" src="'.$javascript.'"></script>'."\n";
		}
	}
	
	public function outputContent()
	{
		echo $this->content;
	}
	
	public function outputAdminMenu() // might want to split out the include functionality here
	{
		global $auth;
		
		if ($auth->isLoggedIn())
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
			
			// are the php devs sadistic or what, because file_exists() is an amazingly poorly written function
			$thminclude =
				$_SERVER['DOCUMENT_ROOT']
				. str_replace('/' . basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME'])
				. '/' . $this->location['root']
				. '/' . $this->location['theme_nr'] . '/admin_menu.php';
			
			if (file_exists($thminclude))
			{
				include($this->location['theme_nr'] . '/admin_menu.php');
			}
			else
			{
				include($this->location['theme_def_nr'] . '/admin_menu.php');
			}
		}
	}
	
	private function build()
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
	
	public function outputAll()
	{
		// stop capturing everything
		$this->content = ob_get_clean();
		
		// build the page
		echo $this->build();
	}
}
?>