function displayPage(){
    displayElements();
    $('.thesaurus-elements').delay(1000).fadeIn(3000);
}

function displayHeader(delay){
    $('nav').delay(delay).fadeIn(1000);
}

function displayTitle(title, delay){
    $(title).delay(delay).fadeIn(2000);
}

function displayFooter(delay){
    $('footer').delay(delay).fadeIn(5000);
}


function displayElements(){

    var bottom = (Math.random()*20)+80;
    var nbElements = $('.thesaurus-element').length;
    var uniqueRandoms = [];
    var numRandoms = nbElements;

    function makeUniqueRandom() {
        // refill the array if needed
        if (!uniqueRandoms.length) {
            for (var i = 0; i <= numRandoms; i++) {
                uniqueRandoms.push(i);
            }
        }
        var index = Math.floor(Math.random() * uniqueRandoms.length);
        var val = uniqueRandoms[index];

        // now remove that value from the array
        uniqueRandoms.splice(index, 1);

        return val;

    }

    for (var i = 0; i <= nbElements; i++){
        bottom = Math.random()+'em';

        $('.thesaurus-element:nth-child('+i+')').css('fontSize', (Math.random()*0.5)+1.8 +'em' )
        $('.thesaurus-element:nth-child('+i+')').css('paddingLeft', (Math.random()*3) +'em');
        $('.thesaurus-element:nth-child('+makeUniqueRandom()+') a').delay(1500+(50*i)).fadeIn(1000);

    }

}

function killWait(){
    $('nav').show();
    $('.title').show();
    $('footer').delay(500).fadeIn(100);
    $('.thesaurus-element a').show();
}

$(document).ready(function() {
    displayHeader(200);
    displayTitle('.title', 700);
    displayPage();
    displayFooter(2000);
    $(window).on('click', killWait);
});