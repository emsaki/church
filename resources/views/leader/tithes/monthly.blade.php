<table class="table table-bordered">
    <thead>
        <tr>
            <th>Month</th>
            <th>Total Tithes (TZS)</th>
        </tr>
    </thead>
    <tbody>
    @foreach($monthlyTotals as $row)
        <tr>
            <td>{{ $row->month }}</td>
            <td>{{ number_format($row->total) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
 