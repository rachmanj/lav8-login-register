<table>
    <thead>
        <tr>
            <th>#</th>
            <th>InvoiceNo</th>
            <th>InvoiceIRR</th>
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
                <td>{{ $item->invoice_irr }}</td>
                <td>{{ $item->vendor }}</td>
                <td>{{ $item->receive_date !== null ? date('d-M-Y', strtotime($item->receive_date)) : null }}</td>
                <td>{{ $item->amount }}</td>
                <td>{{ $item->spi_no }}</td>
                <td>{{ $item->spi_date !== null ? date('d-M-Y', strtotime($item->spi_date)) : null }}</td>
            </tr>
        @endforeach
    </tbody>
</table>