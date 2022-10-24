<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"
        integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style type="text/css">
        .wrapper {
            width: 1080px;
            margin: auto;
        }

        .page-header h2 {
            margin-top: 0;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Data Mahasiswa</h2>
                        <a href="create.php" class="btn btn-succes pull-right">Tambah Mahasiswa</a>
                    </div>
                    <?php
                require_once "config.php";
                $sql=("SELECT id, Nama, NIM, Tugas, UTS, UAS, (Tugas+UTS+UAS)/3 as nilaiAkhir from mahasiswa");
                if($result = mysqli_query($link, $sql)){
                if(mysqli_num_rows($result) >0){
                    echo "<table class='table'>";
                    echo "<thead class='thead-dark'>";
                           echo "<tr>";
                            echo "<th scope='col'>#</th>";
                            echo "<th scope='col'>Nama</th>";
                            echo "<th scope='col'>NIM</th>";
                            echo"<th scope='col'>TUGAS</th>";
                            echo "<th scope='col'>UTS</th>";
                            echo "<th scope='col'>UAS</th>";
                            echo "<th scope='col'>Nilai_Akhir</th>";
                            echo "<th scope='col'>Setting</th>";
                           echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>"; 
                    while ($row = mysqli_fetch_array($result)){
                        echo "<tr>";
                            echo "<td>". $row['id'] ."</td>";
                            echo "<td>". $row['Nama'] ."</td>";
                            echo "<td>". $row['NIM'] ."</td>";
                            echo "<td>". $row['Tugas'] ."</td>";
                            echo "<td>". $row['UTS'] ."</td>";
                            echo "<td>". $row['UAS'] ."</td>";
                            echo "<td>". $row['nilaiAkhir'] ."</td>";
                            echo "<td>";
                                echo "<a href='read.php?id=". $row['id'] , "' title='View Record' data-toggle='tooltip'>
                                <span class='glyphicon glyphicon-user'></span></a>";
                                echo "<a href='update.php?id=". $row['id'] , "' title='Update Record' data-toggle='tooltip'>
                                <span class='glyphicon glyphicon-pencil'></span></a>";
                                echo "<a href='delete.php?id=". $row['id'] , "' title='Delete Record' data-toggle='tooltip'>
                                <span class='glyphicon glyphicon-remove'></span></a>";
                            echo"</td>";
                        echo"</tr>";
                    }
                    echo "</tbody>";
                    echo"</table>";

                    mysqli_free_result($result);    
                }else{
                    echo "<p class='lead'><em> No Record were found.</em></p>";

                }
                echo "ERROR: could not able to execute $sql. " . mysqli_error($link);
            }
            mysqli_close($link);
            ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>