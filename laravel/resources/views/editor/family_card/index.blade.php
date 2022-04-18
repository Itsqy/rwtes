@extends('layouts.editor.template')
@section('title', 'Keluarga')   
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Keluarga</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Keluarga & Aktivitas</a></li>
                  <li class="active">Keluarga</li>
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div>
 
      <!-- /row -->
      <div class="row">
          <div class="col-sm-12"> 
              <div class="table-responsive"> 
                <div class="col-sm-12">
                    <div class="white-box"> 
                         <div class="button-box">
                            <a href="{{ URL::route('editor.family-card.create') }}" type="button" class="fcbtn btn btn-primary btn-outline btn-1b waves-effect">Tambah Baru</a>
                            <a href="#" onClick="history.back()" type="button" class="fcbtn btn btn-info btn-outline btn-1b waves-effect">Kembali</a>
                            <a href="#" onClick="reload_table()" type="button" class="fcbtn btn btn-success btn-outline btn-1b waves-effect">Refresh</a> 
                            <a href="#" onClick="showslip('family-card');" type="button" class="fcbtn btn btn-warning btn-outline btn-1b waves-effect pull-right">?</a> 
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Aksi</th> 
                                        <th>IPL ID</th> 
                                        <th>No KK</th>
                                        <th>NIP</th> 
                                        <th>Nama</th> 
                                        <th>No HP</th> 
                                        <th>Alamat</th> 
                                        <th>RT/RW</th>
                                        <th>Blok</th> 
                                        <th>Tarif IPL</th> 
                                        <th>Kode Unik</th> 
                                        <th>Tarif IPL + Kode Unik</th> 
                                        <th>Tagihan 2019</th>
                                        <th>Desa/Kelurahan</th>
                                        <th>Kecamatan</th>
                                        <th>Kabupaten/Kota</th>
                                        <th>Kode Pos</th> 
                                        <th>Provinsi</th> 
                                        <th>Tipe Rumah</th> 
                                        <th>Foto 1</th>
                                        <th>Katerangan Foto 1</th>
                                        <th>Foto 2</th>
                                        <th>Katerangan Foto 2</th>
                                        <th>Foto 3</th>
                                        <th>Katerangan Foto 3</th>
                                        <th>Foto 4</th>
                                        <th>Katerangan Foto 4</th>
                                        <th>Foto 5</th>
                                        <th>Katerangan Foto 5</th>
                                        <th>Foto 6</th>
                                        <th>Katerangan Foto 6</th>
                                        <th>Status</th>
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
      </div>
  </div>
</div> 



{{-- @stop --}}
{{-- @section('scripts') --}}
<script> 
  var table;
  $(document).ready(function() {
      //datatables
      table = $('#dtTable').DataTable({ 
       processing: true,
       serverSide: true,
       fixedColumns:   {
        leftColumns: 4 
       },
       "initComplete": function (settings, json) {  
          $("#dtTable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
       },
       order: [[ 1, 'asc' ]],
       dom: 'Bfrtip',
       buttons: [
            'copy', 'excel', 'print'
       ], 
       ajax: "{{ URL::route('editor.family-card.data') }}",
       columns: [  
       { data: 'action', name: 'action', orderable: false, searchable: false }, 
       { data: 'ipl_id', name: 'ipl_id', "width": "5%" },
       { data: 'no', name: 'no', "width": "5%" },
       { data: 'nip', name: 'nip', "width": "10%" }, 
       { data: 'name', name: 'name', "width": "5%" },
       { data: 'hp', name: 'hp', "width": "5%" },
       { data: 'address', name: 'address', "width": "10%" },
       { data: 'rt_name', name: 'rt_name', "width": "1%" },
       { data: 'block', name: 'block', "width": "5%" },
       { data: 'ipl_tarif', name: 'ipl_tarif', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp. ' ) }, 
       { data: 'unique_code', name: 'unique_code', "width": "5%" },
       { data: 'ipl_tarif_unique_code', name: 'ipl_tarif_unique_code', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp. ' ) }, 
       { data: 'bill_2019', name: 'bill_2019', "width": "5%", render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp. ' ) }, 
       { data: 'village', name: 'village' },
       { data: 'sub_district', name: 'sub_district' },
       { data: 'city', name: 'city' },
       { data: 'pos_code', name: 'pos_code', "width": "5%" },
       { data: 'province', name: 'province', "width": "5%" }, 
       { data: 'house_type_name', name: 'house_type_name', "width": "5%" }, 
       { data: 'image', name: 'image' },
       { data: 'description_image', name: 'description_image' },
       { data: 'image2', name: 'image2' },
       { data: 'description_image2', name: 'description_image2' },
       { data: 'image3', name: 'image3' },
       { data: 'description_image3', name: 'description_image3' },
       { data: 'image4', name: 'image4' },
       { data: 'description_image4', name: 'description_image4' },
       { data: 'image5', name: 'image5' },
       { data: 'description_image5', name: 'description_image5' },
       { data: 'image6', name: 'image6' },
       { data: 'description_image6', name: 'description_image6' },
       { data: 'mstatus', name: 'mstatus' },
       ]
     });
    });

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function delete_id(id, name)
    {
      var name = name.bold();

      $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to delete ' + name + ' data?',
        type: 'red',
        typeAnimated: true,
        buttons: {
          cancel: {
           action: function () { 
           }
         },
         confirm: {
          text: 'DELETE',
          btnClass: 'btn-red',
          action: function () {
           $.ajax({
            url : 'family-card/delete/' + id,
            type: "DELETE",
            data: {
              '_token': $('input[name=_token]').val() 
            },
            success: function(data)
            { 
              var options = { 
                "positionClass": "toast-bottom-right", 
                "timeOut": 1000, 
              };
              toastr.success('Successfully deleted data!', 'Success Alert', options);
              reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              $.alert({
                type: 'red',
                icon: 'fa fa-danger', // glyphicon glyphicon-heart
                title: 'Warning',
                content: 'Error deleteing data!',
              });
            }
          });
         }
       },
     }
   });
  }

  function showslip(id)
  {
   var url = 'manual-book/show/' + id;
     PopupCenter(url,'Popup_Window','700','650');
  }

</script> 

@stop
