@extends('master') @section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('fiture-style/datatables/responsive.dataTables.min.css') }}" rel="stylesheet">
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('fiture-style/select2/select2.min.css') }}">
<style type="text/css">
    table.dataTable.table-sm>thead>tr>th {padding-right: 0 !important;}
</style>
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-md-12">
                <p>
                    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh" onclick="refresh()">
                        <i class="fa fa-refresh"></i>
                    </button>
                    <a href="{{ route('mail.index') }}" class="btn btn-primary">
                        <i class="fa fa-backward"></i>&nbsp; Back to List
                    </a>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Member Table
                        <button type="button" class="btn btn-success pull-right" data-toggle="tooltip" data-placement="top" title="" data-original-title="New blast" onclick="newBlast()">
                            <i class="fa fa-envelope"></i> New blast
                        </button>
                        <button type="button" class="btn btn-danger pull-right" data-toggle="tooltip" data-placement="top" title="" data-original-title="Filter" onclick="$('.form-filter').slideToggle()">
                            <i class="fa fa-filter"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table _fordragclass="table-responsive-sm" class="table table-bordered table-striped table-sm display responsive datatable"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-nowrap">Name :</th>
                                        <th class="text-nowrap">Email :</th>
                                        <th class="text-nowrap">Phone :</th>
                                        <th class="text-nowrap">Type :</th>
                                        <th class="text-nowrap">Level :</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('panel.email-management.mail.new-blast.modal')
    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.responsive.min.js') }}"></script>
<script src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
<script src="{{ asset('fiture-style/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/vendor//tinymce/tinymce.min.js') }}"></script>
<script>
    const levels = {!! json_encode($levels) !!};
    //DATATABLES
    var reqTable = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: {
            url: '{{route("mail.create")}}',
            data: function(draw){
                draw.type = $('.form-filter #type').val();
                draw.level = $('.form-filter #level').val();
            }
        },
        columns: [
            {
                data: 'member_id', 
                name: 'member_id', 
                orderable: false, 
                searchable: false, 
                "width": "4%", 
                checkboxes: true,
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'phone',
                name: 'phone'
            },
            {
                data: 'type.[|].type',
                name: 'type'
            },
            {
                data: 'level.[].name',
                name: 'level'
            },
        ],
        columnDefs: [
            {
                responsivePriority: 1,
                targets: 0,
            },
            {
                responsivePriority: 2,
                targets: 3,
                className: "text-center"
            }
        ],
        "order": [
            [1, 'asc'],
        ],
        select: true,
        initComplete:function(){
            $("div#DataTables_Table_0_wrapper").prepend(
                 '<form class="form-horizontal form-filter" style="display: none;">'+
                     '<label style="margin-left:10px;">Type '+
                         '<select id="type" name="type" aria-controls="table" class="form-control form-control-sm select2" style="width: 150px; padding:0;" onchange="reqTable.draw()">'+
                            '<option value=""></option>'+
                            '<option value="B2B">B2B</option>'+
                            '<option value="B2C">B2C</option>'+
                        '</select>'+
                    '</label>'+
                     '<label style="margin-left:10px;">Level '+
                         '<select id="level" name="level" aria-controls="table" class="form-control form-control-sm select2" style="width: 150px; padding:0;" onchange="reqTable.draw()">'+
                          eachLevel(levels)
                        +'</select>'+
                    '</label>'+
                '</form>'
            );
            $(".select2").select2({
                allowClear: true,
                placeholder: "--please choose--",
                theme: "bootstrap",
            });
        }
    });
    $('.datatable').attr('style', 'border-collapse: collapse !important');
    $('#blastModal').on('hidden.bs.modal', function(){
        $(this).find('form')[0].reset();
    })
    function eachLevel(val){
        var e = '';
        e += '<option value=""></option>';
        for (var i = 0; i < val.length; i++) {
            e += '<option value="'+ val[i].name +'"><center>'+ val[i].name +'</center></option>';
        }
        return e;
    }
    function newBlast(){
        const rows_selected = reqTable.column(0).checkboxes.selected();
        $('.form-hide-list').empty()
        if (rows_selected.length === 0 ) {
            toastr.warning('Please select at least one.', 'Warning');
        } else {
            // Iterate over all selected checkboxes
            $.each(rows_selected, function (index, rowId) {
                console.log(rowId);
                // Create a hidden element
                $('.form-hide-list').append(
                    $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'member_id[]')
                        .val(rowId)
                );
            });
            $('.form-hide-list').append(
                $('<input>')
                    .attr('type', 'text')
                    .attr('class', 'form-control')
                    .attr('readonly', true)
                    .val('Send mail to ' + rows_selected.length + ' Member')
            );
            $('#blastModal').modal('show')
        }
    }

 var editor_config = {
      path_absolute : "{{ URL::to('/') }}/",
      selector : "textarea",
      plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
      relative_urls: false,
      file_browser_callback : function(field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.grtElementByTagName('body')[0].clientHeight;
        var cmsURL = editor_config.path_absolute+'laravel-filemanager?field_name'+field_name;
        if (type = 'image') {
          cmsURL = cmsURL+'&type=Images';
        } else {
          cmsUrl = cmsURL+'&type=Files';
        }

        tinyMCE.activeEditor.windowManager.open({
          file : cmsURL,
          title : 'Filemanager',
          width : x * 0.8,
          height : y * 0.8,
          resizeble : 'yes',
          close_previous : 'no'
        });
      }
    };

    tinymce.init(editor_config);
</script>
@endsection