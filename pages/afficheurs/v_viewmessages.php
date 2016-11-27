<?php

classe('o', 'page-header top') ;
display('page_viewmessages', 'h1');
classe('c') ;


//classe('o', 'page-header top') ;
display('page_vm_msg', 'p');
//classe('c') ;


classe('o', 'page-header text-right') ;
display('title_msg_unread', 'h4');
classe('c') ;
?>
<div class="table-responsive">
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th style="width: 10%" >#</th>
			<th style="width: 50%" ><?php display('objet') ; ?></th>
			<th style="width: 25%" ><?php display('expediteur') ; ?></th>
			<th style="width: 15%" ><?php display('date') ; ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($lm['nonlus'] as $message)
			{
				echo "<tr> \n" ;
				echo '<td>' . $message->id() . '</td>' ;
				echo '<td>' . '<a href="/?page=readmessage&id=' . $message->id() . '">' . $message->objet() . '</a>' . '</td>' ;
				echo '<td><b>' . $message->nom() . ' ' . substr($message->prenom(), 0,1) . '.</b></td>' ;
				echo '<td>' . $message->jour() . '</td>' ;
				echo "\n</tr>" ;
			}
		?>
	</tbody>
</table>
</div>
<a class="btn btn-default btn-block" href='#top'><span class="glyphicon glyphicon-arrow-up"></span> Retour en haut <span class="glyphicon glyphicon-arrow-up"></span></a>

<?php
classe('o', 'page-header text-right') ;
display('title_msg_read', 'h4');
classe('c') ;
?>
<div class="table-responsive">
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th style="width: 10%" >#</th>
			<th style="width: 50%" ><?php display('objet') ; ?></th>
			<th style="width: 25%" ><?php display('expediteur') ; ?></th>
			<th style="width: 15%" ><?php display('date') ; ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($lm['lus'] as $message)
			{
				echo "<tr> \n" ;
				echo '<td>' . $message->id() . '</td>' ;
				echo '<td>' . '<a href="/?page=readmessage&id=' . $message->id() . '">' . $message->objet() . '</a>' . '</td>' ;
				echo '<td><b>' . $message->nom() . ' ' . substr($message->prenom(), 0,1) . '.</b></td>' ;
				echo '<td>' . $message->jour() . '</td>' ;
				echo "\n</tr>" ;
			}
		?>
	</tbody>
</table>
</div>
<a class="btn btn-default btn-block" href='#top'><span class="glyphicon glyphicon-arrow-up"></span> Retour en haut <span class="glyphicon glyphicon-arrow-up"></span></a>
