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
        $sql = "UPDATE mahasiswa SET Nama=?, NIM=?, Tugas=?, UTS=?, UAS=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssi", $param_Nama, $param_NIM, $param_Tugas, $param_UTS, $param_UAS, $param_id);
            
            // Set parameters
            $param_Nama = $Nama;
            $param_NIM = $NIM;
            $param_Tugas = $Tugas;
            $param_UTS = $UTS;
            $param_UAS = $UAS;
            $param_id = $id;
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM mahasiswa WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                $Nama = $row["Nama"];
                $NIM = $row["NIM"];
                $Tugas = $row["Tugas"];
                $UTS = $row["UTS"];
                $UAS = $row["UAS"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 1080px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the mahasiswa record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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