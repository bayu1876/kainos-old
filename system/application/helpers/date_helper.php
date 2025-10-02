<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of date_helper
 *
 * @author F1
 */
function tanggal_mysql_to_php($tgl) {
    //put your code here
    $tahun = substr($tgl,0,4);
    $bulan = substr($tgl,5,2);
    $tanggal = substr($tgl,8,2);
    return $tanggal.'-'.$bulan.'-'.$tahun;
}

function tanggal_php_to_mysql($tgl) {
    //put your code here
    $tahun = substr($tgl,6,4);
    $bulan = substr($tgl,3,2);
    $tanggal = substr($tgl,0,2);
    return $tahun.'-'.$bulan.'-'.$tanggal;
}

function format_waktu($tgl) {
    $array=explode("-",$tgl);
    $tahun=$array[0];
    $bln=$array[1];
    switch($bln) {
        case "01":
            $bulan="January";
            break;
        case "02":
            $bulan="February";
            break;
        case "03":
            $bulan="March";
            break;
        case "04":
            $bulan="April";
            break;
        case "05":
            $bulan="May";
            break;
        case "06":
            $bulan="June";
            break;
        case "07":
            $bulan="July";
            break;
        case "08":
            $bulan="August";
            break;
        case "09":
            $bulan="September";
            break;
        case "10":
            $bulan="October";
            break;
        case "11":
            $bulan="November";
            break;
        case "12":
            $bulan="December";
            break;
    }
    $tgl1=$array[2];
    $tgl2=explode(" ",$tgl1);
    $tanggal=$tgl2[0];
    $result=$tanggal." ".$bulan." ".$tahun."";
    return $result;
}#end function format_waktu

function format_waktu2($tgl) {
    $array=explode("-",$tgl);
    $tahun=$array[0];
    $bln=$array[1];
    switch($bln) {
        case "01":
            $bulan="Jan";
            break;
        case "02":
            $bulan="Feb";
            break;
        case "03":
            $bulan="Mar";
            break;
        case "04":
            $bulan="Apr";
            break;
        case "05":
            $bulan="May";
            break;
        case "06":
            $bulan="Jun";
            break;
        case "07":
            $bulan="Jul";
            break;
        case "08":
            $bulan="Aug";
            break;
        case "09":
            $bulan="Sep";
            break;
        case "10":
            $bulan="Oct";
            break;
        case "11":
            $bulan="Nov";
            break;
        case "12":
            $bulan="Dec";
            break;
        //modified
        default:
            $bulan ="00";
            break;
        //end modified
    }
    $tgl1=$array[2];
    $tgl2=explode(" ",$tgl1);
    $tanggal=$tgl2[0];
    if($bulan == "00") {
        $result = "00-00-0000";
    }else {
        $result = $tanggal." ".$bulan." ".$tahun."";
    }
    return $result;
}#end function format_waktu2

function format_waktu3($tgl) {
    $array=explode("-",$tgl);
    $tahun=$array[0];
    $bln=$array[1];
    switch($bln) {
        case "01":
            $bulan="Jan";
            break;
        case "02":
            $bulan="Feb";
            break;
        case "03":
            $bulan="Mar";
            break;
        case "04":
            $bulan="Apr";
            break;
        case "05":
            $bulan="May";
            break;
        case "06":
            $bulan="Jun";
            break;
        case "07":
            $bulan="Jul";
            break;
        case "08":
            $bulan="Aug";
            break;
        case "09":
            $bulan="Sep";
            break;
        case "10":
            $bulan="Oct";
            break;
        case "11":
            $bulan="Nov";
            break;
        case "12":
            $bulan="Dec";
            break;
    }
    $tgl1=$array[2];
    $tgl2=explode(" ",$tgl1);
    $tanggal=$tgl2[0];
    $result=$bulan;
    return $result;
}#end function format_waktu2


function format_waktu4($tgl) {
    $array=explode("-",$tgl);
    $tahun=$array[0];
    $bln=$array[1];
    switch($bln) {
        case "01":
            $bulan="Jan";
            break;
        case "02":
            $bulan="Feb";
            break;
        case "03":
            $bulan="Mar";
            break;
        case "04":
            $bulan="Apr";
            break;
        case "05":
            $bulan="May";
            break;
        case "06":
            $bulan="Jun";
            break;
        case "07":
            $bulan="Jul";
            break;
        case "08":
            $bulan="Aug";
            break;
        case "09":
            $bulan="Sep";
            break;
        case "10":
            $bulan="Oct";
            break;
        case "11":
            $bulan="Nov";
            break;
        case "12":
            $bulan="Dec";
            break;
        //modified
        default:
            $bulan ="00";
            break;
        //end modified
    }
    $tgl1=$array[2];
    $tgl2=explode(" ",$tgl1);
    $tanggal=$tgl2[0];
    if($bulan == "00") {
        $result= "00-00-0000";
    }else {
        $result=$tanggal." ".$bulan."'".substr($tahun, 2,2)."";
    }

    return $result;
}#end function format_waktu4


function unix_to_human($time = '', $seconds = FALSE, $fmt = 'us') {
    $r  = date('Y', $time).'-'.date('m', $time).'-'.date('d', $time).' ';

    if ($fmt == 'us') {
        $r .= date('h', $time).':'.date('i', $time);
    }
    else {
        $r .= date('H', $time).':'.date('i', $time);
    }

    if ($seconds) {
        $r .= ':'.date('s', $time);
    }

    if ($fmt == 'us') {
        $r .= ' '.date('A', $time);
    }

    return $r;
}


function now() {
    $CI =& get_instance();

    if (strtolower($CI->config->item('time_reference')) == 'gmt') {
        $now = time();
        $system_time = mktime(gmdate("H", $now), gmdate("i", $now), gmdate("s", $now), gmdate("m", $now), gmdate("d", $now), gmdate("Y", $now));

        if (strlen($system_time) < 10) {
            $system_time = time();
            log_message('error', 'The Date class could not set a proper GMT timestamp so the local time() value was used.');
        }

        return $system_time;
    }
    else {
        return time();
    }
}


function dateDiff($startDate, $endDate) {
    // Parse dates for conversion
    $startArry = date_parse($startDate);
    $endArry = date_parse($endDate);

    // Convert dates to Julian Days
    $start_date = gregoriantojd($startArry["month"], $startArry["day"], $startArry["year"]);
    $end_date = gregoriantojd($endArry["month"], $endArry["day"], $endArry["year"]);

    // Return difference
    return round(($end_date - $start_date), 0);
}


function month_to_monthname($number)
{
    $monthname = '';
    switch ($number){
        case 1 :
            $monthname = 'Jan';
            break;
        case 2 :
            $monthname = 'Feb';
            break;
        case 3 :
            $monthname = 'Mar';
            break;
        case 4 :
            $monthname = 'Apr';
            break;
        case 5 :
            $monthname = 'May';
            break;
        case 6 :
            $monthname = 'Jun';
            break;
        case 7 :
            $monthname = 'Jul';
            break;
        case 8 :
            $monthname = 'Aug';
            break;
        case 9 :
            $monthname = 'Sep';
            break;
        case 10 :
            $monthname = 'Oct';
            break;
        case 11 :
            $monthname = 'Nov';
            break;
        case 12 :
            $monthname = 'Dec';
            break;
        default :
            $monthname = '-';
            break;
    }

    return $monthname;
}

//+iw add campaign
 function date_mysql_to_php($tgl) {
    //put your code here
    $tahun = substr($tgl,0,4);
    $bulan = substr($tgl,5,2);
    $tanggal = substr($tgl,8,2);
    return $tanggal.'-'.$bulan.'-'.$tahun;
}

function date_php_to_mysql($tgl) {
    //put your code here
    $tahun = substr($tgl,6,4);
    $bulan = substr($tgl,3,2);
    $tanggal = substr($tgl,0,2);
    return $tahun.'-'.$bulan.'-'.$tanggal;
}


function format_date($date) {
    return date('d M Y', strtotime(date($date)));
}

function format_date_slash($date) {
    return date('d/m/Y', strtotime(date($date)));
}


function tanggal_indo($date){
    $bulan = date('m',  strtotime($date));
    $tahun = date('Y',  strtotime($date));
    $tanggal = date('d',  strtotime($date));
    $namabulan = namabulan_indo($bulan);
    return $tanggal.' '.$namabulan.' '.$tahun;
}

function namabulan_indo($bulan){
    $namabulan = '';
     switch ($bulan){
        case '01':
            $namabulan = "Januari";
            break;
        case '02':
            $namabulan = "Februari";
            break;
        case '03':
            $namabulan = "Maret";
            break;
        case '04':
            $namabulan = "April";
            break;
        case '05':
            $namabulan = "Mei";
            break;
        case '06':
            $namabulan = "Juni";
            break;
        case '07':
            $namabulan = "Juli";
            break;
        case '08':
            $namabulan = "Agustus";
            break;
        case '09':
            $namabulan = "September";
            break;
        case '10':
            $namabulan = "Oktober";
            break;
        case '11':
            $namabulan = "November";
            break;
        case '12':
            $namabulan = "Desember";
            break;
    }
    return $namabulan;
}



function checkin_checkout_indo($checkin,$checkout){
    $tanggalci = date('d',  strtotime($checkin));
    $bulanci = date('m',  strtotime($checkin));
    $tahunci = date('Y',  strtotime($checkin));
    $namabulanci = namabulan_indo($bulanci);
    
    $tanggalco = date('d',  strtotime($checkout));
    $bulanco = date('m',  strtotime($checkout));
    $tahunco = date('Y',  strtotime($checkout));
    $namabulanco = namabulan_indo($bulanco);
    
    return $tanggalci.' '.$namabulanci.' '.$tahunci.' - '.$tanggalco.' '.$namabulanco.' '.$tahunco;
}

// return 01/12/2012
function format_waktu2_slash($tgl) {
    $array=explode("-",$tgl);
    $tahun=$array[0];
    $bln=$array[1];

    $tgl1=$array[2];
    $tgl2=explode(" ",$tgl1);
    $tanggal=$tgl2[0];
    if($bln == "00") {
        $result = "00-00-0000";
    }else {
        $result = $tanggal."/".$bln."/".$tahun."";
    }
    return $result;
}#end 

//end
?>
