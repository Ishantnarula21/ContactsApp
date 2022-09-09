<?php
include("Common/common.php");
include("ContactApp.php");
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
                        <?php
                        // Creating object
                        $obj = new ContactApp();

                        // calling duplicate function two times
                        $displayfunction = $obj->duplicate();
                        $displayfunction2 = $obj->duplicate();
                        //declaring array
                        $duplicate = array();

                        foreach ($displayfunction as $display) {
                            // filtering duplicate phone number  with unique id
                            foreach ($displayfunction2 as $display2) {
                                if ($display['pnumber'] == $display2['pnumber'] && $display['id'] != $display2['id']) {
                                    //storing duplicate values in array
                                    $duplicateName[] = $display['id'];
                                }
                            }
                        }
                        if (isset($duplicateName)) {
                            //checking if there is any duplicate value bychance
                            $datas = array_unique($duplicateName);
                            //declaring array
                            $displayfunction = array();
                            //now everytime we will call getDup method it will pass the id and will get the record with that specified id
                            foreach ($datas as $data) {
                                $displayfunction[] = $obj->getDup($data);
                            }
                            //finally dispaying full record
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
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
</body>

</html>