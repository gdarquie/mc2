//Visualisation surnommée MelViz

function viz_mediane(container, data, nbCsp) {

    var width = document.getElementById(container).getBoundingClientRect().width;
    var height = document.getElementById(container).getBoundingClientRect().height-20;

    if (width == 0) {
        width = 1000;
    }

    if (height == -20) {
        height = 400;
    }

    //console.log(height);



    // creerButton(container);

    var div = d3.select("#"+container).append("div")
        .attr("id", "zone_viz"+container)
        .style("width", width+"px")
        .style("height", height+"px");

    versionMelviz("zone_viz"+container, data, nbCsp);

    $('#bouton_melviz'+container+' input').on('change', function() {

        //jusque là marche

    // $('#bouton_melviz input').on('change', function() {

        // if ($('input[name=radioName]:checked', '#bouton_melviz').val() == "0") {
        if ($('input[name=radioName'+container+']:checked', '#bouton_melviz'+container).val() == "0") {
            // console.log("chargment fonction par le bouton");
            versionMelviz("zone_viz"+container, data, nbCsp);
        } else {
            versionBarres("zone_viz"+container, data, nbCsp);
        }
    });
}

function creerButton(div) {


    $("#"+div).html('');

    bouton = d3.select("#"+div).append("form")
         // .attr("class", "bouton_melviz")
        .attr("id", "bouton_melviz"+div)
        .style("text-align", "right");

    bouton.append("input")
        .attr("name", "radioName"+div)
        .attr("type", "radio")
        .attr("id", "radioButton1"+div)
        .attr("value", "0");

    bouton.append("label")
        .attr("for", "radioButton1"+div)
        .html("Melviz")
        .style("margin-right", "25px");

    bouton.append("input")
        .attr("name", "radioName"+div)
        .attr("type", "radio")
        .attr("id", "radioButton2"+div)
        .attr("value", "1");

    bouton.append("label")
        .attr("for", "radioButton2"+div)
        .html("Barres");

    document.getElementById("radioButton1"+div).checked = true;

}


function versionMelviz(container, data, nbCsp) {



    var width = (document.getElementById(container).getBoundingClientRect().width/nbCsp)-2;
    var height = document.getElementById(container).getBoundingClientRect().height;

    $("#"+container).html('');
    d3.select("#"+container).style("opacity", "0");

    for (var i = 0; i < nbCsp; i++) {

        var tip1 = d3.tip()
            .attr('class', 'd3-tip-version-melviz')
            .offset([-10, 0])
            .html(
                "<strong>Average :</strong> <span>" + data[i].all_items + "%</span>"
            );


        var tip2 = d3.tip()
            .attr('class', 'd3-tip-version-melviz')
            .offset([-10, 0])
            .html("<strong>For this person :</strong> <span>" + data[i].one_item + "%</span>"
            );




        var div = d3.select("#"+container).append("div")
            .style("width", width+"px")
            .attr("height", height+"px")
            .style("display", "inline-block");




        var p = div.append("p")
            .style("width", width+"px")
            .text(data[i].label);


        var svg = div.append("svg")
            .attr("width", width)
            .attr("height", height+25);

        for (var u=0; u<11; u++ ) {
            svg.append("rect")
                .attr("width", width)
                .attr("height", 0.3)
                .attr("y", ((height+12.5) - (u*((height))/10)));
        }

        if (i == 0) {
            for (var m=0; m<11; m++ ) {
                svg.append("text")
                    .html(m*10)
                    .attr("y", ((height+12.5) - (m*((height))/10)) + 5)
            }
        }


        svg.call(tip1);
        svg.call(tip2);



        var ligne = svg.append("rect")
            .attr("width", width/2)
            .attr("height", 5)
            .attr("x", width/4)
            .attr("y", height +10 - ((height)/100)*data[i].all_items)
            //.attr("y", height)
            .on('mouseover', tip1.show)
            .on('mouseout', tip1.hide);


        var diff = (data[i].one_item-data[i].all_items)*5;
        var circleColor;
        if(diff > 0) {
            circleColor="#00cc00";
        } else {
            circleColor="#ff0000";
        }
        var rayon = 5;


        var circle = svg.append("circle")
            .attr("r", rayon)
            .attr("transform", "translate(" + parseInt(width)/2 + ", " + (height +12.5 - (parseInt(height)/100)*data[i].one_item) + ")")
            .style("fill", circleColor)
            .on('mouseover', tip2.show)
            .on('mouseout', tip2.hide);
    }


    d3.select("#"+container)
        .transition()
        .duration(1000)
        .style("opacity", "1"); // then transition to red


}


function versionBarres(container, data, nbCsp) {

    // console.log('lancement de versionBarres, le container est '+container);

    var width = document.getElementById(container).getBoundingClientRect().width / nbCsp;

    var height = document.getElementById(container).getBoundingClientRect().height;

    $("#" + container).html('');
    d3.select("#" + container).style("opacity", "0");

    for (var i = 0; i < nbCsp; i++) {

        var tip3 = d3.tip()
            .attr('class', 'd3-tip-version-barres')
            .offset([-10, 0])
            .html(
                "<strong>Average :</strong> <span>" + data[i].all_items + "%</span>"
            );


        var tip4 = d3.tip()
            .attr('class', 'd3-tip-version-barres')
            .offset([-10, 0])
            .html("<strong>For this person :</strong> <span>" + data[i].one_item + "%</span>"
            );


        var div = d3.select("#" + container).append("div")
            .style("width", width + "px")
            .attr("height", height + "px")
            .style("display", "inline-block");


        var p = div.append("p")
            .style("width", width + "px")
            .text(data[i].label);


        var svg = div.append("svg")
            .attr("width", width)
            .attr("height", height + 25);


        for (var u = 0; u < 11; u++) {
            svg.append("rect")
                .attr("width", width)
                .attr("height", 0.3)
                .attr("y", ((height + 12.5) - (u * ((height)) / 11)));
        }

        if (i == 0) {
            for (var m = 0; m < 11; m++) {
                svg.append("text")
                    .html(m * 10)
                    .attr("y", ((height + 12.5) - (m * ((height)) / 11)) + 5)
            }
        }


        svg.call(tip3);
        svg.call(tip4);


        var hauteur_barre_1 = (parseInt(height - 25) / 100) * data[i].all_items;

        var barre1 = svg.append("rect")
            .attr("width", width / 4)
            .attr("height", hauteur_barre_1)
            .attr("x", width / 2 - width / 4)
            .attr("y", height + 12.5 - hauteur_barre_1)
            .on('mouseover', tip3.show)
            .on('mouseout', tip3.hide)
            .style("fill", "red");

        var hauteur_barre_2 = (parseInt(height - 25) / 100) * data[i].one_item;

        var barre2 = svg.append("rect")
            .attr("width", width / 4)
            .attr("height", hauteur_barre_2)
            .attr("x", width / 2)
            .attr("y", height + 12.5 - hauteur_barre_2)
            .on('mouseover', tip4.show)
            .on('mouseout', tip4.hide)
            .style("fill", "orange");

        var diff = (data[i].one_item - data[i].all_items) * 5;
        var circleColor;
        if (diff > 0) {
            circleColor = "#00cc00";
        } else {
            circleColor = "#ff0000";
        }
        var rayon = 5;

        d3.select("#" + container)
            .transition()
            .duration(1000)
            .style("opacity", "1"); // then transition to red


        //
        // var circle = svg.append("circle")
        //     .attr("r", rayon)
        //     .attr("transform", "translate(" + parseInt(width)/2 + ", " + (height - (parseInt(height)/100)*data[i].one_item) + ")")
        //     .style("fill", circleColor)
        //     .on('mouseover', tip2.show)
        //     .on('mouseout', tip2.hide);
    }
}