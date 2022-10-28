<!DOCTYPE html>
<html>
 <head>
  <title>Jquery Fullcalandar Integration with PHP and Mysql</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <script>

$(document).ready(function () {
  function fmt(date) {
    return date.format("YYYY-MM-DD HH:mm");

  }

  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();

  var calendar = $('#calendar').fullCalendar({
    editable: true,
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay'
    },

    events: "events.php",

    // Convert the allDay from string to boolean
    eventRender: function (event, element, view) {
      if (event.allDay === 'true') {
        event.allDay = true;
      } else {
        event.allDay = false;
      }
    },
    selectable: true,
    selectHelper: true,
    select: function (start, end, allDay) {
      var title = prompt('Event Title:');
      if (title) {
        var start = fmt(start);
        var end = fmt(end);
        $.ajax({
          url: 'add_events.php',
          data: 'title=' + title + '&start=' + start + '&end=' + end,
          type: "POST",
          success: function (json) {
            //alert('Added Successfully');
          }
        });
        calendar.fullCalendar('renderEvent',
            {
              title: title,
              start: start,
              end: end,
              allDay: allDay
            },
            true // make the event "stick"
        );
      }
      calendar.fullCalendar('unselect');
    },

    editable: true,
    eventDrop: function (event, delta) {
      var start = fmt(event.start);
      var end = fmt(event.end);
      $.ajax({
        url: 'update_events.php',
        data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
        type: "POST",
        success: function (json) {
          //alert("Updated Successfully");
        }
      });
    },
    eventClick: function (event) {
      var decision = confirm("Do you want to remove event?");
      if (decision) {
        $.ajax({
          type: "POST",
          url: "delete_event.php",
          data: "&id=" + event.id,
          success: function (json) {
            $('#calendar').fullCalendar('removeEvents', event.id);
            //alert("Updated Successfully");
          }
        });


      }

    },
    eventResize: function (event) {
      var start = fmt(event.start);
      var end = fmt(event.end);
      $.ajax({
        url: 'update_events.php',
        data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
        type: "POST",
        success: function (json) {
          //alert("Updated Successfully");
        }
      });

    }

  });

});


    </script>
 </head>
 <body style="background-color: #000442;">
 <nav class="navbar  justify-content-between" ">
            <a class=" navbar-brand" style="color:white;font-weight: bold;"> <i class="fa fa-arrow-left"></i>  Ajoutez vos événements  </a>

  </nav>

  <div class="container" style="margin-top:2%;color:#bfeaff; width: 1000px; height: 200px;">
   <div id="calendar"></div>
  </div>
 </body>
</html>
