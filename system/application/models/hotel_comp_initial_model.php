<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of hotel_comp_initial_model
 *
 * @author ftw
 */
class hotel_comp_initial_model extends Model{
    //put your code here
    function  __construct() {
        parent::Model();
    }

    function insert_data($data)
    {
        $this->db->insert('hotel_comp_initial_balance',$data);
        return true;
    }

    function select_hotelcompinitialbalance_by_stars($stars)
    {
        $sql = "SELECT
                    hotel_comp_initial_balance.idhcinitbalance,
                    hotel_comp_initial_balance.mtd_rs,
                    hotel_comp_initial_balance.ytd_rs,
                    hotel_comp_initial_balance.mtd_arr,
                    hotel_comp_initial_balance.ytd_arr,
                    hotel_comp_initial_balance.mtd_trr,
                    hotel_comp_initial_balance.ytd_trr,
                    hotel_comp_initial_balance.per_date,
                    hotel_comp_initial_balance.idhotelcompetitor_FK,
                    ref_hotel_competitor.hotelcompetitor_name,
                    ref_hotel_competitor.idhotelcompetitor
                FROM
                    hotel_comp_initial_balance
                Inner Join ref_hotel_competitor ON hotel_comp_initial_balance.idhotelcompetitor_FK = ref_hotel_competitor.idhotelcompetitor
                WHERE
                     
                        ref_hotel_competitor.stars = ?
                ";
        return $this->db->query($sql,$stars);
    }
    
    function select_hotelcomp_nothave_initialbalance_by_stars($stars){
        $sql = "SELECT
ref_hotel_competitor.idhotelcompetitor ,
ref_hotel_competitor.hotelcompetitor_name
FROM
ref_hotel_competitor
where idhotelcompetitor NOT IN (SELECT
                    
                    hotel_comp_initial_balance.idhotelcompetitor_FK 
                    
                FROM
                    hotel_comp_initial_balance
                Inner Join ref_hotel_competitor ON hotel_comp_initial_balance.idhotelcompetitor_FK = ref_hotel_competitor.idhotelcompetitor
               ) AND ref_hotel_competitor.stars = ?";
        return $this->db->query($sql,$stars);
    }

    function select_hotelcompinitialbalance_by_stars_per_property($stars,$prop)
    {
        $sql = "SELECT
                    hotel_comp_initial_balance.idhcinitbalance,
                    hotel_comp_initial_balance.mtd_rs,
                    hotel_comp_initial_balance.ytd_rs,
                    hotel_comp_initial_balance.mtd_arr,
                    hotel_comp_initial_balance.ytd_arr,
                    hotel_comp_initial_balance.mtd_trr,
                    hotel_comp_initial_balance.ytd_trr,
                    hotel_comp_initial_balance.per_date,
                    hotel_comp_initial_balance.idhotelcompetitor_FK,
                    ref_hotel_competitor.hotelcompetitor_name,
                    ref_hotel_competitor.idhotelcompetitor
                FROM
                    hotel_comp_initial_balance
                Inner Join ref_hotel_competitor ON hotel_comp_initial_balance.idhotelcompetitor_FK = ref_hotel_competitor.idhotelcompetitor
                WHERE
                  
                        ref_hotel_competitor.stars = ? AND ref_hotel_competitor.fo_property = ?
                ";
        return $this->db->query($sql,array($stars,$prop));
    }

    function select_hotelcominitbalance_permonthhotel($month,$hotel)
    {
        $sql = "SELECT
                    hotel_comp_initial_balance.idhcinitbalance,
                    hotel_comp_initial_balance.mtd_rs,
                    hotel_comp_initial_balance.ytd_rs,
                    hotel_comp_initial_balance.mtd_arr,
                    hotel_comp_initial_balance.ytd_arr,
                    hotel_comp_initial_balance.mtd_trr,
                    hotel_comp_initial_balance.ytd_trr,
                    hotel_comp_initial_balance.per_date,
                    hotel_comp_initial_balance.idhotelcompetitor_FK
                FROM
                    hotel_comp_initial_balance
                WHERE
                    MONTH(hotel_comp_initial_balance.per_date) = ? AND YEAR(hotel_comp_initial_balance.per_date) = '2010' AND
                    hotel_comp_initial_balance.idhotelcompetitor_FK = ?
                ";
        return $this->db->query($sql,array($month,$hotel))->row();
    }

    function select_hotelcominitbalance_perhotel($hotel)
    {
        $sql = "SELECT
                    hotel_comp_initial_balance.idhcinitbalance,
                    hotel_comp_initial_balance.mtd_rs,
                    hotel_comp_initial_balance.ytd_rs,
                    hotel_comp_initial_balance.mtd_arr,
                    hotel_comp_initial_balance.ytd_arr,
                    hotel_comp_initial_balance.mtd_trr,
                    hotel_comp_initial_balance.ytd_trr,
                    hotel_comp_initial_balance.per_date,
                    hotel_comp_initial_balance.idhotelcompetitor_FK
                FROM
                    hotel_comp_initial_balance
                WHERE
                   
                    hotel_comp_initial_balance.idhotelcompetitor_FK = ? AND
                    YEAR(per_date) = '". date('Y')."'

                ";
        return $this->db->query($sql,array($hotel))->row();
    }


    function select_hotelcominitbalance_permonthyearhotel($month,$year,$hotel)
    {
        $sql = "SELECT
                    hotel_comp_initial_balance.idhcinitbalance,
                    hotel_comp_initial_balance.mtd_rs,
                    hotel_comp_initial_balance.ytd_rs,
                    hotel_comp_initial_balance.mtd_arr,
                    hotel_comp_initial_balance.ytd_arr,
                    hotel_comp_initial_balance.mtd_trr,
                    hotel_comp_initial_balance.ytd_trr,
                    hotel_comp_initial_balance.per_date,
                    hotel_comp_initial_balance.idhotelcompetitor_FK
                FROM
                    hotel_comp_initial_balance
                WHERE
                    MONTH(hotel_comp_initial_balance.per_date) = ? AND
                    YEAR(hotel_comp_initial_balance.per_date) = ? AND
                    hotel_comp_initial_balance.idhotelcompetitor_FK = ?
                ";
        return $this->db->query($sql,array($month,$year,$hotel))->row();
    }
}
?>
