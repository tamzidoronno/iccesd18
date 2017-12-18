<?php session_start();
if( isset($_SESSION['id']) )  unset($_SESSION['id']);
$link_id = mysql_connect("localhost","root",""); $dbname = "iccesd"; $st="";
//$link_id = mysql_connect("localhost","iccesd_iccesd","*iccesd18"); $dbname = "iccesd_iccesd"; $st="";
if(!mysql_select_db($dbname,$link_id)) die(mysql_error());


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title>Submission: 4th ICCESD'2018, KUET</title>
</head>

<?php
$dd = $_SESSION['epass'];
$ddpid = $_SESSION['pass'];
if(isset($_POST['ssubmit']))
        {
    $txt = "Dear Author(s),\n\n Thank you for your submission of full paper (Paper id: $ddpid) in ICCESD 2018. Please use the Contacting Author's email ID and your paper ID for log-in and future correspondence with us.  \n\n\n\nThanking you\n\n---------------------\nDr. Abu Zakir Morshed\nOrgainizing Secretary, ICCESD 2018\n&\nProfessor, Department of Civil Engineering\nKhulna University of Engineering & Technology (KUET)\nKhulna 9203, Bangladesh\nEmail: iccesd2018@gmail.com\nPhone: +88041 769 471 ext. 239 (off.), +8801714 220 410 (cell)";
            mail("$dd","ICCESD 2018: Thank you for your submission",$txt,"From: ICCESD 2018 KUET <office@iccesd.com>\r\nCC: iccesd2018@gmail.com");
            
        }
?>
<!-- <body style="margin: 0px auto; padding: 0px; background:#000;"> -->
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
  <fieldset  <?php if( !isset($_POST['ssubmit']) ) echo "style='display:none;'"; ?> style="width:100%; font-weight:bold; border:hidden; text-align:center;" >
    <legend style="font-size:20px;color: green; text-align: center;margin-left:18%;">Thank you for your submission in ICCESD 2018.<br> The confirmation message has been sent to your email. <br> Please check your email (including the Spam or Junk folder) for details.  </legend> 
    <a href="logout.php"><button><b>Log Out</b></button></a> </fieldset>
  <?php
    if(isset($_POST['ssubmit'])){

        if($_FILES['fullpaper']['error']>0 || $_FILES['exsum']['error']>0){
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
 $ext = findexts($_FILES['fullpaper']['name']) ; 
 $exts = findexts($_FILES['exsum']['name']) ;
    $upload_folder = '2018fullpaper/';
    $upload_folder2 = '2018exsum/';
    $ppid = $_SESSION['pass'];
    $prefix = ".";
    $fp = "p";
    $es = "a";

    $link = $upload_folder.$fp.$ppid.$prefix.$ext;
    move_uploaded_file($_FILES['fullpaper']['tmp_name'], $link);
    //move_uploaded_file($_FILES['fullpaper']['tmp_name'], $upload_folder.$_FILES['fullpaper']['name']);
    //move_uploaded_file($_FILES["image_file"]["tmp_name"],$link);
    $fullpaper = "/2018fullpaper/".$_FILES['fullpaper']['name'];

    $link2 = $upload_folder2.$es.$ppid.$prefix.$exts;
    move_uploaded_file($_FILES['exsum']['tmp_name'], $link2);
    $exsum = "/2018exsum/".$_FILES['exsum']['name'];
    
    $fpaper=mysql_query("UPDATE submission SET fullpaper = '1' where pid='$ppid'");
  }

  
    }

  ?>
        
        <fieldset style="width:90%;<?php if( isset($_POST['ssubmit']) ) echo 'display:none;'; ?> font-weight:bold; background:#ddd; border-radius:0px 45px; border:hidden; text-align:left;" >
    <legend style="font-size:20px;"> Upload Full Paper </legend>
    <tr><td color="#0000CD;" >upload .doc or .docx file </td> </tr>
          <form method="post" enctype="multipart/form-data" action="fullpaper.php"> 
                      <tr>
                        <td align="right">Upload Full Paper</td>
                <td><input type="file" name="fullpaper"></td>
                        <td>
                        </td>
                      </tr>
                      <tr>
                      <br>
                        <td align="right">Upload Executive Summary</td>
                <td><input type="file" name="exsum"></td>
                        <td>
                        </td>
                      </tr> 
        <!--    <tr>
                        <td align="right">File :</td>
                        <td><input type="file" accept="application/pdf" disabled="disabled"  /> 
                        (only pdf)</td>
                      </tr>  -->                  
                      <tr>
                        <td colspan="2" align="center"><input type="submit" name="ssubmit" <?php if( isset($paper['pid']) ) echo "value='Update'"; else echo "value='Submit'";  ?> />&nbsp;<input type="reset" value="Cancel" /> <a href='index.html'>Log Out</a> </td>
                      </tr>
                    </table>
                </form></fieldset>
    
    </td>
    </tr>
  </table>  <br /><br />
</div>
</body>
</html>
