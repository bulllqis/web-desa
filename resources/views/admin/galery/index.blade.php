@extends('layouts.master')

@section('content')



<br>
    
<div class="row">
<div class="col-lg-12">
    <div class="card-box">
        
        <button type="button" class="btn btn-outline-dark waves-effect waves-light width-md" id="createNewData" style="color:#009DFF">Tambah Data</button>
        <br><br>
        <div class="alert alert-primary" id="pesan-sukses" role="alert" style="display: none;"></div>
        @if ($message = Session::get('sukses'))
        <div class="alert alert-primary" id="pesan-sukses">
        <strong>{{ $message }}</strong>
        </div>
        @endif
        <div class="table-responsive">
            <table class="table mb-0 data-table"  id="example">
                <thead>
                    <tr>
                       <th>No</th>
                        <th>Judul</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                      @foreach($dat as $da)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $da->judul}}</td>
                            
                            <td><img src="{{ asset('foto/'.$da->foto) }}" width="50" height="50"></td>
                            <td>
                                <a href="javascript:void(0)"  data-id="{{ $da->id}}" data-original-title="Edit" class="btn edit  editData"><i class="icon-pencil"></i></a>
                                <a href="javascript:void(0)"  data-id="{{ $da->id}}" data-original-title="Delete" class="btn deleteData"><i class="icon-trash"></i></a>
                            </td>
                        </tr>
                        
                      @endforeach
                </tbody>
            </table>
        </div>

    </div> 
</div>
</div>
        
<!-- modal -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
               
            </div>

            <div class="modal-body">

                <form id="productForm" name="productForm" action="{{ route('galery.store') }}" enctype="multipart/form-data" method="POST">
                   <div id="pesan-error" class="alert alert-danger"></div>
                   @csrf
                   <input type="hidden" name="data_id" id="data_id">
                   
                    <div class="form-group">
                        <label for="judul" class="col-sm-2 control-label">Judul</label>
                        <div class="col-sm-12">
                            <textarea id="judul" name="judul" required="" placeholder="Judul" class="form-control"></textarea>
                            
                    </div>
                    <div class="form-group">
                        <label for="judul" class="col-sm-2 control-label">Keterangan </label>
                        <div class="col-sm-12">
                            <textarea id="keterangan" name="keterangan" required="" placeholder="Masukan Keterangan" class="form-control"></textarea>

                    </div>
                    </div>
                     <div class="form-group">
                        <label for="foto" class="col-sm-2 control-label">Foto</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control " id="foto" name="foto">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="foto" class="col-sm-2 control-label"></label>
                        <div class="col-sm-12">
                        <div id="photos"></div>
                        </div>
                        
                    </div>
                    <br>

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary upload-image" id="saveBtn" value="create">Simpan
                     </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<img src="" alt="" > 
@endsection

@section('script')

<script type="text/javascript">
    $('#pesan-error,#pesan-sukses').hide()
     $(document).ready(function() {
        $('#example').DataTable();
    });
  $(function () {

     

      $.ajaxSetup({

          headers: {

              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

          }

    });

    

   
     

    $('#createNewData').click(function () {

        $('#saveBtn').val("create-data");

        $('#data_id').val('');

        $('#productForm').trigger("reset");

        $('#modelHeading').html("Tambah data");

        $('#ajaxModel').modal('show');

    });

    

    $('body').on('click', '.editData', function () {

      var data_id = $(this).data('id');

      $.get("{{ route('galery.index') }}" +'/' + data_id +'/edit', function (data) {

          $('#modelHeading').html("Ubah data");

          $('#saveBtn').val("edit-galery");

          $('#ajaxModel').modal('show');
          $('#photos').html("<img src={{ URL::to('/') }}/foto/"+data.foto+"  width='100'>")

          $('#keterangan').val(data.keterangan);
          $('#judul').val(data.judul);
          $('#data_id').val(data.id);

          $('#foto').val(data.foto);


      })

   });

    

        if ($("#productForm").length > 0) {
            $("#productForm").validate({

                submitHandler: function(form) {
                    $(this).parents("form").ajaxForm(options);

                }
            })
        }

        var options = { 

            

        complete: function(response) 

        {

            if($.isEmptyObject(response.responseJSON.error)){
                $('#ajaxModel').modal('hide');
                $('#productForm').trigger("reset");
                $('#pesan-sukses').html(data.pesan).fadeIn().delay(1000).fadeOut();

                table.draw();
            }

        }

    };


    $('body').on('click', '.deleteData', function () {

    var data_id = $(this).data("id");


    $.ajax({
        type: "DELETE",
        url: "{{ route('galery.store') }}"+'/'+data_id,
        success: function (data) {
               $(this).closest('tr').remove();
               $('table tbody tr').each(function(index) {
                    $(this).find('td:first').html(index + 1);
                });               
                $('#pesan-sukses').html(data.pesan).fadeIn().delay(1000).fadeOut();

           }.bind(this),
           error: function (data) {
               console.log('Error:', data);
           }
       
    });


});


     

  });

</script>

@endsection