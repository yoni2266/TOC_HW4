<html>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
$url = $_POST['url']; 
$data = json_decode(file_get_contents($url), true);
//$road = '中正區汀州路';

$category_road = array();
$category_month = array();
$road_month = array();

$count_data = 0;
$count_road = 0;
$count_month = 0;

$road_id = array();
$month_largest = 0;

$price_H = 0;
$price_L = 0;

$i = 0;

foreach ($data as $set)
{
	if($count_data == 0)
	{
		$tem = strstr($set['土地區段位置或建物區門牌'], '路', true);
		if($tem){
		//$category_road[$count_road] = $set['土地區段位置或建物區門牌'];
		$category_road[$count_road] = strstr($set['土地區段位置或建物區門牌'], '路', true);
		$count_road++;
		}
	}
	else if ($count_data != 0)
	{
		$tem = strstr($set['土地區段位置或建物區門牌'], '路', true);
		if($tem){
		while($i < $count_road)
		{
			if(strcmp(strstr($set['土地區段位置或建物區門牌'], '路', true), $category_road[$i]) == 0)
				break;
			else if($i == $count_road-1){
				//$category_road[$count_road] = $set['土地區段位置或建物區門牌'];
				$category_road[$count_road] = strstr($set['土地區段位置或建物區門牌'], '路', true);
				$count_road++;
				break;
			}
			else
				;
			$i++;
		}
		$i = 0;
		}
	}
	else;
	
	$tem = strstr($set['土地區段位置或建物區門牌'], '路', true);
	if($tem)
		$count_data++;
}
$i=0;

//echo $price_H . "	" . $price_L . "<br />";
/*while($i < $count_road)
{
	echo "[".$i."]" . $category_road[$i] . "<br />";
	$i++;
}*/

$count_data = 0;
$count_month = 0;

for($j=0; $j<$count_road; $j++)
{
	foreach ($data as $set2)
	{
		if(strcmp($category_road[$j], strstr($set2['土地區段位置或建物區門牌'], '路', true)) == 0)
		{
			//echo $category_road[$j] . "<br />";
			if($count_month == 0)
			{
				$category_month[$count_month] = $set2['交易年月'];
				$count_month++;
			}
			else if ($count_data != 0)
			{
				while($i < $count_month)
				{
					if($set2['交易年月'] == $category_month[$i])
						break;
					else if($i == $count_month-1){
						//echo $category_month[$count_month-1] . "<br />";
						$category_month[$count_month] = $set2['交易年月'];
						$count_month++;
						break;
					}
					else
						;
					$i++;
				}
				$i = 0;
			}
			else;
		}
		else;
	
		$count_data++;
	}
	$road_month[$j] = $count_month;
	$count_month = 0;
	$i=0;
	
	//echo $j . "	" . $category_road[$j] . "	" . $road_month[$j] . "<br />";
	
	//$count_same = 1;
	if($road_month[$j] > $month_largest){
		$count_same = 1;
		$month_largest = $road_month[$j];
		$road_id[$count_same-1] = $j;
		//echo "change id!" . "<br />";
	}
	else if($road_month[$j] == $month_largest){
		$count_same++;
		$road_id[$count_same-1] = $j;
	}
	else;
}

$tem2 = array();
for($i=0; $i<$count_same; $i++)
{
	$tem2[$i] = $category_road[$road_id[$i]];
	$price_H = 0;
	$price_L = 0;
	//$tem2 = $category_road[$road_id];
	foreach ($data as $set3)
	{
		if(strncmp($set3['土地區段位置或建物區門牌'], $tem2[$i], strlen($tem2[$i])) == 0)
		{
			if($set3['總價元'] > $price_H)
				$price_H = $set3['總價元'];
			else;
		
			if($price_L == 0)
				$price_L = $set3['總價元'];
			else if($set3['總價元'] < $price_L)
				$price_L = $set3['總價元'];
			else;
		
			$road_spe = $set3['土地區段位置或建物區門牌'];
		}
		else;
	}
	
	echo $road_spe . ",	最高成交價: ". $price_H . ",	最低成交價: " . $price_L . "<br />";
}


		
?>
</body>
</html>
