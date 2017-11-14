function timeline_emprunt_annee(container, annee, data, data2) {

    var dataFinal;

    if (typeof(data2) == 'undefined') {
         dataFinal = timeline_emprunt_annee_simple_data(data, annee);
    } else {
        dataFinal = timeline_emprunt_annee_double_data(data, annee, data2);
    }



    nv.addGraph(function() {
        var chart = nv.models.lineChart()
            //.height(container.height)
            //.width(container.width)
        ;

        var tabDay = [];

        data.forEach(function(element){
            tabDay.push(element.day);
        });

        chart.tooltip
            .contentGenerator(function(data) {
                thatDay = tabDay[data.pointIndex];
                date = d3.time.format("%d-%m-%Y")(new Date(data.point.x * 1000));
                tooltip_str = '<p class="legende" >'+thatDay+" "+date+'</p>'+'<p class="legende">'+data.point.y+' number(s)</p>';
                return tooltip_str;
            });

        chart.xAxis
            .axisLabel('Jour')
            .tickFormat(function(data){
                return d3.time.format("%d-%m-%Y")(new Date(data * 1000))
            });

        chart.yAxis
            .axisLabel("amount of numbers")
            .tickFormat(d3.format(',r'))
        ;

        d3.select("#"+container)
            .datum(dataFinal)
            .transition().duration(500)
            .call(chart)
        ;

        nv.utils.windowResize(chart.update);

        return chart;

    });

}

function timeline_emprunt_annee_choix_couleur(container, annee, data, color) {

    var dataFinal;

    if (typeof(color) == 'undefined') {
        dataFinal = timeline_emprunt_annee_simple_data(data, annee);
    } else {
        dataFinal = timeline_emprunt_annee_simple_data(data, annee, color);
    }



    nv.addGraph(function() {
        var chart = nv.models.lineChart()
            //.height(container.height)
            //.width(container.width)
        ;


        chart.tooltip
            .contentGenerator(function(data) {
                date = d3.time.format("%d-%m-%Y")(new Date(data.point.x * 1000));
                tooltip_str = '<p class="legende" >'+date+'</p>'+'<p class="legende">'+data.point.y+' emprunt(s)</p>';
                return tooltip_str;
            });

        chart.xAxis
            .axisLabel('Jour')
            .tickFormat(function(data){
                return d3.time.format("%d-%m-%Y")(new Date(data * 1000))
            });

        chart.yAxis
            .axisLabel("Nombre d'emprunts")
            .tickFormat(d3.format(',r'))
        ;

        d3.select("#"+container)
            .datum(dataFinal)
            .transition().duration(500)
            .call(chart)
        ;

        nv.utils.windowResize(chart.update);

        return chart;

    });

}


function timeline_emprunt_annee_simple_data(data,annee,color){

    var tab = [];

    data.forEach(function(element){
        tab.push({x: element.label , y: element.value});
    });

    var colorLine;
    if(typeof (color) == 'undefined'){
        colorLine = 'ff1f24';
    }else {
        colorLine = color;
    }

    return [
        {
            values: tab,
            key: annee,
            color: "#"+colorLine,
        },
    ];
}


function timeline_emprunt_annee_double_data(data,annee,donneeGlobal,color){

    var tab = [];
    var tabGlobal = [];

    data.forEach(function(element){
        tab.push({x: element.label , y: element.value});
    });

    donneeGlobal.forEach(function (element2) {
        tabGlobal.push({x: element2.label , y: element2.value});
    });


    var colorLine;
    if(typeof (color) == 'undefined'){
        colorLine = 'ff1f24';
    }else {
        colorLine = color;
    }

    return [
        {
            values: tab,
            key: annee,
            color: "#"+colorLine,
        },
        {
            values: tabGlobal,
            key: "All",
            color: '#ffa4a5',
        },

    ];

}