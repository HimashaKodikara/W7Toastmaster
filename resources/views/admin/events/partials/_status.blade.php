<form method="get" action="{{ route('event.change-status', $event->id) }}" class="d-inline" onsubmit="return confirmStatusChange(this)">
  @csrf
  <button type="submit" class="btn btn-link">
      <i class="{{ $event->status == 'Y' ? 'fas fa-check' : 'fas fa-backspace' }}"></i>
  </button>
</form>
