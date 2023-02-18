# AJAX Code. Here 3 Project Included

Demos are here <br />
http://edeves.com/ajax/student <br />
http://edeves.com/ajax/employee <br />
http://edeves.com/ajax/contact <br />

seba.edeves.com <br />
food.edeves.com <br />
voca.edeves.com <br />

```
// PHP feedback
  echo json_encode( array('amount' => $amount, 'message'=> $htmlMessage) ); // Simple
  
  /* Condition Select queries return a resultset */
  if (   $regex==0 ) {
      echo json_encode( array('status' => 'wrongFormat', 'message'=> 'Wrong Format User Exist') );
  }
  elseif ( $result->num_rows ) {<br />
      echo json_encode( array('status' => 'exist', 'message'=> 'User Exist') );<br />
  } else {
    echo json_encode( array('status' => 'notexist', 'message'=> 'User Not Exist') );
  }
  
// Js File
$.get( url, function( data ) {
    var objData = jQuery.parseJSON( data ); // jQuery after feedback come
    var status= objData.status; // to get value
  });
});
```
