<!-- 
Author: L.O
Description: This file shows visitor report. it also offers edit and delete visitor functions. when the user click on the "Edit" icon for a visitor, a lightbox
will open, with some of the visitor's information pre-filled. I only displayed three input boxes (Last Name, First Name, ID Number) in the lightbox, just for demonstration. 
Ideally all form elements can be prefilled in the lightbox. If the user click the "Delete" icon,  a message box will pop up to ask for confirmation, if confirmed, the record 
will be deleted. 
-->
<?php 
	 include "base.php"; 
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Visitor Registration</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css" /> 
	<!--  Custom CSS -->
    <link href="css/visitor.css" rel="stylesheet">  
     <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Oxygen:400,700">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/layout.css">  
    <!--  jQuery  -->
    <script src="js/jquery.js"></script> 
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery-ui.js"></script>
     <!-- Bootstrap Core JavaScript -->
    <script src="js/validator.js"></script> 
  	<script charset="utf-8" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script charset="utf-8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
 	<script charset="utf-8" src="//cdn.jsdelivr.net/jquery.validation/1.13.1/jquery.validate.min.js"></script>
 	<script charset="utf-8" src="reportprocess.js"></script>    
</head>

<body> 
  <div class="container">
        <div class="row hidden-sm hidden-xs" >
            <div class="box">         
                <img class="img-responsive img-fluid max-width: 80% center-block" src="img/slide-0.jpg" alt="">                          
            </div>
        </div>     
    
    	<!-- begin report -->
   		<div class="row">
           <div class="box">
                <div class="col-lg-12">                
               	 <div class="row">           
               		 <div class="col-lg-8">
                 		<h1> Visitor Report </h1>
                	</div>
                 	<div class="col-lg-4">
    					<a href="index.php"><div ID="VisitorButton">Register Another Visistor</div></a>         
        			</div>
                  </div>        

  				  <table class="datatable" id="table_visitors">
        			<thead>
         			 <tr>            
           			 <th>Last Name</th>
            		 <th>First Name</th>
             		 <th>ID Number</th>
               		 <th>ID Issuer</th>
               		 <th>Birth Date</th>
                 	 <th>Phone</th>
                 	 <th>Email</th>                      
            		<th>Functions</th>
          			</tr>
        			</thead>
       				<tbody>
       				</tbody>
     			 </table>
    		 </div>

        <div class="lightbox_bg"></div>

    	<div class="lightbox_container">
      	<div class="lightbox_close"></div>
     	<div class="lightbox_content">
        
        <h2>Add Visitor</h2>
        <form class="form add" id="form_visitor" data-id="" novalidate> 
              
          <div class="input_container">
            <label for="last_namel">Last Name: <span class="required">*</span></label>
            <div class="field_container">
              <input type="text" class="text" name="last_name" id="last_name" value="" required>
            </div>
          </div>
          
          <div class="input_container">
            <label for="first_name">First Name: <span class="required">*</span></label>
            <div class="field_container">
              <input type="text" class="text" name="first_name" id="first_name" value="" required>
            </div>
          </div>
          
          <div class="input_container">
            <label for="psid">ID Number: <span class="required">*</span></label>
            <div class="field_container">
              <input type="text" class="text" name="psid" id="psid" value="" required>
            </div>
          </div>
       
          <div class="button_container">
            <button type="submit">Add Visitor</button>
          </div>
        </form>
        
      </div>
    </div>

    <noscript id="noscript_container">
      <div id="noscript" class="error">
        <p>JavaScript support is needed to use this page.</p>
      </div>
    </noscript>

    <div id="message_container">
      <div id="message" class="success">
        <p>This is a success message.</p>
      </div>
    </div>

    <div id="loading_container">
      <div id="loading_container2">
        <div id="loading_container3">
          <div id="loading_container4">

            Loading, please wait...
          </div>
        </div>
      </div>
    </div>
           </div>
       </div>
    </div> 
    <!-- end report -->      

  </div>
    <!-- /.container -->
   
 <?php include ("footer.php"); ?>
</body>
</html>
