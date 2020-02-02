<?php 
ob_start();
include "base.php"; 
// Get job (and id)
$job = '';
$id  = '';

if (isset($_GET['job'])){
  $job = $_GET['job'];
  if ($job == 'get_visitors' ||
      $job == 'get_visitor'   ||
      $job == 'edit_visitor'  ||
      $job == 'delete_visitor'){
    if (isset($_GET['id'])){
      $id = $_GET['id'];
      if (!is_numeric($id)){
        $id = '';
      }
    } 
	
  } else {
    $job = '';
  }
}

// Prepare array
$mysql_data = array();

// Valid job found
if ($job != ''){  
  // Execute job
  if ($job == 'get_visitors'){
    
    // Get visitors
    $query = "SELECT PK_Visitor, LastName, FirstName, IDNumber,IDIssuer,IDType, BirthDate,Phone, Email FROM Visitor ORDER BY LastName";
    $query = mysqli_query($conn, $query);
    if (!$query){
      $result  = 'error';
      $message = 'query error';
    } else {
      $result  = 'success';
      $message = 'query success';
      while ($visitor = mysqli_fetch_array($query)){
			 
		
        $functions  = '<div class="function_buttons"><ul>';
        $functions .= '<li class="function_edit"><a data-id="'   . $visitor['PK_Visitor'] . '" data-name="' . $visitor['FirstName'] .' '.$visitor['LastName']. '"><span>Edit</span></a></li>';
        $functions .= '<li class="function_delete"><a data-id="' . $visitor['PK_Visitor'] . '" data-name="' . $visitor['FirstName'] .' '.$visitor['LastName']. '"><span>Delete</span></a></li>';
        $functions .= '</ul></div>';
        $mysql_data[] = array(        
          "last_name"  => $visitor['LastName'],
		  "first_name"  => $visitor['FirstName'],
		  "psid"  => $visitor['IDNumber'],
		  "issuer"  => $visitor['IDIssuer'],
		  "bday"  => $visitor['BirthDate'],
		  "phone"  => $visitor['Phone'],
		  "email"  => $visitor['Email'],
          "functions"     => $functions
        );
      }
    }
    
  } elseif ($job == 'get_visitor'){
    
    // Get visitor
    if ($id == ''){
      $result  = 'error';
      $message = 'id missing';
    } else {
      $query = "SELECT PK_Visitor, LastName, FirstName, IDNumber FROM Visitor WHERE PK_Visitor= '". mysqli_real_escape_string($conn, $id)."'";
      $query = mysqli_query($conn, $query);
      if (!$query){
        $result  = 'error';
        $message = 'query error';
      } else {
        $result  = 'success';
        $message = 'query success';
        while ($visitor = mysqli_fetch_array($query)){
          $mysql_data[] = array(
           	"last_name"  => $visitor['LastName'],
		    "first_name"  => $visitor['FirstName'],
		    "psid"  => $visitor['IDNumber']			
          );
        }
      }
    }  

  } elseif ($job == 'edit_visitor'){
    
    // Edit visitor
    if ($id == ''){
      $result  = 'error';
      $message = 'id missing';
    } else {     
		$query = "UPDATE Visitor SET "; 
     	 if (isset($_GET['last_name'])) { $query .= "LastName = '" . mysqli_real_escape_string($conn, $_GET['last_name'])."', "; }
	     if (isset($_GET['first_name']))   { $query .= "FirstName  = '" . mysqli_real_escape_string($conn, $_GET['first_name'])."', "; }
		 if (isset($_GET['psid']))   { $query .= "IDNumber = '" . mysqli_real_escape_string($conn, $_GET['psid'])."'"; }         
         $query .= "WHERE PK_Visitor=  '" . mysqli_real_escape_string($conn, $id) . "'";	    
         $query  = mysqli_query($conn, $query);	
         $result  = 'success';
         $message = 'query success';	 
    }    
  } elseif ($job == 'delete_visitor'){  
    // Delete visitor
    if ($id == ''){
      $result  = 'error';
      $message = 'id missing';
    } else { 
        $query = "DELETE FROM Visitor WHERE PK_Visitor= '". mysqli_real_escape_string($conn, $id)."'";
        $query = mysqli_query($conn, $query);
	    $result  = 'success';
        $message = 'query success';	  
    }  
  }
}
mysqli_close($conn);

// Prepare data
$data = array(
  "result"  => $result,
  "message" => $message,
  "data"    => $mysql_data
);

// Convert PHP array to JSON array
$json_data = json_encode($data);
print $json_data;
?>
<?php ob_flush(); ?>
