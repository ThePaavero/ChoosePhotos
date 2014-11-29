$(function () {

    console.log('App running...');

    var wrappers = $('ul li .thumbnail-wrapper');
    var links = $('ul li a.accept-link, ul li a.reject-link');

    var refreshImagePropertiesByStatus = function () {
        wrappers.each(function () {
            var wrapper = $(this);
            var currentStatus = wrapper.data('accepted') === 'yes';
            var container = wrapper.parent();
            if (currentStatus) {
                wrapper.addClass('accepted');
                container.find('.rejected-icon').remove();
                container.prepend('<div class="accepted-icon"></div>');

                // Remove "Accept" button
                container.find('.accept-link').remove();
            } else {
                wrapper.removeClass('accepted');
                container.find('.accepted-icon').remove();
                container.prepend('<div class="rejected-icon"></div>');

                // Remove "Reject" button
                container.find('.reject-link').remove();
            }
        });
    };

    var toggleImageStatus = function (e) {
        e.preventDefault();

        var wrapper = $(this).parent();
        var currentStatus = wrapper.data('accepted');

        if (currentStatus !== 'yes') {
            switchStatusToAccepted(wrapper);
        } else {
            switchStatusToRejected(wrapper);
        }
    };

    var switchStatusToAccepted = function (wrapper) {
        wrapper.addClass('accepted');
        wrapper.data('accepted', 'yes');
        console.log('ACCEPTING!');
    };

    var switchStatusToRejected = function (wrapper) {
        wrapper.removeClass('accepted');
        wrapper.data('accepted', 'no');
        console.log('REJECTING!');
    };

    var makeImagesClickable = function () {
        wrappers.on('click', toggleImageStatus);
        links.on('click', toggleImageStatus);
    };

    $('.fancybox').fancybox();

    refreshImagePropertiesByStatus();
    makeImagesClickable();
});