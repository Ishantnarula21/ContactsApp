<?php
include("Common/common.php");
include("ContactApp.php");

//creating object
$obj = new ContactApp();

//delete data
if (!empty($_REQUEST['did'])) {
    $id = $_REQUEST['did'];
    $obj->delete($id);
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
    <section>
        <!-- header included -->
        <?php include("Common/Header.php"); ?>
        <!-- header included -->

        <div class="container-fluid nav-main">
            <!-- side bar navigation included -->
            <div class="col-md-2 Navigation">
                <?php include("Common/Navigation.php") ?>
            </div>
            <!-- side bar navigation included -->

            <div class="col-md-10 Content">
                <div class="col-md-10">
                    <!-- Calculating total contacts -->
                    <p class="total">Total Contacts :
                        <?php
                        $obj = new ContactApp();
                        $displayfunction = $obj->display();
                        $index = 0;
                        foreach ($displayfunction as $display) {
                            $index++;
                        }
                        echo $index;
                        ?>
                    </p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" colspan="2">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone number</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- display loop -->
                            <?php
                            $obj = new ContactApp();
                            $displayfunction = $obj->display();
                            foreach ($displayfunction as $display) {
                            ?>
                                <tr>
                                    <th scope="row"><img class="contact-pic" src="./upload/<?php echo $display['image'] ?>" /></th>
                                    <td><?php echo $display['name'] ?></td>
                                    <td><?php echo $display['email'] ?></td>
                                    <td><?php echo $display['pnumber'] ?></td>
                                    <td><a class="btn btn-primary" href="CreateNewContact.php?eid=<?php echo $display['id'] ?>">Edit</a></td>
                                    <td><a class="btn btn-danger" href="index.php?did=<?php echo $display['id'] ?>">Delete</a></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </section>
</body>

</html>