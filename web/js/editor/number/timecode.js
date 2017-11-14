console.log("Fonction widget");


$("#tc_widget_beginTc input").change(function(){

//            var value = $(this).val();
    var tc_hour_begin  = $( "#tc_hour_begin").val();
    var tc_min_begin  = $( "#tc_min_begin").val();
    var tc_sec_begin  = $( "#tc_sec_begin").val();

    var tc_total = (tc_hour_begin*3600) + (tc_min_begin*60) + (tc_sec_begin*1);

    $("#number_beginTc").val(tc_total);

    console.log(tc_hour_begin*3600);
})

$("#tc_widget_endTc input").change(function(){

//            var value = $(this).val();
    var tc_hour_ending  = $( "#tc_hour_end").val();
    var tc_min_ending  = $( "#tc_min_end").val();
    var tc_sec_ending  = $( "#tc_sec_end").val();

    var tc_total = (tc_hour_ending*3600) + (tc_min_ending*60) + (tc_sec_ending*1);

    $("#number_endTc").val(tc_total);

    console.log(tc_hour_ending*3600);
})
