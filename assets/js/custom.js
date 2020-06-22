var FOLDER_LOCATION = "/assignment/";
var BASE_URL = window.location.protocol + "//" + window.location.hostname + FOLDER_LOCATION;

$(document).on('click', '.add-route-btn', function () {
    $(this).closest('.row').addClass('d-none');
    $('.insert-route-div').removeClass('d-none');
    $('.update-btn').addClass('d-none');
    $('.insert-btn').removeClass('d-none');
    $('#routeId').val('');
    $("form").trigger("reset");
});

$(document).on('click', '.close-btn', function (e) {
    
    e.preventDefault();
    
    $('.insert-route-div').addClass('d-none');
    $('.add-route-btn-div').removeClass('d-none');
});

$(document).ready(function () {

    (function () {
        $.ajax({
            url: BASE_URL + "show",
            async: false,
            dataType: 'json',
            success: function (data) {
                createTable(data);
            }
        });
    })();
    
});


$('form').on('submit', function (e) {

    e.preventDefault();

    input = $('form').serializeArray();
    data = {};
    

    $.each(input, function (i, v) {
        data[v.name] = v.value;
    });
    
    var routeId = $('#routeId').val();
    if(routeId > 0) {
        data.id = routeId;
    }
    
    insertData(data, "insert");

});

function insertData(data, url) {
    $.ajax({
        type: 'POST',
        data: data,
        url: BASE_URL + url,
        dataType: 'json',
        success: function (res) {
            
            if (res.code == '0') {
                alert(res.msg);
            } else {
                alert(res.msg);
                createTable(res.data);
                showAddBtn();
            }
        }
    });
}

function showAddBtn() {
    $("form").trigger("reset");
    $('.insert-route-div').addClass('d-none');
    $('.add-route-btn-div').removeClass('d-none');
}

function createTable(data) {
    var html = '';
    var i;
    if (data.length > 0) {
        for (i = 0; i < data.length; i++) {
            html += '<tr id="' + data[i].id + '">' +
                    '<td scope="row">' + (i + 1) + '</td>' +
                    '<td scope="row">' + data[i].sapid + '</td>' +
                    '<td scope="row">' + data[i].hostname + '</td>' +
                    '<td scope="row">' + data[i].loopback + '</td>' +
                    '<td scope="row">' + data[i].mac_address + '</td>' +
                    '<td scope="row" style="text-align:right;">' +
                    '<a href="javascript:void(0);" class="btn btn-info btn-sm editRecord mb-1" data-id="' + data[i].id + '" data-sapid="' + data[i].sapid + '" data-hostname="' + data[i].hostname + '" data-loopback="' + data[i].loopback + '" data-mac_address="' + data[i].mac_address + '">Edit</a>' + ' ' +
                    '<a href="javascript:void(0);" class="btn btn-danger btn-sm deleteRecord mb-1" data-id="' + data[i].id + '">Delete</a>' +
                    '</td>' +
                    '</tr>';
        }
    } else {
        html += '<tr class="text-center"><td scope="row" colspan="6"> No data available in Route Table </td></tr>';
    }
    $('.route-body').html(html);
}

$('.route-body').on('click', '.deleteRecord', function () {

    var id = $(this).data('id');

    if (id > 0) {
        var r = confirm('Are you sure! You want to Delete Route');
        
        if (r == true) {
            $.ajax({
                type: 'POST',
                url: BASE_URL + "delete",
                data: {"id" : id},
                dataType: 'json',
                success: function (data) {                    
                    alert('Deleted Successfully');                    
                    createTable(data);
                }
            });            
        }
        
    } else {
        alert('Some Error in Loading. Please try again.');
        location.reload();
    }
});

$('.route-body').on('click', '.editRecord', function () {
    
    $('.add-route-btn').trigger('click');    
    $('.insert-btn').addClass('d-none');
    $('.update-btn').removeClass('d-none');
    
    $('#routeId').val($(this).data('id'));
    $('input[name=sapid]').val($(this).data('sapid'));
    $('input[name=hostname]').val($(this).data('hostname'));
    $('input[name=loopback]').val($(this).data('loopback'));
    $('input[name=mac_address]').val($(this).data('mac_address'));
    
    $('input[name=sapid]').focus();

});
