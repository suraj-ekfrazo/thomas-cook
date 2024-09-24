<!DOCTYPE html>
<html>
<head>
	<title>Email Test Page</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>


<div class="container" style="border: 1px solid #ddd;margin-top: 15px;">
  <h2 style="text-align: center;color: #0678d1;font-size: 2em;">Below are your login details</h2>
         
  <table class="table"  style="width: 70%;text-align: center;margin: auto;border: 1px solid #ddd;    background-color: #6e99d0;
    color: white;margin-bottom: 25px;">


      <tr>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;">User Name</td>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;"><?php echo $data['agent_user_name'] ?></td>
      </tr>
       <tr>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;">User Password</td>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;"><?php echo $agentPassword ?></td>
      </tr>
       <tr >
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;">Agent Code</td>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;"><?php echo $data['agent_code'] ?></td>
      </tr>
  	<tr>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;">Status</td>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;"><?php echo $data['agent_status'] ?></td>
      </tr>
       <tr>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;">Validity From</td>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;"><?php echo $data['agent_form'] ?></td>
      </tr>
       <tr>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;">Validity Till</td>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;"><?php echo $data['agent_to'] ?></td>
      </tr>
      <tr>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;">Buy Margin</td>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;"><?php echo $data['agent_buy'] ?></td>
      </tr>
       <tr>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;">Sell Margin</td>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;"><?php echo $data['agent_sell'] ?></td>
      </tr>
       <tr>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;">First Name</td>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;"><?php echo $data['agent_first_name'] ?></td>
      </tr>
      <tr>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;">Last Name</td>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;"><?php echo $data['agent_last_name'] ?></td>
      </tr>
       <tr>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;">Contact No.</td>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;"><?php echo $data['agent_contact'] ?></td>
      </tr>
       <tr>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;">Email-Id</td>
        <td style="text-align: left;border: 1px solid #ddd;width: 50%;text-align: center;padding:10px 15px;"><?php echo $data['agent_mail'] ?></td>
      </tr>
  </table>
</div>



<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>