<h3>Document Pending</h3>
<h5>as of {{ date('d-M-Y', strtotime($date)) }}</h5>
<br />
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>document_no</th>
            <th>doc_type</th>
            <th>inv_no</th>
            <th>inv_date</th>
            <th>po_no</th>
            <th>project</th>
            <th>vendor</th>
            <th>days</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($documents as $document)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $document->document_no }}</td>
                <td>{{ $document->doctype }}</td>
                <td>{{ $document->inv_no }}</td>
                <td>{{ $document->inv_date ? date('d-M-Y', strtotime($document->inv_date)) : 'n/a' }}</td>
                <td>{{ $document->po_no }}</td>
                <td>{{ $document->project }}</td>
                <td>{{ $document->vendor }}</td>
                <td>{{ $document->days }}</td>
            </tr>
        @endforeach
    </tbody>
</table>