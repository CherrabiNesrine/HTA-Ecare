

$(document).ready(function() {
    //Then assigns the event handler
    $(".shuffle").click(function(){
      console.log("hello");
      let arr = onShuffle();
      shuffleSuccess(arr);
    });
});



$("#datepicker").datepicker( {
format: "mm-yyyy",
startView: "months", 
minViewMode: "months"
});
