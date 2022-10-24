<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$NIM = $Nama =  $Tugas =$UTS =$UAS ="";
$NIM_err = $Nama_err  =$Tugas_err =$UTS_err =$UAS_err ="";

 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate nim
    $input_NIM = trim($_POST["NIM"]);
    if(empty($input_NIM)){
        $NIM_err = "Please enter the nim value.";
    } elseif(!ctype_digit($input_NIM)){
        $NIM_err = "Please enter a positive integer value.";
    } else{
        $NIM = $input_NIM;
    }

    // Validate name
  $input_Nama = trim($_POST["Nama"]);
  if(empty($input_Nama)){
      $Nama_err = "Please enter a name.";
  } elseif(!filter_var($input_Nama, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
      $Nama_err = "Please enter a valid name.";
  } else{
      $Nama = $input_Nama;
  }

  
  // Validate tugas
  $input_Tugas = trim($_POST["Tugas"]);
  if(empty($input_Tugas)){
      $Tugas_err = "Please enter the tugas value.";
  } elseif(!ctype_digit($input_Tugas)){
      $Tugas_err = "Please enter a positive integer value.";
  } else{
      $Tugas = $input_Tugas;
  }

  // Validate uts
  $input_UTS = trim($_POST["UTS"]);
  if(empty($input_UTS)){
      $UTS_err = "Please enter the uts value.";
  } elseif(!ctype_digit($input_UTS)){
      $UTS_err = "Please enter a positive integer value.";
  } else{
      $UTS = $input_UTS;
  }

  // Validate uas
  $input_UAS = trim($_POST["UAS"]);
  if(empty($input_UAS)){
      $UAS_err = "Please enter the uas value.";
  } elseif(!ctype_digit($input_UAS)){
      $UAS_err = "Please enter a positive integer value.";
  } else{
      $UAS = $input_UAS;
  }

    // Check input errors before inserting in database
    if(empty($NIM_err) && empty($Nama_err) && empty($Tugas_err)  && empty($UTS_err)  && empty($UAS_err)){
        // Prepare an update statement
        $sql = "UPDATE mahasiswa SET NIM=?, Nama=?, Tugas=?, UTS=?, UAS=? WHERE id=?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssi",$param_NIM, $param_Nama,  $param_Tugas,  $param_UTS,  $param_UAS, $param_id);

            // Set parameters
            $param_NIM = $NIM;
            $param_Nama = $Nama;
            $param_Tugas =  $Tugas;
            $param_UTS = $UTS;
            $param_UAS = $UAS;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
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
                    $NIM = $row["NIM"];
                    $Nama = $row["Nama"];
                    $Tugas = $row["Tugas"];
                    $UTS = $row["UTS"];
                    $UAS = $row["UAS"];
                   
                } 
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group <?php echo (!empty($NIM_err)) ? 'has-error' : ''; ?>">
                                <label>NIM</label>
                                <input type="text" name="NIM" class="form-control" value="<?php echo $NIM; ?>">
                                <span class="help-block"><?php echo $NIM_err;?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($Nama_err)) ? 'has-error' : ''; ?>">
                                <label>Nama</label>
                                <input type="text" name="Nama" class="form-control" value="<?php echo $Nama; ?>">
                                <span class="help-block"><?php echo $Nama_err;?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($Tugas_err)) ? 'has-error' : ''; ?>">
                                <label>Tugas</label>
                                <input type="text" name="Tugas" class="form-control" value="<?php echo $Tugas; ?>">
                                <span class="help-block"><?php echo $Tugas_err;?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($UTS_err)) ? 'has-error' : ''; ?>">
                                <label>UTS</label>
                                <input type="text" name="UTS" class="form-control" value="<?php echo $UTS; ?>">
                                <span class="help-block"><?php echo $UTS_err;?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($UAS_err)) ? 'has-error' : ''; ?>">
                                <label>UAS</label>
                                <input type="text" name="UAS" class="form-control" value="<?php echo $UAS; ?>">
                                <span class="help-block"><?php echo $UAS_err;?></span>
                            </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>