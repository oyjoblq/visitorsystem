$(document).ready(function(){
  var table_visitors = $('#table_visitors').dataTable({
    "ajax": "reportdata.php?job=get_visitors",
    "columns": [
        { "data": "last_name"},
		{ "data": "first_name"},
		{ "data": "psid"},
		{ "data": "issuer"},      
	  	{ "data": "bday"},
      	{ "data": "phone"},
		{ "data": "email"},      
     	{ "data": "functions",      "sClass": "functions" }
    ],
    "aoColumnDefs": [
      { "bSortable": false, "aTargets": [-1] }
    ],
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    "oLanguage": {
      "oPaginate": {
        "sFirst":       " ",
        "sPrevious":    " ",
        "sNext":        " ",
        "sLast":        " ",
      },
      "sLengthMenu":    "Records per page: _MENU_",
      "sInfo":          "Total of _TOTAL_ records (showing _START_ to _END_)",
      "sInfoFiltered":  "(filtered from _MAX_ total records)"
    }
  });
  
  // On page load: form validation
  jQuery.validator.setDefaults({
    success: 'valid',
    errorPlacement: function(error, element){
      error.insertBefore(element);
    },
    highlight: function(element){
      $(element).parent('.field_container').removeClass('valid').addClass('error');
    },
    unhighlight: function(element){
      $(element).parent('.field_container').addClass('valid').removeClass('error');
    }
  });
  var form_visitor = $('#form_visitor');
  form_visitor.validate();

  // Show message
  var timeout_message;
  function show_message(message_text, message_type){
    $('#message').html('<p>' + message_text + '</p>').attr('class', message_type);
    $('#message_container').show();
    if (typeof timeout_message !== 'undefined'){
      window.clearTimeout(timeout_message);
    }
    timeout_message = setTimeout(function(){
      hide_message();
    }, 8000);
  }
  // Hide message
  function hide_message(){
    $('#message').html('').attr('class', '');
    $('#message_container').hide();
  }

  // Show loading message
  function show_loading_message(){
    $('#loading_container').show();
  }
  // Hide loading message
  function hide_loading_message(){
    $('#loading_container').hide();
  }

  // Show lightbox
  function show_lightbox(){
    $('.lightbox_bg').show();
    $('.lightbox_container').show();
  }
  // Hide lightbox
  function hide_lightbox(){
    $('.lightbox_bg').hide();
    $('.lightbox_container').hide();
  }
  // Lightbox background
  $(document).on('click', '.lightbox_bg', function(){
    hide_lightbox();
  });
  // Lightbox close button
  $(document).on('click', '.lightbox_close', function(){
    hide_lightbox();
  });
  // Escape keyboard key
  $(document).keyup(function(e){
    if (e.keyCode === 27){
      hide_lightbox();
    }
  });
  
  // Hide iPad keyboard
  function hide_ipad_keyboard(){
    document.activeElement.blur();
    $('input').blur();
  } 

  // Edit visitor button
  $(document).on('click', '.function_edit a', function(e){
    e.preventDefault();
    // Get visitor information from database
    show_loading_message();
    var id      = $(this).data('id');
    var request = $.ajax({
      url:          'reportdata.php?job=get_visitor',
      cache:        false,
      data:         'id=' + id,
      dataType:     'json',
      contentType:  'application/json; charset=utf-8',
      type:         'get'
    });
    request.done(function(output){
      if (output.result === 'success'){
        $('.lightbox_content h2').text('Edit Visitor');
        $('#form_visitor button').text('Edit Visitor');
		$('#form_visitor').attr('class', 'form edit');
        $('#form_visitor').attr('data-id', id);
        $('#form_visitor .field_container label.error').hide();
        $('#form_visitor .field_container').removeClass('valid').removeClass('error');
      
			  
        $('#form_visitor #last_name').val(output.data[0].last_name);
		$('#form_visitor #first_name').val(output.data[0].first_name);
		$('#form_visitor #psid').val(output.data[0].psid);
        
        hide_loading_message();
        show_lightbox();
      } else {
		 
        		hide_loading_message();
        		show_message('Information request failed', 'error');
			
      }
    });
    request.fail(function(jqXHR, textStatus){
      hide_loading_message();
      show_message('Information request failed: ' + textStatus, 'error');
    });
  });
  
  // Edit visitor submit form
  $(document).on('submit', '#form_visitor.edit', function(e){
    e.preventDefault();
    // Validate form
    if (form_visitor.valid() === true){
      // Send edited visitor information to database
      hide_ipad_keyboard();
      hide_lightbox();
      show_loading_message();
      var id        = $('#form_visitor').attr('data-id');
      var form_data = $('#form_visitor').serialize();
      var request   = $.ajax({
        url:          'reportdata.php?job=edit_visitor&id=' + id ,
        cache:        false,
        data:         form_data,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'get'
      });
      request.done(function(output){
        if (output.result === 'success'){
          // Reload datable
          	table_visitors.api().ajax.reload(function(){
            hide_loading_message();
            var full_name = $('#first_name').val() + ' ' + $('#last_name').val();
            show_message("Visitor '" + full_name + "' edited successfully.", 'success');
          }, true);
        } else {
			
          hide_loading_message();
          show_message('Edit request failed', 'error');
			
        }
      });
      request.fail(function(jqXHR, textStatus){
        hide_loading_message();
        show_message('Edit request failed: ' + textStatus, 'error');
      });
    }
  });
  
  // Delete visitor
  $(document).on('click', '.function_delete a', function(e){
    e.preventDefault();
    var last_name = $(this).data('name');
    if (confirm("Are you sure you want to delete '" + last_name + "'?")){
      show_loading_message();
      var id      = $(this).data('id');
      var request = $.ajax({
        url:          'reportdata.php?job=delete_visitor&id=' + id,
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'get'
      });
      request.done(function(output){
        if (output.result === 'success'){
          // Reload datable
          table_visitors.api().ajax.reload(function(){
            hide_loading_message();
            show_message("Visitor '" + last_name + "' deleted successfully.", 'success');
          }, true);
        } else {
		
          hide_loading_message();
          show_message('Delete request failed', 'error');
			
        }
      });
      request.fail(function(jqXHR, textStatus){
        hide_loading_message();
        show_message('Delete request failed: ' + textStatus, 'error');
      });
    }
  });

});
