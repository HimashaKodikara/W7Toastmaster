<form method="POST" action="{{ route('news.delete-news', $news->id) }}" class="d-inline"
    onsubmit="return submitDeleteForm(this)">
  @csrf
  @method('delete')
   <button type="submit"
    class="btn btn-link">
  <i class="fas fa-trash-alt"></i>
  </button>
</form>

