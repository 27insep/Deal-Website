<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Convert_date {
  	public function __construct()
   	{
      	// Your own constructor code
    }
	public function get_th_month($month)
	{
		switch($month)
		{
			case 1:
				return "มกราคม";
			break;
			case 2:
				return "กุมภาพันธ์";
			break;
			case 3:
				return "มีนาคม";
			break;
			case 4:
				return "เมษายน";
			break;
			case 5:
				return "พฤษภาคม";
			break;
			case 6:
				return "มิถุนายน";
			break;
			case 7:
				return "กรกฎาคม";
			break;
			case 8:
				return "สิงหาคม";
			break;
			case 9:
				return "กันยายน";
			break;
			case 10:
				return "ตุลาคม";
			break;
			case 11:
				return "พฤศจิกายน";
			break;
			case 12:
				return "ธันวาคม";
			break;
		}
	}
	public function show_thai_date($date,$format="")
	{
		$date	=	substr($date,0,10);
		$set_date	=	explode("-",$date);
		$day		=	(int)$set_date[2];
		$mon	=	$set_date[1];
		$year	=	$set_date[0]+543;		
		
		if(empty($day)||empty($mon)||empty($year))
		{
			return "";
		}
		
		switch($format)
		{
			case 1:
				return $day."/".$mon."/".$year;
			break;
			case 2:
				return $day."-".$mon."-".$year;
			break;
			default:
				return $day." ".$this->get_th_month($mon)." ".$year;	
		}
	}
}
?>