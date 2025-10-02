 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
<style type="text/css">
body {
  margin: 15px  5px 20px  5px;
  font-family:sans-serif;
  
}
 
table {
    border-collapse: collapse;
}
  

</style>
</head>

<body>
<script type="text/php">
    if ( isset($pdf) ) {
         $font = Font_Metrics::get_font("verdana");;
                $size = 6;
                $color = array(0,0,0);
                $text_height = Font_Metrics::get_font_height($font, $size);
                $w = $pdf->get_width();
                $h = $pdf->get_height();
                $y = $h - $text_height - 10;
                $text_footer = "Page {PAGE_NUM} of {PAGE_COUNT}";
                $pdf->page_text($w / 2  , $y, $text_footer, $font, $size, $color);
    }
</script>
        <h3 align="center">HOTEL COMPETITOR ANALYSIS</h3>
       <?php
       $date =  $tanggal;
        $userproperty = $this->session->userdata('property');
        if($userproperty == 'Kagum'){
            $dt_hotelcomp4 = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars(4);
            $dt_hotelcomp3 = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars(3);
        }else{
           $dt_hotelcomp4 = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars(4);
           $dt_hotelcomp3 = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars(3);
        }

        $pertanggal = tanggal_php_to_mysql($date);
        $perdate = substr($date,0,2);
        $permonth = substr($date,3,2);
        $peryear = substr($date,6);


        $seriticolor = "#ccffff";
        $serelacolor = "#00ccff";
        $bananacolor = "#00ff00";
        $goldencolor = "#ffcc00";
        $carrcadincolor = "#ffcccc";

        $start = strtotime($peryear.'-'.'01'.'-'.'01');
        $end = strtotime(tanggal_php_to_mysql($date));
        $diff = $end - $start;
        $ttldays = round($diff / 86400) + 1;

        if($date != ''){
        echo '<table border=1 width="100%" style="font-size: 7pt">
                <tr>
                    <td class="kolom" rowspan="2" style="vertical-align: middle;text-align: center"><b>Hotel Name</b></td>
                    <td class="kolom" rowspan="2" style="vertical-align: middle; text-align: center"><b>R. Inv.</b></td>
                    <td class="kolom" colspan="3" style="vertical-align: middle; text-align: center"><b>Room Sold</b></td>
                    <td class="kolom" colspan="3" style="vertical-align: middle; text-align: center"><b>OCCUPANCY</b></td>
                    <td class="kolom" colspan="3" style="vertical-align: middle; text-align: center"><b>ARR</b></td>
                    <td class="kolom" colspan="3" style="vertical-align: middle; text-align: center"><b>Total Room Revenue</b></td>
                    <td class="kolom" colspan="3" style="vertical-align: middle; text-align: center"><b>Fair Market Share</b></td>
                    <td class="kolom" colspan="3" style="vertical-align: middle; text-align: center"><b>Actual Market Share</b></td>
                    <td class="kolom" colspan="3" style="vertical-align: middle; text-align: center"><b>MPI</b></td>
                    <td class="kolom" rowspan="2" style="vertical-align: middle;text-align: center"><b>GROUP LAST NIGHT</b></td>
                </tr>
                <tr>
                    <td class="kolom" title="Today" style="vertical-align: middle;text-align: center">'.$date.'</td>
                    <td class="kolom" title="Month to Date" style="vertical-align: middle;text-align: center">MTD</td>
                    <td class="kolom" title="Year to Date" style="vertical-align: middle;text-align: center">YTD</td>
                    <!-- End Room Sold-->
                    <td class="kolom" title="Today" style="vertical-align: middle;text-align: center">'.$date.'(%)</td>
                    <td class="kolom" title="Month to Date" style="vertical-align: middle;text-align: center">MTD(%)</td>
                    <td class="kolom" title="Year to Date" style="vertical-align: middle;text-align: center">YTD(%)</td>
                    <!-- End Occupancy -->
                    <td class="kolom" title="Today" style="vertical-align: middle;text-align: center">'.$date.'</td>
                    <td class="kolom" title="Month to Date" style="vertical-align: middle;text-align: center">MTD</td>
                    <td class="kolom" title="Year to Date" style="vertical-align: middle;text-align: center">YTD</td>
                    <!-- End ARR -->
                    <td class="kolom" title="Today" style="vertical-align: middle;text-align: center">'.$date.'</td>
                    <td class="kolom" title="Month to Date" style="vertical-align: middle;text-align: center">MTD</td>
                    <td class="kolom" title="Year to Date" style="vertical-align: middle;text-align: center">YTD</td>
                    <!-- End Total Room Revenue -->
                    <td class="kolom" title="Today" style="vertical-align: middle;text-align: center">'.$date.'</td>
                    <td class="kolom" title="Month to Date" style="vertical-align: middle;text-align: center">MTD</td>
                    <td class="kolom" title="Year to Date" style="vertical-align: middle;text-align: center">YTD</td>
                    <!-- End Fair Market Share-->
                    <td class="kolom" title="Today" style="vertical-align: middle;text-align: center">'.$date.'</td>
                    <td class="kolom" title="Month to Date" style="vertical-align: middle;text-align: center">MTD</td>
                    <td class="kolom" title="Year to Date" style="vertical-align: middle;text-align: center">YTD</td>
                    <!-- End Actual Market Share -->
                    <td class="kolom" title="Today" style="vertical-align: middle;text-align: center">'.$date.'</td>
                    <td class="kolom" title="Month to Date" style="vertical-align: middle;text-align: center">MTD</td>
                    <td class="kolom" title="Year to Date" style="vertical-align: middle;text-align: center">YTD</td>
                    <!-- End MPI -->
                </tr>';
                    if($dt_hotelcomp4->result() != NULL){
                    echo '
                    <tr>
                        <td colspan="24" style="text-align: left"><b>4 STARS HOTEL ****</b></td>
                    </tr>';
                    }//endif 4stars

                    $total_arr_today = 0;
                    $total_arr_mtd = 0;
                    $total_arr_ytd = 0;

                    $total_ri_today = 0;
                    $total_ri_mtd = 0;
                    $total_ri_ytd = 0;
                    $total_rs_today = 0;
                    $total_rs_mtd = 0;
                    $total_rs_ytd = 0;

                    $total_occ_today = 0;
                    $total_occ_mtd = 0;
                    $total_occ_ytd = 0;

                    $total_trr_today = 0;
                    $total_trr_mtd = 0;
                    $total_trr_ytd = 0;

                    $total_fms_today = 0;
                    $total_fms_mtd = 0;
                    $total_fms_ytd = 0;

                    $total_ams_today = 0;
                    $total_ams_mtd = 0;
                    $total_ams_ytd = 0;

                    $total_mpi_today = 0;
                    $total_mpi_mtd = 0;
                    $total_mpi_ytd = 0;
                    foreach ($dt_hotelcomp4->result() AS $rowhtl) {
                        /////////////////////////////
                        $ri_today = 0;$ri_mtd = 0;$ri_ytd = 0;
                        $rs_today = 0;$rs_mtd = 0;$rs_ytd = 0;
                        $arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
                        $occ_today = 0;$occ_mtd = 0;$occ_ytd = 0;
                        $trr_today = 0;$trr_mtd = 0;$trr_ytd = 0;$totaltrrtoday=0;
                        $fms_today = 0;$fms_mtd = 0;$fms_ytd = 0;
                        $ams_today = 0;$ams_mtd = 0;$ams_ytd = 0;
                        $mpi_today = 0;$mpi_mtd = 0;$mpi_ytd = 0;
                        /////////////////////////////

                        $initbalroomsold_mtd = 0;
                        $initbalroomsold_ytd = 0;
                        $initbaltrr_mtd = 0;
                        $initbaltrr_ytd = 0;
                        $initbaldate = 0;
                        $dt_initbal = $this->hotel_comp_initial_model->select_hotelcominitbalance_permonthhotel($permonth,$rowhtl->idhotelcompetitor);
                        if($dt_initbal != NULL )
                        {
                            $initbaldate = $dt_initbal->per_date;
                            if (strtotime($initbaldate) <= $end) {
                                $initbalroomsold_mtd = $dt_initbal->mtd_rs;
                                $initbaltrr_mtd = $dt_initbal->mtd_trr;
                            }
                        }
                        $dt_initbalytd = $this->hotel_comp_initial_model->select_hotelcominitbalance_perhotel($rowhtl->idhotelcompetitor);
                        if($dt_initbalytd != NULL)
                        {
                            if (strtotime($initbaldate) <= $end) {
                                $initbalroomsold_ytd = $dt_initbalytd->ytd_rs;
                                $initbaltrr_ytd = $dt_initbalytd->ytd_trr;
                            }
                        }

                        $rs_mtd += $initbalroomsold_mtd;
                        $rs_ytd += $initbalroomsold_ytd;

                        $dt_analystoday = $this->hotel_competitor_analysis_model->select_competitoranalysisondate_perhotel($rowhtl->idhotelcompetitor,$pertanggal);
                        if($dt_analystoday != NULL){
                            $rs_today = $dt_analystoday->room_sold;
                            $arr_today = $dt_analystoday->arr;
                        }
                        $startdate_mtd = $peryear.'-'.$permonth.'-'.'01';
                        $enddate_mtd = $pertanggal;
                        $dt_rsmtd = $this->hotel_competitor_analysis_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);
                        if($dt_rsmtd != NULL)
                        {
                            $rs_mtd += $dt_rsmtd->RS_MTD;
                        }
                        //$dt_rsytd = $this->hotel_competitor_analysis_model->select_roomsoldyear_woinibaldate_perdate($rowhtl->idhotelcompetitor,$peryear,$pertanggal,$initbaldate);
                        $startdate_ytd = $peryear.'-01-'.'01';
                        $enddate_ytd = $pertanggal;
                        $dt_rsytd = $this->hotel_competitor_analysis_model->select_rsytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);

                        if($dt_rsytd != NULL)
                        {
                            $rs_ytd += $dt_rsytd->RS_YTD;
                        }


                        $dt_trrmtd = $this->hotel_competitor_analysis_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);
                        if($dt_trrmtd != NULL)
                        {
                            $trr_mtd = $dt_trrmtd->TRR_MTD;
                        }

                        $dt_trrytd = $this->hotel_competitor_analysis_model->select_trrytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);
                        if($dt_trrytd != NULL)
                        {
                             $trr_ytd = $dt_trrytd->TRR_YTD;
                        }
                        
                      


                        if (strtotime($initbaldate) <= strtotime($pertanggal)) {
                            $trr_mtd += $initbaltrr_mtd;
                            $trr_ytd += $initbaltrr_ytd;
                        } else {
                            //$trr_mtd += floatval($initbaltrr_mtd) + $totaltrrtoday;
                            //$trr_ytd += floatval($initbaltrr_ytd) + $totaltrrtoday;
                        }



                        $trr_today = $rs_today * $arr_today;
                        if($rs_mtd != 0 && $rs_ytd != 0 && $trr_mtd != 0 && $trr_ytd != 0){
                            $arr_mtd = $trr_mtd / $rs_mtd;
                            $arr_ytd = $trr_ytd /$rs_ytd;
                        }

                        $total_rs_today += $rs_today;
                        $total_rs_mtd += $rs_mtd;
                        $total_rs_ytd += $rs_ytd;

                        $total_arr_today += $arr_today;
                        $total_arr_mtd += $arr_mtd;
                        $total_arr_ytd += $arr_ytd;

                        $total_trr_today += $trr_today;
                        $total_trr_mtd += $trr_mtd;
                        $total_trr_ytd += $trr_ytd;

                        ///////////////////////////////////////////////////
                        $openingdate = strtotime($rowhtl->opening_date);
                        $hotelopendate = $rowhtl->opening_date;
                        $now = strtotime(date('Y-01-01'));
                        $is_opendt = false;
                        if ($openingdate > $now) {
                            $is_opendt = true;
                            $startdate = strtotime($hotelopendate);
                            $enddate = strtotime($pertanggal);
                            $diff = $enddate - $startdate;
                            $ttldaysopendate = round($diff / 86400) + 1;
                        } else {
                            $ttldaysopendate = $ttldays;
                        }
                        if ($is_opendt) {
                            $total_ri_ytd += $rowhtl->room_inventory * $ttldaysopendate;
                        } else {
                            $total_ri_ytd += ($rowhtl->room_inventory * $ttldaysopendate);
                        }
                        ///////////////////////////////////////////////////////

                        $total_ri_today += $rowhtl->room_inventory;
                        $total_ri_mtd += $rowhtl->room_inventory * $perdate;

                    }

                    $oddrow = 0;
                    foreach($dt_hotelcomp4->result() AS $rowhtl)
                    {
                        $oddrow++;
                        /////////////////////////////
                        $ri_today = 0;$ri_mtd = 0;$ri_ytd = 0;
                        $rs_today = 0;$rs_mtd = 0;$rs_ytd = 0;
                        $arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
                        $occ_today = 0;$occ_mtd = 0;$occ_ytd = 0;
                        $trr_today = 0;$trr_mtd = 0;$trr_ytd = 0;$totaltrrtoday=0;
                        $fms_today = 0;$fms_mtd = 0;$fms_ytd = 0;
                        $ams_today = 0;$ams_mtd = 0;$ams_ytd = 0;
                        $mpi_today = 0;$mpi_mtd = 0;$mpi_ytd = 0;
                        /////////////////////////////

                        $initbalroomsold_mtd = 0;
                        $initbalroomsold_ytd = 0;
                        $initbaltrr_mtd = 0;
                        $initbaltrr_ytd = 0;
                        $initbaldate = 0;
                        $dt_initbal = $this->hotel_comp_initial_model->select_hotelcominitbalance_permonthhotel($permonth,$rowhtl->idhotelcompetitor);
                        if($dt_initbal != NULL )
                        {
                            $initbaldate = $dt_initbal->per_date;
                            if (strtotime($initbaldate) <= $end) {
                                $initbalroomsold_mtd = $dt_initbal->mtd_rs;
                                $initbalroomsold_ytd = $dt_initbal->ytd_rs;
                                $initbaltrr_mtd = $dt_initbal->mtd_trr;
                                $initbaltrr_ytd = $dt_initbal->ytd_trr;
                            }
                        }

                         $dt_initbalytd = $this->hotel_comp_initial_model->select_hotelcominitbalance_perhotel($rowhtl->idhotelcompetitor);
                        if($dt_initbalytd != NULL)
                        {
                            if (strtotime($initbaldate) <= $end) {
                              $initbalroomsold_ytd = $dt_initbalytd->ytd_rs;
                              $initbaltrr_ytd = $dt_initbalytd->ytd_trr;
                              }
                        }

                        $rs_mtd += $initbalroomsold_mtd;
                        $rs_ytd += $initbalroomsold_ytd;

                        $dt_analystoday = $this->hotel_competitor_analysis_model->select_competitoranalysisondate_perhotel($rowhtl->idhotelcompetitor,$pertanggal);
                        if($dt_analystoday != NULL){
                            $rs_today = $dt_analystoday->room_sold;
                            $arr_today = $dt_analystoday->arr;
                        }
                        $startdate_mtd = $peryear.'-'.$permonth.'-'.'01';
                        $enddate_mtd = $pertanggal;
                        $dt_rsmtd = $this->hotel_competitor_analysis_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);
                        if($dt_rsmtd != NULL)
                        {
                            $rs_mtd += $dt_rsmtd->RS_MTD;
                        }
                        //$dt_rsytd = $this->hotel_competitor_analysis_model->select_roomsoldyear_woinibaldate_perdate($rowhtl->idhotelcompetitor,$peryear,$pertanggal,$initbaldate);
                        $startdate_ytd = $peryear.'-01-'.'01';
                        $enddate_ytd = $pertanggal;
                        $dt_rsytd = $this->hotel_competitor_analysis_model->select_rsytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);

                        if($dt_rsytd != NULL)
                        {
                            $rs_ytd += $dt_rsytd->RS_YTD;
                        }


                        $dt_trrmtd = $this->hotel_competitor_analysis_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);
                        if($dt_trrmtd != NULL)
                        {
                            $trr_mtd = $dt_trrmtd->TRR_MTD;
                        }

                        $dt_trrytd = $this->hotel_competitor_analysis_model->select_trrytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);
                        if($dt_trrytd != NULL)
                        {
                             $trr_ytd = $dt_trrytd->TRR_YTD;
                        }
                        

                        if (strtotime($initbaldate) <= strtotime($pertanggal)) {
                            $trr_mtd += $initbaltrr_mtd;
                            $trr_ytd += $initbaltrr_ytd;
                        } else {
                            //$trr_mtd += floatval($initbaltrr_mtd) + $totaltrrtoday;
                            //$trr_ytd += floatval($initbaltrr_ytd) + $totaltrrtoday;
                        }

                        $trr_today = $rs_today * $arr_today;
                        if($rs_mtd != 0 && $rs_ytd != 0 && $trr_mtd != 0 && $trr_ytd != 0){
                            $arr_mtd = $trr_mtd / $rs_mtd;
                            $arr_ytd = $trr_ytd /$rs_ytd;
                        }

                        $ri_today += $rowhtl->room_inventory;
                        $ri_mtd += $rowhtl->room_inventory * $perdate;


                        ///////////////////////////////////////////////////
                        $openingdate = strtotime($rowhtl->opening_date);
                        $hotelopendate = $rowhtl->opening_date;
                        $now = strtotime(date('Y-01-01'));
                        $is_opendt = false;
                        if ($openingdate > $now) {
                            $is_opendt = true;
                            $startdate = strtotime($hotelopendate);
                            $enddate = strtotime($pertanggal);
                            $diff = $enddate - $startdate;
                            $ttldaysopendate = round($diff / 86400) + 1;
                        } else {
                            $ttldaysopendate = $ttldays;
                        }
                        if ($is_opendt) {
                            $ri_ytd += $rowhtl->room_inventory * $ttldaysopendate;
                        } else {
                            $ri_ytd += ($rowhtl->room_inventory * $ttldaysopendate);
                        }
                        ///////////////////////////////////////////////////////


                        if($rs_today != 0 && $ri_today !=0){
                            $occ_today = ($rs_today / $ri_today) * 100;
                        }
                        if($rs_mtd != 0 && $ri_mtd != 0)
                        {
                            $occ_mtd = ($rs_mtd / $ri_mtd) * 100;
                        }
                        if($rs_ytd != 0 && $ri_ytd != 0)
                        {
                            $occ_ytd = ($rs_ytd / $ri_ytd) * 100;
                        }

                        $fms_today = $ri_today/$total_ri_today;
                        $fms_mtd = $ri_mtd/$total_ri_mtd;
                        $fms_ytd = $ri_ytd/$total_ri_ytd;

                        if($rs_today != 0 && $total_rs_today != 0){
                            $ams_today = $rs_today / $total_rs_today;
                        }
                        if ($rs_mtd != 0 && $total_rs_mtd != 0) {
                            $ams_mtd = $rs_mtd / $total_rs_mtd;
                        }
                        if ($rs_ytd != 0 && $total_rs_ytd != 0) {
                            $ams_ytd = $rs_ytd / $total_rs_ytd;
                        }
                        if ($ams_today != 0 && $fms_today != 0) {
                            $mpi_today = $ams_today / $fms_today;
                        }
                        if ($ams_mtd != 0 && $fms_mtd != 0) {
                            $mpi_mtd = $ams_mtd / $fms_mtd;
                        }
                        if ($ams_ytd != 0 && $fms_ytd != 0) {
                            $mpi_ytd = $ams_ytd / $fms_ytd;
                        }

//                        $total_occ_today += $occ_today;
//                        $total_occ_mtd += $occ_mtd;
//                        $total_occ_ytd += $occ_ytd;

                        $total_occ_today = ($total_rs_today / $total_ri_today) * 100;
                        $total_occ_mtd = ($total_rs_mtd / $total_ri_mtd) * 100;
                        $total_occ_ytd = ($total_rs_ytd / $total_ri_ytd) * 100;

                        $total_fms_today += $fms_today;
                        $total_fms_mtd += $fms_mtd;
                        $total_fms_ytd += $fms_ytd;

                        $total_ams_today += $ams_today;
                        $total_ams_mtd += $ams_mtd;
                        $total_ams_ytd += $ams_ytd;

                        $total_mpi_today = $total_ams_today / $total_fms_today;
                        $total_mpi_mtd = $total_ams_mtd / $total_fms_mtd;
                        $total_mpi_ytd = $total_ams_ytd / $total_fms_ytd;

                        if ($total_trr_today != 0 || $total_rs_today != 0) {
                            $total_arr_today = $total_trr_today / $total_rs_today;
                        }
                        if ($total_trr_mtd != 0 || $total_rs_mtd != 0) {
                            $total_arr_mtd = $total_trr_mtd / $total_rs_mtd;
                        }
                        if ($total_trr_ytd != 0 || $total_rs_ytd != 0) {
                            $total_arr_ytd = $total_trr_ytd / $total_rs_ytd;
                        }

                        if(($oddrow % 2) != 0){
                            $class = "style='background-color: #ecfce3'";
                            $styletd = ";background-color: #ecfce3";
                        }else{
                            $class = '';
                            $styletd = "";
                        }

                         if (strtolower($rowhtl->hotelcompetitor_name) == "carrcadin") {
                           $styletd = ";background-color: $carrcadincolor";
                        } elseif (strtolower($rowhtl->hotelcompetitor_name) == "grand seriti") {
                           $styletd = ";background-color: $seriticolor";
                        } elseif (strtolower($rowhtl->hotelcompetitor_name) == "grand serela") {
                           $styletd = ";background-color: $serelacolor";
                        } elseif (strtolower($rowhtl->hotelcompetitor_name) == "banana inn") {
                           $styletd = ";background-color: $bananacolor";
                        } elseif (strtolower($rowhtl->hotelcompetitor_name) == "golden flower") {
                         $styletd = ";background-color: $goldencolor";
                        } else {
                          $styletd = ";background-color:white";
                        }//endif
                        echo '
                       <tr>
                        <td class="kolom" style="'.$styletd.'" width="90px">
                            '.$rowhtl->hotelcompetitor_name.'
                        </td>
                        <td class="kolom" style="text-align: center '.$styletd.'">
                            '.$rowhtl->room_inventory.'
                        </td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Today" >'. $rs_today.'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Month to Date"  >'.$rs_mtd.'</td>
                        <td class="kolom" style="text-align: center '.$styletd.'" title="Year to Date" >'.$rs_ytd.'</td>
                        <!-- End Room Sold-->
                        <td class="kolom" style="text-align: center '.$styletd.'" title="Today"  >'.number_format($occ_today,1,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Month to Date" >'.number_format($occ_mtd,1,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Year to Date"  >'.number_format($occ_ytd,1,',','.').'</td>
                        <!-- End Occupancy-->
                        <td class="kolom" style="text-align: right'.$styletd.'" title="Today"  >'.number_format($arr_today,0,',',',').'</td>
                        <td class="kolom" style="text-align: right'.$styletd.'" title="Month to Date" >'.number_format($arr_mtd,0,',',',').'</td>
                        <td class="kolom" style="text-align: right'.$styletd.'" title="Year to Date"  >'.number_format($arr_ytd,0,',',',').'</td>
                        <!-- End ARR-->
                        <td class="kolom" style="text-align: right'.$styletd.'" title="Today"  >'.number_format($trr_today,0,',','.').'</td>
                        <td class="kolom" style="text-align: right'.$styletd.'" title="Month to Date"  >'.number_format($trr_mtd,0,',','.').'</td>
                        <td class="kolom" style="text-align: right'.$styletd.'" title="Year to Date"  >'.number_format($trr_ytd,0,',','.').'</td>
                        <!-- End Total Room Revenue-->
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Today"  >'.number_format($fms_today,2,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Month to Date"  >'.number_format($fms_mtd,2,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Year to Date"  >'.number_format($fms_ytd,2,',','.').'</td>
                        <!-- End Fair Market Share-->
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Today"  >'.number_format($ams_today,2,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Month to Date"  >'.number_format($ams_mtd,2,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Year to Date"  >'.number_format($ams_ytd,2,',','.').'</td>
                        <!-- End Actual Market Share-->
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Today"  >'.number_format($mpi_today,2,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Month to Date" >'.number_format($mpi_mtd,2,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Year to Date"  >'.number_format($mpi_ytd,2,',','.').'</td>
                        <!-- End MPI -->
                        <td class="kolom" style="'.$styletd.'" >';
                                $dt_grouphotel = $this->hotel_competitor_analysis_model->select_groupondate_perhotel($rowhtl->idhotelcompetitor,$pertanggal);
                                $row = 1;
                                $ttlrowgh = $dt_grouphotel->num_rows();
                                foreach($dt_grouphotel->result() AS $rowgh)
                                {
                                    echo '- '. $rowgh->account_name.'[<font style="color:red">'.$rowgh->rno.'</font>]';
                                    if($row < $ttlrowgh)
                                    {
                                        //echo '<b> - </b> ';
                                        echo '<br/>';
                                    }
                                    $row++;
                                }
                              echo ' </td>
                    </tr>';

                    }
                    echo '
                    <tr>
                        <td class="kolom" style="text-align: right"><b>Total</b></td>
                        <td class="kolom" style="text-align: center">'.$total_ri_today.'</td>
                        <td class="kolom" style="text-align: center">'.$total_rs_today.'</td>
                        <td class="kolom" style="text-align: center">'.$total_rs_mtd.'</td>
                        <td class="kolom" style="text-align: center">'.$total_rs_ytd.'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_occ_today,1,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_occ_mtd,1,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_occ_ytd,1,',','.').'</td>
                        <td class="kolom" style="text-align: right">'.number_format($total_arr_today,0,',','.').'</td>
                        <td class="kolom" style="text-align: right">'.number_format($total_arr_mtd,0,',','.').'</td>
                        <td class="kolom" style="text-align: right">'.number_format($total_arr_ytd,0,',','.').'</td>
                        <td class="kolom" style="text-align: right">'.number_format($total_trr_today,0,',','.').'</td>
                        <td class="kolom" style="text-align: right">'.number_format($total_trr_mtd,0,',','.').'</td>
                        <td class="kolom" style="text-align: right">'.number_format($total_trr_ytd,0,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_fms_today,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_fms_mtd,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_fms_ytd,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_ams_today,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_ams_mtd,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_ams_ytd,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_mpi_today,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_mpi_mtd,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_mpi_ytd,2,',','.').'</td>
                        <td class="kolom"></td>
                    </tr>';

                   if($dt_hotelcomp3->result()  != NULL){
                   echo '
                   <tr>
                        <td colspan="24" style="text-align: left"><b>3 STARS HOTEL ***</b></td>
                    </tr>';
                    }//endif hotel 3 stars

                    $total_arr_today3 = 0;
                    $total_arr_mtd3 = 0;
                    $total_arr_ytd3 = 0;

                    $total_ri_today3 = 0;
                    $total_ri_mtd3 = 0;
                    $total_ri_ytd3 = 0;
                    $total_rs_today3 = 0;
                    $total_rs_mtd3 = 0;
                    $total_rs_ytd3 = 0;

                    $total_occ_today3 = 0;
                    $total_occ_mtd3 = 0;
                    $total_occ_ytd3 = 0;

                    $total_trr_today3 = 0;
                    $total_trr_mtd3 = 0;
                    $total_trr_ytd3 = 0;

                    $total_fms_today3 = 0;
                    $total_fms_mtd3 = 0;
                    $total_fms_ytd3 = 0;

                    $total_ams_today3 = 0;
                    $total_ams_mtd3 = 0;
                    $total_ams_ytd3 = 0;

                    $total_mpi_today3 = 0;
                    $total_mpi_mtd3 = 0;
                    $total_mpi_ytd3 = 0;
                    foreach($dt_hotelcomp3->result() AS $rowhtl)
                    {
                         /////////////////////////////
                        $ri_today = 0;$ri_mtd = 0;$ri_ytd = 0;
                        $rs_today = 0;$rs_mtd = 0;$rs_ytd = 0;
                        $arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
                        $occ_today = 0;$occ_mtd = 0;$occ_ytd = 0;
                        $trr_today = 0;$trr_mtd = 0;$trr_ytd = 0;$totaltrrtoday=0;
                        $fms_today = 0;$fms_mtd = 0;$fms_ytd = 0;
                        $ams_today = 0;$ams_mtd = 0;$ams_ytd = 0;
                        $mpi_today = 0;$mpi_mtd = 0;$mpi_ytd = 0;
                        /////////////////////////////

                        $initbalroomsold_mtd = 0;
                        $initbalroomsold_ytd = 0;
                        $initbaltrr_mtd = 0;
                        $initbaltrr_ytd = 0;
                        $initbaldate = 0;
                        $dt_initbal = $this->hotel_comp_initial_model->select_hotelcominitbalance_permonthhotel($permonth,$rowhtl->idhotelcompetitor);
                        if($dt_initbal != NULL )
                        {
                            $initbaldate = $dt_initbal->per_date;
                            if (strtotime($initbaldate) <= $end) {
                                $initbalroomsold_mtd = $dt_initbal->mtd_rs;
                                $initbalroomsold_ytd = $dt_initbal->ytd_rs;
                                $initbaltrr_mtd = $dt_initbal->mtd_trr;
                                $initbaltrr_ytd = $dt_initbal->ytd_trr;
                            }
                        }

                        $dt_initbalytd = $this->hotel_comp_initial_model->select_hotelcominitbalance_perhotel($rowhtl->idhotelcompetitor);
                        if($dt_initbalytd != NULL)
                        {
                            if (strtotime($initbaldate) <= $end) {
                              $initbalroomsold_ytd = $dt_initbalytd->ytd_rs;
                              $initbaltrr_ytd = $dt_initbalytd->ytd_trr;
                              }
                        }


                        $rs_mtd += $initbalroomsold_mtd;
                        $rs_ytd += $initbalroomsold_ytd;

                        $dt_analystoday = $this->hotel_competitor_analysis_model->select_competitoranalysisondate_perhotel($rowhtl->idhotelcompetitor,$pertanggal);
                        if($dt_analystoday != NULL){
                            $rs_today = $dt_analystoday->room_sold;
                            $arr_today = $dt_analystoday->arr;
                        }
                        $startdate_mtd = $peryear.'-'.$permonth.'-'.'01';
                        $enddate_mtd = $pertanggal;
                        $dt_rsmtd = $this->hotel_competitor_analysis_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);
                        if($dt_rsmtd != NULL)
                        {
                            $rs_mtd += $dt_rsmtd->RS_MTD;
                        }
                        //$dt_rsytd = $this->hotel_competitor_analysis_model->select_roomsoldyear_woinibaldate_perdate($rowhtl->idhotelcompetitor,$peryear,$pertanggal,$initbaldate);
                        $startdate_ytd = $peryear.'-01-'.'01';
                        $enddate_ytd = $pertanggal;
                        $dt_rsytd = $this->hotel_competitor_analysis_model->select_rsytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);

                        if($dt_rsytd != NULL)
                        {
                            $rs_ytd += $dt_rsytd->RS_YTD;
                        }


                        $dt_trrmtd = $this->hotel_competitor_analysis_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);
                        if($dt_trrmtd != NULL)
                        {
                            $trr_mtd = $dt_trrmtd->TRR_MTD;
                        }

                        $dt_trrytd = $this->hotel_competitor_analysis_model->select_trrytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);
                        if($dt_trrytd != NULL)
                        {
                             $trr_ytd = $dt_trrytd->TRR_YTD;
                        }
                        

                        if (strtotime($initbaldate) <= strtotime($pertanggal)) {
                            $trr_mtd += $initbaltrr_mtd;
                            $trr_ytd += $initbaltrr_ytd;
                        } else {
                           // $trr_mtd += floatval($initbaltrr_mtd) + $totaltrrtoday;
                           // $trr_ytd += floatval($initbaltrr_ytd) + $totaltrrtoday;
                        }

                        $trr_today = $rs_today * $arr_today;
                        if($rs_mtd != 0 && $rs_ytd != 0 && $trr_ytd != 0 && $trr_mtd != 0){
                            $arr_mtd = $trr_mtd / $rs_mtd;
                            $arr_ytd = $trr_ytd /$rs_ytd;
                        }

                        $total_rs_today3 += $rs_today;
                        $total_rs_mtd3 += $rs_mtd;
                        $total_rs_ytd3 += $rs_ytd;

                        $total_arr_today3 += $arr_today;
                        $total_arr_mtd3 += $arr_mtd;
                        $total_arr_ytd3 += $arr_ytd;

                        $total_trr_today3 += $trr_today;
                        $total_trr_mtd3 += $trr_mtd;
                        $total_trr_ytd3 += $trr_ytd;

                        $total_ri_today3 += $rowhtl->room_inventory;
                        $total_ri_mtd3 += $rowhtl->room_inventory * $perdate;


                        ///////////////////////////////////////////////////
                        $openingdate = strtotime($rowhtl->opening_date);
                        $hotelopendate = $rowhtl->opening_date;
                        $now = strtotime(date('Y-01-01'));
                        $is_opendt = false;
                        if ($openingdate > $now) {
                            $is_opendt = true;
                            $startdate = strtotime($hotelopendate);
                            $enddate = strtotime($pertanggal);
                            $diff = $enddate - $startdate;
                            $ttldaysopendate = round($diff / 86400) + 1;
                        } else {
                            $ttldaysopendate = $ttldays;
                        }
                        if ($is_opendt) {
                            $total_ri_ytd3 += $rowhtl->room_inventory * $ttldaysopendate;
                        } else {
                            $total_ri_ytd3 += ($rowhtl->room_inventory * $ttldaysopendate);
                        }
                        ///////////////////////////////////////////////////////

                    }



                    foreach($dt_hotelcomp3->result() AS $rowhtl)
                    {
                        $oddrow++;
                        /////////////////////////////
                        $ri_today = 0;$ri_mtd = 0;$ri_ytd = 0;
                        $rs_today = 0;$rs_mtd = 0;$rs_ytd = 0;
                        $arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
                        $occ_today = 0;$occ_mtd = 0;$occ_ytd = 0;
                        $trr_today = 0;$trr_mtd = 0;$trr_ytd = 0;$totaltrrtoday=0;
                        $fms_today = 0;$fms_mtd = 0;$fms_ytd = 0;
                        $ams_today = 0;$ams_mtd = 0;$ams_ytd = 0;
                        $mpi_today = 0;$mpi_mtd = 0;$mpi_ytd = 0;
                        /////////////////////////////

                        $initbalroomsold_mtd = 0;
                        $initbalroomsold_ytd = 0;
                        $initbaltrr_mtd = 0;
                        $initbaltrr_ytd = 0;
                        $initbaldate = 0;
                        $dt_initbal = $this->hotel_comp_initial_model->select_hotelcominitbalance_permonthhotel($permonth,$rowhtl->idhotelcompetitor);
                        if($dt_initbal != NULL )
                        {
                            $initbaldate = $dt_initbal->per_date;
                            if (strtotime($initbaldate) <= $end) {
                                $initbalroomsold_mtd = $dt_initbal->mtd_rs;
                                $initbalroomsold_ytd = $dt_initbal->ytd_rs;
                                $initbaltrr_mtd = $dt_initbal->mtd_trr;
                                $initbaltrr_ytd = $dt_initbal->ytd_trr;
                            }
                        }

                        $dt_initbalytd = $this->hotel_comp_initial_model->select_hotelcominitbalance_perhotel($rowhtl->idhotelcompetitor);
                        if ($dt_initbalytd != NULL) {
                            if (strtotime($initbaldate) <= $end) {
                                $initbalroomsold_ytd = $dt_initbalytd->ytd_rs;
                                $initbaltrr_ytd = $dt_initbalytd->ytd_trr;
                            }
                        }

                        $rs_mtd += $initbalroomsold_mtd;
                        $rs_ytd += $initbalroomsold_ytd;

                        $dt_analystoday = $this->hotel_competitor_analysis_model->select_competitoranalysisondate_perhotel($rowhtl->idhotelcompetitor,$pertanggal);
                        if($dt_analystoday != NULL){
                            $rs_today = $dt_analystoday->room_sold;
                            $arr_today = $dt_analystoday->arr;
                        }
                        $startdate_mtd = $peryear.'-'.$permonth.'-'.'01';
                        $enddate_mtd = $pertanggal;
                        $dt_rsmtd = $this->hotel_competitor_analysis_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);
                        if($dt_rsmtd != NULL)
                        {
                            $rs_mtd += $dt_rsmtd->RS_MTD;
                        }
                        //$dt_rsytd = $this->hotel_competitor_analysis_model->select_roomsoldyear_woinibaldate_perdate($rowhtl->idhotelcompetitor,$peryear,$pertanggal,$initbaldate);
                        $startdate_ytd = $peryear.'-01-'.'01';
                        $enddate_ytd = $pertanggal;
                        $dt_rsytd = $this->hotel_competitor_analysis_model->select_rsytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);

                        if($dt_rsytd != NULL)
                        {
                            $rs_ytd += $dt_rsytd->RS_YTD;
                        }


                        $dt_trrmtd = $this->hotel_competitor_analysis_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$rowhtl->idhotelcompetitor);
                        if($dt_trrmtd != NULL)
                        {
                            $trr_mtd = $dt_trrmtd->TRR_MTD;
                        }

                        $dt_trrytd = $this->hotel_competitor_analysis_model->select_trrytd_perhotel($startdate_ytd,$enddate_ytd,$rowhtl->idhotelcompetitor);
                        if($dt_trrytd != NULL)
                        {
                             $trr_ytd = $dt_trrytd->TRR_YTD;
                        }


                        if (strtotime($initbaldate) <= strtotime($pertanggal)) {
                            $trr_mtd += $initbaltrr_mtd;
                            $trr_ytd += $initbaltrr_ytd;
                        } else {
                           // $trr_mtd += floatval($initbaltrr_mtd) + $totaltrrtoday;
                           // $trr_ytd += floatval($initbaltrr_ytd) + $totaltrrtoday;
                        }

                        $trr_today = $rs_today * $arr_today;
                        if($rs_mtd != 0 && $rs_ytd != 0 ){
                            $arr_mtd = $trr_mtd / $rs_mtd;
                            $arr_ytd = $trr_ytd /$rs_ytd;
                        }

                        $ri_today += $rowhtl->room_inventory;
                        $ri_mtd += $rowhtl->room_inventory * $perdate;


                        ///////////////////////////////////////////////////
                        $openingdate = strtotime($rowhtl->opening_date);
                        $hotelopendate = $rowhtl->opening_date;
                        $now = strtotime(date('Y-01-01'));
                        $is_opendt = false;
                        if ($openingdate > $now) {
                            $is_opendt = true;
                            $startdate = strtotime($hotelopendate);
                            $enddate = strtotime($pertanggal);
                            $diff = $enddate - $startdate;
                            $ttldaysopendate = round($diff / 86400) + 1;
                        } else {
                            $ttldaysopendate = $ttldays;
                        }
                        if ($is_opendt) {
                            $ri_ytd += $rowhtl->room_inventory * $ttldaysopendate;
                        } else {
                            $ri_ytd += ($rowhtl->room_inventory * $ttldaysopendate);
                        }
                        ///////////////////////////////////////////////////////


                        if($rs_today != 0 && $ri_today !=0){
                            $occ_today = ($rs_today / $ri_today) * 100;
                        }
                        if($rs_mtd != 0 && $ri_mtd != 0)
                        {
                            $occ_mtd = ($rs_mtd / $ri_mtd) * 100;
                        }
                        if($rs_ytd != 0 && $ri_ytd != 0)
                        {
                            $occ_ytd = ($rs_ytd / $ri_ytd) * 100;
                        }

                        $fms_today = $ri_today/$total_ri_today3;
                        $fms_mtd = $ri_mtd/$total_ri_mtd3;
                        $fms_ytd = $ri_ytd/$total_ri_ytd3;

                        if($rs_today != 0 && $total_rs_today3 != 0){
                            $ams_today = $rs_today / $total_rs_today3;
                        }
                        if ($rs_mtd != 0 && $total_rs_mtd != 0) {
                            $ams_mtd = $rs_mtd / $total_rs_mtd3;
                        }
                        if ($rs_ytd != 0 && $total_rs_ytd3 != 0) {
                            $ams_ytd = $rs_ytd / $total_rs_ytd3;
                        }
                        if ($ams_today != 0 && $fms_today != 0) {
                            $mpi_today = $ams_today / $fms_today;
                        }
                        if ($ams_mtd != 0 && $fms_mtd != 0) {
                            $mpi_mtd = $ams_mtd / $fms_mtd;
                        }
                        if ($ams_ytd != 0 && $fms_ytd != 0) {
                            $mpi_ytd = $ams_ytd / $fms_ytd;
                        }


                        $total_occ_today3 = ($total_rs_today3 / $total_ri_today3) * 100;
                        $total_occ_mtd3 = ($total_rs_mtd3 / $total_ri_mtd3) * 100;
                        $total_occ_ytd3 = ($total_rs_ytd3 / $total_ri_ytd3) * 100;


                        $total_fms_today3 += $fms_today;
                        $total_fms_mtd3 += $fms_mtd;
                        $total_fms_ytd3 += $fms_ytd;

                        $total_ams_today3 += $ams_today;
                        $total_ams_mtd3 += $ams_mtd;
                        $total_ams_ytd3 += $ams_ytd;

                        $total_mpi_today3 = $total_ams_today3 / $total_fms_today3;
                        $total_mpi_mtd3 = $total_ams_mtd3 / $total_fms_mtd3;
                        $total_mpi_ytd3 = $total_ams_ytd3 / $total_fms_ytd3;

                        if($total_trr_today3 != 0 || $total_rs_today3 != 0){
                            $total_arr_today3 = $total_trr_today3 / $total_rs_today3;
                        }
                        if($total_trr_mtd3 != 0 || $total_rs_mtd3 != 0){
                            $total_arr_mtd3 = $total_trr_mtd3  / $total_rs_mtd3;
                        }
                        if($total_trr_ytd3 != 0 || $total_rs_ytd3 != 0){
                            $total_arr_ytd3 = $total_trr_ytd3 / $total_rs_ytd3;
                        }


                        if(($oddrow % 2) != 0){
                            $class = "style='background-color: #ecfce3'";
                            $styletd = ";background-color: #ecfce3";
                        }else{
                            $class = '';
                            $styletd = "";
                        }


                         if (strtolower($rowhtl->hotelcompetitor_name) == "grand serela") {
                           $styletd = ";background-color: $serelacolor";

                        } else {
                          $styletd = ";background-color:white";
                        }//endif


                     if (strtolower($rowhtl->hotelcompetitor_name) == "grand serela") {
                            echo ' <tr style="background-color: '.$serelacolor.'">';
                        
                        } else {
                            echo ' <tr>';
                        }//endif
                         echo '
                         
                        <td class="kolom" style="'.$styletd.'">
                            '.$rowhtl->hotelcompetitor_name.'
                        </td>
                        <td class="kolom" style="text-align: center'.$styletd.'">
                            '.$rowhtl->room_inventory.'
                        </td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Today">'.$rs_today.'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Month to Date">'.$rs_mtd.'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Year to Date">'.$rs_ytd.'</td>
                        <!-- End Room Sold-->
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Today">'.number_format($occ_today,1,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Month to Date">'.number_format($occ_mtd,1,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Year to Date">'.number_format($occ_ytd,1,',','.').'</td>
                        <!-- End Occupancy-->
                        <td class="kolom" style="text-align: right'.$styletd.'" title="Today">'.number_format($arr_today,0,',',',').'</td>
                        <td class="kolom" style="text-align: right'.$styletd.'" title="Month to Date">'.number_format($arr_mtd,0,',',',').'</td>
                        <td class="kolom" style="text-align: right'.$styletd.'" title="Year to Date">'.number_format($arr_ytd,0,',',',').'</td>
                        <!-- End ARR-->
                        <td class="kolom" style="text-align: right'.$styletd.'" title="Today">'.number_format($trr_today,0,',','.').'</td>
                        <td class="kolom" style="text-align: right'.$styletd.'" title="Month to Date">'.number_format($trr_mtd,0,',','.').'</td>
                        <td class="kolom" style="text-align: right'.$styletd.'" title="Year to Date">'.number_format($trr_ytd,0,',','.').'</td>
                        <!-- End Total Room Revenue-->
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Today">'.number_format($fms_today,2,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Month to Date">'.number_format($fms_mtd,2,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Year to Date">'.number_format($fms_ytd,2,',','.').'</td>
                        <!-- End Fair Market Share-->
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Today">'.number_format($ams_today,2,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Month to Date">'.number_format($ams_mtd,2,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Year to Date">'.number_format($ams_ytd,2,',','.').'</td>
                        <!-- End Actual Market Share-->
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Today">'.number_format($mpi_today,2,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Month to Date">'.number_format($mpi_mtd,2,',','.').'</td>
                        <td class="kolom" style="text-align: center'.$styletd.'" title="Year to Date">'.number_format($mpi_ytd,2,',','.').'</td>
                        <!-- End MPI -->
                        <td class="kolom" style="'.$styletd.'">';
                                $dt_grouphotel = $this->hotel_competitor_analysis_model->select_groupondate_perhotel($rowhtl->idhotelcompetitor,$pertanggal);
                                $row = 1;
                                $ttlrowgh = $dt_grouphotel->num_rows();
                                foreach($dt_grouphotel->result() AS $rowgh)
                                {
                                    echo '- '. $rowgh->account_name.'[<font style="color:red">'.$rowgh->rno.'</font>]';
                                    if($row < $ttlrowgh)
                                    {
                                        //echo '<b> - </b> ';
                                        echo '<br/>';
                                    }
                                    $row++;
                                }
                        echo '
                        </td>
                    </tr>';

                    }
                    echo '
                    <tr>
                        <td class="kolom" style="text-align: right"><b>Total</b></td>
                        <td class="kolom" style="text-align: center">'.$total_ri_today3.'</td>
                        <td class="kolom" style="text-align: center">'.$total_rs_today3.'</td>
                        <td class="kolom" style="text-align: center">'.$total_rs_mtd3.'</td>
                        <td class="kolom" style="text-align: center">'.$total_rs_ytd3.'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_occ_today3,1,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_occ_mtd3,1,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_occ_ytd3,1,',','.').'</td>
                        <td class="kolom" style="text-align: right">'.number_format($total_arr_today3,0,',','.').'</td>
                        <td class="kolom" style="text-align: right">'.number_format($total_arr_mtd3,0,',','.').'</td>
                        <td class="kolom" style="text-align: right">'.number_format($total_arr_ytd3,0,',','.').'</td>
                        <td class="kolom" style="text-align: right">'.number_format($total_trr_today3,0,',','.').'</td>
                        <td class="kolom" style="text-align: right">'.number_format($total_trr_mtd3,0,',','.').'</td>
                        <td class="kolom" style="text-align: right">'.number_format($total_trr_ytd3,0,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_fms_today3,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_fms_mtd3,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_fms_ytd3,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_ams_today3,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_ams_mtd3,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_ams_ytd3,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_mpi_today3,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_mpi_mtd3,2,',','.').'</td>
                        <td class="kolom" style="text-align: center">'.number_format($total_mpi_ytd3,2,',','.').'</td>
                        <td class="kolom"></td>
                    </tr>
                </table>';

                    echo '<div style="width: 1110px; ">
                          <table style="margin-top: 20px;margin-bottom:  20px;">';
                    echo '<tr>';
                    echo '<td style="width:450px">';
                    echo '<table  border=1  style=" width:100%;font-size: 6pt">
                                        <tr>
                                            <td colspan="5" class="kolom"><span style="background-color:#ff99ff;padding: 5px ">TARGET '.date('F Y').'</span>, Days in month : <span style="background-color:#ccffff ">'.date('t').'</span></td>
                                            <td colspan="2" class="kolom">REQUIRED TO MEET TARGET</td>
                                        </tr>
                                        <tr class="oddRow">
                                            <td style="text-align: center" class="kolom">Sunan Hotel</td>
                                            <td style="text-align: center">Rnts</td>
                                            <td style="text-align: center">Occ %</td>
                                            <td style="text-align: center">Arr</td>
                                            <td style="text-align: center">RRev</td>
                                            <td style="text-align: center"><b>Rnts</b></td>
                                            <td style="text-align: center"><b>RRev</b></td>
                                        </tr>';
                                          $dt_budgetproperty = $this->hca_property_budget_model->select_budgetproperty_perperiod($permonth,$peryear);

                                         foreach($dt_budgetproperty->result() AS $rowpr){
                                            ////////////////////////////////
                                            ////////////////////////////////
                                            $rs_mtd = 0;
                                            $trr_mtd = 0;
                                            /////////////////////////////
                                            $initbalroomsold_mtd = 0;
                                            $initbaltrr_mtd = 0;
                                            $initbaldate = 0;

                                            $dt_initbal = $this->hotel_comp_initial_model->select_hotelcominitbalance_permonthhotel($permonth,$rowpr->idhotelcompetitor_FK);
                                            if($dt_initbal != NULL)
                                            {
                                                $initbalroomsold_mtd = $dt_initbal->mtd_rs;
                                                 $initbaltrr_mtd = $dt_initbal->mtd_trr;
                                                 $initbaldate = $dt_initbal->per_date;
                                            }

                                            $rs_mtd += $initbalroomsold_mtd;
                                            $rs_ytd += $initbalroomsold_ytd;

                                            $dt_rsmtd = $this->hotel_competitor_analysis_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$rowpr->idhotelcompetitor_FK);
                                            if ($dt_rsmtd != NULL) {
                                                $rs_mtd += $dt_rsmtd->RS_MTD;
                                            }


                                            $dt_trrmtd = $this->hotel_competitor_analysis_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$rowpr->idhotelcompetitor_FK);
                                            if($dt_trrmtd != NULL)
                                            {
                                                $trr_mtd = $dt_trrmtd->TRR_MTD;
                                            }

                                            ////////////////////////////////
                                            ////////////////////////////////

                                            $rm_inventory = $rowpr->room_inventory;
                                            $daysinmonth = date('t');
                                            $occ = $rowpr->room_night / ($rm_inventory * $daysinmonth);
                                            $rrev = $rowpr->room_night * $rowpr->arr;
                                            $rmnight_req =  $rs_mtd - $rowpr->room_night;
                                            $rrev_req = $trr_mtd - $rrev;
                                         echo '
                                        <tr>
                                            <td class="kolom">'.$rowpr->hotelcompetitor_name.'</td>
                                            <td style="text-align: center" class="kolom">'.$rowpr->room_night.'</td>
                                            <td style="text-align: center;background-color: #ccffff" class="kolom">'.number_format($occ * 100,1,',','.').'%</td>
                                            <td style="text-align: right" class="kolom">'.number_format($rowpr->arr,0,',','.').'</td>
                                            <td class="kolom" style="text-align: right;background-color: #ccffff">'.number_format($rrev,0,',','.').'</td>
                                            <td class="kolom" style="text-align: center">'.number_format($rmnight_req,0,',','.').'</td>
                                            <td class="kolom" style="text-align: right">'.number_format($rrev_req,0,',','.').'</td>
                                        </tr>';
                                        }//endforeach property
                                        echo'
                                    </table>';
                    echo '</td>';
                    echo '<td style="width:650px;padding-left:10px">';
                    echo '<table border=1  style=" width:100%;font-size: 6pt">
                                            <tr>
                                                <td colspan="17" class="kolom">FORECAST - EXPECTED CLOSING</td>
                                            </tr>
                                            <tr>
                                                <td class="kolom"><div style="width: 80px"></div></td>';
                                           $dt_hotelprop = $this->ref_hotel_competitor_model->select_hotelcompetitor();
                                                for($i=0;$i<8;$i++){
                                        echo    '<td class="kolom" colspan="2" style=" text-align: center;">
                                                    <b>'.(date('d-F', strtotime($pertanggal . "+ $i day"))).'</b>
                                                </td>';
                                                 }//endfor
                                                 echo '
                                            </tr>';

                                            $seriticolor = "#ccffff";
                                            $serelacolor = "#00ccff";
                                            $bananacolor = "#00ff00";
                                            $goldencolor = "#ffcc00";
                                            $carrcadincolor = "#ffcccc";
                                            $bgcolor = "";
                                            foreach($dt_hotelprop->result() AS $row)
                                            {
                                                if(strtolower($row->hotelcompetitor_name) == "carrcadin" ||
                                                   strtolower($row->hotelcompetitor_name) == "grand seriti" ||
                                                   strtolower($row->hotelcompetitor_name) == "grand serela" ||
                                                   strtolower($row->hotelcompetitor_name) == "golden flower" ||
                                                   strtolower($row->hotelcompetitor_name) == "banana inn"){

                                             if(strtolower($row->hotelcompetitor_name) == "carrcadin"){
                                               $bgcolor = $carrcadincolor;
                                             }elseif(strtolower($row->hotelcompetitor_name) == "grand seriti"){
                                                $bgcolor = $seriticolor;
                                             }elseif(strtolower($row->hotelcompetitor_name) == "grand serela"){
                                                $bgcolor = $serelacolor;
                                             }elseif(strtolower($row->hotelcompetitor_name) == "banana inn"){
                                                $bgcolor = $bananacolor;
                                             }else {
                                                $bgcolor = $goldencolor;
                                             }//endif
                                                echo '<tr>';
                                               echo ' <td  style="background-color:'.$bgcolor.';width: 80px">'.$row->hotelcompetitor_name.'</td>';
                                                   for($i=0;$i<8;$i++){
                                                        $perdate =    (date('Y-m-d', strtotime($pertanggal . "+ $i day")));
                                                        $dt_forecast = $this->property_forecast_model->select_propertyforecast_by_hoteldate($row->idhotelcompetitor,$perdate);
                                                        $roomnight = 0;
                                                        $roominv = $row->room_inventory;
                                                        if($dt_forecast != NULL)
                                                        {
                                                            $roomnight = $dt_forecast->roomnights;
                                                        }
                                                 echo '
                                                <td class="kolom"  style="width: 25px;text-align: center;background-color:'.$bgcolor.'">';
                                                            echo $roomnight;
                                                echo '
                                                </td>
                                                <td class="kolom" style="width: 25px;text-align: center;background-color:'.$bgcolor.'"  >';
                                                     $occ = $roomnight / $roominv ;
                                                            echo number_format($occ * 100,1,'.',',');
                                                echo '%
                                                </td>';
                                                }//endfor
                                                echo '
                                            </tr>';
                                             }//endif
                                            }//endforeach
                                            echo '
                                        </table>';
                    echo '</td>';
                    echo '</tr>';
                    echo '</table>
                        </div>';
        }


       ?>

</body>
</html>
