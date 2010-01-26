<?php
/*
Plugin Name: Houdini
Plugin URI: http://www.phkcorp.com?do=wordpress
Description: Prevents copying of a website through copy-n-paste of the rendered web pages
Version: 1.0
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

?>
		<div class="wrap">
			<h2>Houdini</h2>
<p>Provides a method to copy protect your webpages from plagarism and content theft.</p>

<p>The fact is the internet is open and open to theft especially to content stealing and plagarism.</p>

<p>Until now, there was very little to discourage and deter this serious crime. Yes content theft and
plagarism is a crime in some jurisdictions.</p>

<p>You cannot rely on others or the authorities to continue to police the internet as there as they
do not have enough resources. You need to protect your content and deter this theft.</p>

<p>The basic form of content theft is to copy and paste your content to another medium.</p>

<p>Well Houdini, prevents this by using a little known special algorithm that prevents copying by
making the selected text that is targeted by the perps to be copied to disappear! Yes disappear!!!
The only way to recover is to reload the page in the web browser. If they try again, the content
disappears again. As long as they keep trying to copy your content, the content will disappear
before they can get a chance to execute the Ctrl-C command!</p>

<p>After a few unsuccessful attempts, the theives will move on to a easier target.</p>

<p>Your safe!</p>


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
   if(len>250){
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
<center><h5>This page is copy protected</h5></center>
	';


	return $output;
}


//
// Hooks
//

add_shortcode('houdini', 'show_houdini_javascript');
add_action('admin_menu', 'addHoudiniToManagementPage');

?>