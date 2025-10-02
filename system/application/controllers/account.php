<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of account
 *
 * @author ftw
 */
class account extends Controller {
    //put your code here
    function  __construct() {
        parent::Controller();
        if (!$this->login_routine->is_login()) {
            redirect('login/');
        }
        $this->load->model('account_rate_model');
        $this->load->model('account_model');
        $this->load->model('account_segment_model');
        $this->load->model('katrate_model');
        $this->load->model('ref_industri_model');
        $this->load->model('ref_provience_model');
        $this->load->model('ref_city_model');
        $this->load->model('sales_model');
        $this->load->helper('date');
        $this->load->model('contact_model');
        $this->load->model('property_model');
    }

    function index() {
        $dt_hotel = $this->property_model->select_property();
        $dt_sales = $this->sales_model->select_sales();
        $data = array('accounton'=>'class="on"',
                'welcomeon'=>'',
                'documenton'=>'',
                'activitieson'=>'',
                'reporton'=>'',
                'ebookingon' => '',
                'setupon'=>'',
                'calendaron'=>'',
                'dt_sales'=>$dt_sales->result(),
                'dt_hotel'=>$dt_hotel->result());
        $this->load->view('account/index',$data);
    }
    
    function get_account_new() {
        $data['message'] = array();
        $q = $this->input->post('term');
        $dt_account = $this->account_model->select_company_byletter($q);
        foreach ($dt_account->result() AS $row) {
            $dataacc['label'] = $row->idaccount;
            $dataacc['value'] = $row->account_name;
            $data['message'][] = array("label" => $row->account_name, 'value' => $row->idaccount);
        }
        echo json_encode($data);
    }
    
    function get_contact() {
        $idcompany = $this->input->post('idcompany');
        $data_contact = $this->contact_model->select_contact_byaccount($idcompany);
        $index = 1;
        if ($data_contact->result() != null) {
            foreach ($data_contact->result() AS $row) {
                $index++;
                echo '<input type="radio" value="' . $row->idcontacts . '" name="contactpsn" style="cursor:pointer" id="' . $row->idcontacts . '" class="validate[required] radio contactperson">' . $row->salutation . ' ' . $row->firstname . ' ' . $row->lastname . '</input>';

                echo "<br/>";
            }
        } else {
            echo "<b>Contacts Not Available</b>";
        }
    }
    
    function get_contact_detail(){
        $idcontact = $this->input->post('idcontact');
        $dt_contact = $this->contact_model->select_contact_by_kode($idcontact);
        
        
      echo '{       "salutation" : "' . $dt_contact->salutation . '",
                    "firstname" : "' . $dt_contact->firstname . '",
                    "lastname" : "' . $dt_contact->lastname . '",
                    "title" : "' . $dt_contact->title . '",
                    "address" : "' . $dt_contact->address . '",
                    "phone" : "' . $dt_contact->phone_office . '",
                    "mobile" : "' . $dt_contact->mobile . '",
                    "fax" : "' . $dt_contact->phone_fax . '" ,
                    "salesfirstname" : "' . $dt_contact->salesfirstname . '",
                    "saleslastname" : "' . $dt_contact->saleslastname . '",
                    "salesposition" : "' . $dt_contact->nama_jab . '"     
                  }';
    }



    function search_account()
    {
        $data['message'] = array();
         $q =  $this->input->post('term');
        $dt_account = $this->account_model->select_company_byletter($q);
        foreach($dt_account->result() AS $row)
        {
            $dataacc['label'] = $row->idaccount;
            $dataacc['value'] = $row->account_name;
            $data['message'][]  = array("label"=>$row->account_name,'value'=>$row->idaccount);
            //array_push( $data,$dataacc);
            //array_push($data,$row->account_name);
        }

        echo json_encode($data);
    }

    function get_city() {
        $idpropinsi = $this->input->post('idpropinsi');
        $dt_kota = $this->ref_city_model->get_city_by_propinsi($idpropinsi);

        $option_kota_selected =  '-- Choose --';
        $option_kota[''] = "-- Choose --";
        if($dt_kota->result() != NULL) {
            foreach($dt_kota->result() as $row) {
                $option_kota[$row->ID_KOTA] = $row->NAMA_KOTA;
            }
        }else {
            $option_kota_selected = 'Data Not Available';
            $option_kota[''] = 'Data Not Available';
        }
        echo form_dropdown('kota',$option_kota,$option_kota_selected,'id="kota" class="validate[required]" style="width:250px"');

    }

    function get_city2() {
        $idpropinsi = $this->input->post('idpropinsi');
        $idkota = $this->input->post('idkota');
        $dt_kota = $this->ref_city_model->get_city_by_propinsi($idpropinsi);

        $option_kota_selected =  $idkota;
        $option_kota[''] = "Pilih";
        if($dt_kota->result() != NULL) {
            foreach($dt_kota->result() as $row) {
                $option_kota[$row->ID_KOTA] = $row->NAMA_KOTA;
            }
        }else {
            $option_kota_selected = 'Data Not Available';
            $option_kota['null'] = 'Data Not Available';
        }
        echo form_dropdown('kota',$option_kota,$option_kota_selected,'id="kota" class="validate[required]"');

    }

    function add_account() {
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
     
        // echo unix_to_human($now);unix_to_human($now, TRUE, 'eu');

        $data_account = array('idindustri_FK'=>$industri,
                'countriescode_FK'=>$country,
                'KODE_PROP_FK'=>$propinsi,
                'ID_KOTA_FK'=>$kota,
                'idsales_FK'=>$salescreated,
                'idcomseg_FK'=>$segment,
                'account_name'=>$companyname,
                'office_phone'=>$telp,
                'fax_phone'=>$fax,
                'other_phone'=>$otherphone,
                'acct_email'=>$email,
                'website'=>$website,
                'address'=>$alamat,
                'birthday'=>tanggal_php_to_mysql($birthday),
                'postal_code'=>$kode_pos,
                'description'=>$deskripsi,
                'parent'=>$member,
                'date_created'=>unix_to_human($now, TRUE, 'eu'),
                'ip_address'=>$this->input->ip_address()
        );

        if($salescreated == 0){
            echo "Error, please contact your administrator.";
        }else{
            $idacc = $this->account_model->insert_account($data_account);
            echo $idacc;
        }
        
    }

    function edit_account() {
        $idacc = $this->input->post('idaccount');
        $industri = $this->input->post('industri');
        //updated 15 June 2010
        $country = $this->input->post('country');
        //end update 15 June 2010
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
        $sales = $this->input->post('sales');
        $now = time();
        $data_account = array('idindustri_FK'=>$industri,
                'idsales_FK'=>$sales,
                'countriescode_FK'=>$country,
                'KODE_PROP_FK'=>$propinsi,
                'ID_KOTA_FK'=>$kota,
                'idcomseg_FK'=>$segment,
                'account_name'=>$companyname,
                'office_phone'=>$telp,
                'fax_phone'=>$fax,
                'other_phone'=>$otherphone,
                'acct_email'=>$email,
                'website'=>$website,
                'address'=>$alamat,
                'birthday'=>tanggal_php_to_mysql($birthday),
                'postal_code'=>$kode_pos,
                'description'=>$deskripsi,
                'parent'=>$member,
                'date_modified'=>unix_to_human($now, TRUE, 'eu'),
                'ip_address_modified'=>$this->input->ip_address()
        );
        $this->account_model->update_account($idacc,$data_account);
    }

    function load_data_account() {
        $data_account = $this->account_model->select_account();
        echo '<script type="text/javascript">
                    $("a[rel*=facebox]").facebox();
             </script>
            <table class="companytbl">';
        if(!$data_account->result() == NULL) {
            echo '  <thead>
                  <tr>
                    <th><strong>No.</strong></th>
                    <th><strong>Company Name</strong></th>
                    <th><strong>City</strong></th>
                    <th><strong>Phone</strong></th>
                    <th><strong>Email</strong></th>
                    <th><strong>Industri</strong></th>
                  </tr>
                </thead>';
        }
        else {
            echo '<div class="errorBox"><div class="errorBoxTop">&nbsp;</div>
                            <div class="msgBoxContent errorIcon">
                                <p>Data Belum Tersedia</p>
                            </div>
                        </div>';
        }

        $index = 1;
        foreach($data_account->result() as $row) {
            if($index%2 == 0) {
                $tr = '<tr class="oddRow">';
            }
            else {
                $tr = '<tr>';
            }
            echo $tr;
            echo'
                        <td class="kolom nomor">'. $index++.'</td>

                        <td class="kolom kolom25"><a href="'.site_url().'/account/details_account/'.$row->idaccount.'" id="'. $row->idaccount.'">'. $row->account_name .'</a></td>
                        <td class="kolom kolom15">'. $row->NAMA_KOTA .'</td>
                        <td class="kolom kolom15">'. $row->office_phone .'</td>
                        <td class="kolom kolom20">'. $row->acct_email .'</td>
                        <td class="kolom kolom15">'. $row->industri_name .'</td>
                    </tr>';

        }
        echo '</table>';
    }


    function details_account($idaccount) {
        $level = $this->session->userdata('level');
        $idsalesuser = $this->session->userdata('idstaff');

        $data_account = $this->account_model->select_account_by_kode($idaccount);
        $dt_offering = $this->account_model->get_offering_letter_by_account($idaccount);
        $dt_confirm = $this->account_model->get_confirm_letter_by_account($idaccount);
        $dt_offering_cancel = $this->account_model->get_offering_letter_cancel_by_account($idaccount);


        

        $data = array('idaccount'=>$idaccount,
                'account_name'=>$data_account->account_name,
                'office_phone'=>$data_account->office_phone,
                'fax_phone'=>$data_account->fax_phone,
                'acct_email'=>$data_account->acct_email,
                'website'=>$data_account->website,
                'address'=>$data_account->address,
                'postal_code'=>$data_account->postal_code,
                'description'=>$data_account->description,
                'NAMA_PROP'=>$data_account->NAMA_PROP,
                'NAMA_KOTA'=>$data_account->NAMA_KOTA,
                'postal_code'=>$data_account->postal_code,
                'nama_segment'=>$data_account->nama_segment,
                'description'=>$data_account->description,
                'industri_name'=>$data_account->industri_name,
                'other_phone'=>$data_account->other_phone,
                'dt_offering'=>$dt_offering->result(),
                'dt_offering_cancel'=>$dt_offering_cancel->result(),
                'dt_confirm'=>$dt_confirm->result()
        );
        $this->load->view('backend/sales/account/details_account',$data);
    }



    function get_account() {
        $level = $this->session->userdata('level');
        $idsalesuser = $this->session->userdata('idstaff');
        $property = $this->session->userdata('property');
        $holding = 'SH';
        switch ($level) {
            case 'Admin':
                $q = $_REQUEST['q'];
                if (!$q) return;
                if($property == $holding){
                    $data_account = $this->account_model->select_account();
                }else{
                    $data_account = $this->account_model->select_account_byidsales_perproperty($idsalesuser);
                }
                
                $items = '';
                if($data_account->result() != null) {
                    foreach($data_account->result() AS $row) {
                        $items[$row->account_name]  =  $row->idaccount;
                    }
                    foreach ($items as $key=>$value) {
                        if (strpos(strtolower($key), $q) !== false) {
                            echo "$key|$value\n";
                        }
                    }
                }
                break;
                case 'Manager':
                $q = $_REQUEST['q'];
                if (!$q) return;
                if($property == $holding){
                    $data_account = $this->account_model->select_account();
                }else{
                    $data_account = $this->account_model->select_account_byidsales_perproperty($idsalesuser);
                }
                
                $items = '';
                if($data_account->result() != null) {
                    foreach($data_account->result() AS $row) {
                        $items[$row->account_name]  =  $row->idaccount;
                    }
                    foreach ($items as $key=>$value) {
                        if (strpos(strtolower($key), $q) !== false) {
                            echo "$key|$value\n";
                        }
                    }
                }
                break;

            case 'Sales':
                $q = $_REQUEST['q'];
                if (!$q) return;
                //$data_account = $this->account_model->select_account_byuser($idsalesuser);
                $dt_sales = $this->sales_model->select_salesgroup($idsalesuser);
                if($dt_sales->id_salesgroupFK == 13){
$data_account = $this->account_model->select_account();
                }else{
                $data_account = $this->account_model->select_account_byidsales_pergroup($idsalesuser);
                }
                $items = '';
                if($data_account->result() != null) {
                    foreach($data_account->result() AS $row) {
                        $items[$row->account_name]  =  $row->idaccount;
                    }
                    foreach ($items as $key=>$value) {
                        if (strpos(strtolower($key), $q) !== false) {
                            echo "$key|$value\n";
                        }
                    }
                }
                break;

            default :
                echo "WHO R U???";
                break;
        }


    }


    function get_account_pergroup() {
        $level = $this->session->userdata('level');
        $idsalesuser = $this->session->userdata('idstaff');
        $dt_sales = $this->sales_model->select_person_by_id($idsalesuser);
        $salesgroupname = $dt_sales->nama_sg;
        $salesgroupid = $dt_sales->nama_sg;

        $q = $_REQUEST['q'];
        if (!$q) return;
        if($salesgroupname == "JSO" || $salesgroupname == "Administration" || $salesgroupname == "By Unit"){
            $data_account = $this->account_model->select_account();
        }else{
             if($idsalesuser == 10){
                  $data_account = $this->account_model->select_account_ervin_yoes_maya();
             }else{
                 $data_account = $this->account_model->select_account_byidsales_pergroup($idsalesuser);
             }
            
        }

        $items = '';
        if($data_account->result() != null) {
            foreach($data_account->result() AS $row) {
                $items[$row->account_name]  =  $row->idaccount;
            }
            
            foreach ($items as $key=>$value) {
                if (strpos(strtolower($key), $q) !== false) {
                    echo "$key|$value\n";
                }
            }
        }
    }



    function get_accountdetil() {
        $id = $this->input->post('idaccount');
        $dt_account = $this->account_model->select_account_by_kode($id);

        echo   '{"officephone":"'.$dt_account->office_phone.'",
                 "fax" : "'.$dt_account->fax_phone.'",
                 "address" : "'.$dt_account->address.'",
                 "postalcode" : "'.$dt_account->postal_code.'",
                 "kodeprop" : "'.$dt_account->KODE_PROP_FK.'",
                 "kodekota" : "'.$dt_account->ID_KOTA_FK.'"
                }';
    }



     function validate_company_name()
    {
        /* RECEIVE VALUE */
        $validateValue=$_POST['validateValue'];
        $validateId=$_POST['validateId'];
        $validateError=$_POST['validateError'];

	/* RETURN VALUE */
	$arrayToJs = array();
	$arrayToJs[0] = $validateId;
	$arrayToJs[1] = $validateError;
        $x = $this->account_model->select_company_by_name($validateValue);

         if($x == NULL){
            $arrayToJs[2] = "true";			// RETURN TRUE
            echo '{"jsonValidateReturn":'.json_encode($arrayToJs).'}';			// RETURN ARRAY WITH success
        }else{
            for($x=0;$x<1000000;$x++){
		if($x == 990000){
			$arrayToJs[2] = "false";
			echo '{"jsonValidateReturn":'.json_encode($arrayToJs).'}';		// RETURN ARRAY WITH ERROR
		}
            }
        }
    }


}
?>
