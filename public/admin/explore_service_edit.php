<?php
include 'config.php';
include("middleware.php");
include 'header.php';


## Step 2 - Display user's data in the form for editing

if (isset($_POST['update'])) {
    $id = $_POST['s_id'];
    $icon = $_POST['icon'];
	$title = $_POST['title'];
	$description = $_POST['description'];
	$query = "UPDATE `explors` SET `icon`='$icon',`title`='$title',`description`='$description' WHERE id=$id";
	$result = mysqli_query($conn, $query);
	if ($result) {		
		echo "<script>window.location.href = '/site/admin/explore_service_list.php/'</script>";
	} else {
		echo "<script>window.location.href = '/site/admin/explore_service_edit.php/?id='.$id</script>";
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
                        <?php
						if(isset($_GET['id'])){
$query = "select * from explors where id = " . $_GET['id'];
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
foreach ($result as $user) { ?>
						<form id="demo-form2" action="explore_service_edit.php"   class="form-horizontal form-label-left" method="post" >
						<input type="hidden" name="s_id" value="<?php echo $user['id'] ?>">

							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Icon <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" name="icon" id="icon" required="required" class="form-control " value="<?php echo $user['icon'] ?>">
								</div>
							</div>
                            <div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="title">Title <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">
									<input type="text" name="title" id="title" required="required" class="form-control "  value="<?php echo $user['title'] ?>">
								</div>
							</div>
							<div class="item form-group">
								<label class="col-form-label col-md-3 col-sm-3 label-align" for="description">Description <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 ">									
                                    <textarea id="description" name="description" rows="4" cols="50" class="form-control" required  value="<?php echo $user['description'] ?>"><?php echo $user['description'] ?></textarea>

								</div>
							</div>
							<div class="item form-group">
								<div class="col-md-6 col-sm-6 offset-md-3">
									<button type="submit" name="update" class="btn btn-success">Update</button>
								</div>
							</div>

						</form>

                        <?php
}
}else{
    echo "No results found";
    
}
						}

?>
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