<?php
include $_SERVER['DOCUMENT_ROOT']."/moim/lib/db_connector.php";

?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<script>
	$(document).ready(function(){
			 $("#schedule").val(data);
			$.ajax({	//ajax로 이부분만 보내겠다.
				type : "post",		//post방식으로
				url : "ing_list.php"
			});
	});
</script>


<?php

$year= date("Y-m");

$sql = "select * from club where club_start like '$year-%'";
$result = mysqli_query($conn, $sql) or die("실패원인12 " . mysqli_error($conn));
$row_count= mysqli_num_rows($result);

	for($i=0; $i<$row_count; $i++){
		$row = mysqli_fetch_array($result);
		$num = $row['club_num'];
		$club_name= $row['club_name'];
		echo "<a href='ing_view.php?no=$num' class='go_page'>$club_name</a><br>";
	}
?>
