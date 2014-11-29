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
                container.addClass('accepted');
            } else {
                container.removeClass('accepted');
            }
        });
    };

    var toggleImageStatus = function (element) {

        var currentStatus = element.attr('data-accepted');

        if (currentStatus !== 'yes') {
            switchStatusToAccepted(element);
        } else {
            switchStatusToRejected(element);
        }
    };

    var switchStatusToAccepted = function (wrapper) {

        var pictureFilename = wrapper.find('img').attr('src');

        updateStatusOnServer(pictureFilename, true, function () {
            wrapper.addClass('accepted');
            wrapper.attr('data-accepted', 'yes');
            console.log('Satus changed to "accepted"');
        });
    };

    var switchStatusToRejected = function (wrapper) {

        var pictureFilename = wrapper.find('img').attr('src');

        updateStatusOnServer(pictureFilename, false, function () {
            wrapper.removeClass('accepted');
            wrapper.attr('data-accepted', 'no');
            console.log('Satus changed to "rejected"');
        });
    };

    var makeImagesClickable = function () {

        wrappers.on('click', function (e) {
            e.preventDefault();
            toggleImageStatus($(this));
        });

        links.on('click', function (e) {
            e.preventDefault();
            toggleImageStatus($(this).parent().find('.thumbnail-wrapper'));
        });
    };

    var updateStatusOnServer = function (pictureFilename, bool, callback) {

        $.ajax({
            type : 'POST',
            url : _root + 'project/' + getProjectSlug() + '/update-status',
            data : 'filename=' + pictureFilename,
            success : function (response) {
                if (response === 'ok') {
                    return callback();
                }

                console.error('Something went wrong with updating this picture\'s status :(');
            }
        });
    };

    var getProjectSlug = function () {

        return 'todo';
    };

    $('.fancybox').fancybox();

    refreshImagePropertiesByStatus();
    makeImagesClickable();
});