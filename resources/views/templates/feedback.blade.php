@if (session('success'))

<style>
    pace {
  font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif; 
}
</style>

<div class="pace" role="alert">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'success',
        text: "{{ session('success') }}"

    });
</script>
</div>
@endif

@if (session('error'))

<div class="pace" role="alert">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'error',
        title: 'error',
        text: "{{ session('error') }}"

    });
</script>
</div>
@endif

@if (count($errors)> 0)
     <div class="alert alert-danger">
        <button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p>Perhatian.</p>
        <ul>
            @foreach ($errors->all() as $error)
            <li>
                {{ $error }}
            </li>
            @endforeach
        </ul>
     </div>
@endif
