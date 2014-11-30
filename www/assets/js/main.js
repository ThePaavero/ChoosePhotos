$(function () {

    console.log('App running...');

    var ul = $('ul');
    var wrappers = ul.find('li .thumbnail-wrapper');
    var links = ul.find('li a.accept-link, li a.reject-link');

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

        var fileUrlSegments = wrapper.find('img').attr('src').split('/');
        var pictureFilename = fileUrlSegments[fileUrlSegments.length - 1];
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

        var fileUrlSegments = wrapper.find('img').attr('src').split('/');
        var pictureFilename = fileUrlSegments[fileUrlSegments.length - 1];
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

        NProgress.start();

        $.ajax({
            type : 'POST',
            url : _root + 'project/' + projectSlug + '/update-status',
            data : 'project_slug=' + projectSlug + '&filename=' + pictureFilename,
            success : function (response) {

                NProgress.done();

                if (response === 'ok') {
                    return callback();
                }

                console.error('Something went wrong with updating this picture\'s status :(');
            }
        });
    };

    var getProjectSlug = function () {

        var slug = ul.attr('data-projectslug');
        return slug;
    };

    var listenForEmailLinks = function () {

        var links = $('.send-email-link');

        links.on('click', function (e) {

            e.preventDefault();
            var link = $(this);
            NProgress.start();
            link.attr('disabled', true);

            $.ajax({
                url : link.attr('href'),
                success : function (response) {

                    NProgress.done();

                    if (response === 'ok') {
                        console.log('Yeah!');
                    } else {
                        alert(response);
                    }

                    setTimeout(function () {
                        link.attr('disabled', false);
                    }, 1000);
                }
            });
        });
    };

    $('.fancybox').fancybox();

    refreshImagePropertiesByStatus();
    makeImagesClickable();
    listenForEmailLinks();
});