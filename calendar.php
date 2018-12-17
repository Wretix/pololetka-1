<?php
	date_default_timezone_set('Europe/Prague');

	$week = date("W");
	$year = (isset($_GET['year']))?$_GET['year']:date("Y");
	$week = (isset($_GET['week']))?$_GET['week']:date('W');
		if($week>53){
			$year+= 1;
			$week=1;
		}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CALENDAR</title>
		<link rel="stylesheet" type="text/css" href="style/calendar.css">
	</head>
	<body>
		<img id="sit" src="images/backround.png">
		<div id="arrayWeek">
			<p id="lastWeek"><a href="<?php echo $_SERVER['PHP_SELF'].'?week='.($week-1).'&year='.$year; ?>"><< Minulý týden</a></p>
			<p id="nextWeek"><a href="<?php echo $_SERVER['PHP_SELF'].'?week='.($week+1).'&year='.$year; ?>">Příští týden >></a></p>
		</div>
			<table id="dayTable">
				<div id="dayBackround">
					<tr>
						<?php
							for($day=1; $day<=7; $day++) {
								$d = strtotime($year."W".$week.$day);                           
								echo "<tr><td id='singleDay'>".date('l',$d)."<br>";
								echo date('d'.".". 'F',$d)."</td></tr>";
							}
						?>
					</tr>
				</div>
			</table>
			<table id="taskTable">
					<tr>
						<td>
							<p class="addTask"><a href="">Zadat úkol</a></p>
							<p class="Task">Aktuální úkol:</p>
							<p class="editTask"><a href="">Upravit</p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="addTask"><a href="">Zadat úkol</a></p>
							<p class="Task">Aktuální úkol:</p>
							<p class="editTask"><a href="">Upravit</p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="addTask"><a href="">Zadat úkol</a></p>
							<p class="Task">Aktuální úkol:</p>
							<p class="editTask"><a href="">Upravit</p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="addTask"><a href="">Zadat úkol</a></p>
							<p class="Task">Aktuální úkol:</p>
							<p class="editTask"><a href="">Upravit</p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="addTask"><a href="">Zadat úkol</a></p>
							<p class="Task">Aktuální úkol:</p>
							<p class="editTask"><a href="">Upravit</p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="addTask"><a href="">Zadat úkol</a></p>
							<p class="Task">Aktuální úkol:</p>
							<p class="editTask"><a href="">Upravit</p>
						</td>
					</tr>
					<tr>
						<td>
							<p class="addTask"><a href="">Zadat úkol</a></p>
							<p class="Task">Aktuální úkol:</p>
							<p class="editTask"><a href="">Upravit</p>
						</td>
					</tr>
				</table>
			</div>
	</body>
</html>
