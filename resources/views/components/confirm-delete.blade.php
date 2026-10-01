@props([
    'action',
    'message' => 'Are you sure you want to delete this?',
])

<form
    method="POST"
    action="{{ $action }}"
    data-confirm-delete="{{ $message }}"
    {{ $attributes }}
>
    @csrf
    @method('DELETE')
    {{ $slot }}
</form>
