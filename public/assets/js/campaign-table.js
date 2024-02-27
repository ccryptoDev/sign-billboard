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
            dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			]
		});

        $(".business-name").on('change', function(){
            var search_val = $(this).val();
			table.DataTable()
				.columns( 1 )
				.search( search_val )
				.draw();
        })
		$(".inv_status").on('change', function(){
			var search_val = $(this).val();
			table.DataTable()
				.columns( 7 )
				.search( search_val )
				.draw();
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
	KTDatatablesDataSourceHtml.init();
});