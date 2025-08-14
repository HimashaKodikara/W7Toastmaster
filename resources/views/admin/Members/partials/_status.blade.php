<form method="get" action="{{ route('member.change-status', $member->id) }}" class="d-inline" onsubmit="return confirmStatusChange(this)">
  @csrf
  <button type="submit" class="btn btn-link">
      <i class="{{ $member->status == 'Y' ? 'fas fa-check' : 'fas fa-backspace' }}"></i>
  </button>
</form>
