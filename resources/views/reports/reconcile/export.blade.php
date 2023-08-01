<table>
    <thead>
        <tr>
            <th>#</th>
            <th>InvoiceNo</th>
            <th>VName</th>
            <th>ReceiveD</th>
            <th>Amount</th>
            <th>SPINo</th>
            <th>SPIDate</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reconciles as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->invoice_no }}</td>
                <td>{{ $item->invoice->vendor->vendor_name }}</td>
                <td>{{ date('d-M-Y', strtotime($item->invoice->receive_date)) }}</td>
                <td>{{ $item->invoice->inv_nominal }}</td>
                <td>{{ $item->invoice->spis_id !== null ? $item->invoice->spi->nomor : '-' }}</td>
                <td>{{ $item->invoice->spis_id !== null ? date('d-M-Y', strtotime($item->invoice->spi->date)) : '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>