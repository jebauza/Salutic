{{-- ALERTS --}}
@if (session('message-success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>OK: </strong> {{ session('message-success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
@elseif(session('message-warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Advertencia: </strong> {{ session('message-warning') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
@elseif(session('message-error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error: </strong> {{ session('message-error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
