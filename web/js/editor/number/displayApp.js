(function(window, $)
{

    window.displayApp = {

        test: function () {
            console.log('Launch displayApp for number');
        },

        init: function($title){
            this.hideLoad();
            this.displayNav();
            this.displayMenu();
            this.displayContent($title);
            this.displayFooter();
        },

        hideLoad: function(){
            $('#preloader').hide();
        },

        displayNav: function(){
            $('nav').fadeIn(1000);
            console.log('Launch displayNav');
        },

        displayMenu: function(){
            $('#menu_admin').delay(500).fadeIn(1000)
        },

        //for the first launch
        displayContent: function($title){
            $('.number-title').fadeIn(1000);
            $($title).delay(1000).fadeIn(1000);
            $('#button').delay(1200).fadeIn(1000);
        },

        displayFooter: function(){
            $('footer').delay(2000).fadeIn(1000);
        },

        //when clicking on the menu
        displayItem: function($item){
            $('.main').hide();
            $('.number-title').fadeIn(1000);
            $('#'+$item).fadeIn(300);
            $('#button').fadeIn(300);
        },

    }

})(window, jQuery);

$(document).ready(function() {

    displayApp.init('#title');

    // $('#menu_admin .collection-item span').on('click', function(){
    //         $item = $(this).data("display");
    //     displayApp.displayItem($item);
    // });

    $('#menu_admin .collection-item').on('click', function(){
        $item = $(this).find('span').data("display");
        displayApp.displayItem($item);
    });

});