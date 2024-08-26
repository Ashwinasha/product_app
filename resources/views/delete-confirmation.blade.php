@if(session('delete_confirmation'))
<div class="custom-message-box">
    <span class="custom-message-text">{{ session('delete_confirmation') }}</span>
    <button type="button" class="custom-message-close" aria-label="Close">&times;</button>
</div>
@endif
