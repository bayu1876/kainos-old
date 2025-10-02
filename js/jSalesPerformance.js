/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$().ready(function(){
     $("#btnGo").click(function(){
        var sales = $("#sales").val();
        var monthstart = $("#monthstart").val();
        var monthend = $("#monthend").val();
        var year = $("#year").val();
        var tmp = findSWF("graphslsprod");
        var tmp2 = findSWF("graphcontributiontosegment");
        var tmp3 = findSWF("graphcontributionbyhotel");
        var tmp4 = findSWF("graphcontributiontohotel");
            $.ajax({
                type:"POST",
                url: site_url+"sales_performance/get_sales_performance",
                data:({sales:sales,monthstart:monthstart,monthend:monthend,year:year}),
                success: function(data){
                    $("#containerdatasalesperformance").html(data);
                },
                beforeSend: function(){
                    $("#containerdatasalesperformance").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                }
            });

            $.ajax({
                type:"POST",
                url: site_url+"sales_performance/graph_sales_production",
                data:({sales:sales,monthstart:monthstart,monthend:monthend,year:year}),
                dataType:'json',
                success: function(data){
                       tmp.load( JSON.stringify(data) );
                },
                beforeSend: function(){
                    $("#graphslsprod").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                }
            });

            $.ajax({
                type:"POST",
                url: site_url+"sales_performance/graph_contribution_to_segment",
                data:({sales:sales,monthstart:monthstart,monthend:monthend,year:year}),
                dataType:'json',
                success: function(data){
                       tmp2.load( JSON.stringify(data) );
                },
                beforeSend: function(){
                    $("#graphcontributiontosegment").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                }
            });

            $.ajax({
                type:"POST",
                url: site_url+"sales_performance/graph_contribution_by_hotel",
                data:({sales:sales,monthstart:monthstart,monthend:monthend,year:year}),
                dataType:'json',
                success: function(data){
                       tmp3.load( JSON.stringify(data) );
                },
                beforeSend: function(){
                    $("#graphcontributionbyhotel").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                }
            });

             $.ajax({
                type:"POST",
                url: site_url+"sales_performance/graph_contribution_to_hotel",
                data:({sales:sales,monthstart:monthstart,monthend:monthend,year:year}),
                dataType:'json',
                success: function(data){
                       tmp4.load( JSON.stringify(data) );
                },
                beforeSend: function(){
                    $("#graphcontributiontohotel").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                }
            });
        return false;
     })


        function findSWF(movieName) {
            if (navigator.appName.indexOf("Microsoft")!= -1) {
                return window[movieName];
            } else {
                return document[movieName];
            }
        }

    $("#sales").change(function(){
//        var tmp = findSWF("graphslsprod");
//        $.ajax({
//            type:"POST",
//            url: site_url+"sales_performance/graph_sales_production",
//            dataType:'json',
//            success: function(data){
//                tmp.load( JSON.stringify(data) );
//            },
//            beforeSend: function(){
//                $("#graphslsprod").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
//            }
//        });
    })

    $(".toggleindustry").live('click', function(){
        var id = $(this).attr('id');
        $("#detailcompany"+id).toggle();
        return false;
    });



 



})