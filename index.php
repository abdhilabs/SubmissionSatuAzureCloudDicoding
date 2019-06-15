<html>
 <head>
 <Title>Form Pendaftaran</Title>
 <style type="text/css">
 	body { background-color: #fff; border-top: solid 10px #000;
 	    color: #333; font-size: .85em; margin: 20; padding: 20;
 	    font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
 	}
 	h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
 	h1 { font-size: 2em; }
 	h2 { font-size: 1.75em; }
 	h3 { font-size: 1.2em; }
 	table { margin-top: 0.75em; }
 	th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
 	td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
 </style>
 </head>
 <body>
 <h1>Daftar Di sini!</h1>
 <p>Isikan Nama, Nomor Telpon & Asal, lalu klik <strong>Daftar</strong> untuk mendaftar.</p>
 <form method="post" action="index.php" enctype="multipart/form-data" >
       Nama  <input type="text" name="name" id="name"/></br></br>
       Nomor <input type="number" name="nomer" id="nomer"/></br></br>
       Asal <input type="text" name="asal" id="asal"/></br></br>
       <input type="submit" name="submit" value="Daftar" />
       <input type="submit" name="load_data" value="Load Data" />
 </form>
 <?php
    $host = "<Nama server database Anda>";
    $user = "<Nama admin database Anda>";
    $pass = "<Password admin database Anda>";
    $db = "<Nama database Anda>";

    try {
        $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch(Exception $e) {
        echo "Gagal: " . $e;
    }

    if (isset($_POST['submit'])) {
        try {
            $name = $_POST['name'];
            $nomer = $_POST['nomer'];
            $asal = $_POST['asal'];
            $date = date("Y-m-d");
            // Insert data
            $sql_insert = "INSERT INTO Registration (name, nomer, asal, date) 
                        VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $nomer);
            $stmt->bindValue(3, $asal);
            $stmt->bindValue(4, $date);
            $stmt->execute();
        } catch(Exception $e) {
            echo "Gagal: " . $e;
        }

        echo "<h3>Anda sudah mendaftar!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
            $sql_select = "SELECT * FROM Registration";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll(); 
            if(count($registrants) > 0) {
                echo "<h2>Calon Santri yang sudah mendaftar :</h2>";
                echo "<table>";
                echo "<tr><th>Nama</th>";
                echo "<th>Nomer Telepon</th>";
                echo "<th>Asal</th>";
                echo "<th>Tanggal</th></tr>";
                foreach($registrants as $registrant) {
                    echo "<tr><td>".$registrant['name']."</td>";
                    echo "<td>".$registrant['nomer']."</td>";
                    echo "<td>".$registrant['asal']."</td>";
                    echo "<td>".$registrant['date']."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<h3>Tidak ada yang terdaftar saat ini.</h3>";
            }
        } catch(Exception $e) {
            echo "Gagal: " . $e;
        }
    }
 ?>
 </body>
 </html>