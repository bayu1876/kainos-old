<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of hotel_competitor_analysis
 *
 * @author ftw
 */
class hotel_competitor_analysis extends Controller {

    //put your code here
    function __construct() {
        parent::Controller();
        $this->load->model('ref_hotel_competitor_model');
        $this->load->model('hotel_competitor_analysis_model');
        $this->load->model('account_model');
        $this->load->helper('date');
        $this->load->model('ref_industri_model');
        $this->load->model('account_segment_model');
        $this->load->model('sales_model');
        $this->load->model('ref_countries_model');
        $this->load->model('ref_provience_model');
        $this->load->model('hotel_comp_initial_model');
        $this->load->model('hca_property_budget_model');
        $this->load->model('property_model');
        $this->load->model('property_forecast_model');
        $this->load->library('hca');
    }

    function index() {
        //////////////Information/////////
        //ri = Room Inventory
        //////////////////////////////////
        $holding = "SH";
        $userproperty = $this->session->userdata('property');
        $dt_hotelcompetitor = $this->ref_hotel_competitor_model->select_hotelcompetitor();
        $idfom = $this->session->userdata('idstaff');
        $idjabatan = $this->session->userdata('idjabatan');
        if ($userproperty == $holding) {
            $dt_hotelcomp = $this->ref_hotel_competitor_model->select_hotelcompetitor();
            $dt_hca = $this->hotel_competitor_analysis_model->select_hotelcompanalysis_perdate(date('Y-m-d'));


            $dt_hotelcomp4 = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars(4);
            $dt_hotelcomp3 = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars(3);

            $dt_hotelcomp4allproperty = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars(4);
            $dt_hotelcomp3allproperty = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars(3);

            $dt_industri = $this->ref_industri_model->select_industri();
            $dt_account_segment = $this->account_segment_model->select_account_segment();
            $dt_sales = $this->sales_model->select_sales();

            $dt_countries = $this->ref_countries_model->select_countries();
            $dt_propinsi = $this->ref_provience_model->select_propinsi();
            $ri_mtd = '';
            $ri_ytd = '';

            $dt_initbal4 = $this->hotel_comp_initial_model->select_hotelcompinitialbalance_by_stars(4);
            $dt_initbal3 = $this->hotel_comp_initial_model->select_hotelcompinitialbalance_by_stars(3);

            $dt_woinitbal4 = $this->hotel_comp_initial_model->select_hotelcomp_nothave_initialbalance_by_stars(4);
            $dt_woinitbal3 = $this->hotel_comp_initial_model->select_hotelcomp_nothave_initialbalance_by_stars(3);
        } else {
            $dt_hotelcomp = $this->ref_hotel_competitor_model->select_hotelcompetitor_per_property($userproperty);
            $dt_hca = $this->hotel_competitor_analysis_model->select_hotelcompanalysis_perdate_property(date('Y-m-d'), $userproperty);

            $dt_hotelcomp4 = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars_per_property(4, $userproperty);
            $dt_hotelcomp3 = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars_per_property(3, $userproperty);

            $dt_hotelcomp4allproperty = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars(4);
            $dt_hotelcomp3allproperty = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars(3);

            $dt_industri = $this->ref_industri_model->select_industri();
            $dt_account_segment = $this->account_segment_model->select_account_segment();
            $dt_sales = $this->sales_model->select_sales();

            $dt_countries = $this->ref_countries_model->select_countries();
            $dt_propinsi = $this->ref_provience_model->select_propinsi();
            $ri_mtd = '';
            $ri_ytd = '';

            $dt_initbal4 = $this->hotel_comp_initial_model->select_hotelcompinitialbalance_by_stars_per_property(4, $userproperty);
            $dt_initbal3 = $this->hotel_comp_initial_model->select_hotelcompinitialbalance_by_stars_per_property(3, $userproperty);
        }

        $dt_property = $this->property_model->select_property();
        $dt_yearbudget = $this->hca_property_budget_model->select_yearbudget();
        $dt_budgetpropertyperperiod = $this->hca_property_budget_model->select_budgetproperty_perperiod(date('m'), date('Y'));
        $dt_hotelprop = $this->ref_hotel_competitor_model->select_hotelcompetitor();
        $data = array('accounton' => '',
            'welcomeon' => '',
            'documenton' => 'class="on"',
            'activitieson' => '',
            'reporton' => '',
            'ebookingon' => '',
            'setupon' => '',
            'calendaron' => '',
            'dt_hotelcompetitor' => $dt_hotelcomp->result(),
            'dt_hca' => $dt_hca->result(),
            //'dt_account'=>$dt_account->result(),
            'dt_hotelcomp4' => $dt_hotelcomp4->result(),
            'dt_hotelcomp3' => $dt_hotelcomp3->result(),
            'dt_hotelcomp4allproperty' => $dt_hotelcomp4allproperty->result(),
            'dt_hotelcomp3allproperty' => $dt_hotelcomp3allproperty->result(),
            'dt_industri' => $dt_industri->result(),
            'dt_account_segment' => $dt_account_segment->result(),
            'dt_sales' => $dt_sales->result(),
            'dt_countries' => $dt_countries->result(),
            'dt_propinsi' => $dt_propinsi->result(),
            'dt_initbal4' => $dt_initbal4->result(),
            'dt_initbal3' => $dt_initbal3->result(),
            'dt_woinitbal4' => $dt_woinitbal4->result(),
            'dt_woinitbal3' => $dt_woinitbal3->result(),
            'dt_property' => $dt_property->result(),
            'dt_yearbudget' => $dt_yearbudget->result(),
            'dt_budgetproperty' => $dt_budgetpropertyperperiod->result(),
            'dt_hotelprop' => $dt_hotelprop->result(),
            'userproperty' => $userproperty,
            'idfom' => $idfom,
            'idjabatan' => $idjabatan
        );
        $this->load->view('document/hotel_competitor_analysis/new_index', $data);
    }

    function chart_analysis_occ($refhotelcomp) {
        $this->load->plugin('ofc2');
        $data_1 = array();
        $data_2 = array();
        $data_3 = array();

        $totaldays = date('t');
        $currentdate = date('d');

        $max_y = 0;
        for ($i = 1; $i <= date('t'); $i++) {
            $occ = $this->hca->get_occ_hotel_per_day($refhotelcomp, date("Y-m-$i"));
            $data_1[] = floatval(number_format($occ, 2, '.', '.'));

            $occcompset = $this->hca->get_occ_comp4stars_set_per_day(date("Y-m-$i"));
            $data_2[] = floatval(number_format($occcompset, 2, '.', '.'));

            if (floatval($occ) > $max_y) {
                $max_y = floatval($occ);
            }

            if (floatval($occcompset) > $max_y) {
                $max_y = floatval($occcompset);
            }
        }



        $title = new title('Daily Data fo the Month GF');
        $title->set_style("{font-size: 20px; font-family: Times New Roman; font-weight: bold; color: #131683; text-align: center;}");

        $s1 = new star();
        $s1->size(6)->halo_size(2);

        $s2 = new star();
        $s2->size(6)->halo_size(2)->colour('#f00000')->rotation(180)->hollow(false);


        $x = new x_axis();
        $x->set_range(1, $totaldays);
        $x->set_grid_colour("#FFFFFF");

        $line_1_default_dot = new dot();
        $line_1_default_dot->colour('#f00000');

        $line_1 = new line();
        $line_1->set_default_dot_style($s1);
        $line_1->set_values($data_1);
        $line_1->set_width(1);

// ------- LINE 2 -----
        $line_2_default_dot = new dot();
        $line_2_default_dot->size(3)->halo_size(1)->colour('#3D5C56');

        $line_2 = new line();
        $line_2->set_default_dot_style($s2);
        $line_2->set_values($data_2);
        $line_2->set_width(2);
        $line_2->set_colour('#3D5C56');

// ------- LINE 2 -----
        $line_3_default_dot = new dot();
        $line_3_default_dot->size(4)->halo_size(2);

        $line_3 = new line();
        $line_3->set_default_dot_style($line_3_default_dot);
        $line_3->set_values($data_3);
        $line_3->set_width(6);

        $y = new y_axis();
        $y->set_range(0, $max_y + ceil($max_y / 6), ceil($max_y / 6));
        $y->set_grid_colour("#e9ece8");

        $tooltip = new tooltip();
        //
        // LOOK:
        //
        $tooltip->set_hover();
        //

        $chart = new open_flash_chart();
        $chart->set_tooltip($tooltip);
        $chart->set_title($title);
        $chart->add_element($line_1);

        $chart->set_x_axis($x);
        $chart->set_y_axis($y);
        $chart->set_bg_colour('#FFFFFF');

        echo $chart->toPrettyString();
    }

    function chart_analysis_occ_from_to($refhotelcomp) {
        $from = tanggal_php_to_mysql($this->input->post('from'));
        $to = tanggal_php_to_mysql($this->input->post('to'));
        $daydiff = dateDiff($from, $to);
        $this->load->plugin('ofc2');
        $data_1 = array();
        $data_2 = array();
        $data_3 = array();

        $totaldays = $daydiff;
        $currentdate = date('d');
        $label = array();
        $max_y = 0;
        if ($this->input->post('from') == '' || $this->input->post('to') == '') {
            for ($i = 1; $i <= date('t'); $i++) {
                $label[] = date('d', strtotime(date('0-m-Y') . "+$i day"));
                $occ = $this->hca->get_occ_hotel_per_day($refhotelcomp, date("Y-m-$i"));
                $data_1[] = floatval(number_format($occ, 2, '.', '.'));

                if ($refhotelcomp != 26) {
                    $occcompset = $this->hca->get_occ_comp4stars_set_per_day(date("Y-m-$i"));
                } else {
                    $occcompset = $this->hca->get_occ_comp3stars_set_per_day(date("Y-m-$i"));
                }
                $data_2[] = floatval(number_format($occcompset, 2, '.', ''));

                if (floatval($occ) > $max_y) {
                    $max_y = floatval($occ);
                }

                if (floatval($occcompset) > $max_y) {
                    $max_y = floatval($occcompset);
                }
            }
            $title = new title('Daily Occupancy for the Month of ' . date('F'));
        } else {
            for ($i = 0; $i <= $daydiff; $i++) {
                $label[] = date('d', strtotime($from . "+$i day"));

                $occ = $this->hca->get_occ_hotel_per_day($refhotelcomp, date('Y-m-d', strtotime($from . "+$i day")));
                $data_1[] = floatval(number_format($occ, 2, '.', ''));

                if ($refhotelcomp != 26) {
                    $occcompset = $this->hca->get_occ_comp4stars_set_per_day(date('Y-m-d', strtotime($from . "+$i day")));
                } else {
                    $occcompset = $this->hca->get_occ_comp3stars_set_per_day(date('Y-m-d', strtotime($from . "+$i day")));
                }
                $data_2[] = floatval(number_format($occcompset, 2, '.', ''));

                if (floatval($occ) > $max_y) {
                    $max_y = floatval($occ);
                }

                if (floatval($occcompset) > $max_y) {
                    $max_y = floatval($occcompset);
                }
            }
            $title = new title('Daily Occupancy from ' . date('d M', strtotime($from)) . ' to ' . date('d M', strtotime($to)));
        }


        $title->set_style("{font-size: 20px; font-family: Times New Roman; font-weight: bold; color: #131683; text-align: center;}");

        $s1 = new star();
        $s1->size(6)->halo_size(2);

        $s2 = new star();
        $s2->size(6)->halo_size(2)->colour('#f00000')->rotation(180)->hollow(true);


        $x = new x_axis();
        $x->set_labels_from_array($label);
        //$x->set_range(1, $totaldays);
        $x->set_grid_colour("#FFFFFF");

        $line_1_default_dot = new dot();
        $line_1_default_dot->colour('#f00000');

        $line_1 = new line();
        $line_1->set_default_dot_style($s1);
        $line_1->set_values($data_1);
        $line_1->set_width(1);
        $line_1->set_key('My Property', 15);

// ------- LINE 2 -----
        $line_2_default_dot = new dot();
        $line_2_default_dot->size(2)->halo_size(1)->colour('#FFFFFF');

        $line_2 = new line();
        $line_2->set_default_dot_style($s2);
        $line_2->set_values($data_2);
        $line_2->set_width(1);
        $line_2->set_colour('#f00000');
        $line_2->set_key('Comp Set', 15);


// ------- LINE 2 -----
        $line_3_default_dot = new dot();
        $line_3_default_dot->size(4)->halo_size(2);

        $line_3 = new line();
        $line_3->set_default_dot_style($line_3_default_dot);
        $line_3->set_values($data_3);
        $line_3->set_width(6);

        $y = new y_axis();
        $y->set_range(0, $max_y + ceil($max_y / 6), ceil($max_y / 6));
        $y->set_grid_colour("#e9ece8");

        $tooltip = new tooltip();
        //
        // LOOK:
        //
        $tooltip->set_hover();
        //

        $chart = new open_flash_chart();
        $chart->set_tooltip($tooltip);
        $chart->set_title($title);
        $chart->add_element($line_1);
        $chart->add_element($line_2);
//        $chart->add_element($line_3);

        $chart->set_x_axis($x);
        $chart->set_y_axis($y);
        $chart->set_bg_colour('#FFFFFF');

        echo $chart->toPrettyString();
    }

    function table_analysis_occ_from_to($refhotelcomp) {
        $from = tanggal_php_to_mysql($this->input->post('from'));
        $to = tanggal_php_to_mysql($this->input->post('to'));
        $daydiff = dateDiff($from, $to);

        $month = date('F', strtotime($from));
        echo '<div style="width: 100%;  overflow: scroll;  scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">';
        echo '<table style="border:1px solid black;width: 100%" >
                <tr>
                    <td style="width: 100px"></td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo ' <td style=" width: 20px;text-align: center">';
            $day = date('D', strtotime($from . "+$i day"));

            echo $day;


            echo '</td>';
        }// 
        echo '</tr>
                                <tr style="border:1px solid black" ><!-- Occupancy(%) -->
                                    <td style="border:1px solid black;width: 100px" rowspan="2"><b>Occupancy(%)</b></td>
                                    <td colspan="' . $daydiff . '">
                                        ' . $month . '
                                    </td>
                                </tr>
                                <tr>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo ' <td style=" width: 20px;text-align: center">';


            echo date('d', strtotime($from . "+$i day"));
            ;


            echo ' </td>';
        }//  
        echo '</tr>
                                <tr style="border:1px solid black">
                                    <td style="border:1px solid black;width: 100px">My Property</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center">   ';
            $occ = $this->hca->get_occ_hotel_per_day($refhotelcomp, date('Y-m-d', strtotime($from . "+$i day")));
            echo number_format($occ, 2, ',', '');

            echo '</td>';
        }//  
        echo '</tr>
                                <tr style="border:1px solid black;background-color: #dff8fc">
                                    <td style="border:1px solid black;width: 100px">Comp Set</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center;padding-left:5px;padding-right:5px;">';
            if ($refhotelcomp != 26) {
                $occcompset = $this->hca->get_occ_comp4stars_set_per_day(date('Y-m-d', strtotime($from . "+$i day")));
            } else {
                $occcompset = $this->hca->get_occ_comp3stars_set_per_day(date('Y-m-d', strtotime($from . "+$i day")));
            }
            echo number_format($occcompset, 2, ',', '');

            echo '  </td>';
        }// 
        echo '
                                </tr>
                                <tr style="border:1px solid black">
                                    <td style="border:1px solid black;width: 100px">SubMarket Class</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '
                                </tr >
                                <tr style="border:1px solid black;background-color: #dff8fc">
                                    <td style="border:1px solid black;width: 100px">Comp Set Rank</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }// 
        echo '</tr>
            <tr>
                <td colspan="' . ($daydiff + 1) . '">
                    &nbsp;<!-- spacer -->
                </td>
            </tr>
            <tr style="border:1px solid black"><!-- Occ % Chg -->
                <td style=" width: 100px"><b>Occ % Chg</b></td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '</tr>
        <tr style="border:1px solid black">
            <td style="border:1px solid black;width: 100px">My Property</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center">   </td>';
        }//  
        echo '
            </tr>
            <tr style="border:1px solid black;background-color: #dff8fc">
                <td style="border:1px solid black;width: 100px">Comp Set</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }//  
        echo ' </tr>
                                <tr style="border:1px solid black">
                                    <td style="border:1px solid black;width: 100px">SubMarket Class</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '</tr >
                                <tr style="border:1px solid black;background-color: #dff8fc">
                                    <td style="border:1px solid black;width: 100px">Comp Set Rank</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }// 
        echo '
                                </tr>
                                <tr>
                                    <td colspan="' . ($daydiff + 1) . '">
                                        &nbsp;
                                    </td>
                                </tr>
                                 <tr style="border:1px solid black"><!-- Occ Index -->
                                    <td style=" width: 100px"><b>Occ Index</b></td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo ' <td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '
            </tr>
            <tr style="border:1px solid black; ">
                <td style="border:1px solid black;width: 100px">Index (Comp Set)</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '  <td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '</tr>
              <tr style="border:1px solid black;background-color: #dff8fc">
                <td style="border:1px solid black;width: 100px">Index % Change</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '
            </tr>
        </table>';
        echo '</div>';
    }

    function chart_analysis_arr($refhotelcomp) {
        $this->load->plugin('ofc2');
        $data_1 = array();
        $data_2 = array();
        $data_3 = array();

        $totaldays = date('t');
        $currentdate = date('d');
        for ($i = 1; $i <= $currentdate; $i++) {
            //  $data_1[] = (sin($i) * 1.9) + 10;
            $data_2[] = (sin($i) * 1.9) + 7;
            $data_3[] = (sin($i) * 1.9) + 4;
        }

        $max_y = 0;
        for ($i = 1; $i <= date('t'); $i++) {
            $arr = $this->hca->get_arr_hotel_per_day($refhotelcomp, date("Y-m-$i"));
            $data_1[] = floatval(number_format($arr, 0, '.', ''));
//            
            $arrcompset = $this->hca->get_arr_comp4stars_set_per_day(date("Y-m-$i"));
            $data_2[] = floatval(number_format($arrcompset, 0, '.', '.'));
//            
            if (floatval(number_format($arr, 0, '.', '')) > $max_y) {
                $max_y = number_format($arr, 0, '.', '');
            }
//            
            if (floatval($arrcompset) > $max_y) {
                $max_y = floatval($arrcompset);
            }
        }



        $title = new title('Daily Data fo the Month GF');
        $title->set_style("{font-size: 20px; font-family: Times New Roman; font-weight: bold; color: #131683; text-align: center;}");

        $s1 = new star();
        $s1->size(6)->halo_size(2);

        $s2 = new star();
        $s2->size(6)->halo_size(2)->colour('#f00000')->rotation(180)->hollow(false);


        $x = new x_axis();
        $x->set_range(1, $totaldays);
        $x->set_grid_colour("#FFFFFF");

        $line_1_default_dot = new dot();
        $line_1_default_dot->colour('#f00000');

        $line_1 = new line();
        $line_1->set_default_dot_style($s1);
        $line_1->set_values($data_1);
        $line_1->set_width(1);

// ------- LINE 2 -----
        $line_2_default_dot = new dot();
        $line_2_default_dot->size(3)->halo_size(1)->colour('#3D5C56');

        $line_2 = new line();
        $line_2->set_default_dot_style($s2);
        $line_2->set_values($data_2);
        $line_2->set_width(2);
        $line_2->set_colour('#3D5C56');

// ------- LINE 2 -----
        $line_3_default_dot = new dot();
        $line_3_default_dot->size(4)->halo_size(2);

        $line_3 = new line();
        $line_3->set_default_dot_style($line_3_default_dot);
        $line_3->set_values($data_3);
        $line_3->set_width(6);

        $y = new y_axis();
        $y->set_range(0, $max_y + ceil($max_y / 6), ceil($max_y / 6));

        $y->set_grid_colour("#e9ece8");

        $tooltip = new tooltip();
        //
        // LOOK:
        //
        $tooltip->set_hover();
        //

        $chart = new open_flash_chart();
        $chart->set_tooltip($tooltip);
        $chart->set_title($title);
        $chart->add_element($line_1);
        $chart->add_element($line_2);
//        $chart->add_element($line_3);

        $chart->set_x_axis($x);
        $chart->set_y_axis($y);
        $chart->set_bg_colour('#FFFFFF');

        echo $chart->toPrettyString();
    }

    function chart_analysis_arr_from_to($refhotelcomp) {
        $from = tanggal_php_to_mysql($this->input->post('from'));
        $to = tanggal_php_to_mysql($this->input->post('to'));
        $daydiff = dateDiff($from, $to);
        $this->load->plugin('ofc2');
        $data_1 = array();
        $data_2 = array();
        $data_3 = array();

        $totaldays = $daydiff;
        $currentdate = date('d');
        $label = array();
        $max_y = 0;

        if ($this->input->post('from') == '' || $this->input->post('to') == '') {
            for ($i = 1; $i <= date('t'); $i++) {
                $label[] = date('d', strtotime(date('0-m-Y') . "+$i day"));
                $arr = $this->hca->get_arr_hotel_per_day($refhotelcomp, date("Y-m-$i"));
                $data_1[] = floatval(number_format($arr, 0, '.', ''));

                if ($refhotelcomp != 26) {
                    $arrcompset = $this->hca->get_arr_comp4stars_set_per_day(date("Y-m-$i"));
                } else {
                    $arrcompset = $this->hca->get_arr_comp3stars_set_per_day(date("Y-m-$i"));
                }
                $data_2[] = floatval(number_format($arrcompset, 0, '.', ''));

                if (floatval(number_format($arr, 0, '.', '')) > $max_y) {
                    $max_y = number_format($arr, 0, '.', '');
                }

                if (floatval($arrcompset) > $max_y) {
                    $max_y = floatval($arrcompset);
                }
            }
            $title = new title('Daily ARR for the Month ' . date('F'));
        } else {
            $title = new title('Daily ARR from ' . date('d M', strtotime($from)) . ' to ' . date('d M', strtotime($to)));
            for ($i = 0; $i <= $daydiff; $i++) {
                $label[] = date('d', strtotime($from . "+$i day"));

                $arr = $this->hca->get_arr_hotel_per_day($refhotelcomp, date('Y-m-d', strtotime($from . "+$i day")));
                $data_1[] = floatval(number_format($arr, 0, '.', ''));

                if ($refhotelcomp != 26) {
                    $arrcompset = $this->hca->get_arr_comp4stars_set_per_day(date('Y-m-d', strtotime($from . "+$i day")));
                } else {
                    $arrcompset = $this->hca->get_arr_comp3stars_set_per_day(date('Y-m-d', strtotime($from . "+$i day")));
                }
                $data_2[] = floatval(number_format($arrcompset, 0, '.', ''));

                if (floatval(number_format($arr, 0, '.', '')) > $max_y) {
                    $max_y = number_format($arr, 0, '.', '');
                }

                if (floatval(number_format($arrcompset, 0, '.', '')) > $max_y) {
                    $max_y = floatval(number_format($arrcompset, 0, '.', ''));
                }
            }
        }

        $title->set_style("{font-size: 20px; font-family: Times New Roman; font-weight: bold; color: #131683; text-align: center;}");

        $s1 = new star();
        $s1->size(6)->halo_size(2);

        $s2 = new star();
        $s2->size(6)->halo_size(2)->colour('#f00000')->rotation(180)->hollow(true);


        $x = new x_axis();
        $x->set_labels_from_array($label);
        //$x->set_range(1, $totaldays);
        $x->set_grid_colour("#FFFFFF");

        $line_1_default_dot = new dot();
        $line_1_default_dot->colour('#f00000');

        $line_1 = new line();
        $line_1->set_default_dot_style($s1);
        $line_1->set_values($data_1);
        $line_1->set_width(1);
        $line_1->set_key('My Property', 15);

// ------- LINE 2 -----
        $line_2_default_dot = new dot();
        $line_2_default_dot->size(3)->halo_size(1)->colour('#f00000');

        $line_2 = new line();
        $line_2->set_default_dot_style($s2);
        $line_2->set_values($data_2);
        $line_2->set_width(1);
        $line_2->set_colour('#f00000');
        $line_2->set_key('Comp Set', 15);

// ------- LINE 2 -----
        $line_3_default_dot = new dot();
        $line_3_default_dot->size(4)->halo_size(2);

        $line_3 = new line();
        $line_3->set_default_dot_style($line_3_default_dot);
        $line_3->set_values($data_3);
        $line_3->set_width(6);

        $y = new y_axis();
        $y->set_range(0, $max_y + ceil($max_y / 6), ceil($max_y / 6));
        $y->set_grid_colour("#e9ece8");

        $tooltip = new tooltip();
        //
        // LOOK:
        //
        $tooltip->set_hover();
        //

        $chart = new open_flash_chart();
        $chart->set_tooltip($tooltip);
        $chart->set_title($title);
        $chart->add_element($line_1);
        $chart->add_element($line_2);
//        $chart->add_element($line_3);

        $chart->set_x_axis($x);
        $chart->set_y_axis($y);
        $chart->set_bg_colour('#FFFFFF');

        echo $chart->toPrettyString();
    }

    function table_analysis_arr_from_to($refhotelcomp) {
        $from = tanggal_php_to_mysql($this->input->post('from'));
        $to = tanggal_php_to_mysql($this->input->post('to'));
        $daydiff = dateDiff($from, $to);

        $month = date('F', strtotime($from));
        echo '<div style="width: 100%;  overflow: scroll;  scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">';

        echo '<table style="border:1px solid black;width: 100%" >
                <tr>
                    <td style="width: 100px"></td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo ' <td style=" width: 20px;text-align: center">';
            $day = date('D', strtotime($from . "+$i day"));

            echo $day;


            echo '</td>';
        }// 
        echo '</tr>
                                <tr style="border:1px solid black" ><!-- Arr(%) -->
                                    <td style="border:1px solid black;width: 100px" rowspan="2"><b>ARR</b></td>
                                    <td colspan="' . $daydiff . '">
                                        ' . $month . '
                                    </td>
                                </tr>
                                <tr>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo ' <td style=" width: 20px;text-align: center">';
            echo date('d', strtotime($from . "+$i day"));
            ;
            echo ' </td>';
        }//  
        echo '</tr>
                <tr style="border:1px solid black">
                    <td style="border:1px solid black;width: 100px">My Property</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center">   ';
            $arr = $this->hca->get_arr_hotel_per_day($refhotelcomp, date('Y-m-d', strtotime($from . "+$i day")));
            echo number_format($arr, 0, ',', ',');
            echo '</td>';
        }//  
        echo '</tr>
                                <tr style="border:1px solid black;background-color: #dff8fc">
                                    <td style="border:1px solid black;width: 100px">Comp Set</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center;padding-left:5px;padding-right:5px;">';
            if ($refhotelcomp != 26) {
                $arrcompset = $this->hca->get_arr_comp4stars_set_per_day(date('Y-m-d', strtotime($from . "+$i day")));
            } else {
                $arrcompset = $this->hca->get_arr_comp3stars_set_per_day(date('Y-m-d', strtotime($from . "+$i day")));
            }
            echo number_format($arrcompset, 0, ',', ',');
            echo '  </td>';
        }// 
        echo '
                                </tr>
                                <tr style="border:1px solid black">
                                    <td style="border:1px solid black;width: 100px">SubMarket Class</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '
                                </tr >
                                <tr style="border:1px solid black;background-color: #dff8fc">
                                    <td style="border:1px solid black;width: 100px">Comp Set Rank</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }// 
        echo '</tr>
            <tr>
                <td colspan="' . ($daydiff + 1) . '">
                    &nbsp;<!-- spacer -->
                </td>
            </tr>
            <tr style="border:1px solid black"><!-- ARR Chg -->
                <td style=" width: 100px"><b>ARD Chg</b></td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '</tr>
        <tr style="border:1px solid black">
            <td style="border:1px solid black;width: 100px">My Property</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center">   </td>';
        }//  
        echo '
            </tr>
            <tr style="border:1px solid black;background-color: #dff8fc">
                <td style="border:1px solid black;width: 100px">Comp Set</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }//  
        echo ' </tr>
                                <tr style="border:1px solid black">
                                    <td style="border:1px solid black;width: 100px">SubMarket Class</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '</tr >
                                <tr style="border:1px solid black;background-color: #dff8fc">
                                    <td style="border:1px solid black;width: 100px">Comp Set Rank</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }// 
        echo '
                                </tr>
                                <tr>
                                    <td colspan="' . ($daydiff + 1) . '">
                                        &nbsp;
                                    </td>
                                </tr>
                                 <tr style="border:1px solid black"><!-- ARR Index -->
                                    <td style=" width: 100px"><b>ARD Index</b></td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo ' <td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '
            </tr>
            <tr style="border:1px solid black; ">
                <td style="border:1px solid black;width: 100px">Index (Comp Set)</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '  <td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '</tr>
              <tr style="border:1px solid black;background-color: #dff8fc">
                <td style="border:1px solid black;width: 100px">Index % Change</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '
            </tr>
        </table>';
        echo '</div>';
    }

    function chart_analysis_revpar($refhotelcomp) {
        $this->load->plugin('ofc2');
        $data_1 = array();
        $data_2 = array();
        $data_3 = array();

        $totaldays = date('t');
        $currentdate = date('d');
        for ($i = 1; $i <= $currentdate; $i++) {
            //  $data_1[] = (sin($i) * 1.9) + 10;
            $data_2[] = (sin($i) * 1.9) + 7;
            $data_3[] = (sin($i) * 1.9) + 4;
        }

        $max_y = 0;

        for ($i = 1; $i <= date('t'); $i++) {
            $trr = $this->hca->get_revpar_hotel_per_day($refhotelcomp, date("Y-m-$i"));
            $data_1[] = floatval($trr);
//            
//            $arrcompset = $this->hca->get_arr_comp4stars_set_per_day(date("Y-m-$i"));
//            $data_2[] = floatval(number_format($arrcompset, 0, '.', '.'));
//            
            if ($trr > $max_y) {
                $max_y = $trr;
            }
//            
//            if(floatval($arrcompset) > $max_y)
//            {
//                $max_y = floatval($arrcompset);
//            }
        }



        $title = new title('Daily Data fo the Month GF');
        $title->set_style("{font-size: 20px; font-family: Times New Roman; font-weight: bold; color: #131683; text-align: center;}");

        $s1 = new star();
        $s1->size(6)->halo_size(2);

        $s2 = new star();
        $s2->size(6)->halo_size(2)->colour('#f00000')->rotation(180)->hollow(false);


        $x = new x_axis();
        $x->set_range(1, $totaldays);
        $x->set_grid_colour("#FFFFFF");

        $line_1_default_dot = new dot();
        $line_1_default_dot->colour('#f00000');

        $line_1 = new line();
        $line_1->set_default_dot_style($s1);
        $line_1->set_values($data_1);
        $line_1->set_width(1);

// ------- LINE 2 -----
        $line_2_default_dot = new dot();
        $line_2_default_dot->size(3)->halo_size(1)->colour('#3D5C56');

        $line_2 = new line();
        $line_2->set_default_dot_style($s2);
        $line_2->set_values($data_2);
        $line_2->set_width(2);
        $line_2->set_colour('#3D5C56');

// ------- LINE 2 -----
        $line_3_default_dot = new dot();
        $line_3_default_dot->size(4)->halo_size(2);

        $line_3 = new line();
        $line_3->set_default_dot_style($line_3_default_dot);
        $line_3->set_values($data_3);
        $line_3->set_width(6);

        $y = new y_axis();
        $y->set_range(0, $max_y + ceil($max_y / 6), ceil($max_y / 6));

        $y->set_grid_colour("#e9ece8");

        $tooltip = new tooltip();
        //
        // LOOK:
        //
        $tooltip->set_hover();
        //

        $chart = new open_flash_chart();
        $chart->set_tooltip($tooltip);
        $chart->set_title($title);
        $chart->add_element($line_1);
//        $chart->add_element($line_2);
//        $chart->add_element($line_3);

        $chart->set_x_axis($x);
        $chart->set_y_axis($y);
        $chart->set_bg_colour('#FFFFFF');

        echo $chart->toPrettyString();
    }

    function chart_analysis_revpar_from_to($refhotelcomp) {
        $from = tanggal_php_to_mysql($this->input->post('from'));
        $to = tanggal_php_to_mysql($this->input->post('to'));
        $daydiff = dateDiff($from, $to);
        $this->load->plugin('ofc2');
        $data_1 = array();
        $data_2 = array();
        $data_3 = array();

        $totaldays = date('t');
        $currentdate = date('d');


        $label = array();
        $max_y = 0;
        if ($this->input->post('from') == '' || $this->input->post('to') == '') {
            for ($i = 1; $i <= date('t'); $i++) {
                $label[] = date('d', strtotime(date('0-m-Y') . "+$i day"));
                $trr = $this->hca->get_revpar_hotel_per_day($refhotelcomp, date("Y-m-$i"));
                $data_1[] = floatval($trr);

                if ($refhotelcomp != 26) {
                    $revparcompset = $this->hca->get_revpar_comp4stars_set_per_day(date("Y-m-$i"));
                } else {
                    $revparcompset = $this->hca->get_revpar_comp3stars_set_per_day(date("Y-m-$i"));
                }


                $data_2[] = floatval(number_format($revparcompset, 0, '.', ''));

                if ($trr > $max_y) {
                    $max_y = $trr;
                }

                if (floatval($revparcompset) > $max_y) {
                    $max_y = floatval($revparcompset);
                }
            }
            $title = new title('Daily RevPAR for the Month of ' . date('F'));
        } else {
            for ($i = 0; $i <= $daydiff; $i++) {
                $label[] = date('d', strtotime($from . "+$i day"));
                $trr = $this->hca->get_revpar_hotel_per_day($refhotelcomp, date('Y-m-d', strtotime($from . "+$i day")));
                $data_1[] = floatval($trr);

                if ($refhotelcomp != 26) {
                    $revparcompset = $this->hca->get_revpar_comp4stars_set_per_day(date('Y-m-d', strtotime($from . "+$i day")));
                } else {
                    $revparcompset = $this->hca->get_revpar_comp3stars_set_per_day(date('Y-m-d', strtotime($from . "+$i day")));
                }
                $data_2[] = floatval(number_format($revparcompset, 0, '.', ''));

                if ($trr > $max_y) {
                    $max_y = $trr;
                }

                if (floatval($revparcompset) > $max_y) {
                    $max_y = floatval($revparcompset);
                }
            }
            $title = new title('Daily RevPAR from ' . date('d M', strtotime($from)) . ' to ' . date('d M', strtotime($to)));
        }
        $title->set_style("{font-size: 20px; font-family: Times New Roman; font-weight: bold; color: #131683; text-align: center;}");

        $s1 = new star();
        $s1->size(6)->halo_size(2);

        $s2 = new star();
        $s2->size(6)->halo_size(2)->colour('#f00000')->rotation(180)->hollow(true);

        $x = new x_axis();
        $x->set_labels_from_array($label);
        $x->set_grid_colour("#FFFFFF");

        $line_1_default_dot = new dot();
        $line_1_default_dot->colour('#f00000');

        $line_1 = new line();
        $line_1->set_default_dot_style($s1);
        $line_1->set_values($data_1);
        $line_1->set_width(1);
        $line_1->set_key('My Property', 15);
// ------- LINE 2 -----
        $line_2_default_dot = new dot();
        $line_2_default_dot->size(3)->halo_size(1)->colour('#f00000');

        $line_2 = new line();
        $line_2->set_default_dot_style($s2);
        $line_2->set_values($data_2);
        $line_2->set_width(1);
        $line_2->set_colour('#f00000');
        $line_2->set_key('Comp Set', 15);
// ------- LINE 2 -----
        $line_3_default_dot = new dot();
        $line_3_default_dot->size(4)->halo_size(2);

        $line_3 = new line();
        $line_3->set_default_dot_style($line_3_default_dot);
        $line_3->set_values($data_3);
        $line_3->set_width(6);

        $y = new y_axis();
        $y->set_range(0, $max_y + ceil($max_y / 6), ceil($max_y / 6));

        $y->set_grid_colour("#e9ece8");

        $tooltip = new tooltip();
        //
        // LOOK:
        //
        $tooltip->set_hover();
        //
        $chart = new open_flash_chart();
        $chart->set_tooltip($tooltip);
        $chart->set_title($title);
        $chart->add_element($line_1);
        $chart->add_element($line_2);
        //$chart->add_element($line_3);

        $chart->set_x_axis($x);
        $chart->set_y_axis($y);
        $chart->set_bg_colour('#FFFFFF');

        echo $chart->toPrettyString();
    }

    function table_analysis_revpar_from_to($refhotelcomp) {
        $from = tanggal_php_to_mysql($this->input->post('from'));
        $to = tanggal_php_to_mysql($this->input->post('to'));
        $daydiff = dateDiff($from, $to);

        $month = date('F', strtotime($from));
        echo '<div style="width: 100%;  overflow: scroll;  scrollbar-arrow-color:blue; scrollbar-face-color: #e7e7e7; scrollbar-3dlight-color: #a0a0a0; scrollbar-darkshadow-color:#888888">';
        echo '<table style="border:1px solid black;width: 100%" >
                <tr>
                    <td style="width: 150px"></td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo ' <td style=" width: 150px;text-align: center">';
            $day = date('D', strtotime($from . "+$i day"));
            echo $day;
            echo '</td>';
        }// 
        echo '</tr>
                                <tr style="border:1px solid black" ><!-- RevPAR -->
                                    <td style="border:1px solid black;width: 100px" rowspan="2"><b>RevPAR</b></td>
                                    <td colspan="' . $daydiff . '">
                                        ' . $month . '
                                    </td>
                                </tr>
                                <tr>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo ' <td style=" width: 150px;text-align: center">';


            echo date('d', strtotime($from . "+$i day"));
            ;


            echo ' </td>';
        }//  
        echo '</tr>
                                <tr style="border:1px solid black">
                                    <td style="border:1px solid black;width: 100px">My Property</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center">   ';
            $trr = $this->hca->get_revpar_hotel_per_day($refhotelcomp, date('Y-m-d', strtotime($from . "+$i day")));
            echo number_format($trr, 0, ',', ',');
            echo '</td>';
        }//  
        echo '</tr>
                                <tr style="border:1px solid black;background-color: #dff8fc">
                                    <td style="border:1px solid black;width: 100px">Comp Set</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style="width: 150px;text-align: center;padding-left:5px;padding-right:5px;">';
            if ($refhotelcomp != 26) {
                $totaltrr = $this->hca->get_revpar_comp4stars_set_per_day(date('Y-m-d', strtotime($from . "+$i day")));
            } else {
                $totaltrr = $this->hca->get_revpar_comp3stars_set_per_day(date('Y-m-d', strtotime($from . "+$i day")));
            }
            echo number_format($totaltrr, 0, ',', ',');
            echo '  </td>';
        }// 
        echo '
                                </tr>
                                <tr style="border:1px solid black">
                                    <td style="border:1px solid black;width: 100px">SubMarket Class</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '
                                </tr >
                                <tr style="border:1px solid black;background-color: #dff8fc">
                                    <td style="border:1px solid black;width: 100px">Comp Set Rank</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }// 
        echo '</tr>
            <tr>
                <td colspan="' . ($daydiff + 1) . '">
                    &nbsp;<!-- spacer -->
                </td>
            </tr>
            <tr style="border:1px solid black"><!-- RevPAR Chg -->
                <td style=" width: 100px"><b>RevPAR Chg</b></td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '</tr>
        <tr style="border:1px solid black">
            <td style="border:1px solid black;width: 100px">My Property</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center">   </td>';
        }//  
        echo '
            </tr>
            <tr style="border:1px solid black;background-color: #dff8fc">
                <td style="border:1px solid black;width: 100px">Comp Set</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }//  
        echo ' </tr>
                                <tr style="border:1px solid black">
                                    <td style="border:1px solid black;width: 100px">SubMarket Class</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '</tr >
                                <tr style="border:1px solid black;background-color: #dff8fc">
                                    <td style="border:1px solid black;width: 100px">Comp Set Rank</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }// 
        echo '
                                </tr>
                                <tr>
                                    <td colspan="' . ($daydiff + 1) . '">
                                        &nbsp;
                                    </td>
                                </tr>
                                 <tr style="border:1px solid black"><!-- RevPAR Index -->
                                    <td style=" width: 100px"><b>RevPAR Index</b></td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo ' <td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '
            </tr>
            <tr style="border:1px solid black; ">
                <td style="border:1px solid black;width: 100px">Index (Comp Set)</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '  <td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '</tr>
              <tr style="border:1px solid black;background-color: #dff8fc">
                <td style="border:1px solid black;width: 100px">Index % Change</td>';
        for ($i = 0; $i <= $daydiff; $i++) {
            echo '<td style=" width: 20px;text-align: center"></td>';
        }//  
        echo '
            </tr>
        </table>';
        echo '</div>';
    }

    function add_group() {
        $salescreated = $this->input->post('salescreated');
        $industri = $this->input->post('industri');
        //updated 15June2010
        $country = $this->input->post('country');
        //endupdated
        $propinsi = $this->input->post('propinsi');
        $kota = $this->input->post('kota');
        $segment = $this->input->post('segment');
        $companyname = $this->input->post('companyname');
        $telp = $this->input->post('telp');
        $fax = $this->input->post('fax');
        $otherphone = $this->input->post('otherphone');
        $email = $this->input->post('email');
        $website = $this->input->post('website');
        $alamat = $this->input->post('alamat');
        $kode_pos = $this->input->post('kode_pos');
        $deskripsi = $this->input->post('deskripsi');
        $member = $this->input->post('idparent');
        $birthday = $this->input->post('birthday');
        $now = time();
        //$idsales = $this->session->userdata('idstaff');
        //echo unix_to_human($now);unix_to_human($now, TRUE, 'eu');
        $data_account = array('idindustri_FK' => $industri,
            'countriescode_FK' => $country,
            'KODE_PROP_FK' => $propinsi,
            'ID_KOTA_FK' => $kota,
            'idsales_FK' => $salescreated,
            'idcomseg_FK' => $segment,
            'account_name' => $companyname,
            'office_phone' => $telp,
            'fax_phone' => $fax,
            'other_phone' => $otherphone,
            'acct_email' => $email,
            'website' => $website,
            'address' => $alamat,
            'birthday' => tanggal_php_to_mysql($birthday),
            'postal_code' => $kode_pos,
            'description' => $deskripsi,
            'parent' => $member,
            'date_created' => unix_to_human($now, TRUE, 'eu'),
            'ip_address' => $this->input->ip_address(),
            'is_hca' => 'yes'
        );

        if ($salescreated == 0) {
            echo "Error, please contact your administrator.";
        } else {
            $idacc = $this->account_model->insert_account($data_account);
            echo '1 New Group Added';
        }
    }

    function add_budgethcaproperty() {
        $prop = $this->input->post('property');
        $year = $this->input->post('yearpb');
        $dt_budget = $this->hca_property_budget_model->select_budgetproperty_active_by_propertyyear($prop, $year);
        if ($dt_budget->num_rows() > 0) {
            $this->hca_property_budget_model->delete_budgetproperty_bypropyear($prop, $year);
            for ($i = 1; $i <= 12; $i++) {
                $roomnight = $this->input->post('roomnight' . $i);
                $arr = $this->input->post('arr' . $i);
                $period = $year . '-' . $i . '-01';
                $data = array('idhotelcompetitor_FK' => $prop,
                    'budget_period' => $period,
                    'room_night' => $roomnight,
                    'arr' => $arr,
                    'budget_status' => 'Deactive');
                $this->hca_property_budget_model->insert_data($data);
            }
            echo 'You have been replace property budget.';
        } else {
            for ($i = 1; $i <= 12; $i++) {
                $roomnight = $this->input->post('roomnight' . $i);
                $arr = $this->input->post('arr' . $i);
                $period = $year . '-' . $i . '-01';
                $data = array('idhotelcompetitor_FK' => $prop,
                    'budget_period' => $period,
                    'room_night' => $roomnight,
                    'arr' => $arr,
                    'budget_status' => 'Deactive');
                $this->hca_property_budget_model->insert_data($data);
            }
            echo 'You have new property budget.';
        }
    }

    function generate_pdf_analysis() {
        $printall = $this->input->post('printall');
        $printytd = $this->input->post('printytd');
        $printmtd = $this->input->post('printmtd');

        $tglhca = $this->input->post('tglhca');
        if ($tglhca == '') {
            $tglhca = date('d-m-Y');
        }
        $this->load->plugin('to_pdflandscape');
        $data = array('tanggal' => $tglhca);
        if ($printall != '') {
            $this->load->view('document/hotel_competitor_analysis/pdf_hotelcompetitoranalysis', $data);
        }

        if ($printytd != '') {
            $this->load->view('document/hotel_competitor_analysis/pdf_hotelcompetitoranalysis_ytd', $data);
        }

        if ($printmtd != '') {
            $this->load->view('document/hotel_competitor_analysis/pdf_hotelcompetitoranalysis_mtd', $data);
        }

        $nama_file = 'Hotel Competitor Analysis ' . format_waktu2($tglhca);
        $html = $this->output->get_output();
        pdf_create($html, $nama_file);
    }

    function add_hotelcompanalysis() {
        $idhotel = $this->input->post('idhotel');
        $roomsold = $this->input->post('roomsold');
        $arr = $this->input->post('arr');
        $perdate = tanggal_php_to_mysql($this->input->post('perdate'));
        $group = $this->input->post('idgroup');
        $rno = $this->input->post('rno');
        if (is_array($idhotel)) {
            foreach ($idhotel AS $k => $v) {
                if ($v != '') {
                    $dt_htl = $this->hotel_competitor_analysis_model->select_hotelcompanalys_by_hoteldate($v, $perdate);
                    if ($dt_htl->num_rows() > 0) {
                        $this->hotel_competitor_analysis_model->delete_hotelcompanalys_by_hoteldate($v, $perdate);
                    }

                    $data = array('per_date' => $perdate,
                        'room_sold' => $roomsold[$k],
                        'arr' => $arr[$k],
                        'idhotelcompetitor_FK' => $v);
                    $idhca = $this->hotel_competitor_analysis_model->insert_data($data);
                    if (is_array($group)) {
                        if (array_key_exists($v, $group)) {
                            $qtygroup = count($group[$v]);
                            for ($i = 0; $i < $qtygroup; $i++) {
                                $datagroup = array('idaccount_FK' => $group[$v][$i],
                                    'idhotelcompanalysis_FK' => $idhca,
                                    'rno' => $rno[$v][$i]);
                                $this->hotel_competitor_analysis_model->insert_hotelcompgroup($datagroup);
                            }
                        }
                    }
                }
            }
        }
        redirect('hotel_competitor_analysis');
    }

    function add_hotelcompanalysis_perhotel() {
        $idhotel = $this->input->post('hotelcompperhotel');
        $roomsold = $this->input->post('roomsoldperhotel');
        $arr = $this->input->post('arrperhotel');
        $perdate = tanggal_php_to_mysql($this->input->post('dateperhotel'));
        $group = $this->input->post('idgroupperhotel');
        $rno = $this->input->post('rno');



        $dt_htl = $this->hotel_competitor_analysis_model->select_hotelcompanalys_by_hoteldate($idhotel, $perdate);
        if ($dt_htl->num_rows() > 0) {
            //$this->hotel_competitor_analysis_model->delete_hotelcompanalys_by_hoteldate($idhotel, $perdate);
            $data = array('per_date' => $perdate,
                'room_sold' => $roomsold,
                'arr' => $arr
            );
            $this->hotel_competitor_analysis_model->update_hotelcompetitoranalys_by_id($dt_htl->row()->idhotelcompanalysis, $data);
            $idhca = $dt_htl->row()->idhotelcompanalysis;
        } else {
            $data = array('per_date' => $perdate,
                'room_sold' => $roomsold,
                'arr' => $arr,
                'idhotelcompetitor_FK' => $idhotel);
            $idhca = $this->hotel_competitor_analysis_model->insert_data($data);
        }
        if (is_array($group)) {
            if (array_key_exists($idhotel, $group)) {
                $qtygroup = count($group[$idhotel]);
                for ($i = 0; $i < $qtygroup; $i++) {
                    $this->hotel_competitor_analysis_model->delete_grouplastnight_by_accountidhotelcompanalys($group[$idhotel][$i], $idhca);

                    $datagroup = array('idaccount_FK' => $group[$idhotel][$i],
                        'idhotelcompanalysis_FK' => $idhca,
                        'rno' => $rno[$idhotel][$i]);
                    $this->hotel_competitor_analysis_model->insert_hotelcompgroup($datagroup);
                }
            }
        } else {
            $this->hotel_competitor_analysis_model->delete_grouplastnight_by_hca($idhca);
        }
//
//
//
        redirect('hotel_competitor_analysis');
    }

    function add_initial_balance() {
        $permonth = $this->input->post('permonth');
        $idhotel = $this->input->post('idhotelcomp');
        $rs_mtd = $this->input->post('rs_mtd');
        $rs_ytd = $this->input->post('rs_ytd');
        $arr_mtd = $this->input->post('arr_mtd');
        $arr_ytd = $this->input->post('arr_ytd');
        $trr_mtd = $this->input->post('trr_mtd');
        $trr_ytd = $this->input->post('trr_ytd');
        foreach ($idhotel AS $k => $v) {
            $data = array('mtd_rs' => $rs_mtd[$k],
                'ytd_rs' => $rs_ytd[$k],
//                          'mtd_arr'=>$arr_mtd[$k],
//                          'ytd_arr'=>$arr_ytd[$k],
                'mtd_trr' => $trr_mtd[$k],
                'ytd_trr' => $trr_ytd[$k],
                'per_date' => $permonth,
                'idhotelcompetitor_FK' => $v);
            $this->hotel_comp_initial_model->insert_data($data);
        }
        redirect('hotel_competitor_analysis');
    }

    function add_hotelcompanalysis_test() {
        $group = $this->input->post('idgroup');
        echo count($group);
        echo '<br/>';
        // echo array_key_exists(5, $group);
        echo count($group[5]);
        echo '<br/>';
        echo $group[5][0];
        foreach ($group AS $k => $v) {
            //echo $v[0][];
            echo '<br/>';
            echo 'ID Hotel : ' . $k;
            $t = count($v);
            echo '<br/>';
            echo 'Total Group : ' . $t;
            echo '<br/>';
            for ($i = 0; $i < $t; $i++) {
                echo 'ID GROUP ' . $v[$i];
                echo '<br/>';
            }
        }//endforeach
    }

    function add_forecast() {
        $forecastdate = $this->input->post('forecastdate');
        $rnts = $this->input->post('roomnights');
        $property = $this->input->post('property');
        foreach ($rnts AS $key => $val) {
            $dt_forecast = $this->property_forecast_model->select_propertyforecast_by_hoteldate($property, $forecastdate[$key]);
            if ($dt_forecast != NULL) {
                $data_update = array('roomnights' => $val);
                $this->property_forecast_model->update_forecast_by_hoteldate($property, $forecastdate[$key], $data_update);
            } else {
                $data = array('roomnights' => $val, 'forecast_date' => $forecastdate[$key], 'idhotelcompetitor_FK' => $property);
                $this->property_forecast_model->insert_data($data);
            }
        }
        echo 'Forecast data has been inserted.';
    }

    function get_hotelcomp_perdate() {
        $holding = "SH";
        $date = $this->input->post('date');
        $userproperty = $this->session->userdata('property');

        if ($userproperty == $holding) {
            $dt_hotelcomp4 = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars(4);
            $dt_hotelcomp3 = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars(3);
        } else {
            $dt_hotelcomp4 = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars(4);
            $dt_hotelcomp3 = $this->ref_hotel_competitor_model->select_hotelcompetitor_by_stars(3);
        }

        $seriticolor = "#ccffff";
        $serelacolor = "#00ccff";
        $bananacolor = "#00ff00";
        $goldencolor = "#ffcc00";
        $carrcadincolor = "#ffcccc";

        $pertanggal = tanggal_php_to_mysql($date);
        $perdate = substr($date, 0, 2);
        $permonth = substr($date, 3, 2);
        $peryear = substr($date, 6);

        $start = strtotime($peryear . '-' . '01' . '-' . '01');
        $end = strtotime(tanggal_php_to_mysql($date));
        $diff = $end - $start;
        $ttldays = round($diff / 86400) + 1;

        if ($date != '') {
            echo '<style type="text/css"> .kolom10{width:200px}</style>';
            echo '<table class="dashboard"  style="font-size: 7pt">
                <tr>
                    <td class="kolom kolom10" rowspan="2" style="vertical-align: middle; text-align: center;"><b>Hotel Name</b></td>
                    <td class="kolom kolom10" rowspan="2" style="vertical-align: middle; text-align: center"><b>R. Inv.</b></td>
                    <td class="kolom kolom10" colspan="3" style="vertical-align: middle; text-align: center"><b>Room Sold</b></td>
                    <td class="kolom kolom10" colspan="3" style="vertical-align: middle; text-align: center"><b>OCCUPANCY</b></td>
                    <td class="kolom kolom10" colspan="3" style="vertical-align: middle; text-align: center"><b>ARR</b></td>
                    <td class="kolom kolom10" colspan="3" style="vertical-align: middle; text-align: center"><b>Total Room Revenue</b></td>
                    <td class="kolom kolom10" colspan="3" style="vertical-align: middle; text-align: center"><b>Fair Market Share</b></td>
                    <td class="kolom kolom10" colspan="3" style="vertical-align: middle; text-align: center"><b>Actual Market Share</b></td>
                    <td class="kolom kolom10" colspan="3" style="vertical-align: middle; text-align: center"><b>MPI</b></td>
                    <td class="kolom kolom10" rowspan="2" style="vertical-align: middle; text-align: center"><b>GROUP LAST NIGHT</b></td>
                </tr>
                <tr>
                    <td class="kolom"  title="Today" style="vertical-align: middle; text-align: center">' . $date . '</td>
                    <td class="kolom" title="Month to Date" style="vertical-align: middle; text-align: center">MTD</td>
                    <td class="kolom" title="Year to Date" style="vertical-align: middle; text-align: center">YTD</td>
                    <!-- End Room Sold-->
                    <td class="kolom" title="Today" style="vertical-align: middle; text-align: center">' . $date . '(%)</td>
                    <td class="kolom" title="Month to Date" style="vertical-align: middle; text-align: center">MTD(%)</td>
                    <td class="kolom" title="Year to Date" style="vertical-align: middle; text-align: center">YTD(%)</td>
                    <!-- End Occupancy -->
                    <td class="kolom" title="Today" style="vertical-align: middle; text-align: center">' . $date . '</td>
                    <td class="kolom" title="Month to Date" style="vertical-align: middle; text-align: center">MTD</td>
                    <td class="kolom" title="Year to Date" style="vertical-align: middle; text-align: center">YTD</td>
                    <!-- End ARR -->
                    <td class="kolom" title="Today" style="vertical-align: middle; text-align: center">' . $date . '</td>
                    <td class="kolom" title="Month to Date" style="vertical-align: middle; text-align: center">MTD</td>
                    <td class="kolom" title="Year to Date" style="vertical-align: middle; text-align: center">YTD</td>
                    <!-- End Total Room Revenue -->
                    <td class="kolom" title="Today" style="vertical-align: middle; text-align: center">' . $date . '</td>
                    <td class="kolom" title="Month to Date" style="vertical-align: middle; text-align: center">MTD</td>
                    <td class="kolom" title="Year to Date" style="vertical-align: middle; text-align: center">YTD</td>
                    <!-- End Fair Market Share-->
                    <td class="kolom" title="Today" style="vertical-align: middle; text-align: center">' . $date . '</td>
                    <td class="kolom" title="Month to Date" style="vertical-align: middle; text-align: center">MTD</td>
                    <td class="kolom" title="Year to Date" style="vertical-align: middle; text-align: center">YTD</td>
                    <!-- End Actual Market Share -->
                    <td class="kolom" title="Today" style="vertical-align: middle; text-align: center">' . $date . '</td>
                    <td class="kolom" title="Month to Date" style="vertical-align: middle; text-align: center">MTD</td>
                    <td class="kolom" title="Year to Date" style="vertical-align: middle; text-align: center">YTD</td>
                    <!-- End MPI -->
                </tr>';
            if ($dt_hotelcomp4->result() != NULL) {
                echo '
                    <tr>
                        <td colspan="21" style="text-align: left"><b>4 STARS HOTEL ****</b></td>
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
                $ri_today = 0;
                $ri_mtd = 0;
                $ri_ytd = 0;
                $rs_today = 0;
                $rs_mtd = 0;
                $rs_ytd = 0;
                $arr_today = 0;
                $arr_mtd = 0;
                $arr_ytd = 0;
                $occ_today = 0;
                $occ_mtd = 0;
                $occ_ytd = 0;
                $trr_today = 0;
                $trr_mtd = 0;
                $trr_ytd = 0;
                $totaltrrtoday = 0;
                $fms_today = 0;
                $fms_mtd = 0;
                $fms_ytd = 0;
                $ams_today = 0;
                $ams_mtd = 0;
                $ams_ytd = 0;
                $mpi_today = 0;
                $mpi_mtd = 0;
                $mpi_ytd = 0;
                /////////////////////////////

                $initbalroomsold_mtd = 0;
                $initbalroomsold_ytd = 0;
                $initbaltrr_mtd = 0;
                $initbaltrr_ytd = 0;
                $initbaldate = 0;
                $dt_initbal = $this->hotel_comp_initial_model->select_hotelcominitbalance_permonthhotel($permonth, $rowhtl->idhotelcompetitor);
                if ($dt_initbal != NULL) {
                    $initbaldate = $dt_initbal->per_date;
                    if (strtotime($initbaldate) <= $end) {
                        $initbalroomsold_mtd = $dt_initbal->mtd_rs;
                        $initbaltrr_mtd = $dt_initbal->mtd_trr;
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

                $dt_analystoday = $this->hotel_competitor_analysis_model->select_competitoranalysisondate_perhotel($rowhtl->idhotelcompetitor, $pertanggal);
                if ($dt_analystoday != NULL) {
                    $rs_today = $dt_analystoday->room_sold;
                    $arr_today = $dt_analystoday->arr;
                }
                //$dt_rsmtd = $this->hotel_competitor_analysis_model->select_roomsoldmtd_wodateinitbalbetween_perhotel($rowhtl->idhotelcompetitor,$initbaldate,$pertanggal,$initbaldate);
                $startdate_mtd = $peryear . '-' . $permonth . '-' . '01';
                $enddate_mtd = $pertanggal;
                $dt_rsmtd = $this->hotel_competitor_analysis_model->select_rsmtd_perhotel($startdate_mtd, $enddate_mtd, $rowhtl->idhotelcompetitor);
                if ($dt_rsmtd != NULL) {
                    $rs_mtd += $dt_rsmtd->RS_MTD;
                }
                //$dt_rsytd = $this->hotel_competitor_analysis_model->select_roomsoldyear_woinibaldate_perdate($rowhtl->idhotelcompetitor,$peryear,$pertanggal,$initbaldate);
                $startdate_ytd = $peryear . '-01-' . '01';
                $enddate_ytd = $pertanggal;
                $dt_rsytd = $this->hotel_competitor_analysis_model->select_rsytd_perhotel($startdate_ytd, $enddate_ytd, $rowhtl->idhotelcompetitor);

                if ($dt_rsytd != NULL) {
                    $rs_ytd += $dt_rsytd->RS_YTD;
                }


                //$dt_totaltrrtoday = $this->hotel_competitor_analysis_model->select_totaltrrtoday_wodateinitbal($initbaldate,$initbaldate,$pertanggal,$rowhtl->idhotelcompetitor);
                $dt_totaltrrtoday = $this->hotel_competitor_analysis_model->select_trrtoday_perhotel($pertanggal, $rowhtl->idhotelcompetitor);
                if ($dt_totaltrrtoday != NULL) {
                    $totaltrrtoday = $dt_totaltrrtoday->TRR_TODAY;
                }

                $dt_trrmtd = $this->hotel_competitor_analysis_model->select_trrmtd_perhotel($startdate_mtd, $enddate_mtd, $rowhtl->idhotelcompetitor);
                if ($dt_trrmtd != NULL) {
                    $trr_mtd = $dt_trrmtd->TRR_MTD;
                }

                $dt_trrytd = $this->hotel_competitor_analysis_model->select_trrytd_perhotel($startdate_ytd, $enddate_ytd, $rowhtl->idhotelcompetitor);
                if ($dt_trrytd != NULL) {
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
                if ($rs_mtd != 0) {
                    $arr_mtd = $trr_mtd / $rs_mtd;
                }
                if ($rs_ytd != 0) {
                    $arr_ytd = $trr_ytd / $rs_ytd;
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
            foreach ($dt_hotelcomp4->result() AS $rowhtl) {
                $oddrow++;
                /////////////////////////////
                $ri_today = 0;
                $ri_mtd = 0;
                $ri_ytd = 0;
                $rs_today = 0;
                $rs_mtd = 0;
                $rs_ytd = 0;
                $arr_today = 0;
                $arr_mtd = 0;
                $arr_ytd = 0;
                $occ_today = 0;
                $occ_mtd = 0;
                $occ_ytd = 0;
                $trr_today = 0;
                $trr_mtd = 0;
                $trr_ytd = 0;
                $totaltrrtoday = 0;
                $fms_today = 0;
                $fms_mtd = 0;
                $fms_ytd = 0;
                $ams_today = 0;
                $ams_mtd = 0;
                $ams_ytd = 0;
                $mpi_today = 0;
                $mpi_mtd = 0;
                $mpi_ytd = 0;
                /////////////////////////////

                $initbalroomsold_mtd = 0;
                $initbalroomsold_ytd = 0;
                $initbaltrr_mtd = 0;
                $initbaltrr_ytd = 0;
                $initbaldate = 0;
                $dt_initbal = $this->hotel_comp_initial_model->select_hotelcominitbalance_permonthhotel($permonth, $rowhtl->idhotelcompetitor);
                if ($dt_initbal != NULL) {
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

                $dt_analystoday = $this->hotel_competitor_analysis_model->select_competitoranalysisondate_perhotel($rowhtl->idhotelcompetitor, $pertanggal);
                if ($dt_analystoday != NULL) {
                    $rs_today = $dt_analystoday->room_sold;
                    $arr_today = $dt_analystoday->arr;
                }
                //$dt_rsmtd = $this->hotel_competitor_analysis_model->select_roomsoldmtd_wodateinitbalbetween_perhotel($rowhtl->idhotelcompetitor,$initbaldate,$pertanggal,$initbaldate);
                $startdate_mtd = $peryear . '-' . $permonth . '-' . '01';
                //$enddate = (date('Y-m-d', strtotime($pertanggal. "- 1 day")));
                $enddate_mtd = $pertanggal;
                $dt_rsmtd = $this->hotel_competitor_analysis_model->select_rsmtd_perhotel($startdate_mtd, $enddate_mtd, $rowhtl->idhotelcompetitor);
                if ($dt_rsmtd != NULL) {
                    $rs_mtd += $dt_rsmtd->RS_MTD;
                }

                //$dt_rsytd = $this->hotel_competitor_analysis_model->select_roomsoldyear_woinibaldate_perdate($rowhtl->idhotelcompetitor,$peryear,$pertanggal,$initbaldate);
                $startdate_ytd = $peryear . '-01-' . '01';
                $enddate_ytd = $pertanggal;
                $dt_rsytd = $this->hotel_competitor_analysis_model->select_rsytd_perhotel($startdate_ytd, $enddate_ytd, $rowhtl->idhotelcompetitor);

                if ($dt_rsytd != NULL) {
                    $rs_ytd += $dt_rsytd->RS_YTD;
                }

                //$dt_totaltrrtoday = $this->hotel_competitor_analysis_model->select_totaltrrtoday_wodateinitbal($initbaldate,$initbaldate,$pertanggal,$rowhtl->idhotelcompetitor);
                $dt_totaltrrtoday = $this->hotel_competitor_analysis_model->select_trrtoday_perhotel($pertanggal, $rowhtl->idhotelcompetitor);

                if ($dt_totaltrrtoday != NULL) {
                    $totaltrrtoday = $dt_totaltrrtoday->TRR_TODAY;
                }

                $dt_trrmtd = $this->hotel_competitor_analysis_model->select_trrmtd_perhotel($startdate_mtd, $enddate_mtd, $rowhtl->idhotelcompetitor);
                if ($dt_trrmtd != NULL) {
                    $trr_mtd = $dt_trrmtd->TRR_MTD;
                }

                $dt_trrytd = $this->hotel_competitor_analysis_model->select_trrytd_perhotel($startdate_ytd, $enddate_ytd, $rowhtl->idhotelcompetitor);
                if ($dt_trrytd != NULL) {
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
                if ($rs_mtd != 0) {
                    $arr_mtd = $trr_mtd / $rs_mtd;
                }
                if ($rs_ytd != 0) {
                    $arr_ytd = $trr_ytd / $rs_ytd;
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


                if ($rs_today != 0 && $ri_today != 0) {
                    $occ_today = ($rs_today / $ri_today) * 100;
                }
                if ($rs_mtd != 0 && $ri_mtd != 0) {
                    $occ_mtd = ($rs_mtd / $ri_mtd) * 100;
                }
                if ($rs_ytd != 0 && $ri_ytd != 0) {
                    $occ_ytd = ($rs_ytd / $ri_ytd) * 100;
                }

                $fms_today = $ri_today / $total_ri_today;
                $fms_mtd = $ri_mtd / $total_ri_mtd;
                $fms_ytd = $ri_ytd / $total_ri_ytd;

                if ($rs_today != 0 && $total_rs_today != 0) {
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
                if ($total_trr_mtd != 0 && $total_rs_mtd != 0) {
                    $total_arr_mtd = $total_trr_mtd / $total_rs_mtd;
                }
                if ($total_trr_ytd != 0 || $total_rs_ytd != 0) {
                    $total_arr_ytd = $total_trr_ytd / $total_rs_ytd;
                }

                if (($oddrow % 2) != 0) {
                    $class = "style='background-color: #ecfce3'";
                } else {
                    $class = '';
                }

                if (strtolower($rowhtl->hotelcompetitor_name) == "carrcadin") {
                    echo '  <tr style="background-color:' . $carrcadincolor . '">';
                } elseif (strtolower($rowhtl->hotelcompetitor_name) == "grand seriti") {
                    echo ' <tr style="background-color: ' . $seriticolor . '">';
                } elseif (strtolower($rowhtl->hotelcompetitor_name) == "grand serela") {
                    echo ' <tr style="background-color: ' . $serelacolor . '">';
                } elseif (strtolower($rowhtl->hotelcompetitor_name) == "banana inn") {
                    echo ' <tr style="background-color: ' . $bananacolor . '">';
                } elseif (strtolower($rowhtl->hotelcompetitor_name) == "golden flower") {
                    echo '<tr style="background-color: ' . $goldencolor . '">';
                } else {
                    echo ' <tr>';
                }//endif
                echo '
                        <td class="kolom"  width="190px">
                               ' . $rowhtl->hotelcompetitor_name . '<div style="width:120px"></div>
                        </td>
                        <td class="kolom" style="text-align: center">
                            ' . $rowhtl->room_inventory . '  
                        </td>
                        <td class="kolom" style="text-align: center" title="Today">' . $rs_today . '</td>
                        <td class="kolom" style="text-align: center" title="Month to Date">' . $rs_mtd . '</td>
                        <td class="kolom" style="text-align: center" title="Year to Date">' . $rs_ytd . '</td>
                        <!-- End Room Sold-->
                        <td class="kolom" style="text-align: center" title="Today">' . number_format($occ_today, 1, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Month to Date">' . number_format($occ_mtd, 1, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Year to Date">' . number_format($occ_ytd, 1, ',', '.') . '</td>
                        <!-- End Occupancy-->
                        <td class="kolom" style="text-align: center" title="Today">' . number_format($arr_today, 0, ',', ',') . '</td>
                        <td class="kolom" style="text-align: center" title="Month to Date">' . number_format($arr_mtd, 0, ',', ',') . '</td>
                        <td class="kolom" style="text-align: center" title="Year to Date">' . number_format($arr_ytd, 0, ',', ',') . '</td>
                        <!-- End ARR-->
                        <td class="kolom" style="text-align: center" title="Today">' . number_format($trr_today, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Month to Date">' . number_format($trr_mtd, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Year to Date">' . number_format($trr_ytd, 0, ',', '.') . '</td>
                        <!-- End Total Room Revenue-->
                        <td class="kolom" style="text-align: center" title="Today">' . number_format($fms_today, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Month to Date">' . number_format($fms_mtd, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Year to Date">' . number_format($fms_ytd, 2, ',', '.') . '</td>
                        <!-- End Fair Market Share-->
                        <td class="kolom" style="text-align: center" title="Today">' . number_format($ams_today, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Month to Date">' . number_format($ams_mtd, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Year to Date">' . number_format($ams_ytd, 2, ',', '.') . '</td>
                        <!-- End Actual Market Share-->
                        <td class="kolom" style="text-align: center" title="Today">' . number_format($mpi_today, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Month to Date">' . number_format($mpi_mtd, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Year to Date">' . number_format($mpi_ytd, 2, ',', '.') . '</td>
                        <!-- End MPI -->
                        <td class="kolom">';
                $dt_grouphotel = $this->hotel_competitor_analysis_model->select_groupondate_perhotel($rowhtl->idhotelcompetitor, $pertanggal);
                $row = 1;
                $ttlrowgh = $dt_grouphotel->num_rows();
                foreach ($dt_grouphotel->result() AS $rowgh) {
                    echo '- ' . $rowgh->account_name . '[<font style="color:red">' . $rowgh->rno . '</font>]';
                    if ($row < $ttlrowgh) {
                        //echo '<b> - </b> ';
                        echo '<br/>';
                    }
                    $row++;
                }
                echo ' <div style="width:120px"></div></td>
                    </tr>';
            }
            echo '
                    <tr>
                        <td class="kolom" style="text-align: right"><b>Total</b></td>
                        <td class="kolom" style="text-align: center">' . $total_ri_today . '</td>
                        <td class="kolom" style="text-align: center">' . $total_rs_today . '</td>
                        <td class="kolom" style="text-align: center">' . $total_rs_mtd . '</td>
                        <td class="kolom" style="text-align: center">' . $total_rs_ytd . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_occ_today, 1, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_occ_mtd, 1, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_occ_ytd, 1, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_arr_today, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_arr_mtd, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_arr_ytd, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_trr_today, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_trr_mtd, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_trr_ytd, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_fms_today, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_fms_mtd, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_fms_ytd, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_ams_today, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_ams_mtd, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_ams_ytd, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_mpi_today, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_mpi_mtd, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_mpi_ytd, 2, ',', '.') . '</td>
                        <td class="kolom"></td>
                    </tr>';

            if ($dt_hotelcomp3->result() != NULL) {
                echo '
                   <tr>
                        <td colspan="23" style="text-align: left"><b>3 STARS HOTEL ***</b></td>
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
            foreach ($dt_hotelcomp3->result() AS $rowhtl) {
                /////////////////////////////
                $ri_today = 0;
                $ri_mtd = 0;
                $ri_ytd = 0;
                $rs_today = 0;
                $rs_mtd = 0;
                $rs_ytd = 0;
                $arr_today = 0;
                $arr_mtd = 0;
                $arr_ytd = 0;
                $occ_today = 0;
                $occ_mtd = 0;
                $occ_ytd = 0;
                $trr_today = 0;
                $trr_mtd = 0;
                $trr_ytd = 0;
                $totaltrrtoday = 0;
                $fms_today = 0;
                $fms_mtd = 0;
                $fms_ytd = 0;
                $ams_today = 0;
                $ams_mtd = 0;
                $ams_ytd = 0;
                $mpi_today = 0;
                $mpi_mtd = 0;
                $mpi_ytd = 0;
                /////////////////////////////

                $initbalroomsold_mtd = 0;
                $initbalroomsold_ytd = 0;
                $initbaltrr_mtd = 0;
                $initbaltrr_ytd = 0;
                $initbaldate = 0;
                $dt_initbal = $this->hotel_comp_initial_model->select_hotelcominitbalance_permonthhotel($permonth, $rowhtl->idhotelcompetitor);
                if ($dt_initbal != NULL) {
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

                $dt_analystoday = $this->hotel_competitor_analysis_model->select_competitoranalysisondate_perhotel($rowhtl->idhotelcompetitor, $pertanggal);
                if ($dt_analystoday != NULL) {
                    $rs_today = $dt_analystoday->room_sold;
                    $arr_today = $dt_analystoday->arr;
                }
                //$dt_rsmtd = $this->hotel_competitor_analysis_model->select_roomsoldmtd_wodateinitbalbetween_perhotel($rowhtl->idhotelcompetitor,$initbaldate,$pertanggal,$initbaldate);
                $startdate_mtd = $peryear . '-' . $permonth . '-' . '01';
                $enddate_mtd = $pertanggal;
                $dt_rsmtd = $this->hotel_competitor_analysis_model->select_rsmtd_perhotel($startdate_mtd, $enddate_mtd, $rowhtl->idhotelcompetitor);

                if ($dt_rsmtd != NULL) {
                    $rs_mtd += $dt_rsmtd->RS_MTD;
                }
                //$dt_rsytd = $this->hotel_competitor_analysis_model->select_roomsoldyear_woinibaldate_perdate($rowhtl->idhotelcompetitor,$peryear,$pertanggal,$initbaldate);
                $startdate_ytd = $peryear . '-01-' . '01';
                $enddate_ytd = $pertanggal;
                $dt_rsytd = $this->hotel_competitor_analysis_model->select_rsytd_perhotel($startdate_ytd, $enddate_ytd, $rowhtl->idhotelcompetitor);

                if ($dt_rsytd != NULL) {
                    $rs_ytd += $dt_rsytd->RS_YTD;
                }

                $dt_totaltrrtoday = $this->hotel_competitor_analysis_model->select_totaltrrtoday_wodateinitbal($initbaldate, $initbaldate, $pertanggal, $rowhtl->idhotelcompetitor);
                if ($dt_totaltrrtoday != NULL) {
                    $totaltrrtoday = $dt_totaltrrtoday->TRR_TODAY;
                }


                if (strtotime($initbaldate) == strtotime($pertanggal)) {
                    $trr_mtd += $initbaltrr_mtd;
                    $trr_ytd += $initbaltrr_ytd;
                } else {
                    $trr_mtd += floatval($initbaltrr_mtd) + $totaltrrtoday;
                    $trr_ytd += floatval($initbaltrr_ytd) + $totaltrrtoday;
                }

                $trr_today = $rs_today * $arr_today;
                if ($rs_mtd != 0) {
                    $arr_mtd = $trr_mtd / $rs_mtd;
                }
                if ($rs_ytd != 0) {
                    $arr_ytd = $trr_ytd / $rs_ytd;
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



            foreach ($dt_hotelcomp3->result() AS $rowhtl) {
                $oddrow++;

                /////////////////////////////
                $ri_today = 0;
                $ri_mtd = 0;
                $ri_ytd = 0;
                $rs_today = 0;
                $rs_mtd = 0;
                $rs_ytd = 0;
                $arr_today = 0;
                $arr_mtd = 0;
                $arr_ytd = 0;
                $occ_today = 0;
                $occ_mtd = 0;
                $occ_ytd = 0;
                $trr_today = 0;
                $trr_mtd = 0;
                $trr_ytd = 0;
                $totaltrrtoday = 0;
                $fms_today = 0;
                $fms_mtd = 0;
                $fms_ytd = 0;
                $ams_today = 0;
                $ams_mtd = 0;
                $ams_ytd = 0;
                $mpi_today = 0;
                $mpi_mtd = 0;
                $mpi_ytd = 0;
                /////////////////////////////

                $initbalroomsold_mtd = 0;
                $initbalroomsold_ytd = 0;
                $initbaltrr_mtd = 0;
                $initbaltrr_ytd = 0;
                $initbaldate = 0;
                $dt_initbal = $this->hotel_comp_initial_model->select_hotelcominitbalance_permonthhotel($permonth, $rowhtl->idhotelcompetitor);
                if ($dt_initbal != NULL) {
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

                $dt_analystoday = $this->hotel_competitor_analysis_model->select_competitoranalysisondate_perhotel($rowhtl->idhotelcompetitor, $pertanggal);
                if ($dt_analystoday != NULL) {
                    $rs_today = $dt_analystoday->room_sold;
                    $arr_today = $dt_analystoday->arr;
                }
                //$dt_rsmtd = $this->hotel_competitor_analysis_model->select_roomsoldmtd_wodateinitbalbetween_perhotel($rowhtl->idhotelcompetitor,$initbaldate,$pertanggal,$initbaldate);
                $startdate_mtd = $peryear . '-' . $permonth . '-' . '01';
                $enddate_mtd = $pertanggal;
                $dt_rsmtd = $this->hotel_competitor_analysis_model->select_rsmtd_perhotel($startdate_mtd, $enddate_mtd, $rowhtl->idhotelcompetitor);
                if ($dt_rsmtd != NULL) {
                    $rs_mtd += $dt_rsmtd->RS_MTD;
                }
                //$dt_rsytd = $this->hotel_competitor_analysis_model->select_roomsoldyear_woinibaldate_perdate($rowhtl->idhotelcompetitor,$peryear,$pertanggal,$initbaldate);
                $startdate_ytd = $peryear . '-01-' . '01';
                $enddate_ytd = $pertanggal;
                $dt_rsytd = $this->hotel_competitor_analysis_model->select_rsytd_perhotel($startdate_ytd, $enddate_ytd, $rowhtl->idhotelcompetitor);

                if ($dt_rsytd != NULL) {
                    $rs_ytd += $dt_rsytd->RS_YTD;
                }

                $dt_totaltrrtoday = $this->hotel_competitor_analysis_model->select_totaltrrtoday_wodateinitbal($initbaldate, $initbaldate, $pertanggal, $rowhtl->idhotelcompetitor);
                if ($dt_totaltrrtoday != NULL) {
                    $totaltrrtoday = $dt_totaltrrtoday->TRR_TODAY;
                }


                $dt_trrmtd = $this->hotel_competitor_analysis_model->select_trrmtd_perhotel($startdate_mtd, $enddate_mtd, $rowhtl->idhotelcompetitor);
                if ($dt_trrmtd != NULL) {
                    $trr_mtd = $dt_trrmtd->TRR_MTD;
                }

                $dt_trrytd = $this->hotel_competitor_analysis_model->select_trrytd_perhotel($startdate_ytd, $enddate_ytd, $rowhtl->idhotelcompetitor);
                if ($dt_trrytd != NULL) {
                    $trr_ytd = $dt_trrytd->TRR_YTD;
                }

                if (strtotime($initbaldate) <= strtotime($pertanggal)) {
                    $trr_mtd += $initbaltrr_mtd;
                    $trr_ytd += $initbaltrr_ytd;
                } else {
                    //$trr_mtd += floatval($initbaltrr_mtd) + $totaltrrtoday;
                    // $trr_ytd += floatval($initbaltrr_ytd) + $totaltrrtoday;
                }

                $trr_today = $rs_today * $arr_today;
                if ($rs_mtd != 0) {
                    $arr_mtd = $trr_mtd / $rs_mtd;
                }
                if ($rs_ytd != 0) {
                    $arr_ytd = $trr_ytd / $rs_ytd;
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


                if ($rs_today != 0 && $ri_today != 0) {
                    $occ_today = ($rs_today / $ri_today) * 100;
                }
                if ($rs_mtd != 0 && $ri_mtd != 0) {
                    $occ_mtd = ($rs_mtd / $ri_mtd) * 100;
                }
                if ($rs_ytd != 0 && $ri_ytd != 0) {
                    $occ_ytd = ($rs_ytd / $ri_ytd) * 100;
                }

                $fms_today = $ri_today / $total_ri_today3;
                $fms_mtd = $ri_mtd / $total_ri_mtd3;
                $fms_ytd = $ri_ytd / $total_ri_ytd3;

                if ($rs_today != 0 && $total_rs_today3 != 0) {
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

                if ($total_trr_today3 != 0 || $total_rs_today3 != 0) {
                    $total_arr_today3 = $total_trr_today3 / $total_rs_today3;
                }
                if ($total_trr_mtd3 != 0 || $total_rs_mtd3 != 0) {
                    $total_arr_mtd3 = $total_trr_mtd3 / $total_rs_mtd3;
                }
                if ($total_trr_ytd3 != 0 || $total_rs_ytd3 != 0) {
                    $total_arr_ytd3 = $total_trr_ytd3 / $total_rs_ytd3;
                }


                if (($oddrow % 2) != 0) {
                    $class = "style='background-color: #ecfce3'";
                } else {
                    $class = '';
                }


                if (strtolower($rowhtl->hotelcompetitor_name) == "grand serela") {
                    echo ' <tr style="background-color: ' . $serelacolor . '">';
                } else {
                    echo ' <tr>';
                }//endif

                echo '
                        
                        <td class="kolom">
                            ' . $rowhtl->hotelcompetitor_name . '
                        </td>
                        <td class="kolom" style="text-align: center">
                            ' . $rowhtl->room_inventory . '
                        </td>
                        <td class="kolom" style="text-align: center" title="Today">' . $rs_today . '</td>
                        <td class="kolom" style="text-align: center" title="Month to Date">' . $rs_mtd . '</td>
                        <td class="kolom" style="text-align: center" title="Year to Date">' . $rs_ytd . '</td>
                        <!-- End Room Sold-->
                        <td class="kolom" style="text-align: center" title="Today">' . number_format($occ_today, 1, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Month to Date">' . number_format($occ_mtd, 1, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Year to Date">' . number_format($occ_ytd, 1, ',', '.') . '</td>
                        <!-- End Occupancy-->
                        <td class="kolom" style="text-align: center" title="Today">' . number_format($arr_today, 0, ',', ',') . '</td>
                        <td class="kolom" style="text-align: center" title="Month to Date">' . number_format($arr_mtd, 0, ',', ',') . '</td>
                        <td class="kolom" style="text-align: center" title="Year to Date">' . number_format($arr_ytd, 0, ',', ',') . '</td>
                        <!-- End ARR-->
                        <td class="kolom" style="text-align: center" title="Today">' . number_format($trr_today, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Month to Date">' . number_format($trr_mtd, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Year to Date">' . number_format($trr_ytd, 0, ',', '.') . '</td>
                        <!-- End Total Room Revenue-->
                        <td class="kolom" style="text-align: center" title="Today">' . number_format($fms_today, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Month to Date">' . number_format($fms_mtd, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Year to Date">' . number_format($fms_ytd, 2, ',', '.') . '</td>
                        <!-- End Fair Market Share-->
                        <td class="kolom" style="text-align: center" title="Today">' . number_format($ams_today, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Month to Date">' . number_format($ams_mtd, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Year to Date">' . number_format($ams_ytd, 2, ',', '.') . '</td>
                        <!-- End Actual Market Share-->
                        <td class="kolom" style="text-align: center" title="Today">' . number_format($mpi_today, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Month to Date">' . number_format($mpi_mtd, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center" title="Year to Date">' . number_format($mpi_ytd, 2, ',', '.') . '</td>
                        <!-- End MPI -->
                        <td class="kolom">';
                $dt_grouphotel = $this->hotel_competitor_analysis_model->select_groupondate_perhotel($rowhtl->idhotelcompetitor, $pertanggal);
                $row = 1;
                $ttlrowgh = $dt_grouphotel->num_rows();
                foreach ($dt_grouphotel->result() AS $rowgh) {
                    echo '- ' . $rowgh->account_name . '[<font style="color:red">' . $rowgh->rno . '</font>]';
                    if ($row < $ttlrowgh) {
                        //echo '<b> - </b> ';
                        echo '<br/>';
                    }
                    $row++;
                }
                echo ' </td>
                    </tr>';
            }
            echo '
                    <!--<tr>
                        <td class="kolom" style="text-align: right"><b>Total</b></td>
                        <td class="kolom" style="text-align: center">' . $total_ri_today3 . '</td>
                        <td class="kolom" style="text-align: center">' . $total_rs_today3 . '</td>
                        <td class="kolom" style="text-align: center">' . $total_rs_mtd3 . '</td>
                        <td class="kolom" style="text-align: center">' . $total_rs_ytd3 . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_occ_today3, 1, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_occ_mtd3, 1, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_occ_ytd3, 1, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_arr_today3, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_arr_mtd3, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_arr_ytd3, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_trr_today3, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_trr_mtd3, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_trr_ytd3, 0, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_fms_today3, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_fms_mtd3, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_fms_ytd3, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_ams_today3, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_ams_mtd3, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_ams_ytd3, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_mpi_today3, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_mpi_mtd3, 2, ',', '.') . '</td>
                        <td class="kolom" style="text-align: center">' . number_format($total_mpi_ytd3, 2, ',', '.') . '</td>
                        <td class="kolom">
                        </td>
                    </tr>-->
                </table>';


            ////////////////////////////
            echo '<div style="width: 1500px; ">
                                    <div id="containerbudget" style="float: left;width: 600px" >';
            echo '<table class="dashboard"   style="margin-top: 20px;margin-bottom:  20px;width: 600px;font-size: 7pt">
                                    <tr>
                                        <th colspan="5" class="kolom"><span style="background-color:#ff99ff;padding: 5px ">BUDGET ' . $permonth . ' ' . $peryear . '</span>, Days in month  <span style="background-color:#ccffff ">' . date("t", strtotime($peryear . "-" . $permonth . "-01")) . '</span></th>
                                        <th colspan="2" class="kolom">REQUIRED TO MEET BUDGET</th>
                                    </tr>
                                    <tr class="oddRow">
                                        <th style="text-align: center" class="kolom">Sunan Hotel</th>
                                        <th style="text-align: center">Rnts</th>
                                        <th style="text-align: center">Occ %</th>
                                        <th style="text-align: center">Arr</th>
                                        <th style="text-align: center">RRev</th>
                                        <th style="text-align: center"><b>Rnts</b></th>
                                        <th style="text-align: center"><b>RRev</b></th>
                                    </tr>';
            $dt_budgetpropertyperperiod = $this->hca_property_budget_model->select_budgetproperty_perperiod($permonth, $peryear);

            foreach ($dt_budgetpropertyperperiod->result() AS $rowpr) {
                ////////////////////////////////
                $rs_today = 0;
                $rs_mtd = 0;
                $rs_ytd = 0;
                $trr_today = 0;
                $trr_mtd = 0;
                $trr_ytd = 0;
                $totaltrrtoday = 0;
                /////////////////////////////

                $initbalroomsold_mtd = 0;
                $initbalroomsold_ytd = 0;
                $initbaltrr_mtd = 0;
                $initbaltrr_ytd = 0;
                $initbaldate = 0;
                $dt_initbal = $this->hotel_comp_initial_model->select_hotelcominitbalance_permonthhotel($permonth, $rowpr->idhotelcompetitor_FK);
                if ($dt_initbal != NULL) {
                    $initbaldate = $dt_initbal->per_date;
                    if (strtotime($initbaldate) <= $end) {
                        $initbalroomsold_mtd = $dt_initbal->mtd_rs;
                        $initbalroomsold_ytd = $dt_initbal->ytd_rs;
                        $initbaltrr_mtd = $dt_initbal->mtd_trr;
                        $initbaltrr_ytd = $dt_initbal->ytd_trr;
                    }
                }

                $dt_initbalytd = $this->hotel_comp_initial_model->select_hotelcominitbalance_perhotel($rowpr->idhotelcompetitor_FK);
                if ($dt_initbalytd != NULL) {
                    if (strtotime($initbaldate) <= $end) {
                        $initbalroomsold_ytd = $dt_initbalytd->ytd_rs;
                        $initbaltrr_ytd = $dt_initbalytd->ytd_trr;
                    }
                }

                $rs_mtd += $initbalroomsold_mtd;
                $rs_ytd += $initbalroomsold_ytd;

                $dt_rsmtd = $this->hotel_competitor_analysis_model->select_rsmtd_perhotel($startdate_mtd, $enddate_mtd, $rowpr->idhotelcompetitor_FK);
                if ($dt_rsmtd != NULL) {
                    $rs_mtd += $dt_rsmtd->RS_MTD;
                }


                $dt_trrmtd = $this->hotel_competitor_analysis_model->select_trrmtd_perhotel($startdate_mtd, $enddate_mtd, $rowpr->idhotelcompetitor_FK);
                if ($dt_trrmtd != NULL) {
                    $trr_mtd = $dt_trrmtd->TRR_MTD;
                }


                if (strtotime($initbaldate) <= strtotime($pertanggal)) {
                    $trr_mtd += $initbaltrr_mtd;
                    $trr_ytd += $initbaltrr_ytd;
                } else {
                    //$trr_mtd += floatval($initbaltrr_mtd) + $totaltrrtoday;
                    //$trr_ytd += floatval($initbaltrr_ytd) + $totaltrrtoday;
                }
                ////////////////////////////////
                ////////////////////////////////

                $rm_inventory = $rowpr->room_inventory;
                $daysinmonth = date("t", strtotime($peryear . "-" . $permonth . "-01"));
                $occ = $rowpr->room_night / ($rm_inventory * $daysinmonth);
                $rrev = $rowpr->room_night * $rowpr->arr;
                $rmnight_req = $rs_mtd - $rowpr->room_night;
                $rrev_req = $trr_mtd - $rrev;
                echo '
                                    <tr>
                                        <td class="kolom">' . $rowpr->hotelcompetitor_name . '</td>
                                        <td style="text-align: center" class="kolom">' . $rowpr->room_night . '</td>
                                        <td style="text-align: center;background-color: #ccffff" class="kolom">' . number_format($occ * 100, 1, ',', '.') . '%</td>
                                        <td style="text-align: right" class="kolom">' . number_format($rowpr->arr, 0, ',', '.') . '</td>
                                        <td class="kolom" style="text-align: center;background-color: #ccffff">' . number_format($rrev, 0, ',', '.') . '</td>
                                        <td class="kolom" style="text-align: center">' . number_format($rmnight_req, 0, ',', '.') . '  </td>
                                        <td class="kolom" style="text-align: right">' . number_format($rrev_req, 0, ',', '.') . '</td>
                                    </tr>';
            }//endforeach property 

            echo '</table>';
            echo '</div>';
            echo '  <div id="containerforecast" style="float: left;margin-left: 10px;width: 800px; ">
                                        <table class="dashboard" border="1"  style="margin-top: 20px;margin-bottom:  20px; width: 100%;font-size: 7pt">
                                            <tr>
                                                <th colspan="17" class="kolom">FORECAST - EXPECTED CLOSINGSSS</th>
                                            </tr>
                                            <tr>
                                                <td class="kolom"><div style="width: 100px"></div></td>';
            for ($i = 0; $i < 8; $i++) {
                echo '
                                                    <td class="kolom" colspan="2" style=" text-align: center">
                                                    <b>' . (date('d-F', strtotime($pertanggal . "+ $i day"))) . '</b>
                                                </td>';
            }//endfor 
            echo '</tr>';
            $dt_hotelprop = $this->ref_hotel_competitor_model->select_hotelcompetitor();


            foreach ($dt_hotelprop->result() AS $row) {
                if (strtolower($row->hotelcompetitor_name) == "the sunan hotel solo") { 
                    echo '
                                                <td class="kolom" >' . $row->hotelcompetitor_name . '</td>';
                    for ($i = 0; $i < 8; $i++) {
                        $perdate = (date('Y-m-d', strtotime($pertanggal . "+ $i day")));
                        $dt_forecast = $this->property_forecast_model->select_propertyforecast_by_hoteldate($row->idhotelcompetitor, $perdate);
                        $roomnight = 0;
                        $roominv = $row->room_inventory;
                        if ($dt_forecast != NULL) {
                            $roomnight = $dt_forecast->roomnights;
                        }
                        echo '
                                                <td class="kolom"  style="text-align: center">';
                        echo $roomnight;
                        echo '</td>
                                                <td class="kolom" style="width: 50px;text-align: center"  >';
                        $occ = $roomnight / $roominv;
                        echo number_format($occ * 100, 1, '.', ',');
                        echo ' %
                                                </td>';
                    }//endfor
                    echo '
                                            </tr>';
                }//endif
            }//endforeach
            echo '
                                        </table>
                                    </div>';


            echo '</div>';

            /////////////////////////////
        } else {
            echo '<br/><b>Please, choose the date first.</b>';
        }
    }

// per data

    function load_budget_property() {
        $dt_property = $this->ref_hotel_competitor_model->select_hotelproperty_kagum();
        echo '<table class="dashboard" style="width: 600px">
                 <tr class="oddRow">
                    <td style="width: 100px;text-align: center" class="kolom"><b>MONTH PERIOD</b></td>
                    <td style="width: 200px;text-align: center" class="kolom"><b>ARR</b></td>
                    <td style="width: 200px;text-align: center" class="kolom"><b>ROOM NIGHT</b></td>
                    <td style="width: 100px;text-align: center" class="kolom"><b>STATUS</b></td>
                </tr>';
        foreach ($dt_property->result() AS $rowp) {
            echo '<tr>
                        <td class="kolom" colspan="4" style="text-align: center">' . $rowp->hotelcompetitor_name . '</td>
                    </tr>';
            $dt_budgetact = $this->hca_property_budget_model->select_budgetproperty_active_by_propertyyear($rowp->idhotelcompetitor, date('Y'));
            if ($dt_budgetact->result() != NULL) {
                foreach ($dt_budgetact->result() AS $rowba) {
                    echo '
                        <tr>
                            <td class="kolom">' . format_waktu2($rowba->budget_period) . '</td>
                            <td class="kolom" style="text-align:right">' . $rowba->arr . '</td>
                            <td class="kolom" style="text-align:center">' . $rowba->room_night . '</td>
                            <td class="kolom">' . $rowba->budget_status . '</td>
                        </tr>';
                }//endforeach budget
                echo '<tr><td colspan=4></td></tr>';
            } else {
                echo '<tr><td  style="text-align: center" colspan=4><b>Budget Not Available</b></td></tr>';
            }
        }//endoforeach property
        echo '</table>';
    }

    function load_propertyforecast() {
        echo ' <table class="dashboard" border="1"  style="margin-top: 20px;margin-bottom:  20px; width: 100%">
                                            <tr>
                                                <th colspan="17" class="kolom">FORECAST - EXPECTED CLOSING</th>
                                            </tr>
                                            <tr>
                                                <td class="kolom"><div style="width: 100px"></div></td>';
        for ($i = 0; $i < 8; $i++) {
            echo '
                                                <td class="kolom" colspan="2" style=" text-align: center">
                                                    <b>' . (date('d-M', strtotime(date('Y-m-d') . "+ $i day"))) . '</b>
                                                </td>';
        }//endfor
        echo '</tr>';


        $carrcadincolor = "#ffcccc";
        $dt_hotelprop = $this->ref_hotel_competitor_model->select_hotelcompetitor();
        foreach ($dt_hotelprop->result() AS $row) {
            if (strtolower($row->hotelcompetitor_name) == "the sunan hotel solo") {

                if (strtolower($row->hotelcompetitor_name) == "the sunan hotel solo") {
                    echo '<tr style="background-color: ' . $carrcadincolor . '">';
                }
                echo '
                                                                                <td class="kolom" >' . $row->hotelcompetitor_name . '</td>';
                for ($i = 0; $i < 8; $i++) {
                    $perdate = (date('Y-m-d', strtotime(date('Y-m-d') . "+ $i day")));
                    $dt_forecast = $this->property_forecast_model->select_propertyforecast_by_hoteldate($row->idhotelcompetitor, $perdate);
                    $roomnight = 0;
                    $roominv = $row->room_inventory;
                    if ($dt_forecast != NULL) {
                        $roomnight = $dt_forecast->roomnights;
                    }
                    echo '
                                                                                <td class="kolom"  style="text-align: center">';
                    echo $roomnight;
                    echo '</td>
                                                                                <td class="kolom" style="width: 50px;text-align: center"  >';
                    $occ = $roomnight / $roominv;
                    echo number_format($occ * 100, 1, '.', ',');

                    echo ' %</td>';
                }//endfor
                echo '
                                                                            </tr>';
            }//endif
        }//endforeach
        echo '
                                        </table>';
    }

    function activated_budgetproperty() {
        $property = $this->input->post('property');
        $year = $this->input->post('year');
        $dt_property = $this->ref_hotel_competitor_model->select_hotel_competitor_by_idhotelcompetitor($property);

        $dataupdate = array('budget_status' => 'Deactive');
        $this->hca_property_budget_model->update_budgetproperty_byproperty($property, $dataupdate);

        $dataaactivated = array('budget_status' => 'Active');
        $this->hca_property_budget_model->update_budgetproperty_bypropyear($property, $year, $dataaactivated);
        echo '<table class="dashboard" style="width: 500px">
                     <tr class="oddRow">
                     <td style="width: 100px;text-align: center" class="kolom">MONTH PERIOD</td>
                     <td style="width: 200px;text-align: center" class="kolom">ARR</td>
                     <td style="width: 200px;text-align: center" class="kolom">ROOM NIGHT</td>';
        $dt_budgetact = $this->hca_property_budget_model->select_budgetproperty_active_by_propertyyear($property, $year);
        if ($dt_budgetact->result() != NULL) {
            $status = $dt_budgetact->row(0)->budget_status;
            if ($status == 'Active') {
                echo '<td style="width: 100px;text-align: center" class="kolom">STATUS<br/>[ ' . anchor('', 'Deactivated', 'id="deactivated"') . ' ]<input type="hidden" id="yearactivated" value="' . $year . '"/><input type="hidden" id="propertyactivated" value="' . $property . '"/></td>';
            } else {
                echo '<td style="width: 100px;text-align: center" class="kolom">STATUS<br/>[ ' . anchor('', 'Activated', 'id="activated"') . ' ]<input type="hidden" id="yearactivated" value="' . $year . '"/><input type="hidden" id="propertyactivated" value="' . $property . '"/></td>';
            }
        } else {
            echo '<td style="width: 100px;text-align: center" class="kolom">STATUS</td>';
        }
        echo '</tr>';
        echo '<tr>
                    <td class="kolom" colspan="4" style="text-align: center"><b>' . $dt_property->hotelcompetitor_name . '</b></td>
                  </tr>';
        if ($dt_budgetact->result() != NULL) {
            foreach ($dt_budgetact->result() AS $rowba) {
                echo '
                        <tr>
                        <td style="text-align:center" class="kolom">' . format_waktu2($rowba->budget_period) . '</td>
                            <td style="text-align:right" class="kolom">' . $rowba->arr . '</td>
                            <td style="text-align:center" class="kolom">' . $rowba->room_night . '</td>
                            <td style="text-align:center" class="kolom">' . $rowba->budget_status . '</td>
                        </tr>';
            }//endforeach budget
        } else {
            echo '<tr><td  style="text-align: center" colspan=4><b>Budget Not Available</b></td></tr>';
        }
        echo '</table>';
    }

    function deactivated_budgetproperty() {
        $property = $this->input->post('property');
        $year = $this->input->post('year');
        $dt_property = $this->ref_hotel_competitor_model->select_hotel_competitor_by_idhotelcompetitor($property);

        $datadeactivated = array('budget_status' => 'Deactive');
        $this->hca_property_budget_model->update_budgetproperty_bypropyear($property, $year, $datadeactivated);
        echo '<table class="dashboard" style="width: 500px">
                     <tr class="oddRow">
                        <td style="width: 100px;text-align: center" class="kolom">MONTH PERIOD</td>
                        <td style="width: 200px;text-align: center" class="kolom">ARR</td>
                        <td style="width: 200px;text-align: center" class="kolom">ROOM NIGHT</td>';
        $dt_budgetact = $this->hca_property_budget_model->select_budgetproperty_active_by_propertyyear($property, $year);
        if ($dt_budgetact->result() != NULL) {
            $status = $dt_budgetact->row(0)->budget_status;
            if ($status == 'Active') {
                echo '<td style="width: 100px;text-align: center" class="kolom">STATUS<br/>[ ' . anchor('', 'Deactivated', 'id="deactivated"') . ' ]<input type="hidden" id="yearactivated" value="' . $year . '"/><input type="hidden" id="propertyactivated" value="' . $property . '"/></td>';
            } else {
                echo '<td style="width: 100px;text-align: center" class="kolom">STATUS<br/>[ ' . anchor('', 'Activated', 'id="activated"') . ' ]<input type="hidden" id="yearactivated" value="' . $year . '"/><input type="hidden" id="propertyactivated" value="' . $property . '"/></td>';
            }
        } else {
            echo '<td style="width: 100px;text-align: center" class="kolom">STATUS</td>';
        }
        echo '</tr>';
        echo '<tr>
                    <td class="kolom" colspan="4" style="text-align: center"><b>' . $dt_property->hotelcompetitor_name . '</b></td>
                  </tr>';
        if ($dt_budgetact->result() != NULL) {
            foreach ($dt_budgetact->result() AS $rowba) {
                echo '
                        <tr>
                            <td style="text-align:center" class="kolom">' . format_waktu2($rowba->budget_period) . '</td>
                            <td style="text-align:right" class="kolom">' . $rowba->arr . '</td>
                            <td style="text-align:center" class="kolom">' . $rowba->room_night . '</td>
                            <td style="text-align:center" class="kolom">' . $rowba->budget_status . '</td>
                        </tr>';
            }//endforeach budget
        } else {
            echo '<tr><td  style="text-align: center" colspan=4><b>Budget Not Available</b></td></tr>';
        }
        echo '</table>';
    }

    function get_top_market_group_bandung() {
        $from = tanggal_php_to_mysql($this->input->post('from'));
        $to = tanggal_php_to_mysql($this->input->post('to'));
        $daydiff = dateDiff($from, $to);
        $dt_group = $this->hotel_competitor_analysis_model->select_group_between($from, $to);
        echo '<table width="100%" class="dashboard" border=1 style="border:1px solid black">';
        echo '<tr>
                <th style="text-align:center">NO.</th>
                <th style="text-align:center">GROUP</th>
                <th style="text-align:center">TOTAL RNO</th>
                <th style="text-align:center">HOTEL</th>
                <th style="text-align:center">SUNAN(%)</th>
              </tr>';
        $no = 1;

        $carrcadincolor = "#fe3c08";
        foreach ($dt_group->result() AS $row) {
            $dt_hc = $this->hotel_competitor_analysis_model->select_hotelcompetitor_by_group_between($row->idaccount, $from, $to);
            echo '<tr>
                <td style="text-align:center;width:20px">' . $no++ . '</td>
                <td style=" width:420px">' . $row->account_name . '</td>
                <td  style="text-align:center;width:100px">' . $row->TotalRNO . '</td>
                <td >';
            $kgmrno = 0;
            $kgmpercent = 0;
            $qtyhtl = $dt_hc->num_rows();
            $x = 0;
            foreach ($dt_hc->result() AS $rowhc) {
                $x++;
                if ($rowhc->idhotelcompetitor == 33) {
                    echo '<span style="color:' . $carrcadincolor . '"><b>' . $rowhc->hotelcompetitor_name . '</b></span>(<b>' . $rowhc->TotalRNO . '</b>)';
                } else {
                    echo $rowhc->hotelcompetitor_name . '(<b>' . $rowhc->TotalRNO . '</b>)';
                }
                if ($x < $qtyhtl) {
                    echo ', ';
                }

                if ($rowhc->idhotelcompetitor == 33) {
                    //33 = sunan

                    $kgmrno += $rowhc->TotalRNO;
                }
            }

            $kgmpercent = ($kgmrno / $row->TotalRNO) * 100;
            echo '</td>';
            if ($kgmpercent >= 100 || $kgmpercent <= 0) {
                echo '<td style="text-align:center;width:100px">' . number_format($kgmpercent, 0, '.', '.') . '</td>';
            } else {
                echo '<td style="text-align:center;width:100px">' . number_format($kgmpercent, 2, '.', '.') . '</td>';
            }
            echo '</tr>';
        }

        echo '</table>';
    }

    function get_top_market_group_kagum() {
        $from = tanggal_php_to_mysql($this->input->post('from'));
        $to = tanggal_php_to_mysql($this->input->post('to'));
        $daydiff = dateDiff($from, $to);
        $dt_group = $this->hotel_competitor_analysis_model->select_group_on_kagum_between($from, $to);
        echo '<table width="100%" class="dashboard" border=1 style="border:1px solid black">';
        echo '<tr>
                <th style="text-align:center">NO.</th>
                <th style="text-align:center">GROUP</th>
                <th style="text-align:center">TOTAL RNO</th>
                <th style="text-align:center">SUNAN HOTELS</th>
                <!--<th style="text-align:center">SUNAN(%)</th>-->
              </tr>';
        $no = 1;
        $seriticolor = "#08a4fe";
        $serelacolor = "#00ccff";
        $bananacolor = "#00ff00";
        $goldencolor = "#ea9b03";
        $carrcadincolor = "#fe3c08";
        foreach ($dt_group->result() AS $row) {
            $dt_hc = $this->hotel_competitor_analysis_model->select_hotelkagum_by_group_between($row->idaccount, $from, $to);
            echo '<tr>
                <td style="text-align:center;width:20px">' . $no++ . '</td>
                <td style=" width:420px">' . $row->account_name . '</td>
                <td  style="text-align:center;width:100px">' . $row->TotalRNO . '</td>
                <td >';
            $kgmrno = 0;
            $kgmpercent = 0;
            $qtyhtl = $dt_hc->num_rows();
            $x = 0;
            foreach ($dt_hc->result() AS $rowhc) {
                $x++;
                if ($rowhc->idhotelcompetitor == 33) {
                    echo '<span style="color:' . $carrcadincolor . '"><b>' . $rowhc->hotelcompetitor_name . '</b></span>(<b>' . $rowhc->TotalRNO . '</b>)';
                } else {
                    echo $rowhc->hotelcompetitor_name . '(<b>' . $rowhc->TotalRNO . '</b>)';
                }
                if ($x < $qtyhtl) {
                    echo ', ';
                }

                if ($rowhc->idhotelcompetitor == 33) {
                    //33 = sunan, a

                    $kgmrno += $rowhc->TotalRNO;
                }
            }

            $kgmpercent = ($kgmrno / $row->TotalRNO) * 100;
            echo '</td>';
//                    if ($kgmpercent >= 100 || $kgmpercent <= 0) {
//                        echo '<td style="text-align:center;width:100px">' . number_format($kgmpercent,0, '.', '.') . '</td>';
//                    } else {
//                        echo '<td style="text-align:center;width:100px">' . number_format($kgmpercent, 2, '.', '.') . '</td>';
//                    }
//                    echo '<td style="text-align:center;width:100px">'. ($kgmpercent ).'</td>';
            echo '</tr>';
        }

        echo '</table>';
    }

    function get_budgetproperty_detail() {
        $year = $this->input->post('year');
        $property = $this->input->post('property');
        $dt_property = $this->ref_hotel_competitor_model->select_hotel_competitor_by_idhotelcompetitor($property);
        if ($property != '') {
            echo '<table class="dashboard" style="width: 500px">
                     <tr class="oddRow">
                        <td style="width: 100px;text-align: center" class="kolom">MONTH PERIOD</td>
                        <td style="width: 200px;text-align: center" class="kolom">ARR</td>
                        <td style="width: 200px;text-align: center" class="kolom">ROOM NIGHT</td>';
            $dt_budgetact = $this->hca_property_budget_model->select_budgetproperty_active_by_propertyyear($property, $year);
            if ($dt_budgetact->result() != NULL) {
                $status = $dt_budgetact->row(0)->budget_status;
                if ($status == 'Active') {
                    echo '<td style="width: 100px;text-align: center" class="kolom">STATUS<br/>[ ' . anchor('', 'Deactivated', 'id="deactivated"') . ' ]<input type="hidden" id="yearactivated" value="' . $year . '"/><input type="hidden" id="propertyactivated" value="' . $property . '"/></td>';
                } else {
                    echo '<td style="width: 100px;text-align: center" class="kolom">STATUS<br/>[ ' . anchor('', 'Activated', 'id="activated"') . ' ]<input type="hidden" id="yearactivated" value="' . $year . '"/><input type="hidden" id="propertyactivated" value="' . $property . '"/></td>';
                }
            } else {
                echo '<td style="width: 100px;text-align: center" class="kolom">STATUS</td>';
            }
            echo '</tr>';
            echo '<tr>
                    <td class="kolom" colspan="4" style="text-align: center"><b>' . $dt_property->hotelcompetitor_name . '</b></td>
                  </tr>';
            if ($dt_budgetact->result() != NULL) {
                foreach ($dt_budgetact->result() AS $rowba) {
                    echo '
                        <tr>
                            <td style="text-align:center" class="kolom">' . format_waktu2($rowba->budget_period) . '</td>
                            <td style="text-align:right" class="kolom">' . $rowba->arr . '</td>
                            <td style="text-align:center" class="kolom">' . $rowba->room_night . '</td>
                            <td style="text-align:center" class="kolom">' . $rowba->budget_status . '</td>
                        </tr>';
                }//endforeach budget
            } else {
                echo '<tr><td  style="text-align: center" colspan=4><b>Budget Not Available</b></td></tr>';
            }
            echo '</table>';
        } else {
            echo 'Please select hotel first.';
        }
    }

}

?>
