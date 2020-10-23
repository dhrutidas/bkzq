<?php
// Merchant key here as provided by Payu
$MERCHANT_KEY = "USXGqSdn";
// Merchant Salt as provided by Payu
$SALT = "Q9PmRAbDhC";
//print_r($student);
// End point - change to https://secure.payu.in for LIVE mode
$PAYU_BASE_URL = "https://sandboxsecure.payu.in";//"https://secure.payu.in";

$action = '';

$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {
    $posted[$key] = $value;
  }
}

$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
		  || empty($posted['service_provider'])
  ) {
    $formError = 1;
  } else {
  //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }
    $hash_string .= $SALT;
    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
?>
<html>
  <head>
    <script>
    function cancelPay(userID){
      if(confirm('Are you sure want to cancel ?')){
        alert('Please mail to admin@bkzquiz.com for offline activation process.');
        location.href="<?php echo base_url('./'); ?>";
      }
    }
    </script>
  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
  </head>
  <body onload="submitPayuForm()" class="well">
    <h2>Big Knowledge Zone Payment</h2>
    <br/>
    <?php if($formError) { ?>
      <span style="color:red">Please fill all mandatory fields.</span>
      <br/>
      <br/>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post" name="payuForm">
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <div class="table-responsive"><table class="table">
        <tr>
          <td colspan="3"><b>Your User ID is : <?php echo $student['userID']; ?></b></br>For any query just mail us on <a href='mailto:admin@bkzquiz.com'>admin@bkzquiz.com</a><br/></td>
        </tr>
        <tr>
          <th>Amount: </th>
          <td>INR <?php echo (empty($fees)) ? '' : $fees ?><input type='hidden' name="amount" value="<?php echo (empty($fees)) ? '' : $fees ?>" /></td>
          <th>First Name: </th>
          <td><?php echo (empty($student['fName'])) ? '' : $student['fName']; ?><input type='hidden' name="firstname" id="firstname" value="<?php echo (empty($student['fName'])) ? '' : $student['fName']; ?>" /></td>
        </tr>
        <tr>
          <th>Email: </th>
          <td><?php echo (empty($student['emailID'])) ? '' : $student['emailID']; ?><input type='hidden' name="email" id="email" value="<?php echo (empty($student['emailID'])) ? '' : $student['emailID']; ?>" /></td>
          <th>Phone: </th>
          <td><?php echo (empty($student['contactNumber'])) ? '' : $student['contactNumber']; ?><input type='hidden' name="phone" value="<?php echo (empty($student['contactNumber'])) ? '' : $student['contactNumber']; ?>" /></td>
        </tr>
        <tr>
          <th>Product Info: </th>
          <td colspan="3">User ID :<?php echo $student['userID'];echo '<br/><strong>Package :'.$userPackageType.'</strong>'; ?><input type='hidden' name="productinfo" value='<?php echo (empty($student['userPackageType'])) ? '' : $student['userID'].'!~!'.$student['userPackageType'] ?>' /></td>
        </tr>
        <tr>
          <!--<td>Success URI: </td>-->
          <td colspan="3"><input type='hidden' name="surl" value="<?php echo base_url('paynow-success/').$student['userID']; ?>" size="64" /></td>
        </tr>
        <tr>
          <!--<td>Failure URI: </td>-->
          <td colspan="3"><input type='hidden' name="furl" value="<?php echo 'http://'. $config['base_url'].'/failure.php'; ?>" size="64" /></td>
        </tr>

        <tr>
          <td colspan="3"><input type="hidden" name="service_provider" value="payu_paisa" size="64" /></td>
        </tr>
        <tr>
          <?php if(!$hash) { ?>
            <td colspan="3" style='text-align:right'><input type="button" class="btn btn-danger" value="Pay Later" onclick="cancelPay(<?php echo $student['userID']; ?>)"/></td>
            <?php if(!($student['userPackageType']=='T')) { ?><td colspan="1" style='text-align:right'><input type="submit" class="btn btn-success" value="Pay now" /></td>
          <?php
         }
        }
        ?>
        </tr>
      </table>
    </div>
    </form>
  </body>
</html>
