<?php
ini_set('max_execution_time', 0);
$servername = "localhost";
$username = "root";
$password = "KI3AO0M6a@";
$database = "bpc_new";

// Create connection
$con = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}
else{
	echo "Connected";
}

exit;

$sql = "select * from incidents where agent_id='1'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    $i=0;
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {

    echo "<br>"."************************************************************************************************"."<br>";
    echo $row["inci_number"]. "<br>";
    $qry_document_comments = mysqli_query($con,"select * from document_comments where incident_number='".$row["inci_number"]."'");
    
    if(mysqli_num_rows($qry_document_comments)>0)
    {
    	echo "<br>"."--------------------------------------"."<br>";
    	//echo "<br>"."document_comments---->"."Delete from document_comments where incident_number='".$row["inci_number"]."'"."<br>";
        "<br>"."document_comments=====>'".$row["inci_number"]."'";
        mysqli_query($con,"Delete from document_comments where incident_number='".$row["inci_number"]."'");
    	echo "<br>"."--------------------------------------"."<br>";
    }

    $qry_document_buy = mysqli_query($con,"select * from incident_buy_documents where incident_number='".$row["inci_number"]."'");
    if(mysqli_num_rows($qry_document_comments)>0) {
        echo "<br>" . "--------------------------------------" . "<br>";
        //echo "<br>" . "incident_buy_documents---->" . "delete from incident_buy_documents where incident_number='" . $row["inci_number"] . "'";
        echo "<br>" . "incident_buy_documents=====>".$row["inci_number"];
        mysqli_query($con, "delete from incident_buy_documents where incident_number='" . $row["inci_number"] . "'");
        echo "<br>" . "--------------------------------------" . "<br>";
    }

    $qry_currency = mysqli_query($con,"select * from incident_currency where incident_id='".$row["inci_number"]."'");
    if(mysqli_num_rows($qry_currency)>0) {
        echo "<br>" . "--------------------------------------" . "<br>";
        //echo "<br>" . "incident_currency---->" . "delete from incident_currency where incident_id='" . $row["inci_number"] . "'";
        echo "<br>" . "incident_currency=====>".$row["inci_number"];
        mysqli_query($con, "delete from incident_currency where incident_id='" . $row["inci_number"] . "'");
        echo "<br>" . "--------------------------------------" . "<br>";
    }

    $qry_document_sell = mysqli_query($con,"select * from incident_sell_documents where incident_number='".$row["inci_number"]."'");
    if(mysqli_num_rows($qry_document_sell)>0) {
        echo "<br>" . "--------------------------------------" . "<br>";
        //echo "<br>" . "incident_sell_documents---->" . "delete from incident_sell_documents where incident_number='" . $row["inci_number"] . "'";
        echo "<br>" . "incident_sell_documents=====>" .$row["inci_number"];
        mysqli_query($con, "delete from incident_sell_documents where incident_number='" . $row["inci_number"] . "'");
        echo "<br>" . "--------------------------------------" . "<br>";
    }

    $qry_incident_update = mysqli_query($con,"select * from incident_update where inci_up_key='".$row["inci_key"]."'");
    if(mysqli_num_rows($qry_incident_update)>0) {
        echo "<br>" . "--------------------------------------" . "<br>";
        //echo "<br>" . "incident_update---->" . "delete from incident_update where inci_up_key='" . $row["inci_key"] . "'";
        echo "<br>" . "incident_update=====>" .$row["inci_key"];
        mysqli_query($con, "delete from incident_update where inci_up_key='" . $row["inci_key"] . "'");
        echo "<br>" . "--------------------------------------" . "<br>";
    }

    $qry_incident = mysqli_query($con,"select * from incidents where inci_number='".$row["inci_number"]."'");
    if(mysqli_num_rows($qry_incident)>0) {
        echo "<br>" . "--------------------------------------" . "<br>";
        //echo "<br>" . "incidents---->" . "delete from incidents where inci_number='" . $row["inci_number"] . "'";
        echo "<br>" . "incidents=====>" .$row["inci_number"];
        mysqli_query($con, "delete from incidents where inci_number='" . $row["inci_number"] . "'");
        echo "<br>" . "--------------------------------------" . "<br>";
    }
    echo "<br>"."************************************************************************************************"."<br>";
    //exit;
    $i++;
  }

  echo "<br>"."++++++++++++++++++++++++++++"."<br>";
  echo "<br>"."Total delete record==>".$i."<br>";
  echo "<br>"."++++++++++++++++++++++++++++"."<br>";

} else {
  echo "0 results";
}

?>
