<?php
include 'conn.php';
$response=array();
if(isset($_POST['id']))
{
    $query="UPDATE `students` SET ";
    if(isset($_POST['name']))
    {
        $name=$_POST['name'];
        $query=$query."`name`='$name', ";
    }
    if(isset($_POST['phone']))
    {
        $phone=$_POST['phone'];
        $query=$query."`phone`='$phone', ";
    }
    if(isset($_POST['email']))
    {
        $email=$_POST['email'];
        $query=$query."`email`='$email', ";
    }
    $query = rtrim($query, ", ");
    $id=$_POST['id'];
    $query=$query." WHERE `id`=$id";
    $res=mysqli_query($conn,$query);
    if($res)
    {
        $response['message']="Data Updated Successfully";
        $response['status']=1;
    }
    else
    {
        $response['message']="Data Updation Failed";
        $response['status']=0;
    }
}
else
{
    $response['message']="Incomplete Request";
    $response['status']=0;
}
echo json_encode($response);


?>