<?php


require 'config.php';
include("middleware.php");
include 'header.php';
$query = "SELECT * FROM services";

$result = mysqli_query($conn, $query);
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Service <small>List</small></h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row" style="display: block;">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">

                    <div class="x_content">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="20%">SN</th>
                                    <th width="30%">Image</th>
                                    <th width="30%">Title</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>
                                        <th scope="row">' . $i++ . '</th>
                                        <td><img src="uploads/' . $row['image'] . '" alt="" style="width: 50%;"></td>
                                        <td>' . $row["name"] . '</td>
                                        <td><a href="/site/admin/service_edit.php/?id=' . $row['id'] . '" class="btn btn-primary">Edit</a>                                    
                                        <a href="/site/admin/service_delete.php/?id=' . $row['id'] . '" class="btn btn-danger">Delete</a></td>
                                    </tr>';
                                    }
                                } ?>
                            </tbody>
                        </table>

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