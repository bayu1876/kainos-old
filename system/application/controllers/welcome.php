<?php

class Welcome extends Controller {

    function Welcome() {
        parent::Controller();
        if (!$this->login_routine->is_login()) {
            redirect('login/');
        }
        $this->load->helper('file');
        $this->load->model('property_model');
        $this->load->model('sales_group_model');
        $this->load->model('sales_model');
        $this->load->model('offeringbanquet_model');
        $this->load->model('confirm_letter_model');
        $this->load->model('offering_letter_model');
        $this->load->model('confirm_banquet_model');
        $this->load->model('report_model');
        $this->load->model('sales_dashboard_model');
        $this->load->model('definit_letter_model');
        $this->load->model('offering_view_model');
        $this->load->model('confirm_view_model');
        $this->load->model('account_segment_model');
        $this->load->model('confirm_room_rental_model');
        $this->load->model('offering_room_rental_model');
        $this->load->model('ref_slsact_budget_model');
        $this->load->model('sales_act_budget_model');
        $this->load->model('account_model');
        $this->load->model('telemarketing_model');
        $this->load->model('sales_call_model');
        $this->load->model('entertainment_model');
        $this->load->model('complimentary_model');
        $this->load->model('sales_act_budget_model');
        $this->load->model('account_model');
        $this->load->model('contact_model');
        $this->load->model('confirm_wedding_stall_model');
        $this->load->model('offeringstall_model');
        $this->load->model('sales_target_model');
        $this->load->helper('date');
    }

    function index() {
        //$dt_hotel = $this->property_model->select_property();
        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;
        $jabatan = $dt_sales->nama_jab;

        $dt_hotel = $this->property_model->select_target_property();
        $dt_segment = $this->sales_group_model->get_group_nohotel();
        $dt_sales = $this->sales_model->get_sales_by_segment();

        $dt_salestarget = $this->sales_model->select_salestarget();
        $dt_salestargetpersegment = $this->sales_model->select_salestargetpersegment($salessegment);

        $data_offering = $this->sales_dashboard_model->select_offering_by_status('offering', $idsales);
        
        $data_et = $this->sales_dashboard_model->select_entertainment($idsales);
        $data_othact = $this->sales_dashboard_model->select_oth_activities($idsales);
        $dt_task = $this->sales_dashboard_model->select_task($idsales);
        $dt_telemarketing = $this->sales_dashboard_model->select_telemarketing_confirm($idsales);
        $dt_last_call = $this->sales_dashboard_model->select_last_minutes_sales_call($idsales);
        //end todo-list
        //begin count
        $dt_count_ol = $this->sales_dashboard_model->count_offering_letterall($idsales);
        $dt_count_cancel = $this->sales_dashboard_model->count_letter('cancel', $idsales);
        $dt_count_confirm = $this->sales_dashboard_model->count_letter('confirm', $idsales);
        $dt_count_account = $this->sales_dashboard_model->count_account($idsales);
        $dt_count_contact = $this->sales_dashboard_model->count_contact($idsales);

        $dt_count_telemarketing = $this->sales_dashboard_model->count_telemarketing($idsales);
        $dt_count_lastminutes = $this->sales_dashboard_model->count_lastminutescall($idsales);
        //end count
        //add by hendra
        $dataconfirmletter_by_sales = $this->sales_dashboard_model->select_confirm_letter_by_sales($idsales);

        $data_com_segment = $this->account_segment_model->select_account_segment();

        $dt_confirm_today = $this->confirm_letter_model->select_confirmletter_today();
        $total_confirmtoday = $dt_confirm_today->num_rows();

        $dt_confirmcancel_today = $this->confirm_letter_model->select_confirmlettercancel_today();
        $total_confirmcanceltoday = $dt_confirmcancel_today->num_rows();

        $dtoffcanceltoday = $this->offering_letter_model->select_offeringlettercancel_today();
        $total_offeringcanceltoday = $dtoffcanceltoday->num_rows();

        
        $totalpagecancel = '';

        ////-----------------------
        $dt_confirm_todaypersales = $this->confirm_letter_model->select_confirmletterpersalesgroup_today($salessegment);
        $total_confirmtodaypersales = $dt_confirm_todaypersales->num_rows();

        $dt_confirmcancel_todaypersales = $this->confirm_letter_model->select_confirmlettercancelpersalesgroup_today($salessegment);
        $total_confirmcanceltodaypersales = $dt_confirmcancel_todaypersales->num_rows();

        $dtoffcanceltodaypersales = $this->offering_letter_model->select_offeringlettercancelpersalesgroup_today($salessegment);
        $total_offeringcanceltodaypersales = $dtoffcanceltodaypersales->num_rows();
        ////-------------------------


         ////----------GM-------------
        $dt_confirm_todaypergm = $this->confirm_letter_model->select_confirmletterpergm_today($userproperty);
        $total_confirmtodaypergm = $dt_confirm_todaypersales->num_rows();

        $dt_confirmcancel_todaypergm = $this->confirm_letter_model->select_confirmlettercancelpergm_today($userproperty);
        $total_confirmcanceltodaypergm = $dt_confirmcancel_todaypersales->num_rows();

        $dtoffcanceltodaypergm = $this->offering_letter_model->select_offeringlettercancelpergm_today($userproperty);
        $total_offeringcanceltodaypergm = $dtoffcanceltodaypersales->num_rows();
        ////----------END GM----------

        $dt_salesactive = $this->sales_model->select_sales();
        
        if ($userproperty == 'SH') {
            $dt_salesactivepersegment = $this->sales_model->select_salesbygrouponly($salessegment);
        } else {
            $dt_salesactivepersegment = $this->sales_model->select_salesbygroup_perproperty($salessegment, $userproperty);
        }
        $dt_actsales = $this->ref_slsact_budget_model->select_salesactivities();

        $dt_targetsalesgroup = $this->sales_target_model->get_sales_target_by_salesgroup($salessegment,date('m'));
        if ($dt_targetsalesgroup != NULL) {
            $targetsalesgroup = $dt_targetsalesgroup->amount;
        } else {
            $targetsalesgroup = 0;
        }
        $data = array(
            'totalconfirmtoday' => $total_confirmtoday,
            'total_pageconfirm' => ceil($total_confirmtoday / 4),
            'total_pagecancel' => ceil(($total_confirmcanceltoday + $total_offeringcanceltoday) / 4),
            'totalconfirmtodaypersales' => $total_confirmtodaypersales,
            'total_pageconfirmpersales' => ceil($total_confirmtodaypersales / 4),
            'total_pagecancelpersales' => ceil(($total_confirmcanceltodaypersales + $total_offeringcanceltodaypersales )/ 4),
            
            'totalconfirmtodaypergm'=>$total_confirmtodaypergm,
            'total_pageconfirmpergm'=>ceil($total_confirmtodaypergm / 4),
            'total_pagecancelpergm'=>ceil(($total_confirmcanceltodaypergm + $total_offeringcanceltodaypergm) / 4),
            
            'dt_confirm_today' => $dt_confirm_today->result(),
            'dt_hotel' => $dt_hotel->result(),
            'dt_segment' => $dt_segment->result(),
            'dt_sales' => $dt_sales->result(),
            'dt_salestarget' => $dt_salestarget->result(),
            'dt_salestargetpersegment' => $dt_salestargetpersegment->result(),
            //'data_confirm'=>$data_confirm->result(),
            //'data_cancel'=>$data_cancel->result(),
            'data_offering' => $data_offering->result(),
            'data_othact' => $data_othact->result(),
            'data_et' => $data_et->result(),
            'dt_task' => $dt_task->result(),
            'dt_telemarketing' => $dt_telemarketing->result(),
            'dataconfirmletter_by_sales' => $dataconfirmletter_by_sales->result(),
            'dt_last_call' => $dt_last_call->result(),
            'data_com_segment' => $data_com_segment->result(),
            'dt_count_telemarketing' => $dt_count_telemarketing,
            'dt_count_lastminutes' => $dt_count_lastminutes,
            'dt_count_ol' => $dt_count_ol,
            'dt_count_cancel' => $dt_count_cancel,
            'dt_count_confirm' => $dt_count_confirm,
            'dt_count_account' => $dt_count_account,
            'dt_count_contact' => $dt_count_contact,
            'salesproperty' => $userproperty,
            'dt_salesactive' => $dt_salesactive->result(),
            'dt_actsales' => $dt_actsales->result(),
            'dt_salesactivepersegment' => $dt_salesactivepersegment->result(),
            'targetsalesgroup'=>$targetsalesgroup,
            'idsalesgroup'=>$salessegment,
            'accounton' => '',
            'welcomeon' => 'class="on "',
            'documenton' => '',
            'activitieson' => '',
            'reporton' => '',
            'ebookingon' => '',
            'setupon' => '',
            'calendaron' => ''
        );

        if ($leveluser == 'Admin' || $leveluser == 'Manager') {
            if ($userproperty == 'SH') {
                $this->load->view('welcome_message_grafik', $data);
            }else{
//                if($jabatan != 'FO Manager'){
//                    $this->load->view('welcome_message_grafik_perpropertynew', $data);
//                }else{
//                    $this->load->view('welcome_message_grafik_perproperty_fom', $data);
//                }
                switch ($jabatan){
                    case 'FO Manager':
                        $this->load->view('welcome_message_grafik_perproperty_fom', $data);
                        break;
                    case 'General Manager' :
                        $this->load->view('welcome_message_grafik_perpropertynew', $data);
                        break;
                    default :
                          $this->load->view('welcome_message_grafik_perproperty_fom', $data);
                        break;
                }
            }
        } elseif ($leveluser == 'Sales') {
            //redirect('sales_dashboard/loading_data_offering_by_sales');
            if ($userproperty == 'SH') {
                $this->load->view('welcome_message_salesnew', $data);
            } else {
                $this->load->view('welcome_message_salespropertynew', $data);
            }
        } else {
            echo 'WHO ARE U ?????';
            //echo anchor();
        }
    }

    function graph_collateralbyvalue() {
        $this->load->plugin('ofc2');
        $dt_property = $this->property_model->select_property();
        $total_definit = 0;
        $total_confirm = 0;
        $total_tentative = 0;
        $total_cancel = 0;

        $total_docdefinit = 0;
        $total_docconfirm = 0;
        $total_doctentative = 0;
        $total_doccancel = 0;

        $mxVal = 0;
        $mxRev = 0;
        foreach ($dt_property->result() AS $rowprop) {
            $dt_docoff = $this->offering_letter_model->select_documentoffering_bystatusproperty('offering', $rowprop->idproperty);
            if ($dt_docoff->result() != null) {
                $total_doctentative += $dt_docoff->num_rows();
            }
            $dt_docconf = $this->confirm_letter_model->select_documentconfirm_bystatusproperty('confirm', $rowprop->idproperty);
            if ($dt_docconf->result() != null) {
                $total_docconfirm += $dt_docconf->num_rows();
            }
            $dt_docdef = $this->confirm_letter_model->select_documentconfirm_bystatusproperty('definit', $rowprop->idproperty);
            if ($dt_docdef->result() != null) {
                $total_docdefinit += $dt_docdef->num_rows();
            }
            //new updated 27 Dec 2010
            $dt_docoffloss = $this->offering_letter_model->select_documentoffering_bystatusproperty('LOSS', $rowprop->idproperty);
            if ($dt_docoffloss->result() != null) {
                $total_doccancel += $dt_docoffloss->num_rows();
            }
            $dt_docconfloss = $this->confirm_letter_model->select_documentconfirm_bystatusproperty('LOSS', $rowprop->idproperty);
            if ($dt_docconfloss->result() != null) {
                $total_doccancel += $dt_docconfloss->num_rows();
            }
            $dt_docoffremove = $this->offering_letter_model->select_documentoffering_bystatusproperty('REMOVE', $rowprop->idproperty);
            if ($dt_docoffremove->result() != null) {
                $total_doccancel += $dt_docoffremove->num_rows();
            }
            $dt_docconfremove = $this->confirm_letter_model->select_documentconfirm_bystatusproperty('REMOVE', $rowprop->idproperty);
            if ($dt_docconfremove->result() != null) {
                $total_doccancel += $dt_docconfremove->num_rows();
            }

            //offering revenue
            $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'offering');
            $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'offering');
            $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'offering');
            $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'offering');
            $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'offering');
            $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'offering');
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
            //endofferingreveue
            //olpostponed revenue
            $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
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
            //endolpostponedreveue
            //confirm revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'confirm');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'confirm');
            $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'confirm');
            $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'confirm');
            $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'confirm');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'confirm');
            $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'confirm');
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
            //endconfirmreveue
            //clpostponed revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
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
            //endclpostponedreveue
            //definit revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'definit');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'definit');
            $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'definit');
            $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'definit');
            $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'definit');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'definit');
            $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'definit');
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
            //enddefinitreveue
            //clloss revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
            $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
            $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
            $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
            $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
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
            //endcllossreveue
            //
            //olloss
            $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
            $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
            $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
            $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
            $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
            $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
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
            //endolloss
        }//endforeach property

        $datacollateral = array($total_tentative, $total_confirm, $total_definit, $total_cancel);

        if ($mxVal < $total_doctentative) {
            $mxVal = $total_doctentative;
        }
        if ($mxVal < $total_docconfirm) {
            $mxVal = $total_docconfirm;
        }
        if ($mxVal < $total_docdefinit) {
            $mxVal = $total_docdefinit;
        }
        if ($mxVal < $total_doccancel) {
            $mxVal = $total_doccancel;
        }

        if ($mxRev < $total_tentative) {
            $mxRev = $total_tentative;
        }
        if ($mxRev < $total_confirm) {
            $mxRev = $total_confirm;
        }
        if ($mxRev < $total_definit) {
            $mxRev = $total_definit;
        }
        if ($mxRev < $total_cancel) {
            $mxRev = $total_cancel;
        }

        $category[] = 'Offering';
        $category[] = 'Confirm';
        $category[] = 'Definit';
        $category[] = 'Cancel';

        $bar = new bar_cylinder();
        $bar->set_values($datacollateral);

        $s = new star();
        $line_dot = new line();
        $line_dot->set_default_dot_style($s);
        //$line_dot->set_values(array($total_doctentative, $total_docconfirm, $total_docdefinit, $total_doccancel));
        $line_dot->set_values(array($total_doctentative, $total_docconfirm, $total_docdefinit, $total_doccancel));

        $line_dot->attach_to_right_y_axis();
        $line_dot->colour("#fe0505");

        $chart = new open_flash_chart();

        $chart->add_element($bar);

        $chart->set_number_format(0, true, false, false);
        $tooltip = new tooltip();
        $tooltip->set_hover();

        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');

        $y->set_range(0, $mxRev + ceil($mxRev / 10));

        $y_r = new y_axis();
        $y_r->set_colours('#000000', '#d0d0d0');

        $y_r->set_range(0, $mxVal + ceil($mxVal / 10), ceil($mxVal / 10));
        $chart->add_y_axis($y);
        $chart->set_y_axis_right($y_r);
        $chart->add_element($line_dot);
        $chart->set_tooltip($tooltip);
        $x_axis = new x_axis();
        $x_axis->set_3d(5);

        $x_axis->set_colours('#d0d0d0', '#ffffff');
        $x_axis->set_labels_from_array($category);
        $chart->set_x_axis($x_axis);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toString();
    }

    function graph_collateralbyvalue_property()
    {
        $this->load->plugin('ofc2');
        $dt_property = $this->property_model->select_property();
        $total_definit = 0;
        $total_confirm = 0;
        $total_tentative = 0;
        $total_cancel = 0;

        $total_docdefinit = 0;
        $total_docconfirm = 0;
        $total_doctentative = 0;
        $total_doccancel = 0;

        $mxVal = 0;
        $mxRev = 0;
        $userproperty = $this->session->userdata('property');
        
        foreach($dt_property->result() AS $rowprop)
        {
            if($userproperty == $rowprop->idproperty){
            $dt_docoff = $this->offering_letter_model->select_documentoffering_bystatusproperty('offering', $rowprop->idproperty);
            if ($dt_docoff->result() != null) {
                $total_doctentative += $dt_docoff->num_rows();
            }
            $dt_docconf = $this->confirm_letter_model->select_documentconfirm_bystatusproperty('confirm', $rowprop->idproperty);
            if ($dt_docconf->result() != null) {
                $total_docconfirm += $dt_docconf->num_rows();
            }
            $dt_docdef = $this->confirm_letter_model->select_documentconfirm_bystatusproperty('definit', $rowprop->idproperty);
            if ($dt_docdef->result() != null) {
                $total_docdefinit += $dt_docdef->num_rows();
            }
            //new updated 27 Dec 2010
            $dt_docoffloss = $this->offering_letter_model->select_documentoffering_bystatusproperty('LOSS', $rowprop->idproperty);
            if ($dt_docoffloss->result() != null) {
                $total_doccancel += $dt_docoffloss->num_rows();
            }
            $dt_docconfloss = $this->confirm_letter_model->select_documentconfirm_bystatusproperty('LOSS', $rowprop->idproperty);
            if ($dt_docconfloss->result() != null) {
                $total_doccancel += $dt_docconfloss->num_rows();
            }
            $dt_docoffremove = $this->offering_letter_model->select_documentoffering_bystatusproperty('REMOVE', $rowprop->idproperty);
            if ($dt_docoffremove->result() != null) {
                $total_doccancel += $dt_docoffremove->num_rows();
            }
            $dt_docconfremove = $this->confirm_letter_model->select_documentconfirm_bystatusproperty('REMOVE', $rowprop->idproperty);
            if ($dt_docconfremove->result() != null) {
                $total_doccancel += $dt_docconfremove->num_rows();
            }

            //offering revenue
            $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'offering');
            $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'offering');
            $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'offering');
            $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'offering');
            $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'offering');
            $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'offering');
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
            //endofferingreveue
            //olpostponed revenue
            $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
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
            //endolpostponedreveue

            //confirm revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'confirm');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'confirm');
            $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'confirm');
            $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'confirm');
            $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'confirm');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'confirm');
            $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'confirm');
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
            //endconfirmreveue
            //clpostponed revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
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
            //endclpostponedreveue

            //definit revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'definit');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'definit');
            $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'definit');
            $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'definit');
            $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'definit');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'definit');
            $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'definit');
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
            //enddefinitreveue

            //clloss revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
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
            //endcllossreveue
            //
            //olloss
            $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
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
            //endolloss
            }
        }//endforeach property

        $datacollateral = array($total_tentative,$total_confirm,$total_definit,$total_cancel);

        if($mxVal < $total_doctentative)
        {
            $mxVal = $total_doctentative;
        }
        if($mxVal < $total_docconfirm)
        {
            $mxVal = $total_docconfirm;
        }
        if($mxVal < $total_docdefinit)
        {
            $mxVal = $total_docdefinit;
        }
        if($mxVal < $total_doccancel)
        {
            $mxVal = $total_doccancel;
        }

        if($mxRev < $total_tentative)
        {
            $mxRev = $total_tentative;
        }
        if($mxRev < $total_confirm)
        {
            $mxRev = $total_confirm;
        }
        if($mxRev < $total_definit)
        {
            $mxRev = $total_definit;
        }
         if($mxRev < $total_cancel)
        {
            $mxRev = $total_cancel;
        }

        $category[] = 'Offering';
        $category[] = 'Confirm';
        $category[] = 'Definit';
        $category[] = 'Cancel';

        $bar = new bar_cylinder();
        $bar->set_values($datacollateral);

        $s = new star();
        $line_dot = new line();
        $line_dot->set_default_dot_style($s);
        //$line_dot->set_values(array($total_doctentative, $total_docconfirm, $total_docdefinit, $total_doccancel));
        $line_dot->set_values(array($total_doctentative, $total_docconfirm, $total_docdefinit, $total_doccancel));

        $line_dot->attach_to_right_y_axis();
        $line_dot->colour("#fe0505");


        $chart = new open_flash_chart();

        $chart->add_element($bar);

        $chart->set_number_format(0, true, false, false);
        $tooltip = new tooltip();
        $tooltip->set_hover();

        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');

        $y->set_range(0,$mxRev + ceil($mxRev/10));

        $y_r = new y_axis();
        $y_r->set_colours('#000000', '#d0d0d0');

        $y_r->set_range(0, $mxVal + ceil($mxVal/10),ceil($mxVal/10));
        $chart->add_y_axis($y);
        $chart->set_y_axis_right($y_r);
        $chart->add_element($line_dot);
        $chart->set_tooltip($tooltip);
        $x_axis = new x_axis();
        $x_axis->set_3d(5);

        $x_axis->set_colours('#d0d0d0', '#ffffff');
        $x_axis->set_labels_from_array($category);
        $chart->set_x_axis($x_axis);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toString();
    }
    
    function graph_collateralbyvalue_sales()
    {
        $this->load->plugin('ofc2');
        
        $idsales = $this->session->userdata('idstaff');
         
        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;
        
        $dt_property = $this->property_model->select_property();
        $total_definit = 0;
        $total_confirm = 0;
        $total_tentative = 0;
        $total_cancel = 0;

        $total_docdefinit = 0;
        $total_docconfirm = 0;
        $total_doctentative = 0;
        $total_doccancel = 0;

        $mxVal = 0;
        $mxRev = 0;
        
        foreach ($dt_property->result() AS $row) {
            $dt_docoff = $this->offering_letter_model->select_documentofferingpersalessegment_bystatusproperty($salessegment, 'offering', $row->idproperty);
            if ($dt_docoff->result() != null) {
                $total_doctentative += $dt_docoff->num_rows();
            }
            $dt_docoffpostponed = $this->offering_letter_model->select_documentofferingpersalessegment_bystatusproperty($salessegment, 'postponed', $row->idproperty);
            if ($dt_docoffpostponed->result() != null) {
                $total_doctentative += $dt_docoffpostponed->num_rows();
            }

            $dt_docconf = $this->confirm_letter_model->select_documentconfirmpersegment_bystatusproperty($salessegment, 'confirm', $row->idproperty);
            if ($dt_docconf->result() != null) {
                $total_docconfirm += $dt_docconf->num_rows();
            }

            $dt_docdef = $this->confirm_letter_model->select_documentconfirmpersegment_bystatusproperty($salessegment, 'definit', $row->idproperty);
            if ($dt_docdef->result() != null) {
                $total_docdefinit += $dt_docdef->num_rows();
            }

            $dt_docdefpostponed = $this->confirm_letter_model->select_documentconfirmpersegment_bystatusproperty($salessegment, 'postponed', $row->idproperty);
            if ($dt_docdefpostponed->result() != null) {
                $total_docconfirm += $dt_docdefpostponed->num_rows();
            }

            //new updated 26 July 2010
            $dt_docoffloss = $this->offering_letter_model->select_documentofferingpersalessegment_bystatusproperty($salessegment, 'LOSS', $row->idproperty);
            if ($dt_docoffloss->result() != null) {
                $total_doccancel += $dt_docoffloss->num_rows();
            }

            $dt_docconfloss = $this->confirm_letter_model->select_documentconfirmpersegment_bystatusproperty($salessegment, 'LOSS', $row->idproperty);
            if ($dt_docconfloss->result() != null) {
                $total_doccancel += $dt_docconfloss->num_rows();
            }

            //end new updated 26 July 2010
        }
        
        foreach($dt_property->result() AS $rowprop)
        {
            //offering revenue
            $roomonlyrevenue = $this->offering_view_model->select_revroomonly_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'offering');
            $additionalrevenue = $this->offering_view_model->select_revadditional_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'offering');
            $packagerevenue = $this->offering_view_model->select_revpackage_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'offering');
            $meetingrevenue = $this->offering_view_model->select_revmeetingpackage_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'offering');
            $roomrentalrevenue = $this->offering_view_model->select_revroomrental_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'offering');
            $stallrevenue = $this->offering_view_model->select_revstall_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'offering');
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
            //endofferingreveue
            //olpostponed revenue
            $roomonlyrevenue = $this->offering_view_model->select_revroomonly_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $additionalrevenue = $this->offering_view_model->select_revadditional_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $packagerevenue = $this->offering_view_model->select_revpackage_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $meetingrevenue = $this->offering_view_model->select_revmeetingpackage_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $roomrentalrevenue = $this->offering_view_model->select_revroomrental_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $stallrevenue = $this->offering_view_model->select_revstall_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'postponed');
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
            //endolpostponedreveue

            //confirm revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment,date('m'), date('Y'), 'confirm',$rowprop->idproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm',$rowprop->idproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment,date('m'), date('Y'), 'confirm',$rowprop->idproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm',$rowprop->idproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment,date('m'), date('Y'), 'confirm',$rowprop->idproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment,date('m'), date('Y'), 'confirm',$rowprop->idproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment,date('m'), date('Y'), 'confirm',$rowprop->idproperty);
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
            //endconfirmreveue
            //clpostponed revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment,date('m'), date('Y'), 'postponed',$rowprop->idproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed',$rowprop->idproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment,date('m'), date('Y'), 'postponed',$rowprop->idproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed',$rowprop->idproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment,date('m'), date('Y'), 'postponed',$rowprop->idproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment,date('m'), date('Y'), 'postponed',$rowprop->idproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment,date('m'), date('Y'), 'postponed',$rowprop->idproperty);
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
            //endclpostponedreveue

            //definit revenue
             $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment,date('m'), date('Y'), 'definit',$rowprop->idproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit',$rowprop->idproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment,date('m'), date('Y'), 'definit',$rowprop->idproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit',$rowprop->idproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment,date('m'), date('Y'), 'definit',$rowprop->idproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment,date('m'), date('Y'), 'definit',$rowprop->idproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment,date('m'), date('Y'), 'definit',$rowprop->idproperty);
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
            //enddefinitreveue

            //clloss revenue
             $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment,date('m'), date('Y'), 'loss',$rowprop->idproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss',$rowprop->idproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment,date('m'), date('Y'), 'loss',$rowprop->idproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss',$rowprop->idproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment,date('m'), date('Y'), 'loss',$rowprop->idproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment,date('m'), date('Y'), 'loss',$rowprop->idproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment,date('m'), date('Y'), 'loss',$rowprop->idproperty);
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
            //endcllossreveue
            //
            //olloss
             $roomonlyrevenue = $this->offering_view_model->select_revroomonly_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'loss');
            $additionalrevenue = $this->offering_view_model->select_revadditional_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'loss');
            $packagerevenue = $this->offering_view_model->select_revpackage_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'loss');
            $meetingrevenue = $this->offering_view_model->select_revmeetingpackage_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'loss');
            $roomrentalrevenue = $this->offering_view_model->select_revroomrental_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'loss');
            $stallrevenue = $this->offering_view_model->select_revstall_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'loss');
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
            //endolloss

        }//endforeach property

        $datacollateral = array($total_tentative,$total_confirm,$total_definit,$total_cancel);

        if($mxVal < $total_doctentative)
        {
            $mxVal = $total_doctentative;
        }
        if($mxVal < $total_docconfirm)
        {
            $mxVal = $total_docconfirm;
        }
        if($mxVal < $total_docdefinit)
        {
            $mxVal = $total_docdefinit;
        }
        if($mxVal < $total_doccancel)
        {
            $mxVal = $total_doccancel;
        }

        if($mxRev < $total_tentative)
        {
            $mxRev = $total_tentative;
        }
        if($mxRev < $total_confirm)
        {
            $mxRev = $total_confirm;
        }
        if($mxRev < $total_definit)
        {
            $mxRev = $total_definit;
        }
         if($mxRev < $total_cancel)
        {
            $mxRev = $total_cancel;
        }

        $category[] = 'Offering';
        $category[] = 'Confirm';
        $category[] = 'Definit';
        $category[] = 'Cancel';

        $bar = new bar_cylinder();
        $bar->set_values($datacollateral);

        $s = new star();
        $line_dot = new line();
        $line_dot->set_default_dot_style($s);
        //$line_dot->set_values(array($total_doctentative, $total_docconfirm, $total_docdefinit, $total_doccancel));
        $line_dot->set_values(array($total_doctentative, $total_docconfirm, $total_docdefinit, $total_doccancel));

        $line_dot->attach_to_right_y_axis();
        $line_dot->colour("#fe0505");


        $chart = new open_flash_chart();

        $chart->add_element($bar);

        $chart->set_number_format(0, true, false, false);
        $tooltip = new tooltip();
        $tooltip->set_hover();

        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');

        $y->set_range(0,$mxRev + ceil($mxRev/10));

        $y_r = new y_axis();
        $y_r->set_colours('#000000', '#d0d0d0');

        $y_r->set_range(0, $mxVal + ceil($mxVal/10),ceil($mxVal/10));
        $chart->add_y_axis($y);
        $chart->set_y_axis_right($y_r);
        $chart->add_element($line_dot);
        $chart->set_tooltip($tooltip);
        $x_axis = new x_axis();
        $x_axis->set_3d(5);

        $x_axis->set_colours('#d0d0d0', '#ffffff');
        $x_axis->set_labels_from_array($category);
        $chart->set_x_axis($x_axis);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toString();
    }

    function graph_collateralbyvalue_sales_property() {
        $this->load->plugin('ofc2');

        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');
        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;

        $dt_property = $this->property_model->select_property();
        $total_definit = 0;
        $total_confirm = 0;
        $total_tentative = 0;
        $total_cancel = 0;

        $total_docdefinit = 0;
        $total_docconfirm = 0;
        $total_doctentative = 0;
        $total_doccancel = 0;

        $mxVal = 0;
        $mxRev = 0;

        // foreach ($dt_property->result() AS $row) {
        $dt_docoff = $this->offering_letter_model->select_documentofferingpersalessegment_bystatusproperty($salessegment, 'offering', $userproperty);
        if ($dt_docoff->result() != null) {
            $total_doctentative += $dt_docoff->num_rows();
        }
        $dt_docoffpostponed = $this->offering_letter_model->select_documentofferingpersalessegment_bystatusproperty($salessegment, 'postponed', $userproperty);
        if ($dt_docoffpostponed->result() != null) {
            $total_doctentative += $dt_docoffpostponed->num_rows();
        }

        $dt_docconf = $this->confirm_letter_model->select_documentconfirmpersegment_bystatusproperty($salessegment, 'confirm', $userproperty);
        if ($dt_docconf->result() != null) {
            $total_docconfirm += $dt_docconf->num_rows();
        }

        $dt_docdef = $this->confirm_letter_model->select_documentconfirmpersegment_bystatusproperty($salessegment, 'definit', $userproperty);
        if ($dt_docdef->result() != null) {
            $total_docdefinit += $dt_docdef->num_rows();
        }

        $dt_docdefpostponed = $this->confirm_letter_model->select_documentconfirmpersegment_bystatusproperty($salessegment, 'postponed', $userproperty);
        if ($dt_docdefpostponed->result() != null) {
            $total_docconfirm += $dt_docdefpostponed->num_rows();
        }

        //new updated 26 July 2010
        $dt_docoffloss = $this->offering_letter_model->select_documentofferingpersalessegment_bystatusproperty($salessegment, 'LOSS', $userproperty);
        if ($dt_docoffloss->result() != null) {
            $total_doccancel += $dt_docoffloss->num_rows();
        }

        $dt_docconfloss = $this->confirm_letter_model->select_documentconfirmpersegment_bystatusproperty($salessegment, 'LOSS', $userproperty);
        if ($dt_docconfloss->result() != null) {
            $total_doccancel += $dt_docconfloss->num_rows();
        }

        //end new updated 26 July 2010
        //}
//        foreach($dt_property->result() AS $rowprop)
//        {
        //offering revenue
        $roomonlyrevenue = $this->offering_view_model->select_revroomonly_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'offering');
        $additionalrevenue = $this->offering_view_model->select_revadditional_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'offering');
        $packagerevenue = $this->offering_view_model->select_revpackage_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'offering');
        $meetingrevenue = $this->offering_view_model->select_revmeetingpackage_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'offering');
        $roomrentalrevenue = $this->offering_view_model->select_revroomrental_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'offering');
        $stallrevenue = $this->offering_view_model->select_revstall_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'offering');
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
        //endofferingreveue
        //olpostponed revenue
        $roomonlyrevenue = $this->offering_view_model->select_revroomonly_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'postponed');
        $additionalrevenue = $this->offering_view_model->select_revadditional_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'postponed');
        $packagerevenue = $this->offering_view_model->select_revpackage_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'postponed');
        $meetingrevenue = $this->offering_view_model->select_revmeetingpackage_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'postponed');
        $roomrentalrevenue = $this->offering_view_model->select_revroomrental_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'postponed');
        $stallrevenue = $this->offering_view_model->select_revstall_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'postponed');
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
        //endolpostponedreveue
        //confirm revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
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
        //endconfirmreveue
        //clpostponed revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
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
        //endclpostponedreveue
        //definit revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
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
        //enddefinitreveue
        //clloss revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss', $userproperty);
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss', $userproperty);
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss', $userproperty);
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss', $userproperty);
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss', $userproperty);
        $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss', $userproperty);
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss', $userproperty);
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
        //endcllossreveue
        //
            //olloss
        $roomonlyrevenue = $this->offering_view_model->select_revroomonly_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'loss');
        $additionalrevenue = $this->offering_view_model->select_revadditional_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'loss');
        $packagerevenue = $this->offering_view_model->select_revpackage_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'loss');
        $meetingrevenue = $this->offering_view_model->select_revmeetingpackage_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'loss');
        $roomrentalrevenue = $this->offering_view_model->select_revroomrental_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'loss');
        $stallrevenue = $this->offering_view_model->select_revstall_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'loss');
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
        //endolloss
//        }//endforeach property

        $datacollateral = array($total_tentative, $total_confirm, $total_definit, $total_cancel);

        if ($mxVal < $total_doctentative) {
            $mxVal = $total_doctentative;
        }
        if ($mxVal < $total_docconfirm) {
            $mxVal = $total_docconfirm;
        }
        if ($mxVal < $total_docdefinit) {
            $mxVal = $total_docdefinit;
        }
        if ($mxVal < $total_doccancel) {
            $mxVal = $total_doccancel;
        }

        if ($mxRev < $total_tentative) {
            $mxRev = $total_tentative;
        }
        if ($mxRev < $total_confirm) {
            $mxRev = $total_confirm;
        }
        if ($mxRev < $total_definit) {
            $mxRev = $total_definit;
        }
        if ($mxRev < $total_cancel) {
            $mxRev = $total_cancel;
        }

        $category[] = 'Offering';
        $category[] = 'Confirm';
        $category[] = 'Definit';
        $category[] = 'Cancel';

        $bar = new bar_cylinder();
        $bar->set_values($datacollateral);

        $s = new star();
        $line_dot = new line();
        $line_dot->set_default_dot_style($s);
        //$line_dot->set_values(array($total_doctentative, $total_docconfirm, $total_docdefinit, $total_doccancel));
        $line_dot->set_values(array($total_doctentative, $total_docconfirm, $total_docdefinit, $total_doccancel));

        $line_dot->attach_to_right_y_axis();
        $line_dot->colour("#fe0505");


        $chart = new open_flash_chart();

        $chart->add_element($bar);

        $chart->set_number_format(0, true, false, false);
        $tooltip = new tooltip();
        $tooltip->set_hover();

        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');

        $y->set_range(0, $mxRev + ceil($mxRev / 10));

        $y_r = new y_axis();
        $y_r->set_colours('#000000', '#d0d0d0');

        $y_r->set_range(0, $mxVal + ceil($mxVal / 10), ceil($mxVal / 10));
        $chart->add_y_axis($y);
        $chart->set_y_axis_right($y_r);
        $chart->add_element($line_dot);
        $chart->set_tooltip($tooltip);
        $x_axis = new x_axis();
        $x_axis->set_3d(5);

        $x_axis->set_colours('#d0d0d0', '#ffffff');
        $x_axis->set_labels_from_array($category);
        $chart->set_x_axis($x_axis);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toString();
    }

    function get_collateralbyvaluepersales_chart() {
        $this->load->plugin('ofc2');

        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;

        $dt_hotel = $this->property_model->select_target_property();
        $total_definit = 0;
        $total_confirm = 0;
        $total_tentative = 0;
        $total_cancel = 0;

        $total_docdefinit = 0;
        $total_docconfirm = 0;
        $total_doctentative = 0;
        $total_doccancel = 0;
        foreach ($dt_hotel->result() AS $row) {
            $dt_docoff = $this->offering_letter_model->select_documentofferingpersalessegment_bystatusproperty($salessegment, 'offering', $row->idproperty);
            if ($dt_docoff->result() != null) {
                $total_doctentative += $dt_docoff->num_rows();
            }
            $dt_docoffpostponed = $this->offering_letter_model->select_documentofferingpersalessegment_bystatusproperty($salessegment, 'postponed', $row->idproperty);
            if ($dt_docoffpostponed->result() != null) {
                $total_doctentative += $dt_docoffpostponed->num_rows();
            }

            $dt_docconf = $this->confirm_letter_model->select_documentconfirmpersegment_bystatusproperty($salessegment, 'confirm', $row->idproperty);
            if ($dt_docconf->result() != null) {
                $total_docconfirm += $dt_docconf->num_rows();
            }

            $dt_docdef = $this->confirm_letter_model->select_documentconfirmpersegment_bystatusproperty($salessegment, 'definit', $row->idproperty);
            if ($dt_docdef->result() != null) {
                $total_docdefinit += $dt_docdef->num_rows();
            }

            $dt_docdefpostponed = $this->confirm_letter_model->select_documentconfirmpersegment_bystatusproperty($salessegment, 'postponed', $row->idproperty);
            if ($dt_docdefpostponed->result() != null) {
                $total_docconfirm += $dt_docdefpostponed->num_rows();
            }

            //new updated 26 July 2010
            $dt_docoffloss = $this->offering_letter_model->select_documentofferingpersalessegment_bystatusproperty($salessegment, 'LOSS', $row->idproperty);
            if ($dt_docoffloss->result() != null) {
                $total_doccancel += $dt_docoffloss->num_rows();
            }

            $dt_docconfloss = $this->confirm_letter_model->select_documentconfirmpersegment_bystatusproperty($salessegment, 'LOSS', $row->idproperty);
            if ($dt_docconfloss->result() != null) {
                $total_doccancel += $dt_docconfloss->num_rows();
            }

            //end new updated 26 July 2010
        }

        foreach ($dt_hotel->result() AS $row) {
            //definit
            $dt_fb_definit = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'definit');
            if ($dt_fb_definit != null) {
                $total_definit += $dt_fb_definit->totalfbdefinit;
            }
            $dt_room_only_definit = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'definit');
            if ($dt_room_only_definit != null) {
                $total_definit += $dt_room_only_definit->totalroomonly;
            }
            $dt_room_meeting_definit = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'definit');
            if ($dt_room_meeting_definit != null) {
                $total_definit += $dt_room_meeting_definit->totalroommeeting;
            }
            $dt_package_definit = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'definit');
            if ($dt_package_definit != null) {
                $total_definit += $dt_package_definit->totalpackage;
            }
            $dt_additional_definit = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'definit');
            if ($dt_additional_definit != null) {
                $total_definit += $dt_additional_definit->totaladditional;
            }
            $dt_roomrentalhotel_definit = $this->definit_letter_model->select_roomrentalconfirmrevenue_by_salessegmentpropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'definit');
            if ($dt_roomrentalhotel_definit != null) {
                $total_definit += $dt_roomrentalhotel_definit->TotalRevenueRoomRental;
            }
            $dt_stalldefinit = $this->definit_letter_model->select_stallrevenueconfirm_by_salesgroupproperty($salessegment,$row->idproperty,"definit",date('F'),date('Y'));
            if($dt_stalldefinit != NULL)
            {
                $total_definit += $dt_stalldefinit->TotalRevenue;
            }
            //end definit
            //confirm
            $dt_fb_confirm = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'Confirm');
            if ($dt_fb_confirm != null) {
                $total_confirm += $dt_fb_confirm->totalfbdefinit;
            }
            $dt_room_only_confirm = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'Confirm');
            if ($dt_room_only_confirm != null) {
                $total_confirm += $dt_room_only_confirm->totalroomonly;
            }
            $dt_room_meeting_confirm = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'Confirm');
            if ($dt_room_meeting_confirm != null) {
                $total_confirm += $dt_room_meeting_confirm->totalroommeeting;
            }
            $dt_package_confirm = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'Confirm');
            if ($dt_package_confirm != null) {
                $total_confirm += $dt_package_confirm->totalpackage;
            }
            $dt_additional_confirm = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'Confirm');
            if ($dt_additional_confirm != null) {
                $total_confirm += $dt_additional_confirm->totaladditional;
            }
            $dt_roomrentalhotel_confirm = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'confirm');
            if ($dt_roomrentalhotel_confirm != null) {
                $total_confirm += $dt_roomrentalhotel_confirm->TotalRevenueRoomRental;
            }
            $dt_stallconfirm = $this->definit_letter_model->select_stallrevenueconfirm_by_salesgroupproperty($salessegment,$row->idproperty,"confirm",date('F'),date('Y'));
            if($dt_stallconfirm != NULL)
            {
                $total_confirm += $dt_stallconfirm->TotalRevenue;
            }
            //end confirm
            //offering
            $dt_meeting_package_tentative = $this->definit_letter_model->select_meetingpackage_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'offering');
            if ($dt_meeting_package_tentative != null) {
                $total_tentative += $dt_meeting_package_tentative->TotalMeetingPackage;
            }
            $dt_room_only_tentative = $this->definit_letter_model->select_roomonly_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'offering');
            if ($dt_room_only_tentative != null) {
                $total_tentative += $dt_room_only_tentative->RoomOnly;
            }
            $dt_additional_tentative = $this->definit_letter_model->select_additional_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'offering');
            if ($dt_additional_tentative != null) {
                $total_tentative += $dt_additional_tentative->TotalAdditional;
            }
            $dt_banquet_package_tentative = $this->definit_letter_model->select_banquetpackage_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'offering');
            if ($dt_banquet_package_tentative != null) {
                $total_tentative += $dt_banquet_package_tentative->TotalPackage;
            }
            $dt_roomrental_tentatif = $this->offering_view_model->select_roomrentalrevenue_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'offering');
            if ($dt_roomrental_tentatif != null) {
                $total_tentative += $dt_roomrental_tentatif->RevenueRoomRental;
            }
             $dt_stall_tenta = $this->definit_letter_model->select_stallrevenueoffering_by_salesgroupproperty($salessegment,$row->idproperty,date('F'), date('Y'), 'offering');
            if ($dt_stall_tenta != null) {
                $total_tentative += $dt_stall_tenta->TotalRevenue;
            }
            
            //end offering
            //////////////////////////////////////////
            //offering LOSS
            $dt_meeting_package_offloss = $this->definit_letter_model->select_meetingpackage_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_meeting_package_offloss != null) {
                $total_cancel += $dt_meeting_package_offloss->TotalMeetingPackage;
            }
            $dt_room_only_offloss = $this->definit_letter_model->select_roomonly_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_room_only_offloss != null) {
                $total_cancel += $dt_room_only_offloss->RoomOnly;
            }
            $dt_additional_offloss = $this->definit_letter_model->select_additional_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_additional_offloss != null) {
                $total_cancel += $dt_additional_offloss->TotalAdditional;
            }
            $dt_banquet_package_offloss = $this->definit_letter_model->select_banquetpackage_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_banquet_package_offloss != null) {
                $total_cancel += $dt_banquet_package_offloss->TotalPackage;
            }
            $dt_roomrental_offloss = $this->offering_view_model->select_roomrentalrevenue_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_roomrental_offloss != null) {
                $total_cancel += $dt_roomrental_offloss->RevenueRoomRental;
            }
            $dt_stall_tenta = $this->definit_letter_model->select_stallrevenueoffering_by_salesgroupproperty($salessegment,$row->idproperty,date('F'), date('Y'), 'LOSS');
            if ($dt_stall_tenta != null) {
                $total_cancel += $dt_stall_tenta->TotalRevenue;
            }
            //end offering LOSS
            //
            //confirm loss
            $dt_fb_confirmloss = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_fb_confirmloss != null) {
                $total_cancel += $dt_fb_confirmloss->totalfbdefinit;
            }

            $dt_room_only_confirmloss = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_room_only_confirmloss != null) {
                $total_cancel += $dt_room_only_confirmloss->totalroomonly;
            }

            $dt_room_meeting_confirmloss = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_room_meeting_confirmloss != null) {
                $total_cancel += $dt_room_meeting_confirmloss->totalroommeeting;
            }

            $dt_package_confirmloss = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_package_confirmloss != null) {
                $total_cancel += $dt_package_confirmloss->totalpackage;
            }

            $dt_additional_confirmloss = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_additional_confirmloss != null) {
                $total_cancel += $dt_additional_confirmloss->totaladditional;
            }

            $dt_roomrentalhotel_confirmloss = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_roomrentalhotel_confirmloss != null) {
                $total_cancel += $dt_roomrentalhotel_confirmloss->TotalRevenueRoomRental;
            }
            $dt_stallconfirmloss = $this->definit_letter_model->select_stallrevenueconfirm_by_salesgroupproperty($salessegment,$row->idproperty,"LOSS",date('F'),date('Y'));
            if($dt_stallconfirmloss != NULL)
            {
                $total_cancel += $dt_stallconfirmloss->TotalRevenue;
            }
            //end confirm loss
            //
        }

        $max_value = 0;
        if ($max_value < $total_tentative) {
            $max_value = $total_tentative;
        }
        if ($max_value < $total_confirm) {
            $max_value = $total_confirm;
        }
        if ($max_value < $total_definit) {
            $max_value = $total_definit;
        }
        if ($max_value < $total_cancel) {
            $max_value = $total_cancel;
        }

        $category[] = 'Offering';
        $category[] = 'Confirm';
        $category[] = 'Definit';
        $category[] = 'Cancel';

        $data = array(number_format($total_tentative, 0, ',', '') + 0, number_format($total_confirm, 0, ',', '') + 0, number_format($total_definit, 0, ',', '') + 0, number_format($total_cancel, 0, ',', '') + 0);
        $data2 = array(1, 1, 1, 1);
        $bar = new bar_cylinder();
        $bar->set_values($data);

        $s = new star();
        $line_dot = new line();
        $line_dot->set_default_dot_style($s);
        $line_dot->set_values(array($total_doctentative, $total_docconfirm, $total_docdefinit, $total_doccancel));
        $line_dot->attach_to_right_y_axis();

        $line_dot->colour("#fe0505");

        $max_value_yr = 0;
        if ($max_value_yr < $total_doctentative) {
            $max_value_yr = $total_doctentative;
        }
        if ($max_value_yr < $total_docconfirm) {
            $max_value_yr = $total_docconfirm;
        }
        if ($max_value_yr < $total_docdefinit) {
            $max_value_yr = $total_docdefinit;
        }
        if ($max_value_yr < $total_doccancel) {
            $max_value_yr = $total_doccancel;
        }

        $chart = new open_flash_chart();
        //  $chart->set_title( $title );
        $chart->add_element($bar);
//          $chart->add_element( $bar2 );
        $chart->set_number_format(0, true, false, false);
        $tooltip = new tooltip();
        $tooltip->set_hover();

        $chart->set_tooltip($tooltip);
        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');

        $mxv = ceil($max_value / 5);
        $y->set_range(0, number_format($max_value + $mxv, 0, ',', '') + 0);

        $y_r = new y_axis();
        $y_r->set_colours('#000000', '#d0d0d0');
        $ymxv = ceil($max_value_yr / 5);
        $y_r->set_range(0, $max_value_yr + $ymxv,$ymxv);


        $chart->add_y_axis($y);

        $chart->set_y_axis_right($y_r);
        $chart->add_element($line_dot);


        $x_axis = new x_axis();
        $x_axis->set_3d(5);
        //$x_axis->colour = '#d0d0d0';
        $x_axis->set_colours('#d0d0d0', '#ffffff');
        $x_axis->set_labels_from_array($category);
        $chart->set_x_axis($x_axis);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toString();
    }

    function get_collateralbyvaluepersalesproperty_chart() {
        $this->load->plugin('ofc2');

        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;

        $dt_hotel = $this->property_model->select_target_property();
        $total_definit = 0;
        $total_confirm = 0;
        $total_tentative = 0;
        $total_cancel = 0;

        $total_docdefinit = 0;
        $total_docconfirm = 0;
        $total_doctentative = 0;
        $total_doccancel = 0;
//        foreach ($dt_hotel->result() AS $row) {
        $dt_docoff = $this->offering_letter_model->select_documentofferingpersalessegment_bystatusproperty($salessegment, 'offering', $userproperty);
        if ($dt_docoff->result() != null) {
            $total_doctentative += $dt_docoff->num_rows();
        }
        $dt_docconf = $this->confirm_letter_model->select_documentconfirmpersegment_bystatusproperty($salessegment, 'confirm', $userproperty);
        if ($dt_docconf->result() != null) {
            $total_docconfirm += $dt_docconf->num_rows();
        }
        $dt_docdef = $this->confirm_letter_model->select_documentconfirmpersegment_bystatusproperty($salessegment, 'definit', $userproperty);
        if ($dt_docdef->result() != null) {
            $total_docdefinit += $dt_docdef->num_rows();
        }
        //new updated 26 July 2010
        $dt_docoffloss = $this->offering_letter_model->select_documentofferingpersalessegment_bystatusproperty($salessegment, 'LOSS', $userproperty);
        if ($dt_docoffloss->result() != null) {
            $total_doccancel += $dt_docoffloss->num_rows();
        }
        $dt_docconfloss = $this->confirm_letter_model->select_documentconfirmpersegment_bystatusproperty($salessegment, 'LOSS', $userproperty);
        if ($dt_docconfloss->result() != null) {
            $total_doccancel += $dt_docconfloss->num_rows();
        }
//        }//endforeach
//        foreach ($dt_hotel->result() AS $row) {
        //definit
        $dt_fb_definit = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_fb_definit != null) {
            $total_definit += $dt_fb_definit->totalfbdefinit;
        }
        $dt_room_only_definit = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_room_only_definit != null) {
            $total_definit += $dt_room_only_definit->totalroomonly;
        }
        $dt_room_meeting_definit = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_room_meeting_definit != null) {
            $total_definit += $dt_room_meeting_definit->totalroommeeting;
        }
        $dt_package_definit = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_package_definit != null) {
            $total_definit += $dt_package_definit->totalpackage;
        }
        $dt_additional_definit = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_additional_definit != null) {
            $total_definit += $dt_additional_definit->totaladditional;
        }
        $dt_roomrentalhotel_definit = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_roomrentalhotel_definit != null) {
            $total_definit += $dt_roomrentalhotel_definit->TotalRevenueRoomRental;
        }
        //end definit
        //confirm
        $dt_fb_confirm = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_fb_confirm != null) {
            $total_confirm += $dt_fb_confirm->totalfbdefinit;
        }
        $dt_room_only_confirm = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_room_only_confirm != null) {
            $total_confirm += $dt_room_only_confirm->totalroomonly;
        }
        $dt_room_meeting_confirm = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_room_meeting_confirm != null) {
            $total_confirm += $dt_room_meeting_confirm->totalroommeeting;
        }
        $dt_package_confirm = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_package_confirm != null) {
            $total_confirm += $dt_package_confirm->totalpackage;
        }
        $dt_additional_confirm = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_additional_confirm != null) {
            $total_confirm += $dt_additional_confirm->totaladditional;
        }
        $dt_roomrentalhotel_confirm = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'confirm');
        if ($dt_roomrentalhotel_confirm != null) {
            $total_confirm += $dt_roomrentalhotel_confirm->TotalRevenueRoomRental;
        }
        //end confirm
        //offering
        $dt_meeting_package_tentative = $this->definit_letter_model->select_meetingpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_meeting_package_tentative != null) {
            $total_tentative += $dt_meeting_package_tentative->TotalMeetingPackage;
        }
        $dt_room_only_tentative = $this->definit_letter_model->select_roomonly_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_room_only_tentative != null) {
            $total_tentative += $dt_room_only_tentative->RoomOnly;
        }
        $dt_additional_tentative = $this->definit_letter_model->select_additional_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_additional_tentative != null) {
            $total_tentative += $dt_additional_tentative->TotalAdditional;
        }
        $dt_banquet_package_tentative = $this->definit_letter_model->select_banquetpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_banquet_package_tentative != null) {
            $total_tentative += $dt_banquet_package_tentative->TotalPackage;
        }
        //new 6 May 2010///////////////////////////
        $dt_roomrental_tentatif = $this->offering_view_model->select_roomrentalrevenue_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_roomrental_tentatif != null) {
            $total_tentative += $dt_roomrental_tentatif->RevenueRoomRental;
        }
        //end offering
        //////////////////////////////////////////
        //offering LOSS
        $dt_meeting_package_offloss = $this->definit_letter_model->select_meetingpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_meeting_package_offloss != null) {
            $total_cancel += $dt_meeting_package_offloss->TotalMeetingPackage;
        }
        $dt_room_only_offloss = $this->definit_letter_model->select_roomonly_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_only_offloss != null) {
            $total_cancel += $dt_room_only_offloss->RoomOnly;
        }
        $dt_additional_offloss = $this->definit_letter_model->select_additional_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_additional_offloss != null) {
            $total_cancel += $dt_additional_offloss->TotalAdditional;
        }
        $dt_banquet_package_offloss = $this->definit_letter_model->select_banquetpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_banquet_package_offloss != null) {
            $total_cancel += $dt_banquet_package_offloss->TotalPackage;
        }
        //new 6 May 2010///////////////////////////
        $dt_roomrental_offloss = $this->offering_view_model->select_roomrentalrevenue_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_roomrental_offloss != null) {
            $total_cancel += $dt_roomrental_offloss->RevenueRoomRental;
        }
        //end offering LOSS
        //
        //confirm loss
        $dt_fb_confirmloss = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_fb_confirmloss != null) {
            $total_cancel += $dt_fb_confirmloss->totalfbdefinit;
        }

        $dt_room_only_confirmloss = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_only_confirmloss != null) {
            $total_cancel += $dt_room_only_confirmloss->totalroomonly;
        }

        $dt_room_meeting_confirmloss = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_meeting_confirmloss != null) {
            $total_cancel += $dt_room_meeting_confirmloss->totalroommeeting;
        }

        $dt_package_confirmloss = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_package_confirmloss != null) {
            $total_cancel += $dt_package_confirmloss->totalpackage;
        }

        $dt_additional_confirmloss = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_additional_confirmloss != null) {
            $total_cancel += $dt_additional_confirmloss->totaladditional;
        }

        $dt_roomrentalhotel_confirmloss = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_roomrentalhotel_confirmloss != null) {
            $total_cancel += $dt_roomrentalhotel_confirmloss->TotalRevenueRoomRental;
        }
        //end confirm loss
        //
//        }//endforeach

        $max_value = 0;
        if ($max_value < $total_tentative) {
            $max_value = $total_tentative;
        }
        if ($max_value < $total_confirm) {
            $max_value = $total_confirm;
        }
        if ($max_value < $total_definit) {
            $max_value = $total_definit;
        }
        if ($max_value < $total_cancel) {
            $max_value = $total_cancel;
        }

        $category[] = 'Offering';
        $category[] = 'Confirm';
        $category[] = 'Definit';
        $category[] = 'Cancel';

        $data = array(number_format($total_tentative, 0, ',', '') + 0, number_format($total_confirm, 0, ',', '') + 0, number_format($total_definit, 0, ',', '') + 0, number_format($total_cancel, 0, ',', '') + 0);
        $data2 = array(20, 100, 30, 22);
        $bar = new bar_cylinder();
        $bar->set_values($data);

        $s = new star();
        $line_dot = new line();
        $line_dot->set_default_dot_style($s);
        $line_dot->set_values(array($total_doctentative, $total_docconfirm, $total_docdefinit, $total_doccancel));
        $line_dot->attach_to_right_y_axis();

        $line_dot->colour("#fe0505");

        $max_value_yr = 0;
        if ($max_value_yr < $total_doctentative) {
            $max_value_yr = $total_doctentative;
        }
        if ($max_value_yr < $total_docconfirm) {
            $max_value_yr = $total_docconfirm;
        }
        if ($max_value_yr < $total_docdefinit) {
            $max_value_yr = $total_docdefinit;
        }
        if ($max_value_yr < $total_doccancel) {
            $max_value_yr = $total_doccancel;
        }

        $chart = new open_flash_chart();

        $chart->add_element($bar);
        $chart->set_number_format(0, true, false, false);
        $tooltip = new tooltip();
        $tooltip->set_hover();

        $mv = ceil($max_value/5);

        $chart->set_tooltip($tooltip);
        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');
        $y->set_range(0, number_format($max_value + $mv, 0, ',', '') + 0);

        $y_r = new y_axis();
        $y_r->set_colours('#000000', '#d0d0d0');
        $y_r->set_range(0, $max_value_yr + 50, 25);

        $chart->add_y_axis($y);
        $chart->set_y_axis_right($y_r);
        $chart->add_element($line_dot);

        $x_axis = new x_axis();
        $x_axis->set_3d(5);
        //$x_axis->colour = '#d0d0d0';
        $x_axis->set_colours('#d0d0d0', '#ffffff');
        $x_axis->set_labels_from_array($category);
        $chart->set_x_axis($x_axis);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toString();
    }


    function get_collateralbyvaluepergm_chart() {
        $this->load->plugin('ofc2');

        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');
       
        $dt_hotel = $this->property_model->select_target_property();
        $total_definit = 0;
        $total_confirm = 0;
        $total_tentative = 0;
        $total_cancel = 0;

        $total_docdefinit = 0;
        $total_docconfirm = 0;
        $total_doctentative = 0;
        $total_doccancel = 0;
 
        $dt_docoff = $this->offering_letter_model->select_documentofferingpergm_bystatusproperty('offering', $userproperty);
        if ($dt_docoff->result() != null) {
            $total_doctentative += $dt_docoff->num_rows();
        }
        $dt_docconf = $this->confirm_letter_model->select_documentconfirmpergm_bystatusproperty('confirm', $userproperty);
        if ($dt_docconf->result() != null) {
            $total_docconfirm += $dt_docconf->num_rows();
        }
        $dt_docdef = $this->confirm_letter_model->select_documentconfirmpergm_bystatusproperty('definit', $userproperty);
        if ($dt_docdef->result() != null) {
            $total_docdefinit += $dt_docdef->num_rows();
        }
        //new updated 26 July 2010
        $dt_docoffloss = $this->offering_letter_model->select_documentofferingpergm_bystatusproperty( 'LOSS', $userproperty);
        if ($dt_docoffloss->result() != null) {
            $total_doccancel += $dt_docoffloss->num_rows();
        }
        $dt_docconfloss = $this->confirm_letter_model->select_documentconfirmpergm_bystatusproperty( 'LOSS', $userproperty);
        if ($dt_docconfloss->result() != null) {
            $total_doccancel += $dt_docconfloss->num_rows();
        }

        
        //definit
        $dt_fb_definit = $this->definit_letter_model->select_total_fb_by_property($userproperty, date('F'), date('Y'), 'definit');
        if ($dt_fb_definit != null) {
            $total_definit += $dt_fb_definit->totalfbdefinit;
        }
        $dt_room_only_definit = $this->definit_letter_model->select_total_room_only_by_property( $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_room_only_definit != null) {
            $total_definit += $dt_room_only_definit->totalroomonly;
        }
        $dt_room_meeting_definit = $this->definit_letter_model->select_total_room_meeting_by_properti( $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_room_meeting_definit != null) {
            $total_definit += $dt_room_meeting_definit->totalroommeeting;
        }
        $dt_package_definit = $this->definit_letter_model->select_total_package_by_property( $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_package_definit != null) {
            $total_definit += $dt_package_definit->totalpackage;
        }
        $dt_additional_definit = $this->definit_letter_model->select_total_additional_by_property( $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_additional_definit != null) {
            $total_definit += $dt_additional_definit->totaladditional;
        }
        $dt_roomrentalhotel_definit = $this->definit_letter_model->select_roomrentalrevenue_by_propmonthyearstatus( $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_roomrentalhotel_definit != null) {
            $total_definit += $dt_roomrentalhotel_definit->TotalRevenue;
        }
        $dt_stalldefinit = $this->definit_letter_model->select_stallrevenueconfirm_by_property($userproperty,date('F'),date('Y'),"definit");
        if($dt_stalldefinit != NULL)
        {
            $total_definit += $dt_stalldefinit->TotalRevenue;
        }
        //end definit
        //confirm
        $dt_fb_confirm = $this->definit_letter_model->select_total_fb_by_property(  $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_fb_confirm != null) {
            $total_confirm += $dt_fb_confirm->totalfbdefinit;
        }
        $dt_room_only_confirm = $this->definit_letter_model->select_total_room_only_by_property(   $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_room_only_confirm != null) {
            $total_confirm += $dt_room_only_confirm->totalroomonly;
        }
        $dt_room_meeting_confirm = $this->definit_letter_model->select_total_room_meeting_by_properti( $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_room_meeting_confirm != null) {
            $total_confirm += $dt_room_meeting_confirm->totalroommeeting;
        }
        $dt_package_confirm = $this->definit_letter_model->select_total_package_by_property(  $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_package_confirm != null) {
            $total_confirm += $dt_package_confirm->totalpackage;
        }
        $dt_additional_confirm = $this->definit_letter_model->select_total_additional_by_property(  $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_additional_confirm != null) {
            $total_confirm += $dt_additional_confirm->totaladditional;
        }
        $dt_roomrentalhotel_confirm = $this->definit_letter_model->select_roomrentalrevenue_by_propmonthyearstatus( $userproperty, date('F'), date('Y'), 'confirm');
        if ($dt_roomrentalhotel_confirm != null) {
            $total_confirm += $dt_roomrentalhotel_confirm->TotalRevenue;
        }
        $dt_stallconfirm = $this->definit_letter_model->select_stallrevenueconfirm_by_property($userproperty,date('F'),date('Y'),"confirm");
        if($dt_stallconfirm != NULL)
        {
            $total_confirm += $dt_stallconfirm->TotalRevenue;
        }
        //end confirm
        //offering
        $dt_meeting_package_tentative = $this->definit_letter_model->select_meeting_package_by_property($userproperty, date('F'), date('Y'), 'offering');
        if ($dt_meeting_package_tentative != null) {
            $total_tentative += $dt_meeting_package_tentative->TotalMeetingPackage;
        }
        $dt_room_only_tentative = $this->definit_letter_model->select_room_only_by_property( $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_room_only_tentative != null) {
            $total_tentative += $dt_room_only_tentative->RoomOnly;
        }
        $dt_additional_tentative = $this->definit_letter_model->select_addtional_by_property($userproperty, date('F'), date('Y'), 'offering');
        if ($dt_additional_tentative != null) {
            $total_tentative += $dt_additional_tentative->TotalAdditional;
        }
        $dt_banquet_package_tentative = $this->definit_letter_model->select_banquet_package_by_property( $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_banquet_package_tentative != null) {
            $total_tentative += $dt_banquet_package_tentative->TotalPackage;
        }
        //new 6 May 2010///////////////////////////
        $dt_roomrental_tentatif = $this->definit_letter_model->select_roomrentaltentative_by_propmonthyearstatus( $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_roomrental_tentatif != null) {
            $total_tentative += $dt_roomrental_tentatif->TotalRevenue;
        }
        //end offering
        //////////////////////////////////////////
        //offering LOSS
        $dt_meeting_package_offloss = $this->definit_letter_model->select_meeting_package_by_property( $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_meeting_package_offloss != null) {
            $total_cancel += $dt_meeting_package_offloss->TotalMeetingPackage;
        }
        $dt_room_only_offloss = $this->definit_letter_model->select_room_only_by_property( $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_only_offloss != null) {
            $total_cancel += $dt_room_only_offloss->RoomOnly;
        }
        $dt_additional_offloss = $this->definit_letter_model->select_addtional_by_property( $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_additional_offloss != null) {
            $total_cancel += $dt_additional_offloss->TotalAdditional;
        }
        $dt_banquet_package_offloss = $this->definit_letter_model->select_banquet_package_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_banquet_package_offloss != null) {
            $total_cancel += $dt_banquet_package_offloss->TotalPackage;
        }
        //new 6 May 2010///////////////////////////
        $dt_roomrental_offloss = $this->definit_letter_model->select_roomrentaltentative_by_propmonthyearstatus($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_roomrental_offloss != null) {
            $total_cancel += $dt_roomrental_offloss->TotalRevenue;
        }
        //end offering LOSS
        //
        //confirm loss
        $dt_fb_confirmloss = $this->definit_letter_model->select_total_fb_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_fb_confirmloss != null) {
            $total_cancel += $dt_fb_confirmloss->totalfbdefinit;
        }
        $dt_room_only_confirmloss = $this->definit_letter_model->select_total_room_only_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_only_confirmloss != null) {
            $total_cancel += $dt_room_only_confirmloss->totalroomonly;
        }
        $dt_room_meeting_confirmloss = $this->definit_letter_model->select_total_room_meeting_by_properti($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_meeting_confirmloss != null) {
            $total_cancel += $dt_room_meeting_confirmloss->totalroommeeting;
        }

        $dt_package_confirmloss = $this->definit_letter_model->select_total_package_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_package_confirmloss != null) {
            $total_cancel += $dt_package_confirmloss->totalpackage;
        }

        $dt_additional_confirmloss = $this->definit_letter_model->select_total_additional_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_additional_confirmloss != null) {
            $total_cancel += $dt_additional_confirmloss->totaladditional;
        }

        $dt_roomrentalhotel_confirmloss = $this->definit_letter_model->select_roomrentalrevenue_by_propmonthyearstatus($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_roomrentalhotel_confirmloss != null) {
            $total_cancel += $dt_roomrentalhotel_confirmloss->TotalRevenue;
        }
        //end confirm loss
   

        $max_value = 0;
        if ($max_value < $total_tentative) {
            $max_value = $total_tentative;
        }
        if ($max_value < $total_confirm) {
            $max_value = $total_confirm;
        }
        if ($max_value < $total_definit) {
            $max_value = $total_definit;
        }
        if ($max_value < $total_cancel) {
            $max_value = $total_cancel;
        }

        $category[] = 'Offering';
        $category[] = 'Confirm';
        $category[] = 'Definit';
        $category[] = 'Cancel';

        $data = array(number_format($total_tentative, 0, ',', '') + 0, number_format($total_confirm, 0, ',', '') + 0, number_format($total_definit, 0, ',', '') + 0, number_format($total_cancel, 0, ',', '') + 0);
        $data2 = array(20, 100, 30, 22);
        $bar = new bar_cylinder();
        $bar->set_values($data);

        $s = new star();
        $line_dot = new line();
        $line_dot->set_default_dot_style($s);
        $line_dot->set_values(array($total_doctentative, $total_docconfirm, $total_docdefinit, $total_doccancel));
        $line_dot->attach_to_right_y_axis();

        $line_dot->colour("#fe0505");

        $max_value_yr = 0;
        if ($max_value_yr < $total_doctentative) {
            $max_value_yr = $total_doctentative;
        }
        if ($max_value_yr < $total_docconfirm) {
            $max_value_yr = $total_docconfirm;
        }
        if ($max_value_yr < $total_docdefinit) {
            $max_value_yr = $total_docdefinit;
        }
        if ($max_value_yr < $total_doccancel) {
            $max_value_yr = $total_doccancel;
        }

        $chart = new open_flash_chart();

        $chart->add_element($bar);
        $chart->set_number_format(0, true, false, false);
        $tooltip = new tooltip();
        $tooltip->set_hover();

        $x = ceil($max_value/5);

        $chart->set_tooltip($tooltip);
        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');
        $y->set_range(0, number_format($max_value + $x, 0, ',', '') + 0);

        $mv = ceil($max_value_yr/5);

        $y_r = new y_axis();
        $y_r->set_colours('#000000', '#d0d0d0');
        $y_r->set_range(0, $max_value_yr + $mv,ceil($mv/1.25));


        $chart->add_y_axis($y);

        $chart->set_y_axis_right($y_r);
        $chart->add_element($line_dot);


        $x_axis = new x_axis();
        $x_axis->set_3d(5);
        //$x_axis->colour = '#d0d0d0';
        $x_axis->set_colours('#d0d0d0', '#ffffff');
        $x_axis->set_labels_from_array($category);
        $chart->set_x_axis($x_axis);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toString();
    }

    function graph_revenuebymarketsegment()
    {
         $data_com_segment = $this->account_segment_model->select_account_segment();
        $dt_segment = $this->sales_group_model->get_group_nohotel();
        $comsegment = array();

        $this->load->plugin('ofc2');

        $tgCorporate = 0;
        $tgEvent = 0;
        $tgGov = 0;
        $tgTravel = 0;
        foreach ($dt_segment->result() AS $row) {
            if ($row->nama_sg == "Corporate 1") {
                $tgCorporate += $row->amount;
            }
            if ($row->nama_sg == "Corporate 2") {
                $tgCorporate += $row->amount;
            }
            if ($row->nama_sg == "Goverment") {
                $tgGov += $row->amount;
            }
            if ($row->nama_sg == "Travel Agent") {
                $tgTravel += $row->amount;
            }
            if ($row->nama_sg == "Event") {
                $tgEvent += $row->amount;
            }
        }

        $max_value = 0;

        $dt_cd = array();
        $dt_d = array();
        $dt_cancel = array();
        $dt_target = array();
        foreach ($data_com_segment->result() AS $row) {
            $comsegment[] = $row->nama_segment;
            $targetsegment = 0;
            $totalrevenuedefinit = 0;
            $totalrevenueconfirm = 0;
            $totalrevenuecancel = 0;
            $totalrevenuedefinitconfirm = 0;

            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue_by_companysegment('definit', $row->idcomseg);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_by_companysegment('definit', $row->idcomseg);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue_by_companysegment('definit', $row->idcomseg);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_by_companysegment('definit', $row->idcomseg);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue_by_companysegment('definit', $row->idcomseg);
            $stallrevenue = $this->confirm_view_model->select_stallrevenue_by_companysegment('definit', $row->idcomseg);
            //new 6 May 2010///////////////////////////
            $dt_roomrental_definit_comseg = $this->confirm_view_model->select_revenueroomrental_by_companysegment($row->idcomseg,date('F'), date('Y'), 'definit');

            if ($dt_roomrental_definit_comseg != null) {
                $totalrevenuedefinit += $dt_roomrental_definit_comseg->RevenueRoomRental;
                $totalrevenuedefinitconfirm += $dt_roomrental_definit_comseg->RevenueRoomRental;
            }
            if ($roommeetingrevenue != null) {
                $totalrevenuedefinit += $roommeetingrevenue->RoomMeeting;
                $totalrevenuedefinitconfirm += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalrevenuedefinit += $roomonlyrevenue->RoomOnly; //oke
                $totalrevenuedefinitconfirm += $roomonlyrevenue->RoomOnly;
            }
            if ($packagerevenue != null) {
                $totalrevenuedefinit += $packagerevenue->PackageRevenue;
                $totalrevenuedefinitconfirm += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalrevenuedefinit += $additionalrevenue->AddtionalRevenue;
                $totalrevenuedefinitconfirm += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalrevenuedefinit += $fnbrevenue->FBRevenue;
                $totalrevenuedefinitconfirm += $fnbrevenue->FBRevenue;
            }
            if ($stallrevenue != null) {
                $totalrevenuedefinit += $stallrevenue->TotalRevenue;
                $totalrevenuedefinitconfirm += $stallrevenue->TotalRevenue;
            }

            $roommeetingrevenueconfirm = $this->confirm_view_model->select_roommeetingmeetingrevenue_by_companysegment('confirm', $row->idcomseg);
            $roomonlyrevenueconfirm = $this->confirm_view_model->select_roomonlyrevenue_by_companysegment('confirm', $row->idcomseg);
            $packagerevenueconfirm = $this->confirm_view_model->select_packagerevenue_by_companysegment('confirm', $row->idcomseg);
            $additionalrevenueconfirm = $this->confirm_view_model->select_additionalrevenue_by_companysegment('confirm', $row->idcomseg);
            $fnbrevenueconfirm = $this->confirm_view_model->select_fnbrevenue_by_companysegment('confirm', $row->idcomseg);
            $stallrevenueconfirm = $this->confirm_view_model->select_stallrevenue_by_companysegment('confirm', $row->idcomseg);
            //new 6 May 2010///////////////////////////
            $dt_roomrental_confirm_comseg = $this->confirm_view_model->select_revenueroomrental_by_companysegment($row->idcomseg,date('F'), date('Y'), 'confirm');

            if ($dt_roomrental_confirm_comseg != null) {
                $totalrevenueconfirm += $dt_roomrental_confirm_comseg->RevenueRoomRental;
                $totalrevenuedefinitconfirm += $dt_roomrental_confirm_comseg->RevenueRoomRental;
            }
            //////////////////////////////////////////
            if ($roommeetingrevenueconfirm != null) {
                $totalrevenueconfirm += $roommeetingrevenueconfirm->RoomMeeting;
                $totalrevenuedefinitconfirm += $roommeetingrevenueconfirm->RoomMeeting;
            }
            if ($roomonlyrevenueconfirm != null) {
                $totalrevenueconfirm += $roomonlyrevenueconfirm->RoomOnly; //oke
                $totalrevenuedefinitconfirm += $roomonlyrevenueconfirm->RoomOnly; //oke
            }
            if ($packagerevenueconfirm != null) {
                $totalrevenueconfirm += $packagerevenueconfirm->PackageRevenue;
                $totalrevenuedefinitconfirm += $packagerevenueconfirm->PackageRevenue;
            }
            if ($additionalrevenueconfirm != null) {
                $totalrevenueconfirm += $additionalrevenueconfirm->AddtionalRevenue;
                $totalrevenuedefinitconfirm += $additionalrevenueconfirm->AddtionalRevenue;
            }
            if ($fnbrevenueconfirm != null) {
                $totalrevenueconfirm += $fnbrevenueconfirm->FBRevenue;
                $totalrevenuedefinitconfirm += $fnbrevenueconfirm->FBRevenue;
            }
            if ($stallrevenueconfirm != null) {
                $totalrevenueconfirm += $stallrevenueconfirm->TotalRevenue;
                $totalrevenuedefinitconfirm += $stallrevenueconfirm->TotalRevenue;
            }



            $roommeetingrevenueconfirmpost = $this->confirm_view_model->select_roommeetingmeetingrevenue_by_companysegment('POSTPONED', $row->idcomseg);
            $roomonlyrevenueconfirmpost = $this->confirm_view_model->select_roomonlyrevenue_by_companysegment('POSTPONED', $row->idcomseg);
            $packagerevenueconfirmpost = $this->confirm_view_model->select_packagerevenue_by_companysegment('POSTPONED', $row->idcomseg);
            $additionalrevenueconfirmpost = $this->confirm_view_model->select_additionalrevenue_by_companysegment('POSTPONED', $row->idcomseg);
            $fnbrevenueconfirmpost = $this->confirm_view_model->select_fnbrevenue_by_companysegment('POSTPONED', $row->idcomseg);
            $stallrevenueconfirmpost = $this->confirm_view_model->select_stallrevenue_by_companysegment('POSTPONED', $row->idcomseg);
            //new 6 May 2010///////////////////////////
            $dt_roomrental_confirm_comsegpost = $this->confirm_view_model->select_revenueroomrental_by_companysegment($row->idcomseg, date('F'), date('Y'), 'POSTPONED');
            if ($dt_roomrental_confirm_comsegpost != null) {
                $totalrevenueconfirm += $dt_roomrental_confirm_comsegpost->RevenueRoomRental;
                $totalrevenuedefinitconfirm += $dt_roomrental_confirm_comsegpost->RevenueRoomRental;
            }
            //////////////////////////////////////////
            if ($roommeetingrevenueconfirmpost != null) {
                $totalrevenueconfirm += $roommeetingrevenueconfirmpost->RoomMeeting;
                $totalrevenuedefinitconfirm += $roommeetingrevenueconfirmpost->RoomMeeting;
            }
            if ($roomonlyrevenueconfirmpost != null) {
                $totalrevenueconfirm += $roomonlyrevenueconfirmpost->RoomOnly; //oke
                $totalrevenuedefinitconfirm += $roomonlyrevenueconfirmpost->RoomOnly; //oke
            }
            if ($packagerevenueconfirmpost != null) {
                $totalrevenueconfirm += $packagerevenueconfirmpost->PackageRevenue;
                $totalrevenuedefinitconfirm += $packagerevenueconfirmpost->PackageRevenue;
            }
            if ($additionalrevenueconfirmpost != null) {
                $totalrevenueconfirm += $additionalrevenueconfirmpost->AddtionalRevenue;
                $totalrevenuedefinitconfirm += $additionalrevenueconfirmpost->AddtionalRevenue;
            }
            if ($fnbrevenueconfirmpost != null) {
                $totalrevenueconfirm += $fnbrevenueconfirmpost->FBRevenue;
                $totalrevenuedefinitconfirm += $fnbrevenueconfirmpost->FBRevenue;
            }
            if ($stallrevenueconfirmpost != null) {
                $totalrevenueconfirm += $stallrevenueconfirmpost->TotalRevenue;
                $totalrevenuedefinitconfirm += $stallrevenueconfirmpost->TotalRevenue;
            }

            $roommeetingrevenueconfirmloss = $this->confirm_view_model->select_roommeetingmeetingrevenue_by_companysegment('LOSS', $row->idcomseg);
            $roomonlyrevenueconfirmloss = $this->confirm_view_model->select_roomonlyrevenue_by_companysegment('LOSS', $row->idcomseg);
            $packagerevenueconfirmloss = $this->confirm_view_model->select_packagerevenue_by_companysegment('LOSS', $row->idcomseg);
            $additionalrevenueconfirmloss = $this->confirm_view_model->select_additionalrevenue_by_companysegment('LOSS', $row->idcomseg);
            $fnbrevenueconfirmloss = $this->confirm_view_model->select_fnbrevenue_by_companysegment('LOSS', $row->idcomseg);
            $stallrevenueconfirmloss = $this->confirm_view_model->select_stallrevenue_by_companysegment('LOSS', $row->idcomseg);


            $roommeetingrevenueoffloss = $this->offering_view_model->select_roommeetingmeetingrevenue_bystatuscompany('LOSS', $row->idcomseg);
            $meetingpackagerevenueoffloss = $this->offering_view_model->select_fnbrevenue_bystatuscompany('LOSS', $row->idcomseg);
            $additionalrevenueoffloss = $this->offering_view_model->select_additionalrevenue_bystatuscompany('LOSS', $row->idcomseg);
            $packagerevenueoffloss = $this->offering_view_model->select_packagerevenue_bystatuscompany('LOSS', $row->idcomseg);
            $roomrentalrevenueloss = $this->offering_view_model->select_roomrental_bystatuscompany('LOSS', $row->idcomseg);
            $stallrevenueoffloss = $this->offering_view_model->select_revenuestall_bystatuscompany('LOSS', $row->idcomseg);

            $dt_roomrental_confirmloss_comseg = $this->confirm_view_model->select_revenueroomrental_by_companysegment($row->idcomseg, date('F'), date('Y'), 'LOSS');

            if ($dt_roomrental_confirmloss_comseg != null) {
                $totalrevenuecancel += $dt_roomrental_confirmloss_comseg->RevenueRoomRental;
            }
            //////////////////////////////////////////

            if ($roommeetingrevenueconfirmloss != null) {
                $totalrevenuecancel += $roommeetingrevenueconfirmloss->RoomMeeting;
            }
            if ($roomonlyrevenueconfirmloss != null) {
                $totalrevenuecancel += $roomonlyrevenueconfirmloss->RoomOnly; //oke
            }
            if ($packagerevenueconfirmloss != null) {
                $totalrevenuecancel += $packagerevenueconfirmloss->PackageRevenue;
            }
            if ($additionalrevenueconfirmloss != null) {
                $totalrevenuecancel += $additionalrevenueconfirmloss->AddtionalRevenue;
            }
            if ($fnbrevenueconfirmloss != null) {
                $totalrevenuecancel += $fnbrevenueconfirmloss->FBRevenue;
            }
            if ($stallrevenueconfirmloss != null) {
                $totalrevenuecancel += $stallrevenueconfirmloss->TotalRevenue;
            }

            //////////////////////////////////////////////////////////////////
            //offering LOSS
            if ($roommeetingrevenueoffloss != null) {

                $totalrevenuecancel += $roommeetingrevenueoffloss->RoomOnly;
            }
            if ($meetingpackagerevenueoffloss->TotalMP != null) {

                $totalrevenuecancel += $meetingpackagerevenueoffloss->TotalMP + 0.001;
            }
            if ($additionalrevenueoffloss->TotalAdditional != null) {

                $totalrevenuecancel += $additionalrevenueoffloss->TotalAdditional;
            }

            if ($packagerevenueoffloss->TotalPackage != null) {

                $totalrevenuecancel += $packagerevenueoffloss->TotalPackage;
            }
            if ($roomrentalrevenueloss->RevenueRoomRental != null) {

                $totalrevenuecancel += $roomrentalrevenueloss->RevenueRoomRental;
            }
            if ($stallrevenueoffloss->TotalRevenue != null) {
                $totalrevenuecancel += $stallrevenueoffloss->TotalRevenue;
            }
            //end offering loss

            if ($row->nama_segment == "Corporate") {
                $targetsegment = $tgCorporate;
            }

            if ($row->nama_segment == "Goverment") {
                $targetsegment = $tgGov;
            }

            if ($row->nama_segment == "Event") {
                $targetsegment = $tgEvent;
            }

            if ($row->nama_segment == "Travel Agent") {
                $targetsegment = $tgTravel;
            }

            $dt_cd[] = number_format($totalrevenuedefinitconfirm, 0, ',', '') + 0;

            $dt_d[] = number_format($totalrevenuedefinit, 0, ',', '') + 0;

            $dt_cancel[] = number_format($totalrevenuecancel, 0, ',', '') + 0;

            $dt_target[] = number_format($targetsegment, 0, ',', '') + 0;

            if ($max_value < $targetsegment) {
                $max_value = $targetsegment;
            }
            if ($max_value < $totalrevenuecancel) {
                $max_value = $totalrevenuecancel;
            }
            if ($max_value < $totalrevenuedefinitconfirm) {
                $max_value = $totalrevenuedefinitconfirm;
            }
        }//end foreach

        $bar_cd = new bar_3d(75, '#FF3300');
        $bar_cd->set_values($dt_cd);
        $bar_cd->colour('#FF3300');

        $bar_cancel = new bar_3d(75, '#000000');
        $bar_cancel->set_values($dt_cancel);
        $bar_cancel->colour('#000000');

        $bar_target = new bar_3d(75, '#1e1ef1');
        $bar_target->set_values($dt_target);
        $bar_target->colour('#1e1ef1');

        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');
        $y->set_range(0, number_format($max_value + 300000000, 0, ',', '') + 0, 500000000);

        $x_labels = new x_axis_labels();
        $x_labels->rotate(20);
        $x_labels->set_labels($comsegment);
        $x = new x_axis();
        $x->set_colours('#909090', '#ffffff');
        $x->set_labels($x_labels);
        $x->set_3d(5);

        $tooltip = new tooltip();
        $tooltip->set_hover();

        $chart = new open_flash_chart();
        $chart->add_element($bar_target);
        $chart->add_element($bar_cd);
        $chart->add_element($bar_cancel);
        $chart->set_x_axis($x);
        $chart->add_y_axis($y);
        $chart->set_tooltip($tooltip);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toPrettyString();
    }

    function get_revenuebysegmentpersales_chart() {
        $data_com_segment = $this->account_segment_model->select_account_segment();
        $dt_segment = $this->sales_group_model->get_group_nohotel();
        $comsegment = array();

        $this->load->plugin('ofc2');

        $tgCorporate = 0;
        $tgEvent = 0;
        $tgGov = 0;
        $tgTravel = 0;
        foreach ($dt_segment->result() AS $row) {
            if ($row->nama_sg == "Corporate 1") {
                $tgCorporate += $row->amount;
            }
            if ($row->nama_sg == "Corporate 2") {
                $tgCorporate += $row->amount;
            }
            if ($row->nama_sg == "Goverment") {
                $tgGov += $row->amount;
            }
            if ($row->nama_sg == "Travel Agent") {
                $tgTravel += $row->amount;
            }
            if ($row->nama_sg == "Event") {
                $tgEvent += $row->amount;
            }
        }

        $max_value = 0;

        $dt_cd = array();
        $dt_d = array();
        $dt_cancel = array();
        $dt_target = array();
        foreach ($data_com_segment->result() AS $row) {
            $comsegment[] = $row->nama_segment;
            $targetsegment = 0;
            $totalrevenuedefinit = 0;
            $totalrevenueconfirm = 0;
            $totalrevenuecancel = 0;
            $totalrevenuedefinitconfirm = 0;



            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue_by_companysegment('definit', $row->idcomseg);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_by_companysegment('definit', $row->idcomseg);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue_by_companysegment('definit', $row->idcomseg);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_by_companysegment('definit', $row->idcomseg);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue_by_companysegment('definit', $row->idcomseg);
            //new 6 May 2010///////////////////////////
            $dt_roomrental_definit_comseg = $this->confirm_view_model->select_revenueroomrental_by_companysegment($row->idcomseg, date('F'), date('Y'), 'definit');
            if ($dt_roomrental_definit_comseg != null) {
                $totalrevenuedefinit += $dt_roomrental_definit_comseg->RevenueRoomRental;
                $totalrevenuedefinitconfirm += $dt_roomrental_definit_comseg->RevenueRoomRental;
            }
            if ($roommeetingrevenue != null) {
                $totalrevenuedefinit += $roommeetingrevenue->RoomMeeting;
                $totalrevenuedefinitconfirm += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalrevenuedefinit += $roomonlyrevenue->RoomOnly; //oke
                $totalrevenuedefinitconfirm += $roomonlyrevenue->RoomOnly;
            }
            if ($packagerevenue != null) {
                $totalrevenuedefinit += $packagerevenue->PackageRevenue;
                $totalrevenuedefinitconfirm += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalrevenuedefinit += $additionalrevenue->AddtionalRevenue;
                $totalrevenuedefinitconfirm += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalrevenuedefinit += $fnbrevenue->FBRevenue;
                $totalrevenuedefinitconfirm += $fnbrevenue->FBRevenue;
            }

            $roommeetingrevenueconfirm = $this->confirm_view_model->select_roommeetingmeetingrevenue_by_companysegment('confirm', $row->idcomseg);
            $roomonlyrevenueconfirm = $this->confirm_view_model->select_roomonlyrevenue_by_companysegment('confirm', $row->idcomseg);
            $packagerevenueconfirm = $this->confirm_view_model->select_packagerevenue_by_companysegment('confirm', $row->idcomseg);
            $additionalrevenueconfirm = $this->confirm_view_model->select_additionalrevenue_by_companysegment('confirm', $row->idcomseg);
            $fnbrevenueconfirm = $this->confirm_view_model->select_fnbrevenue_by_companysegment('confirm', $row->idcomseg);
            //new 6 May 2010///////////////////////////
            $dt_roomrental_confirm_comseg = $this->confirm_view_model->select_revenueroomrental_by_companysegment($row->idcomseg, date('F'), date('Y'), 'confirm');
            if ($dt_roomrental_confirm_comseg != null) {
                $totalrevenueconfirm += $dt_roomrental_confirm_comseg->RevenueRoomRental;
                $totalrevenuedefinitconfirm += $dt_roomrental_confirm_comseg->RevenueRoomRental;
            }
            //////////////////////////////////////////
            if ($roommeetingrevenueconfirm != null) {
                $totalrevenueconfirm += $roommeetingrevenueconfirm->RoomMeeting;
                $totalrevenuedefinitconfirm += $roommeetingrevenueconfirm->RoomMeeting;
            }
            if ($roomonlyrevenueconfirm != null) {
                $totalrevenueconfirm += $roomonlyrevenueconfirm->RoomOnly; //oke
                $totalrevenuedefinitconfirm += $roomonlyrevenueconfirm->RoomOnly; //oke
            }
            if ($packagerevenueconfirm != null) {
                $totalrevenueconfirm += $packagerevenueconfirm->PackageRevenue;
                $totalrevenuedefinitconfirm += $packagerevenueconfirm->PackageRevenue;
            }
            if ($additionalrevenueconfirm != null) {
                $totalrevenueconfirm += $additionalrevenueconfirm->AddtionalRevenue;
                $totalrevenuedefinitconfirm += $additionalrevenueconfirm->AddtionalRevenue;
            }
            if ($fnbrevenueconfirm != null) {
                $totalrevenueconfirm += $fnbrevenueconfirm->FBRevenue;
                $totalrevenuedefinitconfirm += $fnbrevenueconfirm->FBRevenue;
            }


            $roommeetingrevenueconfirmpost = $this->confirm_view_model->select_roommeetingmeetingrevenue_by_companysegment('POSTPONED', $row->idcomseg);
            $roomonlyrevenueconfirmpost = $this->confirm_view_model->select_roomonlyrevenue_by_companysegment('POSTPONED', $row->idcomseg);
            $packagerevenueconfirmpost = $this->confirm_view_model->select_packagerevenue_by_companysegment('POSTPONED', $row->idcomseg);
            $additionalrevenueconfirmpost = $this->confirm_view_model->select_additionalrevenue_by_companysegment('POSTPONED', $row->idcomseg);
            $fnbrevenueconfirmpost = $this->confirm_view_model->select_fnbrevenue_by_companysegment('POSTPONED', $row->idcomseg);
            //new 6 May 2010///////////////////////////
            $dt_roomrental_confirm_comsegpost = $this->confirm_view_model->select_revenueroomrental_by_companysegment($row->idcomseg, date('F'), date('Y'), 'POSTPONED');
            if ($dt_roomrental_confirm_comsegpost != null) {
                $totalrevenueconfirm += $dt_roomrental_confirm_comsegpost->RevenueRoomRental;
                $totalrevenuedefinitconfirm += $dt_roomrental_confirm_comsegpost->RevenueRoomRental;
            }
            //////////////////////////////////////////
            if ($roommeetingrevenueconfirmpost != null) {
                $totalrevenueconfirm += $roommeetingrevenueconfirmpost->RoomMeeting;
                $totalrevenuedefinitconfirm += $roommeetingrevenueconfirmpost->RoomMeeting;
            }
            if ($roomonlyrevenueconfirmpost != null) {
                $totalrevenueconfirm += $roomonlyrevenueconfirmpost->RoomOnly; //oke
                $totalrevenuedefinitconfirm += $roomonlyrevenueconfirmpost->RoomOnly; //oke
            }
            if ($packagerevenueconfirmpost != null) {
                $totalrevenueconfirm += $packagerevenueconfirmpost->PackageRevenue;
                $totalrevenuedefinitconfirm += $packagerevenueconfirmpost->PackageRevenue;
            }
            if ($additionalrevenueconfirmpost != null) {
                $totalrevenueconfirm += $additionalrevenueconfirmpost->AddtionalRevenue;
                $totalrevenuedefinitconfirm += $additionalrevenueconfirmpost->AddtionalRevenue;
            }
            if ($fnbrevenueconfirmpost != null) {
                $totalrevenueconfirm += $fnbrevenueconfirmpost->FBRevenue;
                $totalrevenuedefinitconfirm += $fnbrevenueconfirmpost->FBRevenue;
            }

            $roommeetingrevenueconfirmloss = $this->confirm_view_model->select_roommeetingmeetingrevenue_by_companysegment('LOSS', $row->idcomseg);
            $roomonlyrevenueconfirmloss = $this->confirm_view_model->select_roomonlyrevenue_by_companysegment('LOSS', $row->idcomseg);
            $packagerevenueconfirmloss = $this->confirm_view_model->select_packagerevenue_by_companysegment('LOSS', $row->idcomseg);
            $additionalrevenueconfirmloss = $this->confirm_view_model->select_additionalrevenue_by_companysegment('LOSS', $row->idcomseg);
            $fnbrevenueconfirmloss = $this->confirm_view_model->select_fnbrevenue_by_companysegment('LOSS', $row->idcomseg);

            $roommeetingrevenueoffloss = $this->offering_view_model->select_roommeetingmeetingrevenue_bystatuscompany('LOSS', $row->idcomseg);
            $meetingpackagerevenueoffloss = $this->offering_view_model->select_fnbrevenue_bystatuscompany('LOSS', $row->idcomseg);
            $additionalrevenueoffloss = $this->offering_view_model->select_additionalrevenue_bystatuscompany('LOSS', $row->idcomseg);
            $packagerevenueoffloss = $this->offering_view_model->select_packagerevenue_bystatuscompany('LOSS', $row->idcomseg);
            $roomrentalrevenueloss = $this->offering_view_model->select_roomrental_bystatuscompany('LOSS', $row->idcomseg);

            $dt_roomrental_confirmloss_comseg = $this->confirm_view_model->select_revenueroomrental_by_companysegment($row->idcomseg, date('F'), date('Y'), 'LOSS');
            if ($dt_roomrental_confirmloss_comseg != null) {
                $totalrevenuecancel += $dt_roomrental_confirmloss_comseg->RevenueRoomRental;
            }
            //////////////////////////////////////////



            if ($roommeetingrevenueconfirmloss != null) {
                $totalrevenuecancel += $roommeetingrevenueconfirmloss->RoomMeeting;
            }
            if ($roomonlyrevenueconfirmloss != null) {
                $totalrevenuecancel += $roomonlyrevenueconfirmloss->RoomOnly; //oke
            }
            if ($packagerevenueconfirmloss != null) {
                $totalrevenuecancel += $packagerevenueconfirmloss->PackageRevenue;
            }
            if ($additionalrevenueconfirmloss != null) {
                $totalrevenuecancel += $additionalrevenueconfirmloss->AddtionalRevenue;
            }
            if ($fnbrevenueconfirmloss != null) {
                $totalrevenuecancel += $fnbrevenueconfirmloss->FBRevenue;
            }


            //////////////////////////////////////////////////////////////////
            //offering LOSS
            if ($roommeetingrevenueoffloss != null) {

                $totalrevenuecancel += $roommeetingrevenueoffloss->RoomOnly;
            }
            if ($meetingpackagerevenueoffloss->TotalMP != null) {

                $totalrevenuecancel += $meetingpackagerevenueoffloss->TotalMP + 0.001;
            }
            if ($additionalrevenueoffloss->TotalAdditional != null) {

                $totalrevenuecancel += $additionalrevenueoffloss->TotalAdditional;
            }

            if ($packagerevenueoffloss->TotalPackage != null) {

                $totalrevenuecancel += $packagerevenueoffloss->TotalPackage;
            }
            if ($roomrentalrevenueloss->RevenueRoomRental != null) {

                $totalrevenuecancel += $roomrentalrevenueloss->RevenueRoomRental;
            }
            //end offering loss


            if ($row->nama_segment == "Corporate") {
                $targetsegment = $tgCorporate;
            }

            if ($row->nama_segment == "Goverment") {
                $targetsegment = $tgGov;
            }

            if ($row->nama_segment == "Event") {
                $targetsegment = $tgEvent;
            }

            if ($row->nama_segment == "Travel Agent") {
                $targetsegment = $tgTravel;
            }

            $dt_cd[] = $totalrevenuedefinitconfirm;

            $dt_d[] = $totalrevenuedefinit;

            $dt_cancel[] = $totalrevenuecancel;

            $dt_target[] = $targetsegment;

            if ($max_value < $targetsegment) {
                $max_value = $targetsegment;
            }
            if ($max_value < $totalrevenuecancel) {
                $max_value = $totalrevenuecancel;
            }
            if ($max_value < $totalrevenuedefinitconfirm) {
                $max_value = $totalrevenuedefinitconfirm;
            }
        }//end foreach

        $bar_cd = new bar_3d(75, '#FF3300');
        $bar_cd->set_values($dt_cd);
        $bar_cd->colour('#FF3300');

        $bar_cancel = new bar_3d(75, '#000000');
        $bar_cancel->set_values($dt_cancel);
        $bar_cancel->colour('#000000');

        $bar_target = new bar_3d(75, '#1e1ef1');
        $bar_target->set_values($dt_target);
        $bar_target->colour('#1e1ef1');

        $x = ceil($max_value / 5);

        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');
        $y->set_range(0, $max_value + $x);

        $x_labels = new x_axis_labels();
        $x_labels->rotate(20);
        $x_labels->set_labels($comsegment);
        $x = new x_axis();
        $x->set_colours('#909090', '#ffffff');
        $x->set_labels($x_labels);
        $x->set_3d(5);

        $tooltip = new tooltip();
        $tooltip->set_hover();

        $chart = new open_flash_chart();
        $chart->add_element($bar_target);
        $chart->add_element($bar_cd);
        $chart->add_element($bar_cancel);
        $chart->set_x_axis($x);
        $chart->add_y_axis($y);
        $chart->set_tooltip($tooltip);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toPrettyString();
    }

    function graph_achievementbysalesindividual() {
        $this->load->plugin('ofc2');
        $dt_salestarget = $this->sales_model->select_salesonly_new();
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
        $index = 0;
        foreach ($dt_salestarget->result() AS $row) {
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
                $total_definit_sales += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $total_definit_sales += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $total_definit_sales += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $total_definit_sales += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $total_definit_sales += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $total_definit_sales += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $total_definit_sales += $stallrevenue->RevStall;
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
            
            
            $grand_total_confirm_sales += $total_confirm_sales;

            $total = (number_format($total_definit_sales, 0, ',', '')) + (number_format($total_confirm_sales, 0, ',', ''));
            if ($total <= 0) {
                $total = 0;
            }


            $d[] = new pie_value(number_format(floatval($total_confirm_sales), 0, '.', '') + number_format(floatval($total_definit_sales), 0, '.', ''), $row->firstname . ' ' . $row->lastname . ' [' . number_format(floatval($total), 0, ',', '.') . ']');
            $index++;
        }//endforeach

        
        if($dt_salestarget->result() == NULL){
               $d[] = new pie_value(0,  ' '  . ' [0]');
        } 
            
     

        $pie = new pie();
        $pie->alpha(0.5)
                ->add_animation(new pie_fade())
                ->add_animation(new pie_bounce(5))
                ->start_angle(270)
                ->start_angle(0)
                ->tooltip('#percent#<br>')
                ->colours(array("#fd031b", "#fd03e8", "#2c03fd", "#03ddfd", "#03ddfd", "#03fd32", "#000099", "#009900"));

        $pie->set_values($d);
        $chart = new open_flash_chart();
        $chart->add_element($pie);
        $chart->set_bg_colour('#ffffff');
        echo $chart->toPrettyString();
    }
    
    function graph_achievementbysalesindividual_onproperty() {
        $this->load->plugin('ofc2');
        $userproperty = $this->session->userdata('property');
        $dt_salestarget = $this->sales_model->select_salesonly_new();
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
        $index = 0;
        foreach ($dt_salestarget->result() AS $row) {
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

            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesonproperty($row->idsales, date('m'), date('Y'), 'definit',$userproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesonproperty($row->idsales, date('m'), date('Y'), 'definit',$userproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesonproperty($row->idsales, date('m'), date('Y'), 'definit',$userproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesonproperty($row->idsales, date('m'), date('Y'), 'definit',$userproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesonproperty($row->idsales, date('m'), date('Y'), 'definit',$userproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesonproperty($row->idsales, date('m'), date('Y'), 'definit',$userproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesonproperty($row->idsales, date('m'), date('Y'), 'definit',$userproperty);

            if ($roommeetingrevenue != null) {
                $total_definit_sales += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $total_definit_sales += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $total_definit_sales += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $total_definit_sales += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $total_definit_sales += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $total_definit_sales += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $total_definit_sales += $stallrevenue->RevStall;
            }
            //////////////////////////////////////////
            $grand_total_definit_sales += $total_definit_sales;

            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesonproperty($row->idsales, date('m'), date('Y'), 'confirm',$userproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesonproperty($row->idsales, date('m'), date('Y'), 'confirm',$userproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesonproperty($row->idsales, date('m'), date('Y'), 'confirm',$userproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesonproperty($row->idsales, date('m'), date('Y'), 'confirm',$userproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesonproperty($row->idsales, date('m'), date('Y'), 'confirm',$userproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesonproperty($row->idsales, date('m'), date('Y'), 'confirm',$userproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesonproperty($row->idsales, date('m'), date('Y'), 'confirm',$userproperty);

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
          

            $grand_total_confirm_sales += $total_confirm_sales;

            $total = (number_format($total_definit_sales, 0, ',', '')) + (number_format($total_confirm_sales, 0, ',', ''));
            if ($total <= 0) {
                $total = 0;
            }


            $d[] = new pie_value(number_format(floatval($total_confirm_sales), 0, '.', '') + number_format(floatval($total_definit_sales), 0, '.', ''), $row->firstname . ' ' . $row->lastname . ' [' . number_format(floatval($total), 0, ',', '.') . ']');
            $index++;
        }//endforeach


        $pie = new pie();
        $pie->alpha(0.5)
                ->add_animation(new pie_fade())
                ->add_animation(new pie_bounce(5))
                ->start_angle(270)
                ->start_angle(0)
                ->tooltip('#percent#<br>')
                ->colours(array("#fd031b", "#fd03e8", "#2c03fd", "#03ddfd", "#03ddfd", "#03fd32", "#000099", "#009900"));

        $pie->set_values($d);
        $chart = new open_flash_chart();
        $chart->add_element($pie);
        $chart->set_bg_colour('#ffffff');
        echo $chart->toPrettyString();
    }

    function graph_achievementbysalesindividual_persales() {
        $this->load->plugin('ofc2');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;
        $dt_salestarget = $this->sales_model->select_salesonlynew_per_segment($salessegment);
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
        $index = 0;
        foreach ($dt_salestarget->result() AS $row) {
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
                $total_definit_sales += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $total_definit_sales += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $total_definit_sales += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $total_definit_sales += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $total_definit_sales += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $total_definit_sales += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $total_definit_sales += $stallrevenue->RevStall;
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
          

            $grand_total_confirm_sales += $total_confirm_sales;

            $total = (number_format($total_definit_sales, 0, ',', '')) + (number_format($total_confirm_sales, 0, ',', ''));
            if ($total <= 0) {
                $total = 0;
            }


            $d[] = new pie_value(number_format(floatval($total_confirm_sales), 0, '.', '') + number_format(floatval($total_definit_sales), 0, '.', ''), $row->firstname . ' ' . $row->lastname . ' [' . number_format(floatval($total), 0, ',', '.') . ']');
            $index++;
        }//endforeach


        $pie = new pie();
        $pie->alpha(0.5)
                ->add_animation(new pie_fade())
                ->add_animation(new pie_bounce(5))
                ->start_angle(270)
                ->start_angle(0)
                ->tooltip('#percent#<br>')
                ->colours(array("#fd031b", "#fd03e8", "#2c03fd", "#03ddfd", "#03ddfd", "#03fd32", "#000099", "#009900"));

        $pie->set_values($d);
        $chart = new open_flash_chart();
        $chart->add_element($pie);
        $chart->set_bg_colour('#ffffff');
        echo $chart->toPrettyString();
    }
    
    function graph_achievementbysalesindividual_persales_property() {
        $this->load->plugin('ofc2');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;
        $dt_salestarget = $this->sales_model->select_salestargetpersegment_perproperty($salessegment,$userproperty);
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
        $index = 0;
        foreach ($dt_salestarget->result() AS $row) {
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
                $total_definit_sales += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $total_definit_sales += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $total_definit_sales += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $total_definit_sales += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $total_definit_sales += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $total_definit_sales += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $total_definit_sales += $stallrevenue->RevStall;
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
          

            $grand_total_confirm_sales += $total_confirm_sales;

            $total = (number_format($total_definit_sales, 0, ',', '')) + (number_format($total_confirm_sales, 0, ',', ''));
            if ($total <= 0) {
                $total = 0;
            }


            $d[] = new pie_value(number_format(floatval($total_confirm_sales), 0, '.', '') + number_format(floatval($total_definit_sales), 0, '.', ''), $row->firstname . ' ' . $row->lastname . ' [' . number_format(floatval($total), 0, ',', '.') . ']');
            $index++;
        }//endforeach


        $pie = new pie();
        $pie->alpha(0.5)
                ->add_animation(new pie_fade())
                ->add_animation(new pie_bounce(5))
                ->start_angle(270)
                ->start_angle(0)
                ->tooltip('#percent#<br>')
                ->colours(array("#fd031b", "#fd03e8", "#2c03fd", "#03ddfd", "#03ddfd", "#03fd32", "#000099", "#009900"));

        $pie->set_values($d);
        $chart = new open_flash_chart();
        $chart->add_element($pie);
        $chart->set_bg_colour('#ffffff');
        echo $chart->toPrettyString();
    }
    
    function get_salesindividualpersegment_chart() {
        $this->load->plugin('ofc2');
        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;

        $dt_salestarget = $this->sales_model->select_salestargetpersegment($salessegment);
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
        $index = 0;
        foreach ($dt_salestarget->result() AS $row) {
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

            $dt_fb_definit_sales = $this->definit_letter_model->select_total_fb_by_sales($row->idsales, date('F'), date('Y'), 'definit');
            if ($dt_fb_definit_sales != null) {
                $total_definit_sales += $dt_fb_definit_sales->totalfbdefinit;
            }
            $dt_room_only_definit_sales = $this->definit_letter_model->select_total_room_only_by_sales($row->idsales, date('F'), date('Y'), 'definit');
            if ($dt_room_only_definit_sales != null) {
                $total_definit_sales += $dt_room_only_definit_sales->totalroomonly;
            }
            $dt_room_meeting_definit_sales = $this->definit_letter_model->select_total_room_meeting_by_sales($row->idsales, date('F'), date('Y'), 'definit');
            if ($dt_room_meeting_definit_sales != null) {
                $total_definit_sales += $dt_room_meeting_definit_sales->totalroommeeting;
            }
            $dt_package_definit_sales = $this->definit_letter_model->select_total_package_by_sales($row->idsales, date('F'), date('Y'), 'definit');
            if ($dt_package_definit_sales != null) {
                $total_definit_sales += $dt_package_definit_sales->totalpackage;
            }
            $dt_additional_definit_sales = $this->definit_letter_model->select_total_additional_by_sales($row->idsales, date('F'), date('Y'), 'definit');
            if ($dt_additional_definit_sales != null) {
                $total_definit_sales += $dt_additional_definit_sales->totaladditional;
            }
            //new 6 May 2010///////////////////////////
            $dt_roomrental_definit_sales = $this->confirm_view_model->select_revenueroomrental_by_sales($row->idsales, date('F'), date('Y'), 'definit');
            if ($dt_roomrental_definit_sales != null) {
                $total_definit_sales += $dt_roomrental_definit_sales->RevenueRoomRental;
            }
            //////////////////////////////////////////
            $grand_total_definit_sales += $total_definit_sales;

            $dt_fb_confirm_sales = $this->definit_letter_model->select_total_fb_by_sales($row->idsales, date('F'), date('Y'), 'confirm');
            if ($dt_fb_confirm_sales != null) {
                $total_confirm_sales += $dt_fb_confirm_sales->totalfbdefinit;
            }
            $dt_room_only_confirm_sales = $this->definit_letter_model->select_total_room_only_by_sales($row->idsales, date('F'), date('Y'), 'confirm');
            if ($dt_room_only_confirm_sales != null) {
                $total_confirm_sales += $dt_room_only_confirm_sales->totalroomonly;
            }
            $dt_room_meeting_confirm_sales = $this->definit_letter_model->select_total_room_meeting_by_sales($row->idsales, date('F'), date('Y'), 'confirm');
            if ($dt_room_meeting_confirm_sales != null) {
                $total_confirm_sales += $dt_room_meeting_confirm_sales->totalroommeeting;
            }
            $dt_package_confirm_sales = $this->definit_letter_model->select_total_package_by_sales($row->idsales, date('F'), date('Y'), 'confirm');
            if ($dt_package_confirm_sales != null) {
                $total_confirm_sales += $dt_package_confirm_sales->totalpackage;
            }
            $dt_additional_confirm_sales = $this->definit_letter_model->select_total_additional_by_sales($row->idsales, date('F'), date('Y'), 'confirm');
            if ($dt_additional_confirm_sales != null) {
                $total_confirm_sales += $dt_additional_confirm_sales->totaladditional;
            }
            //new 6 May 2010///////////////////////////
            $dt_roomrental_confirm_sales = $this->confirm_room_rental_model->select_revenueroomrental_bysales($row->idsales, date('F'), date('Y'), 'confirm');
            if ($dt_roomrental_confirm_sales != null) {
                $total_confirm_sales += $dt_roomrental_confirm_sales->RevenueRoomRental;
            }
            //////////////////////////////////////////
            $grand_total_confirm_sales += $total_confirm_sales;

            $total = (number_format($total_definit_sales, 0, ',', '')) + (number_format($total_confirm_sales, 0, ',', ''));
            if ($total <= 0) {
                $total = '-';
            }

            $d[] = new pie_value(number_format(floatval($total_confirm_sales), 0, '.', '') + number_format(floatval($total_definit_sales), 0, '.', ''), $row->firstname . ' ' . $row->lastname . ' [' . number_format(floatval($total), 0, ',', '.') . ']');
            $index++;
        }//endforeach


        $pie = new pie();
        $pie->alpha(0.5)
                ->add_animation(new pie_fade())
                ->add_animation(new pie_bounce(5))
                ->start_angle(270)
                ->start_angle(0)
                ->tooltip('#percent#<br>')
                ->colours(array("#fd031b", "#fd03e8", "#2c03fd", "#03ddfd", "#03ddfd", "#03fd32", "#000099", "#009900"));
        $pie->set_values($d);

        $chart = new open_flash_chart();
         $chart->add_element($pie);
        $chart->set_bg_colour('#ffffff');
        echo $chart->toPrettyString();
    }

    function graph_revenuebysalesgroup()
    {
        $this->load->plugin('ofc2');
        //$dt_segment = $this->sales_group_model->get_group_nohotel();
        $dt_segment = $this->sales_group_model->select_salesgroup_kagum();
        $userproperty = $this->session->userdata('property');
        //$comsegment = array();
        $max_value = 0;

        foreach ($dt_segment->result() as $row) {
            $total_definit_all = 0;
            $total_confirm_all = 0;
            $comsegment[] = $row->nama_sg;

            ///////////
            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'confirm');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroup($row->idsalesgroup, date('m'), date('Y'), 'confirm');
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'confirm');
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'confirm');
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'confirm');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevroomrental_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'confirm');
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'confirm');
            if ($roommeetingrevenue != null) {
                $total_confirm_all += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $total_confirm_all += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $total_confirm_all += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $total_confirm_all += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $total_confirm_all += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $total_confirm_all += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $total_confirm_all += $stallrevenue->RevStall;
            }
//            /////////
//            ///////////
            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'POSTPONED');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroup($row->idsalesgroup, date('m'), date('Y'), 'POSTPONED');
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'POSTPONED');
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'POSTPONED');
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'POSTPONED');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevroomrental_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'POSTPONED');
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'POSTPONED');
            if ($roommeetingrevenue != null) {
                $total_confirm_all += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $total_confirm_all += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $total_confirm_all += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $total_confirm_all += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $total_confirm_all += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $total_confirm_all += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $total_confirm_all += $stallrevenue->RevStall;
            }
//            /////////
//            ///////////
            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'definit');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroup($row->idsalesgroup, date('m'), date('Y'), 'definit');
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'definit');
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'definit');
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'definit');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevroomrental_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'definit');
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroup($row->idsalesgroup,date('m'), date('Y'), 'definit');
            if ($roommeetingrevenue != null) {
                $total_definit_all += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $total_definit_all += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $total_definit_all += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $total_definit_all += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $total_definit_all += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $total_definit_all += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $total_definit_all += $stallrevenue->RevStall;
            }
            /////////


            $total = $total_confirm_all + $total_definit_all;
            //$data[] = number_format($total_confirm_all+$total_definit_all,0,'.','');
            $datax[] = new bar_value(floatval($total_confirm_all + $total_definit_all));
            if ($max_value < $total) {
                $max_value = $total;
            }
        }

        $x_labels = new x_axis_labels();
        $x_labels->rotate(20);
        $x_labels->set_labels($comsegment);
        $x = new x_axis();
        $x->set_colours('#000000', '#ffffff');
        $x->set_labels($x_labels);

        $tooltip = new tooltip();
        $tooltip->set_hover();

        $bar = new bar_glass();
        $bar->set_values($datax);

        $chart = new open_flash_chart();
        $chart->add_element($bar);
        $chart->set_x_axis($x);
        $chart->set_tooltip($tooltip);

        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');
        $y->set_range(0, $max_value + ceil($max_value / 10));
        $chart->add_y_axis($y);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toString();
    }
    
    
    function graph_revenuebysalesgroup_property() {
        $this->load->plugin('ofc2');
        //$dt_segment = $this->sales_group_model->get_group_nohotel();
        $dt_segment = $this->sales_group_model->select_salesgroup_kagum();
        $userproperty = $this->session->userdata('property');
        //$comsegment = array();
        $max_value = 0;

        foreach ($dt_segment->result() as $row) {
            $total_definit_all = 0;
            $total_confirm_all = 0;
            $comsegment[] = $row->nama_sg;

            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'confirm', $userproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'confirm', $userproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'confirm', $userproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'confirm', $userproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'confirm', $userproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'confirm', $userproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'confirm', $userproperty);

            if ($roommeetingrevenue != null) {
                $total_confirm_all += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $total_confirm_all += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $total_confirm_all += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $total_confirm_all += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $total_confirm_all += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $total_confirm_all += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $total_confirm_all += $stallrevenue->RevStall;
            }
 
            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'postponed', $userproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'postponed', $userproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'postponed', $userproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'postponed', $userproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'postponed', $userproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'postponed', $userproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'postponed', $userproperty);
            if ($roommeetingrevenue != null) {
                $total_confirm_all += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $total_confirm_all += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $total_confirm_all += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $total_confirm_all += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $total_confirm_all += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $total_confirm_all += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $total_confirm_all += $stallrevenue->RevStall;
            }
 
            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'definit', $userproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'definit', $userproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'definit', $userproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'definit', $userproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'definit', $userproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'definit', $userproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($row->idsalesgroup, date('m'), date('Y'), 'definit', $userproperty);
            if ($roommeetingrevenue != null) {
                $total_definit_all += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $total_definit_all += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $total_definit_all += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $total_definit_all += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $total_definit_all += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $total_definit_all += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $total_definit_all += $stallrevenue->RevStall;
            }
           
            $total = $total_confirm_all + $total_definit_all;
            
            $datax[] = new bar_value(floatval($total_confirm_all + $total_definit_all));
            if ($max_value < $total) {
                $max_value = $total;
            }
        }

        $x_labels = new x_axis_labels();
        $x_labels->rotate(20);
        $x_labels->set_labels($comsegment);
        $x = new x_axis();
        $x->set_colours('#000000', '#ffffff');
        $x->set_labels($x_labels);

        $tooltip = new tooltip();
        $tooltip->set_hover();

        $bar = new bar_glass();
        $bar->set_values($datax);

        $chart = new open_flash_chart();
        $chart->add_element($bar);
        $chart->set_x_axis($x);
        $chart->set_tooltip($tooltip);

        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');
        $y->set_range(0, $max_value + ceil($max_value / 10));
        $chart->add_y_axis($y);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toString();
    }

    function graph_revenuebysalesgroup_sales() {
        $this->load->plugin('ofc2');
        //$dt_segment = $this->sales_group_model->get_group_nohotel();
        $dt_segment = $this->sales_group_model->select_salesgroup_kagum();
        $userproperty = $this->session->userdata('property');

        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;

        //$comsegment = array();
        $max_value = 0;

//        foreach ($dt_segment->result() as $row) {
        $total_definit_all = 0;
        $total_confirm_all = 0;
        $comsegment[] = $dt_sales->nama_sg;

        ///////////
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
        $roomrentalrevenue = $this->confirm_view_model->select_clrevroomrental_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
        if ($roommeetingrevenue != null) {
            $total_confirm_all += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $total_confirm_all += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $total_confirm_all += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $total_confirm_all += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $total_confirm_all += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $total_confirm_all += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $total_confirm_all += $stallrevenue->RevStall;
        }
//            /////////
 
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroup($salessegment, date('m'), date('Y'), 'POSTPONED');
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroup($salessegment, date('m'), date('Y'), 'POSTPONED');
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroup($salessegment, date('m'), date('Y'), 'POSTPONED');
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroup($salessegment, date('m'), date('Y'), 'POSTPONED');
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroup($salessegment, date('m'), date('Y'), 'POSTPONED');
        $roomrentalrevenue = $this->confirm_view_model->select_clrevroomrental_persalesgroup($salessegment, date('m'), date('Y'), 'POSTPONED');
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroup($salessegment, date('m'), date('Y'), 'POSTPONED');
        if ($roommeetingrevenue != null) {
            $total_confirm_all += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $total_confirm_all += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $total_confirm_all += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $total_confirm_all += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $total_confirm_all += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $total_confirm_all += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $total_confirm_all += $stallrevenue->RevStall;
        }
 
//            ///////////
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
        $roomrentalrevenue = $this->confirm_view_model->select_clrevroomrental_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
        if ($roommeetingrevenue != null) {
            $total_definit_all += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $total_definit_all += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $total_definit_all += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $total_definit_all += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $total_definit_all += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $total_definit_all += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $total_definit_all += $stallrevenue->RevStall;
        }
        /////////


        $total = $total_confirm_all + $total_definit_all;
        //$data[] = number_format($total_confirm_all+$total_definit_all,0,'.','');
        $datax[] = new bar_value(floatval($total_confirm_all + $total_definit_all));
        if ($max_value < $total) {
            $max_value = $total;
        }
//        }

        $x_labels = new x_axis_labels();
        $x_labels->rotate(20);
        $x_labels->set_labels($comsegment);
        $x = new x_axis();
        $x->set_colours('#000000', '#ffffff');
        $x->set_labels($x_labels);

        $tooltip = new tooltip();
        $tooltip->set_hover();

        $bar = new bar_glass();
        $bar->set_values($datax);

        $chart = new open_flash_chart();
        $chart->add_element($bar);
        $chart->set_x_axis($x);
        $chart->set_tooltip($tooltip);

        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');
        $y->set_range(0, $max_value + ceil($max_value / 10));
        $chart->add_y_axis($y);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toString();
    }

    
    function graph_revenuebysalesgroup_sales_property() {
        $this->load->plugin('ofc2');
        //$dt_segment = $this->sales_group_model->get_group_nohotel();
        $dt_segment = $this->sales_group_model->select_salesgroup_kagum();
        $userproperty = $this->session->userdata('property');

        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;

       
        $max_value = 0;
 
        $total_definit_all = 0;
        $total_confirm_all = 0;
        $comsegment[] = $dt_sales->nama_sg;

       
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
         if ($roommeetingrevenue != null) {
            $total_confirm_all += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $total_confirm_all += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $total_confirm_all += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $total_confirm_all += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $total_confirm_all += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $total_confirm_all += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $total_confirm_all += $stallrevenue->RevStall;
        }
//            /////////
 
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        if ($roommeetingrevenue != null) {
            $total_confirm_all += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $total_confirm_all += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $total_confirm_all += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $total_confirm_all += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $total_confirm_all += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $total_confirm_all += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $total_confirm_all += $stallrevenue->RevStall;
        }
 
 
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        if ($roommeetingrevenue != null) {
            $total_definit_all += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $total_definit_all += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $total_definit_all += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $total_definit_all += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $total_definit_all += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $total_definit_all += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $total_definit_all += $stallrevenue->RevStall;
        }



        $total = $total_confirm_all + $total_definit_all;
        //$data[] = number_format($total_confirm_all+$total_definit_all,0,'.','');
        $datax[] = new bar_value(floatval($total_confirm_all + $total_definit_all));
        if ($max_value < $total) {
            $max_value = $total;
        }
//        }

        $x_labels = new x_axis_labels();
        $x_labels->rotate(20);
        $x_labels->set_labels($comsegment);
        $x = new x_axis();
        $x->set_colours('#000000', '#ffffff');
        $x->set_labels($x_labels);

        $tooltip = new tooltip();
        $tooltip->set_hover();

        $bar = new bar_glass();
        $bar->set_values($datax);

        $chart = new open_flash_chart();
        $chart->add_element($bar);
        $chart->set_x_axis($x);
        $chart->set_tooltip($tooltip);

        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');
        $y->set_range(0, $max_value + ceil($max_value / 10));
        $chart->add_y_axis($y);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toString();
    }
    
    function get_salesgrouppergm_chart() {
        $this->load->plugin('ofc2');
        $dt_segment = $this->sales_group_model->get_group_nohotel();
        // $dt_segment = $this->sales_group_model->select_group();
        $userproperty = $this->session->userdata('property');
        $comsegment = array();
        $max_value = 0;
        foreach ($dt_segment->result() as $row) {
            $total_definit_all = 0;
            $total_confirm_all = 0;
            $comsegment[] = $row->nama_sg;

            $dt_fb_definit_sales = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($row->idsalesgroup,$userproperty, date('F'), date('Y'), 'definit');
            if ($dt_fb_definit_sales != null) {
                $total_definit_all += $dt_fb_definit_sales->totalfbdefinit;
            }
            $dt_room_only_definit_sales = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($row->idsalesgroup,$userproperty, date('F'), date('Y'), 'definit');
            if ($dt_room_only_definit_sales != null) {
                $total_definit_all += $dt_room_only_definit_sales->totalroomonly;
            }
            $dt_room_meeting_definit_sales = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($row->idsalesgroup,$userproperty, date('F'), date('Y'), 'definit');
            if ($dt_room_meeting_definit_sales != null) {
                $total_definit_all += $dt_room_meeting_definit_sales->totalroommeeting;
            }
            $dt_package_definit_sales = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($row->idsalesgroup,$userproperty, date('F'), date('Y'), 'definit');
            if ($dt_package_definit_sales != null) {
                $total_definit_all += $dt_package_definit_sales->totalpackage;
            }
            $dt_additional_definit_sales = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($row->idsalesgroup,$userproperty, date('F'), date('Y'), 'definit');
            if ($dt_additional_definit_sales != null) {
                $total_definit_all += $dt_additional_definit_sales->totaladditional;
            }
            //new 6 May 2010///////////////////////////
            $dt_roomrental_definit_sales = $this->definit_letter_model->select_roomrentalrevenue_by_salesgrouppropmonthyearstatus($row->idsalesgroup,$userproperty, date('F'), date('Y'), 'definit');
            if ($dt_roomrental_definit_sales != null) {
                $total_definit_all += $dt_roomrental_definit_sales->TotalRevenue;
            }

            $dt_stalldefinit = $this->definit_letter_model->select_stallrevenue_by_salesgrouppropmonthyearstatus($row->idsalesgroup,$userproperty,"definit",date('F'),date('Y'));
            if($dt_stalldefinit != NULL)
            {
                $total_definit_all += $dt_stalldefinit->TotalRevenue;
            }

            $dt_fb_confirm_sales = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($row->idsalesgroup,$userproperty, date('F'), date('Y'), 'confirm');
            if ($dt_fb_confirm_sales != null) {
                $total_confirm_all += $dt_fb_confirm_sales->totalfbdefinit;
            }
            $dt_room_only_confirm_sales = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($row->idsalesgroup,$userproperty, date('F'), date('Y'), 'confirm');
            if ($dt_room_only_confirm_sales != null) {
                $total_confirm_all += $dt_room_only_confirm_sales->totalroomonly;
            }
            $dt_room_meeting_confirm_sales = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($row->idsalesgroup,$userproperty, date('F'), date('Y'), 'confirm');
            if ($dt_room_meeting_confirm_sales != null) {
                $total_confirm_all += $dt_room_meeting_confirm_sales->totalroommeeting;
            }
            $dt_package_confirm_sales = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($row->idsalesgroup,$userproperty, date('F'), date('Y'), 'confirm');
            if ($dt_package_confirm_sales != null) {
                $total_confirm_all += $dt_package_confirm_sales->totalpackage;
            }
            $dt_additional_confirm_sales = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($row->idsalesgroup,$userproperty, date('F'), date('Y'), 'confirm');
            if ($dt_additional_confirm_sales != null) {
                $total_confirm_all += $dt_additional_confirm_sales->totaladditional;
            }
            //new 6 May 2010///////////////////////////
            $dt_roomrental_confirm_sales = $this->definit_letter_model->select_roomrentalrevenue_by_salesgrouppropmonthyearstatus($row->idsalesgroup, $userproperty,date('F'), date('Y'), 'confirm');
            if ($dt_roomrental_confirm_sales != null) {
                $total_confirm_all += $dt_roomrental_confirm_sales->TotalRevenue;
            }

            $dt_stallconfirm = $this->definit_letter_model->select_stallrevenue_by_salesgrouppropmonthyearstatus($row->idsalesgroup,$userproperty,"confirm",date('F'),date('Y'));
            if($dt_stallconfirm != NULL)
            {
                $total_confirm_all += $dt_stallconfirm->TotalRevenue;
            }

            $dt_fb_confirm_sales = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($row->idsalesgroup,$userproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_fb_confirm_sales != null) {
                $total_confirm_all += $dt_fb_confirm_sales->totalfbdefinit;
            }
            $dt_room_only_confirm_sales = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($row->idsalesgroup,$userproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_room_only_confirm_sales != null) {
                $total_confirm_all += $dt_room_only_confirm_sales->totalroomonly;
            }
            $dt_room_meeting_confirm_sales = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($row->idsalesgroup,$userproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_room_meeting_confirm_sales != null) {
                $total_confirm_all += $dt_room_meeting_confirm_sales->totalroommeeting;
            }
            $dt_package_confirm_sales = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($row->idsalesgroup, $userproperty,date('F'), date('Y'), 'POSTPONED');
            if ($dt_package_confirm_sales != null) {
                $total_confirm_all += $dt_package_confirm_sales->totalpackage;
            }
            $dt_additional_confirm_sales = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($row->idsalesgroup,$userproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_additional_confirm_sales != null) {
                $total_confirm_all += $dt_additional_confirm_sales->totaladditional;
            }
            //new 6 May 2010///////////////////////////
            $dt_roomrental_confirm_sales = $this->definit_letter_model->select_roomrentalrevenue_by_salesgrouppropmonthyearstatus($row->idsalesgroup, $userproperty,date('F'), date('Y'), 'POSTPONED');
            if ($dt_roomrental_confirm_sales != null) {
                $total_confirm_all += $dt_roomrental_confirm_sales->RevenueRoomRental;
            }

            $dt_stallconfirm = $this->definit_letter_model->select_stallrevenue_by_salesgrouppropmonthyearstatus($row->idsalesgroup,$userproperty,"POSTPONED",date('F'),date('Y'));
            if($dt_stallconfirm != NULL)
            {
                $total_confirm_all += $dt_stallconfirm->TotalRevenue;
            }


            $total = $total_confirm_all + $total_definit_all;
            //$data[] = number_format($total_confirm_all+$total_definit_all,0,'.','');
            $datax[] = new bar_value(number_format($total_definit_all + $total_confirm_all, 0, '.', '') + 0);
            if ($max_value < $total) {
                $max_value = $total;
            }
        }

        $x_labels = new x_axis_labels();
        $x_labels->rotate(20);
        $x_labels->set_labels($comsegment);
        $x = new x_axis();
        $x->set_colours('#000000', '#ffffff');
        $x->set_labels($x_labels);

        $bar = new bar_glass();
        $bar->set_values($datax);

        $chart = new open_flash_chart();
        $chart->add_element($bar);
        $chart->set_x_axis($x);

        
        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');
        $y->set_range(0, $max_value + 500000000, 200000000);
        $chart->add_y_axis($y);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toString();
    }

    function get_salesgrouppersales_chart() {
        $this->load->plugin('ofc2');
        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');
 
        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;
        $dt_segment = $this->sales_group_model->select_group_by_id($salessegment);

        //$dt_segment = $this->sales_group_model->select_group();
        $comsegment = array();
        $max_value = 0;
//        foreach ($dt_segment->result() as $row) {
        if ($dt_segment != NULL) {
            $total_definit_all = 0;
            $total_confirm_all = 0;
            $comsegment[] = $dt_segment->nama_sg;


            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevroomrental_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
            if ($roommeetingrevenue != null) {
                $total_definit_all += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $total_definit_all += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $total_definit_all += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $total_definit_all += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $total_definit_all += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $total_definit_all += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $total_definit_all += $stallrevenue->RevStall;
            }




            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevroomrental_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
            if ($roommeetingrevenue != null) {
                $total_confirm_all += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $total_confirm_all += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $total_confirm_all += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $total_confirm_all += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $total_confirm_all += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $total_confirm_all += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $total_confirm_all += $stallrevenue->RevStall;
            }





            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroup($salessegment, date('m'), date('Y'), 'POSTPONED');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroup($salessegment, date('m'), date('Y'), 'POSTPONED');
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroup($salessegment, date('m'), date('Y'), 'POSTPONED');
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroup($salessegment, date('m'), date('Y'), 'POSTPONED');
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroup($salessegment, date('m'), date('Y'), 'POSTPONED');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevroomrental_persalesgroup($salessegment, date('m'), date('Y'), 'POSTPONED');
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroup($salessegment, date('m'), date('Y'), 'POSTPONED');
            if ($roommeetingrevenue != null) {
                $total_confirm_all += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $total_confirm_all += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $total_confirm_all += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $total_confirm_all += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $total_confirm_all += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $total_confirm_all += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $total_confirm_all += $stallrevenue->RevStall;
            }

 

            $total = floatval($total_confirm_all + $total_definit_all);
            //$data[] = number_format($total_confirm_all+$total_definit_all,0,'.','');
            $datax[] = new bar_value(number_format(floatval($total_confirm_all + $total_definit_all), 0, '.', '') + 0);
            if ($max_value < $total) {
                $max_value = $total;
            }
//        }
        }//end if

        $xv = ceil($max_value/5);

        $x_labels = new x_axis_labels();
        $x_labels->rotate(20);
        $x_labels->set_labels($comsegment);
        $x = new x_axis();
        $x->set_colours('#000000', '#ffffff');
        $x->set_labels($x_labels);

        $bar = new bar_glass();
        $bar->set_values($datax);

        $chart = new open_flash_chart();
        $chart->add_element($bar);
        $chart->set_x_axis($x);

        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');
        $y->set_range(0, number_format(floatval($max_value) + $xv, 0, ',', '') + 0,$xv);
        $chart->add_y_axis($y);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toString();
    }


     
    function get_salesgrouppersalesproperty_chart() {
        $this->load->plugin('ofc2');
        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;

        //$dt_segment = $this->sales_group_model->get_group_nohotel();
        $dt_segment = $this->sales_group_model->select_group_by_id($salessegment);

        //$dt_segment = $this->sales_group_model->select_group();
        $comsegment = array();
        $max_value = 0;
//        foreach ($dt_segment->result() as $row) {
        if ($dt_segment != NULL) {
            $total_definit_all = 0;
            $total_confirm_all = 0;
            $comsegment[] = $dt_segment->nama_sg;
            //definit
            $dt_fb_definit_sales = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'definit');
            if ($dt_fb_definit_sales != null) {
                $total_definit_all += $dt_fb_definit_sales->totalfbdefinit;
            }
            $dt_room_only_definit_sales = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'definit');
            if ($dt_room_only_definit_sales != null) {
                $total_definit_all += $dt_room_only_definit_sales->totalroomonly;
            }
            $dt_room_meeting_definit_sales = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'definit');
            if ($dt_room_meeting_definit_sales != null) {
                $total_definit_all += $dt_room_meeting_definit_sales->totalroommeeting;
            }
            $dt_package_definit_sales = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'definit');
            if ($dt_package_definit_sales != null) {
                $total_definit_all += $dt_package_definit_sales->totalpackage;
            }
            $dt_additional_definit_sales = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'definit');
            if ($dt_additional_definit_sales != null) {
                $total_definit_all += $dt_additional_definit_sales->totaladditional;
            }
            //new 6 May 2010///////////////////////////
            $dt_roomrental_definit_sales = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'definit');
            if ($dt_roomrental_definit_sales != null) {
                $total_definit_all += $dt_roomrental_definit_sales->TotalRevenueRoomRental;
            }
            //end definit
            //confirm
            $dt_fb_confirm_sales = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'confirm');
            if ($dt_fb_confirm_sales != null) {
                $total_confirm_all += $dt_fb_confirm_sales->totalfbdefinit;
            }
            $dt_room_only_confirm_sales = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'confirm');
            if ($dt_room_only_confirm_sales != null) {
                $total_confirm_all += $dt_room_only_confirm_sales->totalroomonly;
            }
            $dt_room_meeting_confirm_sales = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'confirm');
            if ($dt_room_meeting_confirm_sales != null) {
                $total_confirm_all += $dt_room_meeting_confirm_sales->totalroommeeting;
            }
            $dt_package_confirm_sales = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'confirm');
            if ($dt_package_confirm_sales != null) {
                $total_confirm_all += $dt_package_confirm_sales->totalpackage;
            }
            $dt_additional_confirm_sales = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'confirm');
            if ($dt_additional_confirm_sales != null) {
                $total_confirm_all += $dt_additional_confirm_sales->totaladditional;
            }
            //new 6 May 2010///////////////////////////
            $dt_roomrental_confirm_sales = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'confirm');
            if ($dt_roomrental_confirm_sales != null) {
                $total_confirm_all += $dt_roomrental_confirm_sales->TotalRevenueRoomRental;
            }
            //end confirm
            //postponed
            $dt_fb_confirm_sales = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_fb_confirm_sales != null) {
                $total_confirm_all += $dt_fb_confirm_sales->totalfbdefinit;
            }
            $dt_room_only_confirm_sales = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_room_only_confirm_sales != null) {
                $total_confirm_all += $dt_room_only_confirm_sales->totalroomonly;
            }
            $dt_room_meeting_confirm_sales = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_room_meeting_confirm_sales != null) {
                $total_confirm_all += $dt_room_meeting_confirm_sales->totalroommeeting;
            }
            $dt_package_confirm_sales = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_package_confirm_sales != null) {
                $total_confirm_all += $dt_package_confirm_sales->totalpackage;
            }
            $dt_additional_confirm_sales = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_additional_confirm_sales != null) {
                $total_confirm_all += $dt_additional_confirm_sales->totaladditional;
            }
            //new 6 May 2010///////////////////////////
            $dt_roomrental_confirm_sales = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($dt_segment->idsalesgroup, $userproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_roomrental_confirm_sales != null) {
                $total_confirm_all += $dt_roomrental_confirm_sales->TotalRevenueRoomRental;
            }
            //end postponed

            $total = $total_confirm_all + $total_definit_all;
            //$data[] = number_format($total_confirm_all+$total_definit_all,0,'.','');
            //$datax[] = new bar_value(number_format(  $total_confirm_all + $total_definit_all  , 0, '.', '')+ 0 );
            $datax[] = new bar_value(100);
            if ($max_value < $total) {
                $max_value = $total;
            }
//        }
        }//end if

        $x_labels = new x_axis_labels();
        $x_labels->rotate(20);
        $x_labels->set_labels($comsegment);
        $x = new x_axis();
        $x->set_colours('#000000', '#ffffff');
        $x->set_labels($x_labels);

        $bar = new bar_glass();
        $bar->set_values($datax);

        $chart = new open_flash_chart();
        $chart->add_element($bar);
        $chart->set_x_axis($x);

        $y = new y_axis();
        $y->set_colours('#000000', '#d0d0d0');
        $y->set_range(0, $max_value + 500000000, 200000000);
        $chart->add_y_axis($y);
        $chart->set_bg_colour('#FFFFFF');
        echo $chart->toString();
    }

   function graph_monthlyrevenue()
   {
       $this->load->plugin('ofc2');
        //confirm revenue
        $totalcl = 0;
        $totalol = 0;
        $totalloss = 0;
        $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_periodstatus( date('m'),date('Y'),'confirm');
        $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_periodstatus(date('m'),date('Y'),'confirm');
        $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_periodstatus(date('m'),date('Y'),'confirm');
        $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_periodstatus(date('m'),date('Y'),'confirm');
        $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_periodstatus(date('m'),date('Y'),'confirm');
        $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_periodstatus(date('m'),date('Y'),'confirm');
        $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_periodstatus(date('m'),date('Y'),'confirm');
        if ($roommeetingrevenue != null) {
            $totalcl += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalcl += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalcl += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalcl += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalcl += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalcl += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalcl += $stallrevenue->RevStall;
        }
        //endconfirmreveue

        //definit revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_periodstatus( date('m'),date('Y'),'definit');
        $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_periodstatus(date('m'),date('Y'),'definit');
        $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_periodstatus(date('m'),date('Y'),'definit');
        $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_periodstatus(date('m'),date('Y'),'definit');
        $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_periodstatus(date('m'),date('Y'),'definit');
        $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_periodstatus(date('m'),date('Y'),'definit');
        $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_periodstatus(date('m'),date('Y'),'definit');
        if ($roommeetingrevenue != null) {
            $totalcl += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalcl += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalcl += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalcl += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalcl += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalcl += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalcl += $stallrevenue->RevStall;
        }
        //enddefinitreveue
//
//        //postponed revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_periodstatus(date('m'),date('Y'),'postponed');
        $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_periodstatus(date('m'),date('Y'),'postponed');
        $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_periodstatus(date('m'),date('Y'),'postponed');
        $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_periodstatus(date('m'),date('Y'),'postponed');
        $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_periodstatus(date('m'),date('Y'),'postponed');
        $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_periodstatus(date('m'),date('Y'),'postponed');
        $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_periodstatus(date('m'),date('Y'),'postponed');
        if ($roommeetingrevenue != null) {
            $totalcl += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalcl += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalcl += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalcl += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalcl += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalcl += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalcl += $stallrevenue->RevStall;
        }
        //endpostponedreveue

        //clloss revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_periodstatus(date('m'),date('Y'),'loss');
        $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_periodstatus(date('m'),date('Y'),'loss');
        $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_periodstatus(date('m'),date('Y'),'loss');
        $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_periodstatus(date('m'),date('Y'),'loss');
        $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_periodstatus(date('m'),date('Y'),'loss');
        $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_periodstatus(date('m'),date('Y'),'loss');
        $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_periodstatus(date('m'),date('Y'),'loss');
        if ($roommeetingrevenue != null) {
            $totalloss += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalloss += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalloss += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalloss += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalloss += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalloss += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalloss += $stallrevenue->RevStall;
        }
        //endclloss

        //ol revenue
        $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_periodstatus(date('m'),date('Y'),'offering');
        $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_periodstatus(date('m'),date('Y'),'offering');
        $packagerevenue = $this->offering_view_model->select_packagerevenue_per_periodstatus(date('m'),date('Y'),'offering');
        $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_periodstatus(date('m'),date('Y'),'offering');
        $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_periodstatus(date('m'),date('Y'),'offering');
        $stallrevenue = $this->offering_view_model->select_stallrevenue_per_periodstatus(date('m'),date('Y'),'offering');
        if ($roomonlyrevenue != null) {
            $totalol += $roomonlyrevenue->RevRoomOnly;
        }
        if ($additionalrevenue != null) {
            $totalol += $additionalrevenue->RevAdditional;
        }
        if ($packagerevenue != null) {
            $totalol += $packagerevenue->RevPackage;
        }
        if ($meetingrevenue != null) {
            $totalol += $meetingrevenue->RevMeetingPackage;
        }
        if ($roomrentalrevenue != null) {
            $totalol += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalol += $stallrevenue->RevStall;
        }
        //endolreveue

        //ol postponed revenue
        $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_periodstatus(date('m'),date('Y'),'postponed');
        $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_periodstatus(date('m'),date('Y'),'postponed');
        $packagerevenue = $this->offering_view_model->select_packagerevenue_per_periodstatus(date('m'),date('Y'),'postponed');
        $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_periodstatus(date('m'),date('Y'),'postponed');
        $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_periodstatus(date('m'),date('Y'),'postponed');
        $stallrevenue = $this->offering_view_model->select_stallrevenue_per_periodstatus(date('m'),date('Y'),'postponed');
        if ($roomonlyrevenue != null) {
            $totalol += $roomonlyrevenue->RevRoomOnly;
        }
        if ($additionalrevenue != null) {
            $totalol += $additionalrevenue->RevAdditional;
        }
        if ($packagerevenue != null) {
            $totalol += $packagerevenue->RevPackage;
        }
        if ($meetingrevenue != null) {
            $totalol += $meetingrevenue->RevMeetingPackage;
        }
        if ($roomrentalrevenue != null) {
            $totalol += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalol += $stallrevenue->RevStall;
        }
        //endol postponed reveue
        //ol loss revenue
        $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_periodstatus(date('m'),date('Y'),'loss');
        $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_periodstatus(date('m'),date('Y'),'loss');
        $packagerevenue = $this->offering_view_model->select_packagerevenue_per_periodstatus(date('m'),date('Y'),'loss');
        $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_periodstatus(date('m'),date('Y'),'loss');
        $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_periodstatus(date('m'),date('Y'),'loss');
        $stallrevenue = $this->offering_view_model->select_stallrevenue_per_periodstatus(date('m'),date('Y'),'loss');
        if ($roomonlyrevenue != null) {
            $totalloss += $roomonlyrevenue->RevRoomOnly;
        }
        if ($additionalrevenue != null) {
            $totalloss += $additionalrevenue->RevAdditional;
        }
        if ($packagerevenue != null) {
            $totalloss += $packagerevenue->RevPackage;
        }
        if ($meetingrevenue != null) {
            $totalloss += $meetingrevenue->RevMeetingPackage;
        }
        if ($roomrentalrevenue != null) {
            $totalloss += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalloss += $stallrevenue->RevStall;
        }
        //endolloss reveue


        $mxVal = 0;

        $pie = new pie();
        //$pie->set_alpha(0.6);

        $pie->add_animation(new pie_fade());
        $pie->alpha(0.5)
                ->add_animation(new pie_fade())
                ->add_animation(new pie_bounce(5))
                //->start_angle( 270 )
                ->start_angle(0)
                ->tooltip('#percent# - #val#')
                ->colours(array("#fb0505", "#28c802", "#000000", "#e3d104"));

        $revenueconfirm = floatval($totalcl);
        $revenueoffering = floatval($totalol);
        $cancel = floatval($totalloss);

        $pie->set_values(array(new pie_value($revenueconfirm, number_format($revenueconfirm, 0, ',', '.')),
            new pie_value($revenueoffering, number_format($revenueoffering, 0, ',', '.')),
            new pie_value($cancel, number_format($cancel, 0, ',', '.'))
        ));
        $chart = new open_flash_chart();
        $chart->set_bg_colour("#ffffff");
 
        $chart->add_element($pie);
        echo $chart->toPrettyString();
   }
   
    function graph_monthlyrevenue_sales() {
        $this->load->plugin('ofc2');
        $idsales = $this->session->userdata('idstaff');
        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;
        //confirm revenue
        $totalcl = 0;
        $totalol = 0;
        $totalloss = 0;
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
        $roomrentalrevenue = $this->confirm_view_model->select_clrevroomrental_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroup($salessegment, date('m'), date('Y'), 'confirm');
        if ($roommeetingrevenue != null) {
            $totalcl += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalcl += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalcl += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalcl += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalcl += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalcl += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalcl += $stallrevenue->RevStall;
        }
        //endconfirmreveue
        //definit revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
        $roomrentalrevenue = $this->confirm_view_model->select_clrevroomrental_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroup($salessegment, date('m'), date('Y'), 'definit');
        if ($roommeetingrevenue != null) {
            $totalcl += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalcl += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalcl += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalcl += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalcl += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalcl += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalcl += $stallrevenue->RevStall;
        }
        //enddefinitreveue
//
//        //postponed revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroup($salessegment, date('m'), date('Y'), 'postponed');
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroup($salessegment, date('m'), date('Y'), 'postponed');
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroup($salessegment, date('m'), date('Y'), 'postponed');
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroup($salessegment, date('m'), date('Y'), 'postponed');
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroup($salessegment, date('m'), date('Y'), 'postponed');
        $roomrentalrevenue = $this->confirm_view_model->select_clrevroomrental_persalesgroup($salessegment, date('m'), date('Y'), 'postponed');
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroup($salessegment, date('m'), date('Y'), 'postponed');
        if ($roommeetingrevenue != null) {
            $totalcl += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalcl += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalcl += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalcl += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalcl += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalcl += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalcl += $stallrevenue->RevStall;
        }
        //endpostponedreveue
        //clloss revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroup($salessegment, date('m'), date('Y'), 'loss');
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroup($salessegment, date('m'), date('Y'), 'loss');
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroup($salessegment, date('m'), date('Y'), 'loss');
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroup($salessegment, date('m'), date('Y'), 'loss');
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroup($salessegment, date('m'), date('Y'), 'loss');
        $roomrentalrevenue = $this->confirm_view_model->select_clrevroomrental_persalesgroup($salessegment, date('m'), date('Y'), 'loss');
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroup($salessegment, date('m'), date('Y'), 'loss');
        if ($roommeetingrevenue != null) {
            $totalloss += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalloss += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalloss += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalloss += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalloss += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalloss += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalloss += $stallrevenue->RevStall;
        }
        //endclloss
        //ol revenue
        $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'offering');
        $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'offering');
        $packagerevenue = $this->offering_view_model->select_packagerevenue_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'offering');
        $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'offering');
        $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'offering');
        $stallrevenue = $this->offering_view_model->select_stallrevenue_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'offering');
        if ($roomonlyrevenue != null) {
            $totalol += $roomonlyrevenue->RevRoomOnly;
        }
        if ($additionalrevenue != null) {
            $totalol += $additionalrevenue->RevAdditional;
        }
        if ($packagerevenue != null) {
            $totalol += $packagerevenue->RevPackage;
        }
        if ($meetingrevenue != null) {
            $totalol += $meetingrevenue->RevMeetingPackage;
        }
        if ($roomrentalrevenue != null) {
            $totalol += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalol += $stallrevenue->RevStall;
        }
        //endolreveue
        //ol postponed revenue
        $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'postponed');
        $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'postponed');
        $packagerevenue = $this->offering_view_model->select_packagerevenue_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'postponed');
        $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'postponed');
        $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'postponed');
        $stallrevenue = $this->offering_view_model->select_stallrevenue_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'postponed');
        if ($roomonlyrevenue != null) {
            $totalol += $roomonlyrevenue->RevRoomOnly;
        }
        if ($additionalrevenue != null) {
            $totalol += $additionalrevenue->RevAdditional;
        }
        if ($packagerevenue != null) {
            $totalol += $packagerevenue->RevPackage;
        }
        if ($meetingrevenue != null) {
            $totalol += $meetingrevenue->RevMeetingPackage;
        }
        if ($roomrentalrevenue != null) {
            $totalol += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalol += $stallrevenue->RevStall;
        }
        //endol postponed reveue
        //ol loss revenue
        $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'loss');
        $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'loss');
        $packagerevenue = $this->offering_view_model->select_packagerevenue_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'loss');
        $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'loss');
        $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'loss');
        $stallrevenue = $this->offering_view_model->select_stallrevenue_per_salesgroupperiodstatus($salessegment, date('m'), date('Y'), 'loss');
        if ($roomonlyrevenue != null) {
            $totalloss += $roomonlyrevenue->RevRoomOnly;
        }
        if ($additionalrevenue != null) {
            $totalloss += $additionalrevenue->RevAdditional;
        }
        if ($packagerevenue != null) {
            $totalloss += $packagerevenue->RevPackage;
        }
        if ($meetingrevenue != null) {
            $totalloss += $meetingrevenue->RevMeetingPackage;
        }
        if ($roomrentalrevenue != null) {
            $totalloss += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalloss += $stallrevenue->RevStall;
        }
        //endolloss reveue


        $mxVal = 0;

        $pie = new pie();
        //$pie->set_alpha(0.6);

        $pie->add_animation(new pie_fade());
        $pie->alpha(0.5)
                ->add_animation(new pie_fade())
                ->add_animation(new pie_bounce(5))
                //->start_angle( 270 )
                ->start_angle(0)
                ->tooltip('#percent# - #val#')
                ->colours(array("#fb0505", "#28c802", "#000000", "#e3d104"));

        $revenueconfirm = floatval($totalcl);
        $revenueoffering = floatval($totalol);
        $cancel = floatval($totalloss);

        $pie->set_values(array(new pie_value($revenueconfirm, number_format($revenueconfirm, 0, ',', '.')),
            new pie_value($revenueoffering, number_format($revenueoffering, 0, ',', '.')),
            new pie_value($cancel, number_format($cancel, 0, ',', '.'))
        ));
        $chart = new open_flash_chart();
        $chart->set_bg_colour("#ffffff");

        $chart->add_element($pie);
        echo $chart->toPrettyString();
    }

   
   function graph_monthlyrevenue_sales_property() {
        $this->load->plugin('ofc2');
        $idsales = $this->session->userdata('idstaff');
        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $userproperty = $this->session->userdata('property');
        $salessegment = $dt_sales->id_salesgroupFK;
        //confirm revenue
        $totalcl = 0;
        $totalol = 0;
        $totalloss = 0;
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm', $userproperty);
        if ($roommeetingrevenue != null) {
            $totalcl += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalcl += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalcl += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalcl += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalcl += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalcl += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalcl += $stallrevenue->RevStall;
        }
        //endconfirmreveue
        //definit revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit', $userproperty);
        if ($roommeetingrevenue != null) {
            $totalcl += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalcl += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalcl += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalcl += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalcl += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalcl += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalcl += $stallrevenue->RevStall;
        }
        //enddefinitreveue
        //postponed revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed', $userproperty);
        if ($roommeetingrevenue != null) {
            $totalcl += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalcl += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalcl += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalcl += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalcl += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalcl += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalcl += $stallrevenue->RevStall;
        }
        //endpostponedreveue
        //clloss revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss', $userproperty);
        $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss', $userproperty);
        $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss', $userproperty);
        $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss', $userproperty);
        $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss', $userproperty);
        $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss', $userproperty);
        $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss', $userproperty);
        if ($roommeetingrevenue != null) {
            $totalloss += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalloss += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalloss += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalloss += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalloss += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalloss += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalloss += $stallrevenue->RevStall;
        }
        //endclloss
        //ol revenue
        $roomonlyrevenue = $this->offering_view_model->select_revroomonly_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'offering');
        $additionalrevenue = $this->offering_view_model->select_revadditional_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'offering');
        $packagerevenue = $this->offering_view_model->select_revpackage_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'offering');
        $meetingrevenue = $this->offering_view_model->select_revmeetingpackage_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'offering');
        $roomrentalrevenue = $this->offering_view_model->select_revroomrental_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'offering');
        $stallrevenue = $this->offering_view_model->select_revstall_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'offering');
        if ($roomonlyrevenue != null) {
            $totalol += $roomonlyrevenue->RevRoomOnly;
        }
        if ($additionalrevenue != null) {
            $totalol += $additionalrevenue->RevAdditional;
        }
        if ($packagerevenue != null) {
            $totalol += $packagerevenue->RevPackage;
        }
        if ($meetingrevenue != null) {
            $totalol += $meetingrevenue->RevMeetingPackage;
        }
        if ($roomrentalrevenue != null) {
            $totalol += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalol += $stallrevenue->RevStall;
        }
        //endolreveue
        //ol postponed revenue
        $roomonlyrevenue = $this->offering_view_model->select_revroomonly_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'postponed');
        $additionalrevenue = $this->offering_view_model->select_revadditional_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'postponed');
        $packagerevenue = $this->offering_view_model->select_revpackage_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'postponed');
        $meetingrevenue = $this->offering_view_model->select_revmeetingpackage_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'postponed');
        $roomrentalrevenue = $this->offering_view_model->select_revroomrental_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'postponed');
        $stallrevenue = $this->offering_view_model->select_revstall_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'postponed');
        if ($roomonlyrevenue != null) {
            $totalol += $roomonlyrevenue->RevRoomOnly;
        }
        if ($additionalrevenue != null) {
            $totalol += $additionalrevenue->RevAdditional;
        }
        if ($packagerevenue != null) {
            $totalol += $packagerevenue->RevPackage;
        }
        if ($meetingrevenue != null) {
            $totalol += $meetingrevenue->RevMeetingPackage;
        }
        if ($roomrentalrevenue != null) {
            $totalol += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalol += $stallrevenue->RevStall;
        }
        //endol postponed reveue
        //ol loss revenue
        $roomonlyrevenue = $this->offering_view_model->select_revroomonly_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'loss');
        $additionalrevenue = $this->offering_view_model->select_revadditional_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'loss');
        $packagerevenue = $this->offering_view_model->select_revpackage_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'loss');
        $meetingrevenue = $this->offering_view_model->select_revmeetingpackage_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'loss');
        $roomrentalrevenue = $this->offering_view_model->select_revroomrental_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'loss');
        $stallrevenue = $this->offering_view_model->select_revstall_persalesgroup_property($salessegment, $userproperty, date('m'), date('Y'), 'loss');
        if ($roomonlyrevenue != null) {
            $totalloss += $roomonlyrevenue->RevRoomOnly;
        }
        if ($additionalrevenue != null) {
            $totalloss += $additionalrevenue->RevAdditional;
        }
        if ($packagerevenue != null) {
            $totalloss += $packagerevenue->RevPackage;
        }
        if ($meetingrevenue != null) {
            $totalloss += $meetingrevenue->RevMeetingPackage;
        }
        if ($roomrentalrevenue != null) {
            $totalloss += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalloss += $stallrevenue->RevStall;
        }
        //endolloss reveue


        $mxVal = 0;

        $pie = new pie();
        //$pie->set_alpha(0.6);

        $pie->add_animation(new pie_fade());
        $pie->alpha(0.5)
                ->add_animation(new pie_fade())
                ->add_animation(new pie_bounce(5))
                //->start_angle( 270 )
                ->start_angle(0)
                ->tooltip('#percent# - #val#')
                ->colours(array("#fb0505", "#28c802", "#000000", "#e3d104"));

        $revenueconfirm = floatval($totalcl);
        $revenueoffering = floatval($totalol);
        $cancel = floatval($totalloss);

        $pie->set_values(array(new pie_value($revenueconfirm, number_format($revenueconfirm, 0, ',', '.')),
            new pie_value($revenueoffering, number_format($revenueoffering, 0, ',', '.')),
            new pie_value($cancel, number_format($cancel, 0, ',', '.'))
        ));
        $chart = new open_flash_chart();
        $chart->set_bg_colour("#ffffff");

        $chart->add_element($pie);
        echo $chart->toPrettyString();
    }
    
    
    function graph_monthlyrevenue_property() {
        $this->load->plugin('ofc2');
         
        $userproperty = $this->session->userdata('property');
      
        //confirm revenue
        $totalcl = 0;
        $totalol = 0;
        $totalloss = 0;
        $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'confirm');
        $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'confirm');
        $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'confirm');
        $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'confirm');
        $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'confirm');
        $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'confirm');
        $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'confirm');
        if ($roommeetingrevenue != null) {
            $totalcl += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalcl += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalcl += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalcl += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalcl += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalcl += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalcl += $stallrevenue->RevStall;
        }
        //endconfirmreveue
        //definit revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'definit');
        $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'definit');
        $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'definit');
        $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'definit');
        $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'definit');
        $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'definit');
        $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'definit');
        if ($roommeetingrevenue != null) {
            $totalcl += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalcl += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalcl += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalcl += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalcl += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalcl += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalcl += $stallrevenue->RevStall;
        }
        //enddefinitreveue
        //postponed revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'postponed');
        $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'postponed');
        $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'postponed');
        $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'postponed');
        $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'postponed');
        $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'postponed');
        $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'postponed');
        if ($roommeetingrevenue != null) {
            $totalcl += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalcl += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalcl += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalcl += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalcl += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalcl += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalcl += $stallrevenue->RevStall;
        }
        //endpostponedreveue
        //clloss revenue
        $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'loss');
        $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'loss');
        $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'loss');
        $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'loss');
        $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'loss');
        $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'loss');
        $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($userproperty,date('m'),date('Y'),'loss');
        if ($roommeetingrevenue != null) {
            $totalloss += $roommeetingrevenue->RevRoomMeeting;
        }
        if ($roomonlyrevenue != null) {
            $totalloss += $roomonlyrevenue->RevRoomOnly; //oke
        }
        if ($packagerevenue != null) {
            $totalloss += $packagerevenue->RevPackage;
        }
        if ($additionalrevenue != null) {
            $totalloss += $additionalrevenue->RevAdditional;
        }
        if ($fnbrevenue != null) {
            $totalloss += $fnbrevenue->RevFB;
        }
        if ($roomrentalrevenue != null) {
            $totalloss += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalloss += $stallrevenue->RevStall;
        }
        //endclloss
        //ol revenue
        $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($userproperty,date('m'),date('Y'),'offering');
        $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($userproperty,date('m'),date('Y'),'offering');
        $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($userproperty,date('m'),date('Y'),'offering');
        $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($userproperty,date('m'),date('Y'),'offering');
        $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($userproperty,date('m'),date('Y'),'offering');
        $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($userproperty,date('m'),date('Y'),'offering');
        if ($roomonlyrevenue != null) {
            $totalol += $roomonlyrevenue->RevRoomOnly;
        }
        if ($additionalrevenue != null) {
            $totalol += $additionalrevenue->RevAdditional;
        }
        if ($packagerevenue != null) {
            $totalol += $packagerevenue->RevPackage;
        }
        if ($meetingrevenue != null) {
            $totalol += $meetingrevenue->RevMeetingPackage;
        }
        if ($roomrentalrevenue != null) {
            $totalol += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalol += $stallrevenue->RevStall;
        }
        //endolreveue
        //ol postponed revenue
        $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($userproperty,date('m'),date('Y'),'postponed');
        $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($userproperty,date('m'),date('Y'),'postponed');
        $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($userproperty,date('m'),date('Y'),'postponed');
        $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($userproperty,date('m'),date('Y'),'postponed');
        $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($userproperty,date('m'),date('Y'),'postponed');
        $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($userproperty,date('m'),date('Y'),'postponed');
        if ($roomonlyrevenue != null) {
            $totalol += $roomonlyrevenue->RevRoomOnly;
        }
        if ($additionalrevenue != null) {
            $totalol += $additionalrevenue->RevAdditional;
        }
        if ($packagerevenue != null) {
            $totalol += $packagerevenue->RevPackage;
        }
        if ($meetingrevenue != null) {
            $totalol += $meetingrevenue->RevMeetingPackage;
        }
        if ($roomrentalrevenue != null) {
            $totalol += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalol += $stallrevenue->RevStall;
        }
        //endol postponed reveue
        //ol loss revenue
        $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($userproperty,date('m'),date('Y'),'loss');
        $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($userproperty,date('m'),date('Y'),'loss');
        $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($userproperty,date('m'),date('Y'),'loss');
        $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($userproperty,date('m'),date('Y'),'loss');
        $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($userproperty,date('m'),date('Y'),'loss');
        $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($userproperty,date('m'),date('Y'),'loss');
        if ($roomonlyrevenue != null) {
            $totalloss += $roomonlyrevenue->RevRoomOnly;
        }
        if ($additionalrevenue != null) {
            $totalloss += $additionalrevenue->RevAdditional;
        }
        if ($packagerevenue != null) {
            $totalloss += $packagerevenue->RevPackage;
        }
        if ($meetingrevenue != null) {
            $totalloss += $meetingrevenue->RevMeetingPackage;
        }
        if ($roomrentalrevenue != null) {
            $totalloss += $roomrentalrevenue->RevRoomRental;
        }
        if ($stallrevenue != null) {
            $totalloss += $stallrevenue->RevStall;
        }
        //endolloss reveue


        $mxVal = 0;

        $pie = new pie();
        //$pie->set_alpha(0.6);

        $pie->add_animation(new pie_fade());
        $pie->alpha(0.5)
                ->add_animation(new pie_fade())
                ->add_animation(new pie_bounce(5))
                //->start_angle( 270 )
                ->start_angle(0)
                ->tooltip('#percent# - #val#')
                ->colours(array("#fb0505", "#28c802", "#000000", "#e3d104"));

        $revenueconfirm = floatval($totalcl);
        $revenueoffering = floatval($totalol);
        $cancel = floatval($totalloss);

        $pie->set_values(array(new pie_value($revenueconfirm, number_format($revenueconfirm, 0, ',', '.')),
            new pie_value($revenueoffering, number_format($revenueoffering, 0, ',', '.')),
            new pie_value($cancel, number_format($cancel, 0, ',', '.'))
        ));
        $chart = new open_flash_chart();
        $chart->set_bg_colour("#ffffff");

        $chart->add_element($pie);
        echo $chart->toPrettyString();
    }


    function get_totalrevenuehotel_sales() {
        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;

        $this->load->plugin('ofc2');
        $dt_hotel = $this->property_model->select_target_property();
        $total1 = 0;
        $total2 = 0;
        $total3 = 0;
        $total4 = 0;
        $grandtotal1 = 0;
        $grandtotal2 = 0;
        $grandtotal3 = 0;
        $grandtotal4 = 0;
        $grandtotaltarget = 0;

        $grandtotalbalance = 0;
        $totalbalance = 0;
        $totalAlltentative = 0;
        $totalAllcancel = 0;
        $grand_total_definit = 0;
        $grand_total_confirm = 0;
        $grand_total_confirm_postponed = 0;
        $grand_total_tentative = 0;
        $grand_total_tentative_postponed = 0;
        $grand_total_cancel = 0;
        foreach ($dt_hotel->result() as $row) {
            $totalcancel = 0;
            $total1 = 0;
            $total2 = 0;
            $total3 = 0;
            $total4 = 0;
            $total_definit = 0;
            $total_confirm = 0;
            $total_confirmpostponed = 0;

            $total_tentative = 0;
            $total_tentativepostponed = 0;

            $total_cancel = 0;

            //definit
            $dt_fb_definit = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'definit');
            if ($dt_fb_definit != null) {
                $total_definit += $dt_fb_definit->totalfbdefinit;
            }
            $dt_room_only_definit = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'definit');
            if ($dt_room_only_definit != null) {
                $total_definit += $dt_room_only_definit->totalroomonly;
            }
            $dt_room_meeting_definit = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'definit');
            if ($dt_room_meeting_definit != null) {
                $total_definit += $dt_room_meeting_definit->totalroommeeting;
            }
            $dt_package_definit = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'definit');
            if ($dt_package_definit != null) {
                $total_definit += $dt_package_definit->totalpackage;
            }
            $dt_additional_definit = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'definit');
            if ($dt_additional_definit != null) {
                $total_definit += $dt_additional_definit->totaladditional;
            }
            $dt_roomrentalhotel_definit = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'definit');
            if ($dt_roomrentalhotel_definit != null) {
                $total_definit += $dt_roomrentalhotel_definit->TotalRevenueRoomRental;
            }
            $grand_total_definit += $total_definit;
            //end definit
            //confirm
            $dt_fb_confirm = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'Confirm');
            if ($dt_fb_confirm != null) {
                $total_confirm += $dt_fb_confirm->totalfbdefinit;
            }
            $dt_room_only_confirm = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'Confirm');
            if ($dt_room_only_confirm != null) {
                $total_confirm += $dt_room_only_confirm->totalroomonly;
            }
            $dt_room_meeting_confirm = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'Confirm');
            if ($dt_room_meeting_confirm != null) {
                $total_confirm += $dt_room_meeting_confirm->totalroommeeting;
            }
            $dt_package_confirm = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'Confirm');
            if ($dt_package_confirm != null) {
                $total_confirm += $dt_package_confirm->totalpackage;
            }
            $dt_additional_confirm = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'Confirm');
            if ($dt_additional_confirm != null) {
                $total_confirm += $dt_additional_confirm->totaladditional;
            }
            $dt_roomrentalhotel_confirm = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'confirm');
            if ($dt_roomrentalhotel_confirm != null) {
                $total_confirm += $dt_roomrentalhotel_confirm->TotalRevenueRoomRental;
            }
            $grand_total_confirm += $total_confirm;
            //end confirm
            //POSTPONED
            $dt_fb_confirm = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_fb_confirm != null) {
                $total_confirmpostponed += $dt_fb_confirm->totalfbdefinit;
            }
            $dt_room_only_confirm = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_room_only_confirm != null) {
                $total_confirmpostponed += $dt_room_only_confirm->totalroomonly;
            }
            $dt_room_meeting_confirm = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_room_meeting_confirm != null) {
                $total_confirmpostponed += $dt_room_meeting_confirm->totalroommeeting;
            }
            $dt_package_confirm = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_package_confirm != null) {
                $total_confirmpostponed += $dt_package_confirm->totalpackage;
            }
            $dt_additional_confirm = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_additional_confirm != null) {
                $total_confirmpostponed += $dt_additional_confirm->totaladditional;
            }
            $dt_roomrentalhotel_confirm = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_roomrentalhotel_confirm != null) {
                $total_confirmpostponed += $dt_roomrentalhotel_confirm->TotalRevenueRoomRental;
            }
            $grand_total_confirm_postponed += $total_confirmpostponed;
            //end confirm POSTPONED


            $dt_meeting_package_tentative = $this->definit_letter_model->select_meetingpackage_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'offering');
            if ($dt_meeting_package_tentative != null) {
                $total_tentative += $dt_meeting_package_tentative->TotalMeetingPackage;
            }
            $dt_room_only_tentative = $this->definit_letter_model->select_roomonly_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'offering');
            if ($dt_room_only_tentative != null) {
                $total_tentative += $dt_room_only_tentative->RoomOnly;
            }
            $dt_additional_tentative = $this->definit_letter_model->select_additional_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'offering');
            if ($dt_additional_tentative != null) {
                $total_tentative += $dt_additional_tentative->TotalAdditional;
            }
            $dt_banquet_package_tentative = $this->definit_letter_model->select_banquetpackage_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'offering');
            if ($dt_banquet_package_tentative != null) {
                $total_tentative += $dt_banquet_package_tentative->TotalPackage;
            }
            //new 6 May 2010///////////////////////////
            $dt_roomrental_tentatif = $this->offering_view_model->select_roomrentalrevenue_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'offering');
            if ($dt_roomrental_tentatif != null) {
                $total_tentative += $dt_roomrental_tentatif->RevenueRoomRental;
            }
            $grand_total_tentative +=$total_tentative;


            $dt_meeting_package_tentative = $this->definit_letter_model->select_meetingpackage_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_meeting_package_tentative != null) {
                $total_tentativepostponed += $dt_meeting_package_tentative->TotalMeetingPackage;
            }
            $dt_room_only_tentative = $this->definit_letter_model->select_roomonly_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_room_only_tentative != null) {
                $total_tentativepostponed += $dt_room_only_tentative->RoomOnly;
            }
            $dt_additional_tentative = $this->definit_letter_model->select_additional_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_additional_tentative != null) {
                $total_tentativepostponed += $dt_additional_tentative->TotalAdditional;
            }
            $dt_banquet_package_tentative = $this->definit_letter_model->select_banquetpackage_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_banquet_package_tentative != null) {
                $total_tentativepostponed += $dt_banquet_package_tentative->TotalPackage;
            }
            //new 6 May 2010///////////////////////////
            $dt_roomrental_tentatif = $this->offering_view_model->select_roomrentalrevenue_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'POSTPONED');
            if ($dt_roomrental_tentatif != null) {
                $total_tentativepostponed += $dt_roomrental_tentatif->RevenueRoomRental;
            }
            $grand_total_tentative_postponed += $total_tentativepostponed;


            ///////////Confirm LOSS///////////////
            $dt_fb_confirmloss = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_fb_confirmloss != null) {
                $total_cancel += $dt_fb_confirmloss->totalfbdefinit;
            }
            $dt_room_only_confirmloss = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_room_only_confirmloss != null) {
                $total_cancel += $dt_room_only_confirmloss->totalroomonly;
            }
            $dt_room_meeting_confirmloss = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_room_meeting_confirmloss != null) {
                $total_cancel += $dt_room_meeting_confirmloss->totalroommeeting;
            }
            $dt_package_confirmloss = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_package_confirmloss != null) {
                $total_cancel += $dt_package_confirmloss->totalpackage;
            }
            $dt_additional_confirmloss = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_additional_confirmloss != null) {
                $total_cancel += $dt_additional_confirmloss->totaladditional;
            }
            $dt_roomrentalhotel_confirmloss = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_roomrentalhotel_confirmloss != null) {
                $total_cancel += $dt_roomrentalhotel_confirmloss->TotalRevenueRoomRental;
            }
            //END CONFIRM LOSS////////
            //offering LOSS//
            $dt_meeting_package_offloss = $this->definit_letter_model->select_meetingpackage_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_meeting_package_offloss != null) {
                $total_cancel += $dt_meeting_package_offloss->TotalMeetingPackage;
            }
            $dt_room_only_offloss = $this->definit_letter_model->select_roomonly_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_room_only_offloss != null) {
                $total_cancel += $dt_room_only_offloss->RoomOnly;
            }
            $dt_additional_offloss = $this->definit_letter_model->select_additional_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_additional_offloss != null) {
                $total_cancel += $dt_additional_offloss->TotalAdditional;
            }
            $dt_banquet_package_offloss = $this->definit_letter_model->select_banquetpackage_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_banquet_package_offloss != null) {
                $total_cancel += $dt_banquet_package_offloss->TotalPackage;
            }
            //new 6 May 2010///////////////////////////
            $dt_roomrental_offloss = $this->offering_view_model->select_roomrentalrevenue_by_salesgrouppropertydatestatus($salessegment, $row->idproperty, date('F'), date('Y'), 'LOSS');
            if ($dt_roomrental_offloss != null) {
                $total_cancel += $dt_roomrental_offloss->RevenueRoomRental;
            }
            //end offering LOSS//
            $grand_total_cancel += $total_cancel;
        }
        //////////////////////////////////////////
//            $title = new title('Total Revenue');
//            $title->set_style('color: #040b27; font-size: 12;font-weight:bold');

        $pie = new pie();
        //$pie->set_alpha(0.6);
        $pie->add_animation(new pie_fade());
        $pie->alpha(0.5)
                ->add_animation(new pie_fade())
                ->add_animation(new pie_bounce(5))
                //->start_angle( 270 )
                ->start_angle(0)
                ->tooltip('#percent# - #val#')
                ->colours(array("#fb0505", "#28c802", "#000000", "#e3d104"));

        $revenueconfirm = number_format($grand_total_confirm + $grand_total_definit + $grand_total_confirm_postponed, 0, '.', '') + 0;
        $revenueoffering = number_format($grand_total_tentative + $grand_total_tentative_postponed, 0, '.', '') + 0;
        $cancel = number_format($grand_total_cancel, 0, '.', '') + 0;

        $pie->set_values(array(new pie_value($revenueconfirm, number_format($revenueconfirm, 0, ',', '.')),
            new pie_value($revenueoffering, number_format($revenueoffering, 0, ',', '.')),
            new pie_value($cancel, number_format($cancel, 0, ',', '.'))
        ));
        $chart = new open_flash_chart();
        $chart->set_bg_colour("#ffffff");
//            $chart->set_title( $title );
        $chart->add_element($pie);
        echo $chart->toPrettyString();
    }

    function get_totalrevenuehotel_salesproperty() {
        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;

        $this->load->plugin('ofc2');
        $dt_hotel = $this->property_model->select_target_property();
        $total1 = 0;
        $total2 = 0;
        $total3 = 0;
        $total4 = 0;
        $grandtotal1 = 0;
        $grandtotal2 = 0;
        $grandtotal3 = 0;
        $grandtotal4 = 0;
        $grandtotaltarget = 0;

        $grandtotalbalance = 0;
        $totalbalance = 0;
        $totalAlltentative = 0;
        $totalAllcancel = 0;
        $grand_total_definit = 0;
        $grand_total_confirm = 0;
        $grand_total_confirm_postponed = 0;
        $grand_total_tentative = 0;
        $grand_total_tentative_postponed = 0;
        $grand_total_cancel = 0;
        // foreach ($dt_hotel->result() as $row) {
        $totalcancel = 0;
        $total1 = 0;
        $total2 = 0;
        $total3 = 0;
        $total4 = 0;
        $total_definit = 0;
        $total_confirm = 0;
        $total_confirmpostponed = 0;

        $total_tentative = 0;
        $total_tentativepostponed = 0;

        $total_cancel = 0;

        //definit
        $dt_fb_definit = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_fb_definit != null) {
            $total_definit += $dt_fb_definit->totalfbdefinit;
        }
        $dt_room_only_definit = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_room_only_definit != null) {
            $total_definit += $dt_room_only_definit->totalroomonly;
        }
        $dt_room_meeting_definit = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_room_meeting_definit != null) {
            $total_definit += $dt_room_meeting_definit->totalroommeeting;
        }
        $dt_package_definit = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_package_definit != null) {
            $total_definit += $dt_package_definit->totalpackage;
        }
        $dt_additional_definit = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_additional_definit != null) {
            $total_definit += $dt_additional_definit->totaladditional;
        }
        $dt_roomrentalhotel_definit = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_roomrentalhotel_definit != null) {
            $total_definit += $dt_roomrentalhotel_definit->TotalRevenueRoomRental;
        }
        $grand_total_definit += $total_definit;
        //end definit
        //confirm
        $dt_fb_confirm = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_fb_confirm != null) {
            $total_confirm += $dt_fb_confirm->totalfbdefinit;
        }
        $dt_room_only_confirm = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_room_only_confirm != null) {
            $total_confirm += $dt_room_only_confirm->totalroomonly;
        }
        $dt_room_meeting_confirm = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_room_meeting_confirm != null) {
            $total_confirm += $dt_room_meeting_confirm->totalroommeeting;
        }
        $dt_package_confirm = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_package_confirm != null) {
            $total_confirm += $dt_package_confirm->totalpackage;
        }
        $dt_additional_confirm = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_additional_confirm != null) {
            $total_confirm += $dt_additional_confirm->totaladditional;
        }
        $dt_roomrentalhotel_confirm = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'confirm');
        if ($dt_roomrentalhotel_confirm != null) {
            $total_confirm += $dt_roomrentalhotel_confirm->TotalRevenueRoomRental;
        }
        $grand_total_confirm += $total_confirm;
        //end confirm
        //POSTPONED
        $dt_fb_confirm = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_fb_confirm != null) {
            $total_confirmpostponed += $dt_fb_confirm->totalfbdefinit;
        }
        $dt_room_only_confirm = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_room_only_confirm != null) {
            $total_confirmpostponed += $dt_room_only_confirm->totalroomonly;
        }
        $dt_room_meeting_confirm = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_room_meeting_confirm != null) {
            $total_confirmpostponed += $dt_room_meeting_confirm->totalroommeeting;
        }
        $dt_package_confirm = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_package_confirm != null) {
            $total_confirmpostponed += $dt_package_confirm->totalpackage;
        }
        $dt_additional_confirm = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_additional_confirm != null) {
            $total_confirmpostponed += $dt_additional_confirm->totaladditional;
        }
        $dt_roomrentalhotel_confirm = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_roomrentalhotel_confirm != null) {
            $total_confirmpostponed += $dt_roomrentalhotel_confirm->TotalRevenueRoomRental;
        }
        $grand_total_confirm_postponed += $total_confirmpostponed;
        //end confirm POSTPONED


        $dt_meeting_package_tentative = $this->definit_letter_model->select_meetingpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_meeting_package_tentative != null) {
            $total_tentative += $dt_meeting_package_tentative->TotalMeetingPackage;
        }
        $dt_room_only_tentative = $this->definit_letter_model->select_roomonly_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_room_only_tentative != null) {
            $total_tentative += $dt_room_only_tentative->RoomOnly;
        }
        $dt_additional_tentative = $this->definit_letter_model->select_additional_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_additional_tentative != null) {
            $total_tentative += $dt_additional_tentative->TotalAdditional;
        }
        $dt_banquet_package_tentative = $this->definit_letter_model->select_banquetpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_banquet_package_tentative != null) {
            $total_tentative += $dt_banquet_package_tentative->TotalPackage;
        }
        //new 6 May 2010///////////////////////////
        $dt_roomrental_tentatif = $this->offering_view_model->select_roomrentalrevenue_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_roomrental_tentatif != null) {
            $total_tentative += $dt_roomrental_tentatif->RevenueRoomRental;
        }
        $grand_total_tentative +=$total_tentative;


        $dt_meeting_package_tentative = $this->definit_letter_model->select_meetingpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_meeting_package_tentative != null) {
            $total_tentativepostponed += $dt_meeting_package_tentative->TotalMeetingPackage;
        }
        $dt_room_only_tentative = $this->definit_letter_model->select_roomonly_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_room_only_tentative != null) {
            $total_tentativepostponed += $dt_room_only_tentative->RoomOnly;
        }
        $dt_additional_tentative = $this->definit_letter_model->select_additional_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_additional_tentative != null) {
            $total_tentativepostponed += $dt_additional_tentative->TotalAdditional;
        }
        $dt_banquet_package_tentative = $this->definit_letter_model->select_banquetpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_banquet_package_tentative != null) {
            $total_tentativepostponed += $dt_banquet_package_tentative->TotalPackage;
        }
        //new 6 May 2010///////////////////////////
        $dt_roomrental_tentatif = $this->offering_view_model->select_roomrentalrevenue_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_roomrental_tentatif != null) {
            $total_tentativepostponed += $dt_roomrental_tentatif->RevenueRoomRental;
        }
        $grand_total_tentative_postponed += $total_tentativepostponed;


        ///////////Confirm LOSS///////////////
        $dt_fb_confirmloss = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_fb_confirmloss != null) {
            $total_cancel += $dt_fb_confirmloss->totalfbdefinit;
        }
        $dt_room_only_confirmloss = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_only_confirmloss != null) {
            $total_cancel += $dt_room_only_confirmloss->totalroomonly;
        }
        $dt_room_meeting_confirmloss = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_meeting_confirmloss != null) {
            $total_cancel += $dt_room_meeting_confirmloss->totalroommeeting;
        }
        $dt_package_confirmloss = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_package_confirmloss != null) {
            $total_cancel += $dt_package_confirmloss->totalpackage;
        }
        $dt_additional_confirmloss = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_additional_confirmloss != null) {
            $total_cancel += $dt_additional_confirmloss->totaladditional;
        }
        $dt_roomrentalhotel_confirmloss = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_roomrentalhotel_confirmloss != null) {
            $total_cancel += $dt_roomrentalhotel_confirmloss->TotalRevenueRoomRental;
        }
        //END CONFIRM LOSS////////
        //offering LOSS//
        $dt_meeting_package_offloss = $this->definit_letter_model->select_meetingpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_meeting_package_offloss != null) {
            $total_cancel += $dt_meeting_package_offloss->TotalMeetingPackage;
        }
        $dt_room_only_offloss = $this->definit_letter_model->select_roomonly_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_only_offloss != null) {
            $total_cancel += $dt_room_only_offloss->RoomOnly;
        }
        $dt_additional_offloss = $this->definit_letter_model->select_additional_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_additional_offloss != null) {
            $total_cancel += $dt_additional_offloss->TotalAdditional;
        }
        $dt_banquet_package_offloss = $this->definit_letter_model->select_banquetpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_banquet_package_offloss != null) {
            $total_cancel += $dt_banquet_package_offloss->TotalPackage;
        }
        //new 6 May 2010///////////////////////////
        $dt_roomrental_offloss = $this->offering_view_model->select_roomrentalrevenue_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_roomrental_offloss != null) {
            $total_cancel += $dt_roomrental_offloss->RevenueRoomRental;
        }
        //end offering LOSS//
        $grand_total_cancel += $total_cancel;
        //}//end foreach dt_hotel
        //////////////////////////////////////////
//            $title = new title('Total Revenue');
//            $title->set_style('color: #040b27; font-size: 12;font-weight:bold');

        $pie = new pie();
        //$pie->set_alpha(0.6);
        $pie->add_animation(new pie_fade());
        $pie->alpha(0.5)
                ->add_animation(new pie_fade())
                ->add_animation(new pie_bounce(5))
                //->start_angle( 270 )
                ->start_angle(0)
                ->tooltip('#percent# - #val#')
                ->colours(array("#fb0505", "#28c802", "#000000", "#e3d104"));

        $revenueconfirm = number_format($grand_total_confirm + $grand_total_definit + $grand_total_confirm_postponed, 0, '.', '') + 0;
        $revenueoffering = number_format($grand_total_tentative + $grand_total_tentative_postponed, 0, '.', '') + 0;
        $cancel = number_format($grand_total_cancel, 0, '.', '') + 0;

        $pie->set_values(array(new pie_value($revenueconfirm, number_format($revenueconfirm, 0, ',', '.')),
            new pie_value($revenueoffering, number_format($revenueoffering, 0, ',', '.')),
            new pie_value($cancel, number_format($cancel, 0, ',', '.'))
        ));
        $chart = new open_flash_chart();
        $chart->set_bg_colour("#ffffff");
//            $chart->set_title( $title );
        $chart->add_element($pie);
        echo $chart->toPrettyString();
    }


    function get_hotelmonthlyrevenue() {
        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');
 
        $this->load->plugin('ofc2');
        //definit
        $grand_total_definit = 0;
        $grand_total_confirm = 0;
        $grand_total_confirm_postponed = 0;
        $grand_total_tentative = 0;
        $grand_total_tentative_postponed =0;
        $grand_total_cancel = 0;
        
        $total_definit = 0;
        $dt_fb_definit = $this->definit_letter_model->select_total_fb_by_property($userproperty, date('F'), date('Y'), 'definit');
        if ($dt_fb_definit != null) {
            $total_definit += $dt_fb_definit->totalfbdefinit;
        }
        $dt_room_only_definit = $this->definit_letter_model->select_total_room_only_by_property( $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_room_only_definit != null) {
            $total_definit += $dt_room_only_definit->totalroomonly;
        }
        $dt_room_meeting_definit = $this->definit_letter_model->select_total_room_meeting_by_properti( $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_room_meeting_definit != null) {
            $total_definit += $dt_room_meeting_definit->totalroommeeting;
        }
        $dt_package_definit = $this->definit_letter_model->select_total_package_by_property( $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_package_definit != null) {
            $total_definit += $dt_package_definit->totalpackage;
        }
        $dt_additional_definit = $this->definit_letter_model->select_total_additional_by_property($userproperty, date('F'), date('Y'), 'definit');
        if ($dt_additional_definit != null) {
            $total_definit += $dt_additional_definit->totaladditional;
        }
        $dt_roomrental = $this->definit_letter_model->select_roomrentalrevenue_by_propmonthyearstatus($userproperty, date('F'), date('Y'), 'definit');
        if ($dt_roomrental != NULL) {
            $total_definit += $dt_roomrental->TotalRevenue;
        }
        $dt_stall = $this->definit_letter_model->select_stallrevenue_by_propmonthyearstatus($userproperty, date('F'), date('Y'), 'definit');
        if ($dt_stall != NULL) {
            $total_definit += $dt_stall->TotalRevenue;
        }
        $grand_total_definit += $total_definit;
        //end definit
        //confirm
        $totalconfirm = 0;
        $dt_fb_confirm = $this->definit_letter_model->select_total_fb_by_property($userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_fb_confirm != null) {
            $totalconfirm += $dt_fb_confirm->totalfbdefinit;
        }
        $dt_room_only_confirm = $this->definit_letter_model->select_total_room_only_by_property(  $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_room_only_confirm != null) {
            $totalconfirm += $dt_room_only_confirm->totalroomonly;
        }
        $dt_room_meeting_confirm = $this->definit_letter_model->select_total_room_meeting_by_properti( $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_room_meeting_confirm != null) {
            $totalconfirm += $dt_room_meeting_confirm->totalroommeeting;
        }
        $dt_package_confirm = $this->definit_letter_model->select_total_package_by_property( $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_package_confirm != null) {
            $totalconfirm += $dt_package_confirm->totalpackage;
        }
        $dt_additional_confirm = $this->definit_letter_model->select_total_additional_by_property( $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_additional_confirm != null) {
            $totalconfirm += $dt_additional_confirm->totaladditional;
        }
        $dt_roomrental = $this->definit_letter_model->select_roomrentalrevenue_by_propmonthyearstatus($userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_roomrental != NULL) {
            $totalconfirm += $dt_roomrental->TotalRevenue;
        }

        $dt_stallrevenue_confirm =  $this->definit_letter_model->select_stallrevenue_by_propmonthyearstatus($userproperty, date('F'), date('Y'), 'Confirm');
        if($dt_stallrevenue_confirm != NULL)
        {
            $totalconfirm += $dt_stallrevenue_confirm->TotalRevenue;
        }
        $grand_total_confirm += $totalconfirm;
        //end confirm
        //POSTPONED
        $totalconfirmpostponed = 0;
        $dt_fb_confirm = $this->definit_letter_model->select_total_fb_by_property($userproperty, date('F'), date('Y'), 'Postponed');
        if ($dt_fb_confirm != null) {
            $totalconfirmpostponed += $dt_fb_confirm->totalfbdefinit;
        }
        $dt_room_only_confirm = $this->definit_letter_model->select_total_room_only_by_property(  $userproperty, date('F'), date('Y'), 'Postponed');
        if ($dt_room_only_confirm != null) {
            $totalconfirmpostponed += $dt_room_only_confirm->totalroomonly;
        }
        $dt_room_meeting_confirm = $this->definit_letter_model->select_total_room_meeting_by_properti( $userproperty, date('F'), date('Y'), 'Postponed');
        if ($dt_room_meeting_confirm != null) {
            $totalconfirmpostponed += $dt_room_meeting_confirm->totalroommeeting;
        }
        $dt_package_confirm = $this->definit_letter_model->select_total_package_by_property( $userproperty, date('F'), date('Y'), 'Postponed');
        if ($dt_package_confirm != null) {
            $totalconfirmpostponed += $dt_package_confirm->totalpackage;
        }
        $dt_additional_confirm = $this->definit_letter_model->select_total_additional_by_property( $userproperty, date('F'), date('Y'), 'Postponed');
        if ($dt_additional_confirm != null) {
            $totalconfirmpostponed += $dt_additional_confirm->totaladditional;
        }
        $dt_roomrental = $this->definit_letter_model->select_roomrentalrevenue_by_propmonthyearstatus($userproperty, date('F'), date('Y'), 'Postponed');
        if ($dt_roomrental != NULL) {
            $totalconfirmpostponed += $dt_roomrental->TotalRevenue;
        }

        $dt_stallrevenue_confirm =  $this->definit_letter_model->select_stallrevenue_by_propmonthyearstatus($userproperty, date('F'), date('Y'), 'Postponed');
        if($dt_stallrevenue_confirm != NULL)
        {
            $totalconfirmpostponed += $dt_stallrevenue_confirm->TotalRevenue;
        }
        $grand_total_confirm_postponed += $totalconfirmpostponed;
        //end confirm POSTPONED
        
        
        //tentative
        $totaltentative  = 0;
        $dt_meeting_package_tentative = $this->definit_letter_model->select_meeting_package_by_property($userproperty, date('F'), date('Y'), 'offering');
        if ($dt_meeting_package_tentative != null) {
            $totaltentative += $dt_meeting_package_tentative->TotalMeetingPackage;
        }
        $dt_room_only_tentative = $this->definit_letter_model->select_room_only_by_property($userproperty, date('F'), date('Y'), 'offering');
        if ($dt_room_only_tentative != null) {
            $totaltentative += $dt_room_only_tentative->RoomOnly;
        }
        $dt_additional_tentative = $this->definit_letter_model->select_addtional_by_property($userproperty, date('F'), date('Y'), 'offering');
        if ($dt_additional_tentative != null) {
            $totaltentative += $dt_additional_tentative->TotalAdditional;
        }
        $dt_banquet_package_tentative = $this->definit_letter_model->select_banquet_package_by_property($userproperty, date('F'), date('Y'), 'offering');
        if ($dt_banquet_package_tentative != null) {
            $totaltentative += $dt_banquet_package_tentative->TotalPackage;
        }
        //new 6 May 2010///////////////////////////
        $dt_roomrental_tentatif = $this->offering_view_model->select_roomrentalrevenue_by_property( $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_roomrental_tentatif != null) {
            $totaltentative += $dt_roomrental_tentatif->RevenueRoomRental;
        }
        //end Tentative
        $grand_total_tentative += $totaltentative;
        
        $totaloffpostponed  = 0;
        $dt_meeting_package_tentative = $this->definit_letter_model->select_meeting_package_by_property(   $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_meeting_package_tentative != null) {
            $totaloffpostponed += $dt_meeting_package_tentative->TotalMeetingPackage;
        }
        $dt_room_only_tentative = $this->definit_letter_model->select_room_only_by_property(   $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_room_only_tentative != null) {
            $totaloffpostponed += $dt_room_only_tentative->RoomOnly;
        }
        $dt_additional_tentative = $this->definit_letter_model->select_addtional_by_property(   $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_additional_tentative != null) {
            $totaloffpostponed += $dt_additional_tentative->TotalAdditional;
        }
        $dt_banquet_package_tentative = $this->definit_letter_model->select_banquet_package_by_property(  $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_banquet_package_tentative != null) {
            $totaloffpostponed += $dt_banquet_package_tentative->TotalPackage;
        }
        //new 6 May 2010///////////////////////////
        $dt_roomrental_tentatif = $this->offering_view_model->select_roomrentalrevenue_by_property(  $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_roomrental_tentatif != null) {
            $totaloffpostponed += $dt_roomrental_tentatif->RevenueRoomRental;
        }
        $grand_total_tentative_postponed += $totaloffpostponed;


        ///////////Confirm LOSS///////////////
        $totalcancel = 0;
        $dt_fb_confirmloss = $this->definit_letter_model->select_total_fb_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_fb_confirmloss != null) {
            $totalcancel += $dt_fb_confirmloss->totalfbdefinit;
        }
        $dt_room_only_confirmloss = $this->definit_letter_model->select_total_room_only_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_only_confirmloss != null) {
            $totalcancel += $dt_room_only_confirmloss->totalroomonly;
        }
        $dt_room_meeting_confirmloss = $this->definit_letter_model->select_total_room_meeting_by_properti($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_meeting_confirmloss != null) {
            $totalcancel += $dt_room_meeting_confirmloss->totalroommeeting;
        }
        $dt_package_confirmloss = $this->definit_letter_model->select_total_package_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_package_confirmloss != null) {
            $totalcancel += $dt_package_confirmloss->totalpackage;
        }
        $dt_additional_confirmloss = $this->definit_letter_model->select_total_additional_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_additional_confirmloss != null) {
            $totalcancel += $dt_additional_confirmloss->totaladditional;
        }
        $dt_roomrentalhotel_confirmloss = $this->confirm_view_model->select_revenueroomrental_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_roomrentalhotel_confirmloss != null) {
            $totalcancel += $dt_roomrentalhotel_confirmloss->RevenueRoomRental;
        }
        $dt_stall = $this->definit_letter_model->select_stallrevenue_by_propmonthyearstatus($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_stall != NULL) {
            $totalcancel += $dt_stall->TotalRevenue;
        }
        //END CONFIRM LOSS////////
        //offering LOSS//
        
        $dt_meeting_package_cancel = $this->definit_letter_model->select_meeting_package_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_meeting_package_cancel != null) {
            $totalcancel += $dt_meeting_package_cancel->TotalMeetingPackage;
        }
        $dt_room_only_cancel = $this->definit_letter_model->select_room_only_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_only_cancel != null) {
            $totalcancel += $dt_room_only_cancel->RoomOnly;
        }
        $dt_additional_cancel = $this->definit_letter_model->select_addtional_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_additional_cancel != null) {
            $totalcancel += $dt_additional_cancel->TotalAdditional;
        }
        $dt_banquet_package_cancel = $this->definit_letter_model->select_banquet_package_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_banquet_package_cancel != null) {
            $totalcancel += $dt_banquet_package_cancel->TotalPackage;
        }
        //new 6 May 2010///////////////////////////
        $dt_roomrental_cancel = $this->offering_view_model->select_roomrentalrevenue_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_roomrental_cancel != null) {
            $totalcancel += $dt_roomrental_cancel->RevenueRoomRental;
        }
        $dt_stallrevenue = $this->definit_letter_model->select_stallrevenueoffering_by_property($userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_stallrevenue != NULL) {
            $totalcancel += $dt_stallrevenue->TotalRevenue;
        }
        //end offering LOSS//
        $grand_total_cancel += $totalcancel;
        //}//end foreach dt_hotel

        $pie = new pie();
        $pie->add_animation(new pie_fade());
        $pie->alpha(0.5)
                ->add_animation(new pie_fade())
                ->add_animation(new pie_bounce(5))
                //->start_angle( 270 )
                ->start_angle(0)
                ->tooltip('#percent# - #val#')
                ->colours(array("#fb0505", "#28c802", "#000000", "#e3d104"));

        $revenueconfirm = number_format(floatval($grand_total_confirm + $grand_total_definit + $grand_total_confirm_postponed), 0, '.', '') + 0;
        $revenueoffering = number_format(floatval($grand_total_tentative + $grand_total_tentative_postponed), 0, '.', '') + 0;
        $cancel = number_format(floatval($grand_total_cancel), 0, '.', '') + 0;

        $pie->set_values(array(new pie_value($revenueconfirm, number_format($revenueconfirm, 0, ',', '.')),
                               new pie_value($revenueoffering, number_format($revenueoffering, 0, ',', '.')),
                               new pie_value($cancel, number_format($cancel, 0, ',', '.'))
                                ));
        $chart = new open_flash_chart();
        $chart->set_bg_colour("#ffffff");
        $chart->add_element($pie);
        echo $chart->toPrettyString();
    }

    function get_salesactivity_telemarketing() {
        $this->load->plugin('ofc2');

        $dt_salesactive = $this->sales_model->select_sales();
        $dt_actsales = $this->ref_slsact_budget_model->select_salesactivities();

        $totaltarget = 0;
        $totalactual = 0;

        $title = new title('Telemarketing');
        $title->set_style('color: #040b27; font-size: 12;font-weight:bold');
        $amountact = 0;
        $actual = 0;
        $days_in_month = date('t');
        foreach ($dt_salesactive->result() AS $rowslsact) {
            $dt_slsactamount = $this->sales_act_budget_model->select_amount_persalesactivitymonthyearstatus($rowslsact->id, 1, date('m'), date('Y'), 'Active');

            if ($dt_slsactamount != NULL) {
                $amountact += $dt_slsactamount->jumlah;
            }

//                $actualaccount = $this->account_model->select_todays_account(date('Y-m-d'), $rowslsact->id);
            //$actualtele = $this->telemarketing_model->select_todays_telemarketing(date('Y-m-d'), $rowslsact->id);
            $actualtele = $this->telemarketing_model->select_currentmonth_telemarketing(date('m'), $rowslsact->id);
//                $actualenter = $this->entertainment_model->select_todays_entertainment(date('Y-m-d'), $rowslsact->id);
//                $actualcompliment = $this->complimentary_model->select_todays_compliment(date('Y-m-d'), $rowslsact->id);
//                $actualsalesdlmkota = $this->sales_call_model->select_today_salescall_dalamkota(date('Y-m-d'), $rowslsact->id);
//                $actualsalesluarkota = $this->sales_call_model->select_today_salescall_luarkota(date('Y-m-d'), $rowslsact->id);
//
//                $actual = 0;
//                if ($rowact->slsbudgetname == 'Account') {
//                    if ($actualaccount != NULL) {
//                        $actual = $actualaccount->Total;
//                    }
//                }

            if ($actualtele != NULL) {
                $actual += $actualtele->Total;
            }

//                if ($rowact->slsbudgetname == 'Entertainment') {
//                    if ($actualenter != NULL) {
//                        $actual = $actualenter->Total;
//                    }
//                }
//                if ($rowact->slsbudgetname == 'Compliment') {
//                    if ($actualcompliment != NULL) {
//                        $actual = $actualcompliment->Total;
//                    }
//                }
//                if ($rowact->slsbudgetname == 'Sales Call Dalam Kota') {
//                    if ($actualsalesdlmkota != NULL) {
//                        $actual = $actualsalesdlmkota->Total;
//                    }
//                }
//                if ($rowact->slsbudgetname == 'Sales Call Luar Kota') {
//                    if ($actualsalesluarkota != NULL) {
//                        $actual = $actualsalesluarkota->Total;
//                    }
//                }
        }//endforeach

        $target = ($amountact / $days_in_month) * date('d');
        $data_pie[] = new pie_value(number_format($actual, 0, ',', '') + 0, '');
        //$data_pie[] = new pie_value(number_format(50, 0, ',', '') + 0, '');

        $data_pie[] = new pie_value(number_format($target, 0, ',', '') + 0, '');

        $pie = new pie();
        $pie->set_alpha(0.6);
        $pie->set_start_angle(30);
        $pie->add_animation(new pie_fade());
        $pie->set_tooltip('#val#<br>');
        $pie->set_colours(array('#f00101', '#0000ff')); //red blue

        $pie->set_values($data_pie);

        $chart = new open_flash_chart();
        //$chart->set_title( $title );
        $chart->set_bg_colour('#FFFFFF');
        $chart->add_element($pie);
        echo $chart->toPrettyString();
    }

    function get_salesactivity_account() {
        $this->load->plugin('ofc2');

        $dt_salesactive = $this->sales_model->select_sales();
        $dt_actsales = $this->ref_slsact_budget_model->select_salesactivities();

        $target = 0;
        $title = new title('');
        $title->set_style('color: #040b27; font-size: 12;font-weight:bold');
        $amountact = 0;
        $actual = 0;
        $days_in_month = date('t');
        foreach ($dt_salesactive->result() AS $rowslsact) {
            $dt_slsactamount = $this->sales_act_budget_model->select_amount_persalesactivitymonthyearstatus($rowslsact->id, 6, date('m'), date('Y'), 'Active');
            if ($dt_slsactamount != NULL) {
                $amountact += $dt_slsactamount->jumlah;
            }
            //$actualaccount = $this->account_model->select_todays_account(date('Y-m-d'), $rowslsact->id);
            $actualaccount = $this->account_model->select_currentmonth_account(date('m'), $rowslsact->id);

            if ($actualaccount != NULL) {
                $actual += $actualaccount->Total;
            }
        }//endforeach


        $target = ($amountact / $days_in_month) * (int) date('d');
        $data_pie[] = new pie_value(number_format($actual, 0, ',', '') + 0, '');
        $data_pie[] = new pie_value(number_format($target, 0, ',', '') + 0, '');

        $pie = new pie();
        $pie->set_alpha(0.6);
        $pie->set_start_angle(30);
        $pie->add_animation(new pie_fade());
        $pie->set_tooltip('#val#<br>');
        $pie->set_colours(array('#f00101', '#0000ff')); //red blue
        $pie->set_values($data_pie);
        $chart = new open_flash_chart();
        //$chart->set_title( $title );
        $chart->set_bg_colour('#FFFFFF');
        $chart->add_element($pie);
        echo $chart->toPrettyString();
    }

    function get_salesactivity_entertainment() {
        $this->load->plugin('ofc2');
        $dt_salesactive = $this->sales_model->select_sales();
        $dt_actsales = $this->ref_slsact_budget_model->select_salesactivities();
        $target = 0;
        $title = new title('Entertainment');
        $title->set_style('color: #040b27; font-size: 12;font-weight:bold');
        $amountact = 0;
        $actual = 0;
        $days_in_month = date('t');
        foreach ($dt_salesactive->result() AS $rowslsact) {
            $dt_slsactamount = $this->sales_act_budget_model->select_amount_persalesactivitymonthyearstatus($rowslsact->id, 2, date('m'), date('Y'), 'Active');
            if ($dt_slsactamount != NULL) {
                $amountact += $dt_slsactamount->jumlah;
            }

            //$actualenter = $this->entertainment_model->select_todays_entertainment(date('Y-m-d'), $rowslsact->id);
            $actualenter = $this->entertainment_model->select_currentmonth_entertainment(date('m'), $rowslsact->id);

            if ($actualenter != NULL) {
                $actual += $actualenter->Total;
            }
        }//endforeach

        $target = ($amountact / $days_in_month) * date('d');

        $data_pie[] = new pie_value(number_format($actual, 0, ',', '') + 0, '');
        $data_pie[] = new pie_value(number_format($target, 0, ',', '') + 0, '');

        $pie = new pie();
        $pie->set_alpha(0.6);
        $pie->set_start_angle(30);
        $pie->add_animation(new pie_fade());
        $pie->set_tooltip('#val#<br>');
        $pie->set_colours(array('#f00101', '#0000ff')); //red blue
        $pie->set_values($data_pie);

        $chart = new open_flash_chart();
//            $chart->set_title( $title );
        $chart->set_bg_colour('#FFFFFF');
        $chart->add_element($pie);
        echo $chart->toPrettyString();
    }

    function get_salesactivity_salescallluarkota() {
        $this->load->plugin('ofc2');

        $dt_salesactive = $this->sales_model->select_sales();
        $dt_actsales = $this->ref_slsact_budget_model->select_salesactivities();

        $target = 0;
        $title = new title('Sales Call');
        $title->set_style('color: #040b27; font-size: 12;font-weight:bold');
        $amountact = 0;
        $actual = 0;
        $days_in_month = date('t');
        foreach ($dt_salesactive->result() AS $rowslsact) {
            // $dt_slsactamount = $this->sales_act_budget_model->select_amount_persalesactivitymonthyearstatus($rowslsact->id, 4, date('m'), date('Y'), 'Active');
            $dt_slsactamount2 = $this->sales_act_budget_model->select_amount_persalesactivitymonthyearstatus($rowslsact->id, 5, date('m'), date('Y'), 'Active');


//            if ($dt_slsactamount != NULL) {
//                $amountact += $dt_slsactamount->jumlah;
//            }

            if ($dt_slsactamount2 != NULL) {
                $amountact += $dt_slsactamount2->jumlah;
            }

            //$actualsalesdlmkota = $this->sales_call_model->select_today_salescall_dalamkota(date('Y-m-d'), $rowslsact->id);
            //$actualsalesluarkota = $this->sales_call_model->select_today_salescall_luarkota(date('Y-m-d'), $rowslsact->id);
            $actualsalesluarkota = $this->sales_call_model->select_currentmonthsalescall_luarkota(date('m'), $rowslsact->id);


//            if ($actualsalesdlmkota != NULL) {
//                $actual += $actualsalesdlmkota->Total;
//            }


            if ($actualsalesluarkota != NULL) {
                $actual += $actualsalesluarkota->Total;
            }
        }//endforeach

        $target = ($amountact / $days_in_month) * date('d');



        $data_pie[] = new pie_value(number_format($actual, 0, ',', '') + 0, '');
        $data_pie[] = new pie_value(number_format($target, 0, ',', '') + 0, '');

        $pie = new pie();
        $pie->set_alpha(0.6);
        $pie->set_start_angle(30);
        $pie->add_animation(new pie_fade());
        $pie->set_tooltip('#val#<br>');
        $pie->set_colours(array('#f00101', '#0000ff')); //red blue
        $pie->set_values($data_pie);

        $chart = new open_flash_chart();
//            $chart->set_title( $title );
        $chart->set_bg_colour('#FFFFFF');
        $chart->add_element($pie);
        echo $chart->toPrettyString();
    }

    function get_salesactivity_salescalldalamkota() {
        $this->load->plugin('ofc2');

        $dt_salesactive = $this->sales_model->select_sales();
        $dt_actsales = $this->ref_slsact_budget_model->select_salesactivities();

        $target = 0;
        $title = new title('Sales Call');
        $title->set_style('color: #040b27; font-size: 12;font-weight:bold');
        $amountact = 0;
        $actual = 0;
        $days_in_month = date('t');
        foreach ($dt_salesactive->result() AS $rowslsact) {
            $dt_slsactamount = $this->sales_act_budget_model->select_amount_persalesactivitymonthyearstatus($rowslsact->id, 4, date('m'), date('Y'), 'Active');
            if ($dt_slsactamount != NULL) {
                $amountact += $dt_slsactamount->jumlah;
            }
            //$actualsalesdlmkota = $this->sales_call_model->select_today_salescall_dalamkota(date('Y-m-d'), $rowslsact->id);
            $actualsalesdlmkota = $this->sales_call_model->select_currentmonthsalescall_dalamkota(date('m'), $rowslsact->id);

            if ($actualsalesdlmkota != NULL) {
                $actual += $actualsalesdlmkota->Total;
            }
        }//endforeach

        $target = ($amountact / $days_in_month) * date('d');

        $data_pie[] = new pie_value(number_format($actual, 0, ',', '') + 0, '');
        $data_pie[] = new pie_value(number_format($target, 0, ',', '') + 0, '');

        $pie = new pie();
        $pie->set_alpha(0.6);
        $pie->set_start_angle(30);
        $pie->add_animation(new pie_fade());
        $pie->set_tooltip('#val#<br>');
        $pie->set_colours(array('#f00101', '#0000ff')); //red blue
        $pie->set_values($data_pie);

        $chart = new open_flash_chart();
        // $chart->set_title( $title );
        $chart->set_bg_colour('#FFFFFF');
        $chart->add_element($pie);
        echo $chart->toPrettyString();
    }

     function graph_achievementbyhotel()
     {
         $this->load->plugin('ofc2');
         $datadefinitconfirm = array();
         $datatarget = array();
        $datatentative = array();
        $datacancel = array();
        $labels = array();
        $mxVal = 0;
        $dt_property = $this->property_model->select_property();
        foreach ($dt_property->result() AS $rowprop) {
            $totaldefinit = 0;
            $totalconfirm = 0;
            $totalclpostponed = 0;
            $totaloffering = 0;
            $totalolpostponed = 0;
            $totalloss = 0;
            $labels[] = $rowprop->idproperty;
            //definit revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'definit');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'definit');
            $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'definit');
            $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'definit');
            $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'definit');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'definit');
            $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'definit');
            if ($roommeetingrevenue != null) {
                $totaldefinit += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totaldefinit += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totaldefinit += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $totaldefinit += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $totaldefinit += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $totaldefinit += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totaldefinit += $stallrevenue->RevStall;
            }
            //enddefinitreveue

            //confirm revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'confirm');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'confirm');
            $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'confirm');
            $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'confirm');
            $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'confirm');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'confirm');
            $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'confirm');
            if ($roommeetingrevenue != null) {
                $totalconfirm += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalconfirm += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalconfirm += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $totalconfirm += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $totalconfirm += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $totalconfirm += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totalconfirm += $stallrevenue->RevStall;
            }
            //endconfirmreveue
            //LOSS revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            if ($roommeetingrevenue != null) {
                $totalloss += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalloss += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalloss += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $totalloss += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $totalloss += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $totalloss += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totalloss += $stallrevenue->RevStall;
            }
            //endloss reveue

            //postponed revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            if ($roommeetingrevenue != null) {
                $totalclpostponed += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalclpostponed += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalclpostponed += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $totalclpostponed += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $totalclpostponed += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $totalclpostponed += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totalclpostponed += $stallrevenue->RevStall;
            }
            //endpostponedreveue

            //offering revenue
            $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'offering');
            $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'offering');
            $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'offering');
            $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'offering');
            $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'offering');
            $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'offering');
            if ($roomonlyrevenue != null) {
                $totaloffering += $roomonlyrevenue->RevRoomOnly;
            }
            if ($additionalrevenue != null) {
                $totaloffering += $additionalrevenue->RevAdditional;
            }
            if ($packagerevenue != null) {
                $totaloffering += $packagerevenue->RevPackage;
            }
            if ($meetingrevenue != null) {
                $totaloffering += $meetingrevenue->RevMeetingPackage;
            }
            if ($roomrentalrevenue != null) {
                $totaloffering += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totaloffering += $stallrevenue->RevStall;
            }
            //endofferingreveue

            //olpostponed revenue
            $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'postponed');
            if ($roomonlyrevenue != null) {
                $totalolpostponed += $roomonlyrevenue->RevRoomOnly;
            }
            if ($additionalrevenue != null) {
                $totalolpostponed += $additionalrevenue->RevAdditional;
            }
            if ($packagerevenue != null) {
                $totalolpostponed += $packagerevenue->RevPackage;
            }
            if ($meetingrevenue != null) {
                $totalolpostponed += $meetingrevenue->RevMeetingPackage;
            }
            if ($roomrentalrevenue != null) {
                $totalolpostponed += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totalolpostponed += $stallrevenue->RevStall;
            }
            //endolpostponedreveue

            //ollost revenue
            $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($rowprop->idproperty,date('m'),date('Y'),'loss');
            if ($roomonlyrevenue != null) {
                $totalloss += $roomonlyrevenue->RevRoomOnly;
            }
            if ($additionalrevenue != null) {
                $totalloss += $additionalrevenue->RevAdditional;
            }
            if ($packagerevenue != null) {
                $totalloss += $packagerevenue->RevPackage;
            }
            if ($meetingrevenue != null) {
                $totalloss += $meetingrevenue->RevMeetingPackage;
            }
            if ($roomrentalrevenue != null) {
                $totalloss += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totalloss += $stallrevenue->RevStall;
            }
            //endollossreveue

            $dt_target = $this->property_model->select_target_perproperty($rowprop->idproperty);
            if($dt_target != NULL){
                $targetprop = $dt_target->amount;
            }else{
                $targetprop = 0;
            }

            $datadefinitconfirm[] = floatval($totaldefinit + $totalconfirm + $totalclpostponed);
            $datatentative[] = floatval($totaloffering + $totalolpostponed);
            $datatarget[] = floatval($targetprop);
            $datacancel[] = floatval($totalloss); //floatval();

            if(($totaldefinit + $totalconfirm + $totalclpostponed) > $mxVal)
            {
                $mxVal = floatval($totaldefinit + $totalconfirm + $totalclpostponed);
            }
            if(floatval($totaloffering + $totalolpostponed) > $mxVal)
            {
                $mxVal =floatval($totaloffering + $totalolpostponed) ;
            }
            if(floatval($targetprop) > $mxVal)
            {
                $mxVal =floatval($targetprop) ;
            }
            if(floatval($totalloss) > $mxVal)
            {
                $mxVal = floatval($totalloss) ;
            }
        }
        //$labels = array('Serela', 'Seriti', 'Banana', 'Golden', 'Carrcadin');

        $bardefinitconfirm = new bar_3d(75, '#D54C78');
        $bardefinitconfirm->set_values($datadefinitconfirm);
        $bardefinitconfirm->colour('#FF3300');
        $bardefinitconfirm->set_tooltip("#val# <br>");
        $bardefinitconfirm->set_on_show(new bar_on_show('grow-up', 2.5, 0));

        $bartarget = new bar_3d(75, '#D54C78');
        $bartarget->set_values($datatarget);
        $bartarget->colour('#1e1ef1');
        $bartarget->set_tooltip("#val# <br>");
         $bartarget->set_on_show(new bar_on_show('grow-up', 2.5, 0));
        //$bartarget->key('Target', 12);

        $bar1 = new bar_3d(75, '#D54C78');
        $bar1->set_values($datatentative);
        $bar1->colour('#64e923');
        $bar1->set_tooltip("#val# <br>");
        $bar1->set_on_show(new bar_on_show('grow-up', 2.5, 0));
        //$bar1->key('Tentative', 12);

        $bar2 = new bar_3d(75, '#D54C78');
        $bar2->set_values($datacancel);
        $bar2->colour('#000011');
        $bar2->set_tooltip("#val# <br>");
          $bar2->set_on_show(new bar_on_show('grow-up', 2.5, 0));
        //$bar2->key('Cancel', 12);

        $tooltip = new tooltip();
        $tooltip->set_hover();

        $chart = new open_flash_chart();

        $y_legend = new y_legend('');
        $y_legend->set_style('{font-size: 22px; color: #778877}');
        $chart->set_y_legend($y_legend);

        $y = new y_axis();
        $y->set_range(0, $mxVal);
        $y->set_colours('#000000', '#d0d0d0');

        $x = new x_axis();
        $x->set_labels_from_array($labels);
        $x->set_3d(10);
        $x->set_colours('#d0d0d0', '#ffffff');

        $chart->set_x_axis($x);
        $chart->set_y_axis($y);
        $chart->set_tooltip($tooltip);

        //$chart->set_title($title);
        $chart->set_bg_colour("#ffffff");
        $chart->add_element($bartarget);
        $chart->add_element($bardefinitconfirm);
        $chart->add_element($bar1);
        $chart->add_element($bar2);
        echo $chart->toPrettyString();
     }
     
     function graph_achievementbyhotel_property() {
        $this->load->plugin('ofc2');
        $datadefinitconfirm = array();
        $datatarget = array();
        $datatentative = array();
        $datacancel = array();
        $labels = array();
        $mxVal = 0;
        $dt_property = $this->property_model->select_property();
        $userproperty = $this->session->userdata('property');
        foreach ($dt_property->result() AS $rowprop) {
            if ($userproperty == $rowprop->idproperty) {
                $totaldefinit = 0;
                $totalconfirm = 0;
                $totalclpostponed = 0;
                $totaloffering = 0;
                $totalolpostponed = 0;
                $totalloss = 0;
                $labels[] = $rowprop->idproperty;
                //definit revenue
                $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'definit');
                $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'definit');
                $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'definit');
                $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'definit');
                $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'definit');
                $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'definit');
                $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'definit');
                if ($roommeetingrevenue != null) {
                    $totaldefinit += $roommeetingrevenue->RevRoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totaldefinit += $roomonlyrevenue->RevRoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totaldefinit += $packagerevenue->RevPackage;
                }
                if ($additionalrevenue != null) {
                    $totaldefinit += $additionalrevenue->RevAdditional;
                }
                if ($fnbrevenue != null) {
                    $totaldefinit += $fnbrevenue->RevFB;
                }
                if ($roomrentalrevenue != null) {
                    $totaldefinit += $roomrentalrevenue->RevRoomRental;
                }
                if ($stallrevenue != null) {
                    $totaldefinit += $stallrevenue->RevStall;
                }
                //enddefinitreveue
                //confirm revenue
                $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'confirm');
                $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'confirm');
                $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'confirm');
                $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'confirm');
                $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'confirm');
                $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'confirm');
                $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'confirm');
                if ($roommeetingrevenue != null) {
                    $totalconfirm += $roommeetingrevenue->RevRoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalconfirm += $roomonlyrevenue->RevRoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalconfirm += $packagerevenue->RevPackage;
                }
                if ($additionalrevenue != null) {
                    $totalconfirm += $additionalrevenue->RevAdditional;
                }
                if ($fnbrevenue != null) {
                    $totalconfirm += $fnbrevenue->RevFB;
                }
                if ($roomrentalrevenue != null) {
                    $totalconfirm += $roomrentalrevenue->RevRoomRental;
                }
                if ($stallrevenue != null) {
                    $totalconfirm += $stallrevenue->RevStall;
                }
                //endconfirmreveue
                //LOSS revenue
                $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
                $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
                $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
                $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
                $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
                $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
                $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
                if ($roommeetingrevenue != null) {
                    $totalloss += $roommeetingrevenue->RevRoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalloss += $roomonlyrevenue->RevRoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalloss += $packagerevenue->RevPackage;
                }
                if ($additionalrevenue != null) {
                    $totalloss += $additionalrevenue->RevAdditional;
                }
                if ($fnbrevenue != null) {
                    $totalloss += $fnbrevenue->RevFB;
                }
                if ($roomrentalrevenue != null) {
                    $totalloss += $roomrentalrevenue->RevRoomRental;
                }
                if ($stallrevenue != null) {
                    $totalloss += $stallrevenue->RevStall;
                }
                //endloss reveue
                //postponed revenue
                $roommeetingrevenue = $this->confirm_view_model->select_clrevenueroommeeting_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
                $roomonlyrevenue = $this->confirm_view_model->select_clrevenueroomonly_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
                $packagerevenue = $this->confirm_view_model->select_clrevenuepackage_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
                $additionalrevenue = $this->confirm_view_model->select_clrevenueadditional_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
                $fnbrevenue = $this->confirm_view_model->select_clrevenuefb_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
                $roomrentalrevenue = $this->confirm_view_model->select_clrevenueroomrental_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
                $stallrevenue = $this->confirm_view_model->select_clrevenuestall_per_propertyperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
                if ($roommeetingrevenue != null) {
                    $totalclpostponed += $roommeetingrevenue->RevRoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalclpostponed += $roomonlyrevenue->RevRoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalclpostponed += $packagerevenue->RevPackage;
                }
                if ($additionalrevenue != null) {
                    $totalclpostponed += $additionalrevenue->RevAdditional;
                }
                if ($fnbrevenue != null) {
                    $totalclpostponed += $fnbrevenue->RevFB;
                }
                if ($roomrentalrevenue != null) {
                    $totalclpostponed += $roomrentalrevenue->RevRoomRental;
                }
                if ($stallrevenue != null) {
                    $totalclpostponed += $stallrevenue->RevStall;
                }
                //endpostponedreveue
                //offering revenue
                $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'offering');
                $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'offering');
                $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'offering');
                $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'offering');
                $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'offering');
                $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'offering');
                if ($roomonlyrevenue != null) {
                    $totaloffering += $roomonlyrevenue->RevRoomOnly;
                }
                if ($additionalrevenue != null) {
                    $totaloffering += $additionalrevenue->RevAdditional;
                }
                if ($packagerevenue != null) {
                    $totaloffering += $packagerevenue->RevPackage;
                }
                if ($meetingrevenue != null) {
                    $totaloffering += $meetingrevenue->RevMeetingPackage;
                }
                if ($roomrentalrevenue != null) {
                    $totaloffering += $roomrentalrevenue->RevRoomRental;
                }
                if ($stallrevenue != null) {
                    $totaloffering += $stallrevenue->RevStall;
                }
                //endofferingreveue
                //olpostponed revenue
                $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
                $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
                $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
                $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
                $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
                $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'postponed');
                if ($roomonlyrevenue != null) {
                    $totalolpostponed += $roomonlyrevenue->RevRoomOnly;
                }
                if ($additionalrevenue != null) {
                    $totalolpostponed += $additionalrevenue->RevAdditional;
                }
                if ($packagerevenue != null) {
                    $totalolpostponed += $packagerevenue->RevPackage;
                }
                if ($meetingrevenue != null) {
                    $totalolpostponed += $meetingrevenue->RevMeetingPackage;
                }
                if ($roomrentalrevenue != null) {
                    $totalolpostponed += $roomrentalrevenue->RevRoomRental;
                }
                if ($stallrevenue != null) {
                    $totalolpostponed += $stallrevenue->RevStall;
                }
                //endolpostponedreveue
                //ollost revenue
                $roomonlyrevenue = $this->offering_view_model->select_roomonlyrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
                $additionalrevenue = $this->offering_view_model->select_additionalrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
                $packagerevenue = $this->offering_view_model->select_packagerevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
                $meetingrevenue = $this->offering_view_model->select_meetingpackagerevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
                $roomrentalrevenue = $this->offering_view_model->select_roomrentalrevenuenew_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
                $stallrevenue = $this->offering_view_model->select_stallrevenue_per_propperiodstatus($rowprop->idproperty, date('m'), date('Y'), 'loss');
                if ($roomonlyrevenue != null) {
                    $totalloss += $roomonlyrevenue->RevRoomOnly;
                }
                if ($additionalrevenue != null) {
                    $totalloss += $additionalrevenue->RevAdditional;
                }
                if ($packagerevenue != null) {
                    $totalloss += $packagerevenue->RevPackage;
                }
                if ($meetingrevenue != null) {
                    $totalloss += $meetingrevenue->RevMeetingPackage;
                }
                if ($roomrentalrevenue != null) {
                    $totalloss += $roomrentalrevenue->RevRoomRental;
                }
                if ($stallrevenue != null) {
                    $totalloss += $stallrevenue->RevStall;
                }
                //endollossreveue

                $dt_target = $this->property_model->select_target_perproperty($rowprop->idproperty);
                if ($dt_target != NULL) {
                    $targetprop = $dt_target->amount;
                } else {
                    $targetprop = 0;
                }
                 
                $datadefinitconfirm[] = floatval($totaldefinit + $totalconfirm + $totalclpostponed);
                $datatentative[] = floatval($totaloffering + $totalolpostponed);
                $datatarget[] = floatval($targetprop);
                $datacancel[] = floatval($totalloss); //floatval();

                if (($totaldefinit + $totalconfirm + $totalclpostponed) > $mxVal) {
                    $mxVal = floatval($totaldefinit + $totalconfirm + $totalclpostponed);
                }
                if (floatval($totaloffering + $totalolpostponed) > $mxVal) {
                    $mxVal = floatval($totaloffering + $totalolpostponed);
                }
                if (floatval($targetprop) > $mxVal) {
                    $mxVal = floatval($targetprop);
                }
                if (floatval($totalloss) > $mxVal) {
                    $mxVal = floatval($totalloss);
                }
            }
        }
        //$labels = array('Serela', 'Seriti', 'Banana', 'Golden', 'Carrcadin');

        $bardefinitconfirm = new bar_3d(75, '#D54C78');
        $bardefinitconfirm->set_values($datadefinitconfirm);
        $bardefinitconfirm->colour('#FF3300');
        $bardefinitconfirm->set_tooltip("#val# <br>");
        $bardefinitconfirm->set_on_show(new bar_on_show('grow-up', 2.5, 0));

        $bartarget = new bar_3d(75, '#D54C78');
        $bartarget->set_values($datatarget);
        $bartarget->colour('#1e1ef1');
        $bartarget->set_tooltip("#val# <br>");
        $bartarget->set_on_show(new bar_on_show('grow-up', 2.5, 0));
        //$bartarget->key('Target', 12);

        $bar1 = new bar_3d(75, '#D54C78');
        $bar1->set_values($datatentative);
        $bar1->colour('#64e923');
        $bar1->set_tooltip("#val# <br>");
        $bar1->set_on_show(new bar_on_show('grow-up', 2.5, 0));
        //$bar1->key('Tentative', 12);

        $bar2 = new bar_3d(75, '#D54C78');
        $bar2->set_values($datacancel);
        $bar2->colour('#000011');
        $bar2->set_tooltip("#val# <br>");
        $bar2->set_on_show(new bar_on_show('grow-up', 2.5, 0));
        //$bar2->key('Cancel', 12);

        $tooltip = new tooltip();
        $tooltip->set_hover();

        $chart = new open_flash_chart();

        $y_legend = new y_legend('');
        $y_legend->set_style('{font-size: 22px; color: #778877}');
        $chart->set_y_legend($y_legend);

        $y = new y_axis();
        $y->set_range(0, $mxVal);
        $y->set_colours('#000000', '#d0d0d0');

        $x = new x_axis();
        $x->set_labels_from_array($labels);
        $x->set_3d(10);
        $x->set_colours('#d0d0d0', '#ffffff');

        $chart->set_x_axis($x);
        $chart->set_y_axis($y);
        $chart->set_tooltip($tooltip);

        //$chart->set_title($title);
        $chart->set_bg_colour("#ffffff");
        $chart->add_element($bartarget);
        $chart->add_element($bardefinitconfirm);
        $chart->add_element($bar1);
        $chart->add_element($bar2);
        echo $chart->toPrettyString();
    }

    function graph_achievementbyhotel_sales() {
        $this->load->plugin('ofc2');
        $datadefinitconfirm = array();
        $datatarget = array();
        $datatentative = array();
        $datacancel = array();
        $labels = array();
        $mxVal = 0;
        $dt_property = $this->property_model->select_property();
        
        $idsales = $this->session->userdata('idstaff');
       
        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;
        
        foreach ($dt_property->result() AS $rowprop) {
            $totaldefinit = 0;
            $totalconfirm = 0;
            $totalclpostponed = 0;
            $totaloffering = 0;
            $totalolpostponed = 0;
            $totalloss = 0;
            $labels[] = $rowprop->idproperty;
            //definit revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment,date('m'), date('Y'), 'definit',$rowprop->idproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit',$rowprop->idproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment,date('m'), date('Y'), 'definit',$rowprop->idproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit',$rowprop->idproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment,date('m'), date('Y'), 'definit',$rowprop->idproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment,date('m'), date('Y'), 'definit',$rowprop->idproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment,date('m'), date('Y'), 'definit',$rowprop->idproperty);
            if ($roommeetingrevenue != null) {
                $totaldefinit += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totaldefinit += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totaldefinit += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $totaldefinit += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $totaldefinit += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $totaldefinit += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totaldefinit += $stallrevenue->RevStall;
            }
            //enddefinitreveue
            //confirm revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment,date('m'), date('Y'), 'confirm',$rowprop->idproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm',$rowprop->idproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment,date('m'), date('Y'), 'confirm',$rowprop->idproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm',$rowprop->idproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment,date('m'), date('Y'), 'confirm',$rowprop->idproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment,date('m'), date('Y'), 'confirm',$rowprop->idproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment,date('m'), date('Y'), 'confirm',$rowprop->idproperty);
            if ($roommeetingrevenue != null) {
                $totalconfirm += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalconfirm += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalconfirm += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $totalconfirm += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $totalconfirm += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $totalconfirm += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totalconfirm += $stallrevenue->RevStall;
            }
            //endconfirmreveue
            //LOSS revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment,date('m'), date('Y'), 'loss',$rowprop->idproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss',$rowprop->idproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment,date('m'), date('Y'), 'loss',$rowprop->idproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss',$rowprop->idproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment,date('m'), date('Y'), 'loss',$rowprop->idproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment,date('m'), date('Y'), 'loss',$rowprop->idproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment,date('m'), date('Y'), 'loss',$rowprop->idproperty);
             if ($roommeetingrevenue != null) {
                $totalloss += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalloss += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalloss += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $totalloss += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $totalloss += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $totalloss += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totalloss += $stallrevenue->RevStall;
            }
            //endloss reveue
            //postponed revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment,date('m'), date('Y'), 'postponed',$rowprop->idproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed',$rowprop->idproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment,date('m'), date('Y'), 'postponed',$rowprop->idproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed',$rowprop->idproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment,date('m'), date('Y'), 'postponed',$rowprop->idproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment,date('m'), date('Y'), 'postponed',$rowprop->idproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment,date('m'), date('Y'), 'postponed',$rowprop->idproperty);
            if ($roommeetingrevenue != null) {
                $totalclpostponed += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalclpostponed += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalclpostponed += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $totalclpostponed += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $totalclpostponed += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $totalclpostponed += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totalclpostponed += $stallrevenue->RevStall;
            }
            //endpostponedreveue
            //offering revenue
            $roomonlyrevenue = $this->offering_view_model->select_revroomonly_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'offering');
            $additionalrevenue = $this->offering_view_model->select_revadditional_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'offering');
            $packagerevenue = $this->offering_view_model->select_revpackage_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'offering');
            $meetingrevenue = $this->offering_view_model->select_revmeetingpackage_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'offering');
            $roomrentalrevenue = $this->offering_view_model->select_revroomrental_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'offering');
            $stallrevenue = $this->offering_view_model->select_revstall_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'offering');
            if ($roomonlyrevenue != null) {
                $totaloffering += $roomonlyrevenue->RevRoomOnly;
            }
            if ($additionalrevenue != null) {
                $totaloffering += $additionalrevenue->RevAdditional;
            }
            if ($packagerevenue != null) {
                $totaloffering += $packagerevenue->RevPackage;
            }
            if ($meetingrevenue != null) {
                $totaloffering += $meetingrevenue->RevMeetingPackage;
            }
            if ($roomrentalrevenue != null) {
                $totaloffering += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totaloffering += $stallrevenue->RevStall;
            }
            //endofferingreveue
            //olpostponed revenue
             $roomonlyrevenue = $this->offering_view_model->select_revroomonly_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $additionalrevenue = $this->offering_view_model->select_revadditional_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $packagerevenue = $this->offering_view_model->select_revpackage_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $meetingrevenue = $this->offering_view_model->select_revmeetingpackage_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $roomrentalrevenue = $this->offering_view_model->select_revroomrental_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'postponed');
            $stallrevenue = $this->offering_view_model->select_revstall_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'postponed');
            if ($roomonlyrevenue != null) {
                $totalolpostponed += $roomonlyrevenue->RevRoomOnly;
            }
            if ($additionalrevenue != null) {
                $totalolpostponed += $additionalrevenue->RevAdditional;
            }
            if ($packagerevenue != null) {
                $totalolpostponed += $packagerevenue->RevPackage;
            }
            if ($meetingrevenue != null) {
                $totalolpostponed += $meetingrevenue->RevMeetingPackage;
            }
            if ($roomrentalrevenue != null) {
                $totalolpostponed += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totalolpostponed += $stallrevenue->RevStall;
            }
            //endolpostponedreveue
            //ollost revenue
            $roomonlyrevenue = $this->offering_view_model->select_revroomonly_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'loss');
            $additionalrevenue = $this->offering_view_model->select_revadditional_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'loss');
            $packagerevenue = $this->offering_view_model->select_revpackage_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'loss');
            $meetingrevenue = $this->offering_view_model->select_revmeetingpackage_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'loss');
            $roomrentalrevenue = $this->offering_view_model->select_revroomrental_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'loss');
            $stallrevenue = $this->offering_view_model->select_revstall_persalesgroup_property($salessegment,$rowprop->idproperty, date('m'), date('Y'), 'loss');
             if ($roomonlyrevenue != null) {
                $totalloss += $roomonlyrevenue->RevRoomOnly;
            }
            if ($additionalrevenue != null) {
                $totalloss += $additionalrevenue->RevAdditional;
            }
            if ($packagerevenue != null) {
                $totalloss += $packagerevenue->RevPackage;
            }
            if ($meetingrevenue != null) {
                $totalloss += $meetingrevenue->RevMeetingPackage;
            }
            if ($roomrentalrevenue != null) {
                $totalloss += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totalloss += $stallrevenue->RevStall;
            }
            //endollossreveue

            $dt_target = $this->property_model->select_target_perproperty($rowprop->idproperty);
            if ($dt_target != NULL) {
                $targetprop = $dt_target->amount;
            } else {
                $targetprop = 0;
            }

            $datadefinitconfirm[] = floatval($totaldefinit + $totalconfirm + $totalclpostponed);
            $datatentative[] = floatval($totaloffering + $totalolpostponed);
            $datatarget[] = floatval($targetprop);
            $datacancel[] = floatval($totalloss); //floatval();

            if (($totaldefinit + $totalconfirm + $totalclpostponed) > $mxVal) {
                $mxVal = floatval($totaldefinit + $totalconfirm + $totalclpostponed);
            }
            if (floatval($totaloffering + $totalolpostponed) > $mxVal) {
                $mxVal = floatval($totaloffering + $totalolpostponed);
            }
//            if (floatval($targetprop) > $mxVal) {
//                $mxVal = floatval($targetprop);
//            }
            if (floatval($totalloss) > $mxVal) {
                $mxVal = floatval($totalloss);
            }
        }
        //$labels = array('Serela', 'Seriti', 'Banana', 'Golden', 'Carrcadin');

        $bardefinitconfirm = new bar_3d(75, '#D54C78');
        $bardefinitconfirm->set_values($datadefinitconfirm);
        $bardefinitconfirm->colour('#FF3300');
        $bardefinitconfirm->set_tooltip("#val# <br>");
        $bardefinitconfirm->set_on_show(new bar_on_show('grow-up', 2.5, 0));

//        $bartarget = new bar_3d(75, '#D54C78');
//        $bartarget->set_values($datatarget);
//        $bartarget->colour('#1e1ef1');
//        $bartarget->set_tooltip("#val# <br>");
//        $bartarget->set_on_show(new bar_on_show('grow-up', 2.5, 0));
        //$bartarget->key('Target', 12);

        $bar1 = new bar_3d(75, '#D54C78');
        $bar1->set_values($datatentative);
        $bar1->colour('#64e923');
        $bar1->set_tooltip("#val# <br>");
        $bar1->set_on_show(new bar_on_show('grow-up', 2.5, 0));
        //$bar1->key('Tentative', 12);

        $bar2 = new bar_3d(75, '#D54C78');
        $bar2->set_values($datacancel);
        $bar2->colour('#000011');
        $bar2->set_tooltip("#val# <br>");
        $bar2->set_on_show(new bar_on_show('grow-up', 2.5, 0));
        //$bar2->key('Cancel', 12);

        $tooltip = new tooltip();
        $tooltip->set_hover();

        $chart = new open_flash_chart();

        $y_legend = new y_legend('');
        $y_legend->set_style('{font-size: 22px; color: #778877}');
        $chart->set_y_legend($y_legend);

        $y = new y_axis();
        $y->set_range(0, $mxVal);
        $y->set_colours('#000000', '#d0d0d0');

        $x = new x_axis();
        $x->set_labels_from_array($labels);
        $x->set_3d(10);
        $x->set_colours('#d0d0d0', '#ffffff');

        $chart->set_x_axis($x);
        $chart->set_y_axis($y);
        $chart->set_tooltip($tooltip);

        //$chart->set_title($title);
        $chart->set_bg_colour("#ffffff");
//        $chart->add_element($bartarget);
        $chart->add_element($bardefinitconfirm);
        $chart->add_element($bar1);
        $chart->add_element($bar2);
        echo $chart->toPrettyString();
    }

 
    function graph_achievementbyhotel_sales_property() {
        $this->load->plugin('ofc2');
        $datadefinitconfirm = array();
        $datatarget = array();
        $datatentative = array();
        $datacancel = array();
        $labels = array();
        $mxVal = 0;
        $dt_property = $this->property_model->select_property();
        
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');
        
        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;
        $salesunit = $dt_sales->idsalesunit_FK;
        
        $dt_sales = $this->sales_model->select_salespergroup_unit($idsales);
        
 
//        foreach($dt_sales->result() AS $row){
            $totaldefinit = 0;
            $totalconfirm = 0;
            $totalclpostponed = 0;
            $totaloffering = 0;
            $totalolpostponed = 0;
            $totalloss = 0;
            $labels[] = $userproperty;
            //definit revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment,date('m'), date('Y'), 'definit',$userproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit',$userproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment,date('m'), date('Y'), 'definit',$userproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'definit',$userproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment,date('m'), date('Y'), 'definit',$userproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment,date('m'), date('Y'), 'definit',$userproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment,date('m'), date('Y'), 'definit',$userproperty);
            if ($roommeetingrevenue != null) {
                $totaldefinit += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totaldefinit += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totaldefinit += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $totaldefinit += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $totaldefinit += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $totaldefinit += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totaldefinit += $stallrevenue->RevStall;
            }
            //enddefinitreveue
            //confirm revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment,date('m'), date('Y'), 'confirm',$userproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm',$userproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment,date('m'), date('Y'), 'confirm',$userproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'confirm',$userproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment,date('m'), date('Y'), 'confirm',$userproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment,date('m'), date('Y'), 'confirm',$userproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment,date('m'), date('Y'), 'confirm',$userproperty);
            if ($roommeetingrevenue != null) {
                $totalconfirm += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalconfirm += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalconfirm += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $totalconfirm += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $totalconfirm += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $totalconfirm += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totalconfirm += $stallrevenue->RevStall;
            }
            //endconfirmreveue
            //LOSS revenue
             $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment,date('m'), date('Y'), 'loss',$userproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss',$userproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment,date('m'), date('Y'), 'loss',$userproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'loss',$userproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment,date('m'), date('Y'), 'loss',$userproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment,date('m'), date('Y'), 'loss',$userproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment,date('m'), date('Y'), 'loss',$userproperty);
            if ($roommeetingrevenue != null) {
                $totalloss += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalloss += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalloss += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $totalloss += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $totalloss += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $totalloss += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totalloss += $stallrevenue->RevStall;
            }
            //endloss reveue
            //postponed revenue
            $roommeetingrevenue = $this->confirm_view_model->select_clrevroommeeting_persalesgroupproperty($salessegment,date('m'), date('Y'), 'postponed',$userproperty);
            $roomonlyrevenue = $this->confirm_view_model->select_clrevroomonly_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed',$userproperty);
            $packagerevenue = $this->confirm_view_model->select_clrevpackage_persalesgroupproperty($salessegment,date('m'), date('Y'), 'postponed',$userproperty);
            $additionalrevenue = $this->confirm_view_model->select_clrevadditional_persalesgroupproperty($salessegment, date('m'), date('Y'), 'postponed',$userproperty);
            $fnbrevenue = $this->confirm_view_model->select_clrevfb_persalesgroupproperty($salessegment,date('m'), date('Y'), 'postponed',$userproperty);
            $roomrentalrevenue = $this->confirm_view_model->select_revroomrental_persalesgroupproperty($salessegment,date('m'), date('Y'), 'postponed',$userproperty);
            $stallrevenue = $this->confirm_view_model->select_clrevstall_persalesgroupproperty($salessegment,date('m'), date('Y'), 'postponed',$userproperty);
           if ($roommeetingrevenue != null) {
                $totalclpostponed += $roommeetingrevenue->RevRoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalclpostponed += $roomonlyrevenue->RevRoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalclpostponed += $packagerevenue->RevPackage;
            }
            if ($additionalrevenue != null) {
                $totalclpostponed += $additionalrevenue->RevAdditional;
            }
            if ($fnbrevenue != null) {
                $totalclpostponed += $fnbrevenue->RevFB;
            }
            if ($roomrentalrevenue != null) {
                $totalclpostponed += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totalclpostponed += $stallrevenue->RevStall;
            }
            //endpostponedreveue
            //offering revenue
            $roomonlyrevenue = $this->offering_view_model->select_revroomonly_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'offering');
            $additionalrevenue = $this->offering_view_model->select_revadditional_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'offering');
            $packagerevenue = $this->offering_view_model->select_revpackage_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'offering');
            $meetingrevenue = $this->offering_view_model->select_revmeetingpackage_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'offering');
            $roomrentalrevenue = $this->offering_view_model->select_revroomrental_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'offering');
            $stallrevenue = $this->offering_view_model->select_revstall_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'offering');
            if ($roomonlyrevenue != null) {
                $totaloffering += $roomonlyrevenue->RevRoomOnly;
            }
            if ($additionalrevenue != null) {
                $totaloffering += $additionalrevenue->RevAdditional;
            }
            if ($packagerevenue != null) {
                $totaloffering += $packagerevenue->RevPackage;
            }
            if ($meetingrevenue != null) {
                $totaloffering += $meetingrevenue->RevMeetingPackage;
            }
            if ($roomrentalrevenue != null) {
                $totaloffering += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totaloffering += $stallrevenue->RevStall;
            }
            //endofferingreveue
            //olpostponed revenue
            $roomonlyrevenue = $this->offering_view_model->select_revroomonly_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'postponed');
            $additionalrevenue = $this->offering_view_model->select_revadditional_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'postponed');
            $packagerevenue = $this->offering_view_model->select_revpackage_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'postponed');
            $meetingrevenue = $this->offering_view_model->select_revmeetingpackage_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'postponed');
            $roomrentalrevenue = $this->offering_view_model->select_revroomrental_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'postponed');
            $stallrevenue = $this->offering_view_model->select_revstall_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'postponed');
             if ($roomonlyrevenue != null) {
                $totalolpostponed += $roomonlyrevenue->RevRoomOnly;
            }
            if ($additionalrevenue != null) {
                $totalolpostponed += $additionalrevenue->RevAdditional;
            }
            if ($packagerevenue != null) {
                $totalolpostponed += $packagerevenue->RevPackage;
            }
            if ($meetingrevenue != null) {
                $totalolpostponed += $meetingrevenue->RevMeetingPackage;
            }
            if ($roomrentalrevenue != null) {
                $totalolpostponed += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totalolpostponed += $stallrevenue->RevStall;
            }
            //endolpostponedreveue
            //ollost revenue
            $roomonlyrevenue = $this->offering_view_model->select_revroomonly_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'loss');
            $additionalrevenue = $this->offering_view_model->select_revadditional_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'loss');
            $packagerevenue = $this->offering_view_model->select_revpackage_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'loss');
            $meetingrevenue = $this->offering_view_model->select_revmeetingpackage_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'loss');
            $roomrentalrevenue = $this->offering_view_model->select_revroomrental_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'loss');
            $stallrevenue = $this->offering_view_model->select_revstall_persalesgroup_property($salessegment,$userproperty, date('m'), date('Y'), 'loss');
            if ($roomonlyrevenue != null) {
                $totalloss += $roomonlyrevenue->RevRoomOnly;
            }
            if ($additionalrevenue != null) {
                $totalloss += $additionalrevenue->RevAdditional;
            }
            if ($packagerevenue != null) {
                $totalloss += $packagerevenue->RevPackage;
            }
            if ($meetingrevenue != null) {
                $totalloss += $meetingrevenue->RevMeetingPackage;
            }
            if ($roomrentalrevenue != null) {
                $totalloss += $roomrentalrevenue->RevRoomRental;
            }
            if ($stallrevenue != null) {
                $totalloss += $stallrevenue->RevStall;
            }
            //endollossreveue

            $dt_target = $this->property_model->select_target_perproperty($userproperty);
            if ($dt_target != NULL) {
                $targetprop = $dt_target->amount;
            } else {
                $targetprop = 0;
            }
            
             
            
            $datadefinitconfirm[] = floatval($totaldefinit + $totalconfirm + $totalclpostponed);
            $datatentative[] = floatval($totaloffering + $totalolpostponed);
            $datatarget[] = floatval($targetprop);
            $datacancel[] = floatval($totalloss); //floatval();

            if (($totaldefinit + $totalconfirm + $totalclpostponed) > $mxVal) {
                $mxVal = floatval($totaldefinit + $totalconfirm + $totalclpostponed);
            }
            if (floatval($totaloffering + $totalolpostponed) > $mxVal) {
                $mxVal = floatval($totaloffering + $totalolpostponed);
            }
//            if (floatval($targetprop) > $mxVal) {
//                $mxVal = floatval($targetprop);
//            }
            if (floatval($totalloss) > $mxVal) {
                $mxVal = floatval($totalloss);
            }
//        }//endforeach
        //$labels = array('Serela', 'Seriti', 'Banana', 'Golden', 'Carrcadin');

        $bardefinitconfirm = new bar_3d(75, '#D54C78');
        $bardefinitconfirm->set_values($datadefinitconfirm);
        $bardefinitconfirm->colour('#FF3300');
        $bardefinitconfirm->set_tooltip("#val# <br>");
        $bardefinitconfirm->set_on_show(new bar_on_show('grow-up', 2.5, 0));

//        $bartarget = new bar_3d(75, '#D54C78');
//        $bartarget->set_values($datatarget);
//        $bartarget->colour('#1e1ef1');
//        $bartarget->set_tooltip("#val# <br>");
//        $bartarget->set_on_show(new bar_on_show('grow-up', 2.5, 0));
        //$bartarget->key('Target', 12);

        $bar1 = new bar_3d(75, '#D54C78');
        $bar1->set_values($datatentative);
        $bar1->colour('#64e923');
        $bar1->set_tooltip("#val# <br>");
        $bar1->set_on_show(new bar_on_show('grow-up', 2.5, 0));
        //$bar1->key('Tentative', 12);

        $bar2 = new bar_3d(75, '#D54C78');
        $bar2->set_values($datacancel);
        $bar2->colour('#000011');
        $bar2->set_tooltip("#val# <br>");
        $bar2->set_on_show(new bar_on_show('grow-up', 2.5, 0));
        //$bar2->key('Cancel', 12);

        $tooltip = new tooltip();
        $tooltip->set_hover();

        $chart = new open_flash_chart();

        $y_legend = new y_legend('');
        $y_legend->set_style('{font-size: 22px; color: #778877}');
        $chart->set_y_legend($y_legend);

        $y = new y_axis();
        $y->set_range(0, $mxVal);
        $y->set_colours('#000000', '#d0d0d0');

        $x = new x_axis();
        $x->set_labels_from_array($labels);
        $x->set_3d(10);
        $x->set_colours('#d0d0d0', '#ffffff');

        $chart->set_x_axis($x);
        $chart->set_y_axis($y);
        $chart->set_tooltip($tooltip);

        //$chart->set_title($title);
        $chart->set_bg_colour("#ffffff");
//        $chart->add_element($bartarget);
        $chart->add_element($bardefinitconfirm);
        $chart->add_element($bar1);
        $chart->add_element($bar2);
        echo $chart->toPrettyString();
    }
    
    function get_hotel_bar_salesproperty() {
        $this->load->plugin('ofc2');
        //BI Definit//
        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;
        $totaldefinitbi = 0;
        $dt_fb_definit = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_fb_definit != null) {
            $totaldefinitbi += $dt_fb_definit->totalfbdefinit;
        }
        $dt_room_only_definit = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_room_only_definit != null) {
            $totaldefinitbi += $dt_room_only_definit->totalroomonly;
        }
        $dt_room_meeting_definit = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_room_meeting_definit != null) {
            $totaldefinitbi += $dt_room_meeting_definit->totalroommeeting;
        }
        $dt_package_definit = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_package_definit != null) {
            $totaldefinitbi += $dt_package_definit->totalpackage;
        }
        $dt_additional_definit = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_additional_definit != null) {
            $totaldefinitbi += $dt_additional_definit->totaladditional;
        }
        $dt_roomrentalhotel_definit = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_roomrentalhotel_definit != null) {
            $totaldefinitbi += $dt_roomrentalhotel_definit->TotalRevenueRoomRental;
        }
        //end definit BI
        //confirm BI
        $totalconfirmbi = 0;
        $dt_fb_confirm = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_fb_confirm != null) {
            $totalconfirmbi += $dt_fb_confirm->totalfbdefinit;
        }
        $dt_room_only_confirm = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_room_only_confirm != null) {
            $totalconfirmbi += $dt_room_only_confirm->totalroomonly;
        }
        $dt_room_meeting_confirm = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_room_meeting_confirm != null) {
            $totalconfirmbi += $dt_room_meeting_confirm->totalroommeeting;
        }
        $dt_package_confirm = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_package_confirm != null) {
            $totalconfirmbi += $dt_package_confirm->totalpackage;
        }
        $dt_additional_confirm = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_additional_confirm != null) {
            $totalconfirmbi += $dt_additional_confirm->totaladditional;
        }
        $dt_roomrentalhotel_confirm = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'confirm');
        if ($dt_roomrentalhotel_confirm != null) {
            $totalconfirmbi += $dt_roomrentalhotel_confirm->TotalRevenueRoomRental;
        }
        //end confirm BI
        //Confirm POSTPONED BI
        $totalconfpostponedbi = 0;
        $dt_fb_confirm = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_fb_confirm != null) {
            $totalconfpostponedbi += $dt_fb_confirm->totalfbdefinit;
        }
        $dt_room_only_confirm = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_room_only_confirm != null) {
            $totalconfpostponedbi += $dt_room_only_confirm->totalroomonly;
        }
        $dt_room_meeting_confirm = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_room_meeting_confirm != null) {
            $totalconfpostponedbi += $dt_room_meeting_confirm->totalroommeeting;
        }
        $dt_package_confirm = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_package_confirm != null) {
            $totalconfpostponedbi += $dt_package_confirm->totalpackage;
        }
        $dt_additional_confirm = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_additional_confirm != null) {
            $totalconfpostponedbi += $dt_additional_confirm->totaladditional;
        }
        $dt_roomrentalhotel_confirm = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_roomrentalhotel_confirm != null) {
            $totalconfpostponedbi += $dt_roomrentalhotel_confirm->TotalRevenueRoomRental;
        }
        //Confirm end POSTPONED BI
        //tentative BI
        $totaltentativebi = 0;
        $dt_meeting_package_tentative = $this->definit_letter_model->select_meetingpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_meeting_package_tentative != null) {
            $totaltentativebi += $dt_meeting_package_tentative->TotalMeetingPackage;
        }
        $dt_room_only_tentative = $this->definit_letter_model->select_roomonly_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_room_only_tentative != null) {
            $totaltentativebi += $dt_room_only_tentative->RoomOnly;
        }
        $dt_additional_tentative = $this->definit_letter_model->select_additional_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_additional_tentative != null) {
            $totaltentativebi += $dt_additional_tentative->TotalAdditional;
        }
        $dt_banquet_package_tentative = $this->definit_letter_model->select_banquetpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_banquet_package_tentative != null) {
            $totaltentativebi += $dt_banquet_package_tentative->TotalPackage;
        }
        //new 6 May 2010///////////////////////////
        $dt_roomrental_tentatif = $this->offering_view_model->select_roomrentalrevenue_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_roomrental_tentatif != null) {
            $totaltentativebi += $dt_roomrental_tentatif->RevenueRoomRental;
        }
        //end Tentative BI
        //
        ////POSTPONED BI
        $totaloffpostponedbi = 0;
        $dt_meeting_package_tentative = $this->definit_letter_model->select_meetingpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_meeting_package_tentative != null) {
            $totaloffpostponedbi += $dt_meeting_package_tentative->TotalMeetingPackage;
        }
        $dt_room_only_tentative = $this->definit_letter_model->select_roomonly_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_room_only_tentative != null) {
            $totaloffpostponedbi += $dt_room_only_tentative->RoomOnly;
        }
        $dt_additional_tentative = $this->definit_letter_model->select_additional_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_additional_tentative != null) {
            $totaloffpostponedbi += $dt_additional_tentative->TotalAdditional;
        }
        $dt_banquet_package_tentative = $this->definit_letter_model->select_banquetpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_banquet_package_tentative != null) {
            $totaloffpostponedbi += $dt_banquet_package_tentative->TotalPackage;
        }
        //new 6 May 2010///////////////////////////
        $dt_roomrental_tentatif = $this->offering_view_model->select_roomrentalrevenue_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_roomrental_tentatif != null) {
            $totaloffpostponedbi += $dt_roomrental_tentatif->RevenueRoomRental;
        }
        //end POSTPONED BI
        //////////////////////////////////////////
        //
        //Offering LOSS BI
        $totalcancelbi = 0;
        $dt_meeting_package_cancel = $this->definit_letter_model->select_meetingpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_meeting_package_cancel != null) {
            $totalcancelbi += $dt_meeting_package_cancel->TotalMeetingPackage;
        }
        $dt_room_only_cancel = $this->definit_letter_model->select_roomonly_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_only_cancel != null) {
            $totalcancelbi += $dt_room_only_cancel->RoomOnly;
        }
        $dt_additional_cancel = $this->definit_letter_model->select_additional_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_additional_cancel != null) {
            $totalcancelbi += $dt_additional_cancel->TotalAdditional;
        }
        $dt_banquet_package_cancel = $this->definit_letter_model->select_banquetpackage_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_banquet_package_cancel != null) {
            $totalcancelbi += $dt_banquet_package_cancel->TotalPackage;
        }

        //new 6 May 2010///////////////////////////
        $dt_roomrental_cancel = $this->offering_view_model->select_roomrentalrevenue_by_salesgrouppropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_roomrental_cancel != null) {
            $totalcancelbi += $dt_roomrental_cancel->RevenueRoomRental;
        }
        //////////////////////////////////////////
        //END OFFERING LOSS BI//
        //
        //document confirm LOSS BI
        $dt_fb_confirmloss = $this->definit_letter_model->select_total_fb_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_fb_confirmloss != null) {
            $totalcancelbi += $dt_fb_confirmloss->totalfbdefinit;
        }
        $dt_room_only_confirmloss = $this->definit_letter_model->select_total_room_only_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_only_confirmloss != null) {
            $totalcancelbi += $dt_room_only_confirmloss->totalroomonly;
        }
        $dt_room_meeting_confirmloss = $this->definit_letter_model->select_total_room_meeting_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_meeting_confirmloss != null) {
            $totalcancelbi += $dt_room_meeting_confirmloss->totalroommeeting;
        }
        $dt_package_confirmloss = $this->definit_letter_model->select_total_package_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_package_confirmloss != null) {
            $totalcancelbi += $dt_package_confirmloss->totalpackage;
        }
        $dt_additional_confirmloss = $this->definit_letter_model->select_total_additional_by_sales_segment_property_date($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_additional_confirmloss != null) {
            $totalcancelbi += $dt_additional_confirmloss->totaladditional;
        }
        $dt_roomrentalhotel_confirmloss = $this->confirm_view_model->select_roomrentalrevenue_by_salessegmentpropertydatestatus($salessegment, $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_roomrentalhotel_confirmloss != null) {
            $totalcancelbi += $dt_roomrentalhotel_confirmloss->TotalRevenueRoomRental;
        }//end confirm CANCEL LOSS

        $dt_targetprop = $this->property_model->select_target_perproperty($userproperty);
        $targetprop = number_format($dt_targetprop->amount, 0, ',', '') + 0;

        $max_value = 0;

//        

        $datatarget = array(number_format($targetprop, 0, '.', '') + 0);

        $revenueconfprop = number_format($totalconfirmbi + $totaldefinitbi + $totalconfpostponedbi, 0, '.', '') + 0;

        $datadefinitconfirm = array($revenueconfprop);

        $revenuetentaprop = number_format($totaltentativebi + $totaloffpostponedbi, 0, '.', '') + 0;

        $datatentative = array($revenuetentaprop);

        $datacancel = array(
            number_format($totalcancelbi, 0, '.', '') + 0
        );

        $bardefinitconfirm = new bar_3d(75, '#D54C78');
        $bardefinitconfirm->set_values($datadefinitconfirm);
        $bardefinitconfirm->colour('#FF3300');
        $bardefinitconfirm->set_tooltip("#val# <br>");


        $bar1 = new bar_3d(75, '#D54C78');
        $bar1->set_values($datatentative);
        $bar1->colour('#64e923');
        $bar1->set_tooltip("#val# <br>");
        //$bar1->key('Tentative', 12);

        $bar2 = new bar_3d(75, '#D54C78');
        $bar2->set_values($datacancel);
        $bar2->colour('#000011');
        $bar2->set_tooltip("#val# <br>");
        //$bar2->key('Cancel', 12);

        $tooltip = new tooltip();
        $tooltip->set_hover();

        $chart = new open_flash_chart();

        $y_legend = new y_legend('');
        $y_legend->set_style('{font-size: 22px; color: #778877}');
        $chart->set_y_legend($y_legend);

        $y = new y_axis();
        $y->set_range(0, $max_value + 300000000);
        $y->set_colours('#000000', '#d0d0d0');

        $labels = array();
        $labels = array($userproperty);

        $x = new x_axis();
        $x->set_labels_from_array($labels);
        $x->set_3d(10);

        $x->set_colours('#d0d0d0', '#ffffff');

        $chart->set_x_axis($x);
        $chart->set_y_axis($y);
        $chart->set_tooltip($tooltip);

        //$chart->set_title($title);
        $chart->set_bg_colour("#ffffff");
//        $chart->add_element($bartarget);
        $chart->add_element($bardefinitconfirm);
        $chart->add_element($bar1);
        $chart->add_element($bar2);
        echo $chart->toPrettyString();
    }


    function get_achievementbyhotel_perproperty() {
        $this->load->plugin('ofc2');
       
        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');
        
        $totaldefinit = 0;
        $dt_fb_definit = $this->definit_letter_model->select_total_fb_by_property($userproperty, date('F'), date('Y'), 'definit');
        if ($dt_fb_definit != null) {
            $totaldefinit += $dt_fb_definit->totalfbdefinit;
        }
        $dt_room_only_definit = $this->definit_letter_model->select_total_room_only_by_property( $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_room_only_definit != null) {
            $totaldefinit += $dt_room_only_definit->totalroomonly;
        }
        $dt_room_meeting_definit = $this->definit_letter_model->select_total_room_meeting_by_properti( $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_room_meeting_definit != null) {
            $totaldefinit += $dt_room_meeting_definit->totalroommeeting;
        }
        $dt_package_definit = $this->definit_letter_model->select_total_package_by_property( $userproperty, date('F'), date('Y'), 'definit');
        if ($dt_package_definit != null) {
            $totaldefinit += $dt_package_definit->totalpackage;
        }
        $dt_additional_definit = $this->definit_letter_model->select_total_additional_by_property($userproperty, date('F'), date('Y'), 'definit');
        if ($dt_additional_definit != null) {
            $totaldefinit += $dt_additional_definit->totaladditional;
        }
        $dt_roomrental = $this->definit_letter_model->select_roomrentalrevenue_by_propmonthyearstatus($userproperty, date('F'), date('Y'), 'definit');
        if ($dt_roomrental != NULL) {
            $totaldefinit += $dt_roomrental->TotalRevenue;
        }
        $dt_stall = $this->definit_letter_model->select_stallrevenue_by_propmonthyearstatus($userproperty, date('F'), date('Y'), 'definit');
        if ($dt_stall != NULL) {
            $totaldefinit += $dt_stall->TotalRevenue;
        }
    //end definit
        //confirm
        $totalconfirm = 0;
        $dt_fb_confirm = $this->definit_letter_model->select_total_fb_by_property($userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_fb_confirm != null) {
            $totalconfirm += $dt_fb_confirm->totalfbdefinit;
        }
        $dt_room_only_confirm = $this->definit_letter_model->select_total_room_only_by_property(  $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_room_only_confirm != null) {
            $totalconfirm += $dt_room_only_confirm->totalroomonly;
        }
        $dt_room_meeting_confirm = $this->definit_letter_model->select_total_room_meeting_by_properti( $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_room_meeting_confirm != null) {
            $totalconfirm += $dt_room_meeting_confirm->totalroommeeting;
        }
        $dt_package_confirm = $this->definit_letter_model->select_total_package_by_property( $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_package_confirm != null) {
            $totalconfirm += $dt_package_confirm->totalpackage;
        }
        $dt_additional_confirm = $this->definit_letter_model->select_total_additional_by_property( $userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_additional_confirm != null) {
            $totalconfirm += $dt_additional_confirm->totaladditional;
        }
        $dt_roomrental = $this->definit_letter_model->select_roomrentalrevenue_by_propmonthyearstatus($userproperty, date('F'), date('Y'), 'Confirm');
        if ($dt_roomrental != NULL) {
            $totalconfirm += $dt_roomrental->TotalRevenue;
        }
        $dt_stallrevenue_confirm =  $this->definit_letter_model->select_stallrevenue_by_propmonthyearstatus($userproperty, date('F'), date('Y'), 'Confirm');
        if($dt_stallrevenue_confirm != NULL)
        {
            $totalconfirm += $dt_stallrevenue_confirm->TotalRevenue;
        }
        //end confirm
        //Confirm POSTPONED  
        $totalconfpostponed  = 0;
        $dt_fb_confirm = $this->definit_letter_model->select_total_fb_by_property( $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_fb_confirm != null) {
            $totalconfpostponed += $dt_fb_confirm->totalfbdefinit;
        }
        $dt_room_only_confirm = $this->definit_letter_model->select_total_room_only_by_property(  $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_room_only_confirm != null) {
            $totalconfpostponed += $dt_room_only_confirm->totalroomonly;
        }
        $dt_room_meeting_confirm = $this->definit_letter_model->select_total_room_meeting_by_properti($userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_room_meeting_confirm != null) {
            $totalconfpostponed += $dt_room_meeting_confirm->totalroommeeting;
        }
        $dt_package_confirm = $this->definit_letter_model->select_total_package_by_property($userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_package_confirm != null) {
            $totalconfpostponed += $dt_package_confirm->totalpackage;
        }
        $dt_additional_confirm = $this->definit_letter_model->select_total_additional_by_property($userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_additional_confirm != null) {
            $totalconfpostponed += $dt_additional_confirm->totaladditional;
        }
        $dt_roomrental = $this->definit_letter_model->select_roomrentalrevenue_by_propmonthyearstatus($userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_roomrental != NULL) {
            $totalconfpostponed += $dt_roomrental->TotalRevenue;
        }
        $dt_stallrevenue_postponed=  $this->definit_letter_model->select_stallrevenue_by_propmonthyearstatus($userproperty, date('F'), date('Y'), 'POSTPONED');
        if($dt_stallrevenue_postponed != NULL)
        {
            $totalconfpostponed += $dt_stallrevenue_postponed->TotalRevenue;
        }
        //Confirm end POSTPONED  
        //tentative
        $totaltentative  = 0;
        $dt_meeting_package_tentative = $this->definit_letter_model->select_meeting_package_by_property($userproperty, date('F'), date('Y'), 'offering');
        if ($dt_meeting_package_tentative != null) {
            $totaltentative += $dt_meeting_package_tentative->TotalMeetingPackage;
        }
        $dt_room_only_tentative = $this->definit_letter_model->select_room_only_by_property($userproperty, date('F'), date('Y'), 'offering');
        if ($dt_room_only_tentative != null) {
            $totaltentative += $dt_room_only_tentative->RoomOnly;
        }
        $dt_additional_tentative = $this->definit_letter_model->select_addtional_by_property($userproperty, date('F'), date('Y'), 'offering');
        if ($dt_additional_tentative != null) {
            $totaltentative += $dt_additional_tentative->TotalAdditional;
        }
        $dt_banquet_package_tentative = $this->definit_letter_model->select_banquet_package_by_property($userproperty, date('F'), date('Y'), 'offering');
        if ($dt_banquet_package_tentative != null) {
            $totaltentative += $dt_banquet_package_tentative->TotalPackage;
        }
        //new 6 May 2010///////////////////////////
        $dt_roomrental_tentatif = $this->offering_view_model->select_roomrentalrevenue_by_property( $userproperty, date('F'), date('Y'), 'offering');
        if ($dt_roomrental_tentatif != null) {
            $totaltentative += $dt_roomrental_tentatif->RevenueRoomRental;
        }
        //end Tentative
        //
        ////POSTPONED  
        $totaloffpostponed  = 0;
        $dt_meeting_package_tentative = $this->definit_letter_model->select_meeting_package_by_property(   $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_meeting_package_tentative != null) {
            $totaloffpostponed += $dt_meeting_package_tentative->TotalMeetingPackage;
        }
        $dt_room_only_tentative = $this->definit_letter_model->select_room_only_by_property(   $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_room_only_tentative != null) {
            $totaloffpostponed += $dt_room_only_tentative->RoomOnly;
        }
        $dt_additional_tentative = $this->definit_letter_model->select_addtional_by_property(   $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_additional_tentative != null) {
            $totaloffpostponed += $dt_additional_tentative->TotalAdditional;
        }
        $dt_banquet_package_tentative = $this->definit_letter_model->select_banquet_package_by_property(  $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_banquet_package_tentative != null) {
            $totaloffpostponed += $dt_banquet_package_tentative->TotalPackage;
        }
        //new 6 May 2010///////////////////////////
        $dt_roomrental_tentatif = $this->offering_view_model->select_roomrentalrevenue_by_property(  $userproperty, date('F'), date('Y'), 'POSTPONED');
        if ($dt_roomrental_tentatif != null) {
            $totaloffpostponed += $dt_roomrental_tentatif->RevenueRoomRental;
        }
        //end POSTPONED
        //////////////////////////////////////////
        //
        //Offering LOSS  
        $totalcancel  = 0;
        $dt_meeting_package_cancel = $this->definit_letter_model->select_meeting_package_by_property( $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_meeting_package_cancel != null) {
            $totalcancel += $dt_meeting_package_cancel->TotalMeetingPackage;
        }
        $dt_room_only_cancel = $this->definit_letter_model->select_room_only_by_property( $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_only_cancel != null) {
            $totalcancel += $dt_room_only_cancel->RoomOnly;
        }
        $dt_additional_cancel = $this->definit_letter_model->select_addtional_by_property(  $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_additional_cancel != null) {
            $totalcancel += $dt_additional_cancel->TotalAdditional;
        }
        $dt_banquet_package_cancel = $this->definit_letter_model->select_banquet_package_by_property(  $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_banquet_package_cancel != null) {
            $totalcancel += $dt_banquet_package_cancel->TotalPackage;
        }
        //new 6 May 2010///////////////////////////
        $dt_roomrental_cancel = $this->offering_view_model->select_roomrentalrevenue_by_property(   $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_roomrental_cancel != null) {
            $totalcancel += $dt_roomrental_cancel->RevenueRoomRental;
        }
        //////////////////////////////////////////
        //END OFFERING LOSS //
        //
        //document confirm LOSS  
        $dt_fb_confirmloss = $this->definit_letter_model->select_total_fb_by_property(  $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_fb_confirmloss != null) {
            $totalcancel += $dt_fb_confirmloss->totalfbdefinit;
        }
        $dt_room_only_confirmloss = $this->definit_letter_model->select_total_room_only_by_property(   $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_only_confirmloss != null) {
            $totalcancel += $dt_room_only_confirmloss->totalroomonly;
        }
        $dt_room_meeting_confirmloss = $this->definit_letter_model->select_total_room_meeting_by_properti(   $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_room_meeting_confirmloss != null) {
            $totalcancel += $dt_room_meeting_confirmloss->totalroommeeting;
        }
        $dt_package_confirmloss = $this->definit_letter_model->select_total_package_by_property(  $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_package_confirmloss != null) {
            $totalcancel += $dt_package_confirmloss->totalpackage;
        }
        $dt_additional_confirmloss = $this->definit_letter_model->select_total_additional_by_property(   $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_additional_confirmloss != null) {
            $totalcancel += $dt_additional_confirmloss->totaladditional;
        }
        $dt_roomrentalhotel_confirmloss = $this->confirm_view_model->select_revenueroomrental_by_property(   $userproperty, date('F'), date('Y'), 'LOSS');
        if ($dt_roomrentalhotel_confirmloss != null) {
            $totalcancel += $dt_roomrentalhotel_confirmloss->RevenueRoomRental;
        }//end confirm CANCEL LOSS

        $dt_targetprop = $this->property_model->select_target_perproperty($userproperty);
        $targetprop = number_format($dt_targetprop->amount, 0, ',', '') + 0;

        $max_value = 0;

        $datatarget = array(number_format($targetprop, 0, '.', '') + 0);

        $revenueconfprop = number_format($totalconfirm  + $totaldefinit  + $totalconfpostponed , 0, '.', '') + 0;

        $datadefinitconfirm = array($revenueconfprop);

        $revenuetentaprop = number_format($totaltentative  + $totaloffpostponed , 0, '.', '') + 0;

        $datatentative = array($revenuetentaprop);

        $datacancel = array(
            number_format(floatval($totalcancel) , 0, '.', '') + 0
        );

        if($max_value <  ($targetprop))
        {
            $max_value = $targetprop;
        }
        if($max_value <   ($revenueconfprop))
        {
            $max_value = $revenueconfprop;
        }
        if($max_value <   ($revenuetentaprop))
        {
            $max_value = $revenuetentaprop;
        }

        $bardefinitconfirm = new bar_3d(75, '#D54C78');
        $bardefinitconfirm->set_values($datadefinitconfirm);
        $bardefinitconfirm->colour('#FF3300');
        $bardefinitconfirm->set_tooltip("#val# <br>");

        $bar1 = new bar_3d(75, '#D54C78');
        $bar1->set_values($datatentative);
        $bar1->colour('#64e923');
        $bar1->set_tooltip("#val# <br>");

        $bar2 = new bar_3d(75, '#D54C78');
        $bar2->set_values($datacancel);
        $bar2->colour('#000011');
        $bar2->set_tooltip("#val# <br>");

        $tooltip = new tooltip();
        $tooltip->set_hover();

        $chart = new open_flash_chart();

        $y_legend = new y_legend('');
        $y_legend->set_style('{font-size: 22px; color: #778877}');
        $chart->set_y_legend($y_legend);


        $x = ceil($max_value/5);

        $y = new y_axis();
        $y->set_range(0, $max_value + $x);
        $y->set_colours('#000000', '#d0d0d0');

        $labels = array();
        $labels = array($userproperty);

        $x = new x_axis();
        $x->set_labels_from_array($labels);
        $x->set_3d(10);

        $x->set_colours('#d0d0d0', '#ffffff');

        $chart->set_x_axis($x);
        $chart->set_y_axis($y);
        $chart->set_tooltip($tooltip);
        $chart->set_bg_colour("#ffffff");
        $chart->add_element($bardefinitconfirm);
        $chart->add_element($bar1);
        $chart->add_element($bar2);
        echo $chart->toPrettyString();
    }

    function paging_confirmtoday() {
        $halaman = $this->input->post('halaman');
        if (!isset($halaman)) {
            $halaman = 1;
        }

        $limit = 4; //10 row
        $start = $limit * ($halaman - 1);
        $dt_confirmtoday = $this->confirm_letter_model->select_pagingconfirmletter_today($start, $limit);
        $dtconfirmtoday = $this->confirm_letter_model->select_confirmletter_today();
        $totalallrevenue = 0;
        foreach ($dtconfirmtoday->result() AS $row) {
            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue_byconfirm('confirm', $row->confirmnumber);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_byconfirm('confirm', $row->confirmnumber);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue_byconfirm('confirm', $row->confirmnumber);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_byconfirm('confirm', $row->confirmnumber);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue_byconfirm('confirm', $row->confirmnumber);
            $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
            $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
            if ($roommeetingrevenue != null) {
                $totalallrevenue += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalallrevenue += $roomonlyrevenue->RoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalallrevenue += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalallrevenue += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalallrevenue += $fnbrevenue->FBRevenue;
            }
            if ($roomrentalrevenue != null) {
                $totalallrevenue += $roomrentalrevenue->TotalRevenue;
            }
            if($stallrevenue != NULL)
            {
                $totalallrevenue += $stallrevenue->TotalRevenue;
            }
        }
        echo '<table class="dashboard">';
        echo '<tr class="oddRow">';
        echo '<th>Date Event</th>';
        echo '<th>Hotel</th>';
        echo '<th>Event Name</th>';
        echo '<th>Sales</th>';
        echo '<th>Total</th>';
        echo '</tr>';
        if ($dt_confirmtoday->result() != null) {
            foreach ($dt_confirmtoday->result() AS $row) {
                $totalrevenue = 0;
                $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue_byconfirm('confirm', $row->confirmnumber);
                $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_byconfirm('confirm', $row->confirmnumber);
                $packagerevenue = $this->confirm_view_model->select_packagerevenue_byconfirm('confirm', $row->confirmnumber);
                $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_byconfirm('confirm', $row->confirmnumber);
                $fnbrevenue = $this->confirm_view_model->select_fnbrevenue_byconfirm('confirm', $row->confirmnumber);
                $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
                $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
                if ($roommeetingrevenue != null) {
                    $totalrevenue += $roommeetingrevenue->RoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalrevenue += $roomonlyrevenue->RoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalrevenue += $packagerevenue->PackageRevenue;
                }
                if ($additionalrevenue != null) {
                    $totalrevenue += $additionalrevenue->AddtionalRevenue;
                }
                if ($fnbrevenue != null) {
                    $totalrevenue += $fnbrevenue->FBRevenue;
                }
                if ($roomrentalrevenue != null) {
                    $totalrevenue += $roomrentalrevenue->TotalRevenue;
                }
                if($stallrevenue != NULL)
                {
                    $totalrevenue += $stallrevenue->TotalRevenue;
                }
                echo '<tr class="additionRow">';
                echo '<td class="kolom25"><span title="' . format_waktu4($row->checkin_date) . ' - ' . format_waktu4($row->checkout_date) . '">' . format_waktu4($row->checkin_date) . ' - ' . substr(format_waktu4($row->checkout_date),0,6) . '..</span></td>';
                echo '<td style="text-align:center">' . $row->idproperty_FK . '</td>';
                if (strlen($row->account_name) > 15) {
                    echo '<td><span   title="' . $row->account_name . '">' . anchor('', substr($row->account_name, 0, 15), 'class="accountconfirm" id="' . $row->lastnumber . '"') . '...</span></td>';
                } else {
                    echo '<td><span title="' . $row->account_name . '">' . anchor('', ($row->account_name), 'class="accountconfirm" id="' . $row->lastnumber . '"') . '</span></td>';
                }
                echo '<td>' . $row->firstname . '(' . $row->initial . ')</td>';
                echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr class="additionRow">';
            echo '<td colspan="5">No Confirm Business For Today</td>';
            echo '</tr>';
        }
        echo '<tr>
                    <td colspan="3">Number Of Confirm Business : <b>' . $dtconfirmtoday->num_rows() . '</b></td>
                    <td style="text-align:right">Grand Total</td>
                    <td style="text-align:right"><b>' . number_format($totalallrevenue, 0, ',', '.') . '</b></td>
                   </tr>';
        echo '</table>';
    }

    function paging_confirmtodaypersales() {
        $halaman = $this->input->post('halaman');
        if (!isset($halaman)) {
            $halaman = 1;
        }

        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');
        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;

        $limit = 4; //10 row
        $start = $limit * ($halaman - 1);
        $dt_confirmtoday = $this->confirm_letter_model->select_pagingconfirmletterpersalesgroup_today($salessegment, $start, $limit);
        $dtconfirmtoday = $this->confirm_letter_model->select_confirmletterpersalesgroup_today($salessegment);
        $totalallrevenue = 0;
        foreach ($dtconfirmtoday->result() AS $row) {
            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue_byconfirm('confirm', $row->confirmnumber);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_byconfirm('confirm', $row->confirmnumber);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue_byconfirm('confirm', $row->confirmnumber);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_byconfirm('confirm', $row->confirmnumber);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue_byconfirm('confirm', $row->confirmnumber);
            $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
            $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
            if ($roommeetingrevenue != null) {
                $totalallrevenue += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalallrevenue += $roomonlyrevenue->RoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalallrevenue += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalallrevenue += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalallrevenue += $fnbrevenue->FBRevenue;
            }
            if ($roomrentalrevenue != null) {
                $totalallrevenue += $roomrentalrevenue->TotalRevenue;
            }
            if($stallrevenue != NULL)
            {
                $totalallrevenue += $stallrevenue->TotalRevenue;
            }
        }
        echo '<table class="dashboard">';
        echo '<tr class="oddRow">';
        echo '<th>Date Event</th>';
        echo '<th>Hotel</th>';
        echo '<th>Event Name</th>';
        echo '<th>Sales</th>';
        echo '<th>Total</th>';
        echo '</tr>';
        if ($dt_confirmtoday->result() != null) {
            foreach ($dt_confirmtoday->result() AS $row) {
                $totalrevenue = 0;
                $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue_byconfirm('confirm', $row->confirmnumber);
                $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_byconfirm('confirm', $row->confirmnumber);
                $packagerevenue = $this->confirm_view_model->select_packagerevenue_byconfirm('confirm', $row->confirmnumber);
                $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_byconfirm('confirm', $row->confirmnumber);
                $fnbrevenue = $this->confirm_view_model->select_fnbrevenue_byconfirm('confirm', $row->confirmnumber);
                $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
                $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
                if ($roommeetingrevenue != null) {
                    $totalrevenue += $roommeetingrevenue->RoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalrevenue += $roomonlyrevenue->RoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalrevenue += $packagerevenue->PackageRevenue;
                }
                if ($additionalrevenue != null) {
                    $totalrevenue += $additionalrevenue->AddtionalRevenue;
                }
                if ($fnbrevenue != null) {
                    $totalrevenue += $fnbrevenue->FBRevenue;
                }
                if ($roomrentalrevenue != null) {
                    $totalrevenue += $roomrentalrevenue->TotalRevenue;
                }
                if($stallrevenue != NULL){
                    $totalrevenue += $stallrevenue->TotalRevenue;
                }
                echo '<tr class="additionRow">';
                echo '<td class="kolom25">' . format_waktu4($row->checkin_date) . ' - ' . format_waktu4($row->checkout_date) . '</td>';
                echo '<td style="text-align:center">' . $row->idproperty_FK . '</td>';
                if (strlen($row->account_name) > 15) {
                    echo '<td><span   title="' . $row->account_name . '">' . substr($row->account_name, 0, 15) . '...</span></td>';
                } else {
                    echo '<td><span title="' . $row->account_name . '">' . $row->account_name . '</span></td>';
                }
                echo '<td>' . $row->firstname . '(' . $row->initial . ')</td>';
                echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr class="additionRow">';
            echo '<td colspan="5">No Confirm Business For Today</td>';
            echo '</tr>';
        }
        echo '<tr>
                    <td colspan="3">Number Of Confirm Business : <b>' . $dtconfirmtoday->num_rows() . '</b></td>
                    <td style="text-align:right">Grand Total</td>
                    <td style="text-align:right"><b>' . number_format($totalallrevenue, 0, ',', '.') . '</b></td>
                   </tr>';
        echo '</table>';
    }

    function paging_confirmtodaypergm() {
        $halaman = $this->input->post('halaman');
        if (!isset($halaman)) {
            $halaman = 1;
        }

        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');
     
        $limit = 4; //10 row
        $start = $limit * ($halaman - 1);
        $dt_confirmtoday = $this->confirm_letter_model->select_pagingconfirmletterpergm_today($userproperty, $start, $limit);
        $dtconfirmtoday = $this->confirm_letter_model->select_confirmletterpergm_today($userproperty);
        $totalallrevenue = 0;
        foreach ($dtconfirmtoday->result() AS $row) {
            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue_byconfirm('confirm', $row->confirmnumber);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_byconfirm('confirm', $row->confirmnumber);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue_byconfirm('confirm', $row->confirmnumber);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_byconfirm('confirm', $row->confirmnumber);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue_byconfirm('confirm', $row->confirmnumber);
            $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
            $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
            if ($roommeetingrevenue != null) {
                $totalallrevenue += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalallrevenue += $roomonlyrevenue->RoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalallrevenue += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalallrevenue += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalallrevenue += $fnbrevenue->FBRevenue;
            }
            if ($roomrentalrevenue != null) {
                $totalallrevenue += $roomrentalrevenue->TotalRevenue;
            }
            if($stallrevenue != NULL)
            {
                $totalallrevenue += $stallrevenue->TotalRevenue;
            }
        }
        echo '<table class="dashboard">';
        echo '<tr class="oddRow">';
        echo '<th>Date Event</th>';
        echo '<th>Hotel</th>';
        echo '<th>Event Name</th>';
        echo '<th>Sales</th>';
        echo '<th>Total</th>';
        echo '</tr>';
        if ($dt_confirmtoday->result() != null) {
            foreach ($dt_confirmtoday->result() AS $row) {
                $totalrevenue = 0;
                $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue_byconfirm('confirm', $row->confirmnumber);
                $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_byconfirm('confirm', $row->confirmnumber);
                $packagerevenue = $this->confirm_view_model->select_packagerevenue_byconfirm('confirm', $row->confirmnumber);
                $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_byconfirm('confirm', $row->confirmnumber);
                $fnbrevenue = $this->confirm_view_model->select_fnbrevenue_byconfirm('confirm', $row->confirmnumber);
                $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
                $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
                if ($roommeetingrevenue != null) {
                    $totalrevenue += $roommeetingrevenue->RoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalrevenue += $roomonlyrevenue->RoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalrevenue += $packagerevenue->PackageRevenue;
                }
                if ($additionalrevenue != null) {
                    $totalrevenue += $additionalrevenue->AddtionalRevenue;
                }
                if ($fnbrevenue != null) {
                    $totalrevenue += $fnbrevenue->FBRevenue;
                }
                if ($roomrentalrevenue != null) {
                    $totalrevenue += $roomrentalrevenue->TotalRevenue;
                }
                if($stallrevenue != NULL){
                    $totalrevenue += $stallrevenue->TotalRevenue;
                }
                echo '<tr class="additionRow">';
                echo '<td class="kolom25">' . format_waktu4($row->checkin_date) . ' - ' . format_waktu4($row->checkout_date) . '</td>';
                echo '<td style="text-align:center">' . $row->idproperty_FK . '</td>';
                if (strlen($row->account_name) > 15) {
                    echo '<td><span   title="' . $row->account_name . '">' . anchor('', substr($row->account_name, 0, 15), 'class="accountconfirm" id="' . $row->lastnumber . '"') . '...</span></td>';
                } else {
                    echo '<td><span title="' . $row->account_name . '">' . anchor('', ($row->account_name), 'class="accountconfirm" id="' . $row->lastnumber . '"') . '</span></td>';
                }
                echo '<td>' . $row->firstname . '(' . $row->initial . ')</td>';
                echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr class="additionRow">';
            echo '<td colspan="5">No Confirm Business For Today</td>';
            echo '</tr>';
        }
        echo '<tr>
                    <td colspan="3">Number Of Confirm Business : <b>' . $dtconfirmtoday->num_rows() . '</b></td>
                    <td style="text-align:right">Grand Total</td>
                    <td style="text-align:right"><b>' . number_format($totalallrevenue, 0, ',', '.') . '</b></td>
                   </tr>';
        echo '</table>';
    }

    function load_confirmtoday() {
        $halaman = 1;
        $limit = 4; // 10 row
        $start = $limit * ($halaman - 1);
        $dt_confirmtoday = $this->confirm_letter_model->select_pagingconfirmletter_today($start, $limit);
        $dtconfirmtoday = $this->confirm_letter_model->select_confirmletter_today();
        $totalallrevenue = 0;
        foreach ($dtconfirmtoday->result() AS $row) {
            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue_byconfirm('confirm', $row->confirmnumber);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_byconfirm('confirm', $row->confirmnumber);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue_byconfirm('confirm', $row->confirmnumber);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_byconfirm('confirm', $row->confirmnumber);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue_byconfirm('confirm', $row->confirmnumber);
            $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
            $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
            if ($roommeetingrevenue != null) {
                $totalallrevenue += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalallrevenue += $roomonlyrevenue->RoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalallrevenue += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalallrevenue += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalallrevenue += $fnbrevenue->FBRevenue;
            }
            if ($roomrentalrevenue != null) {
                $totalallrevenue += $roomrentalrevenue->TotalRevenue;
            }
            if($stallrevenue != NULL)
            {
                $totalallrevenue += $stallrevenue->TotalRevenue;
            }
        }

        echo '<table class="dashboard">';
        echo '<tr class="oddRow">';
        echo '<th>Date Event</th>';
        echo '<th>Hotel</th>';
        echo '<th>Event Name</th>';
        echo '<th>Sales</th>';
        echo '<th>Total</th>';
        echo '</tr>';
        if ($dt_confirmtoday->result() != null) {
            foreach ($dt_confirmtoday->result() AS $row) {
                $totalrevenue = 0;
                $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue_byconfirm('confirm', $row->confirmnumber);
                $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_byconfirm('confirm', $row->confirmnumber);
                $packagerevenue = $this->confirm_view_model->select_packagerevenue_byconfirm('confirm', $row->confirmnumber);
                $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_byconfirm('confirm', $row->confirmnumber);
                $fnbrevenue = $this->confirm_view_model->select_fnbrevenue_byconfirm('confirm', $row->confirmnumber);
                $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
                $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
                if ($roommeetingrevenue != null) {
                    $totalrevenue += $roommeetingrevenue->RoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalrevenue += $roomonlyrevenue->RoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalrevenue += $packagerevenue->PackageRevenue;
                }
                if ($additionalrevenue != null) {
                    $totalrevenue += $additionalrevenue->AddtionalRevenue;
                }
                if ($fnbrevenue != null) {
                    $totalrevenue += $fnbrevenue->FBRevenue;
                }
                if ($roomrentalrevenue != null) {
                    $totalrevenue += $roomrentalrevenue->TotalRevenue;
                }
                if($stallrevenue != NULL)
                {
                    $totalrevenue += $stallrevenue->TotalRevenue;
                }

                echo '<tr class="additionRow">';
                 echo '<td class="kolom25"><span title="' . format_waktu4($row->checkin_date) . ' - ' . format_waktu4($row->checkout_date) . '">' . format_waktu4($row->checkin_date) . ' - ' . substr(format_waktu4($row->checkout_date),0,6) . '..</span></td>';
               echo '<td style="text-align:center">' . $row->idproperty_FK . '</td>';
                if (strlen($row->account_name) > 15) {
                    echo '<td><span   title="' . $row->account_name . '">' . anchor('', substr($row->account_name, 0, 15), 'class="accountconfirm" id="' . $row->lastnumber . '"') . '...</span></td>';
                } else {
                    echo '<td><span title="' . $row->account_name . '">' . anchor('', ($row->account_name), 'class="accountconfirm" id="' . $row->lastnumber . '"') . '</span></td>';
                }
                echo '<td>' . $row->firstname . '(' . $row->initial . ')</td>';
                echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr class="additionRow">';
            echo '<td colspan="5">No Confirm Business For Today</td>';
            echo '</tr>';
        }
        echo '<tr>
                    <td colspan="3">Number Of Confirm Business : <b>' . $dtconfirmtoday->num_rows() . '</b></td>
                    <td style="text-align:right">Grand Total</td>
                    <td style="text-align:right"><b>' . number_format($totalallrevenue, 0, ',', '.') . '</b></td>
                   </tr>';
        echo '</table>';
    }

    function detail_confirm_business($lastnumber) {
        $this->load->model('event_type_model');
        $this->load->model('meeting_package_model');
        $this->load->model('ref_tpackage_model');
        $this->load->model('mroom_layout_model');
        $this->load->model('room_model');
        $this->load->model('weektype_model');
        $this->load->model('refadditional_model');
        $this->load->model('refbedtype_model');
        $this->load->model('meeting_structure_model');
        $this->load->model('otherpackage_model');
        $this->load->model('package_model');
        $this->load->model('strucrate_model');
        $this->load->model('mroom_model');
        $this->load->model('refweddingstall_model');
        $this->load->model('confirm_room_model');
        $this->load->model('confirm_room_comments_model');
        $this->load->model('confirm_mpackage_model');
        $this->load->model('confirm_mpackage_comments_model');
        $this->load->model('confirm_banquet_comments_model');
        $this->load->model('confirm_additional_model');
        $this->load->model('confirm_more_comments_model');
        $this->load->model('confirm_package_model');
        $this->load->model('confirm_pack_comments_model');
        $this->load->model('confirm_wedding_stall_model');
        $this->load->model('confirm_package_other_model');
        $this->load->model('offeringothpackagecomment_model');
        $this->load->model('confirmaccounts_model');
        $this->load->model('confirm_fnb_breakdown_model');
        $this->load->model('room_structure_model');
        $this->load->model('ref_room_rental_struc_model');
        $this->load->model('ref_cancelreason_model');
        $this->load->model('ref_hotel_competitor_model');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');





        $level = $this->session->userdata('level');
        $idsalesuser = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');
        if ($userproperty == "SH") {
            $sales = $this->sales_model->select_sales();
        } else {
            $sales = $this->sales_model->select_sales_by_property($userproperty);
        }

        $event_type = $this->event_type_model->select_eventtype();
        $mpackage = $this->meeting_package_model->select_mpackage();
        $package = $this->ref_tpackage_model->select_tmpackage();
        $property = $this->property_model->select_property();
        $layout = $this->mroom_layout_model->select_mroom_layout();
        $room = $this->room_model->select_room();
        $week = $this->weektype_model->select_weektype();
        $refadditional = $this->refadditional_model->select_refadditional();
        $refbedtype = $this->refbedtype_model->select_bedtype();
        // $refweddingstall = $this->refweddingstall_model->select_weddingstall();

        $dt_meetingstruc = $this->meeting_structure_model->select_meetingstruct();


        $dt_confirm = $this->confirm_letter_model->select_confirm_by_lastnumber($lastnumber);
        $noconfirm = $dt_confirm->confirmnum;

        $dt_othpackbyevent = $this->otherpackage_model->select_otherpackage_byevent($dt_confirm->ideventtype);
        $dt_packageother = $this->package_model->select_package_by_property($dt_confirm->ideventtype, $dt_confirm->idprop);
        $dt_roomtype = $this->strucrate_model->select_room_by_property($dt_confirm->idprop);
        $dt_mroom = $this->mroom_model->select_mroom_by_property($dt_confirm->idprop);

        $refweddingstall = $this->refweddingstall_model->select_stall_byproperty($dt_confirm->idprop);
        $dt_strucstall = $this->meeting_structure_model->select_structrate_stall();
        $dt_confirmroom = $this->confirm_room_model->select_confirmroom_by_confirm($noconfirm);
        $dt_roomweekdays = $this->confirm_room_model->select_confirmroomweek_by_confirm($noconfirm, 'Weekdays');
        $dt_roomweekend = $this->confirm_room_model->select_confirmroomweek_by_confirm($noconfirm, 'Weekend');
        $dt_roomcomment = $this->confirm_room_comments_model->select_comments_by_confirm($noconfirm);
        $dt_pkgnonres = $this->confirm_mpackage_model->select_confirmmp_by_confirm($noconfirm, "NON RESIDENTIAL");
        $dt_pkgres = $this->confirm_mpackage_model->select_confirmmp_by_confirm($noconfirm, "RESIDENTIAL");
        $dt_meetingpackage = $this->confirm_mpackage_model->select_confirmmp_by_confirmonly($noconfirm);
        $dt_mpcomment = $this->confirm_mpackage_comments_model->select_comments_by_confirm($noconfirm);
        $dt_banquet = $this->confirm_banquet_model->select_confirmbanquet_by_confirm($noconfirm);
        $dt_banquetcomment = $this->confirm_banquet_comments_model->select_comments_by_confirm($noconfirm);
        $dt_editmpackage = $this->confirm_mpackage_model->select_confirmeditmp_by_confirm($noconfirm);
        //$dt_additional = $this->confirm_additional_model->select_confirmadditional_by_confirm($noconfirm);

        $dt_additional = $this->refadditional_model->select_additional_by_property($dt_confirm->idprop);
        $dt_confadditional = $this->confirm_additional_model->select_confirmadditional_by_confirm($noconfirm);

        $dt_meetingstrucadditional = $this->meeting_structure_model->select_structrate_additional();


        $dt_groupcomment = $this->confirm_more_comments_model->select_comments_by_confirm($noconfirm);

        $dt_package = $this->confirm_package_model->select_confirmpackage_by_confirm($noconfirm);
        $dt_packagecomm = $this->confirm_pack_comments_model->select_comments_by_confirm($noconfirm);
        //$dt_stall = $this->confirm_wedding_stall_model->select_confirmstall_by_confirm($noconfirm);
        $dt_stall = $this->confirm_wedding_stall_model->select_confirmstall_by_confirm($noconfirm);

        $dt_otherpackage = $this->confirm_package_other_model->select_confirmpackageother_byconfirm($noconfirm);
        $dt_otherpackagecomm = $this->offeringothpackagecomment_model->select_comments_by_offering($noconfirm);

        $dt_packagewedding = $this->package_model->select_package_by_property($dt_confirm->ideventtype, $dt_confirm->idprop);
        $dt_strucpackagewed = $this->meeting_structure_model->select_structrate_wedding();

        $refweddingstall2 = $this->refweddingstall_model->select_stall_byproperty2($dt_confirm->idprop);


        $idsales = $this->confirmaccounts_model->select_salestypebyconfirm($noconfirm, 'Sales');
        $idsource = $this->confirmaccounts_model->select_salestypebyconfirm($noconfirm, 'Source');

        $refroompackage = $this->refbedtype_model->select_roompackage();


        $dt_meetingstruconly = $this->meeting_structure_model->select_meetingstruc_only();

        $dt_fnbbreak_new = $this->confirm_fnb_breakdown_model->select_conffnbbreak_byconfirm($noconfirm);

        $dt_roomeditmp = $this->confirm_mpackage_model->select_confirmmp_by_confirm2($noconfirm);

        $dt_roombycmp = $this->room_model->select_room_by_confmpackage($noconfirm);

        $dt_roomstructure = $this->room_structure_model->select_roomstruc();

        $dt_offroomrental = $this->confirm_room_rental_model->select_confroomrental_byconf($noconfirm);
        $dt_refroomrental = $this->ref_room_rental_struc_model->select_refroomrental();

        $dt_refcancelreason = $this->ref_cancelreason_model->select_cancelreason();
        $dt_hotelcompetitor = $this->ref_hotel_competitor_model->select_hotelcompetitor();

        $data = array('accounton' => '',
            'welcomeon' => '',
            'documenton' => 'class="on"',
            'activitieson' => '',
            'reporton' => '',
            'ebookingon' => '',
            'setupon' => '',
            'calendaron' => '',
            'dt_sales' => $sales->result(),
            'dt_etype' => $event_type->result(),
            'dt_package' => $package->result(),
            'dt_mpackage' => $mpackage->result(),
            'dt_editmpack' => $dt_editmpackage->result(),
            'dt_property' => $property->result(),
            'dt_layout' => $layout->result(),
            'dt_room' => $room->result(),
            'dt_week' => $week->result(),
            'dt_refadditional' => $refadditional->result(),
            'dt_bedtype' => $refbedtype->result(),
            'dt_weddingstall' => $refweddingstall->result(),
            'confirmnumber' => $dt_confirm->confirmnum,
            'idsales' => $idsales->idsales_FK,
            'idsource' => $idsource->idsales_FK,
            'letterdate' => $dt_confirm->letterdate,
            'cidate' => tanggal_mysql_to_php($dt_confirm->cidate),
            'codate' => tanggal_mysql_to_php($dt_confirm->codate),
            'idproperty' => $dt_confirm->idprop,
            'property' => $dt_confirm->property,
            'alamatprop' => $dt_confirm->addproperty,
            'client' => $dt_confirm->salute . ' ' . $dt_confirm->firstname . ' ' . $dt_confirm->lastname,
            'title' => $dt_confirm->title,
            'address' => $dt_confirm->ctaddress,
            'phone' => $dt_confirm->ctphone,
            'fax' => $dt_confirm->ctfax,
            'hp' => $dt_confirm->ctmob,
            'email' => $dt_confirm->ctemail,
            'ideventtype' => $dt_confirm->ideventtype,
            'eventname' => $dt_confirm->eventname,
            'idvenueletter' => $dt_confirm->idmroom,
            'pax' => $dt_confirm->pax,
            'idmlayout' => $dt_confirm->idmlayout,
            'eventdate' => tanggal_mysql_to_php($dt_confirm->cidate),
            'account' => $dt_confirm->account,
            'idaccount' => $dt_confirm->idaccount,
            'idvenueletter' => $dt_confirm->idmroom,
            'lastnumber' => $lastnumber,
            'dt_roommp' => $dt_roomeditmp->result(),
            'dt_confroom' => $dt_confirmroom->result(),
            'dt_roomwd' => $dt_roomweekdays->result(),
            'dt_roomwe' => $dt_roomweekend->result(),
            'dt_packagemeeting' => $package->result(),
            'dt_res' => $dt_pkgres->result(),
            'dt_nonres' => $dt_pkgnonres->result(),
            'dt_meetingstruct' => $dt_meetingstruc->result(),
            'dt_additional' => $dt_additional->result(),
            'dt_roomtype' => $dt_roomtype->result(),
            'dt_roomcomment' => $dt_roomcomment,
            'dt_banquet' => $dt_banquet->result(),
            'dt_mroom' => $dt_mroom->result(),
            'dt_banquetcomment' => $dt_banquetcomment,
            'dt_meetingpackage' => $dt_meetingpackage->result(),
            'dt_mpcomment' => $dt_mpcomment,
            'dt_groupcomment' => $dt_groupcomment,
            'dt_package' => $dt_package->result(),
            'dt_packagecomm' => $dt_packagecomm,
            'dt_stall' => $dt_stall->result(),
            'dt_strucratestall' => $dt_strucstall->result(),
            'dt_packagewedding' => $dt_packagewedding->result(),
            'dt_strucratewedding' => $dt_strucpackagewed->result(),
            'dt_otherpackage' => $dt_otherpackage->result(),
            'dt_othpackcomm' => $dt_otherpackagecomm,
            'dt_packageother' => $dt_packageother->result(),
            'dt_othpackbyevent' => $dt_othpackbyevent->result(),
            'dt_confadditional' => $dt_confadditional->result(),
            'dt_weddingstall2' => $refweddingstall2->result(),
            'dt_strucrateadditional' => $dt_meetingstrucadditional->result(),
            'dt_refroompackage' => $refroompackage->result(),
            'dt_meetingstruconly' => $dt_meetingstruconly->result(),
            'dt_fnbbreaknew' => $dt_fnbbreak_new->result(),
            'dt_roombycmp' => $dt_roombycmp->result(),
            'dt_roomstruc' => $dt_roomstructure->result(),
            'dt_refroomrental' => $dt_refroomrental->result(),
            'dt_offroomrental' => $dt_offroomrental->result(),
            'dt_cancelreason' => $dt_refcancelreason->result(),
            'dt_hotelcompetitor' => $dt_hotelcompetitor->result(),
            'userlevel' => $level,
            'userproperty' => $userproperty,
            'iduser' => $idsalesuser,
            'documentowner' => $dt_confirm->owned_by
        );
        // $this->load->view('document/confirmation_letter/edit_confirmation',$data);
        if ($dt_confirm->ideventtype == 'ME' || $dt_confirm->ideventtype == 'RO') {
            $this->load->view('dashboard_confirm_detail', $data);
        } else {
            $this->load->view('dashboard_confirm_detail_nonmeeting', $data);
        }
    }

    function detail_offering($lastnumber) {
        $this->load->model('event_type_model');
        $this->load->model('meeting_package_model');
        $this->load->model('ref_tpackage_model');
        $this->load->model('mroom_layout_model');
        $this->load->model('room_model');
        $this->load->model('weektype_model');
        $this->load->model('refadditional_model');
        $this->load->model('refbedtype_model');
        $this->load->model('refweddingstall_model');
        $this->load->model('offeringroom_model');
        $this->load->model('offeringroomcomments_model');
        $this->load->model('offeringmpackage_model');
        $this->load->model('offeringbanquetcomments_model');
        $this->load->model('offeringmpackagecomments_model');
        $this->load->model('offeringmorecomments_model');
        $this->load->model('offeringadditional_model');
        $this->load->model('meeting_structure_model');
        $this->load->model('offeringpackage_model');
        $this->load->model('package_model');
        $this->load->model('offeringpackagecomment_model');
        $this->load->model('offeringstall_model');
        $this->load->model('offeringotherpackage_model');
        $this->load->model('otherpackage_model');
        $this->load->model('offeringothpackagecomment_model');
        $this->load->model('offeringaccounts_model');
        $this->load->model('offeringaccounts_model');
        $this->load->model('strucrate_model');
        $this->load->model('mroom_model');
        $this->load->model('room_structure_model');
        $this->load->model('ref_room_rental_struc_model');
        $this->load->model('ref_cancelreason_model');
        $this->load->model('ref_hotel_competitor_model');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');
        $this->load->model('');


        $level = $this->session->userdata('level');
        $idsalesuser = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');
        if (($level == "Admin" || $level == "Manager") && $userproperty == "SH") {
            $sales = $this->sales_model->select_sales();
        } else {
            $sales = $this->sales_model->select_sales_by_property($userproperty);
        }

        $event_type = $this->event_type_model->select_eventtype();
        $mpackage = $this->meeting_package_model->select_mpackage();
        $package = $this->ref_tpackage_model->select_tmpackage();
        $property = $this->property_model->select_property();
        $layout = $this->mroom_layout_model->select_mroom_layout();
        $room = $this->room_model->select_room();
        $week = $this->weektype_model->select_weektype();
        $refadditional = $this->refadditional_model->select_refadditional();
        $refbedtype = $this->refbedtype_model->select_bedtype();

        $dt_offering = $this->offering_letter_model->select_offering_by_lastnumber($lastnumber);
        $nooffering = $dt_offering->offeringnum;

        $refweddingstall = $this->refweddingstall_model->select_stall_byproperty($dt_offering->idprop);
        $refweddingstall2 = $this->refweddingstall_model->select_stall_byproperty2($dt_offering->idprop);

        $dt_offeringroom = $this->offeringroom_model->select_offeringroom_by_offering($nooffering);
        $dt_roomweekdays = $this->offeringroom_model->select_offeringroomweek_by_offering($nooffering, 'Weekdays');
        $dt_roomweekend = $this->offeringroom_model->select_offeringroomweek_by_offering($nooffering, 'Weekend');
        $dt_roomcomment = $this->offeringroomcomments_model->select_comments_by_offering($nooffering);
        $dt_pkgnonres = $this->offeringmpackage_model->select_offeringpackage_by_offering($nooffering, "NON RESIDENTIAL");
        $dt_pkgres = $this->offeringmpackage_model->select_offeringpackage_by_offering($nooffering, "RESIDENTIAL");
        $dt_banquet = $this->offeringbanquet_model->select_offeringbanquet_by_offering($nooffering);
        $dt_banquetcomment = $this->offeringbanquetcomments_model->select_comments_by_offering($nooffering);
        $dt_meetingpackage = $this->offeringmpackage_model->select_offeringmp_by_offering($nooffering);
        $dt_editmpackage = $this->offeringmpackage_model->select_offeringeditmp_by_offering($nooffering);
        $dt_mpcomment = $this->offeringmpackagecomments_model->select_comments_by_offering($nooffering);
        //$dt_additional = $this->offeringadditional_model->select_offeringadditional_by_offering($nooffering);
        $dt_groupcomment = $this->offeringmorecomments_model->select_comments_by_offering($nooffering);

        $dt_additional = $this->refadditional_model->select_additional_by_property($dt_offering->idprop);
        $dt_offadditional = $this->offeringadditional_model->select_offeringadditional_by_offering($nooffering);

        $dt_meetingstruc = $this->meeting_structure_model->select_meetingstruct();

        $dt_meetingstruconly = $this->meeting_structure_model->select_meetingstruc_only();

        $dt_meetingstrucadditional = $this->meeting_structure_model->select_structrate_additional();

        $dt_strucpackagewed = $this->meeting_structure_model->select_structrate_wedding();

        $dt_strucstall = $this->meeting_structure_model->select_structrate_stall();

        $dt_package = $this->offeringpackage_model->select_offeringpackage_by_offering($nooffering);
        $dt_packagewedding = $this->package_model->select_package_by_property($dt_offering->ideventtype, $dt_offering->idprop);

        $dt_packagecomm = $this->offeringpackagecomment_model->select_comments_by_offering($nooffering);
        $dt_stall = $this->offeringstall_model->select_offeringstall_by_offering($nooffering);
        $dt_otherpackage = $this->offeringotherpackage_model->select_offeringotherpackage_by_offering($nooffering);
        $dt_othpackbyevent = $this->otherpackage_model->select_otherpackage_byevent($dt_offering->ideventtype);
        $dt_otherpackagecomm = $this->offeringothpackagecomment_model->select_comments_by_offering($nooffering);

        $dt_packageother = $this->package_model->select_package_by_property($dt_offering->ideventtype, $dt_offering->idprop);

        $idsales = $this->offeringaccounts_model->select_salestypebyoffering($nooffering, 'Sales');
        $idsource = $this->offeringaccounts_model->select_salestypebyoffering($nooffering, 'Source');

        $dt_roomtype = $this->strucrate_model->select_room_by_property($dt_offering->idprop);
        $dt_mroom = $this->mroom_model->select_mroom_by_property($dt_offering->idprop);

        $dt_roomstructure = $this->room_structure_model->select_roomstruc();

        $refroompackage = $this->refbedtype_model->select_roompackage();

        $dt_offroomrental = $this->offering_room_rental_model->select_offroomrental_byoffering($nooffering);
        $dt_refroomrental = $this->ref_room_rental_struc_model->select_refroomrental();


        $dt_refcancelreason = $this->ref_cancelreason_model->select_cancelreason();
        $dt_hotelcompetitor = $this->ref_hotel_competitor_model->select_hotelcompetitor();

        $data = array(
            'accounton' => '',
            'welcomeon' => '',
            'documenton' => 'class="on"',
            'activitieson' => '',
            'reporton' => '',
            'ebookingon' => '',
            'setupon' => '',
            'calendaron' => '',
            'dt_sales' => $sales->result(),
            'dt_etype' => $event_type->result(),
            'dt_package' => $package->result(),
            'dt_mpackage' => $mpackage->result(),
            'dt_editmpack' => $dt_editmpackage->result(),
            'dt_property' => $property->result(),
            'dt_layout' => $layout->result(),
            'dt_room' => $room->result(),
            'dt_week' => $week->result(),
            'dt_refadditional' => $refadditional->result(),
            'dt_bedtype' => $refbedtype->result(),
            'dt_weddingstall' => $refweddingstall->result(),
            'dt_weddingstall2' => $refweddingstall2->result(),
            'offeringnumber' => $dt_offering->offeringnum,
            'lastnumber' => $lastnumber,
            'idsales' => $idsales->idsales_FK,
            'idsource' => $idsource->idsales_FK,
            'letterdate' => $dt_offering->letterdate,
            'cidate' => tanggal_mysql_to_php($dt_offering->cidate),
            'codate' => tanggal_mysql_to_php($dt_offering->codate),
            'idproperty' => $dt_offering->idprop,
            'property' => $dt_offering->property,
            'alamatprop' => $dt_offering->addproperty,
            'client' => $dt_offering->salute . ' ' . $dt_offering->firstname . ' ' . $dt_offering->lastname,
            'title' => $dt_offering->title,
            'address' => $dt_offering->ctaddress,
            'phone' => $dt_offering->ctphone,
            'fax' => $dt_offering->ctfax,
            'hp' => $dt_offering->ctmob,
            'email' => $dt_offering->ctemail,
            'ideventtype' => $dt_offering->ideventtype,
            'eventname' => $dt_offering->eventname,
            'idvenueletter' => $dt_offering->idmroom,
            'pax' => $dt_offering->pax,
            'idmlayout' => $dt_offering->idmlayout,
            'eventdate' => tanggal_mysql_to_php($dt_offering->cidate),
            'account' => $dt_offering->account,
            'idaccount' => $dt_offering->idaccount,
            'dt_offroom' => $dt_offeringroom->result(),
            'dt_roomwd' => $dt_roomweekdays->result(),
            'dt_roomwe' => $dt_roomweekend->result(),
            'dt_packagemeeting' => $package->result(),
            'dt_res' => $dt_pkgres->result(),
            'dt_nonres' => $dt_pkgnonres->result(),
            'dt_meetingstruct' => $dt_meetingstruc->result(),
            'dt_strucratewedding' => $dt_strucpackagewed->result(),
            'dt_strucratestall' => $dt_strucstall->result(),
            'dt_additional' => $dt_additional->result(),
            'dt_offadditional' => $dt_offadditional->result(),
            'dt_roomtype' => $dt_roomtype->result(),
            'dt_roomcomment' => $dt_roomcomment,
            'dt_banquet' => $dt_banquet->result(),
            'dt_mroom' => $dt_mroom->result(),
            'dt_banquetcomment' => $dt_banquetcomment,
            'dt_meetingpackage' => $dt_meetingpackage->result(),
            'dt_strucrateadditional' => $dt_meetingstrucadditional->result(),
            'dt_mpcomment' => $dt_mpcomment,
            'dt_groupcomment' => $dt_groupcomment,
            'dt_package' => $dt_package->result(),
            'dt_packagewedding' => $dt_packagewedding->result(),
            'dt_packagecomm' => $dt_packagecomm,
            'dt_stall' => $dt_stall->result(),
            'dt_otherpackage' => $dt_otherpackage->result(),
            'dt_othpackcomm' => $dt_otherpackagecomm,
            'dt_packageother' => $dt_packageother->result(),
            'dt_meetingstruconly' => $dt_meetingstruconly->result(),
            'dt_othpackbyevent' => $dt_othpackbyevent->result(),
            'dt_roomstruc' => $dt_roomstructure->result(),
            'dt_refroompackage' => $refroompackage->result(),
            'dt_offroomrental' => $dt_offroomrental->result(),
            'dt_refroomrental' => $dt_refroomrental->result(),
            'dt_cancelreason' => $dt_refcancelreason->result(),
            'dt_hotelcompetitor' => $dt_hotelcompetitor->result(),
            'userlevel' => $level,
            'userproperty' => $userproperty,
            'iduser' => $idsalesuser,
            'documentowner' => $dt_offering->owned_by
        );

        if ($dt_offering->ideventtype == 'ME') {
            $this->load->view('dashboard_offering_detail', $data);
        } else {
            $this->load->view('dashboard_offeringnonmeeting_detail', $data);
        }
    }

    function load_confirmtodaypersales() {
        $halaman = 1;
        $limit = 4; // 10 row
        $start = $limit * ($halaman - 1);

        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');
        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;

        $dt_confirmtoday = $this->confirm_letter_model->select_pagingconfirmletterpersalesgroup_today($salessegment, $start, $limit);
        $dtconfirmtoday = $this->confirm_letter_model->select_confirmletterpersalesgroup_today($salessegment);
        $totalallrevenue = 0;
        foreach ($dtconfirmtoday->result() AS $row) {
            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue_byconfirm('confirm', $row->confirmnumber);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_byconfirm('confirm', $row->confirmnumber);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue_byconfirm('confirm', $row->confirmnumber);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_byconfirm('confirm', $row->confirmnumber);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue_byconfirm('confirm', $row->confirmnumber);
            $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
            $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
            if ($roommeetingrevenue != null) {
                $totalallrevenue += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalallrevenue += $roomonlyrevenue->RoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalallrevenue += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalallrevenue += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalallrevenue += $fnbrevenue->FBRevenue;
            }
            if ($roomrentalrevenue != null) {
                $totalallrevenue += $roomrentalrevenue->TotalRevenue;
            }
            if($stallrevenue != NULL)
            {
                $totalallrevenue += $stallrevenue->TotalRevenue;
            }
        }

        echo '<table class="dashboard">';
        echo '<tr class="oddRow">';
        echo '<th>Date Event</th>';
        echo '<th>Hotel</th>';
        echo '<th>Event Name</th>';
        echo '<th>Sales</th>';
        echo '<th>Total</th>';
        echo '</tr>';
        if ($dt_confirmtoday->result() != null) {
            foreach ($dt_confirmtoday->result() AS $row) {
                $totalrevenue = 0;
                $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue_byconfirm('confirm', $row->confirmnumber);
                $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_byconfirm('confirm', $row->confirmnumber);
                $packagerevenue = $this->confirm_view_model->select_packagerevenue_byconfirm('confirm', $row->confirmnumber);
                $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_byconfirm('confirm', $row->confirmnumber);
                $fnbrevenue = $this->confirm_view_model->select_fnbrevenue_byconfirm('confirm', $row->confirmnumber);
                $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
                $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
                if ($roommeetingrevenue != null) {
                    $totalrevenue += $roommeetingrevenue->RoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalrevenue += $roomonlyrevenue->RoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalrevenue += $packagerevenue->PackageRevenue;
                }
                if ($additionalrevenue != null) {
                    $totalrevenue += $additionalrevenue->AddtionalRevenue;
                }
                if ($fnbrevenue != null) {
                    $totalrevenue += $fnbrevenue->FBRevenue;
                }
                if ($roomrentalrevenue != null) {
                    $totalrevenue += $roomrentalrevenue->TotalRevenue;
                }
                if($stallrevenue != NULL)
                {
                    $totalrevenue += $stallrevenue->TotalRevenue;
                }

                echo '<tr class="additionRow">';
                echo '<td class="kolom25">' . format_waktu4($row->checkin_date) . ' - ' . format_waktu4($row->checkout_date) . '</td>';
                echo '<td style="text-align:center">' . $row->idproperty_FK . '</td>';
                if (strlen($row->account_name) > 15) {
                    echo '<td><span   title="' . $row->account_name . '">' . substr($row->account_name, 0, 15) . '...</span></td>';
                } else {
                    echo '<td><span title="' . $row->account_name . '">' . $row->account_name . '</span></td>';
                }
                echo '<td>' . $row->firstname . '(' . $row->initial . ')</td>';
                echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr class="additionRow">';
            echo '<td colspan="5">No Confirm Business For Today</td>';
            echo '</tr>';
        }
        echo '<tr>
                    <td colspan="3">Number Of Confirm Business : <b>' . $dtconfirmtoday->num_rows() . '</b></td>
                    <td style="text-align:right">Grand Total</td>
                    <td style="text-align:right"><b>' . number_format($totalallrevenue, 0, ',', '.') . '</b></td>
                   </tr>';
        echo '</table>';
    }


    function load_confirmtodaypergm() {
        $halaman = 1;
        $limit = 4; // 10 row
        $start = $limit * ($halaman - 1);

        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');
        
        $dt_confirmtoday = $this->confirm_letter_model->select_pagingconfirmletterpergm_today($userproperty, $start, $limit);
        $dtconfirmtoday = $this->confirm_letter_model->select_confirmletterpergm_today($userproperty);
        $totalallrevenue = 0;
        foreach ($dtconfirmtoday->result() AS $row) {
            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue_byconfirm('confirm', $row->confirmnumber);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_byconfirm('confirm', $row->confirmnumber);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue_byconfirm('confirm', $row->confirmnumber);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_byconfirm('confirm', $row->confirmnumber);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue_byconfirm('confirm', $row->confirmnumber);
            $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
            $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
            if ($roommeetingrevenue != null) {
                $totalallrevenue += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalallrevenue += $roomonlyrevenue->RoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalallrevenue += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalallrevenue += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalallrevenue += $fnbrevenue->FBRevenue;
            }
            if ($roomrentalrevenue != null) {
                $totalallrevenue += $roomrentalrevenue->TotalRevenue;
            }
            if($stallrevenue != NULL)
            {
                $totalallrevenue += $stallrevenue->TotalRevenue;
            }
        }

        echo '<table class="dashboard">';
        echo '<tr class="oddRow">';
        echo '<th>Date Event</th>';
        echo '<th>Hotel</th>';
        echo '<th>Event Name</th>';
        echo '<th>Sales</th>';
        echo '<th>Total</th>';
        echo '</tr>';
        if ($dt_confirmtoday->result() != null) {
            foreach ($dt_confirmtoday->result() AS $row) {
                $totalrevenue = 0;
                $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue_byconfirm('confirm', $row->confirmnumber);
                $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_byconfirm('confirm', $row->confirmnumber);
                $packagerevenue = $this->confirm_view_model->select_packagerevenue_byconfirm('confirm', $row->confirmnumber);
                $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_byconfirm('confirm', $row->confirmnumber);
                $fnbrevenue = $this->confirm_view_model->select_fnbrevenue_byconfirm('confirm', $row->confirmnumber);
                $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
                $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
                if ($roommeetingrevenue != null) {
                    $totalrevenue += $roommeetingrevenue->RoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalrevenue += $roomonlyrevenue->RoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalrevenue += $packagerevenue->PackageRevenue;
                }
                if ($additionalrevenue != null) {
                    $totalrevenue += $additionalrevenue->AddtionalRevenue;
                }
                if ($fnbrevenue != null) {
                    $totalrevenue += $fnbrevenue->FBRevenue;
                }
                if ($roomrentalrevenue != null) {
                    $totalrevenue += $roomrentalrevenue->TotalRevenue;
                }
                if($stallrevenue != NULL)
                {
                    $totalrevenue += $stallrevenue->TotalRevenue;
                }

                echo '<tr class="additionRow">';
                echo '<td class="kolom25">' . format_waktu4($row->checkin_date) . ' - ' . format_waktu4($row->checkout_date) . '</td>';
                echo '<td style="text-align:center">' . $row->idproperty_FK . '</td>';
                  if (strlen($row->account_name) > 15) {
                    echo '<td><span   title="' . $row->account_name . '">' . anchor('', substr($row->account_name, 0, 15), 'class="accountconfirm" id="' . $row->lastnumber . '"') . '...</span></td>';
                } else {
                    echo '<td><span title="' . $row->account_name . '">' . anchor('', ($row->account_name), 'class="accountconfirm" id="' . $row->lastnumber . '"') . '</span></td>';
                }
                echo '<td>' . $row->firstname . '(' . $row->initial . ')</td>';
                echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr class="additionRow">';
            echo '<td colspan="5">No Confirm Business For Today</td>';
            echo '</tr>';
        }
        echo '<tr>
                    <td colspan="3">Number Of Confirm Business : <b>' . $dtconfirmtoday->num_rows() . '</b></td>
                    <td style="text-align:right">Grand Total</td>
                    <td style="text-align:right"><b>' . number_format($totalallrevenue, 0, ',', '.') . '</b></td>
             </tr>';
        echo '</table>';
    }

    function load_canceltoday() {
        $halaman = 1;
        $limit = 2; // 10 row
        $start = $limit * ($halaman - 1);
        $dt_confirmtoday = $this->confirm_letter_model->select_pagingconfirmlettercancel_today($start, $limit);
        $dtconfirmtoday = $this->confirm_letter_model->select_confirmlettercancel_today();

        $dt_offcanceltoday = $this->offering_letter_model->select_pagingofferinglettercancel_today($start, $limit);
        $dtoffcanceltoday = $this->offering_letter_model->select_offeringlettercancel_today();
        $totalallrevenue = 0;
        foreach ($dtconfirmtoday->result() AS $row) {
            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue2_byconfirm($row->confirmnumber);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue2_byconfirm($row->confirmnumber);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue2_byconfirm($row->confirmnumber);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue2_byconfirm($row->confirmnumber);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue2_byconfirm($row->confirmnumber);
            $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
            $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);

            if ($roommeetingrevenue != null) {
                $totalallrevenue += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalallrevenue += $roomonlyrevenue->RoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalallrevenue += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalallrevenue += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalallrevenue += $fnbrevenue->FBRevenue;
            }
            if ($roomrentalrevenue != null) {
                $totalallrevenue += $roomrentalrevenue->TotalRevenue;
            }
            if($stallrevenue != NULL)
            {
                $totalallrevenue += $stallrevenue->TotalRevenue;
            }

        }//endforeach confirm cancel today

        foreach ($dtoffcanceltoday->result() AS $rowoff) {
            $ttladd = 0;
            $dt_add = $this->offering_view_model->select_additionalrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_add != null) {
                $totalallrevenue += $dt_add->TotalAdditional;
            }
            $ttlbqt = 0;
            $dt_bqt = $this->offering_view_model->select_fnbrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_bqt != null) {
                $totalallrevenue += $dt_bqt->TotalMeetingPackage;
            }

            $dt_pack = $this->offering_view_model->select_packagerevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_pack != null) {
                $totalallrevenue += $dt_pack->TotalPackage;
            }

            $roomrentalrevenuetentatif = $this->offering_room_rental_model->select_revenueroomrental_byoffering($rowoff->offeringnumber);
            if ($roomrentalrevenuetentatif != null) {
                $totalallrevenue += $roomrentalrevenuetentatif->TotalRevenue;
            }

            $totalroom = 0;
            $dt_roommeeting = $this->offering_view_model->select_roommeetingmeetingrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_roommeeting != null) {
                $totalallrevenue += $dt_roommeeting->RoomOnly;
            }

            $dt_stall = $this->offeringstall_model->select_revenuestall_peroffering($rowoff->offeringnumber);
            if($dt_stall != NULL)
            {
                $totalallrevenue += $dt_stall->TotalRevenue;
            }
            
        }//endforeach dtoffering cancel

        echo '<table class="dashboard">';
        echo '<tr class="oddRow">';
        echo '<th>Date Event</th>';
        echo '<th>Hotel</th>';
        echo '<th>Event Name</th>';
        echo '<th>Sales</th>';
        echo '<th>Total</th>';
        echo '</tr>';
//        if ($dt_confirmtoday->result() != null || $dt_offcanceltoday->result() != NULL) {
        foreach ($dt_confirmtoday->result() AS $rowcl) {
            $totalrevenue = 0;
            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue2_byconfirm($rowcl->confirmnumber);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue2_byconfirm($rowcl->confirmnumber);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue2_byconfirm($rowcl->confirmnumber);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue2_byconfirm($rowcl->confirmnumber);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue2_byconfirm($rowcl->confirmnumber);
            $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($rowcl->confirmnumber);
            $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($rowcl->confirmnumber);
            if ($roommeetingrevenue != null) {
                $totalrevenue += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalrevenue += $roomonlyrevenue->RoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalrevenue += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalrevenue += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalrevenue += $fnbrevenue->FBRevenue;
            }
            if ($roomrentalrevenue != null) {
                $totalrevenue += $roomrentalrevenue->TotalRevenue;
            }
            if($stallrevenue != NULL)
            {
                $totalrevenue += $stallrevenue->TotalRevenue;
            }

            echo '<tr class="additionRow">';
            echo '<td class="kolom25"><span title="' . format_waktu4($rowcl->checkin_date) . ' - ' . format_waktu4($rowcl->checkout_date) . '">' . format_waktu4($rowcl->checkin_date) . ' - ' . substr(format_waktu4($rowcl->checkout_date),0,6) . '..</span></td>';
            echo '<td style="text-align:center">' . $rowcl->idproperty_FK . '</td>';
            if (strlen($rowcl->account_name) > 15) {
                echo '<td><span   title="' . $rowcl->account_name . '">' . anchor('', substr($rowcl->account_name, 0, 15), 'class="accountconfirm" id="' . $rowcl->lastnumber . '"') . '...</span></td>';
            } else {
                echo '<td><span title="' . $rowcl->account_name . '">' . anchor('', ($rowcl->account_name), 'class="accountconfirm" id="' . $rowcl->lastnumber . '"') . '</span></td>';
            }
            echo '<td>' . $rowcl->firstname . '(' . $rowcl->initial . ')</td>';
            echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
            echo '</tr>';
        }

        foreach ($dt_offcanceltoday->result() AS $rowol) {
            $totalrevenue = 0;
            $ttladd = 0;
            $dt_add = $this->offering_view_model->select_additionalrevenue2_byoffering($rowol->offeringnumber);
            if ($dt_add != null) {
                $totalrevenue += $dt_add->TotalAdditional;
            }
            $ttlbqt = 0;
            $dt_bqt = $this->offering_view_model->select_fnbrevenue2_byoffering($rowol->offeringnumber);
            if ($dt_bqt != null) {
                $totalrevenue += $dt_bqt->TotalMeetingPackage;
            }
            $dt_pack = $this->offering_view_model->select_packagerevenue2_byoffering($rowol->offeringnumber);
            if ($dt_pack != null) {
                $totalrevenue += $dt_pack->TotalPackage;
            }
            $roomrentalrevenuetentatif = $this->offering_room_rental_model->select_revenueroomrental_byoffering($rowol->offeringnumber);
            if ($roomrentalrevenuetentatif != null) {
                $totalrevenue += $roomrentalrevenuetentatif->TotalRevenue;
            }
            $totalroom = 0;
            $dt_roommeeting = $this->offering_view_model->select_roommeetingmeetingrevenue2_byoffering($rowol->offeringnumber);
            if ($dt_roommeeting != null) {
                $totalrevenue += $dt_roommeeting->RoomOnly;
            }

            $dt_stall = $this->offeringstall_model->select_revenuestall_peroffering($rowol->offeringnumber);
            if($dt_stall != NULL)
            {
                $totalrevenue += $dt_stall->TotalRevenue;
            }
            //   $totalallrevenue += $totalrevenue;

            echo '<tr class="additionRow">';
            echo '<td class="kolom25"><span title="' . format_waktu4($rowol->checkin_date) . ' - ' . format_waktu4($rowol->checkout_date) . '">' . format_waktu4($rowol->checkin_date) . ' - ' . substr(format_waktu4($rowol->checkout_date),0,6) . '..</span></td>';
            echo '<td style="text-align:center">' . $rowol->idproperty_FK . '</td>';
            if (strlen($rowol->account_name) > 15) {
                echo '<td><span   title="' . $rowol->account_name . '">' . anchor('', substr($rowol->account_name, 0, 15), 'class="accountoffering" id="' . $rowol->lastnumber . '"') . '...</span></td>';
            } else {
                echo '<td><span title="' . $rowol->account_name . '">' . anchor('', $rowol->account_name, 'class="accountoffering" id="' . $rowol->lastnumber . '"') . '</span></td>';
            }
            echo '<td>' . $rowol->firstname . '(' . $rowol->initial . ')</td>';
            echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
            echo '</tr>';
        }
 
        echo '<tr>
                    <td colspan="3">Number Of Cancel Business : <b>' . ($dtconfirmtoday->num_rows() + $dtoffcanceltoday->num_rows()) . '</b></td>
                    <td style="text-align:right">Grand Total</td>
                    <td style="text-align:right"><b>' . number_format($totalallrevenue, 0, ',', '.') . '</b></td>
                   </tr>';
        echo '</table>';
    }

    function load_canceltodaypersales() {
        $halaman = 1;
        $limit = 2; // 10 row
        $start = $limit * ($halaman - 1);

        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');
        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;


        $dt_confirmtoday = $this->confirm_letter_model->select_pagingconfirmlettercancelpersalesgroup_today($salessegment, $start, $limit);
        $dtconfirmtoday = $this->confirm_letter_model->select_confirmlettercancelpersalesgroup_today($salessegment);

        $dt_offcanceltoday = $this->offering_letter_model->select_pagingofferinglettercancelpersalesgroup_today($salessegment, $start, $limit);
        $dtoffcanceltoday = $this->offering_letter_model->select_offeringlettercancelpersalesgroup_today($salessegment);
        $totalallrevenue = 0;
        foreach ($dtconfirmtoday->result() AS $row) {
            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue2_byconfirm($row->confirmnumber);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue2_byconfirm($row->confirmnumber);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue2_byconfirm($row->confirmnumber);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue2_byconfirm($row->confirmnumber);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue2_byconfirm($row->confirmnumber);
            $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
            $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
            if ($roommeetingrevenue != null) {
                $totalallrevenue += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalallrevenue += $roomonlyrevenue->RoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalallrevenue += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalallrevenue += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalallrevenue += $fnbrevenue->FBRevenue;
            }
            if ($roomrentalrevenue != null) {
                $totalallrevenue += $roomrentalrevenue->TotalRevenue;
            }
            if($stallrevenue != NULL)
            {
                $totalallrevenue += $stallrevenue->TotalRevenue;
            }
        }//endforeach confirm cancel today

        foreach ($dtoffcanceltoday->result() AS $rowoff) {
            $ttladd = 0;
            $dt_add = $this->offering_view_model->select_additionalrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_add != null) {
                $totalallrevenue += $dt_add->TotalAdditional;
            }
            $ttlbqt = 0;
            $dt_bqt = $this->offering_view_model->select_fnbrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_bqt != null) {
                $totalallrevenue += $dt_bqt->TotalMeetingPackage;
            }

            $dt_pack = $this->offering_view_model->select_packagerevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_pack != null) {
                $totalallrevenue += $dt_pack->TotalPackage;
            }

            $roomrentalrevenuetentatif = $this->offering_room_rental_model->select_revenueroomrental_byoffering($rowoff->offeringnumber);
            if ($roomrentalrevenuetentatif != null) {
                $totalallrevenue += $roomrentalrevenuetentatif->TotalRevenue;
            }

            $totalroom = 0;
            $dt_roommeeting = $this->offering_view_model->select_roommeetingmeetingrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_roommeeting != null) {
                $totalallrevenue += $dt_roommeeting->RoomOnly;
            }

            $dt_stallrevenue = $this->offeringstall_model->select_revenuestall_peroffering($rowoff->offeringnumber);
            if($dt_stallrevenue != NULL)
            {
                $totalallrevenue += $dt_stallrevenue->TotalRevenue;
            }
        }//endforeach dtoffering cancel

        echo '<table class="dashboard">';
        echo '<tr class="oddRow">';
        echo '<th>Date Event</th>';
        echo '<th>Hotel</th>';
        echo '<th>Event Name</th>';
        echo '<th>Sales</th>';
        echo '<th>Total</th>';
        echo '</tr>';
//        if ($dt_confirmtoday->result() != null || $dt_offcanceltoday->result() != NULL) {
        foreach ($dt_confirmtoday->result() AS $rowcl) {
            $totalrevenue = 0;
            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue2_byconfirm($rowcl->confirmnumber);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue2_byconfirm($rowcl->confirmnumber);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue2_byconfirm($rowcl->confirmnumber);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue2_byconfirm($rowcl->confirmnumber);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue2_byconfirm($rowcl->confirmnumber);
            $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($rowcl->confirmnumber);
            $stallrevenue  = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($rowcl->confirmnumber);
            if ($roommeetingrevenue != null) {
                $totalrevenue += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalrevenue += $roomonlyrevenue->RoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalrevenue += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalrevenue += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalrevenue += $fnbrevenue->FBRevenue;
            }
            if ($roomrentalrevenue != null) {
                $totalrevenue += $roomrentalrevenue->TotalRevenue;
            }
            if($stallrevenue != NULL)
            {
                $totalrevenue += $stallrevenue->TotalRevenue;
            }

            echo '<tr class="additionRow">';
            echo '<td class="kolom25">' . format_waktu4($rowcl->checkin_date) . ' - ' . format_waktu4($rowcl->checkout_date) . '</td>';
            echo '<td style="text-align:center">' . $rowcl->idproperty_FK . '</td>';
            if (strlen($rowcl->account_name) > 15) {
                echo '<td><span   title="' . $rowcl->account_name . '">' . substr($rowcl->account_name, 0, 15) . '...</span></td>';
            } else {
                echo '<td><span title="' . $rowcl->account_name . '">' . $rowcl->account_name . '</span></td>';
            }
            echo '<td>' . $rowcl->firstname . '(' . $rowcl->initial . ')</td>';
            echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
            echo '</tr>';
        }

        foreach ($dt_offcanceltoday->result() AS $rowol) {
            $totalrevenue = 0;
            $ttladd = 0;
            $dt_add = $this->offering_view_model->select_additionalrevenue2_byoffering($rowol->offeringnumber);
            if ($dt_add != null) {
                $totalrevenue += $dt_add->TotalAdditional;
            }
            $ttlbqt = 0;
            $dt_bqt = $this->offering_view_model->select_fnbrevenue2_byoffering($rowol->offeringnumber);
            if ($dt_bqt != null) {
                $totalrevenue += $dt_bqt->TotalMeetingPackage;
            }
            $dt_pack = $this->offering_view_model->select_packagerevenue2_byoffering($rowol->offeringnumber);
            if ($dt_pack != null) {
                $totalrevenue += $dt_pack->TotalPackage;
            }
            $roomrentalrevenuetentatif = $this->offering_room_rental_model->select_revenueroomrental_byoffering($rowol->offeringnumber);
            if ($roomrentalrevenuetentatif != null) {
                $totalrevenue += $roomrentalrevenuetentatif->TotalRevenue;
            }
            $totalroom = 0;
            $dt_roommeeting = $this->offering_view_model->select_roommeetingmeetingrevenue2_byoffering($rowol->offeringnumber);
            if ($dt_roommeeting != null) {
                $totalrevenue += $dt_roommeeting->RoomOnly;
            }

            $dt_stall = $this->offeringstall_model->select_revenuestall_peroffering($rowol->offeringnumber);
            if($dt_stall != NULL)
            {
                $totalrevenue += $dt_stall->TotalRevenue;
            }

            //   $totalallrevenue += $totalrevenue;

            echo '<tr class="additionRow">';
            echo '<td class="kolom25">' . format_waktu4($rowol->checkin_date) . ' - ' . format_waktu4($rowol->checkout_date) . '</td>';
            echo '<td style="text-align:center">' . $rowol->idproperty_FK . '</td>';
            if (strlen($rowol->account_name) > 15) {
                echo '<td><span   title="' . $rowol->account_name . '">' . substr($rowol->account_name, 0, 15) . '...</span></td>';
            } else {
                echo '<td><span title="' . $rowol->account_name . '">' . $rowol->account_name . '</span></td>';
            }
            echo '<td>' . $rowol->firstname . '(' . $rowol->initial . ')</td>';
            echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
            echo '</tr>';
        }
//        } else {
//            echo '<tr class="additionRow">';
//            echo '<td colspan="5">No Cancel Business For Today</td>';
//            echo '</tr>';
//        }
        echo '<tr>
                    <td colspan="3">Number Of Cancel Business : <b>' . ($dtconfirmtoday->num_rows() + $dtoffcanceltoday->num_rows()) . '</b></td>
                    <td style="text-align:right">Grand Total</td>
                    <td style="text-align:right"><b>' . number_format($totalallrevenue, 0, ',', '.') . '</b></td>
                   </tr>';
        echo '</table>';
    }


    function load_canceltodaypergm() {
        $halaman = 1;
        $limit = 2; // 10 row
        $start = $limit * ($halaman - 1);

        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');
        
        $dt_canceltoday = $this->confirm_letter_model->select_pagingconfirmlettercancelpergm_today($userproperty, $start, $limit);
        $dtcanceltoday = $this->confirm_letter_model->select_confirmlettercancelpergm_today($userproperty);

        $dt_offcanceltoday = $this->offering_letter_model->select_pagingofferinglettercancelpergm_today($userproperty, $start, $limit);
        $dtoffcanceltoday = $this->offering_letter_model->select_offeringlettercancelpergm_today($userproperty);
        $totalallrevenue = 0;
        foreach ($dtcanceltoday->result() AS $row) {
            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue2_byconfirm($row->confirmnumber);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue2_byconfirm($row->confirmnumber);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue2_byconfirm($row->confirmnumber);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue2_byconfirm($row->confirmnumber);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue2_byconfirm($row->confirmnumber);
            $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
            $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
            if ($roommeetingrevenue != null) {
                $totalallrevenue += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalallrevenue += $roomonlyrevenue->RoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalallrevenue += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalallrevenue += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalallrevenue += $fnbrevenue->FBRevenue;
            }
            if ($roomrentalrevenue != null) {
                $totalallrevenue += $roomrentalrevenue->TotalRevenue;
            }
            if($stallrevenue != NULL)
            {
                $totalallrevenue += $stallrevenue->TotalRevenue;
            }
        }//endforeach confirm cancel today

        foreach ($dtoffcanceltoday->result() AS $rowoff) {
            $ttladd = 0;
            $dt_add = $this->offering_view_model->select_additionalrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_add != null) {
                $totalallrevenue += $dt_add->TotalAdditional;
            }
            $ttlbqt = 0;
            $dt_bqt = $this->offering_view_model->select_fnbrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_bqt != null) {
                $totalallrevenue += $dt_bqt->TotalMeetingPackage;
            }

            $dt_pack = $this->offering_view_model->select_packagerevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_pack != null) {
                $totalallrevenue += $dt_pack->TotalPackage;
            }

            $roomrentalrevenuetentatif = $this->offering_room_rental_model->select_revenueroomrental_byoffering($rowoff->offeringnumber);
            if ($roomrentalrevenuetentatif != null) {
                $totalallrevenue += $roomrentalrevenuetentatif->TotalRevenue;
            }

            $totalroom = 0;
            $dt_roommeeting = $this->offering_view_model->select_roommeetingmeetingrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_roommeeting != null) {
                $totalallrevenue += $dt_roommeeting->RoomOnly;
            }

            $dt_stallrevenue = $this->offeringstall_model->select_revenuestall_peroffering($rowoff->offeringnumber);
            if($dt_stallrevenue != NULL)
            {
                $totalallrevenue += $dt_stallrevenue->TotalRevenue;
            }
        }//endforeach dtoffering cancel

        echo '<table class="dashboard">';
        echo '<tr class="oddRow">';
        echo '<th>Date Event</th>';
        echo '<th>Hotel</th>';
        echo '<th>Event Name</th>';
        echo '<th>Sales</th>';
        echo '<th>Total</th>';
        echo '</tr>';
        foreach ($dt_canceltoday->result() AS $rowcl) {
            $totalrevenue = 0;
            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue2_byconfirm($rowcl->confirmnumber);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue2_byconfirm($rowcl->confirmnumber);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue2_byconfirm($rowcl->confirmnumber);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue2_byconfirm($rowcl->confirmnumber);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue2_byconfirm($rowcl->confirmnumber);
            $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($rowcl->confirmnumber);
            $stallrevenue  = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($rowcl->confirmnumber);
            if ($roommeetingrevenue != null) {
                $totalrevenue += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalrevenue += $roomonlyrevenue->RoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalrevenue += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalrevenue += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalrevenue += $fnbrevenue->FBRevenue;
            }
            if ($roomrentalrevenue != null) {
                $totalrevenue += $roomrentalrevenue->TotalRevenue;
            }
            if($stallrevenue != NULL)
            {
                $totalrevenue += $stallrevenue->TotalRevenue;
            }

            echo '<tr class="additionRow">';
            echo '<td class="kolom25">' . format_waktu4($rowcl->checkin_date) . ' - ' . format_waktu4($rowcl->checkout_date) . '</td>';
            echo '<td style="text-align:center">' . $rowcl->idproperty_FK . '</td>';
            if (strlen($rowcl->account_name) > 15) {
                echo '<td><span   title="' . $rowcl->account_name . '">' . anchor('', substr($rowcl->account_name, 0, 15), 'class="accountconfirm" id="' . $rowcl->lastnumber . '"') . '...</span></td>';
            } else {
                echo '<td><span title="' . $rowcl->account_name . '">' . anchor('', ($rowcl->account_name), 'class="accountconfirm" id="' . $rowcl->lastnumber . '"') . '</span></td>';
            }
            echo '<td>' . $rowcl->firstname . '(' . $rowcl->initial . ')</td>';
            echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
            echo '</tr>';
        }

        foreach ($dt_offcanceltoday->result() AS $rowol) {
            $totalrevenue = 0;
            $ttladd = 0;
            $dt_add = $this->offering_view_model->select_additionalrevenue2_byoffering($rowol->offeringnumber);
            if ($dt_add != null) {
                $totalrevenue += $dt_add->TotalAdditional;
            }
            $ttlbqt = 0;
            $dt_bqt = $this->offering_view_model->select_fnbrevenue2_byoffering($rowol->offeringnumber);
            if ($dt_bqt != null) {
                $totalrevenue += $dt_bqt->TotalMeetingPackage;
            }
            $dt_pack = $this->offering_view_model->select_packagerevenue2_byoffering($rowol->offeringnumber);
            if ($dt_pack != null) {
                $totalrevenue += $dt_pack->TotalPackage;
            }
            $roomrentalrevenuetentatif = $this->offering_room_rental_model->select_revenueroomrental_byoffering($rowol->offeringnumber);
            if ($roomrentalrevenuetentatif != null) {
                $totalrevenue += $roomrentalrevenuetentatif->TotalRevenue;
            }
            $totalroom = 0;
            $dt_roommeeting = $this->offering_view_model->select_roommeetingmeetingrevenue2_byoffering($rowol->offeringnumber);
            if ($dt_roommeeting != null) {
                $totalrevenue += $dt_roommeeting->RoomOnly;
            }

            $dt_stall = $this->offeringstall_model->select_revenuestall_peroffering($rowol->offeringnumber);
            if($dt_stall != NULL)
            {
                $totalrevenue += $dt_stall->TotalRevenue;
            }

            echo '<tr class="additionRow">';
            echo '<td class="kolom25">' . format_waktu4($rowol->checkin_date) . ' - ' . format_waktu4($rowol->checkout_date) . '</td>';
            echo '<td style="text-align:center">' . $rowol->idproperty_FK . '</td>';
            if (strlen($rowol->account_name) > 15) {
                echo '<td><span   title="' . $rowol->account_name . '">' . anchor('', substr($rowol->account_name, 0, 15), 'class="accountoffering" id="' . $rowol->lastnumber . '"') . '...</span></td>';
            } else {
                echo '<td><span title="' . $rowol->account_name . '">' . anchor('', $rowol->account_name, 'class="accountoffering" id="' . $rowol->lastnumber . '"') . '</span></td>';
            }
            echo '<td>' . $rowol->firstname . '(' . $rowol->initial . ')</td>';
            echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
            echo '</tr>';
        }
 
        echo '<tr>
                    <td colspan="3">Number Of Cancel Business : <b>' . ($dtcanceltoday->num_rows() + $dtoffcanceltoday->num_rows()) . '</b></td>
                    <td style="text-align:right">Grand Total</td>
                    <td style="text-align:right"><b>' . number_format($totalallrevenue, 0, ',', '.') . '</b></td>
                   </tr>';
        echo '</table>';
    }


    function paging_canceltoday() {
        $halaman = $this->input->post('halaman');
        if (!isset($halaman)) {
            $halaman = 1;
        }
        $limit = 2; //10 row
        $start = $limit * ($halaman - 1);
        $dt_confirmtoday = $this->confirm_letter_model->select_pagingconfirmlettercancel_today($start, $limit);
        $dtconfirmtoday = $this->confirm_letter_model->select_confirmlettercancel_today();

        $dt_offcanceltoday = $this->offering_letter_model->select_pagingofferinglettercancel_today($start, $limit);
        $dtoffcanceltoday = $this->offering_letter_model->select_offeringlettercancel_today();

        $totalallrevenue = 0;
        foreach ($dtconfirmtoday->result() AS $row) {
            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue2_byconfirm($row->confirmnumber);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue2_byconfirm($row->confirmnumber);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue2_byconfirm($row->confirmnumber);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue2_byconfirm($row->confirmnumber);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue2_byconfirm($row->confirmnumber);
            $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
            $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
            if ($roommeetingrevenue != null) {
                $totalallrevenue += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalallrevenue += $roomonlyrevenue->RoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalallrevenue += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalallrevenue += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalallrevenue += $fnbrevenue->FBRevenue;
            }
            if ($roomrentalrevenue != null) {
                $totalallrevenue += $roomrentalrevenue->TotalRevenue;
            }
            if($stallrevenue != NULL)
            {
                $totalallrevenue += $stallrevenue->TotalRevenue;
            }
        }
        foreach ($dtoffcanceltoday->result() AS $rowoff) {
            $ttladd = 0;
            $dt_add = $this->offering_view_model->select_additionalrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_add != null) {
                $totalallrevenue += $dt_add->TotalAdditional;
            }
            $ttlbqt = 0;
            $dt_bqt = $this->offering_view_model->select_fnbrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_bqt != null) {
                $totalallrevenue += $dt_bqt->TotalMeetingPackage;
            }
            $dt_pack = $this->offering_view_model->select_packagerevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_pack != null) {
                $totalallrevenue += $dt_pack->TotalPackage;
            }
            $roomrentalrevenuetentatif = $this->offering_room_rental_model->select_revenueroomrental_byoffering($rowoff->offeringnumber);
            if ($roomrentalrevenuetentatif != null) {
                $totalallrevenue += $roomrentalrevenuetentatif->TotalRevenue;
            }
            $totalroom = 0;
            $dt_roommeeting = $this->offering_view_model->select_roommeetingmeetingrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_roommeeting != null) {
                $totalallrevenue += $dt_roommeeting->RoomOnly;
            }

            $dt_stall = $this->offeringstall_model->select_revenuestall_peroffering($rowoff->offeringnumber);
            if($dt_stall != NULL)
            {
                $totalallrevenue += $dt_stall->TotalRevenue;
            }
        }
        echo '<table class="dashboard">';
        echo '<tr class="oddRow">';
        echo '<th>Date Event</th>';
        echo '<th>Hotel</th>';
        echo '<th>Event Name</th>';
        echo '<th>Sales</th>';
        echo '<th>Total</th>';
        echo '</tr>';
        if ($dt_confirmtoday->result() != null || $dt_offcanceltoday->result() != NULL) {
            foreach ($dt_confirmtoday->result() AS $row) {
                $totalrevenue = 0;
                $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue2_byconfirm($row->confirmnumber);
                $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue2_byconfirm($row->confirmnumber);
                $packagerevenue = $this->confirm_view_model->select_packagerevenue2_byconfirm($row->confirmnumber);
                $additionalrevenue = $this->confirm_view_model->select_additionalrevenue2_byconfirm($row->confirmnumber);
                $fnbrevenue = $this->confirm_view_model->select_fnbrevenue2_byconfirm($row->confirmnumber);
                $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
                $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
                if ($roommeetingrevenue != null) {
                    $totalrevenue += $roommeetingrevenue->RoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalrevenue += $roomonlyrevenue->RoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalrevenue += $packagerevenue->PackageRevenue;
                }
                if ($additionalrevenue != null) {
                    $totalrevenue += $additionalrevenue->AddtionalRevenue;
                }
                if ($fnbrevenue != null) {
                    $totalrevenue += $fnbrevenue->FBRevenue;
                }
                if ($roomrentalrevenue != null) {
                    $totalrevenue += $roomrentalrevenue->TotalRevenue;
                }
                if($stallrevenue != NULL)
                {
                    $totalrevenue += $stallrevenue->TotalRevenue;
                }
                echo '<tr class="additionRow">';
                echo '<td class="kolom25"><span title="' . format_waktu4($row->checkin_date) . ' - ' . format_waktu4($row->checkout_date) . '">' . format_waktu4($row->checkin_date) . ' - ' . substr(format_waktu4($row->checkout_date),0,6 ). '..</span></td>';
                echo '<td style="text-align:center">' . $row->idproperty_FK . '</td>';
                if (strlen($row->account_name) > 15) {
                    echo '<td><span   title="' . $row->account_name . '">' . anchor('', substr($row->account_name, 0, 15), 'class="accountconfirm" id="' . $row->lastnumber . '"') . '...</span></td>';
                } else {
                    echo '<td><span title="' . $row->account_name . '">' . anchor('', $row->account_name, 'class="accountconfirm" id="' . $row->lastnumber . '"') . '</span></td>';
                }
                echo '<td>' . $row->firstname . '(' . $row->initial . ')</td>';
                echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
                echo '</tr>';
            }

            foreach ($dt_offcanceltoday->result() AS $rowol) {
                $totalrevenue = 0;
                $ttladd = 0;
                $dt_add = $this->offering_view_model->select_additionalrevenue2_byoffering($rowol->offeringnumber);
                if ($dt_add != null) {
                    $totalrevenue += $dt_add->TotalAdditional;
                }
                $ttlbqt = 0;
                $dt_bqt = $this->offering_view_model->select_fnbrevenue2_byoffering($rowol->offeringnumber);
                if ($dt_bqt != null) {
                    $totalrevenue += $dt_bqt->TotalMeetingPackage;
                }
                $dt_pack = $this->offering_view_model->select_packagerevenue2_byoffering($rowol->offeringnumber);
                if ($dt_pack != null) {
                    $totalrevenue += $dt_pack->TotalPackage;
                }
                $roomrentalrevenuetentatif = $this->offering_room_rental_model->select_revenueroomrental_byoffering($rowol->offeringnumber);
                if ($roomrentalrevenuetentatif != null) {
                    $totalrevenue += $roomrentalrevenuetentatif->TotalRevenue;
                }
                $totalroom = 0;
                $dt_roommeeting = $this->offering_view_model->select_roommeetingmeetingrevenue2_byoffering($rowol->offeringnumber);
                if ($dt_roommeeting != null) {
                    $totalrevenue += $dt_roommeeting->RoomOnly;
                }

                $dt_stall = $this->offeringstall_model->select_revenuestall_peroffering($rowol->offeringnumber);
                if($dt_stall != NULL)
                {
                    $totalrevenue += $dt_stall->TotalRevenue;
                }

                echo '<tr class="additionRow">';
                echo '<td class="kolom25"><span title="' . format_waktu4($rowol->checkin_date) . ' - ' . format_waktu4($rowol->checkout_date) . '">' . format_waktu4($rowol->checkin_date) . ' - ' . substr(format_waktu4($rowol->checkout_date),0,6) . '..</span></td>';
                echo '<td style="text-align:center">' . $rowol->idproperty_FK . '</td>';
                if (strlen($rowol->account_name) > 15) {
                    echo '<td><span   title="' . $rowol->account_name . '">' . anchor('', substr($rowol->account_name, 0, 15), 'class="accountoffering" id="' . $rowol->lastnumber . '"') . '...</span></td>';
                } else {
                    echo '<td><span title="' . $rowol->account_name . '">' . anchor('', $rowol->account_name, 'class="accountoffering" id="' . $rowol->lastnumber . '"') . '</span></td>';
                }
                echo '<td>' . $rowol->firstname . '(' . $rowol->initial . ')</td>';
                echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr class="additionRow">';
            echo '<td colspan="5">No Cancel Business For Today</td>';
            echo '</tr>';
        }
        echo '<tr>
                    <td colspan="3">Number Of Cancel Business : <b>' . ($dtconfirmtoday->num_rows() + $dtoffcanceltoday->num_rows()) . '</b></td>
                    <td style="text-align:right">Grand Total</td>
                    <td style="text-align:right"><b>' . number_format($totalallrevenue, 0, ',', '.') . '</b></td>
                   </tr>';
        echo '</table>';
    }

    function paging_canceltodaypersales() {
        $halaman = $this->input->post('halaman');
        if (!isset($halaman)) {
            $halaman = 1;
        }
        $limit = 2; //10 row
        $start = $limit * ($halaman - 1);
        $dt_confirmtoday = $this->confirm_letter_model->select_pagingconfirmlettercancel_today($start, $limit);
        $dtconfirmtoday = $this->confirm_letter_model->select_confirmlettercancel_today();

        $dt_offcanceltoday = $this->offering_letter_model->select_pagingofferinglettercancel_today($start, $limit);
        $dtoffcanceltoday = $this->offering_letter_model->select_offeringlettercancel_today();

        $totalallrevenue = 0;
        foreach ($dtconfirmtoday->result() AS $row) {
            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue2_byconfirm($row->confirmnumber);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue2_byconfirm($row->confirmnumber);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue2_byconfirm($row->confirmnumber);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue2_byconfirm($row->confirmnumber);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue2_byconfirm($row->confirmnumber);
            $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
            $stallrevenue = $this->confirm_wedding_stall_revenue->select_revenuestall_perconfirm($row->confirmnumber);
            if ($roommeetingrevenue != null) {
                $totalallrevenue += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalallrevenue += $roomonlyrevenue->RoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalallrevenue += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalallrevenue += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalallrevenue += $fnbrevenue->FBRevenue;
            }
            if ($roomrentalrevenue != null) {
                $totalallrevenue += $roomrentalrevenue->TotalRevenue;
            }
            if($stallrevenue != NULL)
            {
                $totalallrevenue += $stallrevenue->TotalRevenue;
            }
        }
        foreach ($dtoffcanceltoday->result() AS $rowoff) {
            $ttladd = 0;
            $dt_add = $this->offering_view_model->select_additionalrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_add != null) {
                $totalallrevenue += $dt_add->TotalAdditional;
            }
            $ttlbqt = 0;
            $dt_bqt = $this->offering_view_model->select_fnbrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_bqt != null) {
                $totalallrevenue += $dt_bqt->TotalMeetingPackage;
            }
            $dt_pack = $this->offering_view_model->select_packagerevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_pack != null) {
                $totalallrevenue += $dt_pack->TotalPackage;
            }
            $roomrentalrevenuetentatif = $this->offering_room_rental_model->select_revenueroomrental_byoffering($rowoff->offeringnumber);
            if ($roomrentalrevenuetentatif != null) {
                $totalallrevenue += $roomrentalrevenuetentatif->TotalRevenue;
            }
            $totalroom = 0;
            $dt_roommeeting = $this->offering_view_model->select_roommeetingmeetingrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_roommeeting != null) {
                $totalallrevenue += $dt_roommeeting->RoomOnly;
            }
            $dt_stall = $this->offeringstall_model->select_revenuestall_peroffering($rowoff->offeringnumber);
            if($dt_stall != NULL)
            {
                $totalallrevenue += $dt_stall->TotalRevenue;
            }
        }
        echo '<table class="dashboard">';
        echo '<tr class="oddRow">';
        echo '<th>Date Event</th>';
        echo '<th>Hotel</th>';
        echo '<th>Event Name</th>';
        echo '<th>Sales</th>';
        echo '<th>Total</th>';
        echo '</tr>';
        if ($dt_confirmtoday->result() != null || $dt_offcanceltoday->result() != NULL) {
            foreach ($dt_confirmtoday->result() AS $row) {
                $totalrevenue = 0;
                $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue2_byconfirm($row->confirmnumber);
                $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue2_byconfirm($row->confirmnumber);
                $packagerevenue = $this->confirm_view_model->select_packagerevenue2_byconfirm($row->confirmnumber);
                $additionalrevenue = $this->confirm_view_model->select_additionalrevenue2_byconfirm($row->confirmnumber);
                $fnbrevenue = $this->confirm_view_model->select_fnbrevenue2_byconfirm($row->confirmnumber);
                $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
                $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
                if ($roommeetingrevenue != null) {
                    $totalrevenue += $roommeetingrevenue->RoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalrevenue += $roomonlyrevenue->RoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalrevenue += $packagerevenue->PackageRevenue;
                }
                if ($additionalrevenue != null) {
                    $totalrevenue += $additionalrevenue->AddtionalRevenue;
                }
                if ($fnbrevenue != null) {
                    $totalrevenue += $fnbrevenue->FBRevenue;
                }
                if ($roomrentalrevenue != null) {
                    $totalrevenue += $roomrentalrevenue->TotalRevenue;
                }
                if($stallrevenue != NULL)
                {
                    $totalrevenue += $stallrevenue->TotalRevenue;
                }
                echo '<tr class="additionRow">';
                echo '<td class="kolom25">' . format_waktu4($row->checkin_date) . ' - ' . format_waktu4($row->checkout_date) . '</td>';
                echo '<td style="text-align:center">' . $row->idproperty_FK . '</td>';
                if (strlen($row->account_name) > 15) {
                    echo '<td><span   title="' . $row->account_name . '">' . substr($row->account_name, 0, 15) . '...</span></td>';
                } else {
                    echo '<td><span title="' . $row->account_name . '">' . $row->account_name . '</span></td>';
                }
                echo '<td>' . $row->firstname . '(' . $row->initial . ')</td>';
                echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
                echo '</tr>';
            }

            foreach ($dt_offcanceltoday->result() AS $rowol) {
                $totalrevenue = 0;
                $ttladd = 0;
                $dt_add = $this->offering_view_model->select_additionalrevenue2_byoffering($rowol->offeringnumber);
                if ($dt_add != null) {
                    $totalrevenue += $dt_add->TotalAdditional;
                }
                $ttlbqt = 0;
                $dt_bqt = $this->offering_view_model->select_fnbrevenue2_byoffering($rowol->offeringnumber);
                if ($dt_bqt != null) {
                    $totalrevenue += $dt_bqt->TotalMeetingPackage;
                }
                $dt_pack = $this->offering_view_model->select_packagerevenue2_byoffering($rowol->offeringnumber);
                if ($dt_pack != null) {
                    $totalrevenue += $dt_pack->TotalPackage;
                }
                $roomrentalrevenuetentatif = $this->offering_room_rental_model->select_revenueroomrental_byoffering($rowol->offeringnumber);
                if ($roomrentalrevenuetentatif != null) {
                    $totalrevenue += $roomrentalrevenuetentatif->TotalRevenue;
                }
                $totalroom = 0;
                $dt_roommeeting = $this->offering_view_model->select_roommeetingmeetingrevenue2_byoffering($rowol->offeringnumber);
                if ($dt_roommeeting != null) {
                    $totalrevenue += $dt_roommeeting->RoomOnly;
                }

                $dt_stall = $this->offeringstall_model->select_revenuestall_peroffering($rowol->offeringnumber);
                if($dt_stall != NULL)
                {
                    $totalrevenue += $dt_stall->TotalRevenue;
                }

                echo '<tr class="additionRow">';
                echo '<td class="kolom25">' . format_waktu4($rowol->checkin_date) . ' - ' . format_waktu4($rowol->checkout_date) . '</td>';
                echo '<td style="text-align:center">' . $rowol->idproperty_FK . '</td>';
                if (strlen($rowol->account_name) > 15) {
                    echo '<td><span   title="' . $rowol->account_name . '">' . substr($rowol->account_name, 0, 15) . '...</span></td>';
                } else {
                    echo '<td><span title="' . $rowol->account_name . '">' . $rowol->account_name . '</span></td>';
                }
                echo '<td>' . $rowol->firstname . '(' . $rowol->initial . ')</td>';
                echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr class="additionRow">';
            echo '<td colspan="5">No Cancel Business For Today</td>';
            echo '</tr>';
        }
        echo '<tr>
                    <td colspan="3">Number Of Cancel Business : <b>' . ($dtconfirmtoday->num_rows() + $dtoffcanceltoday->num_rows()) . '</b></td>
                    <td style="text-align:right">Grand Total</td>
                    <td style="text-align:right"><b>' . number_format($totalallrevenue, 0, ',', '.') . '</b></td>
                   </tr>';
        echo '</table>';
    }


    function paging_canceltodaypergm() {
        $halaman = $this->input->post('halaman');
        if (!isset($halaman)) {
            $halaman = 1;
        }

        $userproperty = $this->session->userdata('property');
        
        $limit = 2; //10 row
        $start = $limit * ($halaman - 1);
        $dt_canceltoday = $this->confirm_letter_model->select_pagingconfirmlettercancelgm_today($userproperty, $start, $limit);
        $dtcanceltoday = $this->confirm_letter_model->select_confirmlettercancelpergm_today($userproperty);

        $dt_offcanceltoday = $this->offering_letter_model->select_pagingofferinglettercancelpergm_today($userproperty,$start, $limit);
        $dtoffcanceltoday = $this->offering_letter_model->select_offeringlettercancelpergm_today($userproperty);

        $totalallrevenue = 0;
        foreach ($dtcanceltoday->result() AS $row) {
            $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue2_byconfirm($row->confirmnumber);
            $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue2_byconfirm($row->confirmnumber);
            $packagerevenue = $this->confirm_view_model->select_packagerevenue2_byconfirm($row->confirmnumber);
            $additionalrevenue = $this->confirm_view_model->select_additionalrevenue2_byconfirm($row->confirmnumber);
            $fnbrevenue = $this->confirm_view_model->select_fnbrevenue2_byconfirm($row->confirmnumber);
            $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
            $stallrevenue = $this->confirm_wedding_stall_revenue->select_revenuestall_perconfirm($row->confirmnumber);
            if ($roommeetingrevenue != null) {
                $totalallrevenue += $roommeetingrevenue->RoomMeeting;
            }
            if ($roomonlyrevenue != null) {
                $totalallrevenue += $roomonlyrevenue->RoomOnly; //oke
            }
            if ($packagerevenue != null) {
                $totalallrevenue += $packagerevenue->PackageRevenue;
            }
            if ($additionalrevenue != null) {
                $totalallrevenue += $additionalrevenue->AddtionalRevenue;
            }
            if ($fnbrevenue != null) {
                $totalallrevenue += $fnbrevenue->FBRevenue;
            }
            if ($roomrentalrevenue != null) {
                $totalallrevenue += $roomrentalrevenue->TotalRevenue;
            }
            if($stallrevenue != NULL)
            {
                $totalallrevenue += $stallrevenue->TotalRevenue;
            }
        }
        foreach ($dtoffcanceltoday->result() AS $rowoff) {
            $ttladd = 0;
            $dt_add = $this->offering_view_model->select_additionalrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_add != null) {
                $totalallrevenue += $dt_add->TotalAdditional;
            }
            $ttlbqt = 0;
            $dt_bqt = $this->offering_view_model->select_fnbrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_bqt != null) {
                $totalallrevenue += $dt_bqt->TotalMeetingPackage;
            }
            $dt_pack = $this->offering_view_model->select_packagerevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_pack != null) {
                $totalallrevenue += $dt_pack->TotalPackage;
            }
            $roomrentalrevenuetentatif = $this->offering_room_rental_model->select_revenueroomrental_byoffering($rowoff->offeringnumber);
            if ($roomrentalrevenuetentatif != null) {
                $totalallrevenue += $roomrentalrevenuetentatif->TotalRevenue;
            }
            $totalroom = 0;
            $dt_roommeeting = $this->offering_view_model->select_roommeetingmeetingrevenue2_byoffering($rowoff->offeringnumber);
            if ($dt_roommeeting != null) {
                $totalallrevenue += $dt_roommeeting->RoomOnly;
            }
            $dt_stall = $this->offeringstall_model->select_revenuestall_peroffering($rowoff->offeringnumber);
            if($dt_stall != NULL)
            {
                $totalallrevenue += $dt_stall->TotalRevenue;
            }
        }
        echo '<table class="dashboard">';
        echo '<tr class="oddRow">';
        echo '<th>Date Event</th>';
        echo '<th>Hotel</th>';
        echo '<th>Event Name</th>';
        echo '<th>Sales</th>';
        echo '<th>Total</th>';
        echo '</tr>';
        if ($dt_canceltoday->result() != null || $dt_offcanceltoday->result() != NULL) {
            foreach ($dt_canceltoday->result() AS $row) {
                $totalrevenue = 0;
                $roommeetingrevenue = $this->confirm_view_model->select_roommeetingmeetingrevenue2_byconfirm($row->confirmnumber);
                $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue2_byconfirm($row->confirmnumber);
                $packagerevenue = $this->confirm_view_model->select_packagerevenue2_byconfirm($row->confirmnumber);
                $additionalrevenue = $this->confirm_view_model->select_additionalrevenue2_byconfirm($row->confirmnumber);
                $fnbrevenue = $this->confirm_view_model->select_fnbrevenue2_byconfirm($row->confirmnumber);
                $roomrentalrevenue = $this->confirm_room_rental_model->select_revenueroomrental_byconfirm($row->confirmnumber);
                $stallrevenue = $this->confirm_wedding_stall_model->select_revenuestall_perconfirm($row->confirmnumber);
                if ($roommeetingrevenue != null) {
                    $totalrevenue += $roommeetingrevenue->RoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalrevenue += $roomonlyrevenue->RoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalrevenue += $packagerevenue->PackageRevenue;
                }
                if ($additionalrevenue != null) {
                    $totalrevenue += $additionalrevenue->AddtionalRevenue;
                }
                if ($fnbrevenue != null) {
                    $totalrevenue += $fnbrevenue->FBRevenue;
                }
                if ($roomrentalrevenue != null) {
                    $totalrevenue += $roomrentalrevenue->TotalRevenue;
                }
                if($stallrevenue != NULL)
                {
                    $totalrevenue += $stallrevenue->TotalRevenue;
                }
                echo '<tr class="additionRow">';
                echo '<td class="kolom25">' . format_waktu4($row->checkin_date) . ' - ' . format_waktu4($row->checkout_date) . '</td>';
                echo '<td style="text-align:center">' . $row->idproperty_FK . '</td>';
               if (strlen($row->account_name) > 15) {
                    echo '<td><span   title="' . $row->account_name . '">' . anchor('', substr($row->account_name, 0, 15), 'class="accountconfirm" id="' . $row->lastnumber . '"') . '...</span></td>';
                } else {
                    echo '<td><span title="' . $row->account_name . '">' . anchor('', $row->account_name, 'class="accountconfirm" id="' . $row->lastnumber . '"') . '</span></td>';
                }
                echo '<td>' . $row->firstname . '(' . $row->initial . ')</td>';
                echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
                echo '</tr>';
            }

            foreach ($dt_offcanceltoday->result() AS $rowol) {
                $totalrevenue = 0;
                $ttladd = 0;
                $dt_add = $this->offering_view_model->select_additionalrevenue2_byoffering($rowol->offeringnumber);
                if ($dt_add != null) {
                    $totalrevenue += $dt_add->TotalAdditional;
                }
                $ttlbqt = 0;
                $dt_bqt = $this->offering_view_model->select_fnbrevenue2_byoffering($rowol->offeringnumber);
                if ($dt_bqt != null) {
                    $totalrevenue += $dt_bqt->TotalMeetingPackage;
                }
                $dt_pack = $this->offering_view_model->select_packagerevenue2_byoffering($rowol->offeringnumber);
                if ($dt_pack != null) {
                    $totalrevenue += $dt_pack->TotalPackage;
                }
                $roomrentalrevenuetentatif = $this->offering_room_rental_model->select_revenueroomrental_byoffering($rowol->offeringnumber);
                if ($roomrentalrevenuetentatif != null) {
                    $totalrevenue += $roomrentalrevenuetentatif->TotalRevenue;
                }
                $totalroom = 0;
                $dt_roommeeting = $this->offering_view_model->select_roommeetingmeetingrevenue2_byoffering($rowol->offeringnumber);
                if ($dt_roommeeting != null) {
                    $totalrevenue += $dt_roommeeting->RoomOnly;
                }

                $dt_stall = $this->offeringstall_model->select_revenuestall_peroffering($rowol->offeringnumber);
                if($dt_stall != NULL)
                {
                    $totalrevenue += $dt_stall->TotalRevenue;
                }

                echo '<tr class="additionRow">';
                echo '<td class="kolom25">' . format_waktu4($rowol->checkin_date) . ' - ' . format_waktu4($rowol->checkout_date) . '</td>';
                echo '<td style="text-align:center">' . $rowol->idproperty_FK . '</td>';
                if (strlen($rowol->account_name) > 15) {
                    echo '<td><span   title="' . $rowol->account_name . '">' . anchor('', substr($rowol->account_name, 0, 15), 'class="accountoffering" id="' . $rowol->lastnumber . '"') . '...</span></td>';
                } else {
                    echo '<td><span title="' . $rowol->account_name . '">' . anchor('', $rowol->account_name, 'class="accountoffering" id="' . $rowol->lastnumber . '"') . '</span></td>';
                }
                echo '<td>' . $rowol->firstname . '(' . $rowol->initial . ')</td>';
                echo '<td style="text-align:right">' . number_format($totalrevenue, 0, ',', '.') . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr class="additionRow">';
            echo '<td colspan="5">No Cancel Business For Today</td>';
            echo '</tr>';
        }
        echo '<tr>
                    <td colspan="3">Number Of Cancel Business : <b>' . ($dtcanceltoday->num_rows() + $dtoffcanceltoday->num_rows()) . '</b></td>
                    <td style="text-align:right">Grand Total</td>
                    <td style="text-align:right"><b>' . number_format($totalallrevenue, 0, ',', '.') . '</b></td>
                   </tr>';
        echo '</table>';
    }

    function get_salesactivityvssales() {
        $this->load->plugin('ofc2');
        $title = new title('Title here.' . date("D M d Y"));
        $title->set_style("{font-size: 20px; color: #F24062; text-align: center;}");

        $bar_stack = new bar_stack();

        $s = new star();
        $line_dot = new line();
        $line_dot->set_default_dot_style($s);
        $line_dot->attach_to_right_y_axis();
        $line_dot->colour("#ff3300");
        // set a cycle of 3 colours:
        $bar_stack->set_colours(array('#0000ff', '#00ff33', '#ffcc00', '#43947a', '#ff9933'));
        $dt_refslsactivity = $this->ref_slsact_budget_model->select_salesactivities();
        $dt_sales = $this->sales_model->select_sales();
        $maxvalue = 0;
        $maxsales = 0;

        for ($month = 1; $month <= 12; $month++) {
            $totalslsaccount = 0;
            $totalslstele = 0;
            $totalslsenter = 0;
            $totalslscompliment = 0;
            $totalslsdlmkota = 0;
            $totalslsluarkota = 0;
            foreach ($dt_sales->result() AS $rowsales) {
                $actualaccount = $this->account_model->select_currentmonth_account($month, $rowsales->id);
                $actualtele = $this->telemarketing_model->select_currentmonth_telemarketing($month, $rowsales->id);
                $actualenter = $this->entertainment_model->select_currentmonth_entertainment($month, $rowsales->id);
                $actualsalesdlmkota = $this->sales_call_model->select_currentmonthsalescall_dalamkota($month, $rowsales->id);
                $actualsalesluarkota = $this->sales_call_model->select_currentmonthsalescall_luarkota($month, $rowsales->id);

                if ($actualaccount != NULL) {
                    $totalslsaccount += $actualaccount->Total;
                }
                if ($actualtele != NULL) {
                    $totalslstele += $actualtele->Total;
                }
                if ($actualenter != NULL) {
                    $totalslsenter += $actualenter->Total;
                }
                if ($actualsalesdlmkota != NULL) {
                    $totalslsdlmkota += $actualsalesdlmkota->Total;
                }
                if ($actualsalesluarkota != NULL) {
                    $totalslsluarkota += $actualsalesluarkota->Total;
                }
            }//endforeach sales

            $totalall = $totalslstele + $totalslsenter + $totalslsdlmkota + $totalslsluarkota + $totalslsaccount;
            if ($maxvalue < $totalall) {
                $maxvalue = $totalall;
            }
            $bar_stack->append_stack(array($totalslstele, $totalslsenter, $totalslsdlmkota, $totalslsluarkota, $totalslsaccount));



            ///////////////////////////////////////////////////////

            $dt_confirm = $this->confirm_letter_model->select_confirmdefinit_permonth($month, date('Y'));
            // $dt_definit = $this->confirm_letter_model->select_definit_permonth($month,date('Y'));
            $totalrevenue = 0;
            foreach ($dt_confirm->result() AS $rowconfirm) {
                $roommeetingrevenue = $this->confirm_view_model->select_roommeetingrevenue_perconfirm($rowconfirm->confirmnum);
                $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_perconfirm($rowconfirm->confirmnum);
                $packagerevenue = $this->confirm_view_model->select_packagerevenue_perconfirm($rowconfirm->confirmnum);
                $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_perconfirm($rowconfirm->confirmnum);
                $fnbrevenue = $this->confirm_view_model->select_fbrevenue_perconfirm($rowconfirm->confirmnum);
                $roomrentalrevenue = $this->confirm_view_model->select_roomrentalrevenue_perconfirm($rowconfirm->confirmnum);
                $stallrevenue = $this->confirm_view_model->select_stallrevenue_perconfirm($rowconfirm->confirmnum);

                if ($roommeetingrevenue != null) {
                    $totalrevenue += $roommeetingrevenue->RevRoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalrevenue += $roomonlyrevenue->RevRoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalrevenue += $packagerevenue->RevPackage;
                }
                if ($additionalrevenue != null) {
                    $totalrevenue += $additionalrevenue->RevAdditional;
                }
                if ($fnbrevenue != null) {
                    $totalrevenue += $fnbrevenue->RevFB;
                }
                if ($roomrentalrevenue != null) {
                    $totalrevenue += $roomrentalrevenue->RevRoomRental;
                }
                if ($stallrevenue != null) {
                    $totalrevenue += $stallrevenue->RevStall;
                }
            }

            $salespermonth[] = number_format($totalrevenue, 0, '.', '') + 0;
            if ($maxsales < $totalrevenue) {
                $maxsales = $totalrevenue;
            }
            ///////////////////////////////////////////////////////
        }//end for

        $bar_stack->set_keys(
                array(
                    new bar_stack_key('#0000ff', 'Telemarketing', 15),
                    new bar_stack_key('#00ff33', 'Entertainment', 15),
                    new bar_stack_key('#ffcc00', 'Sales Call Dalam Kota', 15),
                    new bar_stack_key('#43947a', 'Sales Call Luar Kota', 15),
                    new bar_stack_key('#ff9933', 'Account', 15)
                )
        );
        // $bar_stack->set_tooltip( 'X label [#x_label#], Value [#val#]<br>Total [#total#]' );

        $bar_stack->set_tooltip('#val# <br>Total [#total#]');

 
        //$line_dot->set_values(array(0,0,0,15,20));
        $line_dot->set_values($salespermonth);

        $y_r = new y_axis();
        $y_r->set_colours('#000000', '#d0d0d0');

        $ms = ceil($maxsales / 3);
        $y_r->set_range(0, $maxsales + $ms, ceil($ms));

        $y = new y_axis();

        $mv = ceil($maxvalue / 3);
        $y->set_range(0, $maxvalue + $mv,ceil($mv /2));
        $y->set_colours('#000000', '#ffffff');
        $x = new x_axis();
        $x->set_labels_from_array(array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'));
        $x->set_colours('#000000', '#ffffff');

        $tooltip = new tooltip();
        $tooltip->set_hover();

        $chart = new open_flash_chart();
        //$chart->set_title( $title );
        $chart->add_element($bar_stack);
        $chart->set_y_axis_right($y_r);
        $chart->add_element($line_dot);
        $chart->set_x_axis($x);
        $chart->add_y_axis($y);
        $chart->set_tooltip($tooltip);
        $chart->set_bg_colour("#ffffff");
        echo $chart->toPrettyString();
    }

    function get_salesactivityvssales_persales() {
        $this->load->plugin('ofc2');
        $title = new title('Title' . date("D M d Y"));
        $title->set_style("{font-size: 20px; color: #F24062; text-align: center;}");
        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        
        $bar_stack = new bar_stack();

        $s = new star();
        $line_dot = new line();
        $line_dot->set_default_dot_style($s);
        $line_dot->attach_to_right_y_axis();
        $line_dot->colour("#ff3300");
        // set a cycle of 3 colours:
        $bar_stack->set_colours(array('#0000ff', '#00ff33', '#ffcc00', '#43947a', '#ff9933'));
        $dt_refslsactivity = $this->ref_slsact_budget_model->select_salesactivities();

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;
        
        $dt_sales = $this->sales_model->select_salespergroup($idsales);

        $maxvalue = 0;
        $maxsales = 0;

        for ($month = 1; $month <= 12; $month++) {
            $totalslsaccount = 0;
            $totalslstele = 0;
            $totalslsenter = 0;
            $totalslscompliment = 0;
            $totalslsdlmkota = 0;
            $totalslsluarkota = 0;
            foreach ($dt_sales->result() AS $rowsales) {
                $actualaccount = $this->account_model->select_currentmonth_account($month, $rowsales->id);
                $actualtele = $this->telemarketing_model->select_currentmonth_telemarketing($month, $rowsales->id);
                $actualenter = $this->entertainment_model->select_currentmonth_entertainment($month, $rowsales->id);
                $actualsalesdlmkota = $this->sales_call_model->select_currentmonthsalescall_dalamkota($month, $rowsales->id);
                $actualsalesluarkota = $this->sales_call_model->select_currentmonthsalescall_luarkota($month, $rowsales->id);

                if ($actualaccount != NULL) {
                    $totalslsaccount += $actualaccount->Total;
                }

                if ($actualtele != NULL) {
                    $totalslstele += $actualtele->Total;
                }

                if ($actualenter != NULL) {
                    $totalslsenter += $actualenter->Total;
                }

                if ($actualsalesdlmkota != NULL) {
                    $totalslsdlmkota += $actualsalesdlmkota->Total;
                }

                if ($actualsalesluarkota != NULL) {
                    $totalslsluarkota += $actualsalesluarkota->Total;
                }
            }//endforeach sales

            $totalall = $totalslstele + $totalslsenter + $totalslsdlmkota + $totalslsluarkota + $totalslsaccount;
            if ($maxvalue < $totalall) {
                $maxvalue = $totalall;
            }
            $bar_stack->append_stack(array($totalslstele, $totalslsenter, $totalslsdlmkota, $totalslsluarkota, $totalslsaccount));
        }//end for

        $bar_stack->set_keys(
                array(
                    new bar_stack_key('#0000ff', 'Telemarketing', 15),
                    new bar_stack_key('#00ff33', 'Entertainment', 15),
                    new bar_stack_key('#ffcc00', 'Sales Call Dalam Kota', 15),
                    new bar_stack_key('#43947a', 'Sales Call Luar Kota', 15),
                    new bar_stack_key('#ff9933', 'Account', 15)
                )
        );
        $bar_stack->set_tooltip('#val# <br>Total [#total#]');


        for ($month = 1; $month <= 12; $month++) {
            $dt_confirm = $this->confirm_letter_model->select_confirmdefinitpersalesgroup_permonth($month, date('Y'), $salessegment);
            // $dt_definit = $this->confirm_letter_model->select_definit_permonth($month,date('Y'));
            $totalrevenue = 0;
            foreach ($dt_confirm->result() AS $rowconfirm) {
                $roommeetingrevenue = $this->confirm_view_model->select_roommeetingrevenue_perconfirm($rowconfirm->confirmnum);
                $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_perconfirm($rowconfirm->confirmnum);
                $packagerevenue = $this->confirm_view_model->select_packagerevenue_perconfirm($rowconfirm->confirmnum);
                $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_perconfirm($rowconfirm->confirmnum);
                $fnbrevenue = $this->confirm_view_model->select_fbrevenue_perconfirm($rowconfirm->confirmnum);
                $roomrentalrevenue = $this->confirm_view_model->select_roomrentalrevenue_perconfirm($rowconfirm->confirmnum);
                $stallrevenue = $this->confirm_view_model->select_stallrevenue_perconfirm($rowconfirm->confirmnum);
                 if ($roommeetingrevenue != null) {
                    $totalrevenue += $roommeetingrevenue->RevRoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalrevenue += $roomonlyrevenue->RevRoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalrevenue += $packagerevenue->RevPackage;
                }
                if ($additionalrevenue != null) {
                    $totalrevenue += $additionalrevenue->RevAdditional;
                }
                if ($fnbrevenue != null) {
                    $totalrevenue += $fnbrevenue->RevFB;
                }
                if ($roomrentalrevenue != null) {
                    $totalrevenue += $roomrentalrevenue->RevRoomRental;
                }
                if ($stallrevenue != null) {
                    $totalrevenue += $stallrevenue->RevStall;
                }
            }

            $salespermonth[] = number_format($totalrevenue, 0, '.', '') + 0;
            if ($maxsales < $totalrevenue) {
                $maxsales = $totalrevenue;
            }
        }

        //$line_dot->set_values(array(0,0,0,15,20));
        $line_dot->set_values($salespermonth);

        ///
         $y_r = new y_axis();
        $y_r->set_colours('#000000', '#d0d0d0');

        $ms = ceil($maxsales / 3);
        $y_r->set_range(0, $maxsales + $ms, ceil($ms));

        $y = new y_axis();

        $mv = ceil($maxvalue / 3);
        $y->set_range(0, $maxvalue + $mv,ceil($mv /2));
        $y->set_colours('#000000', '#ffffff');
        $x = new x_axis();
        $x->set_labels_from_array(array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'));
        $x->set_colours('#000000', '#ffffff');
        ///
        
        $tooltip = new tooltip();
        $tooltip->set_hover();

        $chart = new open_flash_chart();
        //$chart->set_title( $title );
        $chart->add_element($bar_stack);
        $chart->set_y_axis_right($y_r);
        $chart->add_element($line_dot);
        $chart->set_x_axis($x);
        $chart->add_y_axis($y);
        $chart->set_tooltip($tooltip);
        $chart->set_bg_colour("#ffffff");
        echo $chart->toPrettyString();
    }
    
    function get_salesactivityvssales_persales_onproperty() {
        $this->load->plugin('ofc2');
        $title = new title('Title' . date("D M d Y"));
        $title->set_style("{font-size: 20px; color: #F24062; text-align: center;}");
        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        
        $bar_stack = new bar_stack();

        $s = new star();
        $line_dot = new line();
        $line_dot->set_default_dot_style($s);
        $line_dot->attach_to_right_y_axis();
        $line_dot->colour("#ff3300");
        // set a cycle of 3 colours:
        $bar_stack->set_colours(array('#0000ff', '#00ff33', '#ffcc00', '#43947a', '#ff9933'));
        $dt_refslsactivity = $this->ref_slsact_budget_model->select_salesactivities();

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;
        
        $dt_sales = $this->sales_model->select_sales();

        $maxvalue = 0;
        $maxsales = 0;

        for ($month = 1; $month <= 12; $month++) {
            $totalslsaccount = 0;
            $totalslstele = 0;
            $totalslsenter = 0;
            $totalslscompliment = 0;
            $totalslsdlmkota = 0;
            $totalslsluarkota = 0;
            foreach ($dt_sales->result() AS $rowsales) {
                $actualaccount = $this->account_model->select_currentmonth_account($month, $rowsales->id);
                $actualtele = $this->telemarketing_model->select_currentmonth_telemarketing($month, $rowsales->id);
                $actualenter = $this->entertainment_model->select_currentmonth_entertainment($month, $rowsales->id);
                $actualsalesdlmkota = $this->sales_call_model->select_currentmonthsalescall_dalamkota($month, $rowsales->id);
                $actualsalesluarkota = $this->sales_call_model->select_currentmonthsalescall_luarkota($month, $rowsales->id);

                if ($actualaccount != NULL) {
                    $totalslsaccount += $actualaccount->Total;
                }

                if ($actualtele != NULL) {
                    $totalslstele += $actualtele->Total;
                }

                if ($actualenter != NULL) {
                    $totalslsenter += $actualenter->Total;
                }

                if ($actualsalesdlmkota != NULL) {
                    $totalslsdlmkota += $actualsalesdlmkota->Total;
                }

                if ($actualsalesluarkota != NULL) {
                    $totalslsluarkota += $actualsalesluarkota->Total;
                }
            }//endforeach sales

            $totalall = $totalslstele + $totalslsenter + $totalslsdlmkota + $totalslsluarkota + $totalslsaccount;
            if ($maxvalue < $totalall) {
                $maxvalue = $totalall;
            }
            $bar_stack->append_stack(array($totalslstele, $totalslsenter, $totalslsdlmkota, $totalslsluarkota, $totalslsaccount));
        }//end for

        $bar_stack->set_keys(
                array(
                    new bar_stack_key('#0000ff', 'Telemarketing', 15),
                    new bar_stack_key('#00ff33', 'Entertainment', 15),
                    new bar_stack_key('#ffcc00', 'Sales Call Dalam Kota', 15),
                    new bar_stack_key('#43947a', 'Sales Call Luar Kota', 15),
                    new bar_stack_key('#ff9933', 'Account', 15)
                )
        );
        $bar_stack->set_tooltip('#val# <br>Total [#total#]');


        for ($month = 1; $month <= 12; $month++) {
            $dt_confirm = $this->confirm_letter_model->select_confirmdefinit_onproperty_permonth($month, date('Y'), $userproperty);
            $totalrevenue = 0;
            foreach ($dt_confirm->result() AS $rowconfirm) {
                $roommeetingrevenue = $this->confirm_view_model->select_roommeetingrevenue_perconfirm($rowconfirm->confirmnum);
                $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_perconfirm($rowconfirm->confirmnum);
                $packagerevenue = $this->confirm_view_model->select_packagerevenue_perconfirm($rowconfirm->confirmnum);
                $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_perconfirm($rowconfirm->confirmnum);
                $fnbrevenue = $this->confirm_view_model->select_fbrevenue_perconfirm($rowconfirm->confirmnum);
                $roomrentalrevenue = $this->confirm_view_model->select_roomrentalrevenue_perconfirm($rowconfirm->confirmnum);
                $stallrevenue = $this->confirm_view_model->select_stallrevenue_perconfirm($rowconfirm->confirmnum);
                 if ($roommeetingrevenue != null) {
                    $totalrevenue += $roommeetingrevenue->RevRoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalrevenue += $roomonlyrevenue->RevRoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalrevenue += $packagerevenue->RevPackage;
                }
                if ($additionalrevenue != null) {
                    $totalrevenue += $additionalrevenue->RevAdditional;
                }
                if ($fnbrevenue != null) {
                    $totalrevenue += $fnbrevenue->RevFB;
                }
                if ($roomrentalrevenue != null) {
                    $totalrevenue += $roomrentalrevenue->RevRoomRental;
                }
                if ($stallrevenue != null) {
                    $totalrevenue += $stallrevenue->RevStall;
                }
            }

            $salespermonth[] = number_format($totalrevenue, 0, '.', '') + 0;
            if ($maxsales < $totalrevenue) {
                $maxsales = $totalrevenue;
            }
        }

        //$line_dot->set_values(array(0,0,0,15,20));
        $line_dot->set_values($salespermonth);

        ///
         $y_r = new y_axis();
        $y_r->set_colours('#000000', '#d0d0d0');

        $ms = ceil($maxsales / 3);
        $y_r->set_range(0, $maxsales + $ms, ceil($ms));

        $y = new y_axis();

        $mv = ceil($maxvalue / 3);
        $y->set_range(0, $maxvalue + $mv,ceil($mv /2));
        $y->set_colours('#000000', '#ffffff');
        $x = new x_axis();
        $x->set_labels_from_array(array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'));
        $x->set_colours('#000000', '#ffffff');
        ///
        
        $tooltip = new tooltip();
        $tooltip->set_hover();

        $chart = new open_flash_chart();
        //$chart->set_title( $title );
        $chart->add_element($bar_stack);
        $chart->set_y_axis_right($y_r);
        $chart->add_element($line_dot);
        $chart->set_x_axis($x);
        $chart->add_y_axis($y);
        $chart->set_tooltip($tooltip);
        $chart->set_bg_colour("#ffffff");
        echo $chart->toPrettyString();
    }

    function get_salesactivityvssales_persalesproperty() {
      $this->load->plugin('ofc2');
        $title = new title('Title' . date("D M d Y"));
        $title->set_style("{font-size: 20px; color: #F24062; text-align: center;}");
        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        
        $bar_stack = new bar_stack();

        $s = new star();
        $line_dot = new line();
        $line_dot->set_default_dot_style($s);
        $line_dot->attach_to_right_y_axis();
        $line_dot->colour("#ff3300");
        // set a cycle of 3 colours:
        $bar_stack->set_colours(array('#0000ff', '#00ff33', '#ffcc00', '#43947a', '#ff9933'));
        $dt_refslsactivity = $this->ref_slsact_budget_model->select_salesactivities();

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;
        $salesunit = $dt_sales->idsalesunit_FK;
        
        $dt_sales = $this->sales_model->select_salespergroup_unit($idsales);

        $maxvalue = 0;
        $maxsales = 0;

        for ($month = 1; $month <= 12; $month++) {
            $totalslsaccount = 0;
            $totalslstele = 0;
            $totalslsenter = 0;
            $totalslscompliment = 0;
            $totalslsdlmkota = 0;
            $totalslsluarkota = 0;
            foreach ($dt_sales->result() AS $rowsales) {
                $actualaccount = $this->account_model->select_currentmonth_account($month, $rowsales->id);
                $actualtele = $this->telemarketing_model->select_currentmonth_telemarketing($month, $rowsales->id);
                $actualenter = $this->entertainment_model->select_currentmonth_entertainment($month, $rowsales->id);
                $actualsalesdlmkota = $this->sales_call_model->select_currentmonthsalescall_dalamkota($month, $rowsales->id);
                $actualsalesluarkota = $this->sales_call_model->select_currentmonthsalescall_luarkota($month, $rowsales->id);

                if ($actualaccount != NULL) {
                    $totalslsaccount += $actualaccount->Total;
                }

                if ($actualtele != NULL) {
                    $totalslstele += $actualtele->Total;
                }

                if ($actualenter != NULL) {
                    $totalslsenter += $actualenter->Total;
                }

                if ($actualsalesdlmkota != NULL) {
                    $totalslsdlmkota += $actualsalesdlmkota->Total;
                }

                if ($actualsalesluarkota != NULL) {
                    $totalslsluarkota += $actualsalesluarkota->Total;
                }
            }//endforeach sales

            $totalall = $totalslstele + $totalslsenter + $totalslsdlmkota + $totalslsluarkota + $totalslsaccount;
            if ($maxvalue < $totalall) {
                $maxvalue = $totalall;
            }
            $bar_stack->append_stack(array($totalslstele, $totalslsenter, $totalslsdlmkota, $totalslsluarkota, $totalslsaccount));
        }//end for

        $bar_stack->set_keys(
                array(
                    new bar_stack_key('#0000ff', 'Telemarketing', 15),
                    new bar_stack_key('#00ff33', 'Entertainment', 15),
                    new bar_stack_key('#ffcc00', 'Sales Call Dalam Kota', 15),
                    new bar_stack_key('#43947a', 'Sales Call Luar Kota', 15),
                    new bar_stack_key('#ff9933', 'Account', 15)
                )
        );
        $bar_stack->set_tooltip('#val# <br>Total [#total#]');


        for ($month = 1; $month <= 12; $month++) {
            $dt_confirm = $this->confirm_letter_model->select_confirmdefinitpersalesgroupunitproperty_permonth($month, date('Y'), $salessegment,$salesunit,$userproperty);
            // $dt_definit = $this->confirm_letter_model->select_definit_permonth($month,date('Y'));
            $totalrevenue = 0;
            foreach ($dt_confirm->result() AS $rowconfirm) {
                $roommeetingrevenue = $this->confirm_view_model->select_roommeetingrevenue_perconfirm($rowconfirm->confirmnum);
                $roomonlyrevenue = $this->confirm_view_model->select_roomonlyrevenue_perconfirm($rowconfirm->confirmnum);
                $packagerevenue = $this->confirm_view_model->select_packagerevenue_perconfirm($rowconfirm->confirmnum);
                $additionalrevenue = $this->confirm_view_model->select_additionalrevenue_perconfirm($rowconfirm->confirmnum);
                $fnbrevenue = $this->confirm_view_model->select_fbrevenue_perconfirm($rowconfirm->confirmnum);
                $roomrentalrevenue = $this->confirm_view_model->select_roomrentalrevenue_perconfirm($rowconfirm->confirmnum);
                $stallrevenue = $this->confirm_view_model->select_stallrevenue_perconfirm($rowconfirm->confirmnum);
                 if ($roommeetingrevenue != null) {
                    $totalrevenue += $roommeetingrevenue->RevRoomMeeting;
                }
                if ($roomonlyrevenue != null) {
                    $totalrevenue += $roomonlyrevenue->RevRoomOnly; //oke
                }
                if ($packagerevenue != null) {
                    $totalrevenue += $packagerevenue->RevPackage;
                }
                if ($additionalrevenue != null) {
                    $totalrevenue += $additionalrevenue->RevAdditional;
                }
                if ($fnbrevenue != null) {
                    $totalrevenue += $fnbrevenue->RevFB;
                }
                if ($roomrentalrevenue != null) {
                    $totalrevenue += $roomrentalrevenue->RevRoomRental;
                }
                if ($stallrevenue != null) {
                    $totalrevenue += $stallrevenue->RevStall;
                }
            }

            $salespermonth[] = number_format($totalrevenue, 0, '.', '') + 0;
            if ($maxsales < $totalrevenue) {
                $maxsales = $totalrevenue;
            }
        }
        //$line_dot->set_values(array(0,0,0,15,20));
        $line_dot->set_values($salespermonth);

        ///
         $y_r = new y_axis();
        $y_r->set_colours('#000000', '#d0d0d0');

        $ms = ceil($maxsales / 3);
        $y_r->set_range(0, $maxsales + $ms, ceil($ms));

        $y = new y_axis();

        $mv = ceil($maxvalue / 3);
        $y->set_range(0, $maxvalue + $mv,ceil($mv /2));
        $y->set_colours('#000000', '#ffffff');
        $x = new x_axis();
        $x->set_labels_from_array(array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'));
        $x->set_colours('#000000', '#ffffff');
        ///
        
        $tooltip = new tooltip();
        $tooltip->set_hover();

        $chart = new open_flash_chart();
        //$chart->set_title( $title );
        $chart->add_element($bar_stack);
        $chart->set_y_axis_right($y_r);
        $chart->add_element($line_dot);
        $chart->set_x_axis($x);
        $chart->add_y_axis($y);
        $chart->set_tooltip($tooltip);
        $chart->set_bg_colour("#ffffff");
        echo $chart->toPrettyString();
    }

    function get_customerprofile() {
        $this->load->plugin('ofc2');
        $active = 0;
        $regular = 0;
        $nonactive = 0;
        $dt_customer = $this->account_model->select_customerprofile();
        $totalaccount = $this->account_model->get_numcompany2();
        foreach ($dt_customer->result() AS $rowcust) {
            if ($rowcust->Total < 3) {
                $nonactive++;
            }
            if ($rowcust->Total >= 3 && $rowcust->Total < 10) {
                $regular++;
            }
            if ($rowcust->Total >= 10) {
                $active++;
            }
        }

        $totalaccountused = $nonactive + $regular + $active;

        $diff = $totalaccount - $totalaccountused;


        $title = new title('Customer Profile');
        $title->set_style('color: #040b27; font-size: 12;font-weight:bold');
        $pie = new pie();
        $pie->set_alpha(0.6);
        $pie->set_start_angle(35);
        $pie->add_animation(new pie_fade());
        $pie->set_tooltip('#val# of #total#<br>#percent# of 100%');
        $pie->set_colours(array('#ff0000', '#ffcc66', '#00cc00'));

        $pie->set_values(array($nonactive + $diff, $regular, $active));

        $chart = new open_flash_chart();
        $chart->set_title($title);
        $chart->add_element($pie);
        $chart->set_bg_colour("#ffffff");

        echo $chart->toPrettyString();
    }

    function get_customerprofile_persales() {
        $this->load->plugin('ofc2');
        $active = 0;
        $regular = 0;
        $nonactive = 0;
        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;

        $dt_customer = $this->account_model->select_customerprofilepersalesgroup($salessegment);
        $totalaccount = $this->account_model->get_numcompanypersalesgroup($salessegment);
        foreach ($dt_customer->result() AS $rowcust) {
            if ($rowcust->Total < 3) {
                $nonactive++;
            }
            if ($rowcust->Total >= 3 && $rowcust->Total < 10) {
                $regular++;
            }
            if ($rowcust->Total >= 10) {
                $active++;
            }
        }

        $totalaccountused = $nonactive + $regular + $active;

        $diff = $totalaccount - $totalaccountused;

        $title = new title('Customer Profile');
        $title->set_style('color: #040b27; font-size: 12;font-weight:bold');
        $pie = new pie();
        $pie->set_alpha(0.6);
        $pie->set_start_angle(35);
        $pie->add_animation(new pie_fade());
        $pie->set_tooltip('#val# of #total#<br>#percent# of 100%');
        $pie->set_colours(array('#ff0000', '#ffcc66', '#00cc00'));

        $pie->set_values(array($nonactive + $diff, $regular, $active));

        $chart = new open_flash_chart();
        $chart->set_title($title);
        $chart->add_element($pie);
        $chart->set_bg_colour("#ffffff");

        echo $chart->toPrettyString();
    }

    function get_categorycompanypersales_chart() {
        $this->load->plugin('ofc2');
        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;

        $totalsuspect = 0;
        $totalprospect = 0;
        $totalclient = 0;

//            $dt_suspect = $this->account_model->select_suspect_account();
        $dt_suspect = $this->account_model->select_suspect_account_persalesgroup($salessegment);
        if ($dt_suspect->result() != null) {
            $totalsuspect = $dt_suspect->num_rows();
        }

        $dt_prospect = $this->account_model->select_prospect_accountpersalesgroup($salessegment);
        if ($dt_prospect->result() != null) {
            $totalprospect = $dt_prospect->num_rows();
        }

        $dt_client = $this->account_model->select_client_account_persalesgroup($salessegment);
        if ($dt_client->result() != null) {
            $totalclient = $dt_client->num_rows();
        }

        $title = new title('Company');
        $title->set_style('color: #040b27; font-size: 12;font-weight:bold');
        $pie = new pie();

        $pie->set_alpha(0.6);
        $pie->set_start_angle(30);
        $pie->add_animation(new pie_fade());
        $pie->set_tooltip('#percent# of 100%<br>#val# of #total#');
        $pie->set_colours(array('#f00101', '#057a02', '#3482ec'));

        $pie->set_values(array(new pie_value(number_format($totalsuspect, 0, '.', '') + 0, $totalsuspect),
            new pie_value(number_format($totalprospect, 0, '.', '') + 0, $totalprospect),
            new pie_value(number_format($totalclient, 0, '.', '') + 0, $totalclient)));

        $chart = new open_flash_chart();
        $chart->set_title($title);
        $chart->set_bg_colour('#FFFFFF');
        $chart->add_element($pie);
        echo $chart->toPrettyString();
    }

    function get_categorycontactpersales_chart() {
        $this->load->plugin('ofc2');
        $leveluser = $this->session->userdata('level');
        $idsales = $this->session->userdata('idstaff');
        $userproperty = $this->session->userdata('property');

        $dt_sales = $this->sales_model->select_salesgroup($idsales);
        $salessegment = $dt_sales->id_salesgroupFK;


        $dt_suspect = $this->contact_model->select_contact_suspect_persalesgroup($salessegment);
        $totalsuspect = 0;
        $totalprospect = 0;
        $totalclient = 0;
        if ($dt_suspect->result() != null) {
            $totalsuspect = $dt_suspect->num_rows();
        }

        $dt_prospect = $this->contact_model->select_contact_prospect_persalesgroup($salessegment);
        if ($dt_prospect->result() != null) {
            $totalprospect = $dt_prospect->num_rows();
        }

        $dt_client = $this->contact_model->select_contact_client_persalesgroup($salessegment);
        if ($dt_client->result() != null) {
            $totalclient = $dt_client->num_rows();
        }

        $title = new title('Contact');
        $title->set_style('color: #040b27; font-size: 12;font-weight:bold');
        $pie = new pie();

        $pie->set_alpha(0.6);
        $pie->set_start_angle(30);
        $pie->add_animation(new pie_fade());
        $pie->set_tooltip('#percent# of 100%<br>#val# of #total#');
        $pie->set_colours(array('#f00101', '#057a02', '#3482ec'));

        $pie->set_values(array(new pie_value(number_format($totalsuspect, 0, '.', '') + 0, $totalsuspect),
            new pie_value(number_format($totalprospect, 0, '.', '') + 0, $totalprospect),
            new pie_value(number_format($totalclient, 0, '.', '') + 0, $totalclient)));

        $chart = new open_flash_chart();
        $chart->set_title($title);
        $chart->set_bg_colour('#FFFFFF');
        $chart->add_element($pie);


        $chart->x_axis = null;

        echo $chart->toPrettyString();
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */