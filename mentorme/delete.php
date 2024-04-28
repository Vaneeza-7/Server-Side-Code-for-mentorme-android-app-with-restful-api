<?php
include 'conn.php';
$response=array();
if(isset($_POST['id']))
{
    $id=$_POST['id'];
    $query="DELETE FROM `students` WHERE `id`=$id";
    $res=mysqli_query($conn,$query);
    if($res)
    {
        $response['message']="Data Deleted Successfully";
        $response['status']=1;
    }
    else
    {
        $response['message']="Data Deletion Failed";
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