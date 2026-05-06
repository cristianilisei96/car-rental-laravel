<div class="space-y-3">
    <x-flash-message type="success" :message="session('success')" />
    <x-flash-message type="warning" :message="session('warning')" />
    <x-flash-message type="info" :message="session('info')" />
    <x-flash-message type="danger" :message="session('error')" />

    @if ($errors->any())
        <x-flash-message type="danger" :message="$errors->first()" :duration="7000" />
    @endif
</div>
