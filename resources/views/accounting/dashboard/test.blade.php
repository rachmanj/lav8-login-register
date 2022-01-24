<table>
  <thead>
    <tr>
      <th>Month</th>
      <th>Received</th>
      <th>Process</th>
    </tr>
  </thead>
  <tbody>
    {{-- @foreach ($invoices as $invoice) --}}
    @foreach ($process as $item)
        <tr>
          <td>{{ $item->month }}</td>
          {{-- <td>{{ $invoice->receive_count }}</td> --}}
          <td>{{ $invoices->where('month', $item->month)->count() }}</td>
          <td>{{ $item->processed_count }}</td>
        </tr>
    @endforeach
  </tbody>
</table>