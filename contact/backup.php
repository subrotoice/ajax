// Load time form Server and Set into clock
$.ajax({
  url: 'globalTime.php',
  type: 'POST'
})
.done(function( data ){
  // Clock From Server
  var timestampsub = parseInt(data);
  var serverTime = new Date(timestampsub);
  var clock = new FlipClock($('.your-clock'), {
    clockFace: 'TwelveHourClock'
  });
  clock.setTime(serverTime);
})
.fail(function(){
  alert('Ajax Load Failed ...');
});

// Page Load Report Load
$.ajax({
  url: 'process.php?lastten=yes',
  type: 'GET'
})
.done(function(data){
   $('.allPastReport').html(data);
})
.fail(function(){
  alert('Ajax Submit Failed ...');
});

// close status
$( document ).on( 'click', '.close', function() {
  $('.statusFeedback').fadeTo('slow', .1, function() {
    $(this).hide();
  });
});

// Add Report Form Submit
$("form.reportForm").submit(function(evt){
  evt.preventDefault();
  $.ajax({
    url: 'process.php',
    type: 'POST',
    data: $(this).serialize(), // it will serialize the form data
    dataType: 'html'
  })
  .done(function(data){
     $('.statusFeedback').html(data);
     $.ajax({
       url: 'process.php?lastten=yes',
       type: 'GET'
     })
     .done(function(data){
        $('.allPastReport').html(data);
     })
     .fail(function(){
       alert('Ajax Submit Failed ...');
     });
  })
  .fail(function(){
    alert('Ajax Submit Failed ...');
  });
  $('form.reportForm').trigger("reset");
});
