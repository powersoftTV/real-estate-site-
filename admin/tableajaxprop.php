﻿<?

require_once("baza.php");
$cat=$_GET[cat];
$cat_id=$cat."_id";
$cat_eng=$cat."_eng";
if($_POST[id]){
	$id=$_POST[id];
	$resp=array();
	if($_POST[oper]==del){		
		$result=mysql_query("SELECT $cat_id FROM main");
		
		while($res = mysql_fetch_assoc($result)){
			
			$selected_check = explode(',', $res[$cat_id]);
			$fl=in_array($id, $selected_check);
			if($fl){
				$resp[answerType]="";
				$resp[hidden]="Невозможно удалить. Запись используется";
				echo json_encode($resp);
				exit;
			}
		};
		
		if(!$fl) {
			$ress=mysql_query ("DELETE FROM `$cat` WHERE `id`='$id' ") or die(mysql_error()); 
			if($ress){
				$resp[answerType]="OK";
				$resp[hidden]="";
				}
			else {
				$resp[answerType]="";
				$resp[hidden]="Невозможно удалить.";
				}
			
			
		}
		else {
			$resp[answerType]="";
			$resp[hidden]="Невозможно удалить. Запись используется";
		}
		
	}
	if($_POST[$cat]){
		$input_text=$_POST[$cat];
		$input_text	= trim($input_text);
		$input_text = htmlspecialchars($input_text);
		$input_text = mysql_escape_string($input_text);
		if(mb_strwidth($input_text, 'UTF-8')<60){
			if($input_text=="" ||$input_text==" ") {
				$resp[answerType]="";
				$resp[hidden]="Используются недопустимые символы или пустая строка";
				}
			else {
				$result=mysql_query("SELECT * FROM `$cat` WHERE `$cat`  LIKE '$input_text'");
				$total=mysql_num_rows($result);
				$row=mysql_fetch_array($result);
				if($total && $row[id]!= $id) {
					$resp[answerType]="";
					$resp[hidden]="Запись существует.";
				}
				else {
					$rees=mysql_query ("UPDATE `$cat` SET `$cat`= '$input_text'   WHERE `id`='$id'") or die(mysql_error());
					if($rees){
						$resp[answerType]="OK";
						$resp[hidden]="";
						}
					else {
						$resp[answerType]="";
						$resp[hidden]="Не удалось записать.";
						}
					}
	 			
				}
			}
		else {
			$resp[answerType]="";
			$resp[hidden]="Слишком много символов.";
		}
	}
	if($_POST[$cat_eng]){
		$input_text_eng=$_POST[$cat_eng];
		$input_text_eng	= trim($input_text_eng);
		$input_text_eng = htmlspecialchars($input_text_eng);
		$input_text_eng = mysql_escape_string($input_text_eng);
		if(mb_strwidth($input_text_eng, 'UTF-8')<60){
			if($input_text_eng=="" ||$input_text_eng==" ") {
				$resp[answerType]="";
				$resp[hidden]="Используются недопустимые символы или пустая строка. ";
				}
			else {
				$result_eng=mysql_query("SELECT * FROM `$cat` WHERE `$cat_eng`  LIKE '$input_text_eng'");
				$total_eng=mysql_num_rows($result_eng);
				$row_eng=mysql_fetch_array($result_eng);
				if($total_eng && $row_eng[id]!= $id) {
					$resp[answerType]="";
					$resp[hidden]="Запись  существует.";
				}
				else {
					$rees=mysql_query ("UPDATE `$cat` SET `$cat_eng`= '$input_text_eng'   WHERE `id`='$id'") or die(mysql_error());
					if($rees){
						$resp[answerType]="OK";
						$resp[hidden]="";
						}
					else {
						$resp[answerType]="";
						$resp[hidden]="Не удалось записать.";
						}
					}
	 			
				}
			}
		else {
			$resp[answerType]="";
			$resp[hidden]="Слишком много символов.";
		}
	}
	
 echo json_encode($resp);		
}
if($_POST[oper]==add){
	$resp=array();
	if($_POST[$cat]){
		$input_text=$_POST[$cat];
		$input_text	= trim($input_text);
		$input_text = htmlspecialchars($input_text);
		$input_text = mysql_escape_string($input_text);
		if(mb_strwidth($input_text, 'UTF-8')<60){
			if($input_text=="" ||$input_text==" ") {
				$resp[answerType]="";
				$resp[hidden]="Используются недопустимые символы или пустая строка";
				$resp[id]="";
				}
			else {
				$result=mysql_query("SELECT * FROM `$cat` WHERE `$cat`  LIKE '$input_text'");
				$total=mysql_num_rows($result);
				$row=mysql_fetch_array($result);
				if($total) {
					$resp[answerType]="";
					$resp[hidden]="Запись существует.";
					$resp[id]="";
				}
				else {
					$rees=mysql_query ("INSERT INTO $cat($cat) VALUES('$input_text')") or die(mysql_error());
					$id=mysql_insert_id();
					if($rees){
						$resp[answerType]="OK";
						$resp[hidden]="";
						$resp[id]=$id;
						}
					else {
						$resp[answerType]="";
						$resp[hidden]="Не удалось записать.";
						$resp[id]="";
						}
					}
	 			
				}
			}
		else {
			$resp[answerType]="";
			$resp[hidden]="Слишком много символов.";
			$resp[id]="";
		}
	}
 echo json_encode($resp);	
	
}

?>
