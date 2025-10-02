<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of room_forecast
 *
 * @author user
 */
class room_forecast extends Controller{
    //put your code here
    function __construct() {
        parent::Controller();
        $this->load->model('room_forecast_model');
        $this->load->model('room_forecastremark_model');
        $this->load->helper('date');
    //    $this->load->library('encrypt');
        
    }
    
    function index(){
       // echo $this->encrypt->decode('HtEyA4Lvos3gwL61BDMLM/pqACQcGThUuD0EH1vAroKrVFMJPjcjDzxXvjL9BmXYF1ot9m9xZV2Rkb4FFKGpsw==');
        $dt_month = $this->room_forecast_model->select_roomforecast_monthperiod();
        $dt_year = $this->room_forecast_model->select_roomforecast_yearperiod();
        $data = array('accounton'=>'',
                        'welcomeon'=>'',
                        'documenton'=>'class="on"',
                        'activitieson'=>'',
                        'reporton'=>'',
                        'ebookingon' => '',
                        'setupon'=>'',
                        'calendaron'=>'' ,
                        'dt_monthforecast'=>$dt_month->result(),
                        'dt_yearforecast'=>$dt_year->result()
                        
                        );
        $this->load->view('document/room_forecast/index',$data);
    }
    
    function add_roomforecast_period(){
        $month = $this->input->post('month') ;
        $year = $this->input->post('year');
        
        $totaldays = date('t',  strtotime(date("01-$month-$year")));
        $dt_forecast = $this->room_forecast_model->select_roomforecast_by_monthyear($month,$year);
        if($dt_forecast->result() == NULL){
              for ($i = 1; $i <= $totaldays; $i++) {
                $data = array('date_period' => "$year-$month-$i" );
                $this->room_forecast_model->insert_data($data);
            }
            echo 'New period created.';
        }else{
            echo 'This period already exist';
        }
     
    }
    
    function edit_reservation_on_hand(){
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $ip_address = $this->input->ip_address();
        $userproperty = $this->session->userdata('property');
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("reservation_on_hand" => $value,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        $this->room_forecast_model->update_roomforecast($id, $data_forecast);
        echo $value;
    }
    
     function edit_same_day_reservation(){
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $ip_address = $this->input->ip_address();
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("same_day_reservation" => $value,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        $this->room_forecast_model->update_roomforecast($id, $data_forecast);
        echo $value;
    }
    
    function edit_occupancy_on_hand(){
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $ip_address = $this->input->ip_address();
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("occupancy_on_hand" => $value,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        $this->room_forecast_model->update_roomforecast($id, $data_forecast);
        echo $value;
    }
    
    function edit_exp_arr(){
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $ip_address = $this->input->ip_address();
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("exp_arr_w_i" => $value,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        $this->room_forecast_model->update_roomforecast($id, $data_forecast);
        echo $value;
    }
    
    function edit_total_available(){
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $ip_address = $this->input->ip_address();
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("total_available" => $value,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        $this->room_forecast_model->update_roomforecast($id, $data_forecast);
        echo number_format($value);

    }
    
     function edit_checkin_by_reservation(){
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $ip_address = $this->input->ip_address();
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("checkin_by_rsv" => $value,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        $this->room_forecast_model->update_roomforecast($id, $data_forecast);
        echo $value;
    }
    
     function edit_walk_in(){
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $ip_address = $this->input->ip_address();
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("walk_in" => $value,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        $this->room_forecast_model->update_roomforecast($id, $data_forecast);
        echo $value;
    }
    
    
     function edit_extend(){
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $ip_address = $this->input->ip_address();
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("extend" => $value,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        $this->room_forecast_model->update_roomforecast($id, $data_forecast);
        echo $value;
    }
    
    function edit_day_use(){
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $ip_address = $this->input->ip_address();
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("day_use" => $value,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        $this->room_forecast_model->update_roomforecast($id, $data_forecast);
        echo $value;
    }
    
    function edit_compliment(){
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $ip_address = $this->input->ip_address();
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("compliment" => $value,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        $this->room_forecast_model->update_roomforecast($id, $data_forecast);
        echo $value;
    }
    
    function edit_house_use(){
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $ip_address = $this->input->ip_address();
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("house_use" => $value,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        $this->room_forecast_model->update_roomforecast($id, $data_forecast);
        echo $value;
    }
    
    
    function edit_cancel(){
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $ip_address = $this->input->ip_address();
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("cancel" => $value,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        $this->room_forecast_model->update_roomforecast($id, $data_forecast);
        echo $value;
    }
    
    function edit_no_show(){
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $ip_address = $this->input->ip_address();
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("no_show" => $value,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        $this->room_forecast_model->update_roomforecast($id, $data_forecast);
        echo $value;
    }
    
    function edit_total_pax(){
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $ip_address = $this->input->ip_address();
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("total_pax" => $value,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        $this->room_forecast_model->update_roomforecast($id, $data_forecast);
        echo $value;
    }
      
    function edit_total_room(){
        $id = $this->input->post('id');
        $value = $this->input->post('value');
        $ip_address = $this->input->ip_address();
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("total_room" => $value,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        $this->room_forecast_model->update_roomforecast($id, $data_forecast);
        echo $value;
    }
    
    function edit_roomforecast_remark(){
        $id = $this->input->post('id');
        $remark = $this->input->post('remark');
        $ip_address = $this->input->ip_address();
        $userproperty = $this->session->userdata('property');
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("remark " => $remark,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);
        
        $this->room_forecastremark_model->update_roomforecastremark($id, $data_forecast);
        //echo $remark;
        echo "updated.";
    }

    function new_roomforecast_remark(){
        $month_period = $this->input->post('monthroomforecast');
        $year_period = $this->input->post('yearroomforecast');
        $remark = $this->input->post('remark');
        $ip_address = $this->input->ip_address();
        $userproperty = $this->session->userdata('property');
        $timestamp = unix_to_human(time(), TRUE, 'eu');
        $username = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
        $data_forecast = array("remark " => $remark,
                               "month_period" => $month_period,
                               "year_period" => $year_period,
                               "date_modified" => $timestamp,
                               "modified_by" => $username . ' ' . $ip_address);

        $this->room_forecastremark_model->insert_data($data_forecast);
        //echo $remark;
        echo "updated.";
    }

//    function load_roomforecast_currentmonth(){
//        $dt_forecast = $this->room_forecast_model->select_roomforecast_by_monthyear(date('m'),date('Y'));
//        $data = array('dt_forecast'=>$dt_forecast,'month'=>date('m'),'year'=>date('Y'));
//        $this->load->view('document/room_forecast/template_room_forecast',$data);
//    }

    function load_roomforecast_currentmonth(){
        //$dt_forecast = $this->room_forecast_model->select_roomforecast_by_monthyear(date('m'),date('Y'));
        //iwn:split page room forecast

        $page = $this->input->post('page');
        $page = empty($page)? 1:$page;
        if($page == 2){
            $lim1 = 15; $lim2 = 16;
        } else {
            $lim1 = 0; $lim2 = 15;
        }

//
        $dt_forecast_full = $this->room_forecast_model->select_roomforecast_by_monthyear(date('m'),date('Y'));
//
        $tot_total_available = 0;
        $tot_reservation_on_hand = 0;
        $tot_same_day_reservation = 0;
        $tot_occupancy_on_hand = 0;
        $tot_exp_arr_w_i = 0;
        $tot_checkin_by_rsv = 0;
        $tot_walk_in = 0;
        $tot_extend = 0;
        $tot_day_use = 0;
        $tot_compliment = 0;
        $tot_house_use = 0;
        $tot_cancel = 0;
        $tot_no_show = 0;
        $tot_total_pax = 0;
        $tot_TotalForecast = 0;
        $tot_TotalRoom = 0;
        $tot_total_room = 0;

        foreach ($dt_forecast_full->result() as $value){
            $tot_total_available += $value->total_available;
            $tot_reservation_on_hand += $value->reservation_on_hand;
            $tot_same_day_reservation += $value->same_day_reservation;
            $tot_occupancy_on_hand += $value->occupancy_on_hand;
            $tot_exp_arr_w_i += $value->exp_arr_w_i;
            $tot_checkin_by_rsv += $value->checkin_by_rsv;
            $tot_walk_in += $value->walk_in;
            $tot_extend += $value->extend;
            $tot_day_use += $value->day_use;
            $tot_compliment += $value->compliment;
            $tot_house_use += $value->house_use;
            $tot_cancel += $value->cancel;
            $tot_no_show += $value->no_show;
            $tot_total_pax += $value->total_pax;
            $tot_total_room += $value->total_room;
                $dt_tf = $this->room_forecast_model->select_totalforecast_by_roomforecastid($value->roomforecastid);
                $tot_TotalForecast += $dt_tf->TotalForecast;
    //            $dt_trx = $this->room_forecast_model->select_totalroom_by_roomforecastid($value->roomforecastid);
    //            $tot_TotalRoom += $dt_trx->TotalRoom;
        }

        $dt_total_forecast['tot_total_available']= $tot_total_available;
        $dt_total_forecast['tot_reservation_on_hand']= $tot_reservation_on_hand;
        $dt_total_forecast['tot_same_day_reservation']= $tot_same_day_reservation;
        $dt_total_forecast['tot_occupancy_on_hand']= $tot_occupancy_on_hand;
        $dt_total_forecast['tot_exp_arr_w_i']= $tot_exp_arr_w_i;
        $dt_total_forecast['tot_checkin_by_rsv']= $tot_checkin_by_rsv;
        $dt_total_forecast['tot_walk_in']= $tot_walk_in;
        $dt_total_forecast['tot_extend']= $tot_extend;
        $dt_total_forecast['tot_day_use']= $tot_day_use;
        $dt_total_forecast['tot_compliment']= $tot_compliment;
        $dt_total_forecast['tot_house_use']= $tot_house_use;
        $dt_total_forecast['tot_cancel']= $tot_cancel;
        $dt_total_forecast['tot_no_show']= $tot_no_show;
        $dt_total_forecast['tot_total_pax']= $tot_total_pax;
        $dt_total_forecast['tot_TotalForecast']=$tot_TotalForecast;
        $dt_total_forecast['tot_TotalRoom']=$tot_total_room;
//
        $dt_forecast = $this->room_forecast_model->select_roomforecast_by_monthyear_limit(date('m'),date('Y'),$lim1,$lim2);
        //
        $data = array('dt_forecast'=>$dt_forecast,'month'=>date('m'),'year'=>date('Y'),'dt_total_forecast'=>$dt_total_forecast);
        $this->load->view('document/room_forecast/template_room_forecast',$data);

    }

    function load_roomforecastremark_filter(){

        $month = $this->input->post('monthroomforecast');
        $year = $this->input->post('yearroomforecast');
        
        $dt_forecastremark = $this->room_forecastremark_model->select_roomforecastremark_by_monthyear($month,$year)->row();
        //print_r($dt_forecastremark);
        $data = array('dt_forecastremark'=>$dt_forecastremark,'month'=>date('n'),'year'=>date('Y'));
        $this->load->view('document/room_forecast/template_room_forecastremark',$data);

    }

    function load_roomforecastremark_filter2(){

        $month = $this->input->post('monthroomforecast');
        $year = $this->input->post('yearroomforecast');

        $dt_forecastremark = $this->room_forecastremark_model->select_roomforecastremark_by_monthyear($month,$year)->row();
        //print_r($dt_forecastremark);
        $data = array('dt_forecastremark'=>$dt_forecastremark,'month'=>date('n'),'year'=>date('Y'));
        $this->load->view('document/room_forecast/report_room_forecastremark',$data);

    }

    function load_roomforecast_currentmonth2(){ // version : view only
        // get total
        $dt_forecast_full = $this->room_forecast_model->select_roomforecast_by_monthyear(date('m'),date('Y'));

        $tot_total_available = 0;
        $tot_reservation_on_hand = 0;
        $tot_same_day_reservation = 0;
        $tot_occupancy_on_hand = 0;
        $tot_exp_arr_w_i = 0;
        $tot_checkin_by_rsv = 0;
        $tot_walk_in = 0;
        $tot_extend = 0;
        $tot_day_use = 0;
        $tot_compliment = 0;
        $tot_house_use = 0;
        $tot_cancel = 0;
        $tot_no_show = 0;
        $tot_total_pax = 0;
        $tot_TotalForecast = 0;
        $tot_TotalRoom = 0;

        foreach ($dt_forecast_full->result() as $value){
            $tot_total_available += $value->total_available;
            $tot_reservation_on_hand += $value->reservation_on_hand;
            $tot_same_day_reservation += $value->same_day_reservation;
            $tot_occupancy_on_hand += $value->occupancy_on_hand;
            $tot_exp_arr_w_i += $value->exp_arr_w_i;
            $tot_checkin_by_rsv += $value->checkin_by_rsv;
            $tot_walk_in += $value->walk_in;
            $tot_extend += $value->extend;
            $tot_day_use += $value->day_use;
            $tot_compliment += $value->compliment;
            $tot_house_use += $value->house_use;
            $tot_cancel += $value->cancel;
            $tot_no_show += $value->no_show;
            $tot_total_pax += $value->total_pax;
                $dt_tf = $this->room_forecast_model->select_totalforecast_by_roomforecastid($value->roomforecastid);
                $tot_TotalForecast += $dt_tf->TotalForecast;
                $dt_trx = $this->room_forecast_model->select_totalroom_by_roomforecastid($value->roomforecastid);
                $tot_TotalRoom += $dt_trx->TotalRoom;
        }

        $dt_total_forecast['tot_total_available']= $tot_total_available;
        $dt_total_forecast['tot_reservation_on_hand']= $tot_reservation_on_hand;
        $dt_total_forecast['tot_same_day_reservation']= $tot_same_day_reservation;
        $dt_total_forecast['tot_occupancy_on_hand']= $tot_occupancy_on_hand;
        $dt_total_forecast['tot_exp_arr_w_i']= $tot_exp_arr_w_i;
        $dt_total_forecast['tot_checkin_by_rsv']= $tot_checkin_by_rsv;
        $dt_total_forecast['tot_walk_in']= $tot_walk_in;
        $dt_total_forecast['tot_extend']= $tot_extend;
        $dt_total_forecast['tot_day_use']= $tot_day_use;
        $dt_total_forecast['tot_compliment']= $tot_compliment;
        $dt_total_forecast['tot_house_use']= $tot_house_use;
        $dt_total_forecast['tot_cancel']= $tot_cancel;
        $dt_total_forecast['tot_no_show']= $tot_no_show;
        $dt_total_forecast['tot_total_pax']= $tot_total_pax;
        $dt_total_forecast['tot_TotalForecast']=$tot_TotalForecast;
        $dt_total_forecast['tot_TotalRoom']=$tot_TotalRoom;

        // end get total

        //iwn:split page room forecast
        $page = $this->input->post('page');
        $page = empty($page)? 1:$page;
        if($page == 2){
            $lim1 = 15; $lim2 = 16;
        } else {
            $lim1 = 0; $lim2 = 15;
        }
        $dt_forecast = $this->room_forecast_model->select_roomforecast_by_monthyear_limit(date('m'),date('Y'),$lim1,$lim2);
        //
        $data = array('dt_forecast'=>$dt_forecast,'month'=>date('m'),'year'=>date('Y'),'dt_total_forecast'=>$dt_total_forecast);
        $this->load->view('document/room_forecast/template_room_forecast2',$data);
    }
    
//    function load_roomforecast_by_monthyear(){
//        $month = $this->input->post('monthroomforecast');
//        $year = $this->input->post('yearroomforecast');
//
//        $dt_forecast = $this->room_forecast_model->select_roomforecast_by_monthyear($month,$year);
//        $data = array('dt_forecast'=>$dt_forecast,'month'=>$month,'year'=>$year);
//        $this->load->view('document/room_forecast/template_room_forecast',$data);
//    }
    function load_roomforecast_by_monthyear(){
        $month = $this->input->post('monthroomforecast');
        $year = $this->input->post('yearroomforecast');
        $page = $this->input->post('page');
        //$dt_forecast = $this->room_forecast_model->select_roomforecast_by_monthyear($month,$year);
        //iwn:split page room forecast
        $page = empty($page)? 1:$page;
        if($page == 2){
            $lim1 = 15; $lim2 = 16;
        } else {
            $lim1 = 0; $lim2 = 15;
        }

//        $dt_forecast = $this->room_forecast_model->select_roomforecast_by_monthyear_limit($month,$year,$lim1,$lim2);
        $dt_forecast_full = $this->room_forecast_model->select_roomforecast_by_monthyear($month,$year);
//
        $tot_total_available = 0;
        $tot_reservation_on_hand = 0;
        $tot_same_day_reservation = 0;
        $tot_occupancy_on_hand = 0;
        $tot_exp_arr_w_i = 0;
        $tot_checkin_by_rsv = 0;
        $tot_walk_in = 0;
        $tot_extend = 0;
        $tot_day_use = 0;
        $tot_compliment = 0;
        $tot_house_use = 0;
        $tot_cancel = 0;
        $tot_no_show = 0;
        $tot_total_pax = 0;
        $tot_TotalForecast = 0;
        $tot_TotalRoom = 0;
        $tot_total_room = 0;

        foreach ($dt_forecast_full->result() as $value){
            $tot_total_available += $value->total_available;
            $tot_reservation_on_hand += $value->reservation_on_hand;
            $tot_same_day_reservation += $value->same_day_reservation;
            $tot_occupancy_on_hand += $value->occupancy_on_hand;
            $tot_exp_arr_w_i += $value->exp_arr_w_i;
            $tot_checkin_by_rsv += $value->checkin_by_rsv;
            $tot_walk_in += $value->walk_in;
            $tot_extend += $value->extend;
            $tot_day_use += $value->day_use;
            $tot_compliment += $value->compliment;
            $tot_house_use += $value->house_use;
            $tot_cancel += $value->cancel;
            $tot_no_show += $value->no_show;
            $tot_total_pax += $value->total_pax;
            $tot_total_room += $value->total_room;
                $dt_tf = $this->room_forecast_model->select_totalforecast_by_roomforecastid($value->roomforecastid);
                $tot_TotalForecast += $dt_tf->TotalForecast;
    //            $dt_trx = $this->room_forecast_model->select_totalroom_by_roomforecastid($value->roomforecastid);
    //            $tot_TotalRoom += $dt_trx->TotalRoom;
        }

        $dt_total_forecast['tot_total_available']= $tot_total_available;
        $dt_total_forecast['tot_reservation_on_hand']= $tot_reservation_on_hand;
        $dt_total_forecast['tot_same_day_reservation']= $tot_same_day_reservation;
        $dt_total_forecast['tot_occupancy_on_hand']= $tot_occupancy_on_hand;
        $dt_total_forecast['tot_exp_arr_w_i']= $tot_exp_arr_w_i;
        $dt_total_forecast['tot_checkin_by_rsv']= $tot_checkin_by_rsv;
        $dt_total_forecast['tot_walk_in']= $tot_walk_in;
        $dt_total_forecast['tot_extend']= $tot_extend;
        $dt_total_forecast['tot_day_use']= $tot_day_use;
        $dt_total_forecast['tot_compliment']= $tot_compliment;
        $dt_total_forecast['tot_house_use']= $tot_house_use;
        $dt_total_forecast['tot_cancel']= $tot_cancel;
        $dt_total_forecast['tot_no_show']= $tot_no_show;
        $dt_total_forecast['tot_total_pax']= $tot_total_pax;
        $dt_total_forecast['tot_TotalForecast']=$tot_TotalForecast;
        $dt_total_forecast['tot_TotalRoom']=$tot_total_room;


        // end get total
        $dt_forecast = $this->room_forecast_model->select_roomforecast_by_monthyear_limit($month,$year,$lim1,$lim2);

        $data = array('dt_forecast'=>$dt_forecast,'month'=>$month,'year'=>$year, 'dt_total_forecast'=>$dt_total_forecast);
        $this->load->view('document/room_forecast/template_room_forecast',$data);
    }


    function load_roomforecast_by_monthyear2(){ // version : view only
        $month = $this->input->post('monthroomforecast');
        $year = $this->input->post('yearroomforecast');
        $page = $this->input->post('page');
        //$dt_forecast = $this->room_forecast_model->select_roomforecast_by_monthyear($month,$year);

        // get total
        $dt_forecast_full = $this->room_forecast_model->select_roomforecast_by_monthyear($month,$year);

        $tot_total_available = 0;
        $tot_reservation_on_hand = 0;
        $tot_same_day_reservation = 0;
        $tot_occupancy_on_hand = 0;
        $tot_exp_arr_w_i = 0;
        $tot_checkin_by_rsv = 0;
        $tot_walk_in = 0;
        $tot_extend = 0;
        $tot_day_use = 0;
        $tot_compliment = 0;
        $tot_house_use = 0;
        $tot_cancel = 0;
        $tot_no_show = 0;
        $tot_total_pax = 0;
        $tot_TotalForecast = 0;
        $tot_TotalRoom = 0;

        foreach ($dt_forecast_full->result() as $value){
            $tot_total_available += $value->total_available;
            $tot_reservation_on_hand += $value->reservation_on_hand;
            $tot_same_day_reservation += $value->same_day_reservation;
            $tot_occupancy_on_hand += $value->occupancy_on_hand;
            $tot_exp_arr_w_i += $value->exp_arr_w_i;
            $tot_checkin_by_rsv += $value->checkin_by_rsv;
            $tot_walk_in += $value->walk_in;
            $tot_extend += $value->extend;
            $tot_day_use += $value->day_use;
            $tot_compliment += $value->compliment;
            $tot_house_use += $value->house_use;
            $tot_cancel += $value->cancel;
            $tot_no_show += $value->no_show;
            $tot_total_pax += $value->total_pax;
                $dt_tf = $this->room_forecast_model->select_totalforecast_by_roomforecastid($value->roomforecastid);
                $tot_TotalForecast += $dt_tf->TotalForecast;
                $dt_trx = $this->room_forecast_model->select_totalroom_by_roomforecastid($value->roomforecastid);
                $tot_TotalRoom += $dt_trx->TotalRoom;
        }

        $dt_total_forecast['tot_total_available']= $tot_total_available;
        $dt_total_forecast['tot_reservation_on_hand']= $tot_reservation_on_hand;
        $dt_total_forecast['tot_same_day_reservation']= $tot_same_day_reservation;
        $dt_total_forecast['tot_occupancy_on_hand']= $tot_occupancy_on_hand;
        $dt_total_forecast['tot_exp_arr_w_i']= $tot_exp_arr_w_i;
        $dt_total_forecast['tot_checkin_by_rsv']= $tot_checkin_by_rsv;
        $dt_total_forecast['tot_walk_in']= $tot_walk_in;
        $dt_total_forecast['tot_extend']= $tot_extend;
        $dt_total_forecast['tot_day_use']= $tot_day_use;
        $dt_total_forecast['tot_compliment']= $tot_compliment;
        $dt_total_forecast['tot_house_use']= $tot_house_use;
        $dt_total_forecast['tot_cancel']= $tot_cancel;
        $dt_total_forecast['tot_no_show']= $tot_no_show;
        $dt_total_forecast['tot_total_pax']= $tot_total_pax;
        $dt_total_forecast['tot_TotalForecast']=$tot_TotalForecast;
        $dt_total_forecast['tot_TotalRoom']=$tot_TotalRoom;


        // end get total


        //iwn:split page room forecast
        $page = empty($page)? 1:$page;
        if($page == 2){
            $lim1 = 15; $lim2 = 16;
        } else {
            $lim1 = 0; $lim2 = 15;
        }

        $dt_forecast = $this->room_forecast_model->select_roomforecast_by_monthyear_limit($month,$year,$lim1,$lim2);
        //

        $data = array('dt_forecast'=>$dt_forecast,'month'=>$month,'year'=>$year, 'dt_total_forecast'=>$dt_total_forecast);
        $this->load->view('document/room_forecast/template_room_forecast2',$data);
    }

    function load_period_forecast(){
//        $dt_period = $this->room_forecast_model->
    }
    
//    function report_room_forecast() {
//        $dt_forecast = $this->room_forecast_model->select_roomforecast_by_monthyear(date('m'), date('Y'));
//        $dt_yearperiod = $this->room_forecast_model->select_roomforecast_yearperiod();
//         $data = array('accounton'=>'',
//                        'welcomeon'=>'',
//                        'documenton'=>'',
//                        'activitieson'=>'',
//                        'reporton'=>'class="on"',
//                        'ebookingon' => '',
//                        'setupon'=>'',
//                        'calendaron'=>'' ,
//             'dt_forecast' => $dt_forecast,
//                        'year_period'=>$dt_yearperiod->result()
//
//                        );
//
//        $this->load->view('document/room_forecast/report_room_forecast', $data);
//    }
    function report_room_forecast(){
       // echo $this->encrypt->decode('HtEyA4Lvos3gwL61BDMLM/pqACQcGThUuD0EH1vAroKrVFMJPjcjDzxXvjL9BmXYF1ot9m9xZV2Rkb4FFKGpsw==');
        $dt_month = $this->room_forecast_model->select_roomforecast_monthperiod();
        $dt_year = $this->room_forecast_model->select_roomforecast_yearperiod();
        $data = array('accounton'=>'',
                        'welcomeon'=>'',
                        'documenton'=>'class="on"',
                        'activitieson'=>'',
                        'reporton'=>'',
                        'ebookingon' => '',
                        'setupon'=>'',
                        'calendaron'=>'' ,
                        'dt_monthforecast'=>$dt_month->result(),
                        'dt_yearforecast'=>$dt_year->result()

                        );
        $this->load->view('document/room_forecast/report_room_forecast2',$data);
    }
    
    function filter_roomforecast(){
        $month = $this->input->post('month');
        $year = $this->input->post('year');
         
        $dt_forecast = $this->room_forecast_model->select_roomforecast_by_monthyear($month, $year);
        if($dt_forecast->result() != NULL){
            $data = array('dt_forecast'=>$dt_forecast,'month'=>date('F',  strtotime("01-$month-$year")),'year'=>$year);
             $this->load->view('document/room_forecast/template_report_room_forecast',$data);
        }else{
            echo 'Room forecast not available.';
        }
    }
    
    
    function test_iframe(){
        $dt_forecast = $this->room_forecast_model->select_roomforecast_by_monthyear(date('m'), date('Y'));
        $dt_yearperiod = $this->room_forecast_model->select_roomforecast_yearperiod();
        $data = array('dt_forecast'=>$dt_forecast);
        $this->load->view('document/room_forecast/table_report',$data);
    }
}

?>
