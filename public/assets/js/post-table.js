"use strict";
var KTDatatablesDataSourceHtml = function() {

	var initTable1 = function() {
		var table = $('#kt_datatable');

		// begin first table
		table.DataTable({
			responsive: true,
            "order": [[ 6, "desc" ]]
		});

        $(".business_name").on('change', function(){
            var search_val = $(this).val();
			table.DataTable()
				.columns( 1 )
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