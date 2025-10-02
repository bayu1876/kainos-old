<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of sales_model
 *
 * @author FTW
 */
class sales_model extends Model {
    //put your code here
    function  __construct() {
        parent::Model();
    }

    function add_sales($data_person) {
        if($this->db->insert('sales',$data_person))
            return $this->db->insert_id();
        else
            return FALSE;
    }

    function get_sales_by_segment() {
        $sql = 'SELECT sales.firstname,sales.id_salesgroupFK,sales.initial
                FROM sales_group
                  INNER JOIN sales ON (sales_group.idsalesgroup = sales.id_salesgroupFK)
                WHERE
                  sales.id_salesgroupFK <> 6
                ORDER BY sales.id_salesgroupFK,sales.id_jabatanFK';
        return $this->db->query($sql);
    }

    function select_salesbygrouponly($idgroup)
    {
        if($idgroup != ''){
            $sql = "SELECT *
                    FROM
                      sales
                    WHERE
                      sales.`id_salesgroupFK` = ? AND
                      sales.slsstatus = 'Active'";
        }else{
            $sql = "SELECT *
                    FROM
                      sales
                    WHERE sales.slsstatus = 'Active'";
        }
        
        return $this->db->query($sql,$idgroup);
    }
    
    
    function select_salesbygroup_perproperty($idgroup, $property) {
        if ($idgroup != '') {
            $sql = "SELECT *
                    FROM
                    sales
                    Inner Join user_acc ON sales.idsales = user_acc.idstaff_FK
                    WHERE
                      sales.`id_salesgroupFK` =? AND
                      sales.slsstatus = 'Active' AND 
                    user_acc.idproperty_FK = ? AND user_acc.`level` = 'Sales'
                    ";
        } else {
            $sql = "SELECT *
                    FROM
                      sales
                    WHERE sales.slsstatus = 'Active'";
        }

        return $this->db->query($sql, array($idgroup, $property));
    }

    function select_sales() {
        $sql = 'SELECT
                  s.idsales AS id,
                  s.nama_sls,
                  s.telp1_sls AS telp1,
                  s.telp2_sls AS telp2,
                  s.email_sls AS email,
                  sg.nama_sg AS sgroup,
                  p.nama_jab AS pos,
                  s.firstname,
                  s.lastname,
                  s.id_salesgroupFK
                    FROM
                    sales AS s
                    Inner Join sales_group AS sg ON (s.id_salesgroupFK = sg.idsalesgroup)
                    Inner Join ref_jabatan AS p ON (s.id_jabatanFK = p.idjabatan)
                    Inner Join user_acc ON s.idsales = user_acc.idstaff_FK
                    WHERE (sg.nama_sg <> "Administration" AND s.slsstatus = "Active")
                                            AND user_acc.`level` = "Sales"
                    ORDER BY
                  s.firstname
                 ';
         
        return $this->db->query($sql);
    }
    
     function select_sales_new() {
        $sql = 'SELECT
                  s.idsales AS id,
                  s.nama_sls,
                  s.telp1_sls AS telp1,
                  s.telp2_sls AS telp2,
                  s.email_sls AS email,
                  sg.nama_sg AS sgroup,
                  p.nama_jab AS pos,
                  s.firstname,
                  s.lastname,
                  s.id_salesgroupFK
                    FROM
                    sales AS s
                    Inner Join sales_group AS sg ON (s.id_salesgroupFK = sg.idsalesgroup)
                    Inner Join ref_jabatan AS p ON (s.id_jabatanFK = p.idjabatan)
                    Inner Join user_acc ON s.idsales = user_acc.idstaff_FK
                    WHERE  p.nama_jab <> "Administrator" 
                    ORDER BY
                  s.firstname
                  
                 ';
         
        return $this->db->query($sql);
    }


    function select_sales3() {
        $sql = 'SELECT
                  *
FROM
sales AS s
Inner Join sales_group AS sg ON (s.id_salesgroupFK = sg.idsalesgroup)
Inner Join ref_jabatan AS p ON (s.id_jabatanFK = p.idjabatan)
Inner Join user_acc ON s.idsales = user_acc.idstaff_FK
WHERE (sg.nama_sg <> "Administration" AND s.slsstatus = "Active")
			AND user_acc.`level` = "Sales"
ORDER BY
                  s.firstname

                 ';

        return $this->db->query($sql);
    }


    function select_sales_nonunit() {
        $sql = 'SELECT
                  s.idsales AS id,
                  s.nama_sls,
                  s.telp1_sls AS telp1,
                  s.telp2_sls AS telp2,
                  s.email_sls AS email,
                  sg.nama_sg AS sgroup,
                  p.nama_jab AS pos,
                  s.firstname,
                  s.lastname,
                  s.id_salesgroupFK
                FROM
                    sales AS s
                    Inner Join sales_group AS sg ON (s.id_salesgroupFK = sg.idsalesgroup)
                    Inner Join ref_jabatan AS p ON (s.id_jabatanFK = p.idjabatan)
                    Inner Join user_acc ON s.idsales = user_acc.idstaff_FK
                WHERE (sg.nama_sg <> "Administration" OR sg.nama_sg <> "By Unit") AND s.slsstatus = "Active") AND user_acc.`level` = "Sales"
                ORDER BY s.firstname';

        return $this->db->query($sql);
    }


    function select_sales_admin() {
        $sql = 'SELECT
                  s.idsales AS id,

                  s.nama_sls,
                  s.telp1_sls AS telp1,
                  s.telp2_sls AS telp2,
                  s.email_sls AS email,
                  sg.nama_sg AS sgroup,
                  p.nama_jab AS pos,
                  s.firstname,
                  s.lastname,
                  s.id_salesgroupFK
                FROM
                  sales s
                  INNER JOIN sales_group sg ON (s.id_salesgroupFK = sg.idsalesgroup)
                  INNER JOIN ref_jabatan p ON (s.id_jabatanFK = p.idjabatan)
                WHERE (sg.nama_sg = "Administration" AND s.slsstatus = "Active")
                ORDER BY
                  s.firstname
                 ';

        return $this->db->query($sql);
    }

    function select_sales_byidsales($idsales) {
        $sql = 'SELECT
                  s.idsales AS id,
                  s.nama_sls,
                  s.telp1_sls AS telp1,
                  s.telp2_sls AS telp2,
                  s.email_sls AS email,
                  sg.nama_sg AS sgroup,
                  p.nama_jab AS pos,
                  s.firstname,
                  s.lastname
                FROM
                  sales s
                  INNER JOIN sales_group sg ON (s.id_salesgroupFK = sg.idsalesgroup)
                  INNER JOIN ref_jabatan p ON (s.id_jabatanFK = p.idjabatan)
                WHERE sg.nama_sg <> "Administration" AND s.slsstatus = "Active" AND s.idsales = ?
                ORDER BY
                  s.firstname
                 ';
        return $this->db->query($sql,$idsales);
    }

    function select_sales2() {
        $sql = 'SELECT
                  s.idsales AS id,
                  s.nama_sls,
                  s.telp1_sls AS telp1,
                  s.telp2_sls AS telp2,
                  s.email_sls AS email,
                  s.firstname,
                  s.lastname
                FROM
                  sales s
                ORDER BY
                  s.firstname ASC
                 ';
        return $this->db->query($sql);
    }

    function select_person_by_id($id) {
        $sql = 'SELECT *
                FROM sales AS s
                JOIN sales_group AS sg
                ON s.id_salesgroupFK = sg.idsalesgroup
                JOIN ref_jabatan AS p
                ON s.id_jabatanFK = p.idjabatan
                WHERE s.idsales = ?
                ORDER BY s.idsales ASC
                  ';
        return $this->db->query($sql,$id)->row();
    }

    function select_sales_bycontactperson($id) {
        $sql = 'SELECT *
                    FROM
                      sales AS s
                      INNER JOIN contacts ON (s.idsales = contacts.idsales_FK)
                      WHERE `contacts`.`idcontacts` = ?';
        return $this->db->query($sql,$id)->row();
    }

    function select_person_by_group($group,$sales) {
        $sql = 'SELECT s.idsales AS id,s.nama_sls AS nama_sls,s.telp1_sls AS telp1,telp2_sls AS telp2,email_sls AS email,  sg.idsalesgroup AS id_sg, sg.nama_sg AS sgroup, p.idjabatan AS id_pos,p.nama_jab AS pos
                FROM sales AS s
                JOIN sales_group AS sg
                ON s.id_salesgroupFK = sg.idsalesgroup
                JOIN jabatan AS p
                ON s.id_jabatanFK = p.idjabatan
                WHERE s.id_salesgroupFK = ? AND s.idsales <> '.$sales.'
                ORDER BY s.idsales ASC
                  ';
        return $this->db->query($sql,$group) ;
    }

    function select_salesbygroup($idgroup,$idsales) {
        $sql = 'SELECT *
                FROM sales
                WHERE id_salesgroupFK = ? AND idsales <> ?';
        return $this->db->query($sql,array($idgroup,$idsales));
    }

    function select_salesgroup($idsales) {
        $sql = 'SELECT id_salesgroupFK,nama_jab,nama_sg,idsalesunit_FK
                FROM sales AS sls
                JOIN sales_group AS sg
                ON sg.idsalesgroup = sls.id_salesgroupFK
                JOIN ref_jabatan AS jab
                ON jab.idjabatan = sls.id_jabatanFK
                WHERE sls.idsales = ?';
        return $this->db->query($sql,$idsales)->row();
    }

    function select_salespergroup($sales) {
        $sql1 = 'SELECT id_salesgroupFK
                FROM sales AS sls
                JOIN sales_group AS sg
                ON sg.idsalesgroup = sls.id_salesgroupFK
                WHERE sls.idsales = ?';
        $salesgroup =  $this->db->query($sql1,$sales)->row();

        $sql = 'SELECT
                  s.firstname,
                  s.lastname,
                  s.idsales,
                  s.idsales AS id

                FROM
                  sales s
                  INNER JOIN sales_group sg ON (s.id_salesgroupFK = sg.idsalesgroup)
                WHERE s.id_salesgroupFK = ?  AND s.slsstatus = "Active"
                ORDER BY s.idsales ASC
                  ';
        return $this->db->query($sql,$salesgroup->id_salesgroupFK) ;
    }
    
    
    function select_salespergroup_unit($sales) {
        $sql1 = 'SELECT id_salesgroupFK,idsalesunit_FK
                FROM sales AS sls
                JOIN sales_group AS sg
                ON sg.idsalesgroup = sls.id_salesgroupFK
                WHERE sls.idsales = ?';
        $salesgroup =  $this->db->query($sql1,$sales)->row();

        $sql = 'SELECT
                  s.firstname,
                  s.lastname,
                  s.idsales,
                  s.idsales AS id
FROM
sales AS s
Inner Join sales_group AS sg ON (s.id_salesgroupFK = sg.idsalesgroup)
Inner Join user_acc ON s.idsales = user_acc.idstaff_FK
WHERE
s.id_salesgroupFK = ? AND
s.slsstatus = "Active" AND
s.idsalesunit_FK = ? AND
user_acc.`level` = "Sales"
ORDER BY s.idsales ASC

                  ';
        return $this->db->query($sql,array($salesgroup->id_salesgroupFK,$salesgroup->idsalesunit_FK) );
    }

    //updated 21June2010
    function select_salespergroupunit($sales) {
        $sql1 = 'SELECT
                  sls.id_salesgroupFK,
                  sls.idsalesunit_FK
                FROM
                  sales sls
                  INNER JOIN sales_group sg ON (sg.idsalesgroup = sls.id_salesgroupFK)
                  INNER JOIN sales_unit ON (sls.idsalesunit_FK = sales_unit.idsalesunit)
                WHERE sls.idsales = ?';
        $salesgroup =  $this->db->query($sql1,$sales)->row();

        $sql = 'SELECT
                  s.firstname,
                  s.lastname,
                  s.idsales
                FROM
                  sales s
                  INNER JOIN sales_group sg ON (s.id_salesgroupFK = sg.idsalesgroup)
                  INNER JOIN sales_unit ON (s.idsalesunit_FK = sales_unit.idsalesunit)
                WHERE s.id_salesgroupFK = ? AND s.idsalesunit_FK = ?
                ORDER BY s.idsales ASC
                  ';
        return $this->db->query($sql,array($salesgroup->id_salesgroupFK,$salesgroup->idsalesunit_FK)) ;
    }
    //end updated 21June2010

    function update_person($id,$data) {
        $this->db->where('idsales', $id);
        $this->db->update('sales', $data);
        return TRUE;
    }

    //add by koeznandar

    function get_salesofferingaccounts_by_offering($number) {
        $sql = 'SELECT sa.nama_sls AS namasales,sa.telp1_sls,sa.telp2_sls,sa.email_sls
                FROM sales AS sa
                JOIN offering_accounts oa
                ON sa.idsales = oa.idsales_FK
                WHERE oa.offeringnumber_FK = ?
                GROUP BY sa.idsales';
        return $this->db->query($sql,$number) ;
    }

    function get_offering_letter_by_sales($idsales) {
        $sql = 'SELECT DISTINCT(offering_letter.offeringnumber),
                  accounts.account_name,
                  sales.firstname AS slsfirstname,
                  sales.lastname AS slslastname,
                  offering_letter.event_name,
                  offering_letter.letter_date,
                  offering_letter.checkin_date,
                  offering_letter.idproperty_FK,
                  offering_letter.offering_status,
                  property.nama_prop,
                  offering_accounts.sales_type,
                  event_type.nama_event,
                  contacts.firstname as confirstname,
                  contacts.lastname as conlastname,
                  contacts.idcontacts,
                  accounts.idaccount
                FROM
                  contacts
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                  INNER JOIN offering_accounts ON (offering_accounts.idcontacts_FK = contacts.idcontacts)
                  INNER JOIN offering_letter ON (offering_letter.offeringnumber = offering_accounts.offeringnumber_FK)
                  INNER JOIN sales ON (offering_accounts.idsales_FK = sales.idsales)
                  INNER JOIN property ON (offering_letter.idproperty_FK = property.idproperty)
                  INNER JOIN event_type ON (offering_letter.ideventtype_FK = event_type.ideventtype)
                WHERE
                  offering_accounts.idsales_FK = ? AND
                  offering_accounts.sales_type="Sales"  AND
                  YEAR(offering_letter.checkin_date) = YEAR(NOW()) AND
                  MONTH(offering_letter.checkin_date) = MONTH(NOW())
                  ORDER BY offering_letter.checkin_date ASC';
        return $this->db->query($sql,$idsales);
    }


    function get_offering_letter_by_salesmonthyear($idsales,$monthname,$year) {
        $sql = 'SELECT DISTINCT(offering_letter.offeringnumber),
                  accounts.account_name,
                  sales.firstname AS slsfirstname,
                  sales.lastname AS slslastname,
                  offering_letter.event_name,
                  offering_letter.letter_date,
                  offering_letter.checkin_date,
                  offering_letter.idproperty_FK,
                  offering_letter.offering_status,
                  property.nama_prop,
                  offering_accounts.sales_type,
                  event_type.nama_event,
                  contacts.firstname as confirstname,
                  contacts.lastname as conlastname,
                  contacts.idcontacts,
                  accounts.idaccount
                FROM
                  contacts
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                  INNER JOIN offering_accounts ON (offering_accounts.idcontacts_FK = contacts.idcontacts)
                  INNER JOIN offering_letter ON (offering_letter.offeringnumber = offering_accounts.offeringnumber_FK)
                  INNER JOIN sales ON (offering_accounts.idsales_FK = sales.idsales)
                  INNER JOIN property ON (offering_letter.idproperty_FK = property.idproperty)
                  INNER JOIN event_type ON (offering_letter.ideventtype_FK = event_type.ideventtype)
                WHERE
                  offering_accounts.idsales_FK = ? AND
                  offering_accounts.sales_type = "Sales" AND
                  MONTHNAME(offering_letter.checkin_date) = ? AND
                  YEAR(offering_letter.checkin_date) = ?
                  ORDER BY offering_letter.checkin_date ASC';
        return $this->db->query($sql,array($idsales,$monthname,$year));
    }

    function get_confirm_letter_by_sales($idsales) {
        $sql = 'SELECT
                  DISTINCT(confirm_letter.confirmnumber),
                  accounts.account_name,
                  sales.nama_sls,
                  confirm_letter.event_name,
                  confirm_letter.letterconfirm_date,
                  confirm_letter.checkin_date,
                  property.nama_prop,
                  confirm_letter.offeringnumber_FK AS offeringnumber,
                  event_type.nama_event,
                  contacts.firstname as confirstname,
                  contacts.lastname as conlastname,
                  contacts.idcontacts,
                  accounts.idaccount
                FROM
                  contacts
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                  INNER JOIN confirm_accounts ON (confirm_accounts.idcontacts_FK = contacts.idcontacts)
                  INNER JOIN confirm_letter ON (confirm_letter.confirmnumber = confirm_accounts.confirmnumber_FK)
                  INNER JOIN sales ON (confirm_accounts.idsales_FK = sales.idsales)
                  INNER JOIN property ON (confirm_letter.idproperty_FK = property.idproperty)
                  INNER JOIN event_type ON (confirm_letter.ideventtype_FK = event_type.ideventtype)
                WHERE confirm_accounts.sales_type = "Sales" AND
                    confirm_accounts.idsales_FK = ? AND
                    YEAR(confirm_letter.checkin_date) = YEAR(NOW()) AND
                    MONTH(confirm_letter.checkin_date) = MONTH(NOW())
                ORDER BY confirm_letter.checkin_date ASC';
        return $this->db->query($sql,$idsales);
    }

    function get_confirm_letter_by_salesmonthyear($sales,$monthname,$year) {
        $sql = 'SELECT
                  DISTINCT(confirm_letter.confirmnumber),
                  accounts.account_name,
                  sales.firstname AS slsfirstname,
                  sales.lastname AS slslastname,
                  confirm_letter.event_name,
                  confirm_letter.letterconfirm_date,
                  confirm_letter.checkin_date,
                  property.nama_prop,
                  confirm_letter.offeringnumber_FK AS offeringnumber,
                  event_type.nama_event,
                  contacts.firstname as confirstname,
                  contacts.lastname as conlastname,
                  contacts.idcontacts,
                  accounts.idaccount
                FROM
                  contacts
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                  INNER JOIN confirm_accounts ON (confirm_accounts.idcontacts_FK = contacts.idcontacts)
                  INNER JOIN confirm_letter ON (confirm_letter.confirmnumber = confirm_accounts.confirmnumber_FK)
                  INNER JOIN sales ON (confirm_accounts.idsales_FK = sales.idsales)
                  INNER JOIN property ON (confirm_letter.idproperty_FK = property.idproperty)
                  INNER JOIN event_type ON (confirm_letter.ideventtype_FK = event_type.ideventtype)
                WHERE confirm_accounts.sales_type = "Sales" AND
                    confirm_accounts.idsales_FK = ? AND
                    MONTHNAME(confirm_letter.checkin_date) = ? AND
                    YEAR(confirm_letter.checkin_date) = ?
                ORDER BY confirm_letter.checkin_date ASC';
        return $this->db->query($sql,array($sales,$monthname,$year));
    }

    function get_offering_letter_cancel_by_sales($idsales) {
        $sql = 'SELECT DISTINCT(offering_letter.offeringnumber),
                  accounts.account_name,
                  sales.nama_sls,
                  offering_letter.event_name,
                  offering_letter.letter_date,
                  offering_letter.checkin_date,
                  property.nama_prop,
                  offering_accounts.sales_type,
                  event_type.nama_event,
                  contacts.firstname as confirstname,
                  contacts.lastname as conlastname,
                  contacts.idcontacts,
                  offering_letter.remark,
                  accounts.idaccount
                FROM
                  contacts
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                  INNER JOIN offering_accounts ON (offering_accounts.idcontacts_FK = contacts.idcontacts)
                  INNER JOIN offering_letter ON (offering_letter.offeringnumber = offering_accounts.offeringnumber_FK)
                  INNER JOIN sales ON (offering_accounts.idsales_FK = sales.idsales)
                  INNER JOIN property ON (offering_letter.idproperty_FK = property.idproperty)
                  INNER JOIN event_type ON (offering_letter.ideventtype_FK = event_type.ideventtype)
                WHERE
                  offering_accounts.idsales_FK = ? AND
                  offering_letter.offering_status = "cancel" AND
                  offering_accounts.sales_type="Sales" AND
                  YEAR(offering_letter.checkin_date) = YEAR(NOW()) AND
                  MONTH(offering_letter.checkin_date) = MONTH(NOW())
                  ORDER BY offering_letter.checkin_date ASC';
        return $this->db->query($sql,$idsales);
    }

    function get_offeringcancel_by_salesmonthyear($sales,$monthname,$year) {
        $sql = 'SELECT DISTINCT(offering_letter.offeringnumber),
                  accounts.account_name,
                  sales.firstname AS slsfirstname,
                  sales.lastname AS slslastname,
                  offering_letter.event_name,
                  offering_letter.letter_date,
                  offering_letter.checkin_date,
                  property.nama_prop,
                  offering_accounts.sales_type,
                  event_type.nama_event,
                  contacts.firstname as confirstname,
                  contacts.lastname as conlastname,
                  contacts.idcontacts,
                  offering_letter.remark,
                  accounts.idaccount
                FROM
                  contacts
                  INNER JOIN accounts ON (contacts.idaccount_FK = accounts.idaccount)
                  INNER JOIN offering_accounts ON (offering_accounts.idcontacts_FK = contacts.idcontacts)
                  INNER JOIN offering_letter ON (offering_letter.offeringnumber = offering_accounts.offeringnumber_FK)
                  INNER JOIN sales ON (offering_accounts.idsales_FK = sales.idsales)
                  INNER JOIN property ON (offering_letter.idproperty_FK = property.idproperty)
                  INNER JOIN event_type ON (offering_letter.ideventtype_FK = event_type.ideventtype)
                WHERE
                  offering_accounts.idsales_FK = ? AND
                  offering_letter.offering_status = "cancel" AND
                  offering_accounts.sales_type="Sales" AND
                  MONTHNAME(offering_letter.checkin_date) = ? AND
                  YEAR(offering_letter.checkin_date) = ?  
                  ORDER BY offering_letter.checkin_date ASC';
        return $this->db->query($sql,array($sales,$monthname,$year));
    }

    function select_salestarget() {
        $startthismonth = date('Y-m-d');
        $endthismonth = date('Y-m-d');

        $sql ='SELECT *
                FROM sales_target_person AS stp
                RIGHT JOIN  (SELECT * FROM `sales` WHERE `sales`.`slsstatus` = "Active") AS s
                ON s.idsales = stp.idsales_FK
                JOIN sales_group AS sg
                ON sg.idsalesgroup = s.id_salesgroupFK
                JOIN user_acc
                ON user_acc.idstaff_FK = s.idsales
                WHERE  IFNULL(Month(stp.bulan),0)  = "'.date('m').'" OR
                       IFNULL(Month(stp.bulan),0)  = 0 AND
                       (sg.nama_sg <> "Property" AND
                       sg.nama_sg <> "Administration" AND
                       user_acc.`level` <> "Admin")
                GROUP BY s.idsales
                ORDER BY s.id_salesgroupFK,s.id_jabatanFK';
        return $this->db->query($sql);
    }

    function select_salestarget2() {
       
        $sql ='SELECT *
                FROM sales_target_person AS stp
                RIGHT JOIN  (SELECT * FROM `sales` WHERE `sales`.`slsstatus` = "Active") AS s
                ON s.idsales = stp.idsales_FK
                JOIN sales_group AS sg
                ON sg.idsalesgroup = s.id_salesgroupFK
                JOIN user_acc
                ON user_acc.idstaff_FK = s.idsales
                WHERE  IFNULL(Month(stp.bulan),0)  = "'.date('m').'" OR
                       IFNULL(Month(stp.bulan),0)  = 0 AND
                       (sg.nama_sg <> "Property" AND
                       sg.nama_sg <> "Administration" AND
                       user_acc.`level` <> "Admin" AND
                       s.id_jabatanFK <> 37)
                GROUP BY s.idsales
                ORDER BY s.id_salesgroupFK,s.id_jabatanFK';
        return $this->db->query($sql);
    }
    
    
    
    function select_salesonly_new(){
        $sql = 'SELECT sales.idsales, 
	sales.idsalesunit_FK, 
	sales.id_salesgroupFK, 
	sales.id_jabatanFK, 
	sales.KODE_PROP_FK, 
	sales.ID_KOTA_FK, 
	sales.firstname, 
	sales.lastname, 
	sales.initial, 
	sales.nama_sls, 
	sales.telp1_sls, 
	sales.telp2_sls, 
	sales.fax, 
	sales.email_sls, 
	sales.otheremail, 
	sales.address, 
	sales.postalcode, 
	sales.birthday, 
	sales.slsstatus, 
	sales.photofilename, 
	sales.photofilepath, 
	sales.signaturefilename, 
	sales.signaturefilepath, 
	sales_group.nama_sg, 
	ref_jabatan.nama_jab
FROM sales INNER JOIN sales_group ON sales.id_salesgroupFK = sales_group.idsalesgroup
	 INNER JOIN user_acc ON sales.idsales = user_acc.idstaff_FK
	 INNER JOIN ref_jabatan ON sales.id_jabatanFK = ref_jabatan.idjabatan
WHERE slsstatus = "Active" AND nama_sg <> "Administration" AND level <> "Admin" AND nama_jab NOT LIKE "%Director of Sales%"';
        return $this->db->query($sql);
    }
    
    
    function select_salesonlynew_per_segment($segment){
        $sql = 'SELECT sales.idsales, 
                        sales.idsalesunit_FK, 
                        sales.id_salesgroupFK, 
                        sales.id_jabatanFK, 
                        sales.KODE_PROP_FK, 
                        sales.ID_KOTA_FK, 
                        sales.firstname, 
                        sales.lastname, 
                        sales.initial, 
                        sales.nama_sls, 
                        sales.telp1_sls, 
                        sales.telp2_sls, 
                        sales.fax, 
                        sales.email_sls, 
                        sales.otheremail, 
                        sales.address, 
                        sales.postalcode, 
                        sales.birthday, 
                        sales.slsstatus, 
                        sales.photofilename, 
                        sales.photofilepath, 
                        sales.signaturefilename, 
                        sales.signaturefilepath, 
                        sales_group.nama_sg, 
                        ref_jabatan.nama_jab
                FROM sales INNER JOIN sales_group ON sales.id_salesgroupFK = sales_group.idsalesgroup
                        INNER JOIN user_acc ON sales.idsales = user_acc.idstaff_FK
                        INNER JOIN ref_jabatan ON sales.id_jabatanFK = ref_jabatan.idjabatan
                WHERE slsstatus = "Active" AND nama_sg <> "Administration" AND level <> "Admin" AND nama_jab NOT LIKE "%Director of Sales%" AND id_salesgroupFK = ?';
        return $this->db->query($sql,$segment);
    }

    function select_salestargetpersegment($salesgroup) {
        $startthismonth = date('Y-m-d');
        $endthismonth = date('Y-m-d');
 
        $sql ='SELECT *
                FROM sales_target_person AS stp
                RIGHT JOIN  (SELECT * FROM `sales` WHERE `sales`.`slsstatus` = "Active" AND sales.id_salesgroupFK = ?) AS s
                ON s.idsales = stp.idsales_FK
                JOIN sales_group AS sg
                ON sg.idsalesgroup = s.id_salesgroupFK
                JOIN user_acc
                ON user_acc.idstaff_FK = s.idsales
                WHERE  (IFNULL(Month(stp.bulan),0)  = "'.date('m').'" OR
                       IFNULL(Month(stp.bulan),0)  = 0) AND
                       sg.nama_sg <> "Property" AND
                       sg.nama_sg <> "Administration"  AND
                        user_acc.`level` <> "Admin"
                GROUP BY s.idsales
                ORDER BY s.id_salesgroupFK,s.id_jabatanFK';
        return $this->db->query($sql,$salesgroup);
    }

    function select_salestargetpersegment_perproperty($salesgroup,$property) {
        $startthismonth = date('Y-m-d');
        $endthismonth = date('Y-m-d');
 
        $sql ='SELECT *
                FROM sales_target_person AS stp
                RIGHT JOIN  (SELECT * FROM `sales` WHERE `sales`.`slsstatus` = "Active" AND sales.id_salesgroupFK = ?) AS s
                ON s.idsales = stp.idsales_FK
                JOIN sales_group AS sg
                ON sg.idsalesgroup = s.id_salesgroupFK
                JOIN user_acc
                ON user_acc.idstaff_FK = s.idsales
                WHERE  (IFNULL(Month(stp.bulan),0)  = "'.date('m').'" OR
                       IFNULL(Month(stp.bulan),0)  = 0) AND
                       sg.nama_sg <> "Property" AND
                       sg.nama_sg <> "Administration"  AND
                        user_acc.`level` <> "Admin" AND 
                        user_acc.idproperty_FK = ?
                GROUP BY s.idsales
                ORDER BY s.id_salesgroupFK,s.id_jabatanFK';
        return $this->db->query($sql,array($salesgroup,$property));
    }
    
    function select_salestarget_bydate($month) {
        $sql = 'SELECT *
                FROM sales_target_person AS stp
                RIGHT JOIN  sales AS s
                ON s.idsales = stp.idsales_FK
                JOIN sales_group AS sg
                ON sg.idsalesgroup = s.id_salesgroupFK
                WHERE  IFNULL(Monthname(stp.bulan),0)  = ? OR IFNULL(Month(stp.bulan),0)  = 0 AND sg.nama_sg <> "Property"
                GROUP BY s.idsales
                ORDER BY s.id_salesgroupFK,s.id_jabatanFK
                ';
        return $this->db->query($sql,$month);
    }

    function select_sales_by_property($property)
    {
        $sql = "SELECT
                  sales.idsales AS id,
                  sales.nama_sls,
                  sales.telp1_sls AS telp1,
                  sales.telp2_sls AS telp2,
                  sales.email_sls AS email,
                  sales.firstname,
                  sales.lastname
                FROM
                  sales
                  INNER JOIN user_acc ON (sales.idsales = user_acc.idstaff_FK)
                WHERE
                   sales.id_salesgroupFK <> 8 AND sales.slsstatus = 'Active' AND user_acc.idproperty_FK = ?   AND user_acc.`level` = 'Sales'";
        
        return $this->db->query($sql,$property);
    }

    function select_sales_byunit()
    {
       $sql = "SELECT *
               FROM
                  sales
               INNER JOIN sales_group ON (sales.id_salesgroupFK = sales_group.idsalesgroup)
               WHERE `sales_group`.`nama_sg` = 'By Unit' AND sales.slsstatus = 'Active'";
       return $this->db->query($sql);
    }



    function select_target_year()
    {
        $sql = "SELECT
                sales_target_person.tahun
                FROM
                sales_target_person
                GROUP BY
                sales_target_person.tahun
                ORDER BY sales_target_person.tahun ASC";
        return $this->db->query($sql);
    }


    function select_salestarget_between($sales,$monthstart,$monthend,$year)
    {
        $sql = "SELECT
                SUM(sales_target_person.amount) AS TotalBudget
                FROM
                sales_target_person
                WHERE sales_target_person.idsales_FK = ? AND
			MONTH(bulan) BETWEEN ? AND ? AND
			 (tahun) = ? AND
			target_status = 'Active'
                ";
        return $this->db->query($sql,array($sales,$monthstart,$monthend,$year))->row();
    }
}
?>
