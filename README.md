# AJAX Code. Here 3 Project Included

Demos are here <br />
http://edeves.com/ajax/student <br />
http://edeves.com/ajax/employee <br />
http://edeves.com/ajax/contact <br />

```
// PHP feedback
  /* Select queries return a resultset */
  if (   $regex==0 ) {
      echo json_encode( array('status' => 'wrongFormat', 'message'=> 'Wrong Format User Exist') );
  }
  elseif ( $result->num_rows ) {<br />
      echo json_encode( array('status' => 'exist', 'message'=> 'User Exist') );<br />
  } else {
    echo json_encode( array('status' => 'notexist', 'message'=> 'User Not Exist') );
  }
// Js File
var objData = jQuery.parseJSON( data ); // jQuery after feedback come
```
