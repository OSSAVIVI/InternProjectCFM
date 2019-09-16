<?php

//Connect to database and gain access to $conn variable
include('config/db_connect.php');

//Initiazlize the three fields as blank strings
$name = $phone = $email = '';

//Create an aarray to store error messages
$errors = array('name' => '', 'phone' => '', 'email' => '',);

//When page is loaded, if 'Finished Adding Client' submit buton was pressed, then validate the fields and 
//check for errors before finally INSERTING a new clinet and redirecting to index.php
if (isset($_POST['submit'])) {
    // Validation for name
    if (empty($_POST['name-field'])) {
        $errors['name'] = 'ERROR: A name is required. Please enter a name before clicking \'Finished Adding Client\' <br> ';
    } else {
        $name = htmlspecialchars($_POST['name-field']);
    }

    // Validation for phone
    if (empty($_POST['phone-number-field'])) {
        $phone = 'none';
    } else {
        $phone = htmlspecialchars($_POST['phone-number-field']);
    }

    // Validation for email
    if (empty($_POST['email-field'])) {
        $errors['email'] = 'ERROR: An email is required. Please enter an email before clicking \'Finished Adding Client\' <br> ';
    } else {
        $email = $_POST['email-field'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'ERROR: A valid email is required. Please enter a valid email before clicking \'Finished Adding Client\'';
        }
    }

    if (array_filter($errors)) {
        //echo 'there are errors in the form';
    } else {

        $name = mysqli_real_escape_string($conn, $_POST['name-field']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone-number-field']);
        $email = mysqli_real_escape_string($conn, $_POST['email-field']);

        //Create SQL
        $sql = "INSERT INTO clients(name, phone, email) VALUES('$name', '$phone', '$email')";

        //Save to database and check if was successful
        if (mysqli_query($conn, $sql)) {
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

<!--INSERTION FORM to add clients to the cfm_clients/clients.db database-->
<section class="form-container">
    <h2 align="center" class="###">Enter client info below before clicking 'Finished Adding Client'.</h4>
        <form class="form-container" action="add.php" method="POST">
            <label>Client Name<span class="required">*</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: </label>
            <input type="text" name="name-field" value="<?php echo htmlspecialchars($name); ?>">
            <div class="errors"><?php echo $errors['name']; ?></div>
            <br><br>
            <label>Client Phone Number&nbsp&nbsp: </label>
            <input type="text" name="phone-number-field" value="<?php echo htmlspecialchars($phone); ?>">
            <div class="errors"><?php echo $errors['phone']; ?></div>
            <br><br>
            <label>Client Email<span class="required">*</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: </label>
            <input type="text" name="email-field" value="<?php echo htmlspecialchars($email); ?>">
            <div class="errors"><?php echo $errors['email']; ?></div>
            <br><br>
            <div>
                <input class="add-button" type="submit" name="submit" value="Finished Adding Client">
            </div>
        </form>
</section>

<!--FOOTER-->
<?php include('templates/footer.php'); ?>

</html>