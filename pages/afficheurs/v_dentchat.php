<?php

classe('o', 'page-header');
display('page_dentchat', 'h1' );
classe('c') ;

?>

<form method="post" action="?page=dentchat" class="form-inline well" role='form'>
<fieldset>
	<input type="text" name="message" class="form-control" style="width: 80% ;" placeholder="type your message here..."/>
	<button type="submit" class="btn btn-primary text-right" >Send</button>
</fieldset>
</form>

<script>
 $(document).ready(function() {
 	 $("#responsecontainer").load("/pages/afficheurs/x_dentchat_frame.php");
   var refreshId = setInterval(function() {
      $("#responsecontainer").load('/pages/afficheurs/x_dentchat_frame.php?randval='+ Math.random());
   }, 3000);
   $.ajaxSetup({ cache: false });
});
</script>


<div id="responsecontainer"></div>

<?php


