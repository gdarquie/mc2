function donut_simple(container, data, donut, myColors) {


    if (typeof(donut) == 'undefined') {
        donut = true;
    }

    if (typeof(colors) == 'undefined') {
        myColors = ["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd", "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"];
    }


    d3.scale.myColors = function() {
        return d3.scale.ordinal().range(myColors);
    };

    nv.addGraph(function() {
        var chart = nv.models.pieChart()
            .x(function (d) {
                return d.label
            })
            .y(function (d) {
                return d.value
            })
            .showLabels(true)     //Display pie labels
            .color(d3.scale.myColors().range())     //
            .labelThreshold(.05)  //Configure the minimum slice size for labels to show up
            .labelType("percent") //Configure what type of data to show in the label. Can be "key", "value" or "percent"
            .donut(donut)          //Turn on Donut mode. Makes pie chart look tasty!
            .donutRatio(0.35)     //Configure how big you want the donut hole size to be.
            .showLegend(false);
        ;
        d3.select("#" + container)
            .datum(data)
            .transition().duration(350)
            .call(chart);

        return chart;
    });
}

function donut_simple_avec_legende(container, data, donut,myColors) {

    if (typeof(donut) == 'undefined') {
        donut = true;
    }

    if (typeof(colors) == 'undefined') {
        myColors = ["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd", "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"];
    }


    d3.scale.myColors = function() {
        return d3.scale.ordinal().range(myColors);
    };

    nv.addGraph(function() {
        var chart = nv.models.pieChart()
            .x(function (d) {
                return d.label
            })
            .y(function (d) {
                return d.value
            })
            .showLabels(true)     //Display pie labels
            .color(d3.scale.myColors().range())     //
            .labelThreshold(.05)  //Configure the minimum slice size for labels to show up
            .labelType("percent") //Configure what type of data to show in the label. Can be "key", "value" or "percent"
            .donut(donut)          //Turn on Donut mode. Makes pie chart look tasty!
            .donutRatio(0.50)     //Configure how big you want the donut hole size to be.
            .showLegend(true);
        ;
        d3.select("#" + container)
            .datum(data)
            .transition().duration(350)
            .call(chart);
        if(data.length > 0){
            document.getElementsByClassName('nv-legendWrap')[0].setAttribute('transform', 'translate(-100, -30)');
        }


        var clickEvent = new MouseEvent("click", {
            "view": window,
            "bubbles": true,
            "cancelable": false
        });

        document.getElementsByClassName("nv-series")[0].dispatchEvent(clickEvent);
        document.getElementsByClassName("nv-series")[0].dispatchEvent(clickEvent);

        return chart;
    });
}