<?php session_start();
if( isset($_SESSION['id']) )  unset($_SESSION['id']);
//$link_id = mysql_connect("localhost","root",""); $dbname = "iccesd"; $st="";
$link_id = mysql_connect("localhost","iccesd_iccesd","*iccesd18"); $dbname = "iccesd_iccesd"; $st="";
if(!mysql_select_db($dbname,$link_id)) die(mysql_error());

if( isset($_POST['login']) )
  { $paper=mysql_fetch_array(mysql_query("select * from submission where pid='$_POST[pid]' and id='$_POST[email]' and fullpaper='1'"));
    $paper['author']=explode('~',$paper['author']);  $paper['email']=explode('~',$paper['email']); $paper['affiliation']=explode('~',$paper['affiliation']); 
  }
else if( isset($_POST['admin']) )
  { if( (md5($_POST['email'])=="21232f297a57a5a743894a0e4a801fc3") && (md5($_POST['pid'])=="8798df22313af2041607465cbcded09b") )
      { $_SESSION['id']=$_POST['email'];
      header("Location: admin.php");
      //change
      die();
      }
    
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title>Submission: 4th ICCESD'2018, KUET</title>
<script>
function addauthor(no)
 { document.getElementById('ath'+no).innerHTML="<table width='100%' align='left' border='0'><tr> <td align='right' width='18%'>(Author "+no+") Name</td><td width='82%'><input name='author"+no+"' type='text' size='40' /> </td> </tr> <tr><td align='right'>Email</td> <td><input name='email"+no+"' type='text' /></td> </tr> <tr> <td align='right' valign='top'>affiliation</td> <td><input name='affiliation"+no+"' type='text' size='60' /></td> </tr><tr> <td align='right' valign='top'>Contacting Author</td> <td><input name='contact' id='contact"+no+"' value='"+no+"' type='radio' /><br /><br /></td> </tr> <tr><td colspan='2' align='right' id='ath"+(no+1)+"'><input type='button' value='Add Author' onclick='addauthor("+(no+1)+")' /></td></tr></table>"; 
 }
</script>
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
  { $_POST['title']=str_replace("'", "&#39;", $_POST['title']); $_POST['title']=str_replace('"', '&quot;', $_POST['title']);
  if( isset($_POST['pid']) )
    { for( $i=1, $author=array(), $email=array(), $affiliation=array(), $emailr=array(),$cont="" ; isset($_POST['author'.$i]) ; $i++ ) 
         {  if( $_POST['author'.$i]!="") 
             { if( $i == $_POST['contact'] ) $cont=$_POST['email'.$i];  array_push($emailr,$_POST['author'.$i]." <".$_POST['email'.$i].">");
           array_push($author,$_POST['author'.$i]); array_push($email,$_POST['email'.$i]); array_push($affiliation,$_POST['affiliation'.$i]);
           }  
         }
    $author=implode("~",$author); $email=implode("~",$email); $affiliation=implode("~",$affiliation); $emailr=implode(", ",$emailr);
      mysql_query("update submission set id='$cont',title='$_POST[title]',author='$author',email='$email',keyword='$_POST[keywords]',abstract='$_POST[abstract]',remarks='$_POST[track]' where pid='$_POST[pid]'");
      if( mysql_affected_rows() )
      { $txt = "Dear Author,\n\n Thank you for updating your paper (Paper id: $_POST[pid]) for ICCESD 2018.\n\n\n\nThanking you\n---------------------\nDr. Abu Zakir Morshed\nOrganizing Secretary, ICCESD 2018\n&\nProfessor, Department of Civil Engineering\nKhulna University of Engineering & Technology (KUET)\nKhulna 9203, Bangladesh\nEmail: iccesd2018@gmail.com\nPhone: +88041 769 471 ext. 239 (off.), +8801714 220 410 (cell)";
          mail("$emailr","ICCESD 2018: Thank you for updating your paper",$txt,"From: ICCESD 2018 KUET <office@iccesd.com\r\nCC: iccesd2018@gmail.com");    
          echo $emailr;
      }   
    }
  else {
  $pid=mysql_fetch_array(mysql_query("select max(pid) pid from submission")); if( isset($pid['pid']) ) $pid=$pid['pid']+3; else $pid=4101; 
  for( $i=1, $author=array(), $email=array(), $affiliation=array(), $emailr=array(),$cont="" ; isset($_POST['author'.$i]) ; $i++ ) 
     { if( $_POST['author'.$i]!="") 
         { if( $i == $_POST['contact'] ) $cont=$_POST['email'.$i];  array_push($emailr,$_POST['author'.$i]." <".$_POST['email'.$i].">");
         array_push($author,$_POST['author'.$i]); array_push($email,$_POST['email'.$i]); array_push($affiliation,$_POST['affiliation'.$i]); 
       }  
     }
  $author=implode("~",$author); $email=implode("~",$email); $affiliation=implode("~",$affiliation); $emailr=implode(", ",$emailr);
    if(!mysql_query("insert into submission values('$pid','$cont','$_POST[title]','$author','$email','$affiliation','$_POST[keywords]','$_POST[abstract]','$_POST[track]','0')")) echo mysql_error();
  else {
  $txt = "Dear Author,\n\nThank you for your submission in ICCESD 2018. Please use the Contacting Author's email ID and your paper ID for log-in and future correspondence with us.\n\nPaper ID: $pid\nTitle: $_POST[title]\nAuthor(s): $author\n\n\n\nThanking you\n---------------------\nDr. Abu Zakir Morshed\nOrganizing Secretary, ICCESD 2018\n&\nProfessor, Department of Civil Engineering\nKhulna University of Engineering & Technology (KUET)\nKhulna 9203, Bangladesh\nEmail: iccesd2018@gmail.com\nPhone: +88041 769 471 ext. 239 (off.), +8801714 220 410 (cell)";
  mail("$emailr","ICCESD 2018: Thank you for your submission",$txt,"From: ICCESD 2018 KUET <office@iccesd.com\r\nCC: iccesd2018@gmail.com");

  
  }
  }
  }
?>

    <fieldset  <?php if( !isset($_POST['submit']) ) echo "style='display:none;'"; ?> style="width:100%; font-weight:bold; border:hidden; text-align:center;" >
    <legend style="font-size:20px;color: green; text-align: center;">Thank you for your submission in ICCESD 2018.<br> The confirmation message has been sent to your email.<?php echo emailr ?> <br> Please check your email (including the Spam or Junk folder) for details.  </legend> 
          </fieldset>
    <fieldset  <?php if( (isset($_GET['op']) || isset($paper['pid']) || isset($_POST['submit']))  ) echo "style='display:none;'"; ?> style="width:45%; font-weight:bold; background:#ddd; border-radius:0px 45px; border:hidden; text-align:left; margin-left: 25%" >
    <legend style="font-size:20px;"> Downloads &nbsp &nbsp  &nbsp;&nbsp;&nbsp;&nbsp;Login </legend> 
          <form method="post">
                    <table width="100%" border="0">
                      <tr>
                        <td width="29%" rowspan="" align="center" style="border-right:1px solid green;"><a href="templatepapers17/FP_ICCESD2018.doc">Full Paper</a></td><td align="right">Email ID:</td><td><input autofocus type="text" name="email" required /></td></tr>
                       <tr><td width="29%" rowspan="" align="center" style="border-right:1px solid green;"><a href="templatepapers17/abstract_ICCESD2018.doc">Executive Summary</a></td><td width="17%" align="right">Paper ID:</td>
                        <td width="54%"><input type="text" name="pid" required size="10" /></td></tr>
                        <tr><td width="29%" rowspan="" align="center" style="border-right:1px solid green;"><a href="templatepapers17/APA_guide.pdf">Referencing Style</a></td><td colspan="2" align="center"><span style="color:red;"> To Update Submission </span>
                          <input type="submit" name="login" value="Login" /> &nbsp; <a href="index.html">Home</a></td></tr>

                      <tr>
                        
                      </tr>
                    </table>
                </form></fieldset>    <?php if( isset($_POST['login']) ) echo $st; ?>
        
        
        <fieldset  <?php if( !isset($_GET['op'])   && !isset($paper['pid']) || (isset($_GET['op']) && $_GET['op']!="new") ) echo "style='display:none;'"; ?> style="width:90%; font-weight:bold; background:#ddd; border-radius:0px 45px; border:hidden; text-align:left;" >
    <legend style="font-size:20px;"> Sign In </legend> 
          <form method="post" action="fullpaper.php"> <?php if( isset($paper['pid']) ) echo "<input type='hidden' name='pid' value='$paper[pid]' />"; $_SESSION['pass'] = $paper['pid']; $_SESSION['epass'] = $paper['id']; ?>
                    <table width="100%" border="0">
                      <tr>
                        <td align="right" valign="top">Title</td>
                        <td><input name="title" type="text" size="70" style="background-color:#c2c2a3;" autofocus required <?php if( isset($paper['pid']) ) echo "value='$paper[title]'"; ?> readonly /><br /><br /></td>
                      </tr>
            <tr>
                        <td width='18%' align="right">(Author 1) Name</td>
                        <td width='82%'><input name="author1" type="text" size="40" style="background-color:#c2c2a3;" required <?php if( isset($paper['pid']) ) { $temp=$paper['author'][0]; echo "value='$temp'"; } ?> readonly /> </td>
                      </tr>
            <tr>
                        <td align="right">Email</td>
                        <td><input name="email1" type="text" style="background-color:#c2c2a3;" required <?php if( isset($paper['pid']) ){ $temp=$paper['email'][0]; echo "value='$temp'"; } ?> readonly /></td>
                      </tr>
            <tr>
                        <td align="right">affiliation</td>
                        <td><input name="affiliation1" type="text" size="60" style="background-color:#c2c2a3;" required <?php if( isset($paper['pid']) ) { $temp=$paper['affiliation'][0]; echo "value='$temp'"; } ?> readonly /></td>
                      </tr>
            <tr>
                        <td align="right" valign="top">Contacting Author</td>
                        <td><input name="contact" id="contact1" type="radio" value="1" checked readonly /><br /><br /></td>
                      </tr>
            <tr>
                        <td width="18%" align="right">(Author 2) Name</td>
                        <td width="82%"><input name="author2" type="text" size="40" style="background-color:#c2c2a3;" <?php  if( isset($paper['author'][1]) ) { $temp=$paper['author'][1]; echo "value='$temp'"; } ?> readonly /> </td>
                      </tr>
            <tr>
                        <td align="right">Email</td>
                        <td><input name="email2" type="text" style="background-color:#c2c2a3;" <?php if( isset($paper['email'][1]) ) { $temp=$paper['email'][1]; echo "value='$temp'";} ?> readonly /></td>
                      </tr>
            <tr>
                        <td align="right">affiliation</td>
                        <td><input name="affiliation2" type="text" size="60" style="background-color:#c2c2a3;" <?php if( isset($paper['affiliation'][1]) ) { $temp=$paper['affiliation'][1]; echo "value='$temp'";} ?> readonly /></td>
                      </tr>
            <tr>
                        <td align='right' valign='top'>Contacting Author</td>
                        <td><input name='contact' id="contact2" type='radio' value="2" style="background-color:#c2c2a3;" <?php if( isset($paper['email'][1]) && $paper['email'][1]==$paper['id'] ) echo "checked"; ?> readonly /><br /><br /></td>
                      </tr>
        <?php
           for( $i=3 ; isset($paper['author'][$i-1]) ; $i++ )
            { echo "<tr>
                        <td align='right'>(Author $i) Name</td>
                        <td><input name='author$i' type='text' size='40' style='background-color:#c2c2a3;' value='".$paper['author'][$i-1]."' readonly /> </td>
                      </tr>
            <tr>
                        <td align='right'>Email</td>
                        <td><input name='email$i' type='text' style='background-color:#c2c2a3;' value='".$paper['email'][$i-1]."' readonly /></td>
                      </tr>
            <tr>
                        <td align='right'>affiliation</td>
                        <td><input name='affiliation$i' type='text' style='background-color:#c2c2a3;' size='60' value='".$paper['affiliation'][$i-1]."' readonly /></td>
                      </tr>
            <tr>
                        <td align='right' valign='top'>Contacting Author</td>
                        <td><input name='contact' id='contact$i' type='radio'  value='$i' ".($paper['email'][$i-1]==$paper['id']?"checked":"")." readonly /><br /><br /></td>
                      </tr>";           
            }
        ?>
            
            <tr><td align="right" valign="top">Track</td><td><select name="track" style="background-color:#c2c2a3;" requird>
            <?php $track=array("Structural and Earthquake Engineering","Geotechnical and Geological Engineering","Environmental Engineering","Transporatation Planning and Traffic Management","Water Resources Engineering","Construction Engineering and Management","Fire Engineering");
            for( $i=0 ; isset($track[$i]) ; $i++ ) 
               { $se=""; if( isset($paper['remarks']) && $i==$paper['remarks'] ) $se="selected"; echo "<option value='$i' $se>$track[$i]</option>"; }  
            ?>
            </select></td></tr>
            <tr>
                        <td align="right" valign="top">Abstract</td>
                        <td><textarea readonly name="abstract" cols="70" rows="6" style="background-color:#c2c2a3;" required="required"> <?php if( isset($paper['pid']) ) echo "$paper[abstract]"; ?> </textarea> </td>
                      </tr>  
            <tr>
                        <td align="right">Keywords</td>
                        <td><input name="keywords" type="text" size="50" style="background-color:#c2c2a3;" required <?php if( isset($paper['pid']) ) echo "value='$paper[keyword]'"; ?> readonly /> 
                        (Separated by semicolon)</td>
                      </tr>
                      
        <!--    <tr>
                        <td align="right">File :</td>
                        <td><input type="file" accept="application/pdf" disabled="disabled"  /> 
                        (only pdf)</td>
                      </tr>  -->                  
                      <tr>
                        <td colspan="2" align="center"> <a href="fullpaper.php"><button style="background-color: #122e6f; color: white;font-size: 20px;border-radius: 8px;"> Click to Upload Full Paper</button></a> &nbsp;<input type="reset" value="Cancel" /> <a href='index.html'>Log Out</a> </td>
                      </tr>
                    </table>
                </form></fieldset>
        <fieldset  <?php if( !isset($_GET['op']) || (isset($_GET['op']) && $_GET['op']!="admin")  ) echo "style='display:none;'"; ?>style="width:45%; font-weight:bold; background:#ddd; border-radius:0px 45px; border:hidden; text-align:left; margin-left: 25%" >
    <legend style="font-size:20px;"> Login </legend> 
          <form method="post">
                    <table width="100%" border="0">
                      <tr>
                        <td width="29%" rowspan="3" align="center" style="border-right:1px solid green;"><a href="submission.php?op=new">Sign Up for New Submission</a></td>
                        <td align="right">User ID:</td>
                        <td><input autofocus type="text" name="email" required /></td>
                      </tr>
            <tr>
              <td width="17%" align="right">Password:</td>
                        <td width="54%"><input type="password" name="pid" required size="10" /></td>
                      </tr>                      
                      <tr>
                        <td colspan="2" align="center">                   <input type="submit" name="admin" value="Admin Login" /> &nbsp; <a href="index.html">Home</a></td>
                      </tr>
                    </table>
                </form></fieldset>
    
    </td>
    </tr>
  </table>  <br /><br />
</div>
</body>
</html>
