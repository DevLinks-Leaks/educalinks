<html>
<body>
<?php

// Check if one of the student name links was clicked

if(isset($_GET["action"]) == "get_client"){
    
    // Get the specific student data
    
    $client_info = file_get_contents('http://desarrollo.educalinks.com.ec/ws/api.php?action=get_client&clie_codi=' . $_GET["clie_codi"]);
    
    // Decode from JSON into an array
    
    $client_info = json_decode($client_info, true);
    
?>

First Name : <?php var_dump($client_info); ?><br />
Last Name : <?php echo $client_info["client_codi"] ?><br />

<?php

}

 // else // else print out the list of students
 
 // {
    
 //    // Call the method get_student_list in the API to get the list
    
 //    $student_list = file_get_contents('http://desarrollo.educalinks.com.ec/ws/api.php?action=get_student_list');
    
 //    // Convert from JSON and into an array
    
 //    $student_list = json_decode($student_list, true);
    
?>


</body>
</html>