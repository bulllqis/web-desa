@extends('layouts.master')

@section('content')



<br>
    
<div class="row">
<div class="col-lg-12">
    <div class="card-box">
        
        <button type="button" class="btn btn-outline-dark waves-effect waves-light width-md" id="createNewData" style="color:#009DFF">Tambah Data</button>
        <br><br>
        @if ($message = Session::get('sukses'))
        <div class="alert alert-primary" id="pesan-sukses">
        <strong>{{ $message }}</strong>
        </div>
        @endif        
        </div>
        <div class="table-responsive">
            <table class="table mb-0 data-table" >
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    
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

            <form id="productForm" name="productForm" action="{{ route('user.store') }}" enctype="multipart/form-data" method="POST">
                <div id="pesan-error" class="alert alert-danger"></div>
                   @csrf
                   <input type="hidden" name="data_id" id="data_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nama</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control required" id="Nama" value=""  minlength="2"  title="Nama Harus Diisi" required="">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label">Role</label>
                        <div class="col-sm-12">
                            <select name="role" id="role" class="form-control">
                                <option value="admin">Administator</option>
                                <option value="pegawai">Pegawai</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Simpan
                     </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    $('#pesan-error,#pesan-sukses').hide()
  $(function () {

     

      $.ajaxSetup({

          headers: {

              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

          }

    });

    

    var table = $('.data-table').DataTable({

        processing: true,

        serverSide: true,

        ajax: "{{ route('user.index') }}",

        columns: [

            {data: 'DT_RowIndex', name: 'DT_RowIndex'},

            {data: 'name', name: 'name'},
            {data: 'username', name: 'username'},
            {data: 'role', name: 'role'},
            {data: 'action', name: 'action', orderable: false, searchable: false},

        ]

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

      $.get("{{ route('user.index') }}" +'/' + data_id +'/edit', function (data) {

          $('#modelHeading').html("Ubah data");

          $('#saveBtn').val("edit-user");

          $('#ajaxModel').modal('show');

          $('#data_id').val(data.id);

          $('#name').val(data.name);

          $('#email').val(data.email);

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

            url: "{{ route('user.store') }}"+'/'+data_id,

            success: function (data) {
                $('#pesan-sukses').html(data.pesan).fadeIn().delay(1000).fadeOut()
                table.draw();

            },

            error: function (data) {

                console.log('Error:', data);

            }

        });

    });

     

  });

</script>

@endsection