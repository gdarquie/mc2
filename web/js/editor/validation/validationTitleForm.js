(function ($) {
    $(document).ready(function() {

        var $wrapper = $('.js-title-validation-wrapper');

        $wrapper.on('click', '.js-remove-title-validation', function(e) {
            e.preventDefault();
            $(this).closest('.js-title-validation-item').remove();
        });

        $('.js-remove-title-validation').on('click', function(e) {

            e.preventDefault();
            // $(this).closest('.js-title-validation-item').remove();
            $index = $(this).closest('.js-title-validation-item').index();
            $target = "#number_validationTitle_"+$index;
            $($target).remove();
        });

        $wrapper.on('click', '.js-add-title-validation', function(e){
            e.preventDefault();

            // Get the data-prototype explained earlier
            var prototype = $wrapper.data('prototype');

            // get the new index
            var index = $wrapper.data('index');

            // Replace '__name__' in the prototype's HTML to
            // instead be a number based on how many items we have
            var newForm = prototype.replace(/__name__/g, index);

            // increase the index with one for the next item
            $wrapper.data('index', index + 1);

            // Display the form in the page in an li, before the "Add a tag" link li
            $(this).before(newForm);

        })
    });
})(jQuery);