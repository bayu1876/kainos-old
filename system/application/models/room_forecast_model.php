<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of room_forecast_model
 *
 * @author user
 */
class room_forecast_model extends Model{
    //put your code here
    function __construct() {
        parent::Model();
    }
    
    function insert_data($data)
    {
        return $this->db->insert('room_forecast',$data);
    }    
    
    function select_roomforecast_by_monthyear($month,$year){
        $sql = "SELECT
                room_forecast.roomforecastid,
                room_forecast.date_period,
                room_forecast.reservation_on_hand,
                room_forecast.same_day_reservation,
                room_forecast.occupancy_on_hand,
                room_forecast.exp_arr_w_i,
                room_forecast.total_forecast,
                room_forecast.checkin_by_rsv,
                room_forecast.walk_in,
                room_forecast.extend,
                room_forecast.day_use,
                room_forecast.compliment,
                room_forecast.house_use,
                room_forecast.cancel,
                room_forecast.no_show,
                room_forecast.total_room,
                room_forecast.total_pax,
                room_forecast.total_available,
                room_forecast.forecast_status
                FROM
                room_forecast
                WHERE MONTH(date_period) = ? AND YEAR(date_period) = ?";
        return $this->db->query($sql,array($month,$year));
    }

//iwn:split page room forecast
    function select_roomforecast_by_monthyear_limit($month,$year,$lim1,$lim2){
        $sql = "SELECT
                room_forecast.roomforecastid,
                room_forecast.date_period,
                room_forecast.reservation_on_hand,
                room_forecast.same_day_reservation,
                room_forecast.occupancy_on_hand,
                room_forecast.exp_arr_w_i,
                room_forecast.total_forecast,
                room_forecast.checkin_by_rsv,
                room_forecast.walk_in,
                room_forecast.extend,
                room_forecast.day_use,
                room_forecast.compliment,
                room_forecast.house_use,
                room_forecast.cancel,
                room_forecast.no_show,
                room_forecast.total_room,
                room_forecast.total_pax,
                room_forecast.total_available,
                room_forecast.forecast_status
                FROM
                room_forecast
                WHERE MONTH(date_period) = ? AND YEAR(date_period) = ? LIMIT ?,?";
        return $this->db->query($sql,array($month,$year,$lim1,$lim2));
    }

//
    function update_roomforecast($id,$data){
        $this->db->where('roomforecastid',$id);
        return $this->db->update('room_forecast',$data);
        
    }
    
    
    function select_totalforecast_by_roomforecastid($roomforecastid){
        $sql = "SELECT
                (room_forecast.reservation_on_hand + same_day_reservation + occupancy_on_hand + exp_arr_w_i) AS TotalForecast 
               FROM
                room_forecast
                WHERE room_forecast.roomforecastid = ?
                ";
        return $this->db->query($sql,$roomforecastid)->row();
    }
    
    
    function select_totalroom_by_roomforecastid($roomforecastid){
        $sql = "SELECT
(room_forecast.checkin_by_rsv + walk_in + extend) AS TotalRoom 
 
FROM
room_forecast

                WHERE room_forecast.roomforecastid = ?
                ";
        return $this->db->query($sql,$roomforecastid)->row();
    }
    
    function select_roomforecast_yearperiod(){
        $sql = "SELECT
room_forecast.date_period ,
YEAR(date_period) AS year
FROM
room_forecast
GROUP BY YEAR(date_period)";
        return $this->db->query($sql);
    }
    
    function select_roomforecast_monthperiod(){
        $sql = "SELECT
                room_forecast.date_period ,
                MONTH(date_period) AS month,
                MONTHNAME(date_period) AS mname
                FROM
                room_forecast
                GROUP BY MONTH(date_period)";
        return $this->db->query($sql);
    }
}

?>
