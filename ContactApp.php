<?php
class ContactApp
{

    ///////////////////////////Database Connection////////////////////////////////


    //declaring database variables
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "contactapp";
    public $con;

    //database connection
    public function __construct()
    {
        $this->con = new mysqli($this->servername, $this->username, $this->password, $this->database);
        if (mysqli_connect_error()) {
            trigger_error("Failed to connect the database");
        } else {
            return $this->con;
        }
    }


    ///////////////////////////Insertion and updating Records////////////////////////////////


    //insert function
    public function insertdata()
    {
        //fetching values
        $name = $this->con->real_escape_string($_REQUEST['name']);
        $email = $this->con->real_escape_string($_REQUEST['email']);
        $pnumber = $this->con->real_escape_string($_REQUEST['pnumber']);
        $image = $this->con->real_escape_string($_FILES['image']['name']);
        // if the image is uploaded by user then it will add that specified image
        if (is_numeric($pnumber)) {
            if (!empty($image)) {
                $filename = $this->con->real_escape_string($_FILES['image']['name']);
                $filepath = $_FILES['image']['tmp_name'];
                //exploding extention from file name
                $imagename = explode(".", $filename);
                $ext = $imagename[1];
                //getting table status for id
                $query = "show table status like 'allcontacts'";
                $result = $this->con->query($query);
                $row = $result->fetch_assoc();
                $id = $row['Auto_increment'];
                $newfilename = $id . "." . $ext;
                //insertion query
                $query = "insert into allcontacts (name,email,pnumber,image) VALUES ('$name','$email','$pnumber','$newfilename')";
                $result = $this->con->query($query);
                //moving uploaded file to upload folder 
                if ($result == true) {
                    move_uploaded_file($filepath, "upload/" . $newfilename);
                    echo "Record Inserted";
                } else {
                    echo "record not inserted";
                }
                // and if image is not given then by default it will be logo.png
            } else {
                $newfilename = "Logo.png";
                $query = "insert into allcontacts (name,email,pnumber,image) VALUES ('$name','$email','$pnumber','$newfilename')";
                $result = $this->con->query($query);
                if ($result == true) {
                    echo "Record Inserted";
                } else {
                    echo "record not inserted";
                }
            }
            clearstatcache();
        } else {
            echo '<script>alert("The Phone number must be numeric only")</script>';
        }
    }

    //updating record
    public function update()
    {
        //fetching values
        $uid = $this->con->real_escape_string($_REQUEST['eid']);
        $name = $this->con->real_escape_string($_REQUEST['name']);
        $email = $this->con->real_escape_string($_REQUEST['email']);
        $pnumber = $this->con->real_escape_string($_REQUEST['pnumber']);
        $image = $this->con->real_escape_string($_FILES['image']['name']);
        if (!empty($image)) {
            $filename = $this->con->real_escape_string($_FILES['image']['name']);
            $filepath = $_FILES['image']['tmp_name'];
            //exploding extention from file name
            $imagename = explode(".", $filename);
            $ext = $imagename[1];

            //getting table status
            $query = "show table status like 'allcontacts'";
            $result = $this->con->query($query);
            $row = $result->fetch_assoc();
            $id = $row['Auto_increment'];
            $newfilename = $id . "." . $ext;
            $query = "select image from allcontacts where id=$uid";
            $result = $this->con->query($query);
            $getimage = $result->fetch_assoc();
            if ($result == true) {
                unlink('upload/' . $getimage['image']);
            }
            //updation query
            $query = "update allcontacts set name='$name',email='$email',pnumber='$pnumber',image='$newfilename' where id=$uid";
            $result = $this->con->query($query);

            //moving uploaded file to upload folder 
            if ($result == true) {
                move_uploaded_file($filepath, "upload/" . $newfilename);
                echo "Record Updated";
            } else {
                echo "Record not Updated";
            }
        } else {
            $query = "select image from allcontacts where id=$uid";
            $result = $this->con->query($query);
            $getimage = $result->fetch_assoc();
            if ($result == true) {
                unlink('upload/' . $getimage['image']);
            }
            $newfilename = "Logo.png";
            $query = "update allcontacts set name='$name',email='$email',pnumber='$pnumber',image='$newfilename' where id=$uid";
            $result = $this->con->query($query);
            if ($result == true) {
                echo "Record Updated";
            } else {
                echo "Record not Updated";
            }
        }
        clearstatcache();
    }


    ///////////////////////////Display Methods////////////////////////////////


    //display function
    public function display()
    {
        if (isset($_REQUEST['searchbtn'])) {
            $sname = $_REQUEST['sname'];
            $query = "select * from allcontacts where name like '%$sname%'";
            $result = $this->con->query($query);
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            $query = "select * from allcontacts";
            $result = $this->con->query($query);
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }

    //displaying edited record
    public function editbyid($eid)
    {
        $query = "select * from allcontacts where id=$eid";
        $result = $this->con->query($query);
        $row = $result->fetch_assoc();
        return $row;
    }

    //trash display
    public function trashdisplay()
    {
        if (isset($_REQUEST['searchbtn'])) {
            $sname = $_REQUEST['sname'];
            $query = "select * from trash where name like '%$sname%'";
            $result = $this->con->query($query);
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            $query = "select * from trash";
            $result = $this->con->query($query);
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }

    //duplicate record display
    public function duplicate()
    {
        $query = "SELECT * FROM `allcontacts` ";
        $result = $this->con->query($query);
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    // getting duplicate contacts
    public function getDup($id)
    {
        $query = "SELECT * FROM `allcontacts` where id = $id";
        $result = $this->con->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row;
        }
    }

    ///////////////////////////Delete Methods////////////////////////////////


    //delete function
    public function delete($id)
    {
        $uname = "Logo.png";
        $query = "select image from allcontacts where id=$id";
        $result = $this->con->query($query);
        $getimage = $result->fetch_assoc();
        $query = "insert into trash select * from allcontacts where id=$id";
        $result = $this->con->query($query);
        if ($result == true) {

            $query = "delete from allcontacts where id=$id";
            $result = $this->con->query($query);
            if ($getimage['image'] == $uname && $result == true) {
                echo "Record Deleted";
            } elseif ($getimage['image'] != $uname) {
                echo "Record deleted";
            } else {
                echo "Record not deleted";
            }
            clearstatcache();
        }
    }

    //permanent delete function
    public function pdelete($id)
    {
        $query = "select image from trash where id=$id";
        $result = $this->con->query($query);
        $getimage = $result->fetch_assoc();
        $query = "delete from trash where id=$id";
        $result = $this->con->query($query);
        if ($getimage['image'] == "Logo.png") {
            echo "Record permanently deleted";
        } else {
            unlink('upload/' . $getimage['image']);
            echo "Record permanently deleted";
        }
    }

    //restore
    public function restore($id)
    {
        $query = "insert into allcontacts select * from trash where id=$id";
        $result = $this->con->query($query);
        if ($result == true) {
            $query = "delete from trash where id=$id";
            $result = $this->con->query($query);
            if ($result == true) {
                echo "Record Restored";
            }
        } else {
            echo "Contact Not Restored";
        }
    }
    //delete all
    public function dall()
    {
        $query = "truncate trash";
        $result = $this->con->query($query);
        if ($result == true) {
            echo "Trash Is Empty Now";
        } else {
            echo "Trash cant be empty";
        }
    }
}
