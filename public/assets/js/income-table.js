"use strict";
var KTDatatablesDataSourceHtml = function() {

	var initTable1 = function() {
		var table = $('#kt_datatable');

		// begin first table
		table.DataTable({
			responsive: true,
			footerCallback: function(row, data, start, end, display) {
				for(var i = 2; i < 6; i++){
					var column = i;
					var api = this.api(), data;

					// Remove the formatting to get integer data for summation
					var intVal = function(i) {
						return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
					};

					// Total over all pages
					var total = api.column(column).data().reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

					// Total over this page
					var pageTotal = api.column(column, {page: 'current'}).data().reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

					// Update footer
					$(api.column(column).footer()).html(
						'$' + KTUtil.numberString(pageTotal.toFixed(2)),
					);
				}
				
			},
		});

        $(".business-name").on('change', function(){
            var search_val = $(this).val();
			table.DataTable()
				.columns( 0 )
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