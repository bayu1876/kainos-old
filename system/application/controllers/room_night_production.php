<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of room_night_production
 *
 * @author user
 */
class room_night_production extends Controller {

    //put your code here
    function __construct() {
        parent::Controller();
        $this->load->model('sales_model');
        $this->load->model('confirm_room_model');
        $this->load->model('confirm_room_breakdown_model');
        $this->load->model('confirmaccounts_model');
        $this->load->model('confirm_mpackage_model');
        $this->load->model('room_night_production_model');
        $this->load->model('confirm_view_model');
        $this->load->helper('date');
    }

    function index() {
        $dt_sales = $this->sales_model->select_sales();
        $opt_sales[''] = '- Select Sales -';
        foreach ($dt_sales->result() AS $row) {
            $opt_sales[$row->id] = $row->firstname . ' ' . $row->lastname;
        }
        
         $dt_monthprod = $this->room_night_production_model->select_monthproduction();
         $dt_yearprod = $this->room_night_production_model->select_yearproduction();
        $data = array('accounton' => 'class="on"',
                      'welcomeon' => '',
                      'documenton' => '',
                      'activitieson' => '',
                      'reporton' => '',
                      'ebookingon' => '',
                      'setupon' => '',
                      'calendaron' => '',
                      'opt_sales' => $opt_sales,
                      'dt_sales'=>$dt_sales,
              'dt_monthprod'=>$dt_monthprod,
                       'dt_yearprod'=>$dt_yearprod
                    );
        $this->load->view('report/rnp/index', $data);
    }

    function get_room_production() {
        $date = $this->input->post('dateproduction');
        $sales = $this->input->post('sales');

        $confirmnumber_rnp = array();
        $dt_confirmroom = $this->confirm_room_model->select_confirmroom_by_checkindate_sales(tanggal_php_to_mysql($date), $sales);
        
        $dt_confirmroombreakdown = $this->confirm_room_breakdown_model->select_confirmroombreakdown_by_checkindate_sales(tanggal_php_to_mysql($date), $sales);
        
        foreach($dt_confirmroom->result() AS $row){
            $confirmnumber_rnp[] = $row->confirmnumber_FK;
        }
        
        foreach($dt_confirmroombreakdown->result() AS $row){
            if(!in_array($row->confirmnumber_FK, $confirmnumber_rnp)){
                $confirmnumber_rnp[] = $row->confirmnumber_FK;
            }
        }
        
        $data = array('confirmnumber_rnp'=> $confirmnumber_rnp,
                      'dt_confirmroom' => $dt_confirmroom->result(),
                      'sales'=>$sales,
                      'dateproduction'=>tanggal_php_to_mysql($date));
        $this->load->view('report/rnp/data_rnp', $data);
    }
    
    function submit_roomnightproduction(){
        $sales = $this->input->post('salesrnp');
        $dateprod = $this->input->post('daternp');
        $confirmnumber = $this->input->post('confirmnumber');
        $datarnp = array('date_created'=>unix_to_human(time(), TRUE, 'eu'),
                         'date_production'=>$dateprod,
                         'idsales_FK'=>$sales);
        
        $dt_rnp = $this->room_night_production_model->select_roomnightproduction_by_dateprod_sales($dateprod,$sales);
        
        if ($dt_rnp->result() == NULL) {
            if (is_array($confirmnumber)) {
                $idrnp = $this->room_night_production_model->insert_data($datarnp);
                foreach ($confirmnumber AS $k => $cl) {
                    $datarnpdetail = array('idroomnightproduction_FK' => $idrnp, 'confirmnumber_FK' => $cl);
                    $this->room_night_production_model->insert_rnpdetail($datarnpdetail);
                }
                echo 'Room Night Production Created.';
            }else{
                echo 'Failed to create room night production.';
            }
        } else {
            echo 'Room Night Production for selected sales and date already created';
        }
    }
    
    function load_roomnightproduction(){
         $dt_rnp = $this->room_night_production_model->select_roomnightproduction();
         $dt_sales = $this->sales_model->select_sales();
         $dt_monthprod = $this->room_night_production_model->select_monthproduction();
         $dt_yearprod = $this->room_night_production_model->select_yearproduction();
         $data = array('dt_rnpsales'=>$dt_rnp->result(),
                       'month'=>date('m'),
                       'year'=>date('Y'),
                       'dt_sales'=>$dt_sales,
                       'dt_monthprod'=>$dt_monthprod,
                       'dt_yearprod'=>$dt_yearprod
                       );
         
         $this->load->view('report/rnp/data_rnp_sales',$data);
    }
    
    function print_pdf_rnp(){
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $this->load->plugin('to_pdflandscapelegal');

        $dt_rnp = $this->room_night_production_model->select_roomnightproduction();
        $dt_sales = $this->sales_model->select_sales();

        $data = array('dt_rnpsales' => $dt_rnp->result(),
            'month' => $month,
            'year' => $year,
            'dt_sales' => $dt_sales,
        );
        $nama_file = 'RNP-' . $month . '-' . $year;
        $this->load->view('report/rnp/pdf_rnp_report', $data);
        $html = $this->output->get_output();
        pdf_create($html, $nama_file);
    }
    
    function get_roomnightproduction() {
        $month = $this->input->post('month');
        $year = $this->input->post('year');

        $dt_rnp = $this->room_night_production_model->select_roomnightproduction();
        $dt_sales = $this->sales_model->select_sales();
        $dt_monthprod = $this->room_night_production_model->select_monthproduction();
        $dt_yearprod = $this->room_night_production_model->select_yearproduction();
        $data = array('dt_rnpsales' => $dt_rnp->result(),
            'month' => $month,
            'year' => $year,
            'dt_sales' => $dt_sales,
            'dt_monthprod' => $dt_monthprod,
            'dt_yearprod' => $dt_yearprod
        );
        
        $this->load->view('report/rnp/data_rnp_sales',$data);
    }

}

?>
