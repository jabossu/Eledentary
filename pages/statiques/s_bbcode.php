<div class="page-header">
<h1>How to use BBcode :</h1>
</div>

<p>BBCode is a way for you to use style in your messages.
To do so, you may use <strong>bbcode tags</strong> in your writting as shown below : 
<code>[style] some text to style [/style]</code><br/>

Depending of what you replace "style with", various effects can be acheived.</p>

<p>We use a simplified version of BBcode wich allows following effects :
<ul class="well" style="margin-left : 75px; margin-right : 75px;" >
	<li><b>Bold text</b> : <code>[b]text[/b]</code></li>
	<li><i>Italic text</i> : <code>[i]text[/i]</code></li>
	<li><u>Underlined text</u> : <code>[u]text[/u]</code></li>
	<li><strike>Stroke out text</strike> : <code>[s]text[/s]</code></li>
	
	<li><h1>Heading 1 : </h1><code>[h1]Heading[/h1]</code></li>
	<li><h2>Heading 2 : </h2><code>[h2]Heading[/h2]</code></li>
	<li><h3>Heading 3 : </h3><code>[h3]Heading[/h3]</code></li>
	<li><h4>Heading 4 : </h4><code>[h4]Heading[/h4]</code></li>
</ul>
</p>

<p>We also integrated few emojis you can use in your messages. They will be atomatically transformed to images, provided they are preceeded and followed by a space.

<?php
classe('o', 'row');
classe('o', 'well col-sm-8 col-sm-push-2') ;
foreach ($smileys as $key => $image)
{
	classe('o', 'col-sm-3') ;
	echo '<code>' . str_replace('\\', '', $key) . '</code> &#10145; ' . '<img src="ressources/simple_smileys_1.7/' . $image . '.png">' ; 
	classe('c');
}
classe('c');

classe('c');
?>
</p>
