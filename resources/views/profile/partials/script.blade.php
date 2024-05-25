@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                {{-- <li style="color:red;">{{ $error }}</li> --}}
            @endforeach
        </ul>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                html: `{!! implode('<br>', $errors->all()) !!}`
            });
        });
    </script>
@endif

@if(session("error"))
<script>
  Swal.fire({
  icon: "error",
  title: "Oops...",
  text: "{{session("error")}}",
 
});
</script>
@endif

@if(session("success"))
<script>
    Swal.fire({
    icon: "success",
    title: "{{session("success")}}",
    // text: "{{session("error")}}",
   
  });
  </script>
@endif