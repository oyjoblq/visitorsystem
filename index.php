<?php 
	ob_start(); 
	session_start();
	include "base.php"; // include database connection information
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
 	 <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css" /> 
    <!--  Custom CSS -->
    <link href="css/visitor.css" rel="stylesheet">
   <!--  jQuery  -->
    <script src="js/jquery.js"></script> 
	 <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery-ui.js"></script>
     <!-- Bootstrap Core JavaScript -->
    <script src="js/validator.js"></script>
 	<script type="text/javascript">   
		$(document).ready(function(){ 
		   $('#IssuerState').hide();
           $('#IssuerCountry').hide();
		}); 
	</script> 
	
    <!-- 
    Depending on the ID Type to show the ID Issue dropdown list. By default, both dropdown lists are hidden 
    If ID Type is Driver License, show the State dropdown list, hide the country list
    If ID Type is Passport, show the country dropdown list, hide the state list
    --> 
    
    <script type="text/javascript">
		function ShowIDIssuer(str)
			{
			  if (str == "")
   				{
   				  $('#IssuerState').hide();
				  $('#IssuerCountry').hide();
				}
				
  	  		   if (str == "Passport")
				{
   				  $('#IssuerState').hide();
  				  $('#IssuerCountry').show();
			    }
  
    	      if (str == "Driver License")
 			  {
 				 $('#IssuerState').show();
  				 $('#IssuerCountry').hide();
  				}
 			 }
	</script>
   
   <!-- Calendar Datepicker for birthdate. Birthdate can not be in the future, so current day is the maximum date that can be chosen -->
    <script  type="text/javascript">
      $(function () {
        $("#BirthDate").datepicker({
            changeMonth: true,
            changeYear: true,
			maxDate: '0',
            yearRange: '-100:+0'
        });
      });
	</script>
    
</head>

<body>
  <div class="container">
        <div class="row hidden-sm hidden-xs" >
            <div class="box">
           		 <img class="img-responsive img-fluid max-width: 80% center-block" src="img/slide-0.jpg" alt="Visitor Registration">
           </div>
        </div>

        <div class="row">
           <div class="box">
                <div class="col-lg-12">
                   <hr />
                    <h2 class="intro-text text-center"><b>Visitor Registration Form</b></h2>
                    <hr />
                    
                    <!-- Start Registration Form -->      
       				<form role="form" class="form-horizontal" method="post"  id="VisitorForm" name="VisitorForm" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
  
  					<!-- start first name input box -->
  					<div class="form-group required">
 						<label for="FirstNameL" class="col-sm-4 control-label">First Name: </label>
       					<div class="col-sm-8"> 
       						<input type="text" name="FirstName" id="FirstName"  class="form-control" value="<?php echo( (isset($_POST['FirstName'])&&($_POST["FirstName"] != ''))? htmlentities($_POST["FirstName"]): '' ); ?>" required/>
         					<div class="help-block with-errors"></div>
       					</div>
       				</div>
 				 	<!-- end first name input box -->
                    
                    <!-- start last name input box -->
  					<div class="form-group required ">
  						<label for="LastNameL" class="col-sm-4 control-label">Last Name:</label>
    	 				<div class="col-sm-8">
                        	<input type="text" name="LastName" id="LastName" class="form-control" value="<?php echo((isset($_POST['LastName'])&& ($_POST["LastName"] != ''))? htmlentities($_POST["LastName"]): '' ); ?>" required/>
         					 <div class="help-block with-errors"></div>
        				</div>
  					</div>
                    <!-- end last name input box -->
    
    				<!-- start ID Type dropdown list. The onchange event will trigger the ID Issuer dropdowns -->
    				<div class="form-group required">
 	 					<label for="IDTypeL" class="col-sm-4 control-label">ID Type: </label>
  	   					<div class="col-sm-8"> 
      						<select name="IDType" id="IDType" class="form-control" onchange="ShowIDIssuer(this.value)" required/> 
    							<option value="">Please Choose</option>
   								<option value="Driver License" <?php echo (isset($_POST['IDType']) && ($_POST['IDType'] == 'Driver License')) ? 'selected="selected"' : ''; ?>>Driver License</option>
    							<option value="Passport" <?php echo (isset($_POST['IDType']) && ($_POST['IDType'] == 'Passport')) ? 'selected="selected"' : ''; ?>>Passport</option>
   							</select>
          					<div class="help-block with-errors"></div> 
   						</div>
   					</div>
                    <!-- end ID Type dropdown list -->
        
        			<!-- start IssuerState: State dropdown list. This container IssuerState will be hidden by default, it will be shown if ID Type is driver license -->
       				<div id="IssuerState">
   		 				<div class="form-group">
   			 			<label for="IDIssuerSL" class="col-sm-4 control-label">ID Issuer:</label>
     	  				<div class="col-sm-8">
          					<select name="IDIssuerS" id="IDIssuerS" class="form-control" readonly >
   			  					<option value="">Please Choose</option>
 			  					 <?php  
								   // get the state list from the database table USState. retain pre-selected value from previous submission 
			 						$result1 = mysqli_query($conn, "SELECT StateName FROM USState order by StateName");	
									while($row = mysqli_fetch_array($result1)) 
									{		 
					 					$IDIssuerS = $_POST['IDIssuerS'] ?? ''; 		 
					 					if($row['StateName'] ==  $IDIssuerS)
										{
         				 					$isSelected = 'selected="selected"';
   					 					} 
					  					else 
					 					{
         				 					$isSelected = ''; 
    				 					} 		
										echo "<option value='".$row['StateName']."'".$isSelected.">".$row['StateName']."</option>";
									}
			   					 ?>   
   			  				</select>
               				<div class="help-block with-errors"></div>  
            			</div>
  		 			 </div>
    				</div> <!-- end  IssuerState -->
    
    				<!-- start IssuerCountry: Country dropdown list. This container IssuerCountry will be hidden by default, it will be shown if ID Type is passport -->
  	   				<div id="IssuerCountry">
  	 	 				<div class="form-group">
    						<label for="IDIssuerCL" class="col-sm-4 control-label">ID Issuer:</label>
      					 <div class="col-sm-8">
      	 					<select name="IDIssuerC" id="IDIssuerC" class="form-control" readonly >
    							<option value="">Please Choose</option>
  			 					<?php  
									// get the country list from the database table Country. retain pre-selected value from previous submission  
									$result2 = mysqli_query($conn, "SELECT ShortName FROM Country order by ShortName");	
	 								while($row = mysqli_fetch_array($result2)) 
									{		 
		 								$IDIssuerC = $_POST['IDIssuerC'] ?? '';		 
				 						if($row['ShortName'] == $IDIssuerC)
				 						{
         			 						$isSelected2 = 'selected="selected"'; 
   				  						} 
				  						else 
				  						{
          									$isSelected2 = ''; 
     			   						}
 										echo "<option value='".$row['ShortName']."'".$isSelected2.">".$row['ShortName']."</option>";
		 		 					}
			  					?>
        					 </select>
              				 <div class="help-block with-errors"></div>  
        				</div>
    	  			   </div> 
         			</div> <!-- end  IssuerCountry -->
  
         		 	<!-- start ID Number input box -->
       				<div class="form-group required">
 	     				<label for="IDNumberL" class="col-sm-4 control-label">ID Number: </label>
     	  				<div class="col-sm-8">  
        					<input type="text" name="IDNumber" id="IDNumber" class="form-control" value="<?php echo( (isset($_POST['IDNumber'])&& ($_POST["IDNumber"] != ''))? htmlentities($_POST["IDNumber"]): '' ); ?>" required/>         
                        	<div class="help-block with-errors"></div>
        				</div>
      				</div> <!-- end ID Number input box -->
  
 	       			<!-- start Birthdate input box. Datepicker calendar will be shown -->
       				<div class="form-group">
    				<label for="BirthDateL"  class="col-sm-4 control-label">Birthdate:</label>
 		 				<div class="col-sm-8"><input type="text" name="BirthDate" id="BirthDate" class="form-control" value="<?php echo((isset($_POST['BirthDate'])&&  ($_POST["BirthDate"] != ''))? htmlentities($_POST["BirthDate"]): '' ); ?>" readonly /></div>
 		 			</div> <!-- end Birthdate input box -->
     
     				<!-- start Phone input box. simple phone format validation -->
 	 				<div class="form-group">
    					<label for="PhoneL"   class="col-sm-4 control-label">Phone(Format: XXX-XXX-XXXX):</label>
        				<div class="col-sm-8">
      		 				<input type="tel" pattern="^\d{3}-\d{3}-\d{4}$"   name="Phone" id="Phone"  class="form-control" value="<?php echo( (isset($_POST['Phone'])&& ($_POST["Phone"] != ''))? htmlentities($_POST["Phone"]): '' ); ?>" oninvalid="this.setCustomValidity(this.willValidate?'':'Phone Format: XXX-XXX-XXXX')"/>
       					</div>
      				</div>  <!-- end phone input box -->
                    
    				 <!-- start Email input box -->
      				<div class="form-group">
    					<label for="EmailL"   class="col-sm-4 control-label">Email:</label>
       					<div class="col-sm-8">
       						<input type="email" name="Email" id="Email"  class="form-control"  value="<?php echo( (isset($_POST['Email'])&&($_POST["Email"] != ''))? htmlentities($_POST["Email"]): '' ); ?>" />
        				</div>
       				</div>    <!-- end email input box -->
       
       				 <!-- start other information input box -->
  	   				<div class="form-group">
   					 	<label for="OtherL"   class="col-sm-4 control-label">Other Information:</label>
         				<div class="col-sm-8">
        					<input type="text" name="Other" id="Other"  class="form-control" value="<?php echo( (isset($_POST['Other'])&&($_POST["Other"] != ''))? htmlentities($_POST["Other"]): '' ); ?>" />
         				</div>
       				</div>     <!-- end other information input box -->  

					 <!-- start submission button -->
	 				<div class="form-group">
     					<div class="col-sm-4"> </div>
         			 	<div class="col-sm-8"> 
 	         				<input type="submit" name="Register" id="Register" value="Submit"  />
        			 	</div>
     				 </div> <!-- end submission button -->
                              
   			 </form> 
			<!-- end of Registration Form -->
 
 
 			<div class="row">
           		<div class="box">
                	<div class="col-lg-12">                
                		<a href="report.php"><b>View Visitor Report</b></a>
						 <?php
						// the above form will be submmitted to self. so here start the form processing
						if(isset($_POST["Register"])){
							// make sure required fields are not empty
							if((!empty($_POST['FirstName'])) && (!empty($_POST['LastName'])) && (!empty($_POST['IDType'])) && (!empty($_POST['IDNumber'])))
							{	
								// get form submittedvalue for each form element
								$FirstName = mysqli_real_escape_string($conn,$_POST['FirstName']);
								$LastName= mysqli_real_escape_string($conn,$_POST['LastName']);
								$IDNumber = mysqli_real_escape_string($conn,$_POST['IDNumber']);
								$IDType= mysqli_real_escape_string($conn,$_POST['IDType']);
								$IDIssuerS = mysqli_real_escape_string($conn,$_POST['IDIssuerS']);
								$IDIssuerC = mysqli_real_escape_string($conn,$_POST['IDIssuerC']);		
								$BirthDate = mysqli_real_escape_string($conn,$_POST['BirthDate']);		
								$BirthDateFormatted = date('Ymd', strtotime($BirthDate));		
								$Phone = mysqli_real_escape_string($conn,$_POST['Phone']);
								$Email = mysqli_real_escape_string($conn,$_POST['Email']);	
								$Other = mysqli_real_escape_string($conn,$_POST['Other']);		
				
								if ($IDType == 'Driver License')
		 						{
		  							$IDIssuer = $IDIssuerS;		  
								}
		 						elseif ($IDType == 'Passport')
		 						{
		 							
		  								$IDIssuer = $IDIssuerC;	
		  						}
		 						else
		 						{
		 								$IDIssuer=''; 
		  						}
		 						
		 								
								$dq = '"'; //double quotes to enclose the name values,prevent inserting error for names with apostrophes							
	   							$alreadyin= mysqli_query($conn, "SELECT * FROM Visitor WHERE FirstName= ".$dq.$FirstName.$dq ." AND LastName = ".$dq .$LastName.$dq ." AND IDType = '".$IDType."' AND IDNumber = '".$IDNumber."' AND IDIssuer = '".$IDIssuer."'");
		
		 						$num_rows = mysqli_num_rows($alreadyin); 
									//if the person is already existing in the table. don't add again. 
								if ($num_rows >0)		
 								{
										$alert = "<i class='fa fa-check' style='font-size:80px;color:red' aria-hidden='true'></i> <br>";			
										$alert  .= $FirstName .' '.$LastName. " (ID Type: ".$IDType."; ID Number: ". $IDNumber.") already exists. No need to register!";			
										echo $alert;
										?>
                                        <!-- refresh page after briefly show message -->
										<script type="text/javascript">
    										window.setTimeout(function() {
       										window.location.href='index.php';
    										}, 5000);
										</script>
								<?		
								}
								else
								{		
										// if person is new. add to the Visitor table
			 							$addperson =  mysqli_query($conn, "INSERT INTO  Visitor(FirstName, LastName,IDType, IDNumber, IDIssuer, BirthDate, Phone, Email,Notes) VALUES (".$dq.$FirstName.$dq .",".$dq .$LastName.$dq .",'".$IDType."','".$IDNumber."','".$IDIssuer."','".$BirthDateFormatted."','".$Phone."','".$Email."','".$Other."')"); 
		 
			 							$runadd  = mysqli_query($conn ,$addperson);
			
										$_SESSION['msg'] = "<i class='fa fa-check' style='font-size:80px;color:red' aria-hidden='true'></i> <br>";		
										$_SESSION['msg'] .= "Success! ". $FirstName .' '.$LastName. " (ID Type: ".$IDType."; ID Number: ". $IDNumber.")  is registered!";
										?>
                               			 <!-- direct to report page to show visitors report -->
										<script type="text/javascript">				
											window.location = "report.php";
		   								</script>         
          								<?php			
								} // end add new visitor					 	
	
							} // end if required fields are filled	
							else
							{
								$errormsg ="<br><i class='fa fa-close' style='font-size:80px;color:red'></i><br /><font color='red'>Please enter all required information.</font>";
								echo $errormsg;	
							} // end if required information not filled
						} // end of processing form
						mysqli_close($conn);
						?>         
         			</div>
      			 </div>
   			 </div>
   			 <!-- end info box -->      
        </div>
       </div>
    </div>

  </div>
    <!-- /.container -->
   
 <?php include("footer.php"); ?>
</body>
</html>
<?php ob_flush(); ?>