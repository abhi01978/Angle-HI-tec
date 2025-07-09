<?php
include 'config.php';
include("middleware.php");
include 'header.php';
if (isset($_POST['submit'])){
       
    #file name with a random number so that similar dont get replaced
    $pname = $_FILES["image"]["name"];
	$pname2 = $_FILES["image2"]["name"];
 
    #temporary file name to store file
    $tname = $_FILES["image"]["tmp_name"];
	$tname2 = $_FILES["image2"]["tmp_name"];
   
     #upload directory path
    $uploads_dir = 'about';
	$uploads_dir = 'about2';
    #TO move the uploaded file to specific location
    move_uploaded_file($tname, $uploads_dir.'/'.$pname);
	move_uploaded_file($tname2, $uploads_dir.'/'.$pname2);
 
    #sql query to insert into database
    $sql = "INSERT into about(image, image2) VALUES('$pname','$pname2')";
 
    if(mysqli_query($conn,$sql)){
        echo "<script>window.location.href = 'about_list.php'</script>";        
    }
    else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
}
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>Add About Image</h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 ">
				<div class="x_panel">					
					<div class="x_content">
						<br />
						<form id="demo-form2" action="about_create.php"   class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Image <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="file" name="image" id="image" required="required" class="form-control ">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="image2">Image 2 <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="file" name="image2" id="image2" required="required" class="form-control ">
								</div>
							</div>							
							<div class="item form-group">
								<div class="col-md-6 col-sm-6 offset-md-3">
									<button type="submit" name="submit" class="btn btn-success">Submit</button>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<!-- /page content -->




<?php
include 'footer.php';
?>