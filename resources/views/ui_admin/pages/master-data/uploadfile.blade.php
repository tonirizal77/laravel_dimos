<!DOCTYPE html>
<html>
<head>
    <title>Membuat Fitur Upload Menggunakan Ajax di Laravel</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Membuat Fitur Upload Menggunakan Ajax di Laravel</h1>
        {{-- <form action="{{ url('upload') }}" enctype="multipart/form-data" method="POST" id="form_upload"> --}}
        <form enctype="multipart/form-data" id="form_upload">
            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
            @csrf

            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

            <div class="print-img" style="display:none">
                <img src="" style="height:200px;width:200px;border-radius: 12px">
            </div>

            <div class="form-group">
                <label>Judul:</label>
                <input type="text" name="judul" class="form-control" placeholder="Masukkan Judul">
            </div>

            <div class="form-group">
                <label>Gambar:</label>
                <input type="file" name="gambar" class="form-control">
            </div>

            <div class="form-group">
                <button class="btn btn-success upload-image" type="submit">Kirim</button>
            </div>
        </form>
    </div>

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script> --}}
    {{-- jquery Foam --}}
    <script src="{{ asset('ui_admin/plugins/jQuery/jquery.min.js') }}"></script>
    <script src="{{ asset('ui_admin/plugins/jQuery/jquery.form.js') }}"></script>

    <script type="text/javascript">
        $("button.upload-image").on("click", function(e){
            $("form#form_upload").ajaxForm(options);
        });

        var options = {
            complete: function(response) {
                console.log(response);
                if($.isEmptyObject(response.responseJSON.error)){
                    $("input[name='judul']").val('');
                    $(".print-img").css('display','block');
                    $(".print-img").find('img').attr('src','/gambar/'+response.responseJSON.gambar);

                    alert('Upload gambar berhasil.');
                }else{
                    printErrorMsg(response.responseJSON.error);
                }
            },
            // target: "#output1", // target element(s) to be updated with server response
            // beforeSubmit: function(bs){
            //     alert(bs)
            // }, // pre-submit callback
            // success: function(ss){
            //     alert(ss)
            // }, // post-submit callback

            // other available options:
            url:  'uploaded',        // override for form's 'action' attribute
            type: 'post',           // 'get' or 'post', override for form's 'method' attribute
            // dataType:  'json',   // 'xml', 'script', or 'json' (expected server response type)
            clearForm: true,     // clear all form fields after successful submit
            resetForm: true,     // reset the form after successful submit


        };

        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
    </script>

</body>
</html>
