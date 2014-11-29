$(function () {

    console.log('App running...');

    var wrappers = $('ul li .thumbnail-wrapper');
    var links = $('ul li a.accept-link, ul li a.reject-link');

    var refreshImagePropertiesByStatus = function () {

        wrappers.each(function () {

            var wrapper = $(this);
            var container = wrapper.parent();
            var currentStatus = wrapper.attr('data-accepted');
            console.log(currentStatus);

            if (currentStatus === 'yes') {
                container.addClass('accepted');
                container.find('a.accept-link').hide();
                container.find('a.reject-link').show();
            } else {
                container.removeClass('accepted');
                container.find('a.accept-link').show();
                container.find('a.reject-link').hide();
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
        var projectSlug = getProjectSlug();

        updateStatusOnServer(projectSlug, pictureFilename, true, function () {
            wrapper.addClass('accepted');
            wrapper.attr('data-accepted', 'yes');
            wrapper.parent().find('a.accept-link').hide();
            wrapper.parent().find('a.reject-link').show();
            console.log('Satus changed to "accepted"');
        });
    };

    var switchStatusToRejected = function (wrapper) {

        var pictureFilename = wrapper.find('img').attr('src');
        var projectSlug = getProjectSlug();

        updateStatusOnServer(projectSlug, pictureFilename, false, function () {
            wrapper.removeClass('accepted');
            wrapper.attr('data-accepted', 'no');
            wrapper.parent().find('a.accept-link').show();
            wrapper.parent().find('a.reject-link').hide();
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

    var updateStatusOnServer = function (projectSlug, pictureFilename, bool, callback) {

        $.ajax({
            type : 'POST',
            url : _root + 'project/' + getProjectSlug() + '/update-status',
            data : 'project_slug=' + projectSlug + '&filename=' + pictureFilename,
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