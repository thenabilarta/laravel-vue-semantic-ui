var BAP_Account = {

    init: function () {

        this.uploadProfilePicture();
        this.notifications();
    },
    uploadProfilePicture: function(){

        $('#profile_picture').fileinput({
            dropZoneEnabled: false,
            uploadAsync: false,
            showUpload: false,
            showRemove: false,
            showCaption: true,
            maxFileCount: 1,
            showBrowse: true,
            browseOnZoneClick: true,
        })

    },

    notifications: function(){

        //TODO Finish this
        //Mark as read / new
        //Load more on scroll

    }

}

BAP_Account.init();
