# AJAX Code. Here 3 Project Included

// Add Student Button click
$("form.studentEntry").submit(function(evt){
  evt.preventDefault();
  $.ajax({
    url: 'process.php',
    type: 'POST',
    data: $(this).serialize(), // it will serialize the form data
    dataType: 'html'
  })
  .done(function( data ){
    $('form.studentEntry').hide(50, 0, function() {
      $('.studentDetails').html( data ).fadeTo('slow', 1);
    });
  })
  .fail(function(){
    alert('Ajax Submit Failed ...');
  });
  $('form.studentEntry').trigger("reset");
});
