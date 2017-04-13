
jQuery('#<?php echo get_option('stylesheet'); ?>-style-css').remove(); 

// Main AJAX function
function nexus_ajaxMe(action, postData, returnFunction, returnFunctionType) {
    jQuery.ajax({
        url: nexus_ajaxurl+'?action='+action,
        type: 'post',
        data: postData,
        processData: false,
        success: function(data) {
            var dataArray = JSON.parse(data);
            //console.log(dataArray);
            returnFunction(dataArray, returnFunctionType);
        },
        error: function(jqXHR, textStatus, errorThrown){
            //console.log(jqXHR);
        }
    });
}

// Removes some "on" events so that it doesn't return multiple times
function nexus_removeBinders() {         
    jQuery(document).off('click', '.reorder-requests');
    jQuery(document).off('input change', '.nexus_searchInput');
    jQuery(document).off('click','.assignMenu');
    jQuery(document).off('click','.assignCancel');
    jQuery(document).off('click','.downloadXML');
    jQuery(document).off('change','select[name="printers]');
}


// Functions/tools that require to be reinitilised upon new ajax page load
function nexus_init() {  

    var nexus_files = wp.media({
        title: 'Upload File(s)',
        multiple: true
    });  

    jQuery('#<?php echo get_option('stylesheet'); ?>-style-css').remove();
}

jQuery(document).ready(function ($) {

    // ---------------------------------------
    // Condensed javascript & jQuery functions
    // ---------------------------------------

    // Initial Inition
    nexus_init();

    var nexus_files = wp.media({
        title: 'Upload File(s)',
        multiple: true
    });

    nexus_files.on('open', function(e){
        var selection = nexus_files.state().get('selection'),
            ids = $('input#filelist').val().split(',');
            //console.log(ids);
        if (ids) {
            ids.forEach(function(id) {
                var attachment = wp.media.attachment(id);
                attachment.fetch();
                selection.add( attachment ? [ attachment ] : [] );
            });
        }
    });
    $(document).on('click','.fileUploadLink', function(e){
        e.preventDefault();
        var type = $(this).attr('data-type');
        nexus_files.open().on('select', function(e){
            var filesObject = nexus_files.state().get('selection'),
                filesJSON = filesObject.toJSON(),
                filesCount = Object.keys(filesJSON).length,
                fileURL, fileIDList = [];

            $(document).find('#uploadBox > ul').empty();

            for (var i = 0; i < filesCount; i++) {
                //if (i > 0) { fileIDList += ',';}
                //console.log(filesJSON);
                fileIDList.push(filesJSON[i].id);
                fileURL = filesJSON[i].url;
                if (filesJSON[i].filename && filesJSON[i].filename != 'undefined') {
                    $(document).find('#uploadBox > ul').append('<li class="singleFileContainer"><span>'+filesJSON[i].filename+'</span></li>');
                }
            }
            $('input#filelist').val(fileIDList);
            //var id = uploaded_file.toJSON().id;
            //console.log(file_url);
            // Let's assign the url value to the input field
            //$('#image_url').val(image_url);
            //$('#image_id').val(id);
        });
    });

    $('#<?php echo get_option('stylesheet'); ?>-style-css').remove();

    $(document).on('click','.nexus_uploadFiles', function(e){
        e.preventDefault();
        var type = $(this).attr('data-type'),
            files = wp.media({
                title: 'Upload File(s)',
                multiple: true
            }).open().on('select', function(e){
                var filesObject = files.state().get('selection'),
                    filesJSON = filesObject.toJSON(),
                    filesCount = Object.keys(filesJSON).length,
                    fileURL, fileIDList;

                for (var i = 0; i < filesCount; i++) {
                    if (i > 0) { fileIDList += ',';}
                    fileIDList += filesJSON[i].id;
                    fileURL = filesJSON[i].url;
                }
                //var id = uploaded_file.toJSON().id;
                //console.log(file_url);
                // Let's assign the url value to the input field
                //$('#image_url').val(image_url);
                //$('#image_id').val(id);
            });
    });

    // File uploader
    $(document).on('change', '#fileUploader', function(){
        var formData = new FormData($(this).closest('form')[0]);

        $('#loadingCircle').addClass('active');
        $('#loadingFade').addClass('active');

        for (var pair of formData.entries()) {
            //console.log(pair[0]+ ', ' + pair[1]); 
        }

        $.ajax({
            url: nexus_ajaxurl+'?action=nexus_update_attachment_ajax',
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                var dataArray = JSON.parse(data);
                //console.log(dataArray);
                var oldList = $('input#filelist').val(),
                    pre = (oldList ? '*' : ''),
                    newList = oldList+pre+dataArray['filelist'],
                    imagePreview = dataArray['mockups'];

                if (imagePreview == 'false') {
                    for (var key in dataArray['filearray']) {

                        if (dataArray['removeButton'] == 'true') {
                            var removeButton = '<a href="#" class="removeFile" data-file="'+dataArray['filearray'][key]['id']+'">X</a>';
                        } else { var removeButton = ''; }

                        $(document).find('#uploadBox > ul').append('<li class="singleFileContainer"><span>'+dataArray['filearray'][key]['name']+'</span>'+removeButton+'</li>');
                    }
                } else {
                    for (var key in dataArray['filearray']) {
                        var url = dataArray['filearray'][key]['url'], thumbSplit = url.split('.'), thumbCount = thumbSplit.length - 1,
                            thumb = url.replace('.'+thumbSplit[thumbCount], '-150x150.'+thumbSplit[thumbCount]);
                        $(document).find('#mockups').prepend('<div class="pure-u-1-2 pure-u-md-1-4 txtC singleFileContainer"><div class="pure-g"><div class="pure-u-5-5"><a href="'+url+'" class="imgPopup"><img src="'+thumb+'"></a><br><a href="#" class="removeFile" data-postid="'+dataArray['postid']+'" data-type="mockups" data-file="'+dataArray['filearray'][key]['id']+'">Remove Mockup</a></div></div></div>');
                    }
                }

                $('#loadingCircle').removeClass('active');
                $('#loadingFade').removeClass('active');

                $('input#filelist').val(newList);
            },
            error: function(jqXHR, textStatus, errorThrown){
                //console.log(jqXHR);
            }
        });
    });

    $(document).on('click', '.mobileNavButton', function(e) {
        e.preventDefault(); var toggle = ($(this).hasClass('active') ? 'close' : 'open');
        if (toggle == 'open') {
            $('.mobileNavButton').addClass('active');
            $('.navigationMenu li a:not(.active):not(.open)').addClass('open');
        } else {
            $('.mobileNavButton').removeClass('active');
            $('.navigationMenu li a:not(.active).open').removeClass('open');
        }
    });

    $(document).on('click', '.navigationMenu li a:not(.active).open', function(e) {
        $('.mobileNavButton').removeClass('active');
        $('.navigationMenu li a.open').removeClass('open');
    });

    /* $(document).on('click','.fileUploadLink',function(e){
        e.preventDefault();
        $(document).find('#fileUploader').click();
    }); */

    $(document).on('click','.removeFile',function(e){
        e.preventDefault();
        var attID = $(this).attr('data-file'),
            type = $(this).attr('data-type'),
            postid = $(this).attr('data-postid');

        $.ajax({
            url: nexus_ajaxurl+'?action=nexus_removeFile',
            type: 'post',
            data: {attachID: attID, type: type, postid: postid},
            success: function(data) {
                var dataArray = JSON.parse(data);
                //console.log(dataArray);
                $('.removeFile[data-file="'+dataArray['id']+'"]').closest('.singleFileContainer').remove();
            },
            error: function(jqXHR, textStatus, errorThrown){
                //console.log(jqXHR);
            }
        });
    });

    var md = new MobileDetect(window.navigator.userAgent);

    if(md.mobile()) { $('html').addClass('mobile'); }

    $(document).on('click', '.mobile .menuContainer .nexus_ajaxFunction', function(e){
        $('#mm-menu-toggle').click();
    });

    // Opens the menu on page load if the user is currently logged in
    <?php if (is_user_logged_in()) { ?> if(!md.mobile()) { $('#mm-menu-toggle').click(); } <?php } ?> 

    // Data Attribute Loop
        function nexus_loopData(element) {
            var dataAttr = $(element).data();
            if (dataAttr) { return dataAttr; // $.each(dataAttr, function (i, e) {//console.log(i + ":" + e); }); // For array modification
            } else { return false; }
        }

    // Onlick event to run ALL future pageload queries
        $(document).on('click','.nexus_ajaxFunction',function(e){
            e.preventDefault();
            var dataArr = nexus_loopData($(this));
            if ($(this).attr('data-update') == 'yes') { dataArr['updatestatus'] = $(document).find('select[name="jobStatus"]').val(); //console.log(dataArr['updatestatus']); }
            nexus_ajaxFunction(dataArr);
        }); 

        function nexus_ajaxFunction(dataArr) {
            nexus_removeBinders();

            var dataString = '', search = false, stats = false, menu = false;
            if (!$(this).hasClass('active')) {
                $('.nexus_ajaxFunction.active').removeClass('active');
                for (var key in dataArr) {
                    dataString += '[data-'+key+'="'+dataArr[key]+'"]';
                    if (key == 'requesttype' && dataArr[key] == 'search') { search = true; }
                    if (key == 'query' && dataArr[key] == 'statistics') { stats = true; }
                    if (key == 'menu') { menu = true; }
                }

                $('.nexus_ajaxFunction'+dataString).addClass('active');
            }

            if (search) {
                var searchString = $('#fullSiteSearch').val();
                dataArr['searchquery'] = searchString;
            }

            if (stats) {
                var startDate = $('#startDate').val(),
                    endDate = $('#endDate').val();
                dataArr['startdate'] = startDate;
                dataArr['enddate'] = endDate;
                //console.log(startDate);
                //console.log(endDate);
            }

            var queryData = dataArr;

            if (menu) {
                //console.log(nexus_ajaxurl+'?action=nexus_menuQuerySelector');
                //console.log(queryData);
                $("#ajaxNavigationContainer").slideUp('fast').load(nexus_ajaxurl+'?action=nexus_menuQuerySelector', queryData, function() { 
                    //console.log('loaded');
                    $('#ajaxNavigationContainer').slideDown(); 
                });
            }

            $("#ajaxContainer").fadeOut('fast',function(){
                $('#loadingCircle:not(.active)').addClass('active'); $('#loadingFade:not(.active)').addClass('active');
            }).load(nexus_ajaxurl+'?action=nexus_querySelector', queryData, function() {   
                $('#loadingCircle.active').removeClass('active'); $('#loadingFade.active').removeClass('active'); $('#ajaxContainer').fadeIn(); nexus_init(); 
            });
        }

        function ajaxSetHistory(atts, title, url) {
            history.pushState(atts, title, url);
        }


        $(document).on('keyup','input[name="nexus_jumpToJob"]',function(e){
            if(e.which == 13) {   
                var dataArr = {menu:'single_request', query:'single_request', postid: parseInt($(this).val(),10)};

                if ($(this).val() % 1 === 0) {
                    nexus_ajaxFunction(dataArr);
                }
            }
        }); 

    // URL modification for reload
        function reloadType(type) {
            var uri = '<?php echo $_SERVER['REQUEST_URI']; ?>',
                postType = uri.split('/');
            window.location.href='<?php echo 'http://' . $_SERVER['HTTP_HOST']; ?>/'+type+'/'+postType[2]+'/';
        }

    // Reloads the current page (will most likely add a new function to reload via AJAX instead)
        function pageReload(data) {
            nexus_ajaxFunction(data);
        }

    // Form Submit Button
        $(document).on('click', '.nexus_formSubmit', function(e){
            e.preventDefault(); var form = $(this).attr('href'), validate = $(this).attr('data-validate');
            if (validate == 'true') { 
                var validated = validateRequest(form); 
            } else { 
                var validated = true; 
            }
            if (validated) { $('form'+form).submit(); $(this).closest('form').slideUp('fast'); $('#loadingCircle').addClass('active'); $('#loadingFade:not(.active)').addClass('active'); }
        });

    // Form Submission - Standard
        $(document).on('submit', 'form.nexus_formData', function(e){
            e.preventDefault();
            var formData = $(this).serialize(), formFunction = $(this).attr('data-function');

            //console.log(formData);

            $.ajax({
                url: nexus_ajaxurl+'?action='+formFunction,
                type: 'post',
                data: formData,
                processData: false,
                success: function(data) {
                    var dataArray = JSON.parse(data);
                    //console.log(dataArray);
                    $('#loadingCircle').removeClass('active');
                    $('#loadingFade.active').removeClass('active');
                    $('#submitConfirmation').slideDown();
                },
                error: function(jqXHR, textStatus, errorThrown){
                    //console.log(jqXHR);
                }
            });
        });

    // Form Submission - AJAX
        $(document).on('click', '.nexus_ajaxSubmit', function(e){
            e.preventDefault(); var form = $(this).attr('href'), validate = $(this).attr('data-validate');
            if (validate == 'true') { 
                var validated = validateRequest(form); 
            } else { 
                var validated = true; 
            }
            if (validated) { $('form'+form).submit();  }
        });

        $(document).on('submit', 'form.nexus_ajaxForm', function(e){
            e.preventDefault();
            var formData = $(this).serialize(), formFunction = $(this).attr('data-function');

            //console.log(formFunction);

            $.ajax({
                url: nexus_ajaxurl+'?action='+formFunction,
                type: 'post',
                data: formData,
                processData: false,
                success: function(data) {
                    var dataArray = JSON.parse(data);
                    //console.log(dataArray);
                    pageReload(dataArray['array']);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    //console.log(jqXHR);
                }
            });
        });

    // Filter panel functions
        $(document).on('click','.filterToggle',function(e){
            e.preventDefault();
            $('.filterPanel').toggleClass('open');
        });

        $(window).on('click',function(){
            $('.filterPanel.open').removeClass('open');
        });

        $(document).on('click','.filterPanel',function(e){
            e.stopPropagation();
        });

    // Turn any element into an anchor/link using the "data-url" attribute (not recommended for... well, anything)
        $(document).on('click', '.clickForURL', function(e) {
            e.preventDefault();
            window.location.href = $(this).attr('data-url');
        });

    // All-purpose modal opener (no 3957458 duplicates, please)
        function openModal(modalElement, ajaxClass, nexus_ajaxurl) {
            $('body').addClass('noscroll');
            $('html').addClass('noscroll');
            $(modalElement+'.modal-frame').removeClass('state-leave').addClass('state-appear');

            if (ajaxClass && ajaxClass != '') {
                if (!$(modalElement+' .modal-body > .'+ajaxClass).hasClass('loaded')) {
                    $(modalElement+' .modal-body > .'+ajaxClass).load(nexus_ajaxurl, function(){
                        $(modalElement+' .modal-body > .loadingCircle.active').removeClass('active');
                        $(modalElement+' .modal-body > .'+ajaxClass).addClass('loaded').fadeIn();
                    });
                }
            }
        }

        $(document).on('click', '.modalButton', function(e) {
            e.preventDefault();
            var modalElement = $(this).attr('href'),
                ajaxClass = $(this).attr('data-ajaxclass'),
                nexus_ajaxurl = $(this).attr('data-nexus_ajaxurl');

            openModal(modalElement, ajaxClass, nexus_ajaxurl);
        });

    // Modal search function (for brands/masquerade)
        $(document).on('input', 'input.searchFunction', function(){
            var theVal = $(this).val(),
                theVal = theVal.toLowerCase(),
                type = $(this).attr('name');

            if (theVal != '') {
                $('div.'+type+'[data-name*="'+theVal+'"]').each(function() { $(this).fadeIn(); });
                $('div.'+type).not('[data-name*="'+theVal+'"]').each(function() { $(this).fadeOut(); });
            } else {
                $('.'+type).each(function() { $(this).fadeIn(); });
            }
        });

    // Modal search result picker
        $(document).on('click', '.modalSearchResult', function(e){
            e.preventDefault();
            var type = $(this).attr('data-type'),
                field = $(this).attr('data-type'),
                modalElement = $(this).closest('.modal-frame').attr('id'),
                resultID = $(this).attr('data-num'),
                resultValue = $(this).attr('data-value');

            //console.log(modalElement);

            if (resultValue && resultValue != '') { $(document).find('input[name="'+field+'"]').val(resultValue); }
            $(document).find('.'+type+'IMG img').attr('src',$(document).find('#pickerIMG-'+resultID).attr('src'));
            $(document).find('.'+type+'NameForm').html($(document).find('#pickerName-'+resultID).html());

            $('body').removeClass('noscroll');
            $('html').removeClass('noscroll');
            $(document).find(modalElement+'.modal-frame').removeClass('state-appear').addClass('state-leave');
        });

    // CGI XML List Generator
        $('.parseCGI').on('click',function(e){
            e.preventDefault();
            var valid = validateRequest($('.parseCGI').parent('form'));

            if (valid) {
                var CGIList = $('textarea[name="CGIList"]').val(),
                    directory = $('input[name="directory"]').val(),
                    data = {CGIList: CGIList, directory:directory};

                $('.cgiForm').slideUp(); $('#loadingCircle').addClass('active');
                $('#loadingFade:not(.active)').addClass('active');

                function callback(dataArray) { 
                    $('.parsedCGI > #selectable').html(dataArray['html']).delay(1000).parent('.parsedCGI').slideDown(function(){
                        $('#loadingCircle').removeClass('active'); $('#loadingFade.active').removeClass('active');
                    }); 
                }

                nexus_ajaxMe('CGIParser', data, callback);
            }
        });

    // Export CGI form XML for Filezilla
        function saveTextAsFile() {
            var textToWrite = $('.parsedCGI > #selectable').html(),
                textToWrite = textToWrite.replace(/<br>/g,'\n'),
                textToWrite = textToWrite.replace(/&lt;/g,'<'),
                textToWrite = textToWrite.replace(/&gt;/g,'>');
            var textFileAsBlob = new Blob([textToWrite], {type:'application/xml'});
            var fileNameToSaveAs = '<?php echo date('d-m-Y'); ?>_cgiform_filezilla_queue.xml';

            var downloadLink = document.createElement("a");
            downloadLink.download = fileNameToSaveAs;
            downloadLink.innerHTML = "Download File";

            downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
            downloadLink.onclick = destroyClickedElement;
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);

            downloadLink.click();
        }

        $('.downloadXML').on('click', function(e){
            e.preventDefault();
            saveTextAsFile();
        });

    // Remove element that is clicked/targeted
        function destroyClickedElement(event) {
            document.body.removeChild(event.target);
        }

    // Load and pop up a preview of a request (may remove in revised system)
        function nexus_getRequestPreview(reqID) {
            var data = { reqID: reqID };
            function callback(dataArray) {
                $('#requestHoverDetails .pure-u-5-5 .requestDetails').html(dataArray['html']);
                $('#requestHoverDetails .pure-u-5-5 .requestDetails').attr('data-reqid',reqID);
                openModal('#requestHoverDetails');
            }
            nexus_ajaxMe('nexus_getRequestPreview', data, callback);
        }

        $('.requestContainer').on('click', function(e){
            e.preventDefault();
            nexus_getRequestPreview($(this).attr('data-id'));
        });

    // Capitalise the first letter of a string... In javascript... (Not sure why either)
        function capitalizeFirstLetter(string) { 
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

    // PLACE THESE INTO THE RELEVANT POPUPS UPON SYSTEM REVISION ---------------------- <<<<<<<<<<<<<<<<<<<<<
        $(document).on('change', 'select[name="printers"]', function(e){
            var theVal = $(this).val();
            if (theVal == 'na' || theVal == 'No Printer') {
                $('.hidePrinterOptions').each(function(){
                    $(this).fadeOut('fast');  
                });
            } else {
                $('.hidePrinterOptions').each(function(){
                    $(this).fadeIn();  
                });
            }
        });
    // PLACE THESE INTO THE RELEVANT POPUPS UPON SYSTEM REVISION ---------------------- <<<<<<<<<<<<<<<<<<<<<

    // Form Submission (collate these at bottom?)
        $('form#desBIO').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            nexus_ajaxMe('addBio', formData, pageReload);
        });

    // Allow selected feedback to be used on designer carousel
        $('input[type="checkbox"][name="useFeedback"]').on('click',function(){

            if (this.checked) { var checkMe = 'yes'; } else { var checkMe = 'no'; }
            var theID = $(this).attr('data-id'),
                data = {useMe: checkMe, theID: theID};

            nexus_ajaxMe('useFeedback', data, pageReload);
        });

    // Function for stealing a request from someone else
        $('.stealButton').on('click',function(e){
            e.preventDefault();

            var theID = $(this).attr('data-id'),
                newDesigner =  $(this).attr('data-newid'),
                data = {newDesigner: newDesigner, theID: theID};

            nexus_ajaxMe('nexus_stealRequest', data, pageReload);
        });

    // Button for assigning a designer to a request (try and break this down to just one function)
        $(document).on('click','.assignButton',function(e){
            e.preventDefault();
            var userID = $(this).attr('data-user'),
                assign = $(this).attr('data-assign'),
                data = { theID: userID, thePost: assign, redirect: 'true' };

            nexus_ajaxMe('nexus_assignUser',data,pageReload);
        });
        $(document).on('click','.assignDesigner',function(e){
            e.preventDefault();
            var userID = $(this).attr('data-user'),
                assign = $(this).attr('data-assign'),
                data = { theID: userID, thePost: assign, redirect: 'false' };

            nexus_ajaxMe('nexus_assignUser',data,pageReload);
        });

    // Switching Date for Statistics Page (Update to AJAX soon!)
        $('select.statsDate').on('change', function(){
            var theType = $(this).attr('name'),
                theVal = $(this).val(),
                endYear = $('select[name="endYear"]').val(),
                startYear = $('select[name="startYear"]').val(); 

            if (theVal != 'na') {
                window.location.href='<?php echo get_bloginfo('url'); ?>/statistics/?startYear='+startYear+'&endYear='+endYear;
            }
        });

    $(document).on('click','.approveUser',function(e){
        e.preventDefault();
        var userID = $(this).attr('data-id');

        $.ajax({
            url: nexus_ajaxurl+'?action=nexus_approveUser',
            type: 'post',
            data: {userID: userID},
            success: function(data) {
                var dataArr = JSON.parse(data);
                //console.log(dataArr);      
                if (dataArr['removeClass']) { $(document).find('.pending').removeClass('pending'); }
                pageReload(dataArr['array']);
            },
            error: function(jqXHR, textStatus, errorThrown){
                //console.log(jqXHR);
            }
        });
    });

    $(document).on('click','.rejectUser',function(e){
        e.preventDefault();
        var userID = $(this).attr('data-id');

        $.ajax({
            url: nexus_ajaxurl+'?action=nexus_rejectUser',
            type: 'post',
            data: {userID: userID},
            success: function(data) {
                var dataArr = JSON.parse(data);
                //console.log(dataArr);          
                if (dataArr['removeClass']) { $(document).find('.pending').removeClass('pending'); }          
                pageReload(dataArr['array']);
            },
            error: function(jqXHR, textStatus, errorThrown){
                //console.log(jqXHR);
            }
        });
    });    

    // Signoff Function
        $('.signOffButton').on('click',function(e){
            e.preventDefault();
            var stage = $(this).attr('data-stage'),
                type = $(this).attr('data-type'),
                project = $(this).attr('data-project'),
                signee = $(this).attr('data-signee'),
                data = { project: project, type: type, stage: stage, signee: signee };

            nexus_ajaxMe('nexus_signOff',data, pageReload);
        });

        $('.noSignOffButton').on('click',function(e){
            e.preventDefault();
            var stage = $(this).attr('data-stage'),
                type = $(this).attr('data-type'),
                project = $(this).attr('data-project'),
                signee = $(this).attr('data-signee'),
                data = { project: project, type: type, stage: stage, signee: signee };

            nexus_ajaxMe('noSignOff',data, pageReload);
        });

    // Delete a publication        
        $('.deletePub').on('click',function(e){
            e.preventDefault();
            var pubID = $(this).attr('data-id'),
                data = { pubID : pubID };

            nexus_ajaxMe('deletePublication', data, pageReload);
        });

    // Reject/Cancel Request         
        $('.cancelButton').on('click',function(e){
            e.preventDefault();
            var type = $(this).attr('data-type'),
                project = $(this).attr('data-project'),
                reasonArray = [], data;

            $('input[type=checkbox].css-checkbox:checked').each(function(){
                if ($(this).attr('ID') == 'reason-3') {
                    reasonArray.push($('input[name="otherRejection"]').val());
                } else {
                    reasonArray.push($(this).val());
                }
            });

            data = {project: project, type: type, reasons: reasonArray};

            function callback() { // WILL HAVE TO CHANGE WITH THE AJAXIFICATION
                var uri = '<?php echo $_SERVER['REQUEST_URI']; ?>',
                    postType = uri.split('/');
                window.location.href='<?php echo 'http://' . $_SERVER['HTTP_HOST']; ?>/cancelled/'+postType[2]+'/';
            }

            nexus_ajaxMe('nexus_denyRequest', data, callback);
        });

    /* Need this to clear out the keyframe classes so they dont clash with each other between enter/leave. Cheers. */
        $(document).bind('webkitAnimationEnd oanimationend msAnimationEnd animationend', '.modal-frame', function(e) {
            $('.modal-frame.state-leave').removeClass('state-leave');
        });

    // Close the modal popups
        $('.close').on('click', function(e) {
            e.preventDefault();
            $('.hideAfterModal').slideUp('fast');
            $('.showAfterModal').slideDown();
            $('body').removeClass('noscroll');
            $('html').removeClass('noscroll');
            $(this).closest('.modal-frame').removeClass('state-appear').addClass('state-leave');
        });

    // Validation of forms (checks for .required class and validates them - could be expanded upon for emails etc)
        function validateRequest(form) {
            var validated = true, currentUser = <?php $current_user = wp_get_current_user(); echo $current_user->ID; ?>;
            $('label.red').removeClass('red');  $('select.red').removeClass('red'); 
            $(form).find('.required').each(function(){
                var theID = $(this).attr('name'), value = $(this).val();
                if (!value || value == 'na') {
                    validated = false;
                    $(this).parent('div').find('label').addClass('red');
                    $('select[name="'+theID+'"]').addClass('red');
                    $(this).parent('div').addClass('error');
                }
            });

            return validated;
        }

    // Gets rid of modal when background is clicked
        $(document).on('click','.modal-frame.state-appear', function(e) {
            if (e.target !== this) { return; }
            e.preventDefault();
            $('.hideAfterModal').slideUp('fast');
            $('.showAfterModal').slideDown();
            $('body').removeClass('noscroll');
            $('html').removeClass('noscroll');
            $(this).removeClass('state-appear').addClass('state-leave');
        });

    // Email Export Fix
        $(document).on('click','#sim-edit-export', function(e) {
            if (e.target !== this) { return; }
            e.preventDefault();
            $(this).find('.sim-edit-box').slideUp(500);
            $(this).fadeOut(500);
        });

    // Feedback submit and validation (maybe tie into normal validation function?)
        $('.feedbackSubmit').on('click',function(e){
            e.preventDefault();
            if ($('label[for="feedbackText"]').hasClass('red')) {
                $('label[for="feedbackText"]').removeClass('red');
            }
            if ($('.ratingLabel').hasClass('red')) {
                $('.ratingLabel').removeClass('red');
            }

            var nope = false;

            if (!$('input[name="rating"]:checked').val() ) {
                $('.ratingLabel').addClass('red'); nope = true;
            }
            if (!$('textarea[name="feedbackText"]').val()) {
                $('label[for="feedbackText"]').addClass('red'); nope = true;
            }

            if (nope) { return; }

            $('form#feedback').submit();
        });

    // Clicks the hidden image upload button
        $(document).on('click','.userPhotoUpload', function(e){
            e.preventDefault();
            var type = $(this).attr('data-type');
            $('#uploadType').val(type);
            $('#imageUpload').click();
        });

    // Submits image upload form
        $('#imageUpload').on('change',function(){
            //console.log($(this).val());
            $('#uploadDatImage').submit();
        });

    // Uploads dat image (keeping due to the extra fields needed for successful image upload)        
        $('#uploadDatImage').submit(function(event) {
            event.preventDefault();
            var theForm = $('#uploadDatImage')[0],
                formData = new FormData(theForm);
            //console.log(theForm);
            $.ajax({
                url: nexus_ajaxurl+'?action=nexus_userImageUpload',
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data){
                    var dataArray = JSON.parse(data);
                    if (dataArray['type'] != 'background') {
                        $('.currentUserView .userImage').css('background-image','url('+dataArray['img']+')');
                    } else {
                        nexus_ajaxFunction(dataArray['array']);
                    }
                },
                error: function(data) {
                    //console.log("Image didn't upload!");
                }
            });
        });

    // File upload functions
        $( '.inputfile' ).each( function() {
            var $input	 = $( this ),
                $label	 = $input.next( 'label' ),
                labelVal = $label.html();

            $input.on( 'change', function( e )
            {
                var fileName = '';
                $(this).closest('form').removeClass('error');

                if( this.files && this.files.length > 1 )
                    fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
                else if( e.target.value )
                    fileName = e.target.value.split( '\\' ).pop();

                if( fileName )
                    $label.find( 'span' ).html( fileName );
                else
                    $label.html( labelVal );
            });

            // Firefox bug fix
            $input
            .on( 'focus', function(){ $input.addClass( 'has-focus' ); })
            .on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
        });

    // Datepicker options
        var date = new Date();
        date.setDate(date.getDate() + 1);

        $(document).on('click','.datepicker:not(.minToday)', function(){
            if ($(this).attr('data-pik') != 'active') {
                var pikaday = new Pikaday({
                   field: this,
                   format: 'DD-MM-YYYY'      
               });

                $(this).attr('data-pik','active');

               $(this).data('pikaday', pikaday).addClass('pikaday');

               pikaday.show();
            }
        });

        $(document).on('click','.datepicker.minToday', function(){
            if ($(this).attr('data-pik') != 'active') {
                var pikaday = new Pikaday({
                    field: this,
                    disableWeekends:true, 
                    minDate:date,
                    format: 'DD-MM-YYYY'      
                }); 

                $(this).attr('data-pik','active');

                $(this).data('pikaday', pikaday).addClass('pikaday');

                pikaday.show();
            }
        });

    // Mockup Submission
        $(document).on('click', '.mockupSubmit',function(e){
            e.preventDefault();
            $('form#uploadMockup').removeClass('error');
            if (document.getElementById('mockupUpload').files.length > 0 ) {
                $('form#uploadMockup').submit();
            } else {
                $('form#uploadMockup').addClass('error');
                $('form#uploadMockup label[for="mockupUpload"] > span').html('No Images Selected');
            }
        });

    // Mockup Upload Function        
        $('form#uploadMockup').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);

            $('#mainForm').fadeOut('fast');
            $('#lean_overlay').fadeOut('fast');
            $('#loadingCircle').addClass('active'); 
            $('#loadingFade:not(.active)').addClass('active');

            $.ajax({
                url: nexus_ajaxurl+'?action=nexus_adminFileUpload',
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#loadingCircle').removeClass('active');
                    $('#mockupNote').fadeIn('fast');
                    $('#loadingFade.active').removeClass('active');
                    var dataArray = JSON.parse(data);
                    //console.log(dataArray);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    //console.log(jqXHR);
                }
            });
        });
}); 