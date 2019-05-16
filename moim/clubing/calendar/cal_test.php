<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>달력</title>
    <link href='../css/core/main.css' rel='stylesheet' />
    <link href='../css/daygrid/main.css' rel='stylesheet' />

    <script src='../js/core/main.js'></script>
    <script src='../js/daygrid/main.js'></script>
    <script type="text/javascript">
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
          plugins: [ 'dayGrid' ]
        });

        calendar.render();
      });

    </script>
  </head>
  <body>
    <div id='calendar'></div>
  </body>
</html>
