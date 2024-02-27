'use strict';
var KTDatatablesDataSourceAjaxClient = function() {
	var initTable1 = function() {
		var table = $('#kt_datatable');

		// begin first table
		table.DataTable({
			responsive: true,
            // serverSide: true,
			ajax: {
				url: '/get_business_account',
                // url: HOST_URL + '/api/datatables/demos/default.php',
				type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
				// data: {
                //     status : $("#update_status").val(),
				// },
			},
            columns: [
				{data: 'business_name'},
				{data: 'user_name'},
				{data: 'created_at'},
				{data: 'sales_name'},
				{data: 'id'},
				{data: 'camp_status'},
                {data: 'user_lock'},
				{data: 'c_date'},
                {data: 'user_lock'},
                {data: 'user_lock'},
			],
			columnDefs: [
                {
                    width : '150px',
                    targets : 0,
                },
                {
                    width : '150px',
                    targets : 1,
                },
                {
                    width : '150px',
                    targets : 2,
                    render : function(data, type, full, meta){
                        return full.id;
                        var d =  new Date(data);
                        return ("0" + (d.getMonth() + 1)).slice(-2) + ("0" + d.getDate()).slice(-2) +d.getFullYear() + full.id;
                    }
                },
                {
                    width : '150px',
                    targets : 3,
                    // render : function(data, type, full, meta){
                    //     return '<span style="cursor:pointer" onclick="update_location(`'+full.id+'`, `'+full.address+'`, `'+full.city+'`, `'+full.state+'`, `'+full.zip+'`)">'+data+'</span>';
                    // }
                },
                {
                    width : '150px',
                    targets : 4,
                    render : function(data, type, full, meta){
                        return ("<a href='/campaign-history/"+data+"'>View</a>");
                    }
                },
                {
                    width : '150px',
                    targets : 5,
                    render : function(data, type, full, meta){
                        if(data == 1){
                            return '<span class="label label-xl label-danger label-pill label-inline mr-2">Live</span>'
                        }
                        else{
                            return '<span class="label label-xl label-warning label-pill label-inline mr-2">Inactive</span>'
                        }
                    }
                },
                {
					width: '150px',
					targets: 6,
					render: function(data, type, full, meta) {
                        var html = "<select class='form-control' onchange='update_status(`"+full.id+"`, `"+data+"`)'>";
                        if(data == 0){
                            html += "<option value='0' selected>Activated</option><option value='1'>Locked out</option>";
                        }
                        else{
                            html += "<option value='0'>Activated</option><option value='1' selected>Locked out</option>";
                        }
                        html += "</select>";
                        return html;
					},
				},
                {
                    width : '100px',
                    targets : 7,
                },
                {
                    width : '100px',
                    targets : 8,
                    render : function(data, type, full, meta){
                        var html = "<a href='/edit-business/"+btoa(full.id)+"'><i class='fa fa-edit text-success mr-5'></i></a>";
                        return html;
                    }
                },
                {
                    width : '100px',
                    targets : 9,
                    "visible": false,
                },
			],
		});
        table.DataTable().columns( 9 ).search($("#update_status").val()).draw()
        $("#update_status").on('change', function(){
            table.DataTable().columns( 9 ).search($(this).val()).draw()
        })
        $("#refresh").click(function(){
            table.DataTable().ajax.reload();
        })
	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxClient.init();
});