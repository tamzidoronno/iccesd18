<?php  session_start(); if( !isset($_SESSION['id']) ) header("location:submission.php");
//$link_id = mysql_connect("localhost","root",""); $dbname = "iccesd"; $st="";
$link_id = mysql_connect("localhost","iccesd_iccesd","*iccesd18"); $dbname = "iccesd_iccesd"; $st="";
if(!mysql_select_db($dbname,$link_id)) die(mysql_error());

if( isset($_POST['action']) )
  { if( $_POST['action']=="Delete" ) mysql_query("delete from submission where id='$_POST[id]' and pid='$_POST[pid]'");
    else if( $_POST['action']=="Accept Abstract") {
	  $a=mysql_query("UPDATE submission SET accept_reject = '5' where id='$_POST[id]' and pid='$_POST[pid]'");
	  
	  $qquery=mysql_query("select * from submission where id='$_POST[id]' and pid='$_POST[pid]'") ; $rrow=mysql_fetch_array($qquery) ;
	  $x = $rrow[email];
	  $dd = str_replace("~", " , ", $x);
	  $txt = "Dear Author(s),\n\n Your abstract (Paper id: $rrow[pid]) has been accepted for ICCESD 2018. Congratulations! \n\n You may now log-in to submit your Full Paper along with a two-page Executive Summary. The necessary templates are available at the 'Submission' page of the conference website (www.iccesd.com). \n\n\n\nThanking you\n\n---------------------\nDr. Abu Zakir Morshed\nOrgainizing Secretary, ICCESD 2018\n&\nProfessor, Department of Civil Engineering\nKhulna University of Engineering & Technology (KUET)\nKhulna 9203, Bangladesh\nEmail: iccesd2018@gmail.com\nPhone: +88041 769 471 ext. 239 (off.), +8801714 220 410 (cell)";
	        mail("$dd","ICCESD 2018: Abstract accepted for ICCESD 2018",$txt,"From: ICCESD 2018 KUET <office@iccesd.com>\r\nCC: iccesd2018@gmail.com");

	  
	}
	else if( $_POST['action']=="Reject Abstract") {
	  $b=mysql_query("UPDATE submission SET accept_reject = '6' where id='$_POST[id]' and pid='$_POST[pid]'");
	  
	  $qquery=mysql_query("select * from submission where id='$_POST[id]' and pid='$_POST[pid]'") ; $rrow=mysql_fetch_array($qquery) ;
	  $x = $rrow[email];
	  $dd = str_replace("~", " , ", $x);
	  $txt = "Dear Author(s),\n\n I regret to inform you that your abstract (Paper id: $rrow[pid]) has been declined by the Editorial Committee for ICCESD 2018. Sorry!  \n\n However, you may attend the conference by paying the necessary registration fees in due course. \n\n\n\nThanking you\n\n---------------------\nDr. Abu Zakir Morshed\nOrgainizing Secretary, ICCESD 2018\n&\nProfessor, Department of Civil Engineering\nKhulna University of Engineering & Technology (KUET)\nKhulna 9203, Bangladesh\nEmail: iccesd2018@gmail.com\nPhone: +88041 769 471 ext. 239 (off.), +8801714 220 410 (cell)";
	        mail("$dd","ICCESD 2018: Decision on your abstract for ICCESD 2018",$txt,"From: ICCESD 2018 KUET <office@iccesd.com>\r\nCC: iccesd2018@gmail.com");
	    		
	}
	else if( $_POST['action']=="Allow fullpaper") {
	  $a=mysql_query("UPDATE submission SET fullpaper = '88' where id='$_POST[id]' and pid='$_POST[pid]'");
	}
	else if( $_POST['action']=="Restrict fullpaper") {
	  $a=mysql_query("UPDATE submission SET fullpaper = '99' where id='$_POST[id]' and pid='$_POST[pid]'");
	}
  }
else if( isset($_POST['admin']) )
  { if( (($_POST['email'])=="admin") && (($_POST['pid'])=="admin") )
      { $_SESSION['id']=$_POST['email'];
      header("Location: http://iccesd.com/admin.php");
      //change
      }   
  }
else if( isset($_POST['submit']) )
  { $_POST['title']=str_replace("'", "&#39;", $_POST['title']); $_POST['title']=str_replace('"', '&quot;', $_POST['title']);
	if( isset($_POST['pid']) )
	  { for( $i=1, $author=array(), $email=array(), $affiliation=array(), $emailr=array(),$cont="" ; isset($_POST['author'.$i]) ; $i++ ) 
	       {  if( $_POST['author'.$i]!="") 
	       	   { if( $i == $_POST['contact'] ) $cont=$_POST['email'.$i];	array_push($emailr,$_POST['author'.$i]." <".$_POST['email'.$i].">");
		     	 array_push($author,$_POST['author'.$i]); array_push($email,$_POST['email'.$i]); array_push($affiliation,$_POST['affiliation'.$i]);
		   	   }	
	   	   }
		$author=implode("~",$author); $email=implode("~",$email); $affiliation=implode("~",$affiliation); $emailr=implode(", ",$emailr);
	    mysql_query("update submission set id='$cont',title='$_POST[title]',author='$author',email='$email',keyword='$_POST[keywords]',abstract='$_POST[abstract]',remarks='$_POST[track]' where pid='$_POST[pid]'");
	    if( mysql_affected_rows() )
		  { $txt = "Dear Author,\n\n Thank you for updating your paper (Paper id: $_POST[pid]) for ICCESD 2018.\n\n\n\nThanking you\n---------------------\nDr. Abu Zakir Morshed\nOrgainizing Secretary, ICCESD 2018\n&\nProfessor, Department of Civil Engineering\nKhulna University of Engineering & Technology (KUET)\nKhulna 9203, Bangladesh\nEmail: iccesd2018@gmail.com\nPhone: +88041 769 471 ext. 239 (off.), +8801819 666 295 (cell)";
	        mail("$emailr","ICCESD 2018: Thank you for updating your paper",$txt,"From: ICCESD 2018 KUET <office@iccesd.com>\r\nCC: iccesd2018@gmail.com");		  
		  }	  
	  }
	else {
	$pid=mysql_fetch_array(mysql_query("select max(right(pid,3)) pid from submission")); if( isset($pid['pid']) ) $pid=$pid['pid']+5; else $pid=11; 
	for( $i=1, $author=array(), $email=array(), $affiliation=array(), $emailr=array(),$cont="" ; isset($_POST['author'.$i]) ; $i++ ) 
	   { if( $_POST['author'.$i]!="") 
	       { if( $i == $_POST['contact'] ) $cont=$_POST['email'.$i];	array_push($emailr,$_POST['author'.$i]." <".$_POST['email'.$i].">");
		     array_push($author,$_POST['author'.$i]); array_push($email,$_POST['email'.$i]); array_push($affiliation,$_POST['affiliation'.$i]); 
		   }	
	   }
	$author=implode("~",$author); $email=implode("~",$email); $affiliation=implode("~",$affiliation); $emailr=implode(", ",$emailr);
    if(!mysql_query("insert into submission values('$pid','$cont','$_POST[title]','$author','$email','$affiliation','$_POST[keywords]','$_POST[abstract]','$_POST[track]')")) echo mysql_error();
	else {
	$txt = "Dear Author,\n\nThank you for your submission in ICCESD 2018. Please use below reference for future contact with us.\n\nPaper ID: $pid\nTitle: $_POST[title]\nAuthor(s): $author\n\n\n\nThanking you\n---------------------\nDr. Abu Zakir Morshed\nOrgainizing Secretary, ICCESD 2018\n&\nProfessor, Department of Civil Engineering\nKhulna University of Engineering & Technology (KUET)\nKhulna 9203, Bangladesh\nEmail: iccesd2018@gmail.com\nPhone: +88041 769 471 ext. 239 (off.), +8801819 666 295 (cell)";
	mail("$emailr","ICCESD 2018: Thank you for your submission",$txt,"From: ICCESD 2018 KUET <office@iccesd.com\r\nCC: iccesd2018@gmail.com");
	}
	}
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title>Submission: 4th ICCESD'2018, KUET</title>
<script>
function addauthor(no)
 { document.getElementById('ath'+no).innerHTML="<table width='100%' align='left' border='0'><tr> <td align='right' width='18%'>(Author "+no+") Name</td><td width='82%'><input name='author"+no+"' type='text' size='40' /> </td> </tr> <tr><td align='right'>Email</td> <td><input name='email"+no+"' type='text' /></td> </tr> <tr> <td align='right' valign='top'>Affiliation</td> <td><input name='affiliation"+no+"' type='text' size='60' /></td> </tr><tr> <td align='right' valign='top'>Contacting Author</td> <td><input name='contact' id='contact"+no+"' value='"+no+"' type='radio' /><br /><br /></td> </tr> <tr><td colspan='2' align='right' id='ath"+(no+1)+"'><input type='button' value='Add Author' onclick='addauthor("+(no+1)+")' /></td></tr></table>"; 
 }
</script>
</head>


<body style="margin: 0px auto; padding: 0px; background:#000;">
   <div style=" margin:0 auto; width:1000px; background:#fff;">
<table border=0; width="100%" cellpadding="0" cellspacing="0">
  
  <tr><td width="17%" rowspan="2" align="right" valign="bottom"><img src="images/h4-1.jpg" width="169" height="305" /></td>
    <td width="66%" align="center" style="font-size:28px; color:#696969; line-height:35px; padding-top:20px; padding-bottom:10px;"><span style="font-size:36px; font-family:'Brush Script MT';">4th</span> <b style="font-size:42px;">I</b>nternational <b style="font-size:42px;">C</b>onference on <br />
      <b style="font-size:42px;">C</b>ivil <b style="font-size:42px;">E</b>ngineering for <b style="font-size:42px;">S</b>ustainable <b style="font-size:42px;">D</b>evelopment <?php echo $paper['pid']; ?><br /><span style="font-size:38px; font-weight:bold; color:#006400;">IC</span><span style="font-size:38px; font-weight:bold; color:#c00000;">CE</span><span style="font-size:38px; font-weight:bold; color:#006400;">SD</span><span style="font-size:38px; font-weight:bold; font-family:'Brush Script MT'; color:#c00000;"> 2018</span> </td><td width="17%" valign="center" align="center"> <img src="images/h0.png" /> </td> </tr>
    
  <tr>
    <td height="155" colspan="2" align="center" valign="bottom"> <img src="images/h4-2.jpg" width="200" height='150' />&nbsp;<img src="images/h4-3.jpg" width="200" height='150' />&nbsp;<img src="images/h4-4.jpg" width="200" height='150' />&nbsp;<img src="images/h4-5.jpg" width="200" height='150' /></td>  </tr>
	<tr>
	  <td colspan="3" align="center" valign="middle" style="font-size:24px; font-weight:bold; color:#0000CD;" valign="top" height="50">9 – 11 February 2018 &nbsp; &nbsp; <span style="color:black;">Khulna, Bangladesh</span></td>
	</tr></table>
	<td> <a href="logout.php"><button><b>Log Out</b></button></a></td>
	<tr>
	  <td height="30" colspan="3" align="center" valign="middle">
	  <fieldset style="width:95%; text-align:left;" >
	  <legend style="font-size:20px;"><b>Submission Summary <?php echo $paper['pid']; ?></b></legend>
	   <br />
	  <table border="1" style="border-collapse:collapse; padding:4px;" width="60%">
	   <tr align="center"><th>SL</th><th>Track</th><th>Amount</th></tr>
	   <?php 
	   $track=array("Structural and Earthquake Engineering","Geotechnical and Geological Engineering","Environmental Engineering","Transporatation Planning and Traffic Management","Water Resources Engineering","Construction Engineering and Management","Fire Engineering");
	   for( $i=1, $t=0, $query=mysql_query("select remarks,count(*) total from submission group by remarks order by remarks") ; $row=mysql_fetch_array($query) ; $i++ )
	      { $color=""; if($i%2) $color="#eee"; echo "<tr bgcolor='$color'><td align=center>$i</td><td>".$track[substr($row['remarks'],-1)]."</td><td align=right>$row[total] &nbsp;</td></tr>"; $t +=$row['total'];
		  }
	   echo "<tr><th colspan=2 align=center>Total</th><th align=right>$t&nbsp;</th></tr>";
	   ?>
	   </table></fieldset>	<br /><br />
	  <fieldset style="width:95%; background:#ddd; border:hidden; text-align:left;" >
	  <legend style="font-size:20px;"><b>Submission Management</b></legend>
	   <br />
	  <table border="1" style="border-collapse:collapse; padding:4px;" width="100%">
	   <tr align="center"><th>Track</th><th>Information</th></tr>
	   <?php 
	   //$track=array("Structural and Earthquake Engineering","Geotechnical and Geological Engineering","Environmental Engineering","Transporatation Planning and Traffic Management","Water Resources Engineering","Construction Engineering and Management","Fire Engineering");
	   for( $i=1, $query=mysql_query("select * from submission order by remarks,pid") ; $row=mysql_fetch_array($query) ; $i++ )
	      { $color="";
	  		if($row[accept_reject]==1){$color="green";}
	        	else if($row[accept_reject]==2)
	        	{$color="red";}
	        	else if($row[accept_reject]==3)
	        	{$color="orange";}
	        	else if($row[accept_reject]==4)
	        	{$color="violet";}
	        	else if($row[accept_reject]==5)
	        	{$color="cornflowerblue";}
	        	else if($row[accept_reject]==6)
	        	{$color="chocolate";}
	          echo "<tr bgcolor='$color'><td>".$track[substr($row['remarks'],-1)]."<br><br><form method='post'><input type='hidden' name='pid' value='$row[pid]' /><input type='hidden' name='id' value='$row[id]' /> <input type='submit' name='action' value='Delete' /> <br /><input type='submit' name='action' value='Accept' /><input type='submit' name='action' value='Reject' /><br><input type='submit' name='action' value='Allow fullpaper' /><input type='submit' name='action' value='Restrict fullpaper' /></form></td><td><b>Paper ID</b>: $row[pid]<br><b>Title:</b> $row[title]<br><b>Author(s):</b> $row[author]<br><b>Contact:</b> $row[email] ($row[id])<br><b>Affiliation:</b> $row[affiliation]<br><b>Keyword(s):</b> $row[keyword]<br><b>Abstract:</b><br>$row[abstract]</td></tr>";
		  }
	   
	   ?>
	   </table></fieldset>	  
	  </td>
    </tr>
	</table>	<br /><br />
</div>
</body>
</html>

