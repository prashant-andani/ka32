<?php
	include "DBConn.php";	
	include "footer.php";
	
	$dateVar=$_GET['bday'];
	
	if(!$dateVar)
	{
		$dateVar = date('Y-m-d');
	}
	
	

	$dbInst = new DbQuery;


	//$stmtUserCount = $dbInst->getUserCount();
	//$stmtUserGroup = $dbInst->getUserGroupDetails();	
	//$stmtUserLogInDetails= $dbInst->getUserAccessedData();
	//$stmtColorsDetails=$dbInst->getColorsDetails();
	$stmtUserSessionActive = $dbInst->getUserSessionActive($dateVar);
	$stmtUserActivity = $dbInst->getUserActivityDetails($dateVar);
	$stmtDataPublish = $dbInst->getDataPublishedMiddleware($dateVar);
	$stmtEntityDataPub = $dbInst->getDataPublished($dateVar);
	//$stmtReadOnlyUser = $dbInst->getReadOnlyUserDetails();
	//$stmtSysAdmin = $dbInst->getSystemAdminDetails();
	//$stmtPwdDate = $dbInst->getUserPassworddate();
	//$stmtUserBasket = $dbInst->getUserBasketAnalysis();
	$stmtInboundBatchJob = $dbInst->getInboundBatchJob($dateVar);
//	$stmt_hourly = $dbInst->getHourlyUserReport($dateVar);
	$stmt_nonMasterContext = $dbInst->getNonMasterContextSubjects() ;
	$stmtToolingBlank = $dbInst->getToolingBlankRecords() ;	
	$stmtDataDeletion = $dbInst->getDataDeletionReport($dateVar);
?>

	
		<form class="navbar-form pull-right">									
							<form name="myform" method="get">
								<b>Date:</b> <input type="date" name="bday">
								<input type = "submit" value="Report">
							</form>
						</form>		
				
	

    <!-- @Start Main Content -->
    <div class="container-fluid main-body" style="margin-top:50px;">
		<div> 
				<div class="row">				
					<div class="span5" id="pieChartDataPublish" style = "width:450px;height:300px;"></div>
					<div class="span5" id="LineChart" style = "width:450px;height:300px;"></div>					
					<div class="span2" style="height:300px;width:200px;overflow:auto;">
						<table class="table table-striped" title= "User session active (in mins)">
							<thead>
								<tr><th>User</th><th>Active</th></tr>
							</thead>
							<tbody>
							<?php 
								while(oci_fetch($stmtUserSessionActive)){
									$uname = oci_result($stmtUserSessionActive, 1);
									$mins = oci_result($stmtUserSessionActive, 2);
									print "<tr><td>" .$uname. "</td><td>".$mins."</td></tr>";
								}
							?>
							</tbody>
						</table>
					</div>
					
					<div class="span2" style="height:300px;width:250px;overflow:auto;">
						<table class="table table-striped" title= "Non Master Context subjects">
							<thead>
								<tr><th>Table_Name</th><th>Record_Count</th></tr>
							</thead>
							<tbody>
							<?php 
								while(oci_fetch($stmt_nonMasterContext)){
									$tab_name = oci_result($stmt_nonMasterContext, 1);
									$r_cnt = oci_result($stmt_nonMasterContext, 2);
									print "<tr><td>" .$tab_name. "</td><td>".$r_cnt."</td></tr>";
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
				<hr>
				<div class="row">				
					<div class="span5" style="height: 300px; width : 450px; overflow: auto;">
						<table class="table table-striped" title= "Inbound Batch Job Details">
							<thead>
								<tr><th>Table_Name</th><th>Batch_ID</th><th>DateTime_Processed</th><th>Err_Column</th><th>Record_Count</th></tr>
							</thead>
							<tbody>
								<?php 					
									
									while(oci_fetch($stmtInboundBatchJob)){
										$tabName = oci_result($stmtInboundBatchJob, 1);
										$batchId = oci_result($stmtInboundBatchJob, 2);
										$dateTimeProcessed = oci_result($stmtInboundBatchJob, 3);
										$errCol = oci_result($stmtInboundBatchJob, 4);
										$record_cnt = oci_result($stmtInboundBatchJob, 5);
										print "<tr><td>".$tabName."</td><td>".$batchId."</td><td>".$dateTimeProcessed."</td><td>".$errCol."</td><td>".$record_cnt."</td></tr>";
									}
									
								?>							
							</tbody>
						</table>
					</div>		
					
					<div class="span4" style="height: 300px; width : 450px; overflow: auto;">
						<table class="table table-striped" title= "User Activity Details">
							<thead>
								<tr><th>User</th><th>Entity</th><th>Action</th><th>#Records</th></tr>
							</thead>
							<tbody>
								<?php 
								
									
									while(oci_fetch($stmtUserActivity)){
										$userName = oci_result($stmtUserActivity, 1);
										$cat_name = oci_result($stmtUserActivity, 2);
										$event_type = oci_result($stmtUserActivity, 3);
										$record_cnt = oci_result($stmtUserActivity, 4);
										print "<tr><td><a href='userlevelreport.php?uname=".$userName."'>"  .$userName. "</a></td><td>".$cat_name."</td><td>".$event_type."</td><td>".$record_cnt."</td></tr>";
									}
									
								?>							
							</tbody>
						</table>
					</div>	
					
					
					<div class="span5" style="height:300px;width:450px;overflow:auto;">
						<table class="table table-striped" title= "Entity wise records published">
							<thead><tr><th>Entity</th><th>Subject</th><th>Published Time</th></tr></thead>
							<tbody>
								<?php 
									while(oci_fetch($stmtEntityDataPub)){
										$entityname = oci_result($stmtEntityDataPub, 1);
										$subject = oci_result($stmtEntityDataPub, 2);
										$pubDate = oci_result($stmtEntityDataPub, 3);
										print "<tr><td>" .$entityname. "</td><td>".$subject."</td><td>".$pubDate."</td></tr>";
									} 
								
								?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">				
					<div class="span5" style="height:200px;width:200px;overflow:auto;">
						<table class="table table-striped" title= "Tooling Records with Blank NAME UI">
							<thead><tr><th>Tooling Record</th></tr></thead>
							<tbody>
								<?php 
									while(oci_fetch($stmtToolingBlank)){
										$toolingRecord = oci_result($stmtToolingBlank, 1);
										print "<tr><td>" .$toolingRecord. "</td></tr>";
									} 
								
								?>
							</tbody>
						</table>
					</div>
					<div class="span5" style="height:300px;width:550px;overflow:auto;">
						<table class="table table-striped" title= "Data Deletion Report">
							<thead><tr><th>Category Name</th><th>Subject Name</th><th>Purged Event</th><th>Purged By</th></tr></thead>
							<tbody>
								<?php 
									while(oci_fetch($stmtDataDeletion)){
										$categoryName = oci_result($stmtDataDeletion, 1);
										$subjectName = oci_result($stmtDataDeletion, 2);
										$purgeEvent = oci_result($stmtDataDeletion, 3);
										$purgedBy = oci_result($stmtDataDeletion, 4);
										print "<tr>
													<td>" .$categoryName. "</td>
													<td>" .$subjectName. "</td>
													<td>" .$purgeEvent. "</td>
													<td>" .$purgedBy. "</td>
													</tr>";
									} 
								
								?>
							</tbody>
						</table>
					</div>
				</div>	
				
					
					
						

							
				</div>
				<hr>
			</div>
		
	</div>



<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/highcharts.js"></script>
<script type="text/javascript">
$(function () {
				var chart;
				$(document).ready(function() {
					chart = new Highcharts.Chart({
						chart: {
							renderTo: 'pieChartDataPublish',
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false
						},
						title: {
							text: 'Data Publishing to Middleware'
						},
						tooltip: {
							pointFormat: '<b>{point.percentage}%</b>',
							percentageDecimals: 1
						},
						plotOptions: {
							pie: {
								allowPointSelect: true,
								cursor: 'pointer',
								dataLabels: {
									enabled: true,
									color: '#000000',
									connectorColor: '#000000',
									formatter: function() {
									var numRound = parseFloat(this.percentage);
										return '<b>'+ this.point.name +'</b> ';
									}
								}
							}
						}, 
						
						
						series: [{
							type: 'pie',
							name: '',
							data: [ 							
							<?php
								while(oci_fetch($stmtDataPublish)){
									$name = oci_result($stmtDataPublish, 1);
									$val = oci_result($stmtDataPublish, 2);
									if (@name == '') {
										echo "No Data Published";
									}
									else {
									echo "['" . $name . "',".$val. "],"; 
									}
								} 
							?>
															
							]
						}]
					});
				});
				
			});
			</script>


<script src="js/highcharts.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
		
			$(function () {
				var chart;
				$(document).ready(function() {
					chart = new Highcharts.Chart({
						chart: {
							renderTo: 'LineChart',
							type: 'line',
							marginRight: 10,
							marginBottom: 30
						},
						title: {
							text: 'Hourly User Access Count',
							x: 10 //center
						},
						subtitle: {
							text: '',
							x: -20
						},
						xAxis: {
							categories: [
							
							<?php
							
							$stmt_hourly = $dbInst->getHourlyUserReport($dateVar);		
							while(oci_fetch($stmt_hourly)){
									$val_hour = oci_result($stmt_hourly, 1);
									echo "'".$val_hour . "',"; 
							} 
							
							?>
							]
							
						},
						yAxis: {
							title: {
								text: 'User Count'
							},
							plotLines: [{
								value: 0,
								width: 1,
								color: '#808080'
							}]
						},
						tooltip: {
							formatter: function() {
									return '<b>'+ this.series.name +'</b><br/>'+
									this.x +': '+ this.y ;
							}
						},
						legend: {
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'top',
							x: 0,
							y: 20,
							borderWidth: 1
						},
						series: [
						{
						name: 'Users',
							data: [
							<?php
							
								$stmt_hourly = $dbInst->getHourlyUserReport($dateVar);
							while(oci_fetch($stmt_hourly)){
									$val_count = oci_result($stmt_hourly, 2);
									echo $val_count . ","; 
							} 
										
							?>
							]
							
							}
							]
					});
				});
				
			});
</script>

			
</body>
</html>
