<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of hotel_competitor_analysis_model
 *
 * @author ftw
 */
class hotel_competitor_analysis_model extends Model{
    //put your code here
    function  __construct() {
        parent::Model();
    }

    function insert_data($data)
    {
        if($this->db->insert('hotel_comp_analysis',$data)){
             return $this->db->insert_id();
        }else{
             return false;
        }
       
    }

    function insert_hotelcompgroup($data)
    {
        $this->db->insert('hotel_competitor_group',$data);
        return true;
    }

    function delete_hotelcompanalys_by_hoteldate($idhotel,$date)
    {
        $sql = "DELETE FROM hotel_comp_analysis WHERE idhotelcompetitor_FK = ? AND per_date = ?";
        return $this->db->query($sql,array($idhotel,$date));
    }

    function select_hotelcompanalys_by_hoteldate($idhotel,$perdate)
    {
        $sql = "SELECT
                hotel_comp_analysis.idhotelcompanalysis,
                hotel_comp_analysis.per_date,
                hotel_comp_analysis.room_sold,
                hotel_comp_analysis.arr,
                hotel_comp_analysis.idhotelcompetitor_FK
                FROM
                hotel_comp_analysis
                WHERE
                hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                hotel_comp_analysis.per_date = ?
                ";
        return $this->db->query($sql,array($idhotel,$perdate));
    }

    function select_group_perhcatoday($hca)
    {
        $sql = "SELECT
                ref_hotel_competitor.hotelcompetitor_name,
                hotel_comp_analysis.per_date,
                accounts.account_name
                FROM
                hotel_competitor_group
                Inner Join hotel_comp_analysis ON hotel_competitor_group.idhotelcompanalysis_FK = hotel_comp_analysis.idhotelcompanalysis
                Inner Join ref_hotel_competitor ON hotel_comp_analysis.idhotelcompetitor_FK = ref_hotel_competitor.idhotelcompetitor
                Inner Join accounts ON accounts.idaccount = hotel_competitor_group.idaccount_FK
                WHERE
                hotel_comp_analysis.per_date = '".date('Y-m-d')."' AND
                hotel_competitor_group.idhotelcompanalysis_FK = ?
                ";
        return $this->db->query($sql,$hca);
    }

    function select_hotelcompanalysis_perdate($date)
    {
        $sql = "SELECT
                ref_hotel_competitor.idhotelcompetitor,
                ref_hotel_competitor.hotelcompetitor_name,
                ref_hotel_competitor.stars,
                ref_hotel_competitor.room_inventory,
                hotel_comp_analysis.room_sold,
                hotel_comp_analysis.arr,
                hotel_comp_analysis.per_date,
                hotel_comp_analysis.idhotelcompanalysis
                FROM
                ref_hotel_competitor
                Inner Join hotel_comp_analysis ON ref_hotel_competitor.idhotelcompetitor = hotel_comp_analysis.idhotelcompetitor_FK
                WHERE
                hotel_comp_analysis.per_date = ?
                ";
        return $this->db->query($sql,$date);
    }

    function select_hotelcompanalysis_perdate_perhotel($date,$idhotel)
    {
        $sql = "SELECT
                ref_hotel_competitor.idhotelcompetitor,
                ref_hotel_competitor.hotelcompetitor_name,
                ref_hotel_competitor.stars,
                ref_hotel_competitor.room_inventory,
                hotel_comp_analysis.room_sold,
                hotel_comp_analysis.arr,
                hotel_comp_analysis.per_date,
                hotel_comp_analysis.idhotelcompanalysis
                FROM
                ref_hotel_competitor
                Inner Join hotel_comp_analysis ON ref_hotel_competitor.idhotelcompetitor = hotel_comp_analysis.idhotelcompetitor_FK
                WHERE
                hotel_comp_analysis.per_date = ? AND
                hotel_comp_analysis.idhotelcompetitor_FK = ?
                ";
        return $this->db->query($sql,array($date,$idhotel))->row();
    }

    function select_hotelcompanalysis_perdate_property($date,$prop)
    {
        $sql = "SELECT
                ref_hotel_competitor.idhotelcompetitor,
                ref_hotel_competitor.hotelcompetitor_name,
                ref_hotel_competitor.stars,
                ref_hotel_competitor.room_inventory,
                hotel_comp_analysis.room_sold,
                hotel_comp_analysis.arr,
                hotel_comp_analysis.per_date,
                hotel_comp_analysis.idhotelcompanalysis
                FROM
                ref_hotel_competitor
                Inner Join hotel_comp_analysis ON ref_hotel_competitor.idhotelcompetitor = hotel_comp_analysis.idhotelcompetitor_FK
                WHERE
                hotel_comp_analysis.per_date = ? AND
                ref_hotel_competitor.fo_property = ?
                ";
        return $this->db->query($sql,array($date,$prop));
    }

    function select_competitoranalysistoday_perhotel($hotel)
    {
        $sql = "SELECT
                    hotel_comp_analysis.idhotelcompanalysis,
                    hotel_comp_analysis.per_date,
                    hotel_comp_analysis.room_sold,
                    hotel_comp_analysis.arr,
                    hotel_comp_analysis.idhotelcompetitor_FK
                FROM
                    hotel_comp_analysis
                WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    hotel_comp_analysis.per_date = '".date('Y-m-d')."'
                ";
        return $this->db->query($sql,$hotel)->row();
    }

     function select_competitoranalysisondate_perhotel($hotel,$perdate)
    {
        $sql = "SELECT
                    hotel_comp_analysis.idhotelcompanalysis,
                    hotel_comp_analysis.per_date,
                    hotel_comp_analysis.room_sold,
                    hotel_comp_analysis.arr,
                    hotel_comp_analysis.idhotelcompetitor_FK
                FROM
                    hotel_comp_analysis
                WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    hotel_comp_analysis.per_date =  ?
                ";
        return $this->db->query($sql,array($hotel,$perdate))->row();
    }

    function select_roomsoldmtd_perhotel($hotel)
    {
        $sql = "SELECT
                   SUM(hotel_comp_analysis.room_sold) AS RS_MTD
                FROM
                    hotel_comp_analysis
                WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    MONTH(hotel_comp_analysis.per_date) = '".date('m')."'  
                ";
        return $this->db->query($sql,$hotel)->row();
    }

    function select_roomsoldmtd_wodateinitbal_perhotel($hotel,$initbaldate)
    {
        $sql = "SELECT
                   SUM(hotel_comp_analysis.room_sold) AS RS_MTD
                FROM
                    hotel_comp_analysis
                WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    MONTH(hotel_comp_analysis.per_date) = '".date('m')."' AND
                    hotel_comp_analysis.per_date <> ?
                ";
        return $this->db->query($sql,array($hotel,$initbaldate))->row();
    }


    function select_roomsoldmtd_wodateinitbalbetween_perhotel($hotel,$initbaldate,$todate,$wodate)
    {
        $sql = "SELECT
                   SUM(hotel_comp_analysis.room_sold) AS RS_MTD
                FROM
                    hotel_comp_analysis
                WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    (hotel_comp_analysis.per_date BETWEEN ? AND ? ) AND 
                    hotel_comp_analysis.per_date <> ?
                ";
        return $this->db->query($sql,array($hotel,$initbaldate,$todate,$wodate))->row();
    }



    function select_roomsoldmtdondate_perhotel($hotel,$month,$year)
    {
        $sql = "SELECT
                   SUM(hotel_comp_analysis.room_sold) AS RS_MTD
                FROM
                    hotel_comp_analysis
                WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    MONTH(hotel_comp_analysis.per_date) = ? AND
                    YEAR(hotel_comp_analysis.per_date) = ?
                ";
        return $this->db->query($sql,array($hotel,$month,$year))->row();
    }
 

    function select_roomsoldmtdondatebetween_wodateinitbal_perhotel($hotel,$month,$year,$dateinitbal)
    {
        $sql = "SELECT
                   SUM(hotel_comp_analysis.room_sold) AS RS_MTD
                FROM
                    hotel_comp_analysis
                WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    (hotel_comp_analysis.per_date) BETWEEN ? AND ? AND
                    hotel_comp_analysis.per_date <> ?
                ";
        return $this->db->query($sql,array($hotel,$month,$year,$dateinitbal))->row();
    }


    function select_grouptoday_perhotel($htl)
    {
        $sql = "SELECT
                accounts.account_name,
                hotel_competitor_group.rno
                FROM
                hotel_comp_analysis
                Inner Join hotel_competitor_group ON hotel_comp_analysis.idhotelcompanalysis = hotel_competitor_group.idhotelcompanalysis_FK
                Inner Join accounts ON hotel_competitor_group.idaccount_FK = accounts.idaccount
                WHERE
                hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                hotel_comp_analysis.per_date = '".date('Y-m-d')."'
                ";
        return $this->db->query($sql,$htl);
    }


    function select_groupondate_perhotel($htl,$date)
    {
        $sql = "SELECT
                accounts.account_name, rno
                FROM
                hotel_comp_analysis
                Inner Join hotel_competitor_group ON hotel_comp_analysis.idhotelcompanalysis = hotel_competitor_group.idhotelcompanalysis_FK
                Inner Join accounts ON hotel_competitor_group.idaccount_FK = accounts.idaccount
                WHERE
                hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                hotel_comp_analysis.per_date = ?
                ";
        return $this->db->query($sql,array($htl,$date));
    }

    function select_roomsoldytd_perhotel($hotel)
    {
          $sql = "SELECT
                    SUM(hotel_comp_analysis.room_sold) AS RS_YTD
                  FROM
                    hotel_comp_analysis
                  WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    YEAR(hotel_comp_analysis.per_date) = '".date('Y')."'
                ";
        return $this->db->query($sql,$hotel)->row();
    }

    function select_roomsoldytd_wodateinitbal_perhotel($hotel,$dateinitbal)
    {
          $sql = "SELECT
                    SUM(hotel_comp_analysis.room_sold) AS RS_YTD
                  FROM
                    hotel_comp_analysis
                  WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    YEAR(hotel_comp_analysis.per_date) = '".date('Y')."' AND
                    hotel_comp_analysis.per_date <> ?  
                ";
        return $this->db->query($sql,array($hotel,$dateinitbal))->row();
    }

    


    function select_roomsoldytdondate_perhotel($hotel,$year)
    {
          $sql = "SELECT
                    SUM(hotel_comp_analysis.room_sold) AS RS_YTD
                  FROM
                    hotel_comp_analysis
                  WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    YEAR(hotel_comp_analysis.per_date) = ?
                    ";
        return $this->db->query($sql,array($hotel,$year))->row();
    }


    function select_roomsoldytdondate_wodateinitbal_perhotel($hotel,$year,$dateinitbal)
    {
          $sql = "SELECT
                    SUM(hotel_comp_analysis.room_sold) AS RS_YTD
                  FROM
                    hotel_comp_analysis
                  WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    YEAR(hotel_comp_analysis.per_date) = ? AND
                    hotel_comp_analysis.per_date <> ?
                    ";
        return $this->db->query($sql,array($hotel,$year,$dateinitbal))->row();
    }

    function select_roomsoldyear_woinibaldate_perdate($hotel,$year,$perdate,$dateinitbal)
    {
         $sql = "SELECT
                    SUM(hotel_comp_analysis.room_sold) AS RS_YTD
                  FROM
                    hotel_comp_analysis
                  WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    YEAR(hotel_comp_analysis.per_date) = ? AND
                    hotel_comp_analysis.per_date <= ? AND
                    hotel_comp_analysis.per_date <> ?
                    ";
        return $this->db->query($sql,array($hotel,$year,$perdate,$dateinitbal))->row();
    }

    function select_arrmtd_perhotel($hotel)
    {
        $sql = "SELECT
                    SUM(hotel_comp_analysis.arr) AS ARR_MTD
                FROM
                    hotel_comp_analysis
                WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    MONTH(hotel_comp_analysis.per_date) = '".date('m')."'
                ";
        return $this->db->query($sql,$hotel)->row();
    }

    function select_arrmtd_wodateinitbal_perhotel($hotel,$dateinitbal)
    {
        $sql = "SELECT
                    SUM(hotel_comp_analysis.arr) AS ARR_MTD
                FROM
                    hotel_comp_analysis
                WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    MONTH(hotel_comp_analysis.per_date) = '".date('m')."' AND
                    hotel_comp_analysis.per_date <> ?
                ";
        return $this->db->query($sql,array($hotel,$dateinitbal))->row();
    }

    function select_arrmtd_wodateinitbalbetween_perhotel($hotel,$dateinitbal,$todate,$wodate)
    {
        $sql = "SELECT
                    SUM(hotel_comp_analysis.arr) AS ARR_MTD
                FROM
                    hotel_comp_analysis
                WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    (hotel_comp_analysis.per_date  BETWEEN ? AND ? ) AND
                    hotel_comp_analysis.per_date <> ?
                ";
        return $this->db->query($sql,array($hotel,$dateinitbal,$todate,$wodate))->row();
    }


    

    function select_arrmtdondate_perhotel($hotel,$month,$year)
    {
        $sql = "SELECT
                    SUM(hotel_comp_analysis.arr) AS ARR_MTD
                FROM
                    hotel_comp_analysis
                WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    MONTH(hotel_comp_analysis.per_date) = ? AND
                    YEAR(hotel_comp_analysis.per_date) = ?
                ";
        return $this->db->query($sql,array($hotel,$month,$year))->row();
    }

    function select_arrmtdondate_wodateinitbal_perhotel($hotel,$month,$year,$dateinitbal)
    {
        $sql = "SELECT
                    SUM(hotel_comp_analysis.arr) AS ARR_MTD
                FROM
                    hotel_comp_analysis
                WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    MONTH(hotel_comp_analysis.per_date) = ? AND
                    YEAR(hotel_comp_analysis.per_date) = ? AND
                    hotel_comp_analysis.per_date <> ?
                ";
        return $this->db->query($sql,array($hotel,$month,$year,$dateinitbal))->row();
    }

    function select_totaltrrtoday_wodateinitbal($dateinitbal,$startdate,$enddate,$hotel)
    {
        $sql = "SELECT
                SUM(hotel_comp_analysis.room_sold * hotel_comp_analysis.arr)  AS TRR_TODAY
                FROM
                hotel_comp_analysis
                WHERE
                hotel_comp_analysis.per_date <> ? AND hotel_comp_analysis.per_date BETWEEN ? AND ?
                AND hotel_comp_analysis.idhotelcompetitor_FK = ?
                ";
        return $this->db->query($sql,array($dateinitbal,$startdate,$enddate,$hotel))->row();
    }


    
    
    function select_arrmtdondate_wodateinitbalbetween_perhotel($hotel,$dateinitbal,$todate,$wodate)
    {
        $sql = "SELECT
                    SUM(hotel_comp_analysis.arr) AS ARR_MTD
                FROM
                    hotel_comp_analysis
                WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    (hotel_comp_analysis.per_date BETWEEN ? AND ? ) AND
                    hotel_comp_analysis.per_date <> ?
                ";
        return $this->db->query($sql,array($hotel,$dateinitbal,$todate,$wodate))->row();
    }


    

    function select_arrytd_perhotel($hotel)
    {
          $sql = "SELECT
                    SUM(hotel_comp_analysis.arr) AS ARR_YTD
                  FROM
                    hotel_comp_analysis
                  WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    YEAR(hotel_comp_analysis.per_date) = '".date('Y')."'
                ";
        return $this->db->query($sql,$hotel)->row();
    }


    function select_arrytd_wodateinitbal_perhotel($hotel,$dateinitbal)
    {
          $sql = "SELECT
                    SUM(hotel_comp_analysis.arr) AS ARR_YTD
                  FROM
                    hotel_comp_analysis
                  WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    YEAR(hotel_comp_analysis.per_date) = '".date('Y')."' AND
                    hotel_comp_analysis.per_date <> ?
                ";
        return $this->db->query($sql,array($hotel,$dateinitbal))->row();
    }

    function select_arrytdondate_perhotel($hotel,$year)
    {
          $sql = "SELECT
                    SUM(hotel_comp_analysis.arr) AS ARR_YTD
                  FROM
                    hotel_comp_analysis
                  WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    YEAR(hotel_comp_analysis.per_date) = ?
                ";
        return $this->db->query($sql,array($hotel,$year))->row();
    }

    function select_arrytdondate_wodateinitbal_perhotel($hotel,$year,$dateinitbal)
    {
          $sql = "SELECT
                    SUM(hotel_comp_analysis.arr) AS ARR_YTD
                  FROM
                    hotel_comp_analysis
                  WHERE
                    hotel_comp_analysis.idhotelcompetitor_FK = ? AND
                    YEAR(hotel_comp_analysis.per_date) = ? AND
                    hotel_comp_analysis.per_date <> ?
                ";
        return $this->db->query($sql,array($hotel,$year,$dateinitbal))->row();
    }

    function update_hotelcompetitoranalys_by_id($id,$data)
    {
        $this->db->where('idhotelcompanalysis',$id);
        $this->db->update('hotel_comp_analysis',$data);
        return true;
    }

    function delete_grouplastnight_by_accountidhotelcompanalys($idaccount,$idhca)
    {
        $this->db->where('idaccount_FK',$idaccount);
        $this->db->where('idhotelcompanalysis_FK',$idhca);
        $this->db->delete('hotel_competitor_group');
        return true;
    }

    function delete_grouplastnight_by_hca($idhca)
    {
        $this->db->where('idhotelcompanalysis_FK',$idhca);
        $this->db->delete('hotel_competitor_group');
        return true;
    }

    function select_rsmtd_perhotel($startdate,$enddate,$hotel)
    {
        $sql = "SELECT
                   SUM(room_sold) AS RS_MTD
                FROM
                    hotel_comp_analysis
                WHERE
                    
                    per_date BETWEEN ? AND ? AND
                    hotel_comp_analysis.idhotelcompetitor_FK = ?";
        return $this->db->query($sql,array($startdate,$enddate,$hotel))->row();
    }

    function select_rsytd_perhotel($startdate,$enddate,$hotel)
    {
        $sql = "SELECT
                   SUM(room_sold) AS RS_YTD
                FROM
                    hotel_comp_analysis
                WHERE

                    per_date BETWEEN ? AND ? AND
                    hotel_comp_analysis.idhotelcompetitor_FK = ?";
        return $this->db->query($sql,array($startdate,$enddate,$hotel))->row();
    }


    function select_arrmonthtodate_perhotel($startdate,$enddate,$hotel)
    {
        $sql = "SELECT
                   SUM(arr) AS ARR_MTD
                FROM
                    hotel_comp_analysis
                WHERE

                    per_date BETWEEN ? AND ? AND
                    hotel_comp_analysis.idhotelcompetitor_FK = ?";
        return $this->db->query($sql,array($startdate,$enddate,$hotel))->row();
    }

    function select_trrtoday_perhotel($pertanggal,$hotel)
    {
        $sql = "SELECT
                   (arr * room_sold) AS TRR_TODAY
                FROM
                    hotel_comp_analysis
                WHERE

                    per_date = ? AND
                    hotel_comp_analysis.idhotelcompetitor_FK = ?";
        return $this->db->query($sql,array($pertanggal,$hotel))->row();
    }

    function select_trrmtd_perhotel($startdate,$enddate,$hotel)
    {
         $sql = "SELECT
                   SUM(arr * room_sold) AS TRR_MTD
                FROM
                    hotel_comp_analysis
                WHERE

                      per_date BETWEEN ? AND ? AND
                    hotel_comp_analysis.idhotelcompetitor_FK = ?";
        return $this->db->query($sql,array($startdate,$enddate,$hotel))->row();
    }

    function select_trrytd_perhotel($startdate,$enddate,$hotel)
    {
         $sql = "SELECT
                   SUM(arr * room_sold) AS TRR_YTD
                FROM
                    hotel_comp_analysis
                WHERE

                      per_date BETWEEN ? AND ? AND
                    hotel_comp_analysis.idhotelcompetitor_FK = ?";
        return $this->db->query($sql,array($startdate,$enddate,$hotel))->row();
    }


    function select_group_between($from,$to)
    {
        $sql = "SELECT
                  (accounts.account_name),
                   accounts.idaccount,
                   SUM(hotel_competitor_group.rno) AS TotalRNO,
                   hotel_comp_analysis.per_date,
                   ref_hotel_competitor.hotelcompetitor_name
                FROM
                hotel_competitor_group
                Inner Join hotel_comp_analysis ON hotel_competitor_group.idhotelcompanalysis_FK = hotel_comp_analysis.idhotelcompanalysis
                Inner Join accounts ON accounts.idaccount = hotel_competitor_group.idaccount_FK
                Inner Join ref_hotel_competitor ON hotel_comp_analysis.idhotelcompetitor_FK = ref_hotel_competitor.idhotelcompetitor
                WHERE  (per_date) BETWEEN ? AND ?
                GROUP BY accounts.account_name
                ORDER BY TotalRNO DESC";
        return $this->db->query($sql,array($from,$to));
    }

    function select_group_on_kagum_between($from,$to)
    {
        $sql = "SELECT
  (accounts.account_name),
accounts.idaccount,
SUM(hotel_competitor_group.rno) AS TotalRNO,
hotel_comp_analysis.per_date,
ref_hotel_competitor.hotelcompetitor_name
FROM
hotel_competitor_group
Inner Join hotel_comp_analysis ON hotel_competitor_group.idhotelcompanalysis_FK = hotel_comp_analysis.idhotelcompanalysis
Inner Join accounts ON accounts.idaccount = hotel_competitor_group.idaccount_FK
Inner Join ref_hotel_competitor ON hotel_comp_analysis.idhotelcompetitor_FK = ref_hotel_competitor.idhotelcompetitor
WHERE  (per_date) BETWEEN ? AND ? AND
(idhotelcompetitor = 26 OR idhotelcompetitor = 24 OR idhotelcompetitor = 25 OR idhotelcompetitor = 23 OR idhotelcompetitor = 4)
GROUP BY accounts.account_name
ORDER BY TotalRNO DESC";
        return $this->db->query($sql,array($from,$to));
    }

    function select_hotelcompetitor_by_group_between($group,$from,$to)
    {
        $sql = "SELECT
accounts.account_name,
SUM(hotel_competitor_group.rno) AS TotalRNO ,
hotel_comp_analysis.per_date,
ref_hotel_competitor.hotelcompetitor_name,
ref_hotel_competitor.idhotelcompetitor,
hotel_competitor_group.idaccount_FK
FROM
hotel_competitor_group
Inner Join hotel_comp_analysis ON hotel_competitor_group.idhotelcompanalysis_FK = hotel_comp_analysis.idhotelcompanalysis
Inner Join accounts ON accounts.idaccount = hotel_competitor_group.idaccount_FK
Inner Join ref_hotel_competitor ON hotel_comp_analysis.idhotelcompetitor_FK = ref_hotel_competitor.idhotelcompetitor
WHERE idaccount_FK = ? AND per_date BETWEEN ? AND ?
GROUP BY ref_hotel_competitor.idhotelcompetitor
ORDER BY rno DESC";
        return $this->db->query($sql,array($group,$from,$to));
    }

    function select_hotelkagum_by_group_between($group,$from,$to)
    {
        $sql = "SELECT
accounts.account_name,
SUM(hotel_competitor_group.rno) AS TotalRNO ,
hotel_comp_analysis.per_date,
ref_hotel_competitor.hotelcompetitor_name,
ref_hotel_competitor.idhotelcompetitor,
hotel_competitor_group.idaccount_FK
FROM
hotel_competitor_group
Inner Join hotel_comp_analysis ON hotel_competitor_group.idhotelcompanalysis_FK = hotel_comp_analysis.idhotelcompanalysis
Inner Join accounts ON accounts.idaccount = hotel_competitor_group.idaccount_FK
Inner Join ref_hotel_competitor ON hotel_comp_analysis.idhotelcompetitor_FK = ref_hotel_competitor.idhotelcompetitor
WHERE idaccount_FK = ? AND per_date BETWEEN ? AND ? AND (idhotelcompetitor = 26 OR idhotelcompetitor = 24 OR idhotelcompetitor = 25 OR idhotelcompetitor = 23 OR  idhotelcompetitor = 4)
GROUP BY ref_hotel_competitor.idhotelcompetitor
ORDER BY rno DESC";
        return $this->db->query($sql,array($group,$from,$to));
    }
}
?>
