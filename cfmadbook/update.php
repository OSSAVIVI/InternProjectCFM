<?php

//Connect to database and gain access to $conn variable
include('config/db_connect.php');

//Initiazlize the three fields as blank strings
$name = $phone = $email = '';

//Create an aarray to store error messages
$errors = array('name' => '', 'phone' => '', 'email' => '',);

$id_to_update_2 = ''; //will be used to access the correct db entry later on in program

//When page is loaded, if 'Update Client' submit button was pressed, then store all of the entries from
//FORM POST to populate the page with upon redirect
if (isset($_POST['update'])) {

    $id_to_update_2 = mysqli_real_escape_string($conn, $_POST['id_to_update']);
    //echo $id_to_update_2; // echo statement used for debugging
    $id_to_update = mysqli_real_escape_string($conn, $_POST['id_to_update']);
    $name_to_update = mysqli_real_escape_string($conn, $_POST['name_to_update']);
    $phone_to_update = mysqli_real_escape_string($conn, $_POST['phone_to_update']);
    $email_to_update = mysqli_real_escape_string($conn, $_POST['email_to_update']);

    //echo $id_to_update;
    $name = $name_to_update;
    $phone = $phone_to_update;
    $email = $email_to_update;
}

//When page is loaded, if 'Finished Updating Client' submit button was pressed, then validate the fields and 
//check for errors before finally INSERTING a new clinet and redirecting to index.php
if (isset($_POST['submit'])) {
    // Validation for name
    if (empty($_POST['name-field2'])) {
        $errors['name'] = 'ERROR: A name is required. Please enter a name before clicking \'Finished Adding Client\' <br> ';
    } else {
        $name = htmlspecialchars($_POST['name-field2']);
    }

    // Validation for phone
    if (empty($_POST['phone-number-field2'])) {
        $phone = 'none';
    } else {
        $phone = htmlspecialchars($_POST['phone-number-field2']);
    }

    // Validation for email
    if (empty($_POST['email-field2'])) {
        $errors['email'] = 'ERROR: An email is required. Please enter an email before clicking \'Finished Adding Client\' <br> ';
    } else {
        $email = $_POST['email-field2'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'ERROR: A valid email is required. Please enter a valid email before clicking \'Finished Adding Client\'';
        }
    }

    if (array_filter($errors)) {
        //echo errors in the form onto the screen wehre appropriate
    } else {

        $name2 = mysqli_real_escape_string($conn, $_POST['name-field2']);
        $phone2 = mysqli_real_escape_string($conn, $_POST['phone-number-field2']);
        $email2 = mysqli_real_escape_string($conn, $_POST['email-field2']);
        $id_to_update_3 = mysqli_real_escape_string($conn, $_POST['id_to_update3']);

        //UPDATE SQL
        $result2 = mysqli_multi_query(
            $conn,
            "UPDATE `clients` SET `name` = '$name2' WHERE `clients`.`id`='$id_to_update_3';" .
                "UPDATE `clients` SET `phone` = '$phone2' WHERE `clients`.`id`='$id_to_update_3';" .
                "UPDATE `clients` SET `email` = '$email2' WHERE `clients`.`id`='$id_to_update_3';"
        );

        //echo $name2 . $phone2 . $email2 . $id_to_update_3; // echo statement used for debugging

        //Save to database and check 
        if ($result2) {
            //successful save - redirect to index.php
            header('Location: index.php');
        } else {
            echo 'QUERY ERROR: ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>

<!--HEADER-->
<?php include('templates/header.php'); ?>

<!--UPDATE FORM to edit clients in the cfm_clients/clients.db database-->
<section class="form-container">
    <h2 align="center" class="###">Update client info below before clicking 'Finished Updating Client'.</h4>
        <form class="form-container" action="update.php" method="POST">
            <label>Client Name<span class="required">*</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: </label>
            <input type="text" name="name-field2" value="<?php echo htmlspecialchars($name); ?>">
            <div class="errors"><?php echo $errors['name']; ?></div>
            <br><br>
            <label>Client Phone Number&nbsp&nbsp: </label>
            <input type="text" name="phone-number-field2" value="<?php echo htmlspecialchars($phone); ?>">
            <div class="errors"><?php echo $errors['phone']; ?></div>
            <br><br>
            <label>Client Email<span class="required">*</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: </label>
            <input type="text" name="email-field2" value="<?php echo htmlspecialchars($email); ?>">
            <div class="errors"><?php echo $errors['email']; ?></div>
            <br><br>
            <input type='hidden' name='id_to_update3' value="<?php echo htmlspecialchars($id_to_update_2); ?>">
            <div>
                <input class="add-button" type="submit" name="submit" value="Finished Updating Client">
            </div>
        </form>
</section>

<!--HEADER-->
<?php include('templates/footer.php'); ?>


</html>