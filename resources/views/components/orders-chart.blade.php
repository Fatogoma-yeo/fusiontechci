<?php

    $days = array();
    $count = 1;
    while ($count <= 7) {
        $days[] = date('d', strtotime("-".$count."day"));
        $count++;
    }
    // echo "<pre>"; print_r($last_weeks[0]); die;

    $dataPoints2 = array(
        array("label"=> "Dimanche", "y"=> 49505 ),
        array("label"=> "Lundi", "y"=> 31917 ),
        array("label"=> "Mardi", "y"=> 25972 ),
        array("label"=> "Mercredi", "y"=> 23337 ),
        array("label"=> "Jeudi", "y"=> 16086 ),
        array("label"=> "Vendredi", "y"=> 13403 ),
        array("label"=> "Samedi", "y"=> 13820 ),
    );
    $dataPoints6 = array(
        array("label"=> "Dimanche", "y"=> 612 ),
        array("label"=> "Lundi", "y"=> 864 ),
        array("label"=> "Mardi", "y"=> 891 ),
        array("label"=> "Mercredi", "y"=> 1212 ),
        array("label"=> "Jeudi", "y"=> 1818 ),
        array("label"=> "Vendredi", "y"=> 4327 ),
        array("label"=> "Samedi", "y"=> 9036 ),
    );
 
?>

<div id="chartContainer" style="height: 370px; width: 100%;"></div>
@push('javascript')
<script>
    window.onload = function () {
    
    var chart = new CanvasJS.Chart("chartContainer", { 
        theme: "light2",
        subtitles: [{
            text: "In Gigawatt Hours"
        }],
        legend:{
            cursor: "pointer",
            itemclick: toggleDataSeries
        },
        toolTip: {
            shared: true
        },
        data: [{
            type: "stackedArea",
            name: "{{ __( 'Current Week' ) }}",
            showInLegend: true,
            yValueFormatString: "#,##0 F CFA",
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        },
        {
            type: "stackedArea",
            name: "{{ __( 'Previous Week' ) }}",
            showInLegend: true,
            yValueFormatString: "#,##0 F CFA",
            dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
        }]
    });
 
    chart.render();
    
    function toggleDataSeries(e){
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        }
        else{
            e.dataSeries.visible = true;
        }
        chart.render();
    }
 
}
</script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
@endpush