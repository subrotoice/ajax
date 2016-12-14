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
     $('.required-text').hide();
     $('.statusSign img').hide();
     $('.statusSign i').show();
  })
  .fail(function(){
    alert('Submit Failed ...');
  });
  $(this).trigger("reset");
});
