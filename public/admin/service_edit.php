<?php
include 'config.php';

include("middleware.php");
include 'header.php';


## Step 2 - Display user's data in the form for editing

if (isset($_POST['update'])) {
    $id = $_POST['s_id'];
    $name = $_POST['name'];
    $new_image = $_FILES['image']['name'];
    $image_old = $_POST['image_old'];
    if ($new_image != '') {
        $update_image = $_FILES['image']['name'];
    } else {
        $update_image = $image_old;
    }
    $pname = rand(1000, 10000) . "-" . $_FILES["image"]["name"];
    if (file_exists("uploads/" . $pname)) {
        $new_image = $_FILES['image']['name'];
        $_SESSION['status'] = "Image already exists " . $new_image;
        echo "<script>window.location.href = '/site/admin/service_create.php'</script>";

    } else {
        $query = "UPDATE services SET image='$update_image',name='$name' WHERE id=$id";
        $result = mysqli_query($conn, $query);
        if ($result) {
            if ($_FILES['image']['name'] != '') {
                move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $_FILES["image"]["name"]);
                unlink("uploads/" . $image_old); // remove old image
            }
            $_SESSION['status'] = "Service updated successfully";
            echo "<script>window.location.href = '/site/admin/service_list.php'</script>";
        } else {
            $_SESSION['status'] = "Service update failed";
            header("Location: /site/admin/service_edit.php");
        }
    }
}

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Edit Service</h3>
            </div>
        </div>
        <a href=""></a>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_content">
                        <br />
<?php
$query = "select * from services where id = " . $_GET['id'];
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
foreach ($result as $user) { ?>
<form id="demo-form2" action="service_edit.php" class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="s_id" value="<?php echo $user['id'] ?>">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Image <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="file" name="image" id="image" class="form-control">
                                    <input type="hidden" name="image_old" id="image_old" class="form-control" value="<?php echo $user['image'] ?>">

                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Title <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="name" name="name" required="required" class="form-control" value="<?php echo $user['name'] ?>">
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