<?php 
	include "footer.php";
	include "DBConn.php";	
	
	$dbInst = new DbQuery;
	$vol= $dbInst->getRecordCount();
	$dbsize = $dbInst->getSchemaSize();
	$stmtUserLogInDetails2 = $dbInst->getUserLogInDetails2();
	$stmtActiveYes = $dbInst->getActiveRecordCount();
	$stmtActiveNo = $dbInst->getInActiveRecordCount();
	$stmtMonthName = $dbInst->getAvgRecordsAffectedMonthName();
	$stmtCreate = $dbInst->getCreateQry();
	$stmtAmend = $dbInst->getAmendQry();
	$stmtDelete = $dbInst->getDeleteQry();
	$stmtDataflowMonthName = $dbInst->getDataFlowMonthName();
	$stmtInbound = $dbInst->getInbound();
	$stmtDataPub = $dbInst->getOutbound();
	$stmtConsumerUIAccessCount = $dbInst->getConsumerUIAccess();
			
		while(oci_fetch($stmtActiveYes)){
			$activeYes = oci_result($stmtActiveYes, 1);
		} 
			
		while(oci_fetch($stmtActiveNo)){
			$activeNo = oci_result($stmtActiveNo, 1);
		} 
			
		echo $activeYes ;
		echo $activeNo ;
?>

<html>
<body>	
		
	<div class="container-fluid main-body" style="margin-top:50px;">
		<div class="row">		
				<div class="span3" id="columnChart" style = "width: 450px; height: 300px; "></div>				
				<div class="span3" id="LineChart" style = "width: 450px; height: 300px; "></div>
				<div class="span3" id="DataPubChart" style = "width: 450px; height: 300px; "></div>
			<hr>				
				
		</div>
		<hr>
		<div class="row">
			<div class="span3" id="ActiveIndicatorPieChart" style = "width:350px; height:300px; "></div>	</hr>			
				<div class="span3" style="height:300px;width:250px;overflow:auto;">
					<table class="table table-striped" title = "Top 10 DSS most subscribed for KRDM entities">
						<thead>
							<tr><th>System Name</th><th>No.of Entities</th></tr>
						</thead>
						<tbody>
							<tr><td>FLS</td><td>111</td></tr>
							<tr><td>MDU Japan</td><td>106</td></tr>
							<tr><td>Korea</td><td>103</td></tr>
							<tr><td>SPM</td><td>94</td></tr>
							<tr><td>adiRace</td><td>75</td></tr>
							<tr><td>SAP Hana</td><td>74</td></tr>
							<tr><td>BI</td><td>73</td></tr>
							<tr><td>Cataligent</td><td>60</td></tr>
							<tr><td>NAC</td><td>52</td></tr>
							<tr><td>Flex PLM</td><td>48</td></tr>
							</tbody>
					</table>
				</div>
				
				<div class="span3" style="height:300px;width:250px;overflow:auto;">
					<table class="table table-striped" title = "Consumer UI Access - session count for Generic User">
						<thead>
							<tr><th>Accessed Date</th><th>No.of Sessions</th></tr>
						</thead>
						<tbody>
							<?php 
								while(oci_fetch($stmtConsumerUIAccessCount)){
									$accessed_date = oci_result($stmtConsumerUIAccessCount, 1);
									$session_count = oci_result($stmtConsumerUIAccessCount, 2);
									echo "<tr>
											  <td>".$accessed_date."</td><td>".$session_count."</td>
										  </tr>"; 
								} 
							?>
						</tbody>
					</table>
				</div>
				
				<div class="span3">
					<table>
						<tr><td><h4>Volume : </h4><td><?php echo "<b><td>".$vol. " records</b></td>" ; ?></tr>
						<tr><td><h4>DB Size : </h4><td><?php echo "<b><td>".$dbsize. " MB </b></td>" ; ?></tr>
					</table>	
				</div>				
								
			</div>
	</div>
	
	</body>
	</html>
	
	
<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/highcharts.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">

$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'columnChart',
                type: 'column',
                margin: [ 50, 50, 100, 80]
            },
            title: {
                text: 'Monthly Unique User Count'
            },
            xAxis: {
                categories: [
				
				
				<?php
								while(oci_fetch($stmtUserLogInDetails2)){
									$name = oci_result($stmtUserLogInDetails2, 1);
									echo "'" . $name . "',"; 
								} 
							?> 
                   
                ],
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'No. of Users'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                formatter: function() {
                    return 'ActiveUsers in<b>'+ this.x +'</b>'+ ':'+ Highcharts.numberFormat(this.y,0) + '';
                }
            },
            series: [{
                name: 'Population',
                data: [
				
				
				<?php
					
	$stmtUserLogInDetails2 = $dbInst->getUserLogInDetails2();				
								while(oci_fetch($stmtUserLogInDetails2)){
									$val = oci_result($stmtUserLogInDetails2, 3);
									echo $val . ","; 
								} 
							?> 
				
				],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    x: 4,
                    y: 10,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });
    });
    
});
</script>
	
	
	
<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/highcharts.js"></script>
<script type="text/javascript">
$(function () {
				var chart;
				$(document).ready(function() {
					chart = new Highcharts.Chart({
						chart: {
							renderTo: 'ActiveIndicatorPieChart',
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false
						},
						title: {
							text: 'Active Indicator : Data Distribution'
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
							name: 'sjsjshj',
							data: [
							<?php
								// ['Yes', 310713], ['No', 10514],
								echo "['Yes',".$activeYes."], ['No',".$activeNo."]"; 
							?>
															
							]
						}]
					});
				});
				
			});
			</script>
<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/jquery.min.js"></script>
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
							text: 'Monthly Avg. Records affected',
							x: 10 //center
						},
						subtitle: {
							text: '',
							x: -20
						},
						xAxis: {
							categories: [
							
							<?php
							
		
							while(oci_fetch($stmtMonthName)){
									$val = oci_result($stmtMonthName, 1);
									echo "'".$val . "',"; 
							} 
							
							?>
							]
							
						},
						yAxis: {
							title: {
								text: 'Record Count'
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
						name: 'Create',
							data: [
							<?php
							
		
							while(oci_fetch($stmtCreate)){
									$valCreate = oci_result($stmtCreate, 2);
									echo $valCreate . ","; 
							} 
													
							?>
							]
							
							},							
							{
							name: 'Amend',
							data: [
							
							<?php
							
					
							
							while(oci_fetch($stmtAmend)){
									$valAmend = oci_result($stmtAmend, 2);
									echo $valAmend . ","; 
							} 
													
							?>
							]
							}, 
							{
							name: 'Delete',
							data: [
							<?php
							
							
		
							while(oci_fetch($stmtDelete)){
									$valDelete = oci_result($stmtDelete, 2);
									echo $valDelete . ","; 
							} 
													
							?>
							]
							
							}
							]
					});
				});
				
			});
</script>




<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/highcharts.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'DataPubChart',
                type: 'column'
            },
            title: {
                text: 'Monthly Inbound/Outbound Vol.'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [<?php
							
		
							while(oci_fetch($stmtDataflowMonthName)){
									$valMonthName = oci_result($stmtDataflowMonthName, 1);
									echo "'".$valMonthName . "',"; 
							} 
							
							?>
							]
                    
                
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Record Count'
                }
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 245,
                y: 30,
                floating: true,
                shadow: true
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.x +': '+ this.y;
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
                series: [{
                name: 'Inbound',
                data: [<?php
							
							
		
							while(oci_fetch($stmtInbound)){
									$valDateCreate = oci_result($stmtInbound, 2);
									echo $valDateCreate . ","; 
							} 
													
							?>
							]
				
						
				
				
    
            }, {
                name: 'Outbound',
                data: [<?php
							
							
		
							while(oci_fetch($stmtDataPub)){
									$valDataPub = oci_result($stmtDataPub, 2);
									echo $valDataPub . ","; 
							} 
													
							?>]
    

					
							
            }]
        });
    });
    
});
		</script>
	
	<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/highcharts.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">

<!-- Delta Sizes upload -->
					
			$(function () {
				var chart;
				$(document).ready(function() {
				
					var colors = Highcharts.getOptions().colors,
						categories = ['Dec-12', 'Jan-13', 'Feb-13', 'Mar-13', 'Apr-13'],
						name = 'Month wise uploads',
						data = [{
								y: 794,
								color: colors[0],
								drilldown: {
									name: 'Dec 2012',
									categories: ['04', '05', '07', '12', '13', '17', '19','20'],
									data: [594, 93, 14, 6, 49, 22, 13, 3],
									color: colors[0]
								}
							}, {
								y: 173,
								color: colors[1],
								drilldown: {
									name: 'Jan 2013',
									categories: ['04', '07', '09', '10', '15','17'],
									data: [15, 1,6,47,39,65],
									color: colors[1]
									
										
								}
							}, {
								y: 925,
								color: colors[2],
								drilldown: {
									name: 'Feb 2013',
									categories: ['08', '11', '12', '13', '25', '27', '28'],
									data: [38, 167, 186, 6, 1, 1, 526],
									color: colors[2]
								}
								
									
							}, {
								y: 183,
								color: colors[3],
								drilldown: {
									name: 'Mar 2013',
									categories: ['13', '15', '20', '21', '25', '26', '28'],
									data: [1, 5, 15, 3, 1, 157, 1],
									color: colors[3]
								}
									

							}, {
								y: 350,
								color: colors[4],
								drilldown: {
									name: 'Apr 2013',
									categories: ['02', '03', '11', '15', '16', '17', '18', '19', '22','23', '24', '25', '26'],
									data: [ 2, 32, 1,71, 2, 41, 21, 24, 35, 22, 95, 1, 3],
									color: colors[4]
								}
							}];
				
					function setChart(name, categories, data, color) {
						chart.xAxis[0].setCategories(categories, false);
						chart.series[0].remove(false);
						chart.addSeries({
							name: name,
							data: data,
							color: color || 'white'
						}, false);
						chart.redraw();
					}
				
					chart = new Highcharts.Chart({
						chart: {
							renderTo: 'sizechart',
							type: 'column'
						},
						title: {
							text: 'Size Fallback - Delta Upload'
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							categories: categories
						},
						yAxis: {
							title: {
								text: 'Total records loaded'
							}
						},
						plotOptions: {
							column: {
								cursor: 'pointer',
								point: {
									events: {
										click: function() {
											var drilldown = this.drilldown;
											if (drilldown) { // drill down
												setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
											} else { // restore
												setChart(name, categories, data);
											}
										}
									}
								},
								dataLabels: {
									enabled: true,
									color: colors[0],
									style: {
										fontWeight: 'bold'
									},
									formatter: function() {
										return this.y;
									}
								}
							}
						},
						tooltip: {
							formatter: function() {
								var point = this.point,
									s = this.x +':<b>'+ this.y +' records loaded</b><br/>';
								if (point.drilldown) {
									s += 'Click to view date wise';
								} else {
									s += 'Click to view month wise';
								}
								return s;
							}
						},
						series: [{
							name: name,
							data: data,
							color: 'white'
						}],
						exporting: {
							enabled: false
						}
					});
				});
				
			});
			

</script>

</script>
