<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of account_model
 *
 * @author FTW
 */
class account_model extends Model {
    //put your code here
    function  __construct() {
        parent::Model();
    }

    function insert_account($data_accounts) {
        if( $this->db->insert('accounts',$data_accounts)) {
            return $this->db->insert_id();
        }
        else
            return FALSE;
    }

    function select_account() {
        $sql = 'SELECT
                  accounts.account_name,
                  accounts.office_phone,
                  accounts.fax_phone,
                  accounts.acct_email,
                  account_segment.nama_segment,
                  accounts.idaccount,
                  ref_industri.industri_name,
                  ref_city.NAMA_KOTA
                FROM
                  accounts
                  INNER JOIN account_segment ON (accounts.idcomseg_FK = account_segment.idcomseg)
                  INNER JOIN ref_industri ON (accounts.idindustri_FK = ref_industri.idindustri)
                  INNER JOIN ref_city ON (accounts.ID_KOTA_FK = ref_city.ID_KOTA)
                  INNER JOIN sales ON (accounts.idsales_FK = sales.idsales)
                ORDER BY
                  accounts.account_name
                ';
        return $this->db->query($sql);
    }

    
      
function select_accountsales_by_idcontact($idcontact){
    $sql = "SELECT
            accounts.idsales_FK
            FROM
            contacts
            Inner Join accounts ON contacts.idaccount_FK = accounts.idaccount
            WHERE 
            contacts.idcontacts = ?";
    return $this->db->query($sql,$idcontact)->row();
}
    
    
    function select_account_byuser($iduser) {
        $sql = 'SELECT
                  accounts.idaccount,
                  accounts.account_name
                FROM
                  accounts
                WHERE
                  accounts.idsales_FK = ?
                ORDER BY accounts.account_name ASC
                ';
//        $sql = 'SELECT
//                  accounts.idaccount,
//                  accounts.account_name
//                FROM
//                  contacts
//                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
//                  INNER JOIN sales ON (contacts.idsales_FK = sales.idsales)
//                WHERE
//                  accounts.idsales_FK = ?
//                ORDER BY accounts.account_name ASC
//                ';
        return $this->db->query($sql, $iduser);
    }

    function select_account_byuserproperty($iduser) {
        $sql1 = 'SELECT
                      user_acc.idproperty_FK
                    FROM
                      user_acc
                    WHERE
                      idstaff_FK = ?';
        $salesproperty = $this->db->query($sql1,$iduser)->row();

         $sql = 'SELECT
                  accounts.idaccount,
                  accounts.account_name
                FROM
                  accounts
                  INNER JOIN sales ON (accounts.idsales_FK = sales.idsales)
                  INNER JOIN user_acc ON (sales.idsales = user_acc.idstaff_FK)
                WHERE
                  user_acc.idproperty_FK = ?
                ORDER BY accounts.account_name ASC
                ';
 
        return $this->db->query($sql,$salesproperty->idproperty_FK);
    }


    function select_account_byidsales_pergroup($idsales)
    {
        $sql1 = 'SELECT
                  sales.id_salesgroupFK
                FROM
                  sales
                  WHERE idsales = ?';
        $salesgroup = $this->db->query($sql1,$idsales)->row();


        $sql = 'SELECT
                  accounts.idaccount,
                  accounts.account_name
                FROM
                  accounts
                  INNER JOIN sales ON (accounts.idsales_FK = sales.idsales)
                  INNER JOIN sales_group ON (sales.id_salesgroupFK = sales_group.idsalesgroup)
                WHERE
                  sales_group.idsalesgroup = ?';
        return $this->db->query($sql,$salesgroup->id_salesgroupFK);

    }
    
    function select_account_ervin_yoes_maya()
    {
          $sql = 'SELECT
                  accounts.idaccount,
                  accounts.account_name
                FROM
                  accounts
                  WHERE idsales_FK = 10 OR idsales_FK = 11 OR idsales_FK = 33';
          return $this->db->query($sql);
    }

     function select_account_byidsales_perproperty($idsales)
    {
       $sql1 = 'SELECT
                      user_acc.idproperty_FK
                    FROM
                      user_acc
                    WHERE
                      idstaff_FK = ?';
        $salesproperty = $this->db->query($sql1,$idsales)->row();


        $sql = 'SELECT
                  accounts.idaccount,
                  accounts.account_name
                FROM
                  accounts
                  INNER JOIN sales ON (accounts.idsales_FK = sales.idsales)
                  INNER JOIN user_acc ON (sales.idsales = user_acc.idstaff_FK)
                WHERE
                  user_acc.idproperty_FK = ?';
        return $this->db->query($sql,$salesproperty->idproperty_FK);

    }

    function select_account_by_kode($kode) {
        $sql = 'SELECT 	 *
				FROM
				  ref_city
				  INNER JOIN accounts ON (ref_city.ID_KOTA = accounts.ID_KOTA_FK)
				  INNER JOIN ref_industri ON (accounts.idindustri_FK = ref_industri.idindustri)
				  INNER JOIN ref_provience ON (accounts.KODE_PROP_FK = ref_provience.KODE_PROP)
				  INNER JOIN account_segment ON (accounts.idcomseg_FK = account_segment.idcomseg)
			        WHERE accounts.idaccount = ?
                 ';
        return $this->db->query($sql,$kode)->row();
    }

    function update_account($kode,$data) {
        $this->db->where('idaccount', $kode);
        $this->db->update('accounts', $data);
        return TRUE;
    }

    function get_offering_letter_by_account($idaccount) {
        $sql = 'SELECT
                  DISTINCT(offering_letter.offeringnumber),
                  offering_letter.letter_date,
                  offering_letter.event_name,
                  offering_letter.offering_status,
                  accounts.account_name,
                  sales.firstname as slsfirstname,
                  sales.lastname as slslastname,
                  offering_accounts.idsales_FK,
                  property.nama_prop,
                  event_type.nama_event
                FROM
                  offering_letter
                  INNER JOIN offering_accounts ON (offering_letter.offeringnumber = offering_accounts.offeringnumber_FK)
                  INNER JOIN contacts ON (offering_accounts.idcontacts_FK = contacts.idcontacts)
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                  INNER JOIN sales ON (offering_accounts.idsales_FK = sales.idsales)
                  INNER JOIN property ON (offering_letter.idproperty_FK = property.idproperty)
                  INNER JOIN event_type ON (offering_letter.ideventtype_FK = event_type.ideventtype)
                WHERE accounts.idaccount = ? AND offering_accounts.sales_type = "Sales" AND
                      offering_letter.offering_status="offering"
                ORDER BY offering_letter.letter_date DESC';
        return $this->db->query($sql,$idaccount);
    }

    function get_offering_letter_cancel_by_account($idaccount) {
        $sql = 'SELECT
                  DISTINCT(offering_letter.offeringnumber),
                  offering_letter.letter_date,
                  offering_letter.event_name,
                  offering_letter.offering_status,
                  accounts.account_name,
                  sales.firstname as slsfirstname,
                  sales.lastname as slslastname,
                  offering_accounts.idsales_FK,
                  property.nama_prop,
                  event_type.nama_event,
                  offering_letter.remark
                FROM
                  offering_letter
                  INNER JOIN offering_accounts ON (offering_letter.offeringnumber = offering_accounts.offeringnumber_FK)
                  INNER JOIN contacts ON (offering_accounts.idcontacts_FK = contacts.idcontacts)
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                  INNER JOIN sales ON (offering_accounts.idsales_FK = sales.idsales)
                  INNER JOIN property ON (offering_letter.idproperty_FK = property.idproperty)
                  INNER JOIN event_type ON (offering_letter.ideventtype_FK = event_type.ideventtype)
                WHERE accounts.idaccount = ? AND offering_accounts.sales_type = "Sales"
                      AND offering_letter.offering_status= "cancel"
                ORDER BY offering_letter.letter_date DESC';
        return $this->db->query($sql,$idaccount);
    }

    function get_confirm_letter_by_account($idaccount) {
        $sql = 'SELECT
                  DISTINCT(confirm_letter.confirmnumber),
                  accounts.account_name,
                  sales.firstname as slsfirstname,
                  sales.lastname as slslastname,
                  confirm_accounts.idsales_FK,
                  confirm_letter.event_name,
                  confirm_letter.letterconfirm_date,
                  property.nama_prop,
                  confirm_letter.offeringnumber_FK AS offeringnumber,
                  event_type.nama_event
                FROM
                  contacts
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                  INNER JOIN confirm_accounts ON (confirm_accounts.idcontacts_FK = contacts.idcontacts)
                  INNER JOIN confirm_letter ON (confirm_letter.confirmnumber = confirm_accounts.confirmnumber_FK)
                  INNER JOIN sales ON (confirm_accounts.idsales_FK = sales.idsales)
                  INNER JOIN property ON (confirm_letter.idproperty_FK = property.idproperty)
                  INNER JOIN event_type ON (confirm_letter.ideventtype_FK = event_type.ideventtype)
                WHERE accounts.idaccount = ? AND confirm_accounts.sales_type = "Sales" AND
                  confirm_letter.confirm_status <> "cancel"
                ORDER BY confirm_letter.letterconfirm_date DESC';
        return $this->db->query($sql,$idaccount);
    }

    function select_account_confirm($month,$year) {
//        $sql = 'SELECT
//                  accounts.idaccount,
//                  confirm_letter.checkin_date,
//                  accounts.account_name
//                FROM
//                  confirm_letter
//                  INNER JOIN confirm_accounts ON (confirm_letter.confirmnumber = confirm_accounts.confirmnumber_FK)
//                  INNER JOIN contacts ON (confirm_accounts.idcontacts_FK = contacts.idcontacts)
//                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
//                  WHERE MONTHNAME(confirm_letter.checkin_date) = "'.date('F').'" AND YEAR(confirm_letter.checkin_date) = '.date("Y").'
//                  GROUP BY accounts.idaccount';
        $sql = 'SELECT
                  accounts.idaccount,
                  confirm_letter.checkin_date,
                  accounts.account_name,
                  sales.firstname,
                  sales.initial
                FROM
                  confirm_letter
                  INNER JOIN confirm_accounts ON (confirm_letter.confirmnumber = confirm_accounts.confirmnumber_FK)
                  INNER JOIN contacts ON (confirm_accounts.idcontacts_FK = contacts.idcontacts)
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                  INNER JOIN sales ON (confirm_accounts.idsales_FK = sales.idsales)
                WHERE
                  MONTHNAME(confirm_letter.checkin_date) = ? AND YEAR(confirm_letter.checkin_date) = ? AND
                  confirm_accounts.sales_type = "Sales"
                  GROUP BY accounts.idaccount ORDER BY sales.firstname ASC';
        return $this->db->query($sql,array($month,$year));
    }

    function select_company_by_name($companyname) {
        $this->db->where('account_name',$companyname);
        return $this->db->get('accounts')->row();
    }

    function select_company_byletter($letter) {
        // $sql = "SELECT * FROM accounts ORDER BY idaccount LIMIT $start,$limit";
        $sql = "SELECT
  accounts.account_name,
  accounts.office_phone,
  accounts.fax_phone,
  accounts.acct_email,
  account_segment.nama_segment,
  accounts.idaccount,
  ref_industri.industri_name,
  ref_city.NAMA_KOTA,
  sales.firstname,
  sales.lastname
FROM
  accounts
  INNER JOIN account_segment ON (accounts.idcomseg_FK = account_segment.idcomseg)
  INNER JOIN ref_industri ON (accounts.idindustri_FK = ref_industri.idindustri)
  INNER JOIN ref_city ON (accounts.ID_KOTA_FK = ref_city.ID_KOTA)
  INNER JOIN sales ON (accounts.idsales_FK = sales.idsales)
                  WHERE accounts.account_name LIKE '".$letter."%'
                  ORDER BY accounts.account_name ASC
                 ";
        return $this->db->query($sql);
    }


    function select_company_byletterbyuser($letter,$idsales) {
        // $sql = "SELECT * FROM accounts ORDER BY idaccount LIMIT $start,$limit";
        $sql = "SELECT
                  accounts.account_name,
                  accounts.office_phone,
                  accounts.fax_phone,
                  accounts.acct_email,
                  account_segment.nama_segment,
                  accounts.idaccount,
                  ref_industri.industri_name,
                  ref_city.NAMA_KOTA
                FROM
                  accounts
                  INNER JOIN account_segment ON (accounts.idcomseg_FK = account_segment.idcomseg)
                  INNER JOIN ref_industri ON (accounts.idindustri_FK = ref_industri.idindustri)
                  INNER JOIN ref_city ON (accounts.ID_KOTA_FK = ref_city.ID_KOTA)
                  WHERE idsales_FK = $idsales AND accounts.account_name LIKE '".$letter."%'
                  GROUP BY accounts.idaccount
                  ORDER BY accounts.account_name ASC";

//SELECT
//                  contacts.firstname AS confirstname,
//                  contacts.lastname AS conlastname,
//                  accounts.account_name,
//                  contacts.birthday,
//                  sales.firstname AS slsfirstname,
//                  sales.lastname AS slslastname,
//                  ref_industri.industri_name,
//                  ref_city.NAMA_KOTA,
//                  contacts.idsales_FK,
//                  accounts.office_phone,
//                  accounts.fax_phone,
//                  accounts.idaccount,
//                  accounts.acct_email
//                FROM
//                  contacts
//                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
//                  INNER JOIN sales ON (contacts.idsales_FK = sales.idsales)
//                  INNER JOIN ref_industri ON (accounts.idindustri_FK = ref_industri.idindustri)
//                  INNER JOIN ref_city ON (accounts.ID_KOTA_FK = ref_city.ID_KOTA)
//                WHERE accounts.account_name LIKE '".$letter."%' AND accounts.idsales_FK = '".$idsales."'
//                GROUP BY accounts.idaccount ORDER BY accounts.account_name ASC


        return $this->db->query($sql);
    }


     function select_company_byletterbyusergroup($letter,$idsales) {
         $sql1 = 'SELECT
                  sales.id_salesgroupFK
                FROM
                  sales
                  WHERE idsales = ?';
        $salesgroup = $this->db->query($sql1,$idsales)->row();

         $sql = "SELECT
                  accounts.account_name,
                  accounts.office_phone,
                  accounts.fax_phone,
                  accounts.acct_email,
                  account_segment.nama_segment,
                  accounts.idaccount,
                  ref_industri.industri_name,
                  ref_city.NAMA_KOTA,
                  sales.firstname,
                  sales.lastname
                FROM
                  accounts
                  INNER JOIN account_segment ON (accounts.idcomseg_FK = account_segment.idcomseg)
                  INNER JOIN ref_industri ON (accounts.idindustri_FK = ref_industri.idindustri)
                  INNER JOIN ref_city ON (accounts.ID_KOTA_FK = ref_city.ID_KOTA)
                  INNER JOIN sales ON (accounts.idsales_FK = sales.idsales)
                  WHERE sales.id_salesgroupFK = ? AND accounts.account_name LIKE '".$letter."%'
                  GROUP BY accounts.idaccount
                  ORDER BY accounts.account_name ASC";
        return $this->db->query($sql,$salesgroup->id_salesgroupFK);
    }

    function select_company_byletterbyuserproperty($letter,$idsales) {
         $sql1 = 'SELECT
                      user_acc.idproperty_FK
                    FROM
                      user_acc
                    WHERE
                      idstaff_FK = ?';
        $salesproperty = $this->db->query($sql1,$idsales)->row();

         $sql = "SELECT
                  accounts.account_name,
                  accounts.office_phone,
                  accounts.fax_phone,
                  accounts.acct_email,
                  account_segment.nama_segment,
                  accounts.idaccount,
                  ref_industri.industri_name,
                  ref_city.NAMA_KOTA,
                  sales.firstname,
                  sales.lastname
                FROM
                  accounts
                  INNER JOIN account_segment ON (accounts.idcomseg_FK = account_segment.idcomseg)
                  INNER JOIN ref_industri ON (accounts.idindustri_FK = ref_industri.idindustri)
                  INNER JOIN ref_city ON (accounts.ID_KOTA_FK = ref_city.ID_KOTA)
                  INNER JOIN sales ON (accounts.idsales_FK = sales.idsales)
                  INNER JOIN user_acc ON (sales.idsales = user_acc.idstaff_FK)
                  WHERE user_acc.idproperty_FK = ? AND accounts.account_name LIKE '".$letter."%'
                  GROUP BY accounts.idaccount
                  ORDER BY accounts.account_name ASC";
        return $this->db->query($sql,$salesproperty->idproperty_FK);
    }


    function select_company_byletterbyuser_hendra($letter,$idsales) {
        // $sql = "SELECT * FROM accounts ORDER BY idaccount LIMIT $start,$limit";
        $sql = "SELECT
                  accounts.account_name,
                  accounts.office_phone,
                  accounts.fax_phone,
                  accounts.acct_email,
                  account_segment.nama_segment,
                  accounts.idaccount,
                  ref_industri.industri_name,
                  ref_city.NAMA_KOTA
                FROM
                  accounts
                  INNER JOIN account_segment ON (accounts.idcomseg_FK = account_segment.idcomseg)
                  INNER JOIN ref_industri ON (accounts.idindustri_FK = ref_industri.idindustri)
                  INNER JOIN ref_city ON (accounts.ID_KOTA_FK = ref_city.ID_KOTA)
                  WHERE accounts.account_name LIKE '".$letter."%' AND accounts.idsales_FK = '".$idsales."'
                  ORDER BY accounts.account_name ASC
                 ";
        return $this->db->query($sql);
    }

    function select_pagingcompany($start,$limit) {
        //$sql = "SELECT * FROM accounts ORDER BY idaccount LIMIT $start,$limit";
        $sql = "SELECT
                  accounts.account_name,
                  accounts.office_phone,
                  accounts.fax_phone,
                  accounts.acct_email,
                  account_segment.nama_segment,
                  accounts.idaccount,
                  ref_industri.industri_name,
                  ref_city.NAMA_KOTA,
                  sales.firstname,
                  sales.lastname
                FROM
                  accounts
                  INNER JOIN account_segment ON (accounts.idcomseg_FK = account_segment.idcomseg)
                  INNER JOIN ref_industri ON (accounts.idindustri_FK = ref_industri.idindustri)
                  INNER JOIN ref_city ON (accounts.ID_KOTA_FK = ref_city.ID_KOTA)
                  INNER JOIN sales ON (accounts.idsales_FK = sales.idsales)
                GROUP BY
                  accounts.idaccount
                ORDER BY
                  accounts.account_name
                  LIMIT $start,$limit";
        return $this->db->query($sql);
    }

    function select_pagingcompanybyuser($start,$limit,$iduser) {
        //$sql = "SELECT * FROM accounts ORDER BY idaccount WHERE idsales_FK = ".$iduser." LIMIT $start,$limit";
        $sql = "SELECT
                  accounts.account_name,
                  accounts.office_phone,
                  accounts.fax_phone,
                  accounts.acct_email,
                  account_segment.nama_segment,
                  accounts.idaccount,
                  ref_industri.industri_name,
                  ref_city.NAMA_KOTA
                FROM
                  accounts
                  INNER JOIN account_segment ON (accounts.idcomseg_FK = account_segment.idcomseg)
                  INNER JOIN ref_industri ON (accounts.idindustri_FK = ref_industri.idindustri)
                  INNER JOIN ref_city ON (accounts.ID_KOTA_FK = ref_city.ID_KOTA)
                  WHERE idsales_FK = $iduser
                  GROUP BY accounts.idaccount
                  ORDER BY accounts.account_name ASC
                  LIMIT $start,$limit";
        return $this->db->query($sql);
    }


    function select_pagingcompanybyusergroup($start,$limit,$iduser) {//New
        $sql1 = 'SELECT
                  sales.id_salesgroupFK
                FROM
                  sales
                  WHERE idsales = ?';
        $salesgroup = $this->db->query($sql1,$iduser)->row();
            $sql = "SELECT
                      accounts.account_name,
                      accounts.office_phone,
                      accounts.fax_phone,
                      accounts.acct_email,
                      account_segment.nama_segment,
                      accounts.idaccount,
                      ref_industri.industri_name,
                      ref_city.NAMA_KOTA,
                      sales.id_salesgroupFK,
                      sales.firstname,
                      sales.lastname
                    FROM
                      accounts
                      INNER JOIN account_segment ON (accounts.idcomseg_FK = account_segment.idcomseg)
                      INNER JOIN ref_industri ON (accounts.idindustri_FK = ref_industri.idindustri)
                      INNER JOIN ref_city ON (accounts.ID_KOTA_FK = ref_city.ID_KOTA)
                      INNER JOIN sales ON (accounts.idsales_FK = sales.idsales)
                      WHERE sales.`id_salesgroupFK` = ?
                    GROUP BY
                      accounts.idaccount
                    ORDER BY
                      accounts.account_name
                      LIMIT $start,$limit";
        return $this->db->query($sql,$salesgroup->id_salesgroupFK);
    }

    function select_pagingcompanybyuserproperty($start,$limit,$iduser) {//New
        $sql1 = 'SELECT
                      user_acc.idproperty_FK
                    FROM
                      user_acc
                    WHERE
                      idstaff_FK = ?';
        $salesproperty = $this->db->query($sql1,$iduser)->row();
            $sql = "SELECT
                      accounts.account_name,
                      accounts.office_phone,
                      accounts.fax_phone,
                      accounts.acct_email,
                      account_segment.nama_segment,
                      accounts.idaccount,
                      ref_industri.industri_name,
                      ref_city.NAMA_KOTA,
                      sales.id_salesgroupFK,
                      sales.firstname,
                      sales.lastname
                    FROM
                      accounts
                      INNER JOIN account_segment ON (accounts.idcomseg_FK = account_segment.idcomseg)
                      INNER JOIN ref_industri ON (accounts.idindustri_FK = ref_industri.idindustri)
                      INNER JOIN ref_city ON (accounts.ID_KOTA_FK = ref_city.ID_KOTA)
                      INNER JOIN sales ON (accounts.idsales_FK = sales.idsales)
                      INNER JOIN user_acc ON (sales.idsales = user_acc.idstaff_FK)
                      WHERE user_acc.`idproperty_FK` = ?
                    GROUP BY
                      accounts.idaccount
                    ORDER BY
                      accounts.account_name
                      LIMIT $start,$limit";
        return $this->db->query($sql,$salesproperty->idproperty_FK);
    }

    function select_pagingcompanybyuser_hendra($start,$limit,$iduser) {
        //$sql = "SELECT * FROM accounts ORDER BY idaccount WHERE idsales_FK = ".$iduser." LIMIT $start,$limit";
        $sql = "SELECT
                  contacts.firstname AS confirstname,
                  contacts.lastname AS conlastname,
                  accounts.account_name,
                  contacts.birthday,
                  sales.firstname AS slsfirstname,
                  sales.lastname AS slslastname,
                  ref_industri.industri_name,
                  ref_city.NAMA_KOTA,
                  contacts.idsales_FK,
                  accounts.office_phone,
                  accounts.fax_phone,
                  accounts.idaccount,
                  accounts.acct_email
                FROM
                  contacts
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                  INNER JOIN sales ON (contacts.idsales_FK = sales.idsales)
                  INNER JOIN ref_industri ON (accounts.idindustri_FK = ref_industri.idindustri)
                  INNER JOIN ref_city ON (accounts.ID_KOTA_FK = ref_city.ID_KOTA)
                WHERE
                  contacts.idsales_FK = $iduser
                ORDER BY accounts.account_name ASC
                LIMIT $start,$limit";
        return $this->db->query($sql);
    }


    function get_numcompany() {
        $sql = "SELECT COUNT(`accounts`.`idaccount`) AS total
                FROM
                  accounts
                  INNER JOIN sales ON (accounts.idsales_FK = sales.idsales)";
        //return $this->db->count_all('accounts');
        $query = $this->db->query($sql)->row();
        return $query->total;
    }

    function get_numcompany2() {
        $sql = "SELECT COUNT(`accounts`.`idaccount`) AS total
                FROM
                  accounts
                  ";
        //return $this->db->count_all('accounts');
        $query = $this->db->query($sql)->row();
        return $query->total;
    }


    function get_numcompanypersalesgroup($salesgroup) {
        $sql = "SELECT COUNT(`accounts`.`idaccount`) AS total
FROM
accounts
Inner Join sales ON accounts.idsales_FK = sales.idsales
WHERE
sales.id_salesgroupFK = $salesgroup


                  ";
        
        $query = $this->db->query($sql)->row();
        return $query->total;
    }


    function get_numcompany_byuser($iduser) {
        $sql = 'SELECT COUNT(idaccount) AS total FROM accounts WHERE idsales_FK = ? ';
        return $this->db->query($sql,$iduser)->row();
    }

    function get_numcompany_byusergroup($iduser) {
         $sql1 = 'SELECT
                  sales.id_salesgroupFK
                FROM
                  sales
                  WHERE idsales = ?';
        $salesgroup = $this->db->query($sql1,$iduser)->row();
        $sql = 'SELECT 
                  COUNT(idaccount) AS total
                FROM
                  accounts
                  INNER JOIN sales ON (accounts.idsales_FK = sales.idsales) WHERE id_salesgroupFK = ? ';
        return $this->db->query($sql,$salesgroup->id_salesgroupFK)->row();
    }

    function get_numcompany_byuserproperty($iduser) {
         $sql1 = 'SELECT
                      user_acc.idproperty_FK
                    FROM
                      user_acc
                    WHERE
                      idstaff_FK = ?';
        $salesproperty = $this->db->query($sql1,$iduser)->row();
        $sql = 'SELECT
                  COUNT(idaccount) AS total
                FROM
                  accounts
                  INNER JOIN sales ON (accounts.idsales_FK = sales.idsales)
                  INNER JOIN user_acc ON (sales.idsales = user_acc.idstaff_FK)
                  WHERE user_acc.`idproperty_FK` = ?';
        return $this->db->query($sql,$salesproperty->idproperty_FK)->row();
    }

    //updated 2 June 2010
    function select_suspect_account()
    {
        //company without activity
        $sql = 'SELECT  accounts.`idaccount`
                FROM `accounts`
                WHERE accounts.`idaccount` NOT IN (
                        SELECT  DISTINCT(`accounts`.`idaccount`)  AS idaccount
                        FROM
                        offering_accounts
                        INNER JOIN contacts ON (offering_accounts.idcontacts_FK = contacts.idcontacts)
                        INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                          ) AND accounts.`idaccount` NOT IN (SELECT   DISTINCT(`accounts`.`idaccount`)
                FROM
                  confirm_accounts
                  INNER JOIN contacts ON (confirm_accounts.idcontacts_FK = contacts.idcontacts)
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount))';
        return $this->db->query($sql);
    }

    function select_suspect_account_persalesgroup($salesgroup)
    {
        //company without activity
        $sql = "SELECT  accounts.`idaccount`, sales.firstname
                FROM `accounts`
                INNER JOIN sales ON sales.idsales = accounts.idsales_FK
                WHERE accounts.`idaccount` NOT IN (
                        SELECT  DISTINCT(`accounts`.`idaccount`)  AS idaccount
                        FROM
                        offering_accounts
                        INNER JOIN contacts ON (offering_accounts.idcontacts_FK = contacts.idcontacts)
                        INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                        ) AND accounts.`idaccount` NOT IN (SELECT   DISTINCT(`accounts`.`idaccount`)
                                                             FROM
                                                             confirm_accounts
                                                             INNER JOIN contacts ON (confirm_accounts.idcontacts_FK = contacts.idcontacts)
                                                             INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount))
                AND sales.id_salesgroupFK = $salesgroup";
        return $this->db->query($sql);
    }

    function select_prospect_account()
    {
        //company has offering
        $sql = 'SELECT  accounts.`idaccount`
                FROM `accounts`
                WHERE accounts.`idaccount` IN (
                        SELECT  DISTINCT(`accounts`.`idaccount`)  AS idaccount
                        FROM
                        offering_accounts
                        INNER JOIN contacts ON (offering_accounts.idcontacts_FK = contacts.idcontacts)
                        INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                          ) AND accounts.`idaccount` NOT IN (SELECT   DISTINCT(`accounts`.`idaccount`)
                FROM
                  confirm_accounts
                  INNER JOIN contacts ON (confirm_accounts.idcontacts_FK = contacts.idcontacts)
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount))';
        return $this->db->query($sql);
    }

    function select_prospect_accountpersalesgroup($salesgroup)
    {
        //company has offering
        $sql = "SELECT  accounts.`idaccount`
                FROM `accounts`
                INNER JOIN sales ON sales.idsales = accounts.idsales_FK
                WHERE accounts.`idaccount` IN (
                        SELECT  DISTINCT(`accounts`.`idaccount`)  AS idaccount
                        FROM
                        offering_accounts
                        INNER JOIN contacts ON (offering_accounts.idcontacts_FK = contacts.idcontacts)
                        INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                          ) AND accounts.`idaccount` NOT IN (SELECT   DISTINCT(`accounts`.`idaccount`)
                FROM
                  confirm_accounts
                  INNER JOIN contacts ON (confirm_accounts.idcontacts_FK = contacts.idcontacts)
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount))
               AND sales.id_salesgroupFK = $salesgroup";
        return $this->db->query($sql);
    }

    function select_client_account(){

        $sql = "SELECT  accounts.`idaccount`
                FROM `accounts`
                WHERE accounts.`idaccount` IN (
                        SELECT  DISTINCT(`accounts`.`idaccount`)  AS idaccount
                        FROM
                        offering_accounts
                        INNER JOIN contacts ON (offering_accounts.idcontacts_FK = contacts.idcontacts)
                        INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                          ) AND accounts.`idaccount` IN (SELECT   DISTINCT(`accounts`.`idaccount`)
                FROM
                  confirm_accounts
                  INNER JOIN contacts ON (confirm_accounts.idcontacts_FK = contacts.idcontacts)
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount))";

     
        return $this->db->query($sql);
    }

    function select_client_account_persalesgroup($salesgroup){

        $sql = "SELECT  accounts.`idaccount`
                FROM `accounts`
                INNER JOIN sales ON sales.idsales = accounts.idsales_FK
                WHERE accounts.`idaccount` IN (
                        SELECT  DISTINCT(`accounts`.`idaccount`)  AS idaccount
                        FROM
                        offering_accounts
                        INNER JOIN contacts ON (offering_accounts.idcontacts_FK = contacts.idcontacts)
                        INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                          ) AND accounts.`idaccount` IN (SELECT   DISTINCT(`accounts`.`idaccount`)
                FROM
                  confirm_accounts
                  INNER JOIN contacts ON (confirm_accounts.idcontacts_FK = contacts.idcontacts)
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount))
               AND sales.id_salesgroupFK = $salesgroup";


        return $this->db->query($sql);
    }




    function select_todays_account($date,$sales)
    {
        $sql = "SELECT COUNT(accounts.`idaccount`) AS Total
                FROM
                  accounts
                  WHERE DATE(accounts.`date_created`) = ? AND
                        accounts.`idsales_FK` = ?";
        return $this->db->query($sql,array($date,$sales))->row();
    }

    function select_currentmonth_account($month,$sales)
    {
        $sql = "SELECT COUNT(accounts.`idaccount`) AS Total
                FROM
                  accounts
                  WHERE MONTH(accounts.`date_created`) = ? AND
                        YEAR(accounts.`date_created`) = '".date('Y')."' AND
                        accounts.`idsales_FK` = ?";
        return $this->db->query($sql,array($month,$sales))->row();
    }

    function select_customerprofile()
    {
        $sql = "SELECT
                accounts.account_name,
                COUNT(accounts.idaccount) AS Total
                FROM
                confirm_accounts
                Inner Join contacts ON confirm_accounts.idcontacts_FK = contacts.idcontacts
                Inner Join accounts ON contacts.idaccount_FK = accounts.idaccount
                Inner Join confirm_letter ON confirm_letter.confirmnumber = confirm_accounts.confirmnumber_FK
                WHERE
                confirm_accounts.sales_type = 'Sales' AND
                (confirm_letter.confirm_status = 'Confirm' OR confirm_letter.confirm_status = 'Definit')
                GROUP BY
                accounts.idaccount
                ";

        return $this->db->query($sql);
    }


    function select_customerprofilepersalesgroup($salesgroup)
    {
        $sql = "SELECT
                accounts.account_name,
                COUNT(accounts.idaccount) AS Total
                FROM
                confirm_accounts
                Inner Join contacts ON confirm_accounts.idcontacts_FK = contacts.idcontacts
                Inner Join accounts ON contacts.idaccount_FK = accounts.idaccount
                Inner Join confirm_letter ON confirm_letter.confirmnumber = confirm_accounts.confirmnumber_FK
                WHERE
                confirm_accounts.sales_type = 'Sales' AND
                (confirm_letter.confirm_status = 'Confirm' OR confirm_letter.confirm_status = 'Definit') AND
                confirm_accounts.idsalesgroup_FK = $salesgroup
                GROUP BY
                accounts.idaccount
                ";

        return $this->db->query($sql);
    }



    //end updated 2 June 2010



    function select_accountactual_by_salesbetween($sales,$monthstart,$monthend,$year)
    {
        $sql = "SELECT COUNT(accounts.`idaccount`) AS Total
                FROM
                  accounts
                  WHERE accounts.`idsales_FK` = ? AND
                        MONTH(accounts.`date_created`) BETWEEN ? AND ? AND
                        YEAR(accounts.`date_created`) = ?
                ";
        return $this->db->query($sql,array($sales,$monthstart,$monthend,$year))->row();
    }

    function select_account_bysalesindustry($sales,$industry)
    {
        $sql= "SELECT
accounts.idaccount,
accounts.account_name,
accounts.office_phone,
accounts.fax_phone,
accounts.other_phone,
ref_city.NAMA_KOTA,
ref_industri.industri_name,
sales.firstname,
sales.lastname
FROM
accounts
Inner Join ref_city ON accounts.ID_KOTA_FK = ref_city.ID_KOTA
Inner Join ref_industri ON accounts.idindustri_FK = ref_industri.idindustri
Inner Join sales ON sales.idsales = accounts.idsales_FK
WHERE
accounts.idsales_FK = ? AND accounts.idindustri_FK = ?
ORDER BY accounts.account_name ASC
";
         return $this->db->query($sql,array($sales,$industry));
    }

     function select_account_bysales ($sales )
    {
        $sql= "SELECT
                accounts.idaccount,
                accounts.account_name,
                accounts.office_phone,
                accounts.fax_phone,
                accounts.other_phone,
                ref_city.NAMA_KOTA,
                ref_industri.industri_name,
                sales.firstname,
                sales.lastname
                FROM
                accounts
                Inner Join ref_city ON accounts.ID_KOTA_FK = ref_city.ID_KOTA
                Inner Join ref_industri ON accounts.idindustri_FK = ref_industri.idindustri
                Inner Join sales ON sales.idsales = accounts.idsales_FK
                WHERE
                accounts.idsales_FK = ?
                ORDER BY accounts.account_name ASC";
         return $this->db->query($sql,array($sales ));
    }

    function search_account_by_name($q){
        $sql = "SELECT
                    accounts.idaccount,
                    accounts.account_name
                FROM
                    accounts
                WHERE
                    accounts.account_name LIKE '".$q."%'
                ";
        return $this->db->query($sql);
    }
}
?>
