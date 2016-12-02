<?php
classe('o', 'page-header') ;
display('page_traduction', 'h1' ) ;
classe('c') ;

?>

<form method='post' action='/?page=traduction'>
<table class="table table-striped table-hover table-condensed">
<tr>
	<th style="width: 20%;">
		Keyword
	</th>
	<th style="width: 40%;">
		Value in reference language (<?php echo $ref ; ?>)
	</th>
	<th style="width: 40%;">
		Value in current language (<?php echo $cur ; ?>)
	</th>
</tr>

<?php 

foreach( $langueRef as $keyword => $values)
{
	echo "<tr>";
		echo "<td><b>";
			echo $keyword ;
		echo "</td><b>";
		
		echo "<td>";
			echo htmlspecialchars($values) ;
		echo "</td>";
		
		echo "<td>";
			echo '<input class="	form-control" type="text" name='.$keyword.' value="' . $langueCur[$keyword] .'">' ;
		echo "</td>";
	echo "</tr>";
	
}

?>

</table>
<button class="btn btn-success" type='submit'><span class="glyphicon glyphicon-floppy-disk"></span> Save changes</button>
</form>
