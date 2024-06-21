<!-- resources/views/lookup-results.blade.php -->
<h2>Breakage Data for Student ID: {{ request()->input('student_id') }}</h2>
<table>
    <thead>
        <tr>
            <th>Type</th>
            <th>Equipment</th>
            <th>Cost</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($breakageData['data'] as $breakage)
            <tr>
                <td>{{ $breakage['fieldData']['type'] }}</td>
                <td>{{ $breakage['fieldData']['equipment'] }}</td>
                <td>{{ $breakage['fieldData']['cost'] }}</td>
                <td>{{ $breakage['fieldData']['notes'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
