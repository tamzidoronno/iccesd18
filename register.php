<?php session_start();
if( isset($_SESSION['id']) )  unset($_SESSION['id']);
//$link_id = mysql_connect("localhost","root",""); $dbname = "iccesd"; $st="";
$link_id = mysql_connect("localhost","iccesd_iccesd","*iccesd18"); $dbname = "iccesd_iccesd"; $st="";
if(!mysql_select_db($dbname,$link_id)) die(mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title>Submission: 4th ICCESD'2018, KUET</title>
</head>



<body style="margin: 0px auto; padding: 0px; background:#000;">
   <div style=" margin:0 auto; width:1000px; background:#fff;">
<table border=0; width="100%" cellpadding="0" cellspacing="0">
  
  <tr><td width="17%" rowspan="2" align="right" valign="bottom"><img src="images/h4-1.jpg" width="169" height="305" /></td>
    <td width="66%" align="center" style="font-size:28px; color:#696969; line-height:35px; padding-top:20px; padding-bottom:10px;"><span style="font-size:36px; font-family:'Brush Script MT';">4th</span> <b style="font-size:42px;">I</b>nternational <b style="font-size:42px;">C</b>onference on <br />
      <b style="font-size:42px;">C</b>ivil <b style="font-size:42px;">E</b>ngineering for <b style="font-size:42px;">S</b>ustainable <b style="font-size:42px;">D</b>evelopment<br /><span style="font-size:38px; font-weight:bold; color:#006400;">IC</span><span style="font-size:38px; font-weight:bold; color:#c00000;">CE</span><span style="font-size:38px; font-weight:bold; color:#006400;">SD</span><span style="font-size:38px; font-weight:bold; font-family:'Brush Script MT'; color:#c00000;"> 2018</span> </td><td width="17%" valign="center" align="center"> <img src="images/h0.png" /> </td> </tr>
    
  <tr>
    <td height="155" colspan="2" align="center" valign="bottom"> <img src="images/h4-2.jpg" width="200" height='150' />&nbsp;<img src="images/h4-3.jpg" width="200" height='150' />&nbsp;<img src="images/h4-4.jpg" width="200" height='150' />&nbsp;<img src="images/h4-5.jpg" width="200" height='150' /></td>  </tr>
  <tr>
    <td colspan="3" align="center" valign="middle" style="font-size:24px; font-weight:bold; color:#0000CD;" valign="top" height="50">9 – 11 February 2018 &nbsp; &nbsp; <span style="color:black;">Khulna, Bangladesh</span></td>
  </tr></table>
   
    <?php
if( isset($_POST['submit']) )
{
    if($_POST[pid]=="0000")
    {
      $payslip=mysql_fetch_array(mysql_query("select max(pid) pid from registertable")); if( isset($payslip['pid']) ) $payslip=$payslip['pid']+3; else {$payslip=777000;}
      $pid=$payslip; 
    }
    else {
      $pid=$_POST[pid];
    }  
  $sql = "INSERT INTO registerTable(name,email,address,phone,regtype,pid,payment,amount,payslip,pdate,payslip_img) VALUES('$_POST[name]','$_POST[email]','$_POST[address]','$_POST[phone]','$_POST[regtype]','$pid','$_POST[payment]','$_POST[amount]','$_POST[payslip]','$_POST[pdate]','1')";
  mysql_query($sql);

  if($_FILES['pimage']['error']>0){
             echo 'error';
   }
  else{
  
 //This function separates the extension from the rest of the file name and returns it 
 function findexts ($filename) 
 { 
 $filename = strtolower($filename) ; 
 $exts = split("[/\\.]", $filename) ; 
 $n = count($exts)-1; 
 $exts = $exts[$n]; 
 return $exts; 
 } 
 
 //This applies the function to our file  
 $ext = findexts($_FILES['pimage']['name']) ; 
    $upload_folder = '2018reg/';
    $prefix = ".";

    $link = $upload_folder.$pid.$prefix.$ext;
    move_uploaded_file($_FILES['pimage']['tmp_name'], $link);
    $pimage = "/2018reg/".$_FILES['pimage']['name'];
  }

  }
    
?>

    <fieldset  <?php if( !isset($_POST['submit']) ) echo "style='display:none;'"; ?> style="width:100%; font-weight:bold; border:hidden; text-align:center;" >
    <legend style="font-size:20px;color: green; text-align: center;">Thank you for registering at ICCESD 2018.</legend> 
          </fieldset>
   
        
        
        <fieldset <?php if( isset($_POST['submit']) ) echo "style='display:none;'"; ?> style="width:90%; font-weight:bold; background:#ddd; border-radius:0px 45px; border:hidden; text-align:left;" >
    <legend style="font-size:20px;"> Registration Form </legend> 
          <form method="post" enctype="multipart/form-data" action="register.php">
                    <table width="100%" border="0">
                      <tr>
                        <td align="right" valign="top">Name</td>
                        <td><input name="name" type="text" size="70"  autofocus required /><br /><br /></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top">Email</td>
                        <td><input name="email" type="text" size="70"  autofocus required /><br /><br /></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top">Address</td>
                        <td><input name="address" type="text" size="70"  autofocus required /><br /><br /></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top">Mobile No.</td>
                        <td><input name="phone" type="text" size="70"  autofocus required /><br /><br /></td>
                      </tr>
            <tr><td align="right" valign="top">Registering as:</td><td><select name="regtype"  requird>
           <option value="Author">Author</option>
            <option value="Local Delegate">Local Delegate</option>
            <option value="Local Student">Local Student</option>
            <option value="SAARC Delegate">SAARC Delegate</option>
            <option value="Foreign Delegate">Foreign Delegate</option>
            </select></td></tr>
                      <tr>
                        <td align="right" valign="top">Paper ID <br> (If no paper ID,type 0000)</td>
                        <td><input name="pid" type="text" size="30"  autofocus required /><br /><br /></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top">Payment Method</td>
                        <td><input type="radio" name="payment" value="DBBL"> DBBL<br>
                            <input type="radio" name="payment" value="Janata Bank Ltd"> Janata Bank Ltd<br>
                            <input type="radio" name="payment" value="Pay Order/Bank Draft"> Pay Order/Bank Draft  </td>
                      </tr>
            <tr>
                        <td align="right" valign="top">Paid Amount</td>
                        <td><input name="amount" type="text" size="30"  autofocus required /><br /><br /></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top">Pay Slip No.</td>
                        <td><input name="payslip" type="text" size="30"  autofocus required /></td>
                      </tr>
                       <tr>
                        <td align="right" valign="top">Pay Slip's Date<br>(DD-MM-YYYY)</td>
                        <td><input name="pdate" type="text" size="30"  autofocus required /></td>
                      </tr>
                      <tr>
                        <td align="right">Upload Pay Slip Image</td>
                <td><input type="file" name="pimage"></td>
                        <td>
                        </td>
                      </tr>
                      
                  
                      <tr>
                        <td colspan="2" align="center"><input type="submit" name="submit"> <input type="reset" value="Cancel" /></td>
                      </tr>
                    </table>
                </form></fieldset>
       
    
    </td>
    </tr>
  </table>  <br /><br />
</div>
</body>
</html>
