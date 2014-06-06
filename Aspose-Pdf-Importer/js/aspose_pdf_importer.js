jQuery(document).ready(function(){

    jQuery.ajax
    ({
        type : "post",
        dataType : "html",
        url : AsposeParams['aspose_files_url'],
        data : {appSID: AsposeParams['appSID'], appKey : AsposeParams['appKey']},
        success: function(response) {
            $('#aspose_cloud').append(response);

        }
    });

    $('#aspose_folder_name').live('change',function() {
        var selected_folder_name = $(this).val();
        if(selected_folder_name != '') {
            jQuery.ajax
            ({
                type : "post",
                dataType : "html",
                url : AsposeParams['aspose_files_url'],
                data : {appSID: AsposeParams['appSID'], appKey : AsposeParams['appKey'], aspose_folder : selected_folder_name},
                success: function(response) {
                    $('#aspose_cloud').html(response);

                }
            });
        }
    });



    $('#tabs').tabs();
    $("#select_pdf_file").uploadify({


        fileTypeDesc : 'Pdf Files',
        fileTypeExts : '*.pdf',
        queueID      : 'itemqueue',
        swf          : AsposeParams['swf'],
        uploader     : AsposeParams['uploader'],
        formData     : {'folder' : AsposeParams['folder'] },
        buttonText   : 'Select Pdf File',
        onUploadSuccess : function(file, data, response){

            $('#pdf_file_name').val(file.name);
        }

    });

    $('#insert_pdf_content').live('click',function(){
        var filename = $('#pdf_file_name').val();
        $(this).parent().parent().parent().parent().parent().parent().parent().parent().fadeOut();
        $body = $("body");
        $body.addClass("loading");

        jQuery.ajax
        ({
            type : "post",
            dataType : "html",
            url : AsposeParams['insert_pdf_url'],
            data : {appSID: AsposeParams['appSID'], appKey : AsposeParams['appKey'], filename : filename, uploadpath: AsposeParams['folder']},
            success: function(response) {
                window.send_to_editor(response);
                $body.removeClass("loading");

            }
        });
    });

    $('#insert_aspose_pdf_content').live('click',function(){
        var filename = $('input[name="aspose_filename"]:checked').val();
        $(this).parent().parent().parent().parent().parent().parent().parent().parent().fadeOut();
        $body = $("body");
        $body.addClass("loading");

        jQuery.ajax
        ({
            type : "post",
            dataType : "html",
            url : AsposeParams['insert_pdf_url'],
            data : {appSID: AsposeParams['appSID'], appKey : AsposeParams['appKey'], filename : filename, uploadpath: AsposeParams['folder'] , aspose : '1'},
            success: function(response) {
                window.send_to_editor(response);
                $body.removeClass("loading");

            }
        });

    });


});


