/*
 * jQuery File Upload Plugin JS Example 6.0.3
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*jslint nomen: true, unparam: true, regexp: true */
/*global $, window, document */

$(function () {
    'use strict';
    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload();
        // Load existing files:
        $.getJSON($('#fileupload').prop('action'),{name:$("#upselect").val()}, function (files) {
            var fu = $('#fileupload').data('fileupload'),
                template;
            fu._adjustMaxNumberOfFiles(-files.length);
            template = fu._renderDownload(files)
               .appendTo($('#fileupload .files'));
            // Force reflow:
            fu._reflow = fu._transition && template.length &&
             template[0].offsetWidth;
            template.addClass('in');
});
    

    // Enable iframe cross-domain access via redirect page:
    var redirectPage = window.location.href.replace(
        /\/[^\/]*$/,
        '/cors/result.html?%s'
    );
    $('#fileupload').bind('fileuploadsend', function (e, data) {
        if (data.dataType.substr(0, 6) === 'iframe') {
            var target = $('<a/>').prop('href', data.url)[0];
            if (window.location.host !== target.host) {
                data.formData.push({
                    name: 'redirect',
                    value: redirectPage
                });
            }
        }
    });

    // Open download dialogs via iframes,
    // to prevent aborting current uploads:
    $('#fileupload .files').delegate(
        'a:not([rel^=gallery])',
        'click',
        function (e) {
            e.preventDefault();
            $('<iframe style="display:none;"></iframe>')
                .prop('src', this.href)
                .appendTo(document.body);
        }
    );

    // Initialize the Bootstrap Image Gallery plugin:
    $('#fileupload .files').imagegallery();

});
$(document).ready(function(){
	  $("#showup").click(function(){
			  $("#fcontainer").show("fast");
			  $("#welcome").hide("fast");
			return false;
    }); 
	$("#uploadcomplete").click(function(){
			  $("#fcontainer").hide("fast");
			  $("#welcome").show("fast");
			return false;
    });
	$("#upselect").change(function(){
			$('#fileupload .files').empty();
		     $.getJSON($('#fileupload').prop('action'),{name:$("#upselect").val()}, function (files) {
            var fu = $('#fileupload').data('fileupload'),
                template;
			if(files.length==0)
				$('#fileupload .files').html("<center>画集里还没有文件，请点击[添加文件] 或把图片拖放到浏览器中上传</center>");
            fu._adjustMaxNumberOfFiles(-files.length);
            template = fu._renderDownload(files)
               .appendTo($('#fileupload .files'));
            // Force reflow:
            fu._reflow = fu._transition && template.length &&
             template[0].offsetWidth;
            template.addClass('in');
			});
	});
	$("#groupsubmit").click(function()
	{
			 $.ajax({                                                
			type: "POST",                                 
			url: "/imagegroup/new",                                    
			data: "groupname="+$("#groupname").val()+"&groupdescription="+$("#groupdescription").val()+"&groupcatalog="+$("#groupcatalog").val(),   
			success: function(msg){                 
				 $("#upselect").html(msg);    
				 $("#upselect").change();
				 $("#groupnotice").show("fast");
			}    
			});  
	});
});

