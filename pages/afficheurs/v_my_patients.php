<?php

classe('o', 'page-header') ;
display('my_patient', 'h1') ;
classe('c') ;

?>

<div class='liste' id='top'>

<div class="table-responsive">
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th style="width: 10%" >#id</th>
			<th style="width: 60%" ><?php display('nom') ;echo ' ' ; display('prenom') ;?></th>
			<th style="width: 30%" ><?php display('patho_nom') ; ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($liste as $p)
			{
				echo "<tr> \n" ;
				echo '<td><b>' . $p->id() . '</b></td>' ;
				echo '<td><b>' . '<a href="?page=profile_patient&id=' . $p->id() . '">' . $p->nom() . ' ' . $p->prenom() . '</td>' ;
				echo '<td>' . $p->patho() .  '</td>' ;
				echo "\n</tr>" ;
			}
		?>
	</tbody>
</table>

</div>
</div>
