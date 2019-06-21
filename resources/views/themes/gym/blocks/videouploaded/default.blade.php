@if ($videouploaded != '')
    <source src="{{ $videouploaded . '.webm' }}" type="video/webm">
    <source src="{{ $videouploaded . '.mp4' }}" type="video/mp4">
    <source src="{{ $videouploaded . '.ogv' }}" type="video/ogg">
@endif
