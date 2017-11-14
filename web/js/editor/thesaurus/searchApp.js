(function(window, $)
    {

        window.searchApp = {

            test: function(){
                console.log('Launch searchApp');
            },

            searchItem: function(){

                var $inputDiv = $("#searchItem");
                var $autocomplete = $('.autocomplete-content');
                var inputVal = $("#searchItem").val();
                var link = '/thesaurus/id=';

                console.log('Les caractères rentrés sont : "'+inputVal+'" et la length et de '+inputVal.length);


                if(inputVal.length>1){

                    jQuery.when(
                        jQuery.getJSON('/api/thesaurus/elastica/'+inputVal)
                    ).done(function (json){

                        data = [];

                        for(var i= 0; i < json.length;i++){

//                                id = json[i].id;
                            title = json[i].title;
                            code = json[i].code;
                            id = json[i].id;

                            data[i] = {};

//                                data[id]['id'] = id;
                            data[i]['title'] = title;
                            data[i]['code'] = code;
                            data[i]['id'] = id;
                        }

//                            console.log(data);
//                            var response = JSON.stringify(data);

                        if(!$.isEmptyObject(data)){

//                                console.log(response);

                            var highlight = function(string, $el) {
                                var img = $el.find('img');
                                var matchStart = $el.text().toLowerCase().indexOf("" + string.toLowerCase() + ""),
                                    matchEnd = matchStart + string.length - 1,
                                    beforeMatch = $el.text().slice(0, matchStart),
                                    matchText = $el.text().slice(matchStart, matchEnd + 1),
                                    afterMatch = $el.text().slice(matchEnd + 1);
                                $el.html("<a href="+link+id+"><span>" + beforeMatch + "<span class='highlight'>" + matchText + "</span>" + afterMatch + "</span></a>");
                                if (img.length) {
                                    $el.prepend(img);
                                }
                            };

                            var val = inputVal.toLowerCase();
                            $autocomplete.empty();

                            if (val !== '') {

                                for (var i = 0; i < data.length; i++) {

                                    var id = data[i].id;
                                    var key = data[i].title;
                                    var code = data[i].code;


                                    console.log('id= '+id+', val = '+ val+', key ='+key+', code ='+code);

                                    if (key.toLowerCase() !== val && key.toLowerCase().indexOf(val) !== -1){

                                        var autocompleteOption = $('<li></li>');
                                        autocompleteOption.append('<span>'+key+' ('+code+')</span>');
                                        $autocomplete.append(autocompleteOption);
                                        highlight(val, autocompleteOption);

                                        console.log('Résultat item ='+data[i].title)

                                    }
                                }
                            }

                            // Perform search
                            $inputDiv.on('keyup', function (e) {
                                // Capture Enter

                                if (e.which === 13) {
                                    $autocomplete.find('a').first().click();
                                    return;
                                }

                            });

                        }

                    });
                }

                else{
                    $autocomplete.empty();;
                }


            }
        }//end searchApp

    }

)(window, jQuery);


$(document).ready(function() {

    $("#searchItem").keyup(function() {

        searchApp.searchItem();
//            console.log('window.Response.content = '+window.Response.content);
    });

});