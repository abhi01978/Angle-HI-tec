<?php
include 'config.php';

include("middleware.php");
include 'header.php';
$query = "SELECT * FROM explors";

$result = mysqli_query($conn, $query);
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Explore Service <small>List</small></h3>
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
                                    <th width="10%">SN</th>
                                    <th width="20%">Icone</th>
                                    <th width="20%">Title</th>
                                    <th width="25%">Description</th>
                                    <th width="25%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>
                                        <th scope="row">' . $i++ . '</th>
                                        <td><i class="fa-solid fa-' . $row["icon"] . '"></i></td>
                                        <td>' . $row["title"] . '</td>
                                        <td>' . $row["description"] . '</td>
                                        <td><a href="/site/admin/explore_service_edit.php/?id=' . $row['id'] . '" class="btn btn-primary">Edit</a>                                    
                                        <a href="/site/admin/explore_service_delete.php/?id=' . $row['id'] . '" class="btn btn-danger">Delete</a></td>
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