<form method="get" action="{{ route('gallery.change-status', $gallery->id) }}" class="d-inline" onsubmit="return confirmStatusChange(this)">
  @csrf
  <button type="submit" class="btn btn-link">
      <i class="{{ $gallery->status == 'Y' ? 'fas fa-check' : 'fas fa-backspace' }}"></i>
  </button>
</form>
