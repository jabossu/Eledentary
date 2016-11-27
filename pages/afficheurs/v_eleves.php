<?php

classe('o', 'page-header') ;
display('page_eleves', 'h1') ;
classe('c') ;

display('page_eleves_msg') ;

?>



<div class='liste' id='top'>

<center>
	<a class="btn btn-primary<?php echo ( $r == 'all' ) ? ' active' : '' ; ?>" href="?page=eleves&year=<?php echo $y ; ?>&role=all" ><span  class="glyphicon glyphicon-ok" ></span> <?php display('all_status') ; ?></a>
	<a class="btn btn-primary<?php echo ( $r == 'administrateur' ) ? ' active' : '' ; ?>" href="?page=eleves&year=<?php echo $y ; ?>&role=administrateur" ><span  class="glyphicon glyphicon-star" ></span> <?php display('administrateur') ; ?></a>
	<a class="btn btn-primary<?php echo ( $r == 'approuve' ) ? ' active' : '' ; ?>" href="?page=eleves&year=<?php echo $y ; ?>&role=approuve" ><span  class="glyphicon glyphicon-user" ></span> <?php display('approuve') ; ?></a>
	<a class="btn btn-primary<?php echo ( $r == 'nouveau' ) ? ' active' : '' ; ?>" href="?page=eleves&year=<?php echo $y ; ?>&role=nouveau" ><span  class="glyphicon glyphicon-time" ></span> <?php display('nouveau') ; ?></a>
	<a class="btn btn-primary<?php echo ( $r == 'banni' ) ? ' active' : '' ; ?>" href="?page=eleves&year=<?php echo $y ; ?>&role=banni" ><span  class="glyphicon glyphicon-remove" ></span> <?php display('banni') ; ?></a>
</center><br/>

<ul class="nav nav-tabs">
	<li<?php if ( $y == 0 ) { echo ' class="active" ' ; } ?>>
		<a href="/?page=eleves&year=0&role=<?php echo $r ; ?>" >	<?php display('all_years') ; ?></a></li>
	<li<?php if ( $y == 3 ) { echo ' class="active" ' ; } ?>>
		<a href="/?page=eleves&year=3&role=<?php echo $r ; ?>">		<?php display('3') ; ?></a></li>
	<li<?php if ( $y == 4 ) { echo ' class="active" ' ; } ?>>
		<a href="/?page=eleves&year=4&role=<?php echo $r ; ?>">		<?php display('4') ; ?></a></li>
	<li<?php if ( $y == 5 ) { echo ' class="active" ' ; } ?>>
		<a href="/?page=eleves&year=5&role=<?php echo $r ; ?>">		<?php display('5') ; ?></a></li>
	<li<?php if ( $y == 6 ) { echo ' class="active" ' ; } ?>>
		<a href="/?page=eleves&year=6&role=<?php echo $r ; ?>">		<?php display('6') ; ?></a></li>
</ul>

<div class="table-responsive">
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th style="width: 15%" >#</th>
			<th style="width: 30%" ><?php display('nom') ; ?></th>
			<th style="width: 30%" ><?php display('prenom') ; ?></th>
			<th style="width: 25%" ><?php display('annee') ; ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($liste_eleves as $eleve)
			{
				if ( $eleve->statut() == 'banni' )
				{	$icone = '<span class="glyphicon glyphicon-remove-circle" ></span>' ;	}
				elseif ($eleve->statut() == 'nouveau')
				{	$icone = '<span class="glyphicon glyphicon-time" ></span>' ;	}
				elseif ($eleve->statut() == 'administrateur')
				{	$icone = '<span class="glyphicon glyphicon-star" ></span>' ;	}
				else
				{	$icone = '<span class="glyphicon glyphicon-user" ></span>' ;	}
				$icone = $icone . '&nbsp;&nbsp;-&nbsp;&nbsp;' ;
			
				echo "<tr> \n" ;
				echo '<td><b>' . $icone . $eleve->matricule() . '</b></td>' ;
				echo '<td><b>' . '<a href="?page=profile&id=' . $eleve->id() . '">' . $eleve->nom() . '</b></td>' ;
				echo '<td>' . $eleve->prenom() . '</td>' ;
				echo '<td>' . translate( $eleve->annee() ) . '</td>' ;
				echo "\n</tr>" ;
			}
		?>
	</tbody>
</table>
<a class="btn btn-info btn-block" href='#top'><span class="glyphicon glyphicon-arrow-up"></span> <?php display('back_to_top') ;?> <span class="glyphicon glyphicon-arrow-up"></span></a>

</div>
</div>
