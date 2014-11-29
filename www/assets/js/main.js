$(function () {

    console.log('App running...');

    var wrappers = $('ul li .thumbnail-wrapper');

    var makeImagesClickable = function () {
        wrappers.on('click', toggleImageStatus);
    };

    var refreshImagePropertiesByStatus = function () {
        wrappers.each(function () {
            var wrapper = $(this);
            var currentStatus = wrapper.data('accepted') === 'yes';
            if (currentStatus) {
                wrapper.addClass('accepted');
                var container = wrapper.parent();
                container.prepend('<div class="selected-icon"></div>');

                // Remove "Accept" button
                container.find('.accept-link').remove();
            } else {
                // Remove "Reject" button
                container.find('.reject-link').remove();
            }
        });
    };

    var toggleImageStatus = function (e) {
        e.preventDefault();

        var currentStatus = $(this).data('accepted');
        console.log(currentStatus);
    };

    $('.fancybox').fancybox();

    refreshImagePropertiesByStatus();
    makeImagesClickable();
});