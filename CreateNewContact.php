<?php
include("Common/common.php");
include("ContactApp.php");
$obj = new ContactApp();

//insert data
if (isset($_REQUEST['save'])) {
    $obj->insertdata($_POST, $_FILES);
}

//update data
if (isset($_REQUEST['update'])) {
    $id = $_REQUEST['eid'];
    $obj->update($_POST, $_FILES, $id);
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

        <!-- insertion form -->
        <div class="col-md-10 Content">
            <div class="col-md-10">
                <h1>Create New Contact</h1>
                <form method="post" enctype="multipart/form-data">
                    <!-- displaying edit data in input -->
                    <?php
                    if (!empty($_REQUEST['eid'])) {
                        $editid = $_REQUEST['eid'];
                        $ro = $obj->editbyid($editid);
                    }
                    ?>
                    <div class="mb-3">
                        <label for="Name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="Name" name="name" value="<?php if (!empty($ro['name'])) echo $ro['name'] ?> " required>
                    </div>
                    <div class="mb-3">
                        <label for="Email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="Email" name="email" value="<?php if (!empty($ro['email'])) echo $ro['email'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="pnumber" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="pnumber" name="pnumber" value=" <?php if (!empty($ro['pnumber'])) echo $ro['pnumber'] ?> " required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image (optional)</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <?php
                    if (!empty($_REQUEST['eid'])) {
                    ?>

                        <input type="submit" class="btn btn-success" name="update" value="Update" />
                    <?php
                    } else {
                    ?>
                        <input type="submit" class="btn btn-primary" name="save" value="Save" />
                    <?php
                    }
                    ?>
                    <a class="btn btn-warning" role="button" href="CreateNewContact.php">Reset</a>
                </form>
            </div>
        </div>
        <!-- insertion form ends here -->
</body>

</html>