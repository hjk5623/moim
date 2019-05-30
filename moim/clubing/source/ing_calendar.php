<?php
// daygrid_views.php
$today= date("Y-m-d");
 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='../css/calendar_core.css' rel='stylesheet' />
<link href='../css/calendar_daygrid.css' rel='stylesheet' />

<script src='../js/calendar_core.js'></script>
<script src='../js/calendar_interaction.js'></script>
<script src='../js/calendar_daygrid.js'></script>
<script>
  $(document).ready(function(){
    fn_get_events();
  });
  function fn_set_calendar(events){
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid' ],
      header: {
        left: 'prevYear,prev,next,nextYear today',
        center: 'title',
        right: 'dayGridMonth,dayGridWeek,dayGridDay'
      },
      defaultDate: '<?=$today?>',
      navLinks: true, // can click day/week names to navigate views
      // editable: true,
      // eventLimit: true, // allow "more" link when too many events
      events: events
    });
    calendar.render();
  }
  function fn_get_events(){
    $.ajax({
			url: 'ing_schedule.php',
			dataType: 'json',
			success: function(events) {
				fn_set_calendar(events);
        console.log(events);
			}
		});
  }
</script>

<style>

  body {
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 900px;
    margin: 0 auto;
    margin-top: 50px;
  }

</style>
</head>
<body>

  <div id='calendar'></div>

</body>
</html>
