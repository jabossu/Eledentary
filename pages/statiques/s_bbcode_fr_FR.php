<div class="page-header">
<h1>Comment utiliser le BBcode :</h1>
</div>

<p>Le bbcode est un moyen d'intégrer des effets de style dans vos messages.<br/>
Pour ce faire, il vous suffit d'utiliser des <strong>balises BBcode</strong> de la façon suivante :<br/>
<code>[style] mon message [/style]</code><br/>
Selon ce par quoi vous remplacez "style", l'effet appliqué est différent.</p>

<p>Le BBcode simplifié que nous utilisons vous permet d'intégrer les effet suivants :
<ul class="well" style="margin-left : 75px; margin-right : 75px;" >
	<li><b>Texte Gras</b> : <code>[b]texte[/b]</code></li>
	<li><i>Texte italique</i> : <code>[i]texte[/i]</code></li>
	<li><u>Texte souligné</u> : <code>[u]texte[/u]</code></li>
	<li><strike>Texte barré</strike> : <code>[s]texte[/s]</code></li>
	
	<li><h1>Titre 1 : </h1><code>[h1]titre[/h1]</code></li>
	<li><h2>Titre 2 : </h2><code>[h2]titre[/h2]</code></li>
	<li><h3>Titre 3 : </h3><code>[h3]titre[/h3]</code></li>
	<li><h4>Titre 4 : </h4><code>[h4]titre[/h4]</code></li>
</ul>
</p>

<p>Nous avons également quelques émoticons intégrés, qui seront reconnus et transformés dans vos messages :

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
