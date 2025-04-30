@if (session('success'))

<div class="alert alert-success" role="alert">
{{ session('success') }}
</div>
@endif

@if (session('error'))

<div class="alert alert-danger" role="alert">
       {{ 'error' }}
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
