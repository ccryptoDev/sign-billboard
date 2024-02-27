"use strict";
function deleteGallery(id) {
  $.ajax({
    type : "POST",
    url : '/delete-gallery',
    data : {
      id : id
    },
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success : function(res){
      $('#kt_datatable').DataTable().ajax.reload();
    },
    error : function(res){
    }
  });
}
function updateGallery(id, text){
  $("#u_id").val(id);
  $("#frmUpdate input[name='text']").val(text);
  $(".btn-update").click();
}
var KTDatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {
		var table = $('#kt_datatable');

		// begin first table
		table.DataTable({
			responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			ajax: {
				url: '/get-gallery',
				type: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
				data: {
					// parameters for custom backend script demo
					columnsDef: [
						'url', 'created_at'
          ],
				},
			},
			columns: [
				{data: 'url'},
				{data: 'name'},
				{data: 'date'},
				{data: 'Actions', responsivePriority: -1},
			],
			columnDefs: [
				{
					targets: -1,
					title: 'Actions',
					orderable: false,
					render: function(data, type, full, meta) {
						return '\
              <a href="javascript:;" class="btn btn-sm btn-success btn-icon" title="Delete" onclick="updateGallery(`' + full.id + '`, `' + full.name + '`)">\
								<i class="la la-edit"></i>\
							</a>\
							<a href="javascript:;" class="btn btn-sm btn-danger btn-icon" title="Delete" onclick="deleteGallery(' + full.id + ')">\
								<i class="la la-trash"></i>\
							</a>\
						';
					},
				},
				{
					targets: 0,
					render: function(data, type, full, meta) {
						return '<img src=/gallery/' +data+ ' style="max-width: 100px">'
					},
				}
			],
		});
	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxServer.init();
});