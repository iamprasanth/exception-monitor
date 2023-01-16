$(document).ready(function() {

    $(".datepicker").datepicker({
        format: constants.DATE_FORMAT_COMMON,
        endDate: "today"
    });

    // Filter
    $('#from_date, #to_date').on('change', function () {
        var e = $("#from_date").val(),
            t = $("#to_date").val();
            $.ajax({
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                url: baseUrl + "getexceptions",
                method: "GET",
                data: { from_date: e, to_date: t},
                success: function (e) {
                    exceptionTable.clear().draw();
                    exceptionTable.rows.add(e);
                    exceptionTable.columns.adjust().draw();
                },
            });
    });

    var exceptionTable = $("#smt-exception-table").DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "deferRender": true,
            "ordering": false,
            "searching": false,
            "bPaginate": true,
            "bLengthChange": false,
            "bInfo": false,
            "pageLength": 10,
            responsive: true,
            "ajax": {
                "url": baseUrl + "getexceptions",
                "dataSrc": ""
            },
            'fnCreatedRow': function (nRow, aData, iDataIndex) {
                $(nRow).attr('id', 'network-' + aData.id);
            },
            "columns": [{
                "width": "5%",
                "render": function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                "width": "20%",
                "render": function (data, type, content, meta) {
                    return content.date;
                }
            },
            {
                "width": "20%",
                "render": function (data, type, content, meta) {
                    return content.timestamp;
                }
            },
            {
                "width": "20%",
                "render": function (data, type, content, meta) {
                    return content.env;
                }
            },
            {
                "width": "20%",
                "render": function (data, type, content, meta) {
                    return content.type;
                }
            },
            {
                "width": "20%",
                "render": function (data, type, content, meta) {
                    var str = content.message;
                    if (str.length > 45) {
                        var strname = str.substr(0, 45);
                        return strname + '...';
                    } else {
                        return str;
                    }
                }
            },
            {
                sortable: false,
                "width": "15%",
                "render": function (data, type, content, meta) {
                    return '<a class="btn btn-sm btn-primary btn-edit" onclick="viewException(' + content.id + ')">\n\
                     <i class="fa fa-eye text-white" title="View"></i></a>';
                }
            }
            ]
        });



});

//Function to view exception
function viewException(id)
{
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: baseUrl + 'viewexceptions/' + id,
        type: 'GET',
        success: function (data) {
            $('#view_details').val(data.detail);
            $('#viewException').modal('show');
        }
    });
}
