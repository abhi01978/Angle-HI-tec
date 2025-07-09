<?php
include 'config.php';
include("middleware.php");
include 'header.php';
if (isset($_POST['submit'])){   
    $addres = $_POST['addres'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email']; 
    #sql query to insert into database
    $sql = "INSERT into address (addres,mobile,email) VALUES('$addres','$mobile','$email')";
 
    if(mysqli_query($conn,$sql)){
        echo "<script>window.location.href = 'address_list.php'</script>";        
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
						<form id="demo-form2" action="address_create.php"   class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Address <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">									
                                    <textarea id="addres" name="addres" rows="4" cols="50" class="form-control" required></textarea>
								</div>
							</div>
                            <div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="mobile">Title <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" name="mobile" id="mobile" required="required" class="form-control ">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">									
                                <input type="text" name="email" id="email" required="required" class="form-control ">
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