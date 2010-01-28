<?php
/*
Plugin Name: Houdini
Plugin URI: http://www.phkcorp.com?do=wordpress
Description: Prevents copying of a website through copy-n-paste of the rendered web pages
Version: 1.2
Author: PHK Corporation
Author URI: http://www.phkcorp.com
*/

/*

	Copyright 2010  PHK Corporation  (email : phkcorp2005@gmail.com)

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

function addHoudiniSettingsTable ()
{
	global $wpdb;

	if (is_admin()) {

		$query = "CREATE TABLE IF NOT EXISTS `wp_houdini_settings` (
  				`pagetext` varchar(255) NOT NULL)
				ENGINE=MyISAM DEFAULT CHARSET=latin1;";

		$wpdb->query($query);

		$query = "ALTER TABLE `wp_houdini_settings` ADD `textsize` INT NOT NULL DEFAULT '250'";
		$wpdb->query($query);

	} // endif of is_admin()
}


//// Add page to options menu.
function addHoudiniToManagementPage()
{
    // Add a new submenu under Options:
    add_options_page('Houdini', 'Houdini', 8, 'houdini', 'displayHoudiniManagementPage');
}

// Display the admin page.
function displayHoudiniManagementPage()
{
	global $wpdb;

	if (is_admin()) {
		// Create the tables, if they do not exist?
		addHoudiniSettingsTable();

		if (isset($_POST['houdini_update']))
		{
			//check_admin_referer();

			$pageText = $_POST['houdini_text_tag'];
			//if ($pageText == '') $pageText = 'This page is copy protected';

			$textSize = $_POST['houdini_textsize_tag'];
			if ($textSize == '') $textSize = 0;

			$wpdb->query("TRUNCATE TABLE wp_houdini_settings");

			$sql = "insert into wp_houdini_settings (pagetext,textsize) values ('".$pageText."','".$textSize."')";
			$wpdb->query($sql);

			// echo message updated
			echo "<div class='updated fade'><p>Houdini settings have been updated with.</p></div>";
		}

		$t = $wpdb->get_col("select pagetext from wp_houdini_settings");
		$pageText = $t[0];
		$t = $wpdb->get_col("select textsize from wp_houdini_settings");
		$textSize = $t[0];

?>
		<div class="wrap">
			<h2>Houdini</h2>



			<form method="post">
				<fieldset class='options'>
					<legend><h2><u>Settings</u></h2></legend>
					<table class="editform" cellspacing="2" cellpadding="5" width="100%">
						<tr>
							<th width="30%" valign="top" style="padding-top: 10px;">
								Page Text:
							</th>
							<td>
								<input type='text' size='30' maxlength='80' name='houdini_text_tag' id='houdini_text_tag' value='<?php echo $pageText;?>' />
								<br>Display a single line of text (or no text)<br>
							</td>
						</tr>
						<tr>
							<th width="30%" valign="top" style="padding-top: 10px;">
								Text Size:
							</th>
							<td>
								<input type='text' size='10' maxlength='10' name='houdini_textsize_tag' id='houdini_textsize_tag' value='<?php echo $textSize;?>' />
								<br>Specify minimum selected text before deselection/disappearance<br>
							</td>
						</tr>
						<tr>
							<td colspan="2">
							<p class="submit"><input type='submit' name='houdini_update' value='Update' /></p>
							</td>
						</tr>
					</table>
				</fieldset>
			</form>


				<fieldset class='options'>
					<legend><h2><u>Tips &amp; Techniques</u></h2></legend>
						<p>To use this plugin, simply insert the shortcode [houdini] on the pages or posts
						that you want to prevent plagarism of your website.</p>
						<p>When someone tries to select some text on your website, that selection will soon disappear
						preventing the visitor from copying the selected text. To restore the page, the visitor must
						reload the page</p>
						<p><strong>To disable the context or right mouse click menu,</strong> add the following to the
						body tag in your theme header.php [oncontextmenu="return false;" to look similar to
						&lt;body oncontextmenu="return false;"&gt;]
						<p>Now you have tight and full security over plagarism of your site</p>
				</fieldset>

				<fieldset class='options'>
					<legend><h2><u>About the Architecture</u></h2></legend>
						<p>This plugin uses a little know special javascript algorithm to make selected text disappear.</p>
				</fieldset>

				<fieldset class='options'>
					<legend><h2><u>Wordpress Development</u></h2></legend>
<p><a href="http://www.phkcorp.com" target="_blank">PHK Corporation</a> is available for custom Wordpress development which includes development of new plugins, modification
of existing plugins, migration of HTML/PSD/Smarty themes to wordpress-compliant <b>seamless</b> themes.</p>
<p>You may see our samples at <a href="http://www.phkcorp.com?do=wordpress" target="_blank">www.phkcorp.com?do=wordpress</a></p>
<p>Please email at <a href="mailto:phkcorp2005@gmail.com">phkcorp2005@gmail.com</a> or <a href="http://www.phkcorp.com?do=contact" target="_blank">www.phkcorp.com?do=contact</a> with your programming requirements.</p>
				</fieldset>

				<fieldset class='options'>
					<legend><h2><u>Plugin PHP Code</u></h2></legend>
<p>Here is the actual plugin code.</p>
<p>
<code>
&lt;script language=javascript&gt;<br/>
function getSelText(){<br/>
&nbsp;&nbsp;var txt="";<br/>
&nbsp;&nbsp;if(window.getSelection){<br/>
&nbsp;&nbsp;&nbsp;txt=window.getSelection()<br/>
&nbsp;&nbsp;} else if(document.getSelection){<br/>
&nbsp;&nbsp;&nbsp;txt=document.getSelection()<br/>
&nbsp;&nbsp;} else if(document.selection){<br/>
&nbsp;&nbsp;&nbsp;txt=document.selection.createRange().text<br/>
&nbsp;&nbsp;} else return 0;<br/>
<br/>
&nbsp;&nbsp;txt+="";<br/>
&nbsp;&nbsp;len=txt.length;<br/>
&nbsp;&nbsp;return len;<br/>
}<br/>
function displayPage(){<br/>
&nbsp;&nbsp;len=getSelText();<br/>
&nbsp;&nbsp;if(len>250){<br/>
&nbsp;&nbsp;&nbsp;if(window.getSelection){<br/>
&nbsp;&nbsp;&nbsp;&nbsp;window.getSelection().removeAllRanges()<br/>
&nbsp;&nbsp;&nbsp;} else if(document.selection&&document.selection.clear) {<br/>
&nbsp;&nbsp;&nbsp;&nbsp;document.selection.clear()<br/>
&nbsp;&nbsp;&nbsp;}<br/>
&nbsp;&nbsp;}<br/>
&nbsp;&nbsp;window.setTimeout("displayPage()",100)<br/>
}<br/>
<br/>
window.setTimeout ("displayPage()", 100 );<br/>
<br/>
&lt;/script&gt;
&lt;center&gt;&lt;h5&gt;This page is copy protected&lt;/h5&gt;&lt;/center&gt;

</code>
</p>
				</fieldset>
<?php
	} // endif of is_admin()
}



function show_houdini_javascript($atts, $content=null, $code="")
{
	global $wpdb;
	$t = $wpdb->get_col("select pagetext from wp_houdini_settings");

	$pageText = $t[0];
	$t = $wpdb->get_col("select textsize from wp_houdini_settings");
	$textSize = $t[0];

	$output = '
<script language=javascript>
function getSelText(){
   var txt="";
   if(window.getSelection){
     txt=window.getSelection()
   } else if(document.getSelection){
     txt=document.getSelection()
   } else if(document.selection){
     txt=document.selection.createRange().text
   } else return 0;

   txt+="";
   len=txt.length;
   return len
}
function displayPage(){
   len=getSelText();
   if(len>'.$textSize.'){
      if(window.getSelection){
         window.getSelection().removeAllRanges()
      } else if(document.selection&&document.selection.clear) {
         document.selection.clear()
      }
   }
   window.setTimeout("displayPage()",100)
}

window.setTimeout ("displayPage()", 100 );

</script>
<center><h5>'.$pageText.'</h5></center>
	';


	return $output;
}



//
// Hooks
//

add_shortcode('houdini', 'show_houdini_javascript');
add_action('admin_menu', 'addHoudiniToManagementPage');

?>