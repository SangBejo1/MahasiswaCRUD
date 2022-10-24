<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$Nama = $NIM = $Tugas = $UTS = $UAS ="";
$Nama_err = $NIM_err = $Tugas_err = $UTS_err = $UAS_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["Nama"]);
    if(empty($input_name)){
        $Nama_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Nama_err = "Please enter a valid name.";
    } else{
        $Nama = $input_name;
    }
    
    // Validate address
    $input_NIM = trim($_POST["NIM"]);
    if(empty($input_NIM)){
        $NIM_err = "Please enter the NIM.";     
    } elseif(!ctype_digit($input_NIM)){
        $NIM_err = "Please enter a positive integer value.";
    } else{
        $NIM = $input_NIM;
    }
    
    // Validate salary
    $input_Tugas = trim($_POST["Tugas"]);
    if(empty($input_Tugas)){
        $Tugas_err = "Please enter the Score.";     
    } elseif(!ctype_digit($input_Tugas)){
        $Tugas_err = "Please enter a positive integer value.";
    } else{
        $Tugas = $input_Tugas;
    }
    $input_UTS = trim($_POST["UTS"]);
    if(empty($input_UTS)){
        $UTS_err = "Please enter the Score.";     
    } elseif(!ctype_digit($input_UTS)){
        $UTS_err = "Please enter a positive integer value.";
    } else{
        $UTS = $input_UTS;
    }
    $input_UAS = trim($_POST["UAS"]);
    if(empty($input_UAS)){
        $UAS_err = "Please enter the Score.";     
    } elseif(!ctype_digit($input_UAS)){
        $UAS_err = "Please enter a positive integer value.";
    } else{
        $UAS = $input_UAS;
    }
    
    // Check input errors before inserting in database
    if(empty($Nama_err) && empty($NIM_err) && empty($Tugas_err)&& empty($UTS_err)&& empty($UAS_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO mahasiswa (Nama, NIM, Tugas, UTS, UAS) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_Nama, $param_NIM, $param_Tugas, $param_UTS, $param_UAS);
            
            // Set parameters
            $param_Nama = $Nama;
            $param_NIM = $NIM;
            $param_Tugas = $Tugas;
            $param_UTS = $UTS;
            $param_UAS = $UAS;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add mahasiswa record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="Nama" class="form-control <?php echo (!empty($Nama_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Nama; ?>">
                            <span class="invalid-feedback"><?php echo $Nama_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>NIM</label>
                            <input type="text" name="NIM" class="form-control <?php echo (!empty($NIM_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $NIM; ?>">
                            <span class="invalid-feedback"><?php echo $NIM_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Tugas</label>
                            <input type="text" name="Tugas" class="form-control <?php echo (!empty($Tugas_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Tugas; ?>">
                            <span class="invalid-feedback"><?php echo $Tugas_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>UTS</label>
                            <input type="text" name="UTS" class="form-control <?php echo (!empty($UTS_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $UTS; ?>">
                            <span class="invalid-feedback"><?php echo $UTS_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>UAS</label>
                            <input type="text" name="UAS" class="form-control <?php echo (!empty($UAS_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $UAS; ?>">
                            <span class="invalid-feedback"><?php echo $UAS_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>