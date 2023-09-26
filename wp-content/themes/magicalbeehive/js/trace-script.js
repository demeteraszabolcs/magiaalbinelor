(function ($, root, undefined) {
	
	$(function () {
		
	    var distable = $('#tracetable').DataTable({
				"dom": 'Brtip',
				"ordering": false,
				"processing": true,
				"autoWidth": false,
				"serverSide": false,
				"responsive": true,
				"columnDefs": [
					{
						"targets": 2,
						"createdCell": function (td, cellData, rowData, row, col) {
							$(td).html('<a href="' + cellData + '">Link</a>');
						}
					},
				],
				"ajax": {
					"type": "GET",
					"url": ajax_url_trace,
				},
				"fnDrawCallback": function(oSettings) {
					if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
							$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
							$(oSettings.nTableWrapper).find('.dataTables_info').hide();
					}
				}
			});

	});
	
})(jQuery, this);