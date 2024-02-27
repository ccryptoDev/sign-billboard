"use strict";
var KTDatatablesDataSourceHtml = function() {

	var initTable1 = function() {
		var table = $('#kt_datatable');

		// begin first table
		table.DataTable({
			responsive: true,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			iDisplayLength : 25,
			order : [0, 'asc'],
			columnDefs: [
				{
					target: 0,
					visible: false,
				},
			],
		});
	};
    var initTable2 = function() {
		var table = $('#kt_datatable_2');

		// begin first table
		table.DataTable({
			responsive: true,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			iDisplayLength : 25,
			order : [0, 'asc'],
			columnDefs: [
				{
					target: 0,
					visible: false,
				},
			],
		});
	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
            initTable2();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesDataSourceHtml.init();
});