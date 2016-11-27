<?php

classe('o', 'page-header');
display('page_patients', 'h1') ;
classe('c');

$button = function ($lien, $texte, $type, $activable=true, $othertab=false)
{
	$a = ($activable == false)	? 'active' : '' ;
	$o = ($othertab == true)	? ' target="_blank" ' : '' ;
	echo '<br /><a href="' . $lien . '" class="btn btn-block btn-' . $type . ' ' . $a . '"' . $o . '>' . translate($texte) . "</a>\n";
};


classe('o', 'row');

classe('o', 'col-sm-9');
	?>
	<div class='liste' id='top'>
	<div class="table-responsive">
	<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th style="width: 15%" >#</th>
			<th style="width: 15%" ><?php display('initiales') ; ?></th>
			<th style="width: 20%" ><?php display('pathologie') ; ?></th>
			<th style="width: 50%" ><?php display('details') ; ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($liste as $p)
			{
				echo "<tr> \n" ;
				echo '<td><b>' . $p->id() . ' ; </b><i>' . $p->cnp() . '</i></td>' ;
				echo '<td><b>' . '<a href="?page=profile_patient&id=' . $p->id() . '">' . substr($p->prenom(), 0, 1) . '. ' . substr($p->nom(), 0, 2) . '.' . '</b></td>' ;
				echo '<td>' . $p->patho() . ' (' . $p->annees() . ') ' . '</td>' ;
				echo '<td>' . $p->details() . '</td>' ;
				echo "\n</tr>" ;
			}
		?>
	</tbody>
	</table>
	<a class="btn btn-info btn-block" href='#top'><span class="glyphicon glyphicon-arrow-up"></span> <?php display('back_to_top') ;?> <span class="glyphicon glyphicon-arrow-up"></span></a>
	</div>
	</div>
	<?php
	
classe('c') ;

classe('o', 'col-sm-3') ;
	
	
	$f = new form();
	$qm = new pathologiesManager($bdd) ;
	$l = $qm->liste() ; $choix = array( 0 => 'Toutes / All') ;
	foreach ( $l as $v )
	{
		$choix[$v->id()] = $v->nom() ; 
	}
	$f->liste('patho', translate('select_patho'), $choix, $_POST['patho']) ;
	$f->submit( translate('filtrer') ) ;
	$f->output() ;

	?>
	<hr><table><?php
	foreach ( $choix as $k => $v )
	{
		echo "\n\t\t<tr><td style='width: 90%'>". $v . '</td><td style="width: 20%"><span class="badge">' .$pm->compter( $k ) . "</span></td></tr>" ; 
	}
	?>
	</table><hr>
	<a class="btn btn-success btn-block" href='?page=profile_patient'><?php display('create_patient') ; ?></a>
	<?php

classe('c') ;

classe('o', 'col-sm-3') ;

classe('c') ;

classe('c') ;


