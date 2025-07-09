<?php
include 'config.php';
include("middleware.php");
include 'header.php';
if (isset($_POST['submit'])){   
    $icon = $_POST['icon'];
    $title = $_POST['title'];
    $description = $_POST['description']; 
    #sql query to insert into database
    $sql = "INSERT into explors (icon,title,description) VALUES('$icon','$title','$description')";
 
    if(mysqli_query($conn,$sql)){
        echo "<script>window.location.href = 'explore_service_list.php'</script>";        
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
				<h3>Add Explore Service</h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 ">
				<div class="x_panel">					
					<div class="x_content">
						<br />
						<form id="demo-form2" action="explore_service_create.php"   class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Icon <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" name="icon" id="icon" required="required" class="form-control ">
								</div>
							</div>
                            <div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="title">Title <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" name="title" id="title" required="required" class="form-control ">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="description">Description <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">									
                                    <textarea id="description" name="description" rows="4" cols="50" class="form-control" required></textarea>

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