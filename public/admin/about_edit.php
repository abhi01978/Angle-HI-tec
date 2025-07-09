<?php
include 'config.php';

include("middleware.php");
include 'header.php';


## Step 2 - Display user's data in the form for editing

if (isset($_POST['update'])) {
    $id = $_POST['s_id'];
    $new_image = $_FILES['image']['name'];
    $new_image2 = $_FILES['image2']['name'];
    $image_old = $_POST['image_old'];
    $image_old2 = $_POST['image_old2'];
    if ($new_image != '') {
        $update_image = $_FILES['image']['name'];
    } else {
        $update_image = $image_old;
    }
    if ($new_image2 != '') {
        $update_image2 = $_FILES['image2']['name'];
    } else {
        $update_image2 = $image_old2;
    }
    $pname = $_FILES["image"]["name"];
    $pname2 = $_FILES["image2"]["name"];
    if (file_exists("about/" . $pname) || file_exists("about2/" . $pname2)) {
        $new_image = $_FILES['image']['name'];
        $new_image2 = $_FILES['image2']['name'];
        $_SESSION['status'] = "Image already exists " . $new_image;
        $_SESSION['status'] = "Image already exists " . $new_image2;
        echo "<script>window.location.href = '/site/admin/about_create.php'</script>";
    } else {
        $query = "UPDATE about SET image='$update_image', image2='$update_image2'  WHERE id=$id";
        $result = mysqli_query($conn, $query);
        if ($result) {
            if ($_FILES['image']['name'] != '') {
                move_uploaded_file($_FILES["image"]["tmp_name"], "about/" . $_FILES["image"]["name"]);
                unlink("about/" . $image_old); // remove old image
            }
            if ($_FILES['image2']['name'] != '') {
                move_uploaded_file($_FILES["image2"]["tmp_name"], "about2/" . $_FILES["image2"]["name"]);
                unlink("about2/" . $image_old2); // remove old image
            }
            $_SESSION['status'] = "about updated successfully";
            echo "<script>window.location.href = '/site/admin/about_list.php'</script>";
        } else {
            $_SESSION['status'] = "About update failed";
            header("Location: /site/admin/about_edit.php");
        }
    }
}

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Edit About Image</h3>
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
if(isset($_GET['id'])){
$query = "select * from about where id = " . $_GET['id'];
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
foreach ($result as $user) { ?>
<form id="demo-form2" action="about_edit.php" class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
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
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Image 2<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="file" name="image2" id="image2" class="form-control">
                                    <input type="hidden" name="image_old2" id="image_old2" class="form-control" value="<?php echo $user['image2'] ?>">
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