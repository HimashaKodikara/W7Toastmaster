<form method="POST" action="{{ route('event.delete-event', $event->id) }}" class="d-inline"
    onsubmit="return submitDeleteForm(this)">
  @csrf
  @method('delete')
   <button type="submit"
    class="btn btn-link">
  <i class="fas fa-trash-alt"></i>
  </button>
</form>

