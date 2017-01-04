// Add Report Form Submit
$("form.contact-form").submit(function(evt){
  evt.preventDefault();
  $('.statusSign img').show();
  $.ajax({
    url: 'process.php',
    type: 'POST',
    data: $(this).serialize(), // it will serialize the form data
    dataType: 'html'
  })
  .done(function(data){
    var objData = jQuery.parseJSON( data );
    if ( objData.status === "success" ) {
      $('.required-text').hide();
      $('.statusSign img').hide();
      $('.statusSign i').addClass( 'fa-check' ).show("slow");
      $('.information').html( objData.message );
    } else {
      $('.statusSign img').hide();
      $('.statusSign i').addClass( 'fa-times' ).show("slow");
      $('.information').html( objData.message );
    }

  })
  .fail(function(){
    alert('Submit Failed ...');
  });
  $(this).trigger("reset");
});
