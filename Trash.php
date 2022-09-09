<?php
include("Common/common.php");
include("ContactApp.php");
//creating object
$obj = new ContactApp();

//delete.
if (!empty($_REQUEST['did'])) {
    $id = $_REQUEST['did'];
    $obj->pdelete($id);
}

//Restore.
if (!empty($_REQUEST['rid'])) {
    $id = $_REQUEST['rid'];
    $obj->restore($id);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Contact</title>
</head>

<body>
    <!-- header included -->
    <?php include("Common/Header.php"); ?>
    <!-- side bar navigation included -->
    <div class="container-fluid nav-main">
        <div class="col-md-2 Navigation">
            <?php include("Common/Navigation.php") ?>
        </div>
        <div class="col-md-10 Content">
            <div class="col-md-10">

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" colspan="2">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone number</th>
                            <th scope="col">Delete Forever</th>
                            <th scope="col">Restore</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- display loop -->
                        <?php
                        $obj = new ContactApp();
                        $displayfunction = $obj->trashdisplay();
                        foreach ($displayfunction as $display) {
                        ?>
                            <tr>
                                <th scope="row"><img class="contact-pic" src="./upload/<?php echo $display['image'] ?>" /></th>
                                <td><?php echo $display['name'] ?></td>
                                <td><?php echo $display['email'] ?></td>
                                <td><?php echo $display['pnumber'] ?></td>
                                <td><a class="btn btn-danger" href="Trash.php?did=<?php echo $display['id'] ?>">Delete</a></td>
                                <td><a class="btn btn-success" href="Trash.php?rid=<?php echo $display['id'] ?>">Restore</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
</body>

</html>