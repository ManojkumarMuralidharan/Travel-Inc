<?php
echo "
<html>

<head>
<script type='text/javascript' src='jquery-1.7.1.min.js'></script>

<script type='text/javascript' src='notifier.js'></script>
<script type='text/javascript' src='jquery-ui.min.js'></script>
</head>
<script>
$(document).ready(function() {
$('#check').click(function(e){
			$.ajax({
			type: 'POST',
			url: 'restchecklogin.php' ,
			data: { Username: 'manojkumar.muralidharan@itcinfotech.com' , Password: 'login@123'},
			}).done(function(data) { 
			alert(data);
			
			});
});
});
</script>
<body>
<a href='#' id='check'>Check id</a>

</body>
</html>";

?>