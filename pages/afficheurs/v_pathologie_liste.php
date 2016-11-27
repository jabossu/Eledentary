<?php

classe('o', 'page-header');
display('page_listepatho', 'h1') ;
classe('c');

?>

<div class='liste' id='top'>

<div class="table-responsive">
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th style="width: 10%" >#</th>
			<th style="width: 20%" ><?php display('nom_patho') ; ?></th>
			<th style="width: 50%" ><?php display('patho_details') ; ?></th>
			<th style="width: 20%" ><?php display('annees_soignantes') ; ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($liste as $patholol)
			{
				echo "<tr> \n" ;
				echo '<td><b>' . $patholol->id() . '</b></td>' ;
				echo '<td><b>'  . $patholol->nom() . '</b> - <small><a href="?page=pathologie_add&id='.$patholol->id().'">edit</a></small></td>' ;
				echo '<td>' . $patholol->details() .  '</td>' ;
				echo '<td>' . str_replace(',', ' ; ', $patholol->p_annees() ) .  '</td>' ;
				echo "\n</tr>" ;
			}
		?>
	</tbody>
</table>
<a class="btn btn-info btn-block" href='#top'><span class="glyphicon glyphicon-arrow-up"></span> <?php display('back_to_top') ;?> <span class="glyphicon glyphicon-arrow-up"></span></a>

</div>
</div>
