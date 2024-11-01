<?php
/*
Plugin Name: WP FreeStyle Wiki
Plugin URI: http://wordpress.org/extend/plugins/wp-freestyle-wiki/
Description: Enables the use of FreeStyle Wiki markup in your posts/pages
Version: 0.2.2
Author: Jun Futagawa
Author URI: http://jfut.integ.jp/
*/

/*  Copyright 2009-2010 Jun Futagawa

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class WP_FreeStyle_Wiki
{
	const NAME = 'WP FreeStyle Wiki';
	const VERSION = '0.2.2';

	const PROCESS_WIKI = 'process_wiki.pl';
	const FSWIKI = 'fswiki/wiki.cgi';

	var $url = '';
	var $path = '';
	var $convertCount = 0; // for fswiki_navigateor_id

	function getInstance() {
		static $plugin = null;
		if (!$plugin) {
			$plugin = new WP_FreeStyle_Wiki();
		}
		return $plugin;
	}

	function init() {
		$this->url = get_bloginfo('url').'/wp-content/plugins/'.end(explode(DIRECTORY_SEPARATOR, dirname(__FILE__)));
		$this->path = getcwd().'/wp-content/plugins/'.end(explode(DIRECTORY_SEPARATOR, dirname(__FILE__)));
		add_action('wp_head', array($this,'head'));
		add_action('the_content', array($this,'the_content'), 7);
		add_filter('edit_page_form', array($this,'edit_form_advanced')); // for page
		add_filter('edit_form_advanced', array($this,'edit_form_advanced')); // for post
		if (!is_executable(dirname(__FILE__).'/'.WP_FreeStyle_Wiki::PROCESS_WIKI)) {
			chmod(dirname(__FILE__).'/'.WP_FreeStyle_Wiki::PROCESS_WIKI, 0755);
			clearstatcache();
		}
		if (!is_executable(dirname(__FILE__).'/'.WP_FreeStyle_Wiki::FSWIKI)) {
			chmod(dirname(__FILE__).'/'.WP_FreeStyle_Wiki::FSWIKI, 0755);
			clearstatcache();
		}
	}

	function head() {
	?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->url?>/fswiki.css"/>
	<?php
	}

	function the_content($str) {
		$replace = 'return wp_fswiki($matches[1]);';
		return preg_replace_callback('/\[fswiki\](.*?)\[\/fswiki\]/s',create_function('$matches',$replace),$str);
	}

	function edit_form_advanced() {
?>
<script type="text/javascript" src="<?php echo $this->url?>/admin.js"></script>
<?php
	}

	function convert($text) {
		$navigator = 'fswiki_content'.$this->convertCount++;
		return '<div id="'.$navigator.'" class="fswiki_content">'.$this->convert_html($text).'</div>';
	}

	function convert_html($text) {
		$descriptorspec = array(
			0 => array('pipe', 'r'),
			1 => array('pipe', 'w'),
		);
		$process = proc_open(
			dirname(__FILE__).'/'.WP_FreeStyle_Wiki::PROCESS_WIKI,
			$descriptorspec, $pipes, $this->path
		);

		if (is_resource($process)) {
			fwrite($pipes[0], $text);
			fclose($pipes[0]);
			$result = stream_get_contents($pipes[1]);
			fclose($pipes[1]);
			proc_close($process);
			return $result;
		} else {
			return __("Failed to parse fswiki notation!");
		}
	}
}

add_action('init', 'fswiki_init');
function fswiki_init() {
	$p = WP_FreeStyle_Wiki::getInstance();
	$p->init();
}

function wp_fswiki($text) {
	$p = WP_FreeStyle_Wiki::getInstance();
	return $p->convert($text);
}
