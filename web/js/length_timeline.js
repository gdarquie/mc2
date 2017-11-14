function create_gant(data,lengthFilm){

    var w = document.getElementById("svg_timeline").getBoundingClientRect().width;

    // var w = 800;
    var h = 400;
    var svg = d3.selectAll(".svg")
        .append("svg")
        .attr("width", w)
        .attr("height", h)
        .attr("class", "svg");
    var colArray =
        //for todd, remove after
        [
            "#003399",
            "#cc0099",
            "#ff0000",
            "#ffff00",
            "#595959",
            "#339933"

        ];
    //
    // [
    //     "#8d0000",
    //     "#a90000",
    //     "#CC0000",
    //     "#ff3838",
    //     "#7F7F7F",
    //     "#ff8d8d"
    // ];
    // [
    //     "#7F7F7F",
    //     "#7F7F7F",
    //     "#7F7F7F",
    //     "#7F7F7F",
    //     "#7F7F7F",
    //     "#7F7F7F"
    // ];
    var taskArray = [];
    data.forEach(function(element) {
        addTask(element.start,element.end,element.content,element.id,element.cast,element.shots);
    });
    function doTime(tme){
        var t = Math.floor(tme / 60);
        return t+":00";
    }
    function doTime2(tme){
        var t = Math.floor(tme / 60);
        return t;
    }
    function addTask(start,end,taskn,id,type,shots) {
        if(shots==0){
            shots = 1;
        }
        taskArray.push({
            "id" :id,
            "task" : taskn,
            "type" : type,
            "startTime": doTime(start),
            "startTimeInt": doTime2(start),
            "endTime": doTime(end),
            "endTimeInt": doTime2(end),
            "seconds": end-start,
            "shots" : shots
        });
    };
    var timeFormat = d3.time.format("%M:%S");
    var timeScale = d3.time.scale()
        .domain([d3.min(taskArray, function(d) {
            return  timeFormat.parse("00:00");
        }),
            d3.max(taskArray, function(d) {
                return timeFormat.parse(doTime(lengthFilm));
            })])
        .range([0,w-100]);
    var categories = new Array();
    var pos = new Array();
    for (var i = 0; i < taskArray.length; i++){
        categories.push(taskArray[i].type);
    }
    for (var i = 0; i < taskArray.length; i++){
        pos.push(taskArray[i].task);
    }
    var catsUnfiltered = categories;//for vert labels
    categories = checkUnique(categories);
    pos = checkUnique(pos);
    makeGant(taskArray,categories, w, h);
    function makeGant(tasks,categories, pageWidth, pageHeight){
        var barHeight = 50;
        var gap =  75;
        var topPadding = 0;
        var sidePadding = 0;
        var colorScale = d3.scale.linear()
            .domain([0, categories.length])
            .range(["#00B9FA", "#F95002"])
            .interpolate(d3.interpolateHcl);
        makeGrid(sidePadding, topPadding, pageWidth, pageHeight);
        drawRects(tasks, categories,gap, topPadding, sidePadding, barHeight, colorScale, pageWidth, pageHeight);
//vertLabels(gap, topPadding, sidePadding, barHeight, colorScale);
    }
    function drawRects(theArray,theCategories, theGap, theTopPad, theSidePad, theBarHeight, theColorScale, w, h){
        var rectangles = svg.append('g')
            .selectAll("rect")
            .data(theArray)
            .enter();
        var innerRects = rectangles.append("rect")
            .attr("rx", 3)
            .attr("ry", 3)
            .attr("x", function(d){
                return (w/(lengthFilm/60))*d.startTimeInt;
            })
            .attr("y", 24)
            .attr("width", function(d){
                if(((w/(lengthFilm/60))*(d.endTimeInt - d.startTimeInt))-0.5 <= 0 ){
                    return 7;
                }
                return ((w/(lengthFilm/60))*(d.endTimeInt - d.startTimeInt))-0.5;
            })
            .attr("height", 50)
            .attr("stroke", "none")
            .attr("fill", function(d){
                for (var i = 0; i < pos.length; i++){
                    if (d.type == 725){
                        return colArray[0];
                    }else if(d.type == 743){
                        return colArray[5];
                    }else if(d.type == 744){
                        return colArray[3];
                    }else if(d.type == 745){
                        return colArray[2];
                    }else if(d.type == 746){
                        return colArray[1];
                    }else{
                        return colArray[4];
                    }
                }
            });
        innerRects.on('mouseover', function(e) {
            var tag = "";
            var minutes = 0;
            var heures = 0;
            for (var i=1; i<d3.select(this).data()[0].startTimeInt+2; i++) {
                if (i % 60 == 0) {
                    heures++;
                    minutes = 0;
                } else {
                    minutes++;
                }
                if(minutes<9) {
                    var debut = "0" + heures + ":" + "0" + (minutes-1);
                } else {
                    var debut = "0" + heures + ":" + (minutes-1);
                }
            }
            minutes = 0;
            heures = 0;
            for (var i=1; i<d3.select(this).data()[0].endTimeInt+2; i++) {
                if (i % 60 == 0) {
                    heures++;
                    minutes = 0;
                } else {
                    minutes++;
                }
                if(minutes<9) {
                    var fin = "0" + heures + ":" + "0" + (minutes-1);
                } else {
                    var fin = "0" + heures + ":" + (minutes-1);
                }
            }
            tag ="Title: " + d3.select(this).data()[0].task + "<br/>" +
                "<p> <span> Length: </span>"+(d3.select(this).data()[0].seconds)+" sec</p>"+
                "<p> <span> Begin Tc: </span>" + debut + " </p>" +
                "<p> <span> Ending Tc: </span> " + fin +" </p>" +
                "<p><span>Shots: </span>"+ (d3.select(this).data()[0].shots) +"</p>";
            var output = document.getElementById("tag");
            var x = (this.x.animVal.value + this.width.animVal.value/2);
            var y = this.y.animVal.value + 25 + "px";
            if(x<100){
                x = 100;
            }
            else if(x>w-100){
                x = w-100;
            }
            x = x+"px";
            output.innerHTML = tag;
            output.style.top = y;
            output.style.left = x;
            output.style.transform = "translate(0px, 100px)";
            output.style.display = "block";
        }).on('mouseout', function() {
            var output = document.getElementById("tag");
            output.style.display = "none";
        });
    }
    function makeGrid(theSidePad, theTopPad, w, h){
        svg.append("rect")
            .attr("width", w)
            .attr("height", 1)
            .attr("y", 80);
        var minutes = -1;
        var heures = 0;
        for (var i=1; i<((lengthFilm/60)/10)+1; i++) {
            if(i%7 == 0) {
                heures++;
                minutes = 0;
            } else {
                minutes++;
            }
            var timeActuel = "0"+heures+":"+minutes+"0";
            var decalage = w/((lengthFilm/60)/10);
            svg.append("text")
                .html(timeActuel)
                .attr("y", 100)
                .attr("x", ((i-1)*decalage));
            svg.append("rect")
                .attr("width", 1)
                .attr("height", 5)
                .attr("y", 80)
                .attr("x", ((i-1)*decalage));
        }
    }
    function checkUnique(arr) {
        var hash = {}, result = [];
        for ( var i = 0, l = arr.length; i < l; ++i ) {
            if ( !hash.hasOwnProperty(arr[i]) ) { //it works with objects! in FF, at least
                hash[ arr[i] ] = true;
                result.push(arr[i]);
            }
        }
        return result;
    }
    function getCounts(arr) {
        var i = arr.length, // var to loop over
            obj = {}; // obj to store results
        while (i) obj[arr[--i]] = (obj[arr[i]] || 0) + 1; // count occurrences
        return obj;
    }
// get specific from everything
    function getCount(word, arr) {
        return getCounts(arr)[word] || 0;
    }
}