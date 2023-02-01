<form action="{{ route('wait-payment.send', $model->inv_id) }}" method="POST">
    @csrf @method('PUT')
    <button type="submit" class="btn btn-xs btn-success">send</button>
</form>