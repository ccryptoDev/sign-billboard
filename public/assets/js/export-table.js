"use strict";
var KTDatatablesDataSourceHtml = function() {

	var initTable1 = function() {
		var table = $('#kt_datatable');

		// begin first table
		table.DataTable({
			responsive: true,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			iDisplayLength : 25,
			order : [0, 'desc'],
			columnDefs: [
			],
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			]
		});
		// $(".inv_status").on('change', function(){
		// 	var search_val = $(this).val();
		// 	table.DataTable()
		// 		.columns( 8 )
		// 		.search( search_val )
		// 		.draw();
		// })
	};

	// $('.payment_method').select2({
	// 	placeholder: "Select a payment method"
	// });
	// $('#kt_datatable').on('select2:select','.payment_method',function (e) {
	// // $(".payment_method").on('select2:select', function(e){
	// 	var init = $(this).attr('data-val');
	// 	var data = $(this).val();
	// 	var approve = true;
	// 	for(var i = 0; i < data.length; i++){
	// 		if(data[i] == 0 && data.length > 1){
	// 			approve = false;
	// 		}
	// 	}
	// 	if(approve == false){
	// 		$(this).val(init);
	// 		$(this).trigger('change');
	// 		toastr.error("You can't select 'Free' plan in this business");
	// 		return;
	// 	}
	// 	$(this).attr('data-val', $(this).val());
	// 	$.ajax({
	// 		url : "/change-payment-method",
	// 		type : "POST",
	// 		data : {
	// 			business_name : $(this).data('name'),
	// 			method : $(this).val(),
	// 		},
	// 		success : function(res){
	// 			if(res == 'success'){
	// 				toastr.success('success');
	// 			}
	// 			else{
	// 				toastr.error(res);
	// 			}
	// 		},
	// 		error : function(err){
	// 			toastr.error("Please refresh your browser");
	// 		}
	// 	})
	// })
	// $(".payment_method").on('select2:unselect', function(){
	// 	// $(this).attr('data-val', $(this).val());
	// 	$.ajax({
	// 		url : "/change-payment-method",
	// 		type : "POST",
	// 		data : {
	// 			business_name : $(this).data('name'),
	// 			method : $(this).val(),
	// 		},
	// 		success : function(res){
	// 			if(res == 'success'){
	// 				toastr.success('success');
	// 			}
	// 			else{
	// 				toastr.error(res);
	// 			}
	// 		},
	// 		error : function(err){
	// 			toastr.error("Please refresh your browser");
	// 		}
	// 	})
	// })
	// $(".start_date, .end_date").on('change', function(){
	// 	var tag = $(this).parent().parent();
	// 	$.ajax({
	// 		url : "/change-payment-date",
	// 		type : "POST",
	// 		data : {
	// 			business_name : $(this).data('name'),
	// 			start_date : tag.find('.start_date').val(),
	// 			end_date : tag.find('.end_date').val(),
	// 			method : tag.find(".payment_method").val(),
	// 		},
	// 		headers: {
	// 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 		},
	// 		success : function(res){
	// 			if(res == 'success'){
	// 				toastr.success('success');
	// 			}
	// 			else{
	// 				toastr.error(res);
	// 			}
	// 		},
	// 		error : function(err){
	// 			toastr.error("Please refresh your browser");
	// 		}
	// 	})
	// })

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesDataSourceHtml.init();
});