"use strict";
// Class definition

var KTDatatableHtmlTableDemo = function() {
    // Private functions

    // demo initializer
    var demo = function() {

		var datatable = $('#kt_datatable').KTDatatable({
			data: {
				saveState: {cookie: false},
			},
			search: {
				input: $('#kt_datatable_search_query'),
				key: 'generalSearch'
			},
			columns: [
				{
					field: 'Action',
					width: 80,
				},
                {
					field: 'Start Date',
					width: 100,
				},
                {
					field: 'End Date',
					width: 100,
				},
                {
					field: 'Last Changed by',
					width: 150,
				},
                {
					field: 'Modified',
					width: 100,
				},
                {
					field: 'Status',
					title: 'Status',
					autoHide: false,
                    width : 150,
					// callback function support for column rendering
					template: function(row) {
						var status = {
                            0: {
                                'title': 'Published to CM',
                                'class': ' label-success'
                            },
							1: {
                                'title': 'Campaign',
                                'class': ' label-danger'
                            },
							2: {
                                'title': 'Deleted',
                                'class': ' label-primary'
                            },
                            3 : {
                                'title': 'Deleted',
                                'class': ' label-info'
                            },
                            4 : {
                                'title': 'Created an Ad',
                                'class': ' label-warning'
                            },
						};
						return '<span class="label font-weight-bold label-lg' + status[row.Status].class + ' label-inline">' + status[row.Status].title + '</span>';
					},
				}
			],
		});



        $('#kt_datatable_search_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Status');
        });

        $('#kt_datatable_search_type').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Type');
        });

        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();

    };

    return {
        // Public functions
        init: function() {
            // init dmeo
            demo();
        },
    };
}();

jQuery(document).ready(function() {
	KTDatatableHtmlTableDemo.init();
});