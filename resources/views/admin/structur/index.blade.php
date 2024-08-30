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
            <table class="table mb-0 data-table" id="example" >
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Masa Jabatan</th>
                        <th>Jabatan</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                 @foreach($dat as $da)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $da->nama}}</td>
                        <td>{{ $da->masa_jabatan}}</td>
                        <td>{{ $da->jabatan }}</td>
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
                <form id="productForm" name="productForm" action="{{ route('structur.store') }}" enctype="multipart/form-data" method="POST">
                    <div id="pesan-error" class="alert alert-danger"></div>
                    @csrf
                    <input type="hidden" name="data_id" id="data_id">
                    <div class="form-group">
                        <label for="judul" class="col-sm-2 control-label">Nama </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control required" id="nama" name="nama" placeholder="Masukan Nama Lengkap" minlength="5" title="Field Harus Diisi" required="">
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="col-sm-12">
                            <label for="">Masa Jabatan</label>
                        </div>
                        <div class="col-sm-5">
                            <input type="date" class="form-control" placeholder="mm/dd/yyyy" data-provide="datepicker" name="mulai" id="mulai">
                        </div>
                        <div class="col-sm-2">
                            <p>Sampai</p>
                        </div>
                        <div class="col-sm-5">
                            <input type="date" class="form-control" placeholder="mm/dd/yyyy" data-provide="datepicker" name="selesai" id="selesai">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Jabatan</label>
                        <div class="col-sm-12">
                            <select name="role" id="jabatan" class="form-control">
                                <option value="KEPALA DESA">KEPALA DESA</option>
                                <option value="BPD">BPD</option>
                                <option value="SEKRETARIS DESA">SEKRETARIS DESA</option>
                                <option value="KAUR PERENCANAAN">KAUR PERENCANAAN</option>
                                <option value="KAUR TATA USAHA & UMUM">KAUR TATA USAHA & UMUM</option>
                                <option value="KAUR KEUANGAN">KAUR KEUANGAN</option>
                                <option value="KASI PEMERINTAHAN">KASI PEMERINTAHAN</option>
                                <option value="KASI PELAYANAN">KASI PELAYANAN</option>
                                <option value="KASI KESEJAHTERAAN">KASI KESEJAHTERAAN</option>
                                <option value="KEPALA DUSUN TAMPANING">KEPALA DUSUN TAMPANING</option>
                                <option value="KEPALA DUSUN KAWARANG">KEPALA DUSUN KAWARANG</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="foto" class="col-sm-2 control-label">Foto</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control" id="foto" name="foto">
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
                        <button type="submit" class="btn btn-primary upload-image" id="saveBtn" value="create">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<img src="" alt="">
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    });

    $('#pesan-error,#pesan-sukses').hide();
    
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
            $.get("{{ route('structur.index') }}" +'/' + data_id +'/edit', function (data) {
                $('#modelHeading').html("Ubah data");
                $('#saveBtn').val("edit-structur");
                $('#ajaxModel').modal('show');
                $('#data_id').val(data.id);
                $('#photos').html("<img src={{ URL::to('/') }}/foto/"+data.foto+" width='100'>");
                $('#nama').val(data.nama);
                $('#jabatan').val(data.jabatan);
            })
        });

        $('body').on('click', '.deleteData', function () {

var data_id = $(this).data("id");


$.ajax({
    type: "DELETE",
    url: "{{ route('structur.store') }}"+'/'+data_id,
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
