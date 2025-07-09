<?php
include 'config.php';

include("middleware.php");
include 'header.php';
if (isset($_POST['submit'])){
   
    $name = $_POST['name'];
       
    #file name with a random number so that similar dont get replaced
    $pname = rand(1000,10000)."-".$_FILES["image"]["name"];
 
    #temporary file name to store file
    $tname = $_FILES["image"]["tmp_name"];
   
     #upload directory path
    $uploads_dir = 'uploads';
    #TO move the uploaded file to specific location
    move_uploaded_file($tname, $uploads_dir.'/'.$pname);
 
    #sql query to insert into database
    $sql = "INSERT into services(image,name) VALUES('$pname','$name')";
 
    if(mysqli_query($conn,$sql)){
        echo "<script>window.location.href = 'service_list.php'</script>";        
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
				<h3>Add Service</h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 ">
				<div class="x_panel">					
					<div class="x_content">
						<br />
						<form id="demo-form2" action="service_create.php"   class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Image <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="file" name="image" id="image" required="required" class="form-control ">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Title <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" id="name" name="name" required="required" class="form-control">
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