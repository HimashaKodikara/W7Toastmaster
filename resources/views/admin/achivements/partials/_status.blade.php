<form method="get" action="{{ route('achivements.change-status', $achievement->id) }}" class="d-inline" onsubmit="return confirmStatusChange(this)">
  @csrf
  <button type="submit" class="btn btn-link">
      <i class="{{ $achievement->status == 'Y' ? 'fas fa-check' : 'fas fa-backspace' }}"></i>
  </button>
</form>
