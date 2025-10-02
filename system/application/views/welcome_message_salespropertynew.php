<html>
    <head>
       <?= $this->load->view('title');?>
        <?= $this->load->view('main_link'); ?>
        <link href="<?= base_url();?>css/jpaginate/style.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url()?>css/tab.css" type="text/css" media="screen" />
        <script type="text/javascript" src="<?= base_url();?>assets/js/swfobject.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>js/sorttable.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>js/jquery.paginate.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>js/jDashboardSalesProperty.js"></script>
        <style type="text/css">
            .demo{
                width:100%;
                border: 1px solid #fff;
            }
        </style>
    </head>
    <body>
        <script type="text/javascript">
            swfobject.embedSWF(
            "<?= base_url();?>assets/swf/open-flash-chart.swf", "grafik_hotel",
            "100%", "35%",
            "9.0.0", "expressInstall.swf",
            {"data-file":"<?= urlencode(site_url('welcome/graph_achievementbyhotel_sales_property')) ?>"},
            {wmode:"opaque"}
            );
            
          

            swfobject.embedSWF(
            "<?= base_url();?>assets/swf/open-flash-chart.swf", "grafik_company",
            "100%", "40%",
            "9.0.0", "expressInstall.swf",
            {"data-file":"<?= urlencode(site_url('welcome/get_categorycompanypersales_chart')) ?>"},
            {wmode:"opaque"}
            );

            swfobject.embedSWF(
            "<?= base_url();?>assets/swf/open-flash-chart.swf", "grafik_contact",
            "100%", "40%",
            "9.0.0", "expressInstall.swf",
            {"data-file":"<?= urlencode(site_url('welcome/get_categorycontactpersales_chart')) ?>"},
            {wmode:"opaque"}
            );

             

         

             swfobject.embedSWF(
            "<?= base_url();?>assets/swf/open-flash-chart.swf", "grafik_revenuebymarketsegment",
            "100%", "45%",
            "9.0.0", "expressInstall.swf",
            {"data-file":"<?= urlencode(site_url('welcome/get_revenuebysegmentpersales_chart')) ?>"},
            {wmode:"opaque"}
            );

            swfobject.embedSWF(
            "<?= base_url();?>assets/swf/open-flash-chart.swf", "grafik_salesindividual",
            "100%", "60%",
            "9.0.0", "expressInstall.swf",
            {"data-file":"<?= urlencode(site_url('welcome/graph_achievementbysalesindividual_persales_property')) ?>"},
            {wmode:"opaque"}
            );

            swfobject.embedSWF(
            "<?= base_url();?>assets/swf/open-flash-chart.swf", "grafik_salesgroup",
            "100%", "45%",
            "9.0.0", "expressInstall.swf",
            {"data-file":"<?= urlencode(site_url('welcome/graph_revenuebysalesgroup_sales_property')) ?>"},
            {wmode:"opaque"}
            );

            swfobject.embedSWF(
            "<?= base_url();?>assets/swf/open-flash-chart.swf", "grafik_revenuetotalhotel",
           "100%", "33%",
            "9.0.0", "expressInstall.swf",
            {"data-file":"<?= urlencode(site_url('welcome/graph_monthlyrevenue_sales_property')) ?>"},
            {wmode:"opaque"}
            );

           
            
   

            swfobject.embedSWF(
            "<?= base_url();?>assets/swf/open-flash-chart.swf", "grafik_slsactivityentertainment",
            "100%", "100%",
            "9.0.0", "expressInstall.swf",
            {"data-file":"<?= urlencode(site_url('welcome/get_salesactivity_entertainment')) ?>"},
            {wmode:"opaque"}
            );

          

            swfobject.embedSWF(
            "<?= base_url();?>assets/swf/open-flash-chart.swf", "grafiksalesactivity",
            "100%", "60%",
            "9.0.0", "expressInstall.swf",
            {"data-file":"<?= urlencode(site_url('welcome/get_salesactivityvssales_persalesproperty')) ?>"},
            {wmode:"opaque"}
            );

            swfobject.embedSWF(
            "<?= base_url();?>assets/swf/open-flash-chart.swf", "grafik_slsactivitysalescalldalamkota",
            "100%", "100%",
            "9.0.0", "expressInstall.swf",
            {"data-file":"<?= urlencode(site_url('welcome/get_salesactivity_salescalldalamkota')) ?>"},
            {wmode:"opaque"}
            );

            swfobject.embedSWF(
            "<?= base_url();?>assets/swf/open-flash-chart.swf", "grafik_customerprofile",
            "90%", "40%",
            "9.0.0", "expressInstall.swf",
            {"data-file":"<?= urlencode(site_url('welcome/get_customerprofile_persales')) ?>"},
            {wmode:"opaque"}
            );
        </script>
        <?= $this->load->view('main_header'); ?>
         <div class="content_wrap">
            <div class="box">
                <!-- Start Content Box -->
                <div class="content-box" style="width: 1050px">
                    <div class="content-box-header">
                        <h3>DASHBOARD</h3>
                        <ul class="content-box-tabs">
                            <li><a href="#tab1" class="default-tab">Achievement</a></li> <!-- href must be unique and match the id of target div -->
                            <li><a href="#tab2">Sales Activity</a></li>
                        </ul>
                    </div> <!-- End .content-box-header -->
                    <div class="content-box-content">
                        <div class="tab-content default-tab" id="tab1">
                            <div class="content960px2">
                    <div id="content_wrap">
                        <div class="homepagebox">
                            <div class="title_460px_2">
                                <h5>Achievement By Hotel</h5>
                            </div>
                            <div class="content460px_2">
                                <div id="containerlegend" style="float: right">
                                    <table align="center" style="text-align: center">
                                        <tr>
                                            <td style="background-color: #1e1ef1">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td style="font-size: 11px">&nbsp;Target&nbsp;&nbsp;&nbsp;</td>
                                            <td style="background-color: #fb0505">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td style="font-size: 11px">&nbsp;Confirm + Definit + Postponed&nbsp;&nbsp;&nbsp;</td>
                                            <td style="background-color: #64e923">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td style="font-size: 11px">&nbsp;Tentative + Postponed&nbsp;&nbsp;&nbsp;</td>
                                            <td style="background-color: #000000">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td style="font-size: 11px">&nbsp;Loss&nbsp;&nbsp;&nbsp;</td>
                                       </tr>
                                    </table>
                                </div>
                                <br/>
                                <div id="grafik_hotel">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="homepagebox">
                        <?php

                            $dt_hotel = $this->property_model->select_target_property();
                            $grandtotaltarget = 0;
                            $grand_total_definit = 0;
                            $grand_total_confirm = 0;
                            $grand_total_confirm_postponed = 0;
                            $grand_total_tentative = 0;
                            $grand_total_tentative_postponed = 0;
                            $grand_total_cancel = 0;
                            foreach ($dt_hotel->result() as $row) {
                                $totalcancel = 0;
                                $total_definit = 0;
                                $total_confirm = 0;
                                $total_confirmpostponed = 0;

                                $total_tentative = 0;
                                $total_tentativepostponed = 0;

                                $total_cancel = 0;
                                $grandtotaltarget += $row->amount;
                                //definit
                                $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'definit');
                                $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'definit');
                                $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'definit');
                                $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'definit');
                                $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'definit');
                                $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'definit');
                                $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'definit');
                                if ($roommeetingrevenue != null) {
                                    $total_definit += $roommeetingrevenue->RevRoomMeeting;
                                }
                                if ($roomonlyrevenue != null) {
                                    $total_definit += $roomonlyrevenue->RevRoomOnly; //oke
                                }
                                if ($packagerevenue != null) {
                                    $total_definit += $packagerevenue->RevPackage;
                                }
                                if ($additionalrevenue != null) {
                                    $total_definit += $additionalrevenue->RevAdditional;
                                }
                                if ($fnbrevenue != null) {
                                    $total_definit += $fnbrevenue->RevFB;
                                }
                                if ($roomrentalrevenue != null) {
                                    $total_definit += $roomrentalrevenue->RevRoomRental;
                                }
                                if ($stallrevenue != null) {
                                    $total_definit += $stallrevenue->RevStall;
                                }
                                $grand_total_definit += $total_definit;
                                //end definit
                                //confirm
                                $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'confirm');
                                $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'confirm');
                                $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'confirm');
                                $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'confirm');
                                $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'confirm');
                                $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'confirm');
                                $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'confirm');
                                if ($roommeetingrevenue != null) {
                                    $total_confirm += $roommeetingrevenue->RevRoomMeeting;
                                }
                                if ($roomonlyrevenue != null) {
                                    $total_confirm += $roomonlyrevenue->RevRoomOnly; //oke
                                }
                                if ($packagerevenue != null) {
                                    $total_confirm += $packagerevenue->RevPackage;
                                }
                                if ($additionalrevenue != null) {
                                    $total_confirm += $additionalrevenue->RevAdditional;
                                }
                                if ($fnbrevenue != null) {
                                    $total_confirm += $fnbrevenue->RevFB;
                                }
                                if ($roomrentalrevenue != null) {
                                    $total_confirm += $roomrentalrevenue->RevRoomRental;
                                }
                                if ($stallrevenue != null) {
                                    $total_confirm += $stallrevenue->RevStall;
                                }
                                $grand_total_confirm += $total_confirm;
                                //end confirm
                                //POSTPONED
                                $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'POSTPONED');
                                $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'POSTPONED');
                                $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'POSTPONED');
                                $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'POSTPONED');
                                $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'POSTPONED');
                                $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'POSTPONED');
                                $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'POSTPONED');
                                if ($roommeetingrevenue != null) {
                                    $total_confirmpostponed += $roommeetingrevenue->RevRoomMeeting;
                                }
                                if ($roomonlyrevenue != null) {
                                    $total_confirmpostponed += $roomonlyrevenue->RevRoomOnly; //oke
                                }
                                if ($packagerevenue != null) {
                                    $total_confirmpostponed += $packagerevenue->RevPackage;
                                }
                                if ($additionalrevenue != null) {
                                    $total_confirmpostponed += $additionalrevenue->RevAdditional;
                                }
                                if ($fnbrevenue != null) {
                                    $total_confirmpostponed += $fnbrevenue->RevFB;
                                }
                                if ($roomrentalrevenue != null) {
                                    $total_confirmpostponed += $roomrentalrevenue->RevRoomRental;
                                }
                                if ($stallrevenue != null) {
                                    $total_confirmpostponed += $stallrevenue->RevStall;
                                }
                                $grand_total_confirm_postponed += $total_confirmpostponed;
                                //end confirm POSTPONED


                                $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'offering');
                                $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'offering');
                                $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'offering');
                                $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'offering');
                                $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'offering');
                                $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'offering');
                                if ($roomonlyrevenue != null) {
                                    $total_tentative += $roomonlyrevenue->RevRoomOnly;
                                }
                                if ($additionalrevenue != null) {
                                    $total_tentative += $additionalrevenue->RevAdditional;
                                }
                                if ($packagerevenue != null) {
                                    $total_tentative += $packagerevenue->RevPackage;
                                }
                                if ($meetingrevenue != null) {
                                    $total_tentative += $meetingrevenue->RevMeetingPackage;
                                }
                                if ($roomrentalrevenue != null) {
                                    $total_tentative += $roomrentalrevenue->RevRoomRental;
                                }
                                if ($stallrevenue != null) {
                                    $total_tentative += $stallrevenue->RevStall;
                                }
                                 
                                $grand_total_tentative +=$total_tentative;

                                $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'postponed');
                                $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'postponed');
                                $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'postponed');
                                $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'postponed');
                                $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'postponed');
                                $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'postponed');
                                if ($roomonlyrevenue != null) {
                                    $total_tentativepostponed += $roomonlyrevenue->RevRoomOnly;
                                }
                                if ($additionalrevenue != null) {
                                    $total_tentativepostponed += $additionalrevenue->RevAdditional;
                                }
                                if ($packagerevenue != null) {
                                    $total_tentativepostponed += $packagerevenue->RevPackage;
                                }
                                if ($meetingrevenue != null) {
                                    $total_tentativepostponed += $meetingrevenue->RevMeetingPackage;
                                }
                                if ($roomrentalrevenue != null) {
                                    $total_tentativepostponed += $roomrentalrevenue->RevRoomRental;
                                }
                                if ($stallrevenue != null) {
                                    $total_tentativepostponed += $stallrevenue->RevStall;
                                }
                                 
                                $grand_total_tentative_postponed += $total_tentativepostponed;


                                ///////////Confirm LOSS///////////////
                                $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'LOSS');
                                $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'LOSS');
                                $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'LOSS');
                                $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'LOSS');
                                $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'LOSS');
                                $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'LOSS');
                                $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($row->idproperty,date('m'),date('Y'),'LOSS');
                                if ($roommeetingrevenue != null) {
                                    $total_cancel += $roommeetingrevenue->RevRoomMeeting;
                                }
                                if ($roomonlyrevenue != null) {
                                    $total_cancel += $roomonlyrevenue->RevRoomOnly; //oke
                                }
                                if ($packagerevenue != null) {
                                    $total_cancel += $packagerevenue->RevPackage;
                                }
                                if ($additionalrevenue != null) {
                                    $total_cancel += $additionalrevenue->RevAdditional;
                                }
                                if ($fnbrevenue != null) {
                                    $total_cancel += $fnbrevenue->RevFB;
                                }
                                if ($roomrentalrevenue != null) {
                                    $total_cancel += $roomrentalrevenue->RevRoomRental;
                                }
                                if ($stallrevenue != null) {
                                    $total_cancel += $stallrevenue->RevStall;
                                }
                                //END CONFIRM LOSS////////
                                //offering LOSS//
                                $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'LOSS');
                                $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'LOSS');
                                $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'LOSS');
                                $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'LOSS');
                                $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'LOSS');
                                $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($row->idproperty,date('m'),date('Y'),'LOSS');
                                if ($roomonlyrevenue != null) {
                                    $total_cancel += $roomonlyrevenue->RevRoomOnly;
                                }
                                if ($additionalrevenue != null) {
                                    $total_cancel += $additionalrevenue->RevAdditional;
                                }
                                if ($packagerevenue != null) {
                                    $total_cancel += $packagerevenue->RevPackage;
                                }
                                if ($meetingrevenue != null) {
                                    $total_cancel += $meetingrevenue->RevMeetingPackage;
                                }
                                if ($roomrentalrevenue != null) {
                                    $total_cancel += $roomrentalrevenue->RevRoomRental;
                                }
                                if ($stallrevenue != null) {
                                    $total_cancel += $stallrevenue->RevStall;
                                }
                                //end offering LOSS//

                                $grand_total_cancel += $total_cancel;
                            }
                        ?>
                            <div class="title_460px_2">
                                <h5>Monthly Revenue</h5>
                            </div>
                            <div class="content460px_2">
                                    <div id="containerlegend" style="float: right; ">
                                        <table align="center" style="text-align: center">
                                            <tr>
                                                <td style="background-color: #64e923">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td style="font-size: 11px">&nbsp;Tentative + Postponed&nbsp;&nbsp;&nbsp;</td>
                                                <td style="background-color: #fb0505">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td style="font-size: 11px">&nbsp;Confirm + Definit + Postponed&nbsp;&nbsp;&nbsp;</td>
                                                <td style="background-color: #000000">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                <td style="font-size: 11px">&nbsp;Loss&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div>
                                    <br/>
                                        <table width="43%" class=" " border="1px" style="font: 11px Tahoma;">
                                            <tr class="oddRow">
                                                <th colspan="2" style="border:1px solid black">Business Potential</th>
                                            </tr>
                                            <tr>
                                                <td style="border:1px solid black;">&nbsp;Target</td>
                                                <td style="border:1px solid black;text-align: right"><?= number_format($grandtotaltarget,0,',',','); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border:1px solid black">&nbsp;Potential Business</td>
                                                <td style="border:1px solid black;text-align: right" ><?= number_format($grand_total_definit + $grand_total_confirm +$grand_total_confirm_postponed+ $grand_total_tentative + $grand_total_tentative_postponed + $grand_total_cancel,0,',',','); ?>  </td>
                                            </tr>
                                        </table>
                                     </div>
                                    <div id="grafik_revenuetotalhotel"></div>
                            </div>
                        </div>
                    </div>
                     <br/><br/>
                     <div id="content_wrap">
                        <div class="homepagebox">
                             <div class="title_460px_2">
                                 <h5>Today's Loss Business</h5>
                             </div>
                             <div class="content460px_2" style="height: 220px">
                                 <div id="paginationcancel" class="demo">
                                     <input type="hidden" value="<?= $total_pagecancelpersales; ?>" id="totaldatacancel"/>
                                     <div id="pgc1" class="pagecancel _current"></div>
                                     <?php if($total_pagecancelpersales >= 1) {
                                                for($i=1;$i <= $total_pagecancelpersales;$i++) {
                                     ?>
                                     <div id="pgc<?= $i;?>" class="pagecancel" style="display:none;">
                                     </div>
                                     <?php      }//endfor
                                            }//endif
                                     ?>
                                     <?php if($total_pagecancelpersales > 0){ ?>
                                        <div id="page_cancel"></div>
                                     <?php }//endif?>
                                 </div>
                             </div>


                         </div>
                         <div class="homepagebox">
                             <div class="title_460px_2">
                                 <h5>Today's Confirm Business</h5>
                             </div>
                             <div class="content460px_2" style="height: 220px">
                                 <div id="paginationdemo" class="demo">
                                     <input type="hidden" value="<?= $total_pageconfirmpersales; ?>" id="totaldata"/>
                                     <div id="p1" class="pagedemo _current"></div>
                                     <?php if($total_pageconfirmpersales >= 1) {
                                                for($i=1;$i <= $total_pageconfirmpersales;$i++) {
                                     ?>
                                     <div id="p<?= $i;?>" class="pagedemo" style="display:none;"></div>
                                     <?php      }//endfor
                                            }//endif
                                     ?>
                                     <?php if($total_pageconfirmpersales > 0){ ?>
                                        <div id="page_confirm"></div>
                                     <?php }//endif?>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div id="content_wrap">
                         <div class="homepagebox">
                             <div class="title_460px_2">
                                 <h5>Collateral By Value</h5>
                             </div>
                             <div class="content460px_2">
                                 <div id="containerlegend" style="float: right">
                                    <table align="center" style="text-align: center">
                                        <tr>
                                            <td style="background-color: #1e1ef1">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td>&nbsp;Value&nbsp;&nbsp;&nbsp;</td>
                                            <td style="background-color: #fb0505">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td>&nbsp;Quantity&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                 </div>
                                 <br/>
                                 <div id="grafik_collateralbyvalue">

                                 </div>
                             </div>
                         </div>
                     </div>
                     <div id="content_wrap">
                         <div class="homepagebox">
                             <div class="title_460px_2">
                                 <h5>Revenue By Salesgroup</h5>
                             </div>
                             <div class="content460px_2">
                                 <div id="grafik_salesgroup"></div>
                             </div>
                         </div>
                         <div class="homepagebox" style="display: none">
                             <div class="title_460px_2">
                                 <h5>Revenue By Market Segment </h5>
                             </div>
                             <div class="content460px_2">
                                 <div id="containerlegend" style="float: right">
                                    <table align="center" style="text-align: center">
                                        <tr>
                                            <td style="background-color: #1e1ef1">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td>&nbsp;Target&nbsp;&nbsp;&nbsp;</td>
                                            <td style="background-color: #fb0505">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td>&nbsp;Confirm + Definit + Postponed&nbsp;&nbsp;&nbsp;</td>
                                            <td style="background-color: #000000">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td>&nbsp;Loss&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                 </div>
                                 <div id="grafik_revenuebymarketsegment">
                                    
                                 </div>
                             </div>
                         </div>
                     </div>
                      
                    <!-- Content wrapper -->
                     <br/>
                     <table class="dashboard" width="100%" style="display: none">
                        <tr class="oddRow">
                            <th colspan="3" class="tdtitle">Sales By Individual</th>
                        </tr>
                        <tr  class="subtitle3">
                            <td class="kolom" style="width: 110px">&nbsp;</td>
                            <td class="kolom" style="width: 360px">Confirm Bussiness</td>
                            <td>&nbsp;</td>
                        </tr>
                     </table>
                     <table width="100%" class="dashboard sortable" style="display: none">
                        <thead>
                            <tr class="subtitle3">
                                <td class="kolom kolom10" style="cursor: pointer">Sales</td>
                                <td class="kolom kolom10" style="cursor: pointer">Definit</td>
                                <td class="kolom kolom10" style="cursor: pointer">Confirm</td>
                                <td class="kolom kolom10" style="cursor: pointer">Total</td>
                                <td class="kolom kolom10" style="cursor: pointer">Tentative</td>
                                <td class="kolom kolom10" style="cursor: pointer">Cancel</td>
                                <td class="kolom kolom10" style="cursor: pointer">Target</td>
                                <td class="kolom kolom10" style="cursor: pointer">Balance</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $totalall = 0;
                        $totalallsalestentative = 0;
                        $totalallsalescancel = 0;
                        $totalbalancesales = 0;
                        $grand_total_definit_sales = 0;
                        $grand_total_confirm_sales = 0;
                        $grand_total_tentative_sales = 0;
                        $grand_total_cancel_sales = 0;
                        $tes = 0;
                        $totaltargetallsales = 0;
                        $dt_salesindividual = array();

                        foreach ($dt_salestarget AS $row):
                            $totalfbrev = 0;
                            $totalrm = 0;
                            $totalro = 0;
                            $totalpack = 0;
                            $totalslstentative = 0;
                            $totalslscancel = 0;
                            $total_definit_sales = 0;
                            $total_confirm_sales = 0;
                            $total_tentative_sales = 0;
                            $total_cancel_sales = 0;

                            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persales($row->idsales, date('m'), date('Y'), 'definit');
                            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persales($row->idsales, date('m'), date('Y'), 'definit');
                            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persales($row->idsales, date('m'), date('Y'), 'definit');
                            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persales($row->idsales, date('m'), date('Y'), 'definit');
                            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persales($row->idsales, date('m'), date('Y'), 'definit');
                            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persales($row->idsales, date('m'), date('Y'), 'definit');
                            $stallrevenue = $this->confirm_view_model->select_clrevstall_persales($row->idsales, date('m'), date('Y'), 'definit');

                            if ($roommeetingrevenue != null) {
                                $total_confirm_sales += $roommeetingrevenue->RevRoomMeeting;
                            }
                            if ($roomonlyrevenue != null) {
                                $total_confirm_sales += $roomonlyrevenue->RevRoomOnly; //oke
                            }
                            if ($packagerevenue != null) {
                                $total_confirm_sales += $packagerevenue->RevPackage;
                            }
                            if ($additionalrevenue != null) {
                                $total_confirm_sales += $additionalrevenue->RevAdditional;
                            }
                            if ($fnbrevenue != null) {
                                $total_confirm_sales += $fnbrevenue->RevFB;
                            }
                            if ($roomrentalrevenue != null) {
                                $total_confirm_sales += $roomrentalrevenue->RevRoomRental;
                            }
                            if ($stallrevenue != null) {
                                $total_confirm_sales += $stallrevenue->RevStall;
                            }
                            //////////////////////////////////////////
                            $grand_total_definit_sales += $total_definit_sales;

                            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persales($row->idsales, date('m'), date('Y'), 'confirm');
                            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persales($row->idsales, date('m'), date('Y'), 'confirm');
                            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persales($row->idsales, date('m'), date('Y'), 'confirm');
                            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persales($row->idsales, date('m'), date('Y'), 'confirm');
                            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persales($row->idsales, date('m'), date('Y'), 'confirm');
                            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persales($row->idsales, date('m'), date('Y'), 'confirm');
                            $stallrevenue = $this->confirm_view_model->select_clrevstall_persales($row->idsales, date('m'), date('Y'), 'confirm');

                            if ($roommeetingrevenue != null) {
                                $total_confirm_sales += $roommeetingrevenue->RevRoomMeeting;
                            }
                            if ($roomonlyrevenue != null) {
                                $total_confirm_sales += $roomonlyrevenue->RevRoomOnly; //oke
                            }
                            if ($packagerevenue != null) {
                                $total_confirm_sales += $packagerevenue->RevPackage;
                            }
                            if ($additionalrevenue != null) {
                                $total_confirm_sales += $additionalrevenue->RevAdditional;
                            }
                            if ($fnbrevenue != null) {
                                $total_confirm_sales += $fnbrevenue->RevFB;
                            }
                            if ($roomrentalrevenue != null) {
                                $total_confirm_sales += $roomrentalrevenue->RevRoomRental;
                            }
                            if ($stallrevenue != null) {
                                $total_confirm_sales += $stallrevenue->RevStall;
                            }
                            //////////////////////////////////////////
                            $grand_total_confirm_sales += $total_confirm_sales;

                            $dt_roomonly_offer = $this->offering_view_model->select_revroomonly_persales($row->idsales ,date('m'),date('Y'),'offering');
                            if($dt_roomonly_offer != null) {
                                $total_tentative_sales += $dt_roomonly_offer->RevRoomOnly;
                            }
                            $dt_additional_offer = $this->offering_view_model->select_revadditional_persales($row->idsales ,date('m'),date('Y'),'offering');
                            if($dt_additional_offer != null) {
                                $total_tentative_sales += $dt_additional_offer->RevAdditional;
                            }
                            $dt_package_offer = $this->offering_view_model->select_revpackage_persales($row->idsales ,date('m'),date('Y'),'offering');
                            if($dt_package_offer != null) {
                                $total_tentative_sales += $dt_package_offer->RevPackage;
                            }
                            $dt_meetingpackage_offer = $this->offering_view_model->select_revmeetingpackage_persales($row->idsales ,date('m'),date('Y'),'offering');
                            if($dt_meetingpackage_offer != null) {
                                $total_tentative_sales += $dt_meetingpackage_offer->RevMeetingPackage;
                            }
                            
                            $dt_roomrental_offer = $this->offering_view_model->select_revroomrental_persales($row->idsales ,date('m'),date('Y'),'offering');
                            if($dt_roomrental_offer != null) {
                                $total_tentative_sales += $dt_roomrental_offer->RevRoomRental;
                            }
                            
                             $dt_stall_offer = $this->offering_view_model->select_revstall_persales($row->idsales ,date('m'),date('Y'),'offering');
                            if($dt_stall_offer != null) {
                                $total_tentative_sales += $dt_stall_offer->RevStall;
                            }

                            $grand_total_tentative_sales += $total_tentative_sales;

                             $dt_roomonly_offer = $this->offering_view_model->select_revroomonly_persales($row->idsales ,date('m'),date('Y'),'LOSS');
                            if($dt_roomonly_offer != null) {
                                $total_cancel_sales += $dt_roomonly_offer->RevRoomOnly;
                            }
                            $dt_additional_offer = $this->offering_view_model->select_revadditional_persales($row->idsales ,date('m'),date('Y'),'LOSS');
                            if($dt_additional_offer != null) {
                                $total_cancel_sales += $dt_additional_offer->RevAdditional;
                            }
                            $dt_package_offer = $this->offering_view_model->select_revpackage_persales($row->idsales ,date('m'),date('Y'),'LOSS');
                            if($dt_package_offer != null) {
                                $total_cancel_sales += $dt_package_offer->RevPackage;
                            }
                            $dt_meetingpackage_offer = $this->offering_view_model->select_revmeetingpackage_persales($row->idsales ,date('m'),date('Y'),'LOSS');
                            if($dt_meetingpackage_offer != null) {
                                $total_cancel_sales += $dt_meetingpackage_offer->RevMeetingPackage;
                            }

                            $dt_roomrental_offer = $this->offering_view_model->select_revroomrental_persales($row->idsales ,date('m'),date('Y'),'LOSS');
                            if($dt_roomrental_offer != null) {
                                $total_cancel_sales += $dt_roomrental_offer->RevRoomRental;
                            }

                            $dt_stall_offer = $this->offering_view_model->select_revstall_persales($row->idsales ,date('m'),date('Y'),'LOSS');
                            if($dt_stall_offer != null) {
                                $total_cancel_sales += $dt_stall_offer->RevStall;
                            }

                             
                            //////////////////////////////////////////
                            $grand_total_cancel_sales += $total_cancel_sales;

                            $dt_target = $this->report_model->select_target_person(date('F'),date('Y'),$row->idsales);
                            $salestarget = 0;
                            $balance = 0;
                            if($dt_target != null) {
                               // echo number_format($dt_target->amount,0,',',',');
                                $salestarget = $dt_target->amount;
                                $totaltargetallsales += $salestarget;
                            }else {
                               // echo 0;
                            }

                            if($dt_target != null) {
                                $totalbalancesales += $dt_target->amount-($total_definit_sales);
                                //echo number_format($dt_target->amount-($total_definit_sales+$total_confirm_sales),0,',',',');
                                $balance = number_format($dt_target->amount-($total_definit_sales + $total_confirm_sales),0,',','');
                            }else {
                                //echo 0;
                            }

                            $total = (number_format($total_definit_sales,0,',','')) + (number_format($total_confirm_sales,0,',',''));
                            if($total <= 0)
                            {
                              $total = '-';
                            }
                            $totalall += $total;

                            $dt_salesindividual[] =
                            array('sales'=>$row->firstname .' ('.$row->initial.')',
                                  'definit'=>number_format($total_definit_sales,0,',',''),
                                  'confirm'=>$total_confirm_sales,
                                  //'total'=>(number_format($total_definit_sales,0,',','')) + (number_format($total_confirm_sales,0,',','')),
                                  'total'=>$total,
                                  'tentative'=>$total_tentative_sales,
                                  'cancel'=>$total_cancel_sales,
                                  'target'=>$salestarget,
                                  'balance'=>$balance);

                            $dt_saleslegend[] = array('photofile'=>$row->photofilename,
                                                      'sales'=>$row->firstname .' ('.$row->initial.')',
                                                      'total'=>$total
                                                      );
                            ?>
                            <? endforeach;?>
                            <?php
                                function msort($array, $id="id") {
                                    $temp_array = array();
                                    while(count($array) > 0) {
                                        $lowest_id = 0;
                                        $index=0;
                                        foreach ($array as $item) {
                                            if (isset($item[$id]) && $array[$lowest_id][$id]) {
                                                if ($item[$id] > $array[$lowest_id][$id]) {
                                                    $lowest_id = $index;
                                                }
                                            }
                                            $index++;
                                        }
                                        $temp_array[] = $array[$lowest_id];
                                        $array = array_merge(array_slice($array, 0,$lowest_id), array_slice($array, $lowest_id+1));
                                    }
                                    return $temp_array;
                                }
                                ?>
                            <?php
                               $dt_sorted =  msort($dt_salesindividual,'total' );
                               foreach($dt_sorted AS $key=>$val)
                               {
                               
                            ?>
                            <tr>
                                <td class="kolom kolom10"><?= $val['sales']?></td>
                                <td class="kolom kolom10" style="text-align: right">
                                       <?= number_format($val['definit'],0,',',',');?>
                                </td>
                                <td class="kolom kolom10"  style="text-align: right">
                                      <?= number_format($val['confirm'],0,',',',');?>
                                </td>
                                <td class="kolom kolom10"  style="text-align: right">
                                       <?= number_format($val['total'],0,',',',');?>
                                </td>
                                <td class="kolom kolom10"  style="text-align: right">
                                      <?= number_format($val['tentative'],0,',',',');?>
                                </td>
                                <td class="kolom kolom10"  style="text-align: right">
                                         <?= number_format($val['cancel'],0,',',',');?>
                                </td>
                                <td class="kolom kolom10"  style="text-align: right">
                                      <?= number_format($val['target'],0,',',',');?>
                                </td>
                                <td class="kolom kolom10"  style="text-align: right">
                                      <?= number_format($val['balance'],0,',',',');?>
                                </td>
                            </tr>
                            <?php } //endforeach array sorted ?>
                        </tbody>
                        <tr>
                            <td class="kolom"><b>Total</b></td>
                            <td class="kolom"  style="text-align: right"><b><?= number_format($grand_total_definit_sales,0,',',','); ?></b></td>
                            <td class="kolom"  style="text-align: right"><b><?= number_format($grand_total_confirm_sales,0,',',','); ?></b></td>
                            <td class="kolom"  style="text-align: right"><b><?= number_format($grand_total_definit_sales+$grand_total_confirm_sales,0,',','.'); ?></b></td>
                            <td class="kolom"  style="text-align: right"><b><?= number_format($grand_total_tentative_sales,0,',',','); ?></b></td>
                            <td class="kolom"  style="text-align: right"><b><?= number_format($grand_total_cancel_sales,0,',',','); ?></b></td>
                            <td class="kolom"  style="text-align: right"><b><?= number_format($totaltargetallsales,0,',',','); ?></b></td>
                            <td class="kolom"  style="text-align: right"><b><?= number_format($totalbalancesales,0,',',','); ?></b></td>
                        </tr>
                    </table>

                     <div id="content_wrap">
                         <div class="homepagebox">
                             <div class="title_940px_2">
                                 <h5>Achievement By Sales Individual</h5>
                             </div>
                             <div class="content940px_2">
                                 <div id="grafik_salesindividual"></div>
                                 
                             </div>
                         </div>
                     </div>

                     
                    <br/>
                  

                    

                    <div id="content_wrap">
                    <div class="content900px">
                        <table width="100%" class="dashboard">
                            <tr class="oddRow">
                                <td colspan="7" class="tdtitle"><b>Follow Up Your Offering Letter</b></td>
                            </tr>
                            <? if($data_offering  != null) { ?>
                            <tr class="subtitle">
                                <th class="kolom kolom20">Date Of Event</th>
                                <th class="kolom kolom5" style="text-align: center">OL</th>
                                <th class="kolom kolom5" style="text-align: center">Hotel</th>
                                <th class="kolom kolom30">Company</th>
                                <th class="kolom kolom20">Contact</th>
                                <th class="kolom kolom20">Event Name</th>
                                <th class="kolom kolom5">Pax</th>
                                <th class="kolom kolom10">Revenue</th>
                            </tr>
                                <?
                                $index = 1;
                                $totalrevenueall = 0;
                                foreach($data_offering AS $row) {
                                    $index++;
                                    if($index%2 == 0) {
                                        $tr = '<tr class="oddRow">';
                                    }
                                    else {
                                        $tr = '<tr class="">';
                                    }
                                    $totalrevenue = 0;
                                    $additionalrevenue = $this->offering_view_model->select_additionalrevenue_peroffering($row->offeringnumber);
                                    $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_peroffering($row->offeringnumber);
                                    $packagerevenue = $this->offering_view_model->select_packagerevenue_peroffering($row->offeringnumber);
                                    $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_peroffering($row->offeringnumber);
                                    $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_peroffering($row->offeringnumber);
                                    $stallrevenue = $this->offering_view_model->select_stallrevenue_peroffering($row->offeringnumber);

                                    if($roomonlyrevenue != null) {
                                        $totalrevenue += $roomonlyrevenue->RevRoomOnly;
                                    }
                                    if($additionalrevenue != null) {
                                        $totalrevenue += $additionalrevenue->RevAdditional;
                                    }
                                    if($packagerevenue != null) {
                                        $totalrevenue += $packagerevenue->RevPackage;
                                    }
                                    if($meetingrevenue != null) {
                                        $totalrevenue += $meetingrevenue->RevMeetingPackage;
                                    }
                                    if($roomrentalrevenue != null) {
                                        $totalrevenue += $roomrentalrevenue->RevRoomRental;
                                    }
                                    if($stallrevenue != null) {
                                        $totalrevenue += $stallrevenue->RevStall;
                                    }
                                    $totalrevenueall += $totalrevenue;
                                    echo
                                    $tr.'
                                            <td class="kolom  ">'.format_waktu2($row->checkin_date).' - '.format_waktu2($row->checkout_date).'</td>
                                            <td class="kolom  " style="text-align: center">'.$row->offeringnumber.'</td>
                                            <td class="kolom  " style="text-align: center">'.$row->idproperty_FK.'</td>
                                            <td class="kolom  ">'.$row->account_name.'</td>
                                            <td class="kolom  ">'.$row->firstname.' '.$row->lastname.'</td>
                                            <td class="kolom  ">'.$row->event_name.'</td>
                                            <td class="kolom  ">'.$row->pax.'</td>
                                            <td class="kolom  " style="text-align:right">'.number_format($totalrevenue,0,',','.').'</td>
                                    </tr>';
                                }//end foreach
                                ?>
                            <tr>
                                <td colspan="7" class="kolom" style="text-align: center;font-weight: bold">Total</td>
                                <td class="kolom" style="font-weight: bold;text-align: right"><?=number_format($totalrevenueall,0,',','.')?></td>
                            </tr>
                                <?
                            } else {
                                ?>
                            <td colspan="8" class="tdtitle">Data Not Available</td>
                                <?
                            }
                            ?>
                        </table>
                        <br />
                        <table width="100%" class="dashboard">
                            <tr class="oddRow">
                                <td colspan="8" class="tdtitle"><b>My Confirm Business</b></td>
                            </tr>
                            <? if($dataconfirmletter_by_sales  != null) { ?>
                            <tr class="subtitle">
                                <th class="kolom kolom20">Date Of Event</th>
                                <th class="kolom kolom5" style="text-align: center">CL</th>
                                <th class="kolom kolom5">Hotel</th>
                                <th class="kolom kolom30">Company</th>
                                <th class="kolom kolom20">Contact</th>
                                <th class="kolom kolom20">Event Name</th>
                                <th class="kolom kolom5">Pax</th>
                                <th class="kolom kolom10">Revenue</th>
                            </tr>
                                <?
                                $index = 1;
                                $totalallconfirm = 0;
                                $totalalldefinit = 0;
                                $totalall = 0;
                                foreach($dataconfirmletter_by_sales AS $row) {
                                    $index++;
                                    if($index%2 == 0) {
                                        $tr = '<tr class="oddRow">';
                                    }
                                    else {
                                        $tr = '<tr class="">';
                                    }
                                    $totalrevenueconfirm = 0;

                                    $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue2_byconfirm( $row->confirmnum);
                                    $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue2_byconfirm(  $row->confirmnum);
                                    $packagerevenue = $this->confirm_view_model->select_packagerevenue2_byconfirm( $row->confirmnum);
                                    $additionalrevenue = $this->confirm_view_model->select_additionalrevenue2_byconfirm(  $row->confirmnum);
                                    $fnbrevenue = $this->confirm_view_model->select_fnbrevenue2_byconfirm( $row->confirmnum);
                                    $roomrental = $this->confirm_view_model->select_roomrentalrevenue2_byconfirm( $row->confirmnum);
                                    $stall = $this->confirm_view_model->select_stallrevenue2_byconfirm( $row->confirmnum);
                                    if($roommeetingrevenue != null) {
                                        $totalrevenueconfirm += $roommeetingrevenue->RoomMeeting;
                                    }
                                    if($roomonlyrevenue != null) {
                                        $totalrevenueconfirm += $roomonlyrevenue->RoomOnly; //oke
                                    }
                                    if($packagerevenue != null) {
                                        $totalrevenueconfirm += $packagerevenue->PackageRevenue;
                                    }
                                    if($additionalrevenue != null) {
                                        $totalrevenueconfirm += $additionalrevenue->AddtionalRevenue;
                                    }
                                    if($fnbrevenue != null) {
                                        $totalrevenueconfirm += $fnbrevenue->FBRevenue;
                                    }
                                    if($roomrental != null) {
                                        $totalrevenueconfirm += $roomrental->RevenueRoomRental;
                                    }
                                    if($stall != null) {
                                        $totalrevenueconfirm += $stall->RevStall;
                                    }
                                    $totalrevenuedefinit = 0;
                                    
//                                    $roommeetingrevenuedefinit = $this->confirm_view_model->select_roommeetingmeetingrevenue_byconfirm('definit', $row->confirmnum);
//                                    $roomonlyrevenuedefinit = $this->confirm_view_model->select_roomonlyrevenue_byconfirm('definit', $row->confirmnum);
//                                    $packagerevenuedefinit = $this->confirm_view_model->select_packagerevenue_byconfirm('definit', $row->confirmnum);
//                                    $additionalrevenuedefinit = $this->confirm_view_model->select_additionalrevenue_byconfirm('definit',  $row->confirmnum);
//                                    $fnbrevenuedefinit = $this->confirm_view_model->select_fnbrevenue_byconfirm('definit',  $row->confirmnum);
//                                    $roomrental = $this->confirm_view_model->select_roomrentalrevenue_byconfirm('definit',$row->confirmnum);
////
//                                    if($roommeetingrevenuedefinit != null) {
//                                        $totalrevenuedefinit += $roommeetingrevenuedefinit->RoomMeeting;
//                                    }
//                                    if($roomonlyrevenuedefinit != null) {
//                                        $totalrevenuedefinit += $roomonlyrevenuedefinit->RoomOnly; //oke
//                                    }
//                                    if($packagerevenuedefinit != null) {
//                                        $totalrevenuedefinit += $packagerevenuedefinit->PackageRevenue;
//                                    }
//                                    if($additionalrevenuedefinit != null) {
//                                        $totalrevenuedefinit += $additionalrevenuedefinit->AddtionalRevenue;
//                                    }
//                                    if($fnbrevenuedefinit != null) {
//                                        $totalrevenuedefinit += $fnbrevenuedefinit->FBRevenue;
//                                    }
//                                    if($roomrental != null) {
//                                        $totalrevenuedefinit += $roomrental->RevenueRoomRental;
//                                    }

                                    $totalallconfirm += $totalrevenueconfirm;
                                    $totalalldefinit += $totalrevenuedefinit;
                                    $totalall = $totalallconfirm+$totalalldefinit;
                                    $totalcondef = $totalrevenueconfirm + $totalrevenuedefinit;
                                    echo
                                    $tr.'
                                            <td class="kolom  ">'.format_waktu2($row->cidate).' - '.format_waktu2($row->codate).'</td>
                                            <td class="kolom  " style="text-align: center">'.$row->confirmnum.' '.$row->confirm_status.'</td>
                                            <td class="kolom  " style="text-align: center">'.$row->idproperty_FK.'</td>
                                            <td class="kolom  ">'.$row->account.'</td>
                                            <td class="kolom  ">'.$row->confirstname.' '.$row->conlastname.'</td>
                                            <td class="kolom  ">'.$row->event_name.'</td>
                                            <td class="kolom  ">'.$row->pax.'</td>
                                            <td class="kolom  " style="text-align:right">'.number_format($totalcondef,0,',','.').'</td>
                                    </tr>';
                                }//end foreach
                                ?>
                            <tr>
                                <td colspan="7" class="kolom" style="text-align: center;font-weight: bold">Total</td>
                                <td class="kolom" style="font-weight: bold;text-align:right"><?=number_format($totalall,0,',','.')?></td>
                            </tr>
                                <?
                            } else {
                                ?>
                            <td colspan="8" class="tdtitle">Data Not Available</td>
                                <?
                            }
                            ?>
                        </table>
                    </div>
                         <div id="content_wrap">
                    <div class="content500px">
                        <table width="100%" class="dashboard">
                            <tr class="oddRow">
                                <td colspan="3" class="tdtitle"><b>My To-Do List</b></td>
                            </tr>
                            <tr class="subtitle">
                                <th class="kolom kolom35">Subject</th>
                                <th class="kolom kolom10">Date</th>
                                <th class="kolom kolom50">Activities</th>
                            </tr>
                            <?
                            $index = 1;
                            foreach($dt_telemarketing AS $rowtele) {
                                $index++;
                                if($index%2 == 0) {
                                    $tr = '<tr class="oddRow">';
                                }
                                else {
                                    $tr = '<tr>';
                                }
                                echo $tr;
                                echo'<td class="kolom kolom35"><b>[Sales Call]</b> '. strip_tags($rowtele->account_name) .', '.$rowtele->salutation.' '.$rowtele->firstname.' '.$rowtele->lastname.'</td>
                                     <td class="kolom kolom10">'. format_waktu2($rowtele->dateappt) .'</td>
                                     <td class="kolom kolom50">'. strip_tags($rowtele->notes) .'</td>
                                     </tr>';
                            }
                            foreach($dt_last_call AS $rowlast) {
                                $index++;
                                if($index%2 == 0) {
                                    $tr = '<tr class="oddRow">';
                                }
                                else {
                                    $tr = '<tr>';
                                }
                                echo $tr;
                                echo'<td class="kolom kolom35"><b>[Sales Call]</b>'. strip_tags($rowlast->account_name) .', '.$rowlast->salutation.' '.$rowlast->confirstname.' '.$rowlast->conlastname.'</td>
                                     <td class="kolom kolom10">'. format_waktu2($rowlast->datecall) .'</td>
                                     <td class="kolom kolom50">'. strip_tags($rowlast->activities) .'</td>
                                     </tr>';
                            }

                            foreach($data_et AS $rowenter) {
                                $index++;
                                if($index%2 == 0) {
                                    $tr = '<tr class="oddRow">';
                                }
                                else {
                                    $tr = '<tr>';
                                }
                                echo $tr;
                                echo'<td class="kolom kolom35"><b>[Entertainment]</b> '.strip_tags($rowenter->account_name).', '.$rowenter->nama_prop.', '.$rowenter->place.'</td>
                                     <td class="kolom kolom10">'. format_waktu2($rowenter->dateent) .'</td>
                                     <td class="kolom kolom50">'. strip_tags($rowenter->reason) .'</td>
                                     </tr>';
                            }
                            foreach($data_othact AS $rowoa) {
                                $index++;
                                if($index%2 == 0) {
                                    $tr = '<tr class="oddRow">';
                                }
                                else {
                                    $tr = '<tr>';
                                }
                                echo $tr;
                                echo'<td class="kolom kolom35"><b>[Other Act.]</b> '. $rowoa->nama_prop .', '.strip_tags($rowoa->actlist).'</td>
                                     <td class="kolom kolom10">'. format_waktu2($rowoa->dateact) .'</td>
                                     <td class="kolom kolom50">'. strip_tags($rowoa->deskripsi) .'</td>
                                     </tr>';
                            }
                            foreach($dt_task AS $row) {
                                $index++;
                                if($index%2 == 0) {
                                    $tr = '<tr class="oddRow">';
                                }
                                else {
                                    $tr = '<tr>';
                                }
                                echo $tr;
                                echo'<td class="kolom kolom35"><b>[Task]</b> '. strip_tags($row->subject) .'</td>
                                     <td class="kolom kolom10">'. format_waktu2($row->taskdate) .'</td>
                                     <td class="kolom kolom50">'. strip_tags($row->activities) .'</td>
                                     </tr>';
                            }

                            ?>
                        </table>
                    </div>
                                   </div>
                                   <div id="content_wrap">
                    <div class="content500px">
                        <table width="100%" class="dashboard">
                            <tr class="oddRow">
                                <td colspan="6" class="tdtitle"><b>Your Statistics This Month</b></td>
                            </tr>
                            <tr class="subtitle">
                                <th class="kolom kolom15">Company</th>
                                <th class="kolom kolom20">Contact</th>
                                <th class="kolom kolom20">Offering</th>
                                <th class="kolom kolom10">Loss</th>
                                <th class="kolom kolom10">Confirm</th>
                                <th class="kolom kolom30">Telemarketing</th>
                            </tr>

                            <tr>
                                <td class="kolom kolom10"><?= $dt_count_account->totalAccount;?></td>
                                <td class="kolom kolom10"><?= $dt_count_contact->totalContact;?></td>
                                <td class="kolom kolom20"><?= $dt_count_ol->totalLetterOffering;?></td>
                                <td class="kolom kolom10"><?= $dt_count_cancel->totalLetter;?></td>
                                <td class="kolom kolom10"><?= $dt_count_confirm->totalLetter;?></td>
                                <td class="kolom kolom10"><?= $dt_count_telemarketing->totalTelemarketing + $dt_count_lastminutes->totalLastMinutes;?></td>
                            </tr>
                        </table>
                    </div>
                    </div>
                                   </div>
                    <br/><br/>
                </div><!-- END DIV 960-->
                        </div>
                        <!-- End #tab1 -->
                        <div class="tab-content" id="tab2">
                            <div class="content960px2">
                            <div id="content_wrap">
                                <div class="homepagebox">
                                        <div class="title_940px_2" >
                                            <h5>Activities Vs. Sales</h5>
                                        </div>
                                        <div class="content940px_2">
                                            <div id="grafiksalesactivity"></div>
                                        </div>
                                </div>
                                <div class="homepagebox">
                                                <div class="title_940px_2" >
                                                    <h5>Database Outlook</h5>
                                                </div>
                                                <div class="content940px_2">
                                                    <div class="homepagebox" >
                                                        <div class="content300px_2" >
                                                            <div id="containerlegend" style="float: right">
                                                                <table align="center" style="text-align: center">
                                                                    <tr>
                                                                        <td style="background-color: #f00101">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td>&nbsp;Suspect&nbsp;&nbsp;&nbsp;</td>
                                                                        <td style="background-color: #057a02">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td>&nbsp;Prospect&nbsp;&nbsp;&nbsp;</td>
                                                                        <td style="background-color: #3482ec">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td>&nbsp;Client&nbsp;&nbsp;&nbsp;</td>
                                                                        <!--
                                                                        <td style="background-color: #e3d104">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td>&nbsp;Target</td>
                                                                        -->
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div id="grafik_company"></div>
                                                        </div>
                                                    </div>
                                                    <div class="homepagebox">
                                                        <div class="content300px_2">
                                                            <div id="containerlegend" style="float: right">
                                                                <table align="center" style="text-align: center">
                                                                    <tr>
                                                                        <td style="background-color: #f00101">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td>&nbsp;Suspect&nbsp;&nbsp;&nbsp;</td>
                                                                        <td style="background-color: #057a02">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td>&nbsp;Prospect&nbsp;&nbsp;&nbsp;</td>
                                                                        <td style="background-color: #3482ec">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td>&nbsp;Client&nbsp;&nbsp;&nbsp;</td>
                                                                        <!--
                                                                        <td style="background-color: #e3d104">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td>&nbsp;Target</td>
                                                                        -->
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div id="grafik_contact"></div>
                                                        </div>
                                                    </div>
                                                    <div class="homepagebox">
                                                        <div class="content300px_2">
                                                            <div id="containerlegend" style="float: right">
                                                                <table align="center" style="text-align: center">
                                                                    <tr>
                                                                        <td style="background-color: #ff0000">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td>&nbsp;Non Active&nbsp;&nbsp;&nbsp;</td>
                                                                        <td style="background-color: #ffcc66">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td>&nbsp;Regular&nbsp;&nbsp;&nbsp;</td>
                                                                        <td style="background-color: #00cc00">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td>&nbsp;Active&nbsp;&nbsp;&nbsp;</td>
                                                                        <!--
                                                                        <td style="background-color: #e3d104">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td>&nbsp;Target</td>
                                                                        -->
                                                                    </tr>
                                                                </table>
                                                                
                                                            </div>
                                                            <div id="grafik_customerprofile"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                            <div class="homepagebox">
                             <div class="title_940px_2">
                                 <h5>Sales Activity </h5>
                             </div>
                             <div class="content940px_2">
                                 <table class="dashboard" style="display: none">
                                     <tr class="oddRow">
                                         <th style="text-align: center">Sales</th>
                                         <?php foreach($dt_actsales AS $rowact){?>
                                            <th colspan="2" style="text-align: center"><?= $rowact->slsbudgetname;?></th>
                                         <?php }//endactsale ?>
                                     </tr>
                                     <tr>
                                         <th></th>
                                         <?php foreach($dt_actsales AS $rowact){?>
                                            <th style="text-align: center">Target</th>
                                            <th style="text-align: center">Actual</th>
                                          <?php }//endactsale ?>
                                     </tr>
                                     <?php
                                     foreach($dt_salesactivepersegment AS $rowslsact){?>
                                     <tr class="additionRow">
                                         <td class="kolom"><?= strip_tags($rowslsact->firstname); ?> <?= strip_tags($rowslsact->lastname); ?></td>
                                         <?php
                                         $totalactual = 0;
                                         $totaltarget = 0;
                                         $act_acc = 0;
                                         $tgt_acc = 0;

                                         $act_tel = 0;
                                         $tgt_tel = 0;

                                         $act_ent = 0;
                                         $tgt_ent = 0;

                                         $act_com = 0;
                                         $tgt_com = 0;

                                         $act_slsdlmkota = 0;
                                         $tgt_slsdlmkota = 0;

                                         $act_slsluarkota = 0;
                                         $tgt_slsluarkota = 0;
                                         foreach($dt_actsales AS $rowact){?>
                                             <?php
                                                 $days_in_month = date('t');
                                                 $dt_slsactamount = $this->sales_act_budget_model->select_amount_persalesactivitymonthyearstatus($rowslsact->idsales,$rowact->idslsbudget,date('m'),date('Y'),'Active');
                                                 $amountact = 0;
                                                 if($dt_slsactamount != NULL)
                                                 {
                                                     $amountact = $dt_slsactamount->jumlah;
                                                 }

                                                 $target = ($amountact / $days_in_month) * date('d');
                                                 //$actualaccount = $this->account_model->select_todays_account(date('Y-m-d'),$rowslsact->id);
                                                 $actualaccount = $this->account_model->select_currentmonth_account(date('m'),$rowslsact->idsales);

                                                 //$actualtele = $this->telemarketing_model->select_todays_telemarketing(date('Y-m-d'),$rowslsact->id);
                                                 $actualtele = $this->telemarketing_model->select_currentmonth_telemarketing(date('m'),$rowslsact->idsales);

                                                 //$actualenter = $this->entertainment_model->select_todays_entertainment(date('Y-m-d'),$rowslsact->id);
                                                 $actualenter = $this->entertainment_model->select_currentmonth_entertainment(date('m'),$rowslsact->idsales);

                                                 //$actualcompliment = $this->complimentary_model->select_todays_compliment(date('Y-m-d'),$rowslsact->id);
                                                 $actualcompliment = $this->complimentary_model->select_currentmonth_compliment(date('m'),$rowslsact->idsales);

                                                 //$actualsalesdlmkota = $this->sales_call_model->select_todaysalescall_dalamkota(date('Y-m-d'),$rowslsact->id);
                                                 $actualsalesdlmkota = $this->sales_call_model->select_currentmonthsalescall_dalamkota(date('m'),$rowslsact->idsales);

                                                 //$actualsalesluarkota = $this->sales_call_model->select_currentmonthsalescall_luarkota(date('Y-m-d'),$rowslsact->id);
                                                 $actualsalesluarkota = $this->sales_call_model->select_currentmonthsalescall_luarkota(date('m'),$rowslsact->idsales);

                                                 $actual = 0;
                                                 if($rowact->slsbudgetname == 'Account'){
                                                     if($actualaccount != NULL){
                                                        $actual = $actualaccount->Total;
                                                        $totalactual += $actual;
                                                        $act_acc = $actual;
                                                        $tgt_acc = $target;
                                                     }
                                                 }
                                                 if($rowact->slsbudgetname == 'Telemarketing'){
                                                     if($actualtele != NULL){
                                                        $actual = $actualtele->Total;
                                                        $totalactual += $actual;
                                                        $act_tel = $actual;
                                                        $tgt_tel = $target;
                                                     }
                                                 }
                                                 if($rowact->slsbudgetname == 'Entertainment'){
                                                     if($actualenter != NULL){
                                                         $actual = $actualenter->Total;
                                                         $totalactual += $actual;
                                                         $act_ent = $actual;
                                                         $tgt_ent = $target;
                                                     }
                                                 }
                                                 if($rowact->slsbudgetname == 'Compliment'){
                                                     if($actualcompliment != NULL){
                                                          $actual = $actualcompliment->Total;
                                                          $totalactual += $actual;
                                                          $act_com = $actual;
                                                          $tgt_com = $target;
                                                     }
                                                 }
                                                 if($rowact->slsbudgetname == 'Sales Call Dalam Kota'){
                                                     if($actualsalesdlmkota != NULL){
                                                         $actual = $actualsalesdlmkota->Total;
                                                         $totalactual += $actual;
                                                         $act_slsdlmkota = $actual;
                                                         $tgt_slsdlmkota = $target;
                                                     }
                                                 }
                                                 if($rowact->slsbudgetname == 'Sales Call Luar Kota'){
                                                     if($actualsalesluarkota != NULL){
                                                          $actual = $actualsalesluarkota->Total;
                                                          $totalactual += $actual;
                                                          $act_slsluarkota = $actual;
                                                          $tgt_slsluarkota = $target;
                                                     }
                                                 }
                                                 $totaltarget += ceil($target);
                                                 ?>
                                             <td class="kolom" style="text-align: center"><?php echo ceil($target);//if($dt_slsactamount != NULL){echo $dt_slsactamount->jumlah;}else{echo '-';}; ?></td>
                                             <td class="kolom" style="text-align: center"><?= $actual;?>  </td>
                                          <?php }//endactsale
                                                $slsact = $totalactual - $totaltarget;
                                                $dt_salesxx[] = array('sales'=>strip_tags($rowslsact->firstname).' '.strip_tags($rowslsact->lastname),
                                                                      't_account'=>$tgt_acc,
                                                                      'a_account'=>$act_acc,
                                                                      't_telemarketing'=>$tgt_tel,
                                                                      'a_telemarketing'=>$act_tel,
                                                                      't_entertainment'=>$tgt_ent,
                                                                      'a_entertainment'=>$act_ent,
                                                                      't_compliment'=>$tgt_com,
                                                                      'a_compliment'=>$act_com,
                                                                      't_slsdlmkota'=>$tgt_slsdlmkota,
                                                                      'a_slsdlmkota'=>$act_slsdlmkota,
                                                                      't_slsluarkota'=>$tgt_slsluarkota,
                                                                      'a_slsluarkota'=>$act_slsluarkota,
                                                                      'actual'=>$totalactual,
                                                                      'target'=>$totaltarget,
                                                                      'statistik'=>$slsact);
                                          ?>
                                     </tr>
                                     <?php }//endoforeach?>
                                 </table>
                                 <?php
                                  function msortasc($array, $id="id") {
                                     $temp_array = array();
                                     while (count($array) > 0) {
                                         $lowest_id = 0;
                                         $index = 0;
                                         foreach ($array as $item) {
                                             if (isset($item[$id]) && $array[$lowest_id][$id]) {
                                                 if ((int) $item[$id] < (int) $array[$lowest_id][$id]) {
                                                     $lowest_id = $index;
                                                 }
                                             }
                                             $index++;
                                         }
                                         $temp_array[] = $array[$lowest_id];
                                         $array = array_merge(array_slice($array, 0, $lowest_id), array_slice($array, $lowest_id + 1));
                                     }
                                     return $temp_array;
                                 }
                                 $dt_salessorted = msortasc($dt_salesxx,'statistik' );?>

                                 <table class="dashboard">
                                     <tr class="oddRow">
                                         <th class="kolom" style="text-align: center">Sales</th>
                                         <?php foreach($dt_actsales AS $rowact){?>
                                         <th class="kolom" colspan="2" style="text-align: center"><?= $rowact->slsbudgetname;?></th>
                                         <?php }//endactsale ?>
                                         <!--<th></th>-->
                                     </tr>
                                     <tr class="additionRow">
                                         <th></th>
                                         <?php foreach($dt_actsales AS $rowact){?>
                                         <th class="kolom" style="text-align: center">Target</th>
                                         <th class="kolom" style="text-align: center">Actual</th>
                                          <?php }//endactsale ?>
                                          <!--<th>Stat.</th>-->
                                     </tr>
                                     
                                     <?php
                                     $toprank = 0;
                                     foreach($dt_salessorted AS $key=>$val){
                                     $toprank++;
                                     if($toprank <= 1){
                                         ?>
                                     <tr class="additionRow">
                                         <td class="kolom" style="color: #ff3333"><?= $val['sales']; ?></td>
                                         <td class="kolom" style="text-align: center;color: #ff3333"><?= ceil($val['t_telemarketing']); ?> </td>
                                         <td class="kolom" style="text-align: center;color: #ff3333"><?= $val['a_telemarketing']; ?> </td>
                                         <td class="kolom" style="text-align: center;color: #ff3333"><?= ceil($val['t_entertainment']);?></td>
                                         <td class="kolom" style="text-align: center;color: #ff3333"><?= $val['a_entertainment'];?></td>
                                         <td class="kolom" style="text-align: center;color: #ff3333"><?= ceil($val['t_slsdlmkota']);?></td>
                                         <td class="kolom" style="text-align: center;color: #ff3333"><?= $val['a_slsdlmkota'];?></td>
                                         <td class="kolom" style="text-align: center;color: #ff3333"><?= ceil($val['t_slsluarkota']);?></td>
                                         <td class="kolom" style="text-align: center;color: #ff3333"><?= $val['a_slsluarkota'];?></td>
                                         <td class="kolom" style="text-align: center;color: #ff3333"><?= ceil($val['t_account']);?></td>
                                         <td class="kolom" style="text-align: center;color: #ff3333"><?= $val['a_account'];?></td>
                                         <!-- <td class="kolom" style="text-align: center;color: #ff3333"><?= $val['statistik'];?></td>-->
                                     </tr>
                                     <?php
                                     }else{
                                     ?>
                                       <tr class="additionRow">
                                         <td class="kolom"><?= $val['sales']; ?></td>
                                         <td class="kolom" style="text-align: center"><?= ceil($val['t_telemarketing']); ?> </td>
                                         <td class="kolom" style="text-align: center"><?= $val['a_telemarketing']; ?> </td>
                                         <td class="kolom" style="text-align: center"><?= ceil($val['t_entertainment']);?></td>
                                         <td class="kolom" style="text-align: center"><?= $val['a_entertainment'];?></td>
                                         <td class="kolom" style="text-align: center"><?= ceil($val['t_slsdlmkota']);?></td>
                                         <td class="kolom" style="text-align: center"><?= $val['a_slsdlmkota'];?></td>
                                         <td class="kolom" style="text-align: center"><?= ceil($val['t_slsluarkota']);?></td>
                                         <td class="kolom" style="text-align: center"><?= $val['a_slsluarkota'];?></td>
                                         <td class="kolom" style="text-align: center"><?= ceil($val['t_account']);?></td>
                                         <td class="kolom" style="text-align: center"><?= $val['a_account'];?></td>
                                        <!--<td class="kolom" style="text-align: center; "><?= $val['statistik'];?></td> -->
                                       </tr>
                                     <?php
                                     }
                                     }//endforeach ?>
                                 </table>

                             </div>
                         </div>
                     </div>
                     <!--
                     <table>
                         <tr>
                             <td style="background-color: #f00101">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                             <td>&nbsp;Actual&nbsp;&nbsp;&nbsp;</td>
                             <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                             <td style="background-color: #0000ff">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                             <td>&nbsp;Target&nbsp;&nbsp;&nbsp;</td>
                         </tr>
                     </table>
                     <div id="content_wrap">
                        <div class="homepagebox">
                            <div class="title_220px_2" >
                                <h5>Telemarketing</h5>
                            </div>
                            <div class="content220px_2">
                                 <div id="grafik_slsactivitytelemarketing">
                                 </div>
                            </div>
                        </div>
                        <div class="homepagebox">
                            <div class="title_220px_2" >
                                <h5>Account</h5>
                            </div>
                            <div class="content220px_2">
                               <div id="grafik_slsactivityaccount">
                               </div>
                            </div>
                        </div>
                        <div class="homepagebox">
                            <div class="title_220px_2" >
                                <h5>Entertainment</h5>
                            </div>
                            <div class="content220px_2">
                                <div id="grafik_slsactivityentertainment">
                                </div>
                            </div>
                        </div>
                        <div class="homepagebox">
                            <div class="title_220px_2" >
                                <h5>Sales Call Luar Kota</h5>
                            </div>
                            <div class="content220px_2">
                                <div id="grafik_slsactivitysalescallluarkota">
                                </div>
                            </div>
                        </div>

                          <div class="homepagebox">
                            <div class="title_220px_2" >
                                <h5>Sales Call Dalam Kota</h5>
                            </div>
                            <div class="content220px_2">
                                <div id="grafik_slsactivitysalescalldalamkota">
                                </div>
                            </div>
                        </div>
                    </div>-->
                                <!-- end content wrap-->
                        </div>
                        </div>
                        <!-- End #tab2 -->
                    </div> <!-- End .content-box-content -->
                </div>
                <!-- End .content-box -->
            </div>
            <!-- End box -->
        </div>
        <?= $this->load->view('main_footer'); ?>
    </body>
</html>