@if (session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('status') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="position-fixed top-50 start-0 translate-middle-y" style="z-index: 100000">
    <div id="liveToast" class="toast hide" role="alert" data-bs-delay="5000" data-bs-autohide="true" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <img src="/favicon.svg" class="rounded me-2" style="height: 24px">
            <strong class="me-auto">Contacto actualizado</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">

        </div>
    </div>
</div>
