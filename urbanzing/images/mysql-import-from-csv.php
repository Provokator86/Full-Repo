<?php
error_reporting(E_ALL | E_STRICT);

if (isset($_POST['buttonGo']) && is_uploaded_file($_FILES['import_file']['tmp_name'])) {
	// Import Settings
	$compression = 'none';
	$format = 'csv';
	$import_type = 'table';
	$flagSingleDmlSqlRun = FALSE;
	$numColumnsInExcelFile = 24;
	
	$replacements = array(
						'\\n'	=> "\n",
						'\\t'	=> "\t",
						'\\r'	=> "\r"
					);
	$arrWeekDays = array(
						"'Monday'",
						"'Tuesday'",
						"'Wednesday'",
						"'Thursday'",
						"'Friday'",
						"'Saturday'",
						"'Sunday'"
					);

	$flagConsiderBizHours = TRUE;
	$excelColumnNumberForBizHours = (18 - 1); // With respect to the Array Concept
	$numRecordsInRelatedBizHours = count($arrWeekDays) * 2;
	$endColumnNumberForBizHours = $excelColumnNumberForBizHours + $numRecordsInRelatedBizHours;
	if ($flagConsiderBizHours) {
		$numColumnsInExcelFile += $numRecordsInRelatedBizHours;
	}

	$flagConsiderCuisine = TRUE;
	$excelColumnNumberForCuisine = (15 - 1); // With respect to the Array Concept
	$numRecordsInRelatedBizCuisine = 1;
	if ($flagConsiderCuisine) {
		$numColumnsInExcelFile += $numRecordsInRelatedBizCuisine;
	}

	// Extra Field Details
	$valStatus = '1';
	$idCreatedBy = 1;
	$timeCreation = time();
	$idRegion = 1;

	$strFileName = basename($_FILES['import_file']['name']);
	if (".".$format !== strtolower(substr($strFileName, -4))) {
		echo "File Format is wrong here.\n";
	}
	else {
		$import_handle = @fopen($_FILES['import_file']['tmp_name'], 'r');
		if ($import_handle === FALSE) {
			echo "Error in opening the file.<br/>";
		}
		else {
			$size = filesize($_FILES['import_file']['tmp_name']);
			if (empty($size)) {
				echo "File is empty.<br/>";
			}
			else {
				// Database Connection Settings
				$dbHostName = 'localhost';
				$dbUsername = 'root';
				$dbPassword = 'fd2KOdO4';
				$dbDatabaseName = 'urbanzing';

				$link = mysql_connect($dbHostName, $dbUsername, $dbPassword) or die(mysql_error());
				$conn = mysql_select_db($dbDatabaseName, $link) or die(mysql_error());
				
				$dbTableName = 'urban_business';
				$arrFieldNames = array(
										"`name`",
										"`business_category`",
										"`business_type_id`",
										"`address`",
										"`country_id`",
										"`state_id`",
										"`city_id`",
										"`zipcode`",
										"`land_mark`",
										"`phone_number`",
										"`website`",
										"`contact_person`",
										"`contact_email`",
										"`price_range_id`",
										"`other_cuisine`",
										"`hour_comment`",
										"`tags`",
										"`credit_card`",
										"`delivery`",
										"`vegetarian`",
										"`parking`",
										"`take_reservation`",
										"`air_conditioned`",
										"`serving_alcohol`",
										"`status`",
										"`cr_by`",
										"`cr_date`",
										"`region_id`"
									);

				$dbTableNameRelatedBizHours = "urban_business_hour";
				$arrFieldNamesRelatedBizHours = array(
													"`business_id`",
													"`day`",
													"`hour_from`",
													"`hour_to`",
													"`cr_by`"
												);

				$dbTableNameRelatedCuisine = "urban_business_cuisine";
				$arrFieldNamesRelatedCuisine = array(
														"`business_id`",
														"`cuisine_id`",
														"`cr_by`"
													);

				if (empty($_POST['csv_columns'])) {
					$query = "SHOW COLUMNS FROM $dbTableName";
					$sql = mysql_query($query, $link);

					while ($_tmpColumnDetails = mysql_fetch_array($sql)) {
						$arrListFields[] = $_tmpColumnDetails[0];
					}

					$strListFields = implode(", ", $arrListFields);
				}
				else {
					$strListFields = $_POST['csv_columns'];
				}

				// As of now, the use of the Array Variable "$arrFieldNames" is to be considered.
				$strListFields = implode(", ", $arrFieldNames);

				$sql_template = "INSERT INTO $dbTableName ($strListFields) VALUES ";

				$csv_terminated = strtr($_POST['csv_terminated'], $replacements);
				$csv_enclosed = strtr($_POST['csv_enclosed'],  $replacements);
				$csv_escaped = strtr($_POST['csv_escaped'], $replacements);
				$csv_new_line = strtr($_POST['csv_new_line'], $replacements);

				$flagNeglectFirstRow = FALSE;
				if (isset($_POST['csv_neglect_first_row'])) {
					$flagNeglectFirstRow = TRUE;
				}

				$fileContent = fread($import_handle, $size);
				fclose($import_handle);

				$lines = 0;
				$numAffectedRows = 0;

				$arrAllFields = array();
				$arrRequiredFields = array();
				$arrRecords = array();
				$arrRecordsBizHours = array();
				$arrRecordsCuisine = array();

				$strToReplaceWithForAllLines = "'".$csv_terminated." '";
				$strToReplaceWithForSpecialLines = "'".$csv_terminated."'";

				$strCommonAppendToRecords = ", '".$valStatus."', ".$idCreatedBy.", ".$timeCreation.", ".$idRegion;
				$strCommonAppendToRelatedTables = ", ".$idCreatedBy;
				$strCommonPrependToRelatedTables = "";

				foreach(explode($csv_new_line, $fileContent) as $line) {
					$lines++;
					if ($flagNeglectFirstRow) {
						$flagNeglectFirstRow = FALSE; // As this Flag will not be required after this condition.
						continue;
					}
					#echo '<br/>line='.$line;

					$line = trim($line, " \t");
					$line = str_replace("\r", "", $line);
					$line = str_replace("'", "\'", $line);
					$line = str_replace('"', '\"', $line);

					#$line = "'".$line;
					$line = str_replace($csv_terminated, $strToReplaceWithForAllLines, $line);
					$line = substr($line, 0, -4);
					#echo '<br/>line 2='.$line;

					if (empty($line)) {
						continue;
					}

					$arrAllFields = explode($csv_terminated, $line);
					$numLineColumns = count($arrAllFields);
					#echo '<br/>num of columns='.count($arrAllFields);

					if ($numColumnsInExcelFile != $numLineColumns) {
						echo "Wrong Number of Fields provided for Line Number #$lines.<br/>";
						continue;
					}

					// This part is fully Project-specific, so can be deleted as per Project's requirements
					for ($i = 0; $i < $numLineColumns; $i++) {
						$arrAllFields[$i] = str_replace('|', ",", $arrAllFields[$i]);

						// The values of this Column will go into another Table, so this Customization is necessary.
						if ($flagConsiderCuisine && $i == $excelColumnNumberForCuisine) {
							$arrAllFields[$i] = trim(str_replace("'", "", $arrAllFields[$i]));
						}

						if (($i < $excelColumnNumberForBizHours || $i >= $endColumnNumberForBizHours) &&
							$i != $excelColumnNumberForCuisine) {
							$arrRequiredFields[] = $arrAllFields[$i];
						}
					}

					if ($flagConsiderBizHours) {
						
					}

					$arrRecords[] = "('" . implode(",", $arrRequiredFields) . "'" . $strCommonAppendToRecords . ")";
					
					if (!$flagSingleDmlSqlRun) {
						#echo 'sdsdgsdgsdgsdg';exit;
						$_eachDmlSql = $sql_template.end($arrRecords);
						#echo '<br/>sql = '.$_eachDmlSql;
						$_eachDml = mysql_query($_eachDmlSql, $link);
						$idPrimaryKey = mysql_insert_id();
						if (!empty($idPrimaryKey)) {
							$strCommonPrependToRelatedTables = $idPrimaryKey.", ";
							$numAffectedRows++;
						}
						else {
							echo "Error in the CSV Record for Line Number #$lines.<br/>";
							continue;
						}

						unset($_eachDmlSql);
					}

					// Exclusively for Biz Hours
					if ($flagConsiderBizHours) {
						for ($i = 0, $counterWeekDay = 0; $i < $numRecordsInRelatedBizHours; $i++, $counterWeekDay++) {
							$arrRecordsBizHours[] = "(".$strCommonPrependToRelatedTables.$arrWeekDays[$counterWeekDay].", ".
													ucfirst(strtolower(trim($arrAllFields[$excelColumnNumberForBizHours + $i++]))).", ".
													strtolower(trim($arrAllFields[$excelColumnNumberForBizHours + $i])).
													$strCommonAppendToRelatedTables.")";
						}
					}

					// Exclusively for Cuisine Section
					if ($flagConsiderCuisine) {
						for ($i = 0; $i < $numRecordsInRelatedBizCuisine; $i++) {
							$strCuisineData = $arrAllFields[$excelColumnNumberForCuisine];
							$arrCuisineData = explode(",", $strCuisineData);
							
							foreach ($arrCuisineData as $_eachCuisineData) {
								$arrRecordsCuisine[] = "(".$strCommonPrependToRelatedTables.trim($_eachCuisineData).$strCommonAppendToRelatedTables.")";
							}
						}
					}

					/*echo '<br/><pre>line=';
					print_r($line);
					echo '--<br/>this record=';
					print_r($arrRecords);
					echo '--<br/>this cuisine=';
					print_r($arrRecordsCuisine);
					echo '--<br/>this biz=';
					print_r($arrRecordsBizHours);
					echo '--</pre>---';*/

					unset($arrAllFields, $arrRequiredFields);
				}

				if (empty($arrRecords)) {
					echo "No Records found to be fruitful. So Nothing to write.<br/>";
				}
				else {
					if ($flagSingleDmlSqlRun) {
						$sql_template .= implode(", ", $arrRecords);
						mysql_query($sql_template, $link);
						$numAffectedRows = mysql_affected_rows($link);
					}

					echo "$lines Rows fetched from the File and $numAffectedRows Records could be Inserted into the &ldquo;$dbTableName&rdquo; Table.<br/>";
				}

				if ($flagConsiderBizHours && !empty($arrRecordsBizHours)) {
					$sqlBizHours = "INSERT INTO $dbTableNameRelatedBizHours (".implode(", ", $arrFieldNamesRelatedBizHours).") VALUES ".implode(", ", $arrRecordsBizHours);
					mysql_query($sqlBizHours, $link);
					#echo '<br/>biz hours sql='.$sqlBizHours.'----';
				}

				if ($flagConsiderCuisine && !empty($arrRecordsCuisine)) {
					$sqlCuisine = "INSERT INTO $dbTableNameRelatedCuisine (".implode(", ", $arrFieldNamesRelatedCuisine).") VALUES ".implode(", ", $arrRecordsCuisine);
					mysql_query($sqlCuisine, $link);
					#echo '<br/>cuisine sql='.$sqlCuisine.'----';
				}

				mysql_close($link);
			}
		}
	}
}
?>

<form name="frmMysqlImport" id="frmMysqlImport" action="" method="post" enctype="multipart/form-data">
	<table width="100%" border="0" cellpadding="4" cellspacing="0">
		<tr>
			<td align="center" colspan="2"><strong>CSV File Import Logic</strong></td>
		</tr>

		<tr>
			<td width="45%" align="left">Location of the text file:</td>
			<td align="left"><input type="file" name="import_file" id="input_import_file" /></td>
		</tr>

		<tr>
			<td align="left">Fields Terminated by:</td>
			<td align="left"><input type="text" maxlength="2" size="2" name="csv_terminated" id="text_csv_terminated" value="," /></td>
		</tr>

		<tr>
			<td align="left">Fields Enclosed by:</td>
			<td align="left"><input type="text" maxlength="2" size="2" name="csv_enclosed" id="text_csv_enclosed" value="" /></td>
		</tr>

		<tr>
			<td align="left">Fields Escaped by:</td>
			<td align="left"><input type="text" maxlength="2" size="2" name="csv_escaped" id="text_csv_escaped" value="" /></td>
		</tr>

		<tr>
			<td align="left">Lines Terminated by:</td>
			<td align="left"><input type="text" size="2" name="csv_new_line" id="text_csv_new_line" value="\n" /></td>
		</tr>

		<tr>
			<td align="left">Do not consider First Row:</td>
			<td align="left"><input type="checkbox" name="csv_neglect_first_row" id="text_csv_neglect_first_row" value="1" checked /></td>
		</tr>

		<tr>
			<td align="left">Column Names:</td>
			<td align="left"><input type="text" name="csv_columns" id="text_csv_columns" value="" /></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td align="left"><input type="submit" name="buttonGo" id="buttonGo" value="Go" /></td>
		</tr>
	</table>
</form>