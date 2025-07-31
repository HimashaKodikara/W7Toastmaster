<form method="get" action="{{ route('news.change-status', $news->id) }}" class="d-inline" onsubmit="return confirmStatusChange(this)">
  @csrf
  <button type="submit" class="btn btn-link">
      <i class="{{ $news->status == 'Y' ? 'fal fa-check' : 'fal fa-backspace' }}"></i>
  </button>
</form>
