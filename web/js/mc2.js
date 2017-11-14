function test(){
	console.log("La fonction test de mc2.js a bien été lancée");
}

function myParallax(){
	$('.parallax').parallax();
}


//Ajout de fonctions pour jquery
jQuery.fn.displaytable = function() {

    var max = 10;
    var mytable = $(this);

	if (typeof dtable == 'undefined')
	{
		dtable = 0;
	}

    $('.displaytable').hide();
	if(this.next(".showall").length == 0){
        $(this).after('<p class="center cursor showall"></p>');
	}
    var mybutton = mytable.next('p');

    if(dtable == 0){

		$('.displaytable tr').each(
			function(index){
				if(index > max){
					$(this).hide();
				}
			}
		);
        mybutton.text('Show all');
    }
    else{
        $('.displaytable tr').fadeIn();
        mybutton.html('Hide');
	}

    $('.displaytable').fadeIn();

};

$('.modal').modal({
        dismissible: true, // Modal can be dismissed by clicking outside of the modal
        opacity: .5, // Opacity of modal background
        inDuration: 300, // Transition in duration
        outDuration: 200, // Transition out duration
        startingTop: '4%', // Starting top style attribute
        endingTop: '10%', // Ending top style attribute
    }
);

$(document).ready(function() {
	myParallax();
	$(".displaytable").displaytable();
    $(".tablesorter").tablesorter(); // tablesorter.js
    $('select').material_select();
	$('textarea').trigger('autoresize');
    $('.datepicker').pickadate({
        // editable: true,
        min: new Date(1920,1,1),
        max: new Date(1975,12,31),
        // defaultDate : new Date(1940,1,30),
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 80, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd',
        today: ''
    });

    $(".showall").click(function(){

    	console.log(dtable);
        if(dtable == 0){
            dtable = 1;
        }
        else
		{
			dtable = 0;
		}

        console.log("dtable = "+dtable);
        $(".displaytable").displaytable();
    });



});


